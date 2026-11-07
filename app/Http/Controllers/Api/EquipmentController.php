<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipmentRequest;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

/**
 * @tags Equipment
 */
class EquipmentController extends Controller
{
    /**
     * Listar equipos
     *
     * Devuelve los equipos paginados de a 10.
     */
    public function index(): AnonymousResourceCollection
    {
        return EquipmentResource::collection(Equipment::paginate(10));
    }

    /**
     * Crear equipo
     *
     * El horómetro parte en 0; solo cambia al registrar cargas o mantenciones.
     */
    public function store(EquipmentRequest $request): JsonResponse
    {
        $equipment = Equipment::create($request->validated())->refresh();

        return new EquipmentResource($equipment)->response()->setStatusCode(201);
    }

    /**
     * Ver equipo
     */
    public function show(Equipment $equipment): EquipmentResource
    {
        return new EquipmentResource($equipment);
    }

    /**
     * Editar equipo
     *
     * Se envía el cuerpo completo, igual que al crear.
     */
    public function update(EquipmentRequest $request, Equipment $equipment): EquipmentResource
    {
        $equipment->update($request->validated());

        return new EquipmentResource($equipment->refresh());
    }

    /**
     * Eliminar equipo
     */
    public function destroy(Equipment $equipment): Response
    {
        $equipment->delete();
       // noContent es un error 204
        return response()->noContent();
    }
}
