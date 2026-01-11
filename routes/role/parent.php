<?php

use App\Http\Controllers\Api\ParentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:parent'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('children', [ParentController::class, 'getChildrenWeb'])->name('children');
    
    Route::get('children/{student}/lessons', [ParentController::class, 'getChildLessonsWeb'])->name('children.lessons');
    
    Route::post('permissions', [ParentController::class, 'createPermissionWeb'])->name('permissions.store');
    Route::get('permissions', [ParentController::class, 'getPermissionHistoryWeb'])->name('permissions.index');
});
