<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreUpdatePlan;
use App\Repositories\PlanRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    protected $planRepository;

    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function index(): JsonResponse
    {
        $plans = $this->planRepository->all();

        return response()->json($plans);
    }

    public function store(StoreUpdatePlan $request): JsonResponse
    {
        $data = $request->validated();

        $plan = $this->planRepository->create($data);

        if ($plan) {
            return response()->json(['message' => 'Plano criado com sucesso'], 201);
        } else {
            return response()->json(['message' => 'Falha ao criar o plano'], 422);
        }
    }

    public function show($id)
    {
    $item = $this->planRepository->show($id);

    if (!$item) {
        return response()->json(['message' => 'Item não encontrado'], 404);
    }

    return response()->json($item, 200);
    }

    public function update(StoreUpdatePlan $request, $id)
    {
        $plan = $this->planRepository->find($id);
    
        if (!$plan) {
            return response()->json(['message' => 'Plano não encontrado'], 404);
        }
    
        $data = $request->validated();
    
        return $this->planRepository->update($data, $id);
    
    }

    public function destroy(string $id, Request $request)
    {
        $forceDelete = $request->input('forceDelete', false);
        $item = $this->planRepository->find($id);
        
        if (!$item) {
            return response()->json(['message' => 'Plano não encontrado'], 404);
        }
        
        if ($forceDelete) {
            return $this->planRepository->performDelete($id, true);
        } else {
            return $this->planRepository->performDelete($id, false);
        }
    }
    
}
