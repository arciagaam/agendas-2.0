<?php

namespace App\Http\Controllers\admin\information;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuildingStoreRequest;
use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.information.buildings.index', ['buildings' => Building::getBuildings()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.information.buildings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BuildingStoreRequest $request)
    {
        Building::create($request->validated());
        return redirect()->route('admin.information.buildings.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Building $building)
    {
        return view('pages.admin.information.buildings.edit', ['building' => $building]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BuildingStoreRequest $request, Building $building)
    {
        $building->update($request->validated());
        return redirect()->route('admin.information.buildings.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building)
    {
        //
    }
}
