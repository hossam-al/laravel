<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function index()
    {

        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        return view('paymob.profile.profile', compact('user'));
    }
    public function edit(Request $request): View
    {
        return view('paymob.profile.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.index')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function change_image(Request $request, $id)
    {
        $miga = 1024 * 2;
        $request->validate(['image' => "required|file|mimes:png,jpg,jpeg,webp|max:$miga"]);

        $users = User::find($id);

        if ($users->image == null) {
            $image_data = $request->file('image');
            $image_getname = $image_data->getClientOriginalName();
            $image_folder_patch = public_path('upload/');
            $image_data->move($image_folder_patch, $image_getname);
            $users->update(['image' =>  $image_getname]);
        } else {
            $old_image = $users->image;
            $old_pacth = public_path('upload/') .  $old_image;
            unlink($old_pacth);
            $image_data = $request->file('image');
            $image_getname = $image_data->getClientOriginalName();
            $image_folder_patch = public_path('upload/');
            $image_data->move($image_folder_patch, $image_getname);
            $users->update(['image' =>  $image_getname]);
        }


        return redirect()->back()->with('success', 'Change Image Success');
    }

    public function delete_image($id)
    {
        $user = User::find($id);


        if ($user->image == null) {
            return redirect()->back()->with('error', 'the image olrady deleted');
        } else {
            $old_image = $user->image;
            $old_pacth = public_path('upload/') .  $old_image;
            unlink($old_pacth);
            $user->update(['image' => null]);
            return redirect()->back();
        }
    }
    public function settings()
    {
        return view('paymob.profile.settings');
    }
}
