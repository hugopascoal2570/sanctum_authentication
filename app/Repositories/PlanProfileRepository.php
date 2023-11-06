<?php

namespace App\Repositories;

use App\Models\Plan;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PlanProfileRepository 
{
	private $plan, $profile;

    public function __construct(Plan $plan, Profile $profile)
    {
        $this->plan = $plan;
        $this->profile = $profile;
    }

    public function profiles($idPlan)
    {
        $plan = $this->plan->find($idPlan);

        if (!$plan) {
            return response()->json(['message' => 'Plano não encontrado'], 404);
        }

        $profiles = $plan->profiles()->paginate();

        return response()->json(['plan' => $plan, 'profiles' => $profiles], 200);
    }

    public function plans($idProfile): JsonResponse
    {
        $profile = $this->profile->find($idProfile);

        if (!$profile) {
            return response()->json(['message' => 'Perfil não encontrado'], 404);
        }

        $plans = $profile->plans()->paginate();

        return response()->json(['profile' => $profile, 'plans' => $plans], 200);
    }

    public function profilesAvailable(Request $request, $idPlan)
    {
        if (!$plan = $this->plan->find($idPlan)) {
            return redirect()->back();
        }

        $filters = $request->except('_token');

        $profiles = $plan->profilesAvailable($request->filter);

        return view('admin.pages.plans.profiles.available', compact('plan', 'profiles', 'filters'));
    }

        public function attachProfilesPlan(Request $request, $idPlan): JsonResponse
        {
            $plan = $this->plan->find($idPlan);
    
            if (!$plan) {
                return response()->json(['message' => 'Plano não encontrado'], 404);
            }
    
            if (!$request->profiles || count($request->profiles) == 0) {
                return response()->json(['message' => 'É necessário escolher pelo menos um perfil'], 422);
            }
    
            $plan->profiles()->attach($request->profiles);
    
            return response()->json(['message' => 'Perfis anexados com sucesso'], 201);
        }

        public function detachProfilePlan($idPlan, $idProfile): JsonResponse
        {
            $plan = $this->plan->find($idPlan);
            $profile = $this->profile->find($idProfile);
    
            if (!$plan || !$profile) {
                return response()->json(['message' => 'Plano ou perfil não encontrado'], 404);
            }
    
            $plan->profiles()->detach($profile);
    
            return response()->json(['message' => 'Perfil removido com sucesso do plano'], 200);
        }
}