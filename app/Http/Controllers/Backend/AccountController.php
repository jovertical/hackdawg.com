<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Rules\OldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AccountController extends Controller
{
    /**
     * Show the user's account page.
     *
     * @return \Inertia\Response
     */
    public function showAccountPage()
    {
        return Inertia::render('Account', [
            'countries' => Country::all(),
        ]);
    }

    /**
     * Handle a request to update the user's profile.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function updateProfile()
    {
        $this->validate(request(), [
            'website' => 'nullable|url',
            'avatar' => 'image|max:2048',
        ]);

        Auth::user()->update(request(['job_title', 'company', 'website', 'about']));

        if (request()->hasFile('avatar')) {
            Auth::user()
                ->addMedia(request()->file('avatar'))
                ->toMediaCollection('avatars');
        }

        return back()->with('message', [
            'title' => 'Succesfully saved!',
            'body' => 'Profile information updated.',
            'variant' => 'success',
        ]);
    }

    /**
     * Handle a request to update the user's personal information.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updatePersonal()
    {
        $this->validate(request(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
        ]);

        Auth::user()->update(request([
            'first_name',
            'last_name',
            'email',
            'country',
            'state',
            'city',
            'street_address',
            'postal_code',
        ]));

        return back()->with('message', [
            'title' => 'Succesfully saved!',
            'body' => 'Personal information updated.',
            'variant' => 'success',
        ]);
    }

    /**
     * Handle a request to update the user's password.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updatePassword()
    {
        $this->validate(request(), [
            'old_password' => ['required', new OldPassword(Auth::user()->password)],
            'new_password' => 'required|min:8',
        ]);

        Auth::user()->update([
            'password' => Hash::make(request('new_password')),
        ]);

        return back()->with('message', [
            'title' => 'Succesfully saved!',
            'body' => 'Password updated.',
            'variant' => 'success',
        ]);
    }
}
