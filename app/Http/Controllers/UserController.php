<?php

namespace App\Http\Controllers;


use App\Events\Autorized;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Control if is Admin role defined in middleware.
     *
     * @return \Illuminate\Http\Response
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
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        return view('user.edit')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, user $user)
    {
        $user->update(request(['name','ishoreca','horecaname','vatnumber']));

        return redirect(  $user->hasrole('Admin') ? '/users' : '/');
    }



}
