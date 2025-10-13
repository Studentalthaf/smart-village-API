<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HeadOfFamilyController;
use App\Http\Controllers\FamilyMemberController;

Route::get('test', function () {
    return response()->json(['message' => 'API is working']);
});

Route::apiResource('users', UserController::class);
Route::get('users/all/paginated', [UserController::class, 'getAllPaginated']);

Route::apiResource('head-of-families', HeadOfFamilyController::class);
Route::get('head-of-families/all/paginated', [HeadOfFamilyController::class, 'getAllPaginated']);


Route::apiResource('family-members', FamilyMemberController::class);
Route::get('family-members/all/paginated', [FamilyMemberController::class, 'getAllPaginated']);
