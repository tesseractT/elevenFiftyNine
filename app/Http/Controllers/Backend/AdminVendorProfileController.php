<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorProfileStoreRequest;
use App\Models\Vendor;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminVendorProfileController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile = Vendor::where('user_id', Auth::user()->id)->first();
        return view('admin.vendor-profile.index', compact('profile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param VendorProfileStoreRequest $vendorProfileStoreRequest
     * @return RedirectResponse
     */
    public function store(VendorProfileStoreRequest $vendorProfileStoreRequest)
    {

        $vendor = Vendor::where('user_id', Auth::user()->id)->first();
        $bannerPath = $this->updateImage($vendorProfileStoreRequest, 'banner', 'uploads', $vendor->banner);


        $vendor->banner = empty(!$bannerPath) ? $bannerPath : $vendor->banner;
        $vendor->phone = $vendorProfileStoreRequest->phone;
        $vendor->email = $vendorProfileStoreRequest->email;
        $vendor->address = $vendorProfileStoreRequest->address;
        $vendor->description = $vendorProfileStoreRequest->description;
        $vendor->fb_link = $vendorProfileStoreRequest->fb_link;
        $vendor->twitter_link = $vendorProfileStoreRequest->twitter_link;
        $vendor->insta_link = $vendorProfileStoreRequest->insta_link;
        $vendor->save();

        toastr()->success('Profile updated successfully');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
