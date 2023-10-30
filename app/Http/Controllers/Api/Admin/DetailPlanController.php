<?php

namespace App\Http\Controllers\Api\Admin;

use App\Repositories\DetailPlanRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Plan,
    DetailPlan
};
use App\Http\Requests\Api\StoreUpdateDetailPlan;

class DetailPlanController extends Controller
{
    private $detailPlanRepository, $detailPlan, $plan;

    public function __construct(DetailPlan $detailPlan, Plan $plan, DetailPlanRepository $detailPlanRepository)
    {
        $this->detailPlanRepository = $detailPlanRepository;
        $this->detailPlan = $detailPlan;
        $this->plan = $plan;
    }

    public function index(Request $request)
    {
        return $this->detailPlanRepository->index($request);
    }

    public function show($id)
    {
        return $this->detailPlanRepository->show($id);
    }

    public function store(StoreUpdateDetailPlan $request, $url)
    {

        $data = $request->all();
        
        $createdDetailPlan = $this->detailPlanRepository->store($data, $url);
    
        return $createdDetailPlan;
    }
    
    public function update(StoreUpdateDetailPlan $request, $urlPlan, $idDetail)
    {
        $data = $request->validated();
    
        $updatedDetailPlan = $this->detailPlanRepository->update($data, $idDetail, $urlPlan);
    
        if (!$updatedDetailPlan) {
            return response()->json(['message' => 'Erro interno ao atualizar o detalhe do plano'], 500);
        }
    return $updatedDetailPlan;
    }
    
    public function destroy( $urlPlan, string $idDetail,Request $request)
    {
        $forceDelete = $request->input('forceDelete', false);
        $item = $this->detailPlanRepository->find($idDetail);
    
        if (!$item) {
            return ['message' => 'Plano não encontrado'];
        }
    
        return $this->detailPlanRepository->delete($item, $forceDelete);
    }
    
}
