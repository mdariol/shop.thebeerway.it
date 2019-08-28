<?php

namespace App\Http\Controllers;

use App\Events\Autorized;
use App\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin')->except('edit', 'update');
    }

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
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit')->with('user', $user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        $user->update(request(['name','ishoreca','horecaname','vatnumber']));

        return redirect(  auth()->user()->hasrole('Admin') ? '/users' : '/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function delete(User $user)
    {
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
        $user->delete();

        return redirect(  '/users' );
    }
}
