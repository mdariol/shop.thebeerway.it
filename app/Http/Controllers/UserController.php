<?php

namespace App\Http\Controllers;

use App\Events\Autorized;
use App\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index')->with([
            'users' => User::all(),
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
     * @return \Illuminate\Http\Response
     */
    public function roleassign()
    {
        $user = User::find(request()->assign_user);

        $user->syncRoles(request()->roles);

        if ($user->hasanyrole('Publican|Admin|Distributor')) {
            event(new Autorized($user));
        }

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
}
