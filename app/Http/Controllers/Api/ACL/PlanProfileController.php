<?php

namespace App\Http\Controllers\Api\ACL;

use App\Http\Controllers\Controller;
use App\Repositories\PlanProfileRepository;
use Illuminate\Http\Request;

class PlanProfileController extends Controller
{
    protected $planProfileRepository;

    public function __construct(PlanProfileRepository $planProfileRepository)
    {
        $this->planProfileRepository = $planProfileRepository;
    }

    public function profiles($idPlan){
        return $this->planProfileRepository->profiles($idPlan);
    }

    public function plans($idProfile){
        return $this->planProfileRepository->plans($idProfile);
    }

    public function profilesAvailable(Request $request,$idProfile){
        return $this->planProfileRepository->profilesAvailable($request, $idProfile);
    }

    public function attachProfilesPlan(Request $request,$idProfile){
        return $this->planProfileRepository->attachProfilesPlan($request, $idProfile);
    }
    public function detachProfilePlan($idPlan, Request $request){
        $data = $request->all();
        return $this->planProfileRepository->detachProfilePlan($idPlan, $data);
    }
}
