<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\MenuRepo;
use App\Services\MenuItemService;
use App\Repositories\MenuItemRepo;
use App\Repositories\MenuLayerRepo;

class MenuItemController extends Controller
{
    use ApiResponser;

    protected $menuRepo;

    protected $itemRepo;

    protected $layerRepo;

    protected $itemService;

    /**
     * class constructor for depency injection
     *
     * @param MenuRepo $menuRepo
     * @param ItemRepo $itemRepo
     * @param ItemService $itemService
     */
    public function __construct(
        MenuRepo $menuRepo,
        MenuItemRepo $itemRepo,
        MenuItemService $itemService,
        MenuLayerRepo $layerRepo
    ) {
        $this->menuRepo = $menuRepo;
        $this->itemRepo = $itemRepo;
        $this->layerRepo = $layerRepo;
        $this->itemService = $itemService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $menu)
    {
        $menu = $this->menuRepo->getById($menu);
        $highestLayer = $this->layerRepo->getMenuMaxLayer($menu->id);
        $items = $request->all();

        if ($highestLayer+count($items) > $menu->max_children) {
            return $this->errorResponse("Max menu children exceed", 403);
        }

        $items = $this->itemService->setMenuItemsData($items, $menu->id);

        $items = $this->itemRepo->create($items);

        $menuStructure = $this->itemRepo->getMenuItems($menu->id);

        return $this->successResponse($menuStructure, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($menu)
    {
        $menu = $this->menuRepo->getById($menu);
        $menuStructure = $this->itemRepo->getMenuItems($menu->id);

        return $this->successResponse($menuStructure);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($menu)
    {
        $menu = $this->menuRepo->getById($menu);
        $this->itemRepo->delete($menu->id);

        return $this->successResponse();
    }
}
