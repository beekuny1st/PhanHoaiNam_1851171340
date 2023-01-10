<?php

namespace App\Common;

interface RepositoryInterface
{
    public function getAll();

    public function get($whereClauses, $orderBy = 'id:asc', $with = [], $withCount = []);

    public function paginate($limit, $whereClauses, $orderBy, $with = [], $withCount = []);

    public function findById($id, $with = [], $withCount = []);

    public function find($whereClauses, $orderByFields = null, $with = [], $withCount = []);

    public function create(array $attributes, $with = [], $withCount = []);

    public function update($id, array $attributes, $with = [], $withCount = []);

    public function delete($id, $with = []);

    public function createOrUpdate($id, array $attributes, $with = [], $withCount = []);

    public function bulkUpdate(array $whereClauses, array $attributes);

    public function bulkDelete(array $whereClauses);

    public function truncate();

}
