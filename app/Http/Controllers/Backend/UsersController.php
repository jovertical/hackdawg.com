<?php

namespace App\Http\Controllers\Backend;

use App\Models\Country;
use App\Models\User;
use Inertia\Inertia;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Users/List', [
            'users' => User::with('roles')->paginate(5),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Users/Create', [
            'countries' => Country::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store()
    {
        $this->validate(request(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
        ]);

        User::create(request([
            'first_name',
            'last_name',
            'email',
            'country',
            'state',
            'city',
            'street_address',
            'postal_code',
        ]));

        // TODO: Send an email for the user to set their password.

        return redirect()->route('backend.users.index')->with('message', [
            'title' => 'Success!',
            'body' => 'User created.',
            'variant' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Inertia\Response
     */
    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'countries' => Country::all(),
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(User $user)
    {
        $this->validate(request(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $user->update(request([
            'first_name',
            'last_name',
            'email',
            'country',
            'state',
            'city',
            'street_address',
            'postal_code',
        ]));

        return redirect()->route('backend.users.index')->with('message', [
            'title' => 'Success!',
            'body' => 'User details updated.',
            'variant' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('message', [
            'title' => 'Success!',
            'body' => 'User deleted.',
            'variant' => 'success',
        ]);
    }
}