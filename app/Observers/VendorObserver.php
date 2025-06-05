<?php

namespace App\Observers;

use App\Mail\VendorApprovalNotification;
use App\Models\Admin;
use App\Models\Shop;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class VendorObserver
{
    /**
     * Handle the Shop "created" event.
     */
    public function created(Shop $vendor): void
    {
        //
    }

    /**
     * Handle the Shop "updated" event.
     */
    public function updated(Shop $vendor): void
    {
        if ($vendor->isDirty('status') && $vendor->status == 'approved') {
            $password = rand(11111, 99999);
            $vendor->password = Hash::make($password);
            $vendor->saveQuietly();
            Mail::to($vendor->email)->send(new VendorApprovalNotification($vendor, $password));
        }
    }

    /**
     * Handle the Shop "deleted" event.
     */
    public function deleted(Shop $vendor): void
    {
        //
    }

    /**
     * Handle the Shop "restored" event.
     */
    public function restored(Shop $vendor): void
    {
        //
    }

    /**
     * Handle the Shop "force deleted" event.
     */
    public function forceDeleted(Shop $vendor): void
    {
        //
    }
}
