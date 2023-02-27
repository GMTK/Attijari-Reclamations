<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return Inertia::render('Gestion/Roles/indexRoles', ['roles' => $roles, 'permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(StoreRoleRequest $request)
    {

        $request->validate([
            'title' => 'required',
            'permissions' => 'required', 'Array'
        ]);

        $role = new Role();
        $role->title = $request->title;
        $role->save();

        $role->permissions()->sync($request->input('permissions', []));

        return redirect()->route('gestion.roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'permissions' => 'required', 'Array'
        ]);

        $role = Role::findOrFail($id);
        $role->title = $request->title;
        $role->save();

        $role->permissions()->sync($request->input('permissions', []));
    }


    public function destroy($id)
    {
        Role::find($id)->delete();

        return redirect()->route('gestion.roles');
    }
}
