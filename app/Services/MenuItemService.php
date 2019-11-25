<?php

namespace App\Services;

use App\Repositories\MenuLayerRepo;

class MenuItemService
{
    protected $layerRepo;

    public function __construct(MenuLayerRepo $layerRepo)
    {
        $this->layerRepo = $layerRepo;
    }

    /**
     * group items data for insertion
     *
     * @param array $items
     * @param integer $menu
     * @return array
     */
    public function setMenuItemsData(array $items, int $menu): array
    {
        $response = [];
        $layer = $this->layerRepo->getMenuMaxLayer($menu)+1;
        foreach ($items as $item) {
            array_push($response, [
                "menu_id"=>$menu,
                "name"=> $item["name"],
                "layer"=>$layer
            ]);

            $layer++;
        }

        return $response;
    }
}
