<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PermissionProfileRepository 
{
	private $permission, $profile;

    public function __construct(Permission $permission, Profile $profile)
    {
        $this->permission = $permission;
        $this->profile = $profile;
    }

    public function permissions($idProfile)
    {
        $profile = $this->profile->find($idProfile);
    
        if (!$profile) {
            return response()->json(['message' => 'Perfil não encontrado'], 404);
        }
    
        $permissions = $profile->permissions()->paginate();
    
        return response()->json(['profile' => $profile, 'permissions' => $permissions], 200);
    }

    public function profiles($idPermission)
    {
        if (!$permission = $this->permission->find($idPermission)) {
            return response()->json(['message' => 'Permissão não encontrada'], 404);
        }
    
        $profiles = $permission->profiles()->paginate();
    
        return response()->json(['permission' => $permission, 'profiles' => $profiles], 200);
    }

    public function permissionsAvailable(Request $request, $idProfile)
{
    if (!$profile = $this->profile->find($idProfile)) {
        return response()->json(['message' => 'Perfil não encontrado'], 404);
    }

    $filters = $request->except('_token');

    $permissions = $profile->permissionsAvailable($request->filter);

    return response()->json(['profile' => $profile, 'permissions' => $permissions, 'filters' => $filters], 200);
}

public function attachPermissionsProfile(Request $request, $idProfile)
{
    $profile = $this->profile->find($idProfile);

    if (!$profile) {
        return response()->json(['message' => 'Perfil não encontrado'], 404);
    }

    $permissions = $request->permissions;

    if (empty($permissions)) {
        return response()->json(['message' => 'Escolha pelo menos uma permissão'], 400);
    }

    $profile->permissions()->attach($permissions);

    return response()->json(['message' => 'Permissões atribuídas com sucesso', 'profile_id' => $profile->id], 201);
}

public function detachPermissionProfile($idProfile, $idPermission): JsonResponse
{
    $profile = $this->profile->find($idProfile);
    $permission = $this->permission->find($idPermission);

    if (!$profile || !$permission) {
        return response()->json(['message' => 'Perfil ou permissão não encontrado'], 404);
    }

    $profile->permissions()->detach($permission);

    return response()->json(['message' => 'Permissão removida com sucesso'], 200);
}
}