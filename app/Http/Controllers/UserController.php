<?php

namespace App\Http\Controllers;


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
        $this->middleware('admin');
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
        return back();
    }



}
