<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreUpdateProfile;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Repositories\ProfileRepository;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    protected $model, $profileRepository;

    public function __construct(Profile $profile, ProfileRepository $profileRepository)
    {
        $this->model = $profile;
        $this->profileRepository = $profileRepository;

    }

    public function index(Request $request): JsonResponse
    {
        $plans = $this->profileRepository->all($request);
    
        return response()->json($plans);
    }

    public function show($id)
    {
        try {
            $item = $this->model->where('id', $id)->first();

            if (!$item) {
                return response()->json(['message' => 'Perfil não encontrado'], 404);
            }

            return response()->json($item, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro interno no servidor'], 500);
        }
    }

    public function store(StoreUpdateProfile $request)
    {
        $data = $request->validated();
    
        $this->profileRepository->create($data);
    
        return response()->json(['message' => 'Perfil criado com sucesso'], 201);
    }

    public function update(StoreUpdateProfile $request, $id)
    {
        $plan = $this->profileRepository->find($id);
    
        if (!$plan) {
            return response()->json(['message' => 'Plano não encontrado'], 404);
        }
    
        $data = $request->validated();
    
        $this->profileRepository->update($data, $plan);
    
        return response()->json(['message' => 'Plano atualizado com sucesso'], 200);
    }

    public function destroy(string $id, Request $request)
    {
        
        $forceDelete = $request->input('forceDelete', false);
        $item = $this->profileRepository->find($id);
    
        if (!$item) {
            return ['message' => 'Plano não encontrado'];
        }
    
        return $this->profileRepository->delete($item, $forceDelete);
    }
}
