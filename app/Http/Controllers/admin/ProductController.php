<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function ProductPage()
    {
        // check if the role is admin or not
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('loginpage');
            } else {
                $products = Product::all();
                // returning the list of product and the view
                return view('admin.products.admin_products', compact('products'));
            }
        }
    }

    public function AddProductPage()
    {
        // check if the role is admin or not
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('loginpage');
            } else {
                return view('admin.products.admin_addproducts');
            }
        } else {
            return redirect()->route('loginpage');
        }
    }

    public function AddProductRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_code' => 'required|string',
            'product_picture' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product_name' => 'required|string',
            'product_type' => 'required|string',
            'product_price' => 'required|numeric',
            'product_net_wt' => 'required|string',
            'product_grain' => 'required|string',
            'product_stocks' => 'required|integer',
            'product_status' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product_status = ($request->input('product_stocks') >= 5) ? 'Available' : (($request->input('product_stocks') > 0) ? 'Low stocks' : 'Not available');

        $image_path = $request->file('product_picture')->store('products', 'public');

        $product = new Product([
            'product_code' => $request->input('product_code'),
            'product_picture' => $image_path,
            'product_name' => $request->input('product_name'),
            'product_price' => $request->input('product_price'),
            'product_type' => $request->input('product_type'),
            'product_net_wt' => $request->input('product_net_wt'),
            'product_grain' => $request->input('product_grain'),
            'product_stocks' => $request->input('product_stocks'),
            'product_status' => $product_status,
        ]);

        // insert to database and return to page
        $product->save();
        return redirect()->route('admin.addproducts')->with('success', 'Product added successfully');
    }

    public function UpdateProductPage($id)
    {
        // check if the role is admin or not
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('loginpage');
            } else {
                $product = Product::find($id);
                if (!$product) {
                    return redirect()->route('admin.products')->with('error', 'Product not found');
                }
                // getting the product and its grain
                $old_grain = $product->product_grain;
                return view('admin.products.admin_update_product', compact('product', 'old_grain'));
            }
        }
    }

    public function UpdateProductRequest(Request $request, $id)
    {
        // check if the role is admin or not
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('loginpage');
            } else {
                // form validation request
                $validator = Validator::make($request->all(), [
                    'product_code' => 'required|string',
                    'product_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'product_name' => 'required|string',
                    'product_type' => 'required|string',
                    'product_price' => 'required|numeric',
                    'product_net_wt' => 'required|string',
                    'product_grain' => 'required|string',
                    'product_stocks' => 'required|integer',
                    'product_status' => 'nullable|string',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $product = Product::find($id);

                if (!$product) {
                    return redirect()->route('admin.products')->with('error', 'Product not found');
                }

                // Update product fields
                $product->product_code = $request->input('product_code');
                $product->product_name = $request->input('product_name');
                $product->product_type = $request->input('product_type');
                $product->product_price = $request->input('product_price');
                $product->product_net_wt = $request->input('product_net_wt');
                $product->product_grain = $request->input('product_grain');
                $product->product_stocks = $request->input('product_stocks');

                // Query update product status based on stocks
                $product->product_status = ($request->input('product_stocks') >= 5) ? 'Available' : (($request->input('product_stocks') > 0) ? 'Low stocks' : 'Not available');

                // Check if a new file is uploaded
                if ($request->hasFile('product_picture')) {
                    $image_path = $request->file('product_picture')->store('products', 'public');
                    $product->product_picture = $image_path;
                }

                // Save to the database
                $product->update();

                return redirect()->route('admin.updateproducts', ['id' => $product->id])->with('success', 'Product updated successfully');
            }
        }
    }

    // delete product
    public function DeleteProductRequest($id)
    {
        // check if the role is admin or not
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('loginpage');
            } else {
                $product = Product::find($id);
                if (!$product) {
                    return redirect()->route('admin.products')->with('error', 'Product not found');
                }

                // delete the picture that is existing in deleting product
                if (!empty($product->product_picture) && File::exists(storage_path("app/public/{$product->product_picture}"))) {
                    File::delete(storage_path("app/public/{$product->product_picture}"));
                }
                $product->delete();

                return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
            }
        }
    }
}
