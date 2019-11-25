<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Repositories\MenuRepo;
use App\Repositories\MenuLayerRepo;

class MenuLayerController extends Controller
{
    use ApiResponser;

    protected $menuRepo;

    protected $layerRepo;

    /**
     * class constructor for depency injection
     *
     * @param MenuRepo $menuRepo
     * @param layerRepo $layerRepo
     */
    public function __construct(MenuRepo $menuRepo, MenuLayerRepo $layerRepo)
    {
        $this->menuRepo = $menuRepo;
        $this->layerRepo = $layerRepo;
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($menu, $layer)
    {
        $menu = $this->menuRepo->getById($menu);
        $layer = $this->layerRepo->getLayer($menu->id, $layer);

        return $this->successResponse($layer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($menu, $layer)
    {
        $menu = $this->menuRepo->getById($menu);
        $this->layerRepo->deleteLayer($menu->id, $layer);

        return $this->successResponse();
    }
}
