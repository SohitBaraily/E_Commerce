<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\VendorRequestNotification;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PageController extends BaseController
{
    public function home()
    {
        $vendors = Shop::where('status', 'approved')->where('expire_date', '>', now())->get();
        return view('frontend.home', compact('vendors'));
    }
    public function vendor_request(Request $request )
    {
        $request->validate([
            'name' => "required|max:50",
            'email' => "required|unique:shops|max:60|email",
            'contact_no' => "required|max:20",
            'address' => "required|max:60",

        ]);
        $vendor = new Shop();
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->contact_no = $request->contact_no;
        $vendor->address = $request->address;
        $vendor->password = Hash::make('12345678');
        $vendor->save();
        $admins = Admin::all();
        Mail::to($admins)->send(new VendorRequestNotification($vendor));
        toast('Your request has been successfully submitted', 'success');
        return redirect()->back();
    }

    public function shop($id)
    {
        $vendor = Shop::where('status', 'approved')->where('id', $id)->first();
        if(!$vendor){
            return view("error.404");
        }
        $products = $vendor->products()->where('status', true)->get();
        return view('frontend.vendor', compact('vendor', 'products'));
    }
    public function product($id)
    {
        $product = Product::where('status', true)->where('id', $id)->first();
        if(!$product){
            return view("error.404");
        }
        return view('frontend.product', compact('product'));
    }

    public function compare(Request $request)
    {
        $q = $request->q;
        $product = Product::where('name','like', "%$q%")->get();
    }
}
