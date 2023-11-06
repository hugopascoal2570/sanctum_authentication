<?php

namespace App\Http\Controllers\Api\ACL;

use App\Http\Controllers\Controller;
use App\Repositories\PermissionProfileRepository;
use Illuminate\Http\Request;

class PermissionProfileController extends Controller
{
    protected $permissionProfileRepository;

    public function __construct(PermissionProfileRepository $permissionProfileRepository)
    {
        $this->permissionProfileRepository = $permissionProfileRepository;
    }

    public function permissions($idProfile){
        return $this->permissionProfileRepository->permissions($idProfile);
    }

    public function profiles($idPermission){
        return $this->permissionProfileRepository->profiles($idPermission);
    }

    public function permissionsAvailable(Request $request,$idProfile){
        return $this->permissionProfileRepository->permissionsAvailable($request, $idProfile);
    }

    public function attachPermissionsProfile(Request $request, $idProfile)
    {
        return $this->permissionProfileRepository->attachPermissionsProfile($request, $idProfile);
    }
    
    public function detachPermissionProfile($idPlan, Request $request)
    {
        $data = $request->all();
        return $this->permissionProfileRepository->detachPermissionProfile($idPlan, $data,);
    }
}
