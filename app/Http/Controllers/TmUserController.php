<?php

namespace App\Http\Controllers;

use App\Models\tm_user;
use App\Http\Requests\Storetm_userRequest;
use App\Http\Requests\Updatetm_userRequest;

class TmUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storetm_userRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(tm_user $tm_user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(tm_user $tm_user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatetm_userRequest $request, tm_user $tm_user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tm_user $tm_user)
    {
        //
    }
}
