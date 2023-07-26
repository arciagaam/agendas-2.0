<?php

namespace App\Http\Controllers\admin\information;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomStoreRequest;
use App\Models\Building;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.information.rooms.index', ['rooms' => Room::getRooms()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.information.rooms.create', ['buildings' => Building::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomStoreRequest $request)
    {
        Room::create($request->validated());
        return redirect()->route('admin.information.rooms.index')->with('success', 'A new room has been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return view('pages.admin.information.rooms.edit', ['room' => $room, 'buildings' => Building::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomStoreRequest $request, Room $room)
    {
        $room->update($request->validated());
        return redirect()->route('admin.information.rooms.index')->with('success', 'Room information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
