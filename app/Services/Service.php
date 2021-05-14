<?php
declare (strict_types = 1);
namespace App\Services;

use App\Repositories\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;


/**
 * Class Service
 *
 * @package App\Services
 */
abstract class Service
{
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * Contructor
     *
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get paginated data
     *
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function paginate(array $params): LengthAwarePaginator
    {
        return $this->repository->paginate($params);
    }

    /**
     * Create an entity
     *
     * @param array $params
     * @return mixed
     */
    public function create(array $params): Model
    {
        $params = $this->preCreate($params);
        $model = $this->repository->create($params);
        $this->postCreate($model, $params);

        return $model;
    }

    /**
     * Prepare data to create
     *
     * @param array $params
     * @return array
     */
    protected function preCreate(array $params): array
    {
        return $params;
    }

    /**
     * Post create entity. Useful when you want to do some thing like attach relationships or call some event
     *
     * @param Model $model
     * @param array $params
     */
    protected function postCreate(Model $model, array $params) {}

    /**
     * Update an entity
     *
     * @param Model $model
     * @param array $params
     * @return Model
     */
    public function update(Model $model, array $params): Model
    {
        $params = $this->preUpdate($model, $params);
        $model = $this->repository->update($model, $params);
        $this->postUpdate($model, $params);

        return $model;
    }

    /**
     * Prepare data to update
     *
     * @param Model $model
     * @param $params
     * @return array
     */
    protected function preUpdate(Model $model, $params): array
    {
        return $params;
    }

    /**
     * Post update entity. Useful when you want to do some thing like attach relationships or call some event
     *
     * @param Model $model
     * @param array $params
     */
    protected function postUpdate(Model $model, array $params) {}

    /**
     * Get all entity list filter by params
     *
     * @param array $params
     * @return Collection
     */
    public function all(array $params): Collection
    {
        return $this->repository->all($params);
    }

    /**
     * Get one register filtered by params
     *
     * @param array $params
     * @return mixed
     */
    public function one(array $params)
    {
        return $this->repository->one($params);
    }

    /**
     * Get entity by id
     *
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->repository->find($id);
    }

    /**
     * Get entity by uuid
     *
     * @param string $uuid
     * @return Model|null
     */
    public function findByUuid(string $uuid): ?Model
    {
        return $this->repository->where('uuid', $uuid)->first();
    }
}
