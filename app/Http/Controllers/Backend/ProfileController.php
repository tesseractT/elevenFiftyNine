<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;


class ProfileController extends Controller
{
    public function index(): View
    {
        return view('admin.profile.index');
    }

    /**
     * Update the user's profile
     *
     * @param Request $request
     * @return RedirectResponse
     */

    public function updateProfile(Request $request)
    {


        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'unique:users,email,' . Auth::user()->id],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $user = Auth::user();

        if ($request->hasFile('image')) {
            File::exists(public_path($user->image)) ? File::delete(public_path($user->image)) : null;
            $image = $request->image;
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);

            $path = "/uploads/" . $imageName;

            $user->image = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        toastr()->success('Profile updated successfully!');
        return redirect()->back();
    }

    /**
     * Update the user's password
     *
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
