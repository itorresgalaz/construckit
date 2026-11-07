<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\FuelLoad;
use Illuminate\Http\Request;
use App\Models\FuelType;
use App\Http\Resources\FuelLoadResource;
use App\Http\Request\FuelLoadRequest;

class FuelLoadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return FuelLoad::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Equipment $equipment)
    {
        //
        $request->validated();
        return FuelLoad::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(FuelLoad $fuelLoad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FuelLoad $fuelLoad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FuelLoad $fuelLoad)
    {
        //
    }
}
