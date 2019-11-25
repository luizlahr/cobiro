<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\ItemRepo;
use App\Http\Requests\ItemRequest;

class ItemController extends Controller
{
    use ApiResponser;

    protected $itemRepo;

    public function __construct(ItemRepo $itemRepo)
    {
        $this->itemRepo = $itemRepo;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {
        $item = $this->itemRepo->create($request->all());

        return $this->successResponse($item, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed  $item
     * @return \Illuminate\Http\Response
     */
    public function show($item)
    {
        $item = $this->itemRepo->getById($item);

        return $item;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $item
     * @return \Illuminate\Http\Response
     */
    public function update(ItemRequest $request, $item)
    {
        $item = $this->itemRepo->update($item, $request->all());

        return $this->successResponse($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($item)
    {
        $this->itemRepo->delete($item);

        return $this->successResponse();
    }
}
