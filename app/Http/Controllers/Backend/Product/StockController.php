<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller{
    public function index(){
        $products= Product::with('product_image')->get();
        return view('Backend.Pages.Product.Stock.index',compact('products'));
    }
    public function add_stock(Request $request){
        // StockMovement::create([
        //     'product_id' => $product_id,
        //     'quantity' => $quantity,
        //     'movement_type' => 'in',
        // ]);
        // $product = Product::find($product_id);
        // $product->qty += $quantity;
        // $product->save();
    }
    public function remove_stock(Request $request){
        // StockMovement::create([
        //     'product_id' => $product_id,
        //     'quantity' => $quantity,
        //     'movement_type' => 'out',
        // ]);
        
        // $product = Product::find($product_id);
        // $product->qty -= $quantity;
        // $product->save();
    }
}