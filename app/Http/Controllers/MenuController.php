<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Repositories\MenuRepo;
use App\Http\Requests\MenuRequest;
use Illuminate\Http\Response;

class MenuController extends Controller
{
    use ApiResponser;

    protected $menuRepo;

    public function __construct(MenuRepo $menuRepo)
    {
        $this->menuRepo = $menuRepo;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\MenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        $menu = $this->menuRepo->create($request->all());

        return $this->successResponse($menu, Response::HTTP_CREATED);
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

        return $menu;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\MenuRequest  $request
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, $menu)
    {
        $menu = $this->menuRepo->update($menu, $request->all());

        return $this->successResponse($menu);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($menu)
    {
        $this->menuRepo->delete($menu);

        return $this->successResponse();
    }
}
