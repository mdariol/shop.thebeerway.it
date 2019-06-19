<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
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
        return view('role.index')->with('roles', Role::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Role::create(['name' => $request->name]);

        return redirect('/roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('role.edit')->with('role', $role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Role $role)
    {
        $role->update(request(['name']));

        return redirect('/roles');
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\Role  $area
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Role $role)
    {
        return view('role.delete')->with('role', $role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect('/roles');
    }
}
