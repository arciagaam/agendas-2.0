<?php

namespace App\Http\Controllers\admin\information;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassroomStoreRequest;
use App\Models\Classroom;
use App\Models\Room;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.information.classrooms.index', ['classrooms' => Classroom::getClassrooms()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.information.classrooms.create', ['rooms' => Room::get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassroomStoreRequest $request)
    {
        Classroom::create($request->validated());
        return redirect()->route('admin.information.classrooms.index');

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
