<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Repository
 * @package App\Repositories
 */
class Repository
{
    private $model;

    /**
     * Repository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Model[]
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param array $arr
     * @return Model
     */
    public function create(array $arr): Model
    {
        return $this->model->create($arr);
    }

    /**
     * @param Model $modelObject
     * @param array $arr
     * @return bool|null
     */
    public function update(Model $modelObject, array $arr): ?bool
    {
        return $modelObject->update($arr);
    }

    /**
     * @param Model $modelObject
     * @return bool|null
     */
    public function delete(Model $modelObject): ?bool
    {
        return $modelObject->delete();
    }

    /**
     * @param $id
     * @return Model|null
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * @param $id
     * @return Model|null
     */
    public function findOrFail($id): ?Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * @param $sortBy
     * @param $orderBy
     * @param $searchValue
     * @return mixed
     */
    public function eloquentQuery($sortBy, $orderBy, $searchValue)
    {
        return $this->model->eloquentQuery($sortBy, $orderBy, $searchValue);
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return $this->model->first();
    }

    /**
     * @param string $column
     * @return mixed
     */
    public function latest($column = 'id')
    {
        return $this->model->latest($column);
    }

    /**
     * @return mixed
     */
    public function truncate()
    {
        return $this->model->truncate();
    }

    /**
     * @param array $arr
     * @return mixed
     */
    public function firstOrCreate(array $arr)
    {
        return $this->model->firstOrCreate($arr);
    }
}
