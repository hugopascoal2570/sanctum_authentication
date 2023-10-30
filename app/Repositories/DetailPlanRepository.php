<?php

namespace App\Repositories;
use App\Models\{
    Plan,
    DetailPLan
};
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;

class DetailPlanRepository 
{
	private $plan, $detailPlan, $baseRepository;

    public function __construct(Plan $plan, DetailPLan $detailPlan, BaseRepository $baseRepository)
    {
        $this->plan = $plan;
        $this->detailPlan = $detailPlan;
        $this->baseRepository = $baseRepository;
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

    public function delete($item, $forceDelete)
    {
        $id = $item->id;
        if ($forceDelete == "true") {
            return $this->baseRepository->forceDelete($this->detailPlan, $id);
        } else {
            return $this->baseRepository->delete($this->detailPlan, $id);
        }
    }
}