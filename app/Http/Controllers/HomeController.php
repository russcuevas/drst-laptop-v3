<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    // public homepage accessible in all role
    public function HomePage()
    {
        $top_products = DB::table('top_products')
            ->join('products', 'top_products.product_id', '=', 'products.id')
            ->select('products.id', 'products.product_name', 'products.product_picture', 'top_products.total_sold')
            ->orderBy('top_products.total_sold', 'desc')
            ->take(3)
            ->get();
        $featured_products = Product::take(4)->get();
        return view('page.home', compact('top_products', 'featured_products'));
    }

    // view single product with its related product grain
    public function SingleProductPage($id)
    {
        $single_product = Product::find($id);

        if (!$single_product) {
            return redirect()->route('homepage')->with('error', 'Product not found');
        }

        $related_products = Product::where('product_grain', $single_product->product_grain)
            ->where('id', '<>', $id)
            ->take(4)
            ->get();

        return view('page.single_product', compact('single_product', 'related_products'));
    }
}
