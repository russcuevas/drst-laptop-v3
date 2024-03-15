<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\OrderDetails;
use App\Models\OrderInitialStatus;
use App\Models\Orders;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    // checkout page
    public function CheckoutPage(Request $request)
    {
        // getting the customer id with the selected products array
        $customer_id = Auth::id();
        $selectedProductIds = $request->input('selected_products', []);

        // condition if empty or if it has a selected product to proceed
        if (empty($selectedProductIds)) {
            return redirect()->route('homepage')->with(['error' => 'Please select at least one product.']);
        }

        // loop
        $cart_items = Cart::where('customer_id', $customer_id)
            ->whereIn('id', $selectedProductIds)
            ->with('product')
            ->get();

        $total = 0;

        foreach ($cart_items as $cart) {
            $subtotal = $cart->quantity * $cart->product->product_price;
            $total += $subtotal;
        }

        return view('page.checkout', compact('cart_items', 'total', 'selectedProductIds'));
    }


    // checkout request
    public function CheckoutRequest(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string',
            'address' => 'required|string',
            'contact' => 'required|string',
            'email' => 'required|email',
            'product_details' => 'required|array',
            'customer_id' => 'required|array',
            'product_id' => 'required|array',
            'subtotal' => 'required|array',
            'total_amount' => 'required|array',
            'total_quantity' => 'required|array',
            'payment_method' => 'required|string',
        ]);

        $productDetails = $request->input('product_details');

        $customerIds = $request->input('customer_id');
        $productIds = $request->input('product_id');
        $subtotals = $request->input('subtotal');
        $totalAmounts = $request->input('total_amount');
        $totalQuantities = $request->input('total_quantity');

        $generateReferenceNumber = $this->generateReferenceNumber();
        $generateInvoiceNumber = $this->generateInvoiceNumber();

        // iterate
        foreach ($customerIds as $key => $customerId) {
            // Create and save order details
            $orderDetails = new OrderDetails([
                'fullname' => $request->input('fullname'),
                'address' => $request->input('address'),
                'contact' => $request->input('contact'),
                'email' => $request->input('email'),
                'products_ordered' => $productDetails[$key],
                'customer_id' => $customerId,
                'product_id' => $productIds[$key],
                'subtotal' => $subtotals[$key],
                'total_amount' => $totalAmounts[$key],
                'total_quantity' => $totalQuantities[$key],
            ]);
            $orderDetails->save();

            // get the id of the save order details
            $orderDetailsId = $orderDetails->id;

            // create and save orders
            $order = new Orders([
                'reference_number' => $generateReferenceNumber,
                'invoice_number' => $generateInvoiceNumber,
                'payment_method' => $request->input('payment_method'),
                'order_details_id' => $orderDetailsId,
            ]);
            $order->save();

            // get the id of the saved order
            $orderId = $order->id;

            // create and save order status
            $orderStatus = new OrderStatus([
                'status' => 'Placed orders',
                'order_id' => $orderId,
            ]);
            $orderStatus->save();

            // get the id of the saved order status
            $orderStatusId = $orderStatus->id;

            // create and save order initial status
            $orderInitialStatus = new OrderInitialStatus([
                'initial_status' => 'Placed orders',
                'status_id' => $orderStatusId,
                'placed_at' => now(),
            ]);
            $orderInitialStatus->save();

            // remove or delete the selected ordered product in the cart of the customer/users..
            $orderedProductIds = is_array($productIds[$key]) ? $productIds[$key] : [$productIds[$key]];

            Cart::where('customer_id', $customerId)
                ->whereIn('product_id', $orderedProductIds)
                ->delete();
        }

        return redirect()->route('homepage')->with('success', 'Orders placed successfully!');
    }

    // function generating reference number
    public function generateReferenceNumber()
    {
        return 'REF' . date('YmdHis') . mt_rand(1000, 9999);
    }

    // function generating invoice number
    public function generateInvoiceNumber()
    {
        return 'INV' . date('YmdHis') . mt_rand(1000, 9999);
    }
}
