<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class BaseRepository 
{
    public function delete(Model $model, $id)
    {
        $item = $model->find($id);

        if (!$item) {
            return ['message' => 'Item não encontrado'];
        }

        try {
            $item->delete();
            return ['message' => 'Item excluído com sucesso'];
        } catch (\Exception $e) {
            return ['message' => 'Erro ao excluir o item'];
        }
    }

    public function forceDelete(Model $model, $id)
    {
        $item = $model->find($id);

        if (!$item) {
            return ['message' => 'Item não encontrado'];
        }

        try {
            $item->forceDelete();
            return ['message' => 'Item excluído permanentemente com sucesso'];
        } catch (\Exception $e) {
            return ['message' => 'Erro ao excluir permanentemente o item'];
        }
    }

    public function searchByName($name)
{
    try {
        $relts = $model->where('name', 'like', "%$name%")->get();

        if ($results->isEmpty()) {
            return response()->json(['message' => 'Nenhum plano encontrado com o nome fornecido'], 404);
        }

        return response()->json($results, 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Erro interno no servidor'], 500);
    }
}

}