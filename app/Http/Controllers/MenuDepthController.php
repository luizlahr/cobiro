<?php

namespace App\Http\Controllers;

use App\Repositories\MenuRepo;
use App\Traits\ApiResponser;

class MenuDepthController extends Controller
{
    use ApiResponser;

    protected $menuRepo;

    public function __construct(MenuRepo $menuRepo)
    {
        $this->menuRepo = $menuRepo;
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed $menu
     * @return \Illuminate\Http\Response
     */
    public function show($menu)
    {
        $depth = $this->menuRepo->getMenuDepth($menu);

        return $this->successResponse($depth);
    }
}
