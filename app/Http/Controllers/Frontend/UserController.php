<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\OrderNotification;
use App\Models\AvailableAddress;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDescription;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class UserController extends BaseController
{
    public function Add_to_cart(Request $request)
    {

        $product = Product::findOrfail($request->product_id);
        $oldCart = Cart::where('product_id', $request->product_id)->where('user_id', Auth::user()->id)->first();
        if ($oldCart) {
            $oldCart->quantity = $request->quantity + $oldCart->quantity;
            $oldCart->amount = $oldCart->quantity * $product->price;
            $oldCart->save();
            toast('Your Products Add to Cart', 'success');

            return redirect()->back();
        }
        $cart = new Cart();
        $cart->user_id = Auth::user()->id;
        $cart->product_id = $request->product_id;
        $cart->quantity = $request->quantity;
        $cart->amount = $product->price - ($product->price * $product->discount) / 100 * $request->quantity;
        $cart->save();
        toast('Your Products Add to Cart', 'success');

        return redirect()->back();
    }

    public function carts()
    {
        $user = User::find(Auth::user()->id);
        $carts = $user->carts()->with('product.shop')->get();

        // Filter carts to only include those with products from approved vendors
        $approvedCarts = $carts->filter(function ($cart) {

            return $cart->product && Shop::where('id', $cart->product->shop_id)->where('status', 'approved')->exists();
        });
        // If no approved carts, return empty viewp
        // Group the carts by vendor ID
        $groupedCarts = $approvedCarts->groupBy(function ($cart) {
            return $cart->product->shop_id;
        });
        // Get all unique vendor IDs and fetch vendors
        $vendorIds = $groupedCarts->keys();
        $vendors = Shop::whereIn('id', $vendorIds)->where('status', 'approved')->get();

        return view('frontend.carts', compact('vendors', 'groupedCarts'));
    }

    public function checkout($id)
    {
        // Get the vendor by ID (or fail)
        $vendor = Shop::where('id', $id)
            ->where('status', 'approved')
            ->firstOrFail();

        // Get authenticated user
        $user = User::find(Auth::user()->id);

        // Get all the user's cart items with related product and vendor


        // Filter the carts for this vendor only and only approved products/vendors
        $vendorCarts = $user->carts()
            ->whereHas('product.shop', function ($query) use ($id) {
                $query->where('id', $id)
                    ->where('status', 'approved');
            })
            ->with('product.shop')
            ->get();
        $addresses = AvailableAddress::where('shop_id', $id)->get();
        return view('frontend.checkout', compact('vendor', 'vendorCarts', 'addresses'));
    }

    public function order_store(Request $request, $id)
    {
        // Get the vendor by ID (or fail)
        $vendor = Shop::where('id', $id)
            ->where('status', 'approved')
            ->firstOrFail();

        // Get authenticated user
        $user = User::find(Auth::user()->id);

        // Get all the user's cart items with related product and vendor


        // Filter the carts for this vendor only and only approved products/vendors
        $vendorCarts = $user->carts()
            ->whereHas('product.shop', function ($query) use ($id) {
                $query->where('id', $id)
                    ->where('status', 'approved');
            })
            ->with('product.shop')
            ->get();

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->shop_id = $id;
        $order->payment_method = $request->payment;
        $order->address_note = $request->address_note;
        $order->available_address_id = $request->address;
        $order->contact = $request->contact;
        $address_price = AvailableAddress::find($request->address)->price ?? 0;
        $order->total_amount = $vendorCarts->sum('amount')+$address_price;
        $order->save();
        $products = [];

        foreach ($vendorCarts as $key => $cart) {
            $od = new OrderDescription();
            $od->product_id = $cart->product_id;
            $od->order_id = $order->id;
            $od->quantity = $cart->quantity;
            $od->amount = $cart->amount;
            $products[] = $cart->product->name;
            $od->save();
            $cart->delete(); // Remove the cart item after order is placed
        }
        if ($request->payment == 'Khalti') {
            Cookie::queue('order_id', $order->id);

            $response =  Http::withHeaders([
                "Authorization" => "Key " . env('KHALTI_SECRET_KEY')
            ])->post(env('KHALTI_BASE__URL') . "/epayment/initiate/", [
                "return_url" => env('KHALTI_RETURN_URL'),
                "website_url" => env('APP_URL'),
                "amount" => $order->total_amount * 100, // Convert to paisa
                "purchase_order_id" => $order->id,
                "purchase_order_name" => $products[0],
                "customer_info" => Auth::user()
            ]);

            return redirect($response['payment_url']);
        }elseif ($request->payment == 'esewa') {
            $message = $order->total_amount . $order->id . $order->shop->name;
            $signature = Base64_encode(hash_hmac('sha256', $message, "8gBm/:&EnhH.1/q", true));
            return view("frontend.esewa", compact('order', "signature"));
        } else {
            toast('Please Select Payment Method', 'error');
            return redirect()->back();
        }
        Mail::to($vendor)->send(new OrderNotification($order));
        toast('Your Order Placed Successfully', 'success');
        return redirect()->back();
    }

    public function khalti(Request $request)
    {
        $response =  Http::withHeaders([
                "Authorization" => "Key " . env('KHALTI_SECRET_KEY')
            ])->post(env('KHALTI_BASE__URL') . "/epayment/lookup/", [
                "pidx" => $request->pidx,
            ]);
        $orderId = Cookie::get("order_id");
        $order = Order::find($orderId);
        $order->payment_status = $response['status'];
        $order->save();
        return redirect('/');
    }
    public function success(Request $request)
    {
        $orderId = Cookie::get("order_id");
        $order = Order::find($orderId);
        $order->payment_status = "paid";
        $order->save();
        return redirect('/');
        return view('frontend.success');
    }
    public function failure(Request $request)
    {
        return view('error.404');
    }
}
