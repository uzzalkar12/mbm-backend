<?php

namespace App\Http\Controllers;

use App\Http\Requests\IssueStoreRequest;
use App\Http\Requests\ProductRequisitionStoreRequest;
use App\Http\Requests\ProductRequisitionUpdateRequest;
use App\Http\Services\ProductRequisitionService;
use App\Jobs\ProductRequisitionMailJob;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductRequisitionController extends Controller
{
    /** Product requisition get all */
    public function index(Request $request, ProductRequisitionService $productRequisitionService)
    {
        $product_requisitions = $productRequisitionService->index($request);
        return response()->json(['success' => true, 'product_requisitions' => $product_requisitions], 201);

    }

    /** Product requisition store */
    public function store(ProductRequisitionStoreRequest $request, ProductRequisitionService $productRequisitionService)
    {
        DB::beginTransaction();

        try {
            $validateData = $request->validated();
            $product_requisition_create = $productRequisitionService->store($validateData);

            $product_requisition_items = json_decode($validateData['product_requisition_items'], true);
            $productRequisitionService->productRequisitionItem($product_requisition_items, $product_requisition_create->id);

            // Mail send
//            $email = 'admin@gmail.com';
//            ProductRequisitionMailJob::dispatch($email);
//
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Product requisition created successfully'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Product requisition created failed. ' . $e->getMessage(),
            ]);
        }

    }

    /** Product requisition show by id */
    public function show($product_requisition_id, ProductRequisitionService $productRequisitionService)
    {
        $product_requisition = $productRequisitionService->findById($product_requisition_id);
        return response()->json(['success' => true, 'product_requisition' => $product_requisition], 201);
    }

    /** Product requisition edit by id */
    public function edit($product_requisition_id, ProductRequisitionService $productRequisitionService)
    {
        $product_requisition = $productRequisitionService->findById($product_requisition_id);

        $products = Product::query()
        ->leftJoin('product_requisition_items', function ($join) use ($product_requisition_id) {
            $join->on('products.id', '=', 'product_requisition_items.product_id')
                ->where('product_requisition_items.product_requisition_id', $product_requisition_id);
        })
            ->select('products.id', 'products.name',  'products.unit',
                'product_requisition_items.product_id', 'product_requisition_items.requested_quantity',  'product_requisition_items.requested_comment','product_requisition_items.product_requisition_id')
            ->get();
        $product_ids = $products->pluck('id');

        return response()->json(['success' => true, 'product_requisition' => $product_requisition, 'products' => $products, 'product_ids' => $product_ids], 201);
    }

    /** Product requisition update by id */
    public function update(ProductRequisitionUpdateRequest $request, $product_requisition_id, ProductRequisitionService $productRequisitionService)
    {
        DB::beginTransaction();

        try {
            $validateData = $request->validated();
            $product_requisition = $productRequisitionService->findById($product_requisition_id);
            $productRequisitionService->update($validateData, $product_requisition);

            $product_requisition_items = json_decode($validateData['product_requisition_items'], true);
            $productRequisitionService->productRequisitionItem($product_requisition_items, $product_requisition_id);


            DB::commit();
            return response()->json(['success' => true, 'message' => 'Product requisition updated successfully'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Product requisition updated failed. ' . $e->getMessage(),
            ]);
        }
    }

    /** Product requisition delete by id */
    public function delete($product_requisition_id, ProductRequisitionService $productRequisitionService)
    {
        $product_requisition = $productRequisitionService->findById($product_requisition_id);
        $productRequisitionService->delete($product_requisition);
        return response()->json(['success' => true, 'message' => 'Product requisition deleted successfully'], 201);
    }

    /** Get all product */
    public function products(ProductRequisitionService $productRequisitionService)
    {
        list($products, $product_ids) = $productRequisitionService->products();
        return response()->json(['success' => true, 'products' => $products, 'product_ids' => $product_ids], 201);
    }

    /** Issue*/
    public function issue($product_requisition_id, ProductRequisitionService $productRequisitionService)
    {
        $suppliers = Supplier::query()->get();
        $product_requisition = $productRequisitionService->productRequisitionIssue($product_requisition_id);
        return response()->json(['success' => true, 'product_requisition' => $product_requisition, 'suppliers' => $suppliers], 201);

    }

    /** Issue store*/
    public function issueStore(IssueStoreRequest $request, ProductRequisitionService $productRequisitionService)
    {
        $validatedData = $request->validated();
        $product_requisition = $validatedData['product_requisition'];
        $productRequisitionService->issueStore($product_requisition);

        return response()->json(['success' => true, 'message' => 'Product requisition issue created.'], 201);
    }

    /** Issue update*/
    public function issueUpdate(IssueStoreRequest $request, ProductRequisitionService $productRequisitionService)
    {
        $validatedData = $request->validated();
        $product_requisition = $validatedData['product_requisition'];
        $productRequisitionService->issueUpdate($product_requisition);

        return response()->json(['success' => true, 'message' => 'Product requisition issue updated.'], 201);
    }
}
