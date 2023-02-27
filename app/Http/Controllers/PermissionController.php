<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionController extends Controller
{

    public function index()
    {
        $permissions = Permission::all();

        return Inertia::render('Gestion/Permissions/indexPermissions', ['permissions_list' => $permissions]);
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

    public function store(StorePermissionRequest $request)
    {

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $perm = new Permission();
        $perm->title = $request->title;
        $perm->description = $request->description;
        $perm->save();

        //$user->roles()->sync($request->input('roles', []));


        return redirect()->route('gestion.permissions');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
