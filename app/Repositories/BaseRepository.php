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

}