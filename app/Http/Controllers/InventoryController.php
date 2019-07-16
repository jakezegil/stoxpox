<?php

namespace App\Http\Controllers;

use App\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    //
    public function index(){
        $inventory = Inventory::all();

        return response()->json([
            'success' => true,
            'data' => $inventory
        ]);
    }

    public function myInventory()
    {
        $inventory = getMyInventory();
 
        return response()->json([
            'success' => true,
            'data' => $inventory
        ]);
    }

    public function getMyInventory()
    {
        $inventory = auth()->user()->inventory()
            ->leftJoin('products', 'inventory.product_id', '=', 'products.id')
            ->get(['name', 'product_count', 'stock_count', 'price', 'for_sale', 'price_per_product']);

        return $inventory;
    }

     /** public function list(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'product_count' => 'required|integer|min:0'
        ]);

        $toList = new Inventory();

        $toList->name = $request->name;
        $toList->price = $request->price;
        $toList->product_count = $request->product_count;

        $availableStock = getMyInventory()->where(
                ['name', '=', $toList->name],
                ['for_sale', '=', 'false'])->value('product_count');

        if($availableStock >= $toList->product_count){
            \DB::transaction(function () {
                $sell = firstOrNew(
                    ['name', '=', $toList->name],
                    ['for_sale', '=', 'true'],
                    ['price', '=', $toList->price]);
            }
        }
        return null;
        );
 
    } */

    private function update(Request $request){

    }
}

