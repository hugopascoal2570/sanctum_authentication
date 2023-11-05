<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreUpdatePermission;
use App\Models\Permission;
use App\Repositories\PermissionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function index(): JsonResponse
    {
        $plans = $this->permissionRepository->all();

        return response()->json($plans);
    }

    public function store(StoreUpdatePermission $request): JsonResponse
    {
        $data = $request->validated();

        $plan = $this->permissionRepository->create($data);

        if ($plan) {
            return response()->json(['message' => 'Plano criado com sucesso'], 201);
        } else {
            return response()->json(['message' => 'Falha ao criar o plano'], 422);
        }
    }

    public function show($id)
    {
    $item = $this->permissionRepository->show($id);

    if (!$item) {
        return response()->json(['message' => 'Item não encontrado'], 404);
    }

    return response()->json($item, 200);
    }

    public function update(StoreUpdatePermission $request, $id)
    {
        $plan = $this->permissionRepository->find($id);
    
        if (!$plan) {
            return response()->json(['message' => 'Plano não encontrado'], 404);
        }
    
        $data = $request->validated();
    
        return $this->permissionRepository->update($data, $id);
    
    }

    public function destroy(string $id, Request $request)
    {
        $forceDelete = $request->input('forceDelete', false);
        $item = $this->permissionRepository->find($id);
        
        if (!$item) {
            return response()->json(['message' => 'Plano não encontrado'], 404);
        }
        
        if ($forceDelete) {
            return $this->permissionRepository->performDelete($id, true);
        } else {
            return $this->permissionRepository->performDelete($id, false);
        }
    }
}
