<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CartController extends Controller
{
    // function adding to cart
    public function AddToCartRequest(Request $request)
    {
        // check if auth the user before adding to cart
        if (!Auth::check()) {
            return redirect()->route('loginpage')->with('error', 'Please log in first');
        }

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer_id = auth()->id();
        $product = Product::find($request->product_id);

        // check if there's product stocks
        if ($product->product_stocks < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient product stocks');
        }

        $existing_cart_item = Cart::where('customer_id', $customer_id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing_cart_item) {
            $existing_cart_item->increment('quantity', $request->quantity);

            // decrease product stocks
            $product->decrement('product_stocks', $request->quantity);
        } else {
            Cart::create([
                'customer_id' => $customer_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);

            // decrease product stocks
            $product->decrement('product_stocks', $request->quantity);
        }

        // update the products status logic
        if ($product->product_stocks >= 5) {
            $product->update(['product_status' => 'Available']);
        } elseif ($product->product_stocks >= 1 && $product->product_stocks <= 4) {
            $product->update(['product_status' => 'Low stocks']);
        } else {
            $product->update(['product_status' => 'Not Available']);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully');
    }

    // view cart of the user that is authenticated
    public function ViewCart()
    {
        $customer_id = auth()->id();

        $cart_items = Cart::where('customer_id', $customer_id)->with('product')->get();

        $total = 0;

        foreach ($cart_items as $cart) {
            $subtotal = $cart->quantity * $cart->product->product_price;
            $total += $subtotal;
        }

        View::share('cart_items', $cart_items);
        View::share('total', $total);

        return view('page.cart', compact('cart_items', 'total'));
    }

    // update the quantity in the cart
    public function UpdateQuantityCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartId' => 'required|exists:carts,id',
            'productId' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => 401
            ]);
        }

        $cart = Cart::find($request->cartId);

        if (!$cart || $cart->customer_id !== auth()->id() || $cart->product_id != $request->productId) {
            return response()->json([
                'message' =>
                'Invalid cart item',
                'status' => 400
            ]);
        }

        $product = Product::find($request->productId);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
                'status' => 404
            ]);
        }

        $quantityDifference = $request->quantity - $cart->quantity;

        if ($product->product_stocks - $quantityDifference < 0) {
            return response()->json([
                'message' => 'Insufficient product stocks',
                'status' => 400
            ]);
        }

        $cart->quantity = $request->quantity;
        $cart->save();

        $product->decrement('product_stocks', $quantityDifference);

        // update the products status logic
        if (
            $product->product_stocks >= 5
        ) {
            $product->update(['product_status' => 'Available']);
        } elseif ($product->product_stocks >= 1 && $product->product_stocks <= 4) {
            $product->update(['product_status' => 'Low stocks']);
        } else {
            $product->update(['product_status' => 'Not Available']);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Quantity updated successfully'
        ]);
    }



    // deleting the cart of the user that is authenticated
    public function DeleteCart($cart_id)
    {
        $customer_id = auth()->id();

        $cart_item = Cart::where('id', $cart_id)
            ->where('customer_id', $customer_id)
            ->first();

        if (!$cart_item) {
            return response()->json(['error' => 'Cart item not found'], 404);
        }

        // returning the quantity to its related product stocks 
        $product = $cart_item->product;

        if ($product) {
            $product->increment('product_stocks', $cart_item->quantity);
            $cart_item->delete();

            // update the products status logic
            if ($product->product_stocks >= 5) {
                $product->update(['product_status' => 'Available']);
            } elseif ($product->product_stocks >= 1 && $product->product_stocks <= 4) {
                $product->update(['product_status' => 'Low stocks']);
            } else {
                $product->update(['product_status' => 'Not Available']);
            }

            return response()->json(['message' => 'Cart item deleted successfully']);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    public function DeleteAllCart()
    {
        $customer_id = auth()->id();

        $cart_items = Cart::where('customer_id', $customer_id)->with('product')->get();

        foreach ($cart_items as $cart_item) {
            $cart_item->product->increment('product_stocks', $cart_item->quantity);
            $cart_item->delete();
        }

        if (isset($cart_item->product)) {
            $product = $cart_item->product;

            if ($product->product_stocks >= 5) {
                $product->update(['product_status' => 'Available']);
            } elseif ($product->product_stocks >= 1 && $product->product_stocks <= 4) {
                $product->update(['product_status' => 'Low stocks']);
            } else {
                $product->update(['product_status' => 'Not Available']);
            }
        }
        return response()->json(['message' => 'All cart items deleted successfully']);
    }
}
