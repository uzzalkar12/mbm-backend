<?php

namespace App\Http\Services;

use App\Http\resources\ProductRequisitionResource;
use App\Models\Product;
use App\Models\ProductRequisition;
use App\Models\ProductRequisitionItem;
use App\Models\ProductRequisitionItemDetail;
use App\Models\ProductStock;
use Illuminate\Support\Facades\DB;

class ProductRequisitionService
{
    public function index($request): \Illuminate\Database\Eloquent\Collection|array
    {
        return ProductRequisition::query()
            ->when($request->has('date_range') && $request->get('date_range') != "", function($query) use($request){
                $query->whereBetween('created_at',  $request->date_range);
            })
            ->get();
    }

    public function findById($product_requisition_id)
    {
        return ProductRequisition::query()
            ->with(['productRequisitionItems.productStocks', 'productRequisitionItems.product'])
            ->where('id', $product_requisition_id)->first();
    }

    public function store($validateData)
    {
        $product_requisition = ProductRequisition::query()->latest()->first();
        if ($product_requisition) {
            $product_requisition_number = $product_requisition->product_requisition_number;
            $product_requisition_number = $product_requisition_number + 1;
        }else{
            $product_requisition_number = '10000';
        }

        $data['product_requisition_number'] = $product_requisition_number;
        $data['user_id']                = 1;
        return ProductRequisition::query()->create($data);
    }

    public function update($validateData, $product_requisition)
    {
        //
    }

    public function productRequisitionItem($product_requisition_items, $product_requisition_id)
    {
        $existing_product_requisition_items = DB::table('product_requisition_items')->get();
        if ($existing_product_requisition_items)
        {
           DB::table('product_requisition_items')->delete();
        }

        $product_requisition_item_array = array();
        foreach ($product_requisition_items as $product_requisition_item)
        {
            $data['product_requisition_id'] = $product_requisition_id;
            $data['product_id']             = $product_requisition_item['product_id'];
            $data['requested_quantity']     = $product_requisition_item['requested_quantity'];
            $data['requested_comment']      = $product_requisition_item['requested_comment'];
            $product_requisition_item_array[] = $data;
        }
        ProductRequisitionItem::query()->insert($product_requisition_item_array);
    }

    public function delete($product_requisition)
    {
        $product_requisition->productRequisitionItems()->delete();
        $product_requisition->delete();
    }

    public function products()
    {
        $products = Product::query()->get();
        $product_ids = $products->pluck('id');

        return [$products, $product_ids];
    }

    public function productRequisitionIssue($product_requisition_id)
    {
        $product_requisition = $this->findById($product_requisition_id);
        return new ProductRequisitionResource($product_requisition);
    }

    public function issueStore($product_requisition)
    {
        $product_requisition_id = $product_requisition['id'];
        $product_requisition_items = $product_requisition['product_requisition_items'];

        $existing_item_details = ProductRequisitionItemDetail::query()->where('product_requisition_id', $product_requisition_id)->get();

        if ($existing_item_details){
            foreach ($existing_item_details as $existing_item_detail){
                $product_stock_id = $existing_item_detail->product_stock_id;
                $accept_quantity = $existing_item_detail->accept_quantity;

                $product_stock = ProductStock::query()->where('id', $product_stock_id)->first();
                if ($product_stock) {
                    $product_stock->update([
                        'quantity' => $product_stock->quantity  + $accept_quantity
                    ]);
                }
            }

            ProductRequisitionItemDetail::query()->where('product_requisition_id', $product_requisition_id)->delete();

        }

        foreach ($product_requisition_items as $product_requisition_item)
        {
            $product_requisition_item_id = $product_requisition_item['id'];
            $requested_amount = $product_requisition_item['requested_amount'];

            if ($requested_amount > 0){
                $product_requisition = ProductRequisitionItem::query()->where('id', $product_requisition_item_id)->first();
                $product_requisition->update(['requested_amount' => $requested_amount]);

                $product_stock_array = array();
                foreach ($product_requisition_item['product_stocks'] as $product_stock){
                    $product_stock_id                    = $product_stock['id'];
                    $quantity                            = $product_stock['quantity'];
                    $data['product_requisition_id']      = $product_requisition_id;
                    $data['product_id']                  = $product_stock['product_id'];
                    $data['product_stock_id']            = $product_stock['id'];
                    $data['supplier_id']                 = $product_stock['supplier_id'];
                    $data['accept_quantity']             = $product_stock['accept_quantity'];
                    $data['total_amount']                = $product_stock['total_amount'];
                    $product_stock_array[] = $data;

                    $product_stock_update = ProductStock::query()->where('id', $product_stock_id)
                        ->first();

                    $product_stock_update->update([
                        'quantity' => $quantity - $product_stock['accept_quantity']
                    ]);
                }


                ProductRequisitionItemDetail::query()->insert($product_stock_array);
            }

        }

    }

    public function issueUpdate($product_requisition)
    {
        $product_requisition_id = $product_requisition['id'];
        $product_requisition_items = $product_requisition['product_requisition_items'];

        $existing_item_details = ProductRequisitionItemDetail::query()->where('product_requisition_id', $product_requisition_id)->get();

        if ($existing_item_details){
            foreach ($existing_item_details as $existing_item_detail){
                $product_stock_id = $existing_item_detail->product_stock_id;
                $accept_quantity = $existing_item_detail->accept_quantity;

                $product_stock = ProductStock::query()->where('id', $product_stock_id)->first();
                if ($product_stock) {
                    $product_stock->update([
                        'quantity' => $product_stock->quantity  + $accept_quantity
                    ]);
                }
            }

            ProductRequisitionItemDetail::query()->where('product_requisition_id', $product_requisition_id)->delete();

        }

        foreach ($product_requisition_items as $product_requisition_item)
        {
            $product_requisition_item_id = $product_requisition_item['id'];
            $requested_amount = $product_requisition_item['requested_amount'];

            if ($requested_amount > 0){
                $product_requisition = ProductRequisitionItem::query()->where('id', $product_requisition_item_id)->first();
                $product_requisition->update(['requested_amount' => $requested_amount]);

                $product_stock_array = array();
                foreach ($product_requisition_item['product_stocks'] as $product_stock){
                    $product_stock_id                    = $product_stock['id'];
                    $quantity                            = $product_stock['quantity'];
                    $data['product_requisition_id']      = $product_requisition_id;
                    $data['product_id']                  = $product_stock['product_id'];
                    $data['product_stock_id']            = $product_stock['id'];
                    $data['supplier_id']                 = $product_stock['supplier_id'];
                    $data['accept_quantity']             = $product_stock['accept_quantity'];
                    $data['total_amount']                = $product_stock['total_amount'];
                    $product_stock_array[] = $data;

                    $product_stock_update = ProductStock::query()->where('id', $product_stock_id)->first();

                    $product_stock_update->update([
                        'quantity' => $quantity - $product_stock['accept_quantity']
                    ]);
                }


                ProductRequisitionItemDetail::query()->insert($product_stock_array);
            }

        }

    }
}
