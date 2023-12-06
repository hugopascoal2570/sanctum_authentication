<?php
namespace App\Repositories;
use App\Models\User;

class UserRepository extends AbstractRepository{

protected $model = User::class;

private $user;

public function __construct(User $user)
{
    $this->user = $user;
}

public function searchByName($name, $email)
{
    try {
        $results = $this->user
        ->where('name', 'like', "%$name%")
        ->orWhere('email','like',"%$email%")
        ->get();

        if ($results->isEmpty()) {
            return response()->json(['message' => 'Nenhum usuário encontrado com o nome fornecido'], 404);
        }

        return response()->json($results, 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Erro interno no servidor'], 500);
    }
}

}