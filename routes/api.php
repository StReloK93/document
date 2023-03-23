<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RejectTypesController;
use App\Http\Controllers\PatternController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\DocumentController;


use App\Http\Controllers\UserOrganizationsController;
use App\Http\Controllers\UserPositionsController;
use App\Http\Controllers\UserRollsController;

use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RollController;
use App\Http\Controllers\NegationController;
use App\Http\Controllers\NegationsListController;
use App\Http\Controllers\BackupController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/passwordreset', [AuthController::class, 'passwordReset']);
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/passwordclear', [UserController::class, 'passwordClear']);
    Route::post('/userupdate', [UserController::class, 'update']);
    Route::post('/adduser', [UserController::class, 'addUser']);

    
    Route::apiResource('organization', OrganizationController::class)->except(['store', 'show']);
    Route::get('organization/all', [OrganizationController::class, 'all']);
    Route::get('organization/my', [OrganizationController::class, 'my']);

    Route::get('rolls', [RollController::class, 'index']);


    Route::apiResource('reject-type', RejectTypesController::class)->except(['show']);

    Route::apiResource('positions', PositionController::class);
    Route::apiResource('negationslist', NegationsListController::class);
    
    Route::apiResource('pattern', PatternController::class);

    Route::apiResource('documents', DocumentController::class);
    Route::get('documentsnegations', [DocumentController::class, 'negation']);
    Route::get('documentsbackup', [DocumentController::class, 'backup']);
    Route::post('documents/{id}', [DocumentController::class, 'update']);


    Route::put('userpositions', [UserPositionsController::class, 'update']);
    Route::post('userpositions', [UserPositionsController::class, 'destroy']);

    
    Route::put('subscribe/{document_id}', [SubscribeController::class, 'check']);
    Route::get('subscribe/{id}', [SubscribeController::class, 'remove']);

    Route::put('userorganizations', [UserOrganizationsController::class, 'update']);
    Route::post('userorganizations', [UserOrganizationsController::class, 'destroy']);


    Route::put('userrolls', [UserRollsController::class, 'update']);
    Route::post('userrolls', [UserRollsController::class, 'destroy']);

    Route::put('negation/{document_id}', [NegationController::class, 'add']);
    Route::delete('negation/{id}', [NegationController::class, 'remove']);


    Route::put('backup/{document_id}', [BackupController::class, 'add']);
    Route::delete('backup/{id}', [BackupController::class, 'remove']);
});