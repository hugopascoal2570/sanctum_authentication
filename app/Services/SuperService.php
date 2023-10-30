<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Services\SuperService;

class SuperService
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function softDelete($id)
    {
        $item = $this->model->find($id);

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

    public function forceDelete($id)
    {
        $item = $this->model->find($id);

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

    public function destroy($id, Request $request, PlanoService $planoService)
{
    $forceDelete = $request->input('softDelete', false);
    $result = $planoService->delete($id, $forceDelete);
    return response()->json($result, $result['message'] ? 200 : 500);
}
}
