<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductRequisitionController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('product-requisition/products',                          [ProductRequisitionController::class, 'products']);
Route::post('product-requisitions',                                  [ProductRequisitionController::class, 'index']);
Route::get('product-requisitions/show/{product_requisition_id}',    [ProductRequisitionController::class, 'show']);
Route::get('product-requisitions/edit/{product_requisition_id}',    [ProductRequisitionController::class, 'edit']);
Route::post('product-requisitions/store',                           [ProductRequisitionController::class, 'store']);
Route::post('product-requisitions/update/{product_requisition_id}', [ProductRequisitionController::class, 'update']);
Route::delete('product-requisitions/{product_requisition_id}',       [ProductRequisitionController::class, 'delete']);
Route::get('product-requisitions/issue/{product_requisition_id}',    [ProductRequisitionController::class, 'issue']);
Route::post('product-requisitions/issue/store',                      [ProductRequisitionController::class, 'issueStore']);
Route::post('product-requisitions/issue/update',                     [ProductRequisitionController::class, 'issueUpdate']);

