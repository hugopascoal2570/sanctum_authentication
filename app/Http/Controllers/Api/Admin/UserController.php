<?php

namespace App\Http\Controllers\Api\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreUpdateUser;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected $model, $userRepository;

    public function __construct(User $user, UserRepository $userRepository)
    {
        $this->model = $user;
        $this->userRepository = $userRepository;

    }

    public function index(Request $request): JsonResponse
    {
        $plans = $this->userRepository->all($request);
    
        return response()->json($plans);
    }

    public function show($id)
    {
        try {
            $item = $this->model->where('id', $id)->first();

            if (!$item) {
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            return response()->json($item, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro interno no servidor'], 500);
        }
    }

    public function store(StoreUpdateUser $request)
    {
        $data = $request->validated();
    
        $this->userRepository->create($data);
    
        return response()->json(['message' => 'Usuário criado com sucesso'], 201);
    }

    public function update(StoreUpdateUser $request, $id)
    {
        $user = $this->userRepository->update($request->only(['name', 'email', 'password']), $id);
        
        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }
    
        return response()->json(['message' => 'Usuário atualizado com sucesso'], 200);
    }

    public function destroy(string $id, Request $request)
    {
        
        $forceDelete = $request->input('forceDelete', false);
        $item = $this->userRepository->find($id);
    
        if (!$item) {
            return ['message' => 'Plano não encontrado'];
        }
    
        return $this->userRepository->delete($item, $forceDelete);
    }
}
