<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\PlanController;
use App\Http\Controllers\Api\Admin\DetailPlanController;
use App\Http\Controllers\Api\Admin\PermissionController;
use App\Http\Controllers\Api\Admin\ProfileController;
use App\Http\Controllers\Api\ACL\PermissionProfileController;

Route::prefix('admin')
    ->group(function() {
        
    //permission x profile
    Route::any('profiles/{id}/permissions/create', [PermissionProfileController::class,'permissionsAvailable'])->name('profiles.permissions.available');
    Route::get('permissions/{id}/profile', [PermissionProfileController::class,'profiles'])->name('permissions.profiles');
    Route::get('profiles/{id}/permissions', [PermissionProfileController::class,'permissions'])->name('profiles.permissions');
   
    //profiles 
    Route::resource('permissions', PermissionController::class);
    Route::resource('profiles', ProfileController::class);

    //planos
    Route::delete('plans/{url}/details/{idDetail}', [DetailPlanController::class, 'destroy'])->name('details.plan.destroy');
    Route::get('plans/{url}/details/{idDetail}', [DetailPlanController::class, 'show'])->name('details.plan.show');
    Route::put('plans/{url}/details/{idDetail}', [DetailPlanController::class, 'update'])->name('details.plan.update');
    Route::post('plans/{url}/details', [DetailPlanController::class, 'store'])->name('details.plan.store');
    Route::get('plans/{url}/details', [DetailPlanController::class, 'index'])->name('details.plan.index');

    Route::get('planos/search',[PlanController::class, 'searchByName']);
    Route::resource('planos', PlanController::class);
    
});


// Route::post('/login', [AuthController::class, 'auth']);
// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
// Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
// Route::post('/register', [AuthController::class, 'register']);

// Route::middleware(['auth:sanctum'])->group(function () {

// });