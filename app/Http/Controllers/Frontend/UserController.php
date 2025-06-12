<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AvailableAddress;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    public function Add_to_cart(Request $request)
    {

        $product = Product::findOrfail($request->product_id);
        $oldCart = Cart::where('product_id', $request->product_id)->where('user_id',Auth::user()->id)->first();
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
        $cart->amount = $request->quantity * $product->price;
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
        return $request;
        return view('frontend.checkout', compact('vendor', 'vendorCarts', 'addresses'));
    }
}
