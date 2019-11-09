<?php

namespace App\Http\Controllers;

use DataTables;
use App\Role;
// use App\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\Roles\CreateRequest;
use App\Http\Requests\Roles\UpdateRequest;

use App\Repositories\RoleRepositoryInterface;
use App\Repositories\PermissionRepositoryInterface;

class RolesController extends Controller
{
    private $roleRepository;
    private $permissionRepository;

    public function __construct(RoleRepositoryInterface $roleRepositoryInterface,
        PermissionRepositoryInterface $permissionRepositoryInterface) {
        $this->middleware('auth');
        $this->roleRepository = $roleRepositoryInterface;
        $this->permissionRepository = $permissionRepositoryInterface;
    }

    public function index() {
        $this->authorize('view', Role::class);
        $permissions = $this->permissionRepository->all();
        return view('roles.index', compact('permissions'));
    }

    public function create() {
        $this->authorize('create', Role::class);
        return view('roles.create');
    }

    public function store(CreateRequest $request) {
        $this->authorize('create', Role::class);
        $request->save();
        session()->flash('success', 'Role successfully created');
        return redirect('roles');
    }

    public function edit(Role $role) {
        $this->authorize('update', Role::class);
        return view('roles.edit', compact('role'));
    }

    public function update(UpdateRequest $request, Role $role) {
        $this->authorize('update', Role::class);
        $request->save();
        session()->flash('success', 'Role successfully updated');
        return redirect('roles');
    }

    public function destroy(Role $role) {
        $this->authorize('delete', Role::class);
        $role->delete();
        session()->flash('success', 'Role successfully deleted');
        return back();
    }

    public function datatable() {
        return Datatables::of($this->roleRepository->datatable_query())
        ->addIndexColumn()
        ->addColumn('access', function($role) {
            $html = '';
            if ($role->name == 'super_admin') {
                return '<span class="label label-success">full</span>';
            } else {
                if ($role->permissions->count() == 0)
                    return '<span class="label label-default">No permissions assigned</span>';

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

            if (auth()->user()->can('delete', Role::class) && $role->isDeletable()) {
                $html .= delete_button('roles', $role->id);
            }
            return $html;
        })
        ->rawColumns(['access', 'action'])
        ->make(true);
    }
}
