<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Models\Permission;

class PermissionRepository extends BaseRepository
{

	private $model, $baseRepository;

    public function __construct(Permission $permission, BaseRepository $baseRepository)
    {
        $this->model = $permission;
        $this->baseRepository = $baseRepository;
    }

    public function find($id)
    {
        return $this->model->find($id);
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

    public function create(array $data)
    {
        $profile = $this->model->create($data);

        return $profile;
    }

    public function update(Permission $permission, array $data)
    {
    try {
        $permission->update($data);
        return $permission;
    } catch (\Exception $e) {
        throw new \Exception('Houve um erro ao atualizar a Permissão, confira os valores informados.');
    }
    }

    public function delete($item, $forceDelete)
    {
        $id = $item->id;
        if ($forceDelete == "true") {
            return $this->baseRepository->forceDelete($this->model, $id);
        } else {
            return $this->baseRepository->delete($this->model, $id);
        }
    }

    public function searchByName($name)
{
    try {
        $results = $this->model->where('name', 'like', "%$name%")->get();

        if ($results->isEmpty()) {
            return response()->json(['message' => 'Nenhuma permissão encontrada com o nome fornecido'], 404);
        }

        return response()->json($results, 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Erro interno no servidor'], 500);
    }
}
}
