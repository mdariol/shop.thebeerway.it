<?php

namespace App\Http\Controllers;

use App\Rules\Password;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Validation rules.
     */
    const RULES = [
        'name' => ['required', 'string', 'max:255', 'min:3'],
    ];

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

        $user->update(request()->validate(self::RULES) + [
            'is_horeca' => request()->has('is_horeca')
        ]);

        if (request()->has('profile_image')) {
            $this->upload('profile_image', $user);
        }

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

    /* ----------------------------------------------------------------------
        Helper
       ---------------------------------------------------------------------- */

    protected function upload(string $file, User $user)
    {
        request()->validate([$file => ['image', 'max:1024']]);

        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $name = request()->file($file)->hashName();
        $name = str_replace(pathinfo($name, 4), 'jpg', $name);

        $file = Image::make(request()->file($file))->fit(500)
            ->encode('jpg', 75);

        Storage::disk('public')->put("profile_images/$name", $file);

        $user->update(['profile_image' => "profile_images/$name"]);
    }
}
