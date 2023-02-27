<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttributeUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
//        //abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//
//
        $roles = Role::with('permissions')->get();
        $users = User::with('roles')->get();
        return Inertia::render('Gestion/Users/indexUsers', ['users_list' => $users, 'roles' => $roles]);
    }

    public function Attribute(AttributeUserRequest $request)
    {

        $request->validate([
            'roles' => 'required',
            'permissions' => 'required',
        ]);

        $user = User::findOrFail($request->id);
        $user->roles()->sync($request->input('roles', []));
        $user->permissions()->sync($request->input('permissions', []));

        return redirect()->route('gestion.users');
    }

    public function store(StoreUserRequest $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'confirmed'],
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();


        return redirect()->route('gestion.users');
    }

    public function show($id)
    {
        //abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //return view('users.show', compact('user'));

        $users = User::with('roles')->get();

        $user = User::find($id);

        $user->load('roles');

        return Inertia::render('Gestion/Users/showUsers', ['user_details' => $user, 'users_list' => $users]);


    }
//
    public function edit($id)
    {
        //abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::with('roles')->get();

        //$roles = Role::pluck('title', 'id');

        $user = User::find($id);

        return Inertia::render('Gestion/Users/editUsers', ['user_edit' => $user, 'users_list' => $users]);
    }
//
    public function update(UpdateUserRequest $request, int $id)
    {

        $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
            ]
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        //$user->roles()->sync($request->input('roles', []));

        return redirect()->route('gestion.users');
    }
//
    public function destroy($id)
    {
        //abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        User::find($id)->delete();

        return redirect()->route('gestion.users');
    }
}
