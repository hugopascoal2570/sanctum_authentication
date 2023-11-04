<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;

class PermissionProfileRepository 
{
	private $permission, $profile, $baseRepository;

    public function __construct(Permission $permission, Profile $profile, BaseRepository $baseRepository)
    {
        $this->permission = $permission;
        $this->profile = $profile;
        $this->baseRepository = $baseRepository;
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

}