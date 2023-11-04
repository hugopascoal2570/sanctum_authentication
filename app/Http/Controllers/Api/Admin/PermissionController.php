<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreUpdatePermission;
use App\Models\Permission;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $model, $permissionRepository;

    public function __construct(Permission $permission, PermissionRepository $permissionRepository)
    {
        $this->model = $permission;
        $this->permissionRepository = $permissionRepository;

    }

    public function index(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $perPage = $request->input('perPage', 10);
    
            $dados = $this->model->paginate($perPage, ['*'], 'page', $page);
    
            if ($dados->isEmpty()) {
                return response()->json(['message' => 'Nenhuma Permissão encontrada'], 404);
            }
    
            return response()->json($dados, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro interno no servidor'], 500);
        }
    }

    public function show($id)
    {
        try {
            $item = $this->model->where('id', $id)->first();

            if (!$item) {
                return response()->json(['message' => 'Nenhuma Permissão encontrada'], 404);
            }

            return response()->json($item, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro interno no servidor'], 500);
        }
    }

    public function store(StoreUpdatePermission $request)
    {
        $data = $request->validated();
    
        $this->permissionRepository->create($data);
    
        return response()->json(['message' => 'Perfil criado com sucesso'], 201);
    }

    public function update(StoreUpdatePermission $request, $id)
    {
        $permission = $this->permissionRepository->find($id);
    
        if (!$permission) {
            return response()->json(['message' => 'Permissão não encontrada'], 404);
        }
    
        $data = $request->validated();
    
        $this->permissionRepository->update($permission, $data);
    
        return response()->json(['message' => 'Permissão atualizada com sucesso'], 200);
    }

    public function destroy(string $id, Request $request)
    {
        
        $forceDelete = $request->input('forceDelete', false);
        $item = $this->permissionRepository->find($id);
    
        if (!$item) {
            return ['message' => 'Permissão não encontrada'];
        }
    
        return $this->permissionRepository->delete($item, $forceDelete);
    }
}
