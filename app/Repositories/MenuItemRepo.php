<?php

namespace App\Repositories;

use App\Models\Item;
use Illuminate\Support\Facades\Cache;

class MenuItemRepo
{
    protected $cacheKey;

    protected $cacheExp;

    protected $model;

    public function __construct(Item $model)
    {
        $this->model = $model;
        $this->cacheKey = "item";
        $this->cacheExp = config("system.cache.expiration");
    }

    /**
     * create items for a given menu with provided data
     *
     * @param array $items
     * @return bool
     */
    public function create(array $items):bool
    {
        Cache::forget("menu." . $items[0]["menu_id"] . ".items");

        return $this->model->insert($items);
    }

    /**
     * Undocumented function
     *
     * @param integer $menu
     * @return boolean
     */
    public function delete(int $menu)
    {
        Cache::forget("menu." . $menu . ".items");

        return $this->model->where("menu_id", $menu)->delete();
    }

    /**
     * return the menu structure for the given menu
     *
     * @param integer $menu
     * @return array
     */
    public function getMenuItems(int $menu): array
    {
        if (Cache::get("menu." . $menu . ".items")) {
            return Cache::get("menu." . $menu . ".items");
        }

        $items = $this->model->where("menu_id", $menu)->orderBy("layer", "asc")->get()->toArray();
        Cache::put("menu." . $menu . ".items", $items, $this->cacheExp);

        return $items;
    }
}
