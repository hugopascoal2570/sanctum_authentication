<?php

namespace App\Http\Controllers\Api\Admin;

use App\Repositories\DetailPlanRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\DetailPlan;
use App\Http\Requests\Api\StoreUpdateDetailPlan;

class DetailPlanController extends Controller
{
    protected $detailPlanRepository;

    public function __construct(DetailPlanRepository $detailPlanRepository)
    {
        $this->detailPlanRepository = $detailPlanRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $plans = $this->detailPlanRepository->all($request);
    
        return response()->json($plans);
    }

    public function store(StoreUpdateDetailPlan $request): JsonResponse
    {
        $data = $request->validated();

        $plan = $this->detailPlanRepository->create($data);

        if ($plan) {
            return response()->json(['message' => 'Plano criado com sucesso'], 201);
        } else {
            return response()->json(['message' => 'Falha ao criar o plano'], 422);
        }
    }

    public function show($id)
    {
    $item = $this->detailPlanRepository->show($id);

    if (!$item) {
        return response()->json(['message' => 'Item não encontrado'], 404);
    }

    return response()->json($item, 200);
    }

    public function update(StoreUpdateDetailPlan $request, $id)
    {
        $plan = $this->detailPlanRepository->find($id);
    
        if (!$plan) {
            return response()->json(['message' => 'Plano não encontrado'], 404);
        }
    
        $data = $request->validated();
    
        return $this->detailPlanRepository->update($data, $id);
    
    }
    
    public function destroy( string $idDetail, Request $request)
    {
        $forceDelete = $request->input('forceDelete', false);
        $item = $this->detailPlanRepository->find($idDetail);
    
        if (!$item) {
            return ['message' => 'Plano não encontrado'];
        }
    
        return $this->detailPlanRepository->delete($item, $forceDelete);
    }
    
}
