<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\VendorRequestNotification;
use App\Models\Admin;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PageController extends BaseController
{
    public function home()
    {
        return view('frontend.home');
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
}
