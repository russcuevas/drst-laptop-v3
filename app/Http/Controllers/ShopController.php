<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function ShopPage()
    {
        $top_products = DB::table('top_products')
            ->join('products', 'top_products.product_id', '=', 'products.id')
            ->select('products.id', 'products.product_name', 'products.product_picture', 'products.product_type', 'products.product_grain', 'products.product_net_wt', 'products.product_price', 'top_products.total_sold')
            ->orderBy('top_products.total_sold', 'desc')
            ->take(3)
            ->get();

        $product_count = Product::count();
        $all_products = Product::paginate(6);
        return view('page.shop', compact('all_products', 'product_count', 'top_products'));
    }

    public function FilterByGrain(Request $request)
    {
        $grain_type = $request->input('grain');
        $filtered_products = Product::where('product_grain', $grain_type)->get();

        $top_products = DB::table('top_products')
            ->join('products', 'top_products.product_id', '=', 'products.id')
            ->select('products.id', 'products.product_name', 'products.product_picture', 'products.product_type', 'products.product_grain', 'products.product_net_wt', 'products.product_price', 'top_products.total_sold')
            ->orderBy('top_products.total_sold', 'desc')
            ->take(3)
            ->get();

        $product_count = Product::count();
        $all_products = $filtered_products;

        return view('page.shop', compact('all_products', 'product_count', 'top_products', 'grain_type'));
    }
}
