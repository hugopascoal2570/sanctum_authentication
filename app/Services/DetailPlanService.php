<?php

namespace App\Services;

use App\Models\DetailPlan;
use App\Models\Plan;
use Illuminate\Http\Request;

class DetailPlanService
{

    private $detailPlan;
    private $plan;
    public function __construct(DetailPlan $detailPlan, Plan $plan)
    {
        $this->detailPlan = $detailPlan;
        $this->plan = $plan;
    }

    public function find($id)
    {
        return $this->detailPlan->find($id);
    }

    public function index(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $perPage = $request->input('perPage', 10);
    
            $dados = $this->detailPlan->paginate($perPage, ['*'], 'page', $page);
    
            if ($dados->isEmpty()) {
                return response()->json(['message' => 'Nenhum Detalhe do Plano encontrado'], 404);
            }
    
            return response()->json($dados, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro interno no servidor'], 500);
        }
    }
    
    public function show($id)
    {
        try {
            $item = $this->detailPlan->find($id);

            if (!$item) {
                return response()->json(['message' => 'Item não encontrado'], 404);
            }

            return response()->json($item, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro interno no servidor'], 500);
        }
    }
    
    public function store(array $data, $url)
    {
            $plan = $this->plan->where('url', $url)->first();
    
            if (!$plan) {
                return response()->json(['message' => 'Plano não encontrado'], 404);
            }
    
            unset($data['url']);

            $data['plan_id'] = $plan->id;

            $detailPlan = $this->detailPlan->create($data);
    
            if ($detailPlan) {
                return response()->json(['message' => 'Detalhe do plano criado com sucesso'], 201);
            } else {
                return response()->json(['message' => 'Erro interno ao criar o detalhe do plano'], 500);
            }

    }
    
    public function update(array $data, $idDetail, $urlPlan)
    {
        try {
            // Encontre o plano pelo URL
            $plan = $this->plan->where('url', $urlPlan)->first();
    
            if (!$plan) {
                return response()->json(['message' => 'Plano não encontrado'], 404);
            }
    
            $detailPlan = $this->detailPlan->find($idDetail);
    
            if (!$detailPlan) {
                return response()->json(['message' => 'Detalhe do plano não encontrado'], 404);
            }
    
            $detailPlan->update($data);
    
            return response()->json(['message' => 'Detalhe do plano atualizado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro interno no servidor'], 500);
        }
    }
        
    public function delete($url, $idDetail, $forceDelete = true)
    {
        $plan = $this->plan->where('url', $url)->first();
        $detailPlan = $this->model->find($idDetail);
    
        if (!$plan || !$detailPlan) {
            return ['message' => 'Detalhe do plano não encontrado'];
        }
    
        try {
            if ($forceDelete) {
                $detailPlan->forceDelete();
                return ['message' => 'Detalhe do plano excluído permanentemente com sucesso'];
            } else {
                $detailPlan->delete();
                return ['message' => 'Detalhe do plano excluído com sucesso'];
            }
        } catch (\Exception $e) {
            return ['message' => 'Erro ao excluir o detalhe do plano'];
        }
    }
    

public function searchByName($name)
{
    try {
        $results = $this->model->where('name', 'like', "%$name%")->get();

        if ($results->isEmpty()) {
            return response()->json(['message' => 'Nenhum detalhe do plano encontrado com o nome fornecido'], 404);
        }

        return response()->json($results, 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Erro interno no servidor'], 500);
    }
}

}
