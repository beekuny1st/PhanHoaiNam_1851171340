<?php

namespace App\Common;

use App\Common\Exceptions\ObjectNotFoundException;
use App\Common\Exceptions\RelationNotFoundException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class EloquentRepository implements RepositoryInterface
{
    protected $_model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        try {
            $this->_model = app()->make(
                $this->getModel()
            );
        } catch (BindingResolutionException $e) {
            throw $e;
        }
    }

    public function getAll()
    {
        return $this->_model->all();
    }

    public function get($whereClauses, $orderBy = 'id:asc', $with = [], $withCount = [])
    {
        $query = $this->_model->newQuery();
        $this->createQuery($query, $whereClauses);
        $this->addOrderBy($query, $orderBy);
        if (!empty($with)) {
            $query = $query->with($with);
        }

        if (!empty($withCount)) {
            $query = $query->withCount($withCount);
        }
        return $query->get();
    }

    public function paginate($limit, $whereClauses, $orderBy, $with = [], $withCount = [])
    {
        $query = $this->_model->newQuery();
        $this->createQuery($query, $whereClauses);
        $this->addOrderBy($query, $orderBy);

        if (!empty($with)) {
            $query = $query->with($with);
        }

        if (!empty($withCount)) {
            $query = $query->withCount($withCount);
        }

        return $query->paginate($limit);
    }

    public function findById($id, $with = [], $withCount = [])
    {
        $query = $this->_model;
        if (!empty($with)) {
            $query = $query->with($with);
        }

        if (!empty($withCount)) {
            $query = $query->withCount($withCount);
        }
        return $query->find($id);
    }

    public function find($whereClauses, $orderBy = null, $with = [], $withCount = [])
    {
        $query = $this->_model->newQuery();
        $this->createQuery($query, $whereClauses);
        $this->addOrderBy($query, $orderBy);

        if (!empty($with)) {
            $query = $query->with($with);
        }

        if (!empty($withCount)) {
            $query = $query->withCount($withCount);
        }

        return $query->first();
    }

    public function create(array $attributes, $with = [], $withCount = [])
    {
        if (isset($attributes['relations'])) {
            $relations = $attributes['relations'];
            unset($attributes['relations']);
        }
        $model = $this->_model->newQuery()->create($attributes);
        if (!empty($relations)) {
            foreach ($relations as $name => $elements) {
                if (empty($elements)) {
                    continue;
                }
                if ($model->isRelation($name)) {
                    $isList = true;
                    foreach ($elements as $index => $element) {
                        if (!is_int($index)) {
                            $isList = false;
                            break;
                        }
                    }
                    if (!$isList) {
                        $model->{$name}()->create($elements);
                    } else {
                        foreach ($elements as $element) {
                            $model->{$name}()->create($element);
                        }
                    }
                } else {
                    throw new RelationNotFoundException();
                }
            }
        }

        if ($model) {
            if (!empty($with)) {
                $model->load($with);
            }

            if (!empty($withCount)) {
                $model->loadCount($withCount);
            }
            return $model;
        } else {
            return null;
        }
    }

    public function update($id, array $attributes, $with = [], $withCount = [])
    {
        $model = $id;
        if (is_scalar($id)) {
            $model = $this->findById($id);
        }
        if ($model) {
            if ($model->update($attributes)) {
                if (!empty($with)) {
                    $model->load($with);
                }

                if (!empty($withCount)) {
                    $model->loadCount($withCount);
                }
                return $model;
            } else {
                return null;
            }
        } else {
            throw new ObjectNotFoundException();
        }
    }

    public function delete($id, $with = [])
    {
        $model = $id;
        if (is_scalar($id)) {
            $model = $this->findById($id);
        }
        if ($model) {
            if (!empty($with)) {
                foreach ($with as $relation) {
                    if ($model->isRelation($relation)) {
                        $model->{$relation}()->delete();
                    } else {
                        throw new RelationNotFoundException();
                    }
                }
            }
            if ($model->delete()) {
                return true;
            } else {
                return false;
            }
        } else {
            throw new ObjectNotFoundException();
        }
    }

    public function createOrUpdate($id, array $attributes, $with = [], $withCount = [])
    {
        $model = $id;
        if (is_array($id)) {
            $model = $this->_model->newQuery()->updateOrCreate($id, $attributes);
            if ($model) {
                if (!empty($with)) {
                    $model->load($with);
                }
                if (!empty($withCount)) {
                    $model->loadCount($withCount);
                }
                return $model;
            }
            return null;
        } else if (is_numeric($id)) {
            $model = $this->findById($id);
        }

        if ($model) {
            if ($model->update($attributes)) {
                if (!empty($with)) {
                    $model->load($with);
                }
                if (!empty($withCount)) {
                    $model->loadCount($withCount);
                }
                return $model;
            } else {
                return null;
            }
        } else {
            return $this->create($attributes, $with, $withCount);
        }
    }

    public function bulkUpdate(array $whereClauses, array $attributes)
    {
        $query = $this->_model->newQuery();
        $this->createQuery($query, $whereClauses);
        return $query->update($attributes);
    }


    public function bulkDelete(array $whereClauses)
    {
        $query = $this->_model->newQuery();
        $this->createQuery($query, $whereClauses);
        return $query->delete();
    }

    private function createQuery(&$query, $whereClauses)
    {
        if (isset($whereClauses)) {
            foreach ($whereClauses as $clause) {
                if ($clause->getOperator() == 'raw') {
                    $query = $query->whereRaw($clause->getColumn());
                } else if ($clause->getOperator() == 'has') {
                    if ($clause->getFunction()) {
                        $query = $query->whereHas($clause->getRelation(), $clause->getFunction(), $clause->getRelationOperator(), $clause->getRelationCount());
                    } else {
                        $query = $query->has($clause->getRelation(), $clause->getRelationOperator(), $clause->getRelationCount());
                    }
                } else if ($clause->getOperator() == 'function') {
                    $query = $query->where($clause->getFunction());
                } else if ($clause->getOperator() == 'or') {
                    $orClauses = $clause->getValue();
                    $query = $query->where(function (Builder $q) use ($orClauses) {
                        $q->where($this->createQueryOr($q, $orClauses));
                    });
                } else if ($clause->getOperator() == 'whereHas') {
                    $orClauses = $clause->getValue();
                    $query = $query->whereHas($clause->getRelation(), function (Builder $q) use ($orClauses) {
                        $q->where($this->createQueryOr($q, $orClauses));
                    }, $clause->getRelationOperator(), $clause->getRelationCount());
                } else if (Str::startsWith($clause->getOperator(), 'fn_')) {
                    $query = $this->whereByName($query, $clause);
                } else {
                    $query = $query->where($clause->getColumn(), $clause->getOperator(), $clause->getValue());
                }
            }
        }
    }

    private function whereByName($query, $clause)
    {
        if (!Str::startsWith($clause->getOperator(), 'fn_')) {
            return $query;
        }

        list($fn, $name, $operator) = explode('_', $clause->getOperator());
        $name = Str::ucfirst($name);
        $functionName = "where$name";
        return $query->{$functionName}($clause->getColumn(), $operator, $clause->getValue());
    }

    private function addOrderBy(&$query, $orderBy)
    {
        if (!empty($orderBy)) {
            $orderFields = preg_split('/\,/', $orderBy);
            foreach ($orderFields as $field) {
                list($column, $value) = preg_split('/:/', $field);
                $query = $query->orderBy($column, $value);
            }
        }
    }

    private function createQueryOr(&$query, $whereClauses)
    {
        if (isset($whereClauses)) {
            foreach ($whereClauses as $clause) {
                if ($clause->getOperator() == 'raw') {
                    $query = $query->orWhereRaw($clause->getColumn());
                } else if ($clause->getOperator() == 'has') {
                    if ($clause->getFunction()) {
                        $query = $query->orWhereHas($clause->getRelation(), $clause->getFunction(), $clause->getRelationOperator(), $clause->getRelationCount());
                    } else {
                        $query = $query->orHas($clause->getRelation(), $clause->getRelationOperator(), $clause->getRelationCount());
                    }
                } else if ($clause->getOperator() == 'function') {
                    $query = $query->orWhere($clause->getFunction());
                } else if ($clause->getOperator() == 'or') {
                    $orClauses = $clause->getValue();
                    $query = $query->orWhere(function (Builder $q) use ($orClauses) {
                        $q->where($this->createQuery($q, $orClauses));
                    });
                } else if ($clause->getOperator() == 'whereHas') {
                    $orClauses = $clause->getValue();
                    $query = $query->orWhereHas($clause->getRelation(), function (Builder $q) use ($orClauses) {
                        $q->where($this->createQueryOr($q, $orClauses));
                    }, $clause->getRelationOperator(), $clause->getRelationCount());
                } else if (Str::startsWith($clause->getOperator(), 'fn_')) {
                    $query = $this->whereByName($query, $clause);
                } else {
                    $query = $query->orWhere($clause->getColumn(), $clause->getOperator(), $clause->getValue());
                }
            }
        }
    }

    public function truncate()
    {
        $this->_model->newQuery()->truncate();
    }


}
