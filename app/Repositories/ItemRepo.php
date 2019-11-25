<?php

namespace App\Repositories;

use App\Models\Item;
use Illuminate\Support\Facades\Cache;

class ItemRepo
{
    protected $model;

    protected $cacheKey;

    protected $cacheExp;

    /**
     * constructor with dependency injection of classes
     *
     * @param Item $model
     */
    public function __construct(Item $model)
    {
        $this->model = $model;
        $this->cacheKey = "item";
        $this->cacheExp = config("system.cache.expiration");
    }

    /**
     * get item data by id
     *
     * @param integer $item
     * @return Item
     */
    public function getById(int $item): Item
    {
        if (Cache::get($this->cacheKey . "." . $item)) {
            return Cache::get($this->cacheKey . "." . $item);
        }

        $item = $this->model->findOrFail($item);
        Cache::put($this->cacheKey . "." . $item->id, $item, $this->cacheExp);

        return $item;
    }

    /**
     * create a new item with provided data
     *
     * @param array $data
     * @return Item
     */
    public function create(array $data): Item
    {
        $item = $this->model->create($data);
        Cache::put($this->cacheKey . "." . $item->id, $item, $this->cacheExp);

        return $item;
    }

    /**
     * update a item by id with provided data
     *
     * @param integer $item
     * @param array $data
     * @return void
     */
    public function update(int $item, array $data)
    {
        $item = $this->model->findOrFail($item);
        $item->update($data);

        Cache::put($this->cacheKey . "." . $item->id, $item, $this->cacheExp);

        return $item;
    }

    /**
     * delete a item by id
     *
     * @param integer $item
     * @return mixed
     */
    public function delete(int $item)
    {
        $item = $this->model->findOrFail($item);
        Cache::forget($this->cacheKey . "." . $item->id);

        return $item->delete();
    }
}
