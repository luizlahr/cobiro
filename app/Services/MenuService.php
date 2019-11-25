<?php

namespace App\Services;

use App\Repositories\MenuRepo;

class MenuService
{
    protected $menuRepo;

    public function __construct(MenuRepo $menuRepo)
    {
        $this->menuRepo = $menuRepo;
    }

    public function menuDepth($items)
    {
        $max = 0;
        foreach ($items as $item) {
            $depth = 1;
            if (isset($item["children"]) && !empty($item["children"])) {
                $depth += $this->menuDepth($item["children"]);
            }
            if ($depth > $max) {
                $max = $depth;
            }
        }

        return $max;
    }

    public function menuLayers($items)
    {
        $layers = 0;
        foreach ($items as $item) {
            $layers += 1;
            if (isset($item["children"])) {
                $layers += $this->menuLayers($item["children"]);
            }
        }

        return $layers;
    }
}
