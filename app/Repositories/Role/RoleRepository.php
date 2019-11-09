<?php
namespace App\Repositories;

use App\Role;

use Illuminate\Http\Request;

class RoleRepository implements RoleRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all() {
        return \Cache::rememberForEver(Role::CACHE_KEY, function() {
            return Role::all();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function create(Request $request) {
        \Cache::forget(Role::CACHE_KEY);
        return Role::create($request->all());
    }

    /**
     * {@inheritdoc}
     */
    public function update(Role $role, Request $request) {
        \Cache::forget(Role::CACHE_KEY);
        return $role->update($request->all());
    }

    /**
     * {@inheritdoc}
     */
    public function datatable_query() {
        return Role::with('permissions');
    }
}
