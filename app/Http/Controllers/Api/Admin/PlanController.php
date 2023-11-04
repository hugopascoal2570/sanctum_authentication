<?php

namespace App\Http\Controllers\Api\Admin;

use App\Repositories\PlanRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Http\Requests\Api\StoreUpdatePlan;

class PlanController extends Controller
{

    private $plan, $planRepository;

    public function __construct(Plan $plan, PlanRepository $planRepository)
    {
        $this->plan = $plan;
        $this->planRepository = $planRepository;
    }

    public function index(Request $request)
    {
        return $this->planRepository->index($request);
    }

    public function store(StoreUpdatePlan $request)
    {
        $data = $request->validated();
    
        $this->planRepository->create($data);
    
        return response()->json(['message' => 'Plano criado com sucesso'], 201);
    }

    public function show(Request $request, $id)
    {
        return $this->planRepository->show($id);
    }

    public function update(StoreUpdatePlan $request, $id)
    {
        $plan = $this->planRepository->find($id);
    
        if (!$plan) {
            return response()->json(['message' => 'Plano não encontrado'], 404);
        }
    
        // Obtenha os dados válidos do Request
        $data = $request->validated();
    
        // Atualize o plano usando o serviço
        $this->planRepository->update($plan, $data);
    
        return response()->json(['message' => 'Plano atualizado com sucesso'], 200);
    }
    
    public function destroy(string $id, Request $request)
    {
        
        $forceDelete = $request->input('forceDelete', false);
        $item = $this->planRepository->find($id);
    
        if (!$item) {
            return ['message' => 'Plano não encontrado'];
        }
    
        return $this->planRepository->delete($item, $forceDelete);
    }
    

    public function searchByName(Request $request)
    {
        $name = $request->input('name');
    
        return $this->planRepository->searchByName($name);
    }

}
