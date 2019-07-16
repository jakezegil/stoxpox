<?php
 
namespace App\Http\Controllers;
 
use App\Product;
use Illuminate\Http\Request;
 
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
 
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function myProducts()
    {
        $products = auth()->user()->products()->get();
 
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function stocklist()
    {
        $products = \DB::table('products as p')
        ->leftJoin('users as u', 'p.user_id', '=', 'u.id')
        ->select('p.id as id', 'u.name as user_name', 'email', 'p.name as product_name', 'stock_count', 'price')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function mystocklist()
    {
        $products = auth()->user()->products()
        ->leftJoin('users as u', 'products.user_id', '=', 'u.id')
        ->select('products.id as id', 'u.name as user_name', 'email', 'products.name as product_name', 'stock_count', 'price')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }
 
    public function show($name)
    {
        $product = null;//work in progress
 
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product with id ' . $id . ' not found'
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $product->toArray()
        ], 400);
    }
 
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:products',
            'price' => 'required|numeric|min:0',
            'stock_count' => 'nullable|integer|min:0'
        ]);
 
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        if(!!$request->stock_count){
            $product->stock_count = $request->stock_count;
        } else {
            $product->stock_count = 100;
        }
 
        if (auth()->user()->products()->save($product))
            return response()->json([
                'success' => true,
                'data' => $product->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Product could not be added'
            ], 500);
    }
 
    public function update(Request $request)
    {

        $name = $request->name;
        
        $product = auth()->user()->products()->whereName($name)->first();
 
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product ' . $name . ' not found'
            ], 400);
        }
 
        $updated = $product->fill($request->all())->save();
 
        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Product could not be updated'
            ], 500);
    }
 
    public function destroy($name)
    {
        $product = auth()->user()->products()->find($name);
 
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product ' . $name . ' not found'
            ], 400);
        }
 
        if ($product->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product could not be deleted'
            ], 500);
        }
    }
}
