<?php

namespace App\Http\Controllers;

use DataTables;
use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;

class RolesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show settings page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->authorize('view', Role::class);
        $permissions = Permission::all();
        return view('roles.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->authorize('create', Role::class);
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request) {
        $this->authorize('create', Role::class);
        $request->save();
        session()->flash('success', 'Role successfully created');
        return redirect('roles');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role) {
        $this->authorize('update', Role::class);
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\RoleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role) {
        $this->authorize('update', Role::class);
        $request->save();
        session()->flash('success', 'Role successfully updated');
        return redirect('roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role) {
        $this->authorize('delete', Role::class);
        $role->delete();
        session()->flash('success', 'Role successfully deleted');
        return back();
    }

    public function datatable() {
        return Datatables::of(Role::with('permissions'))
        ->addIndexColumn()
        ->addColumn('access', function($role) {
            $html = '';
            if ($role->name == 'super_admin') {
                return '<span class="label label-success">full</span>';
            } else {
                if ($role->permissions->count() == 0)
                    return '<span class="badge">No permissions assigned</span>';

                foreach ($role->permissions as $permission) {
                    $html .= '<span class="label label-'.tag_type_for_permisson($permission->name).'">'.$permission->label.'</span> ';
                }
            }
            return $html;
        })
        ->addColumn('action', function($role) {
            $html = '';
            if ($role->name == 'super_admin')
                return;

            if (auth()->user()->can('update', Role::class)) {
                $html .= edit_button('roles', $role->id).' ';
            }

            if (auth()->user()->can('delete', Role::class)) {
                $html .= delete_button('roles', $role->id);
            }
            return $html;
        })
        ->rawColumns(['access', 'action'])
        ->make(true);
    }
}
