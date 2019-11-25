<?php

namespace App\Repositories;

use App\Models\Menu;
use Illuminate\Support\Facades\Cache;

class MenuRepo
{
    protected $model;

    protected $cacheKey;

    protected $cacheExp;

    /**
     * constructor with dependency injection of classes
     *
     * @param Menu $model
     */
    public function __construct(Menu $model)
    {
        $this->model = $model;
        $this->cacheKey = "menu";
        $this->cacheExp = config("system.cache.expiration");
    }

    /**
     * gets menu data by id
     *
     * @param integer $menu
     * @return Menu
     */
    public function getById(int $menu): Menu
    {
        if (Cache::get($this->cacheKey . "." . $menu)) {
            return Cache::get($this->cacheKey . "." . $menu);
        }

        $menu = $this->model->findOrFail($menu);
        Cache::put($this->cacheKey . "." . $menu->id, $menu, $this->cacheExp);

        return $menu;
    }

    /**
     * create a new menu with provided data
     *
     * @param array $data
     * @return Menu
     */
    public function create(array $data): Menu
    {
        $menu = $this->model->create($data);
        Cache::put($this->cacheKey . "." . $menu->id, $menu, $this->cacheExp);

        return $menu;
    }

    /**
     * update a menu by id with provided data
     *
     * @param integer $menu
     * @param array $data
     * @return void
     */
    public function update(int $menu, array $data)
    {
        $menu = $this->model->findOrFail($menu);
        $menu->update($data);

        Cache::put($this->cacheKey . "." . $menu->id, $menu, $this->cacheExp);

        return $menu;
    }

    /**
     * delete a menu by id
     *
     * @param integer $menu
     * @return mixed
     */
    public function delete(int $menu)
    {
        $menu = $this->model->findOrFail($menu);
        Cache::forget($this->cacheKey . "." . $menu->id);

        return $menu->delete();
    }
}
