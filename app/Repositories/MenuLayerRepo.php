<?php

namespace App\Repositories;

use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class MenuLayerRepo
{
    protected $cacheExp;

    protected $model;

    public function __construct(Item $model)
    {
        $this->model = $model;
        $this->cacheExp = config("system.cache.expiration");
    }

    /**
     * get the highest layer for a given menu
     *
     * @param integer $menu
     * @return integer
     */
    public function getMenuMaxLayer(int $menu): int
    {
        $max = $this->model->where("menu_id", $menu)->max("layer");

        return $max ? $max : 0;
    }

    /**
     * Get items from a specific menu layer
     *
     * @param integer $menu
     * @param integer $layer
     * @return array
     */
    public function getLayer(int $menu, int $layer):array
    {
        if (Cache::get("menu.{$menu}.layer.{$layer}")) {
            return Cache::get("menu.{$menu}.layer.{$layer}");
        }

        $response = $this->model->where("menu_id", $menu)->where("layer", $layer)->get()->toArray();
        Cache::put("menu.{$menu}.layer.{$layer}", $response, $this->cacheExp);

        return $response;
    }

    /**
     * deletes items from a specific menu layer
     *
     * @param integer $menu
     * @param integer $layer
     * @return void
     */
    public function deleteLayer(int $menu, int $layer): void
    {
        Cache::forget("menu." . $menu . ".items");
        Cache::forget("menu.{$menu}.layer.{$layer}");
        $this->model->where("menu_id", $menu)->where("layer", $layer)->delete();
        DB::select(
            "update items set layer=(layer-1) where menu_id={$menu} and layer>{$layer}"
        );
    }
}
