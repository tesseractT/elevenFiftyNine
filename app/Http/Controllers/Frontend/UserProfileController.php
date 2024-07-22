<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserProfileController extends Controller
{
    /**
     * Display user profile
     * @return View
     */
    public function index()
    {
        return view('frontend.dashboard.profile');
    }

    /**
     * Update user profile
     * @param Request $request
     * @return RedirectResponse
     */

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . Auth::user()->id],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = Auth::user();

        if ($request->hasFile('image')) {
            if (File::exists(public_path($user->image))) {

                File::delete(public_path($user->image));
            }

            $image = $request->image;
            $imageName = time() . '_' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);

            $path = 'uploads/' . $imageName;
            $user->image = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        toastr()->success('Profile updated successfully');

        return redirect()->back();
    }

    /**
     * Update user password
     * @param Request $request
     * @return RedirectResponse
     */

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password),
        ]);

        toastr()->success('Password updated successfully!');
        return redirect()->back();
    }
}
