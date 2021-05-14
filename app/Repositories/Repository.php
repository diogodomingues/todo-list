<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * Class Repository
 * @package App\Repositories
 */
abstract class Repository
{
    /**
     * Number of items in pagination
     */
    const PER_PAGE = 20;

    // query cache time
    const CACHE_LIFETIME = 10800;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Builder
     */
    protected $query;

    /**
     * Contructor
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all data
     *
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function paginate(array $params): LengthAwarePaginator
    {
        return $this->filter($params)->paginate($params['per_page'] ?? static::PER_PAGE);
    }

    /**
     * Get all data
     *
     * @param array $params
     * @return Collection
     */
    public function get(array $params): Collection
    {
        return $this->filter($params)->get();
    }

    /**
     * Get all data
     *
     * @param array $params
     * @return mixed
     */
    public function first(array $params)
    {
        return $this->filter($params)->first();
    }

    /**
     * @param array $params
     * @return Builder
     */
    protected function filter(array $params): Builder
    {
        $this->query = $this->query ? $this->query : $this->model->query();

        if (count($params)) {
            foreach ($params as $param => $value) {
                $this->query->where($param, $value);
            }
        }

        return $this->query;
    }

    /**
     * Create new element
     *
     * @param array $params
     * @return Model
     */
    public function create(array $params): Model
    {
        $element = $this->model->create($params);

        return $element;
    }

    /**
     * FirstOrCreate - gets a first element filtered by array indexes
     * or create one with arrays params and indexes
     *
     * @param array $indexes - array with values to find
     * @param array $params - array with values to insert (+ $indexes)
     * @return Model - object of $model
     */
    public function firstOrCreate(array $indexes, $params): Model
    {
        $element = $this->model
            ->where($indexes)
            ->first();

        if (!$element) {
            $element = $this->model->save(array_merge($indexes, $params));
        }

        if (!$element) {
            Log::warning('<' . __CLASS__ . '.' . __FUNCTION__ . '> :: can´t for '
                . json_encode(array_marge($indexes, $params)));
        }

        return $element;
    }

    /**
     * Get all without pagination
     *
     * @param array $params
     * @return Collection
     */
    public function all(array $params): Collection
    {
        return $this->filter($params)->get();
    }

    /**
     * Get one register filtered by params
     *
     * @param array $params
     * @return mixed
     */
    public function one(array $params)
    {
        return $this->filter($params)->first();
    }

    /**
     * Update a element with array $params
     *
     * @param Model element
     * @param array $params
     * @return Model
     */
    public function update(Model $element, array $params): Model
    {
        $element->update($params);

        return $element;
    }

    /**
     * Return instance model
     *
     * @return Model
     */
    public function model(): Model
    {
        return $this->model;
    }
}
