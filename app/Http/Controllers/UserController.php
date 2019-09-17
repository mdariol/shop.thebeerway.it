<?php

namespace App\Http\Controllers;

use App\Rules\Password;
use App\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * CompanyController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index');

        return view('user.index')->with([
            'users' => User::queryFilter()->orderBy('name')->get(),
            'roles' => Role::all(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return view('user.show')->with(['user' => $user]);
    }

    /**
     * Assign user roles.
     *
     * @param  \App\User  $user
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function role(User $user)
    {
        $this->authorize('role');

        if (request()->has('role')){
            $user->assignRole(request()->role);

            return back();
        }

        $user->removeRole(request()->remove);

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('user.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\User  $user
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(User $user)
    {
        $this->authorize('update', $user);

        $user->update(request(['name','ishoreca','horecaname','vatnumber']));

        return redirect()->route('users.show', ['user' => $user->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(User $user)
    {
        $this->authorize('delete', $user);

        return view('user.delete')->with('user', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        // TODO: Implement soft delete.
        $this->authorize('delete', $user);

        $user->delete();

        return redirect('/users');
    }

    /**
     * Update the specified resource password in storage.
     *
     * @param  \App\User  $user
     *
     * @return \Illuminate\Http\Response
     */
    public function password(User $user)
    {
        request()->validate([
            'current_password' => ['required', 'string', new Password($user)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make(request()->password),
        ]);

        return back()->with('success', 'Password cambiata!');
    }
}
