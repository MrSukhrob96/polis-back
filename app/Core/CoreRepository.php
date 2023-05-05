<?php

namespace App\Core;

use App\Core\Interfaces\RepositoryInetrface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @method availability
 * @method create
 * @method insert
 * @method collection
 * @method findById
 * @method update
 * @method delete
 */
abstract class CoreRepository implements RepositoryInetrface
{

    protected Model $model;

    /**
     * @param Model|Pivot $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function availability($query)
    {
        return $query;
    }

    /**
     * Method create
     *
     * @param array $payload
     * @return mixed
     */
    public function create(array $payload): mixed
    {
        return $this->model->create($payload);
    }

    /**
     * Method firstOrCreate
     *
     * @param array $where
     * @param array $data
     * @return mixed
     */
    public function firstOrCreate(array $where, array $data): mixed
    {
        return $this->model->firstOrCreate($where, $data);
    }

    /**
     * Method insert
     *
     * @param array $payload
     * @return mixed
     */
    public function insert(array $payload): mixed
    {
        return $this->model->insert($payload);
    }

    /**
     * Method upsert
     * 
     * @param array $where
     * @param array $data
     * @return
     */
    public function updateOrCreate(array $where, array $data)
    {
        return $this->model->updateOrCreate($where, $data);
    }

    /**
     * Method upsert
     * 
     * @param array $where
     * @param array $data
     * @return 
     */
    public function upsert(array $where, array $data)
    {
        return $this->model->upsert($where, $data);
    }

    /**
     * Method collection
     *
     * @param Builder $query
     * @param int|string $limit
     * @param array $appends
     * @return Collection
     */
    public function collection(Builder $query, int|string $limit = 20, array $appends = []): Collection
    {
        return $this->availability($query)->when($limit !== 'all', function ($query) use ($limit) {
            $query->limit($limit);
        })->get()->append($appends);
    }

    /**
     * Method findById
     *
     * @param int $modelId
     * @param array|string[] $columns
     * @param array $relations
     * @param array $appends
     * @return Model|null
     */
    public function findById(int $modelId, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->availability($this->model)->select($columns)
            ->with($relations)
            ->find($modelId);
    }

    /**
     * Method getAll
     * 
     * @return Model|array|null
     */
    public function getAll($relations = [])
    {
        return $this->model->with($relations)->orderBy('id', 'DESC')->get();
    }

    /**
     * Method findById
     *
     * @param Builder $query
     * @param int $per_page
     * @param array $appends
     * @return LengthAwarePaginator|null
     */
    public function pagination(Builder $query, int $per_page = 30, array $appends = []): LengthAwarePaginator
    {
        return $this->availability($query)->paginate($per_page);
    }

    /**
     * Method update
     *
     * @param Model|int $model
     * @param array $payload
     * @return bool
     */
    public function update(Model|int $model, array $payload): bool
    {
        return ($model instanceof Model) ? $model->update($payload) : $this->findById($model)->update($payload);
    }

    /**
     * Method delete
     *
     * @param Model|int $model
     * @return bool
     */
    public function delete(Model|int $model): bool
    {
        return ($model instanceof Model) ? $model->delete() : $this->findById($model)->delete();
    }
}
