<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Common\Enum\EziWebRemoteCacheTypeEnum;
use App\Common\Exceptions\ObjectNotFoundException;
use App\Events\ClearCacheEvent;
use App\Models\Menu;
use App\Repository\MenuRepositoryInterface;
use Illuminate\Support\Facades\DB;

class MenuRepository extends EloquentRepository implements MenuRepositoryInterface
{
    public function getModel()
    {
        return Menu::class;
    }

    public function create(array $attributes, $with = [], $withCount = [])
    {
        $result = parent::create($attributes, $with, $withCount);
        ClearCacheEvent::dispatch(EziWebRemoteCacheTypeEnum::MENUS);
        return $result;
    }

    public function update($id, array $attributes, $with = [], $withCount = [])
    {
        $result = parent::update($id, $attributes, $with, $withCount);
        ClearCacheEvent::dispatch(EziWebRemoteCacheTypeEnum::MENUS);
        return $result;
    }


    /**
     * @param $id
     * @param array $with
     * @return bool
     * @throws ObjectNotFoundException
     * @throws \Exception
     */
    public function delete($id, $with = [])
    {
        $model = $id;
        if (is_numeric($id)) {
            $model = $this->findById($id);
        }
        if ($model) {

            $ids = [$model->id];
            $queueModels = [$model];
            while (!empty($queueModels)) {
                $element = array_shift($queueModels);
                array_push($ids, $element);
                foreach ($element->children as $c) {
                    array_push($queueModels, $c);
                }
            }
            if ($this->_model->whereIn('id', $ids)->delete()) {
                DB::statement('UPDATE menu m JOIN (SELECT @rank := -1) r SET m.order=@rank:=@rank+1 where m.menu_position_id = ?', [$model->menu_position_id]);
                ClearCacheEvent::dispatch(EziWebRemoteCacheTypeEnum::MENUS);
                return true;
            } else {
                throw new \Exception('Không thể xóa');
            }
        } else {
            throw new ObjectNotFoundException();
        }
    }

}