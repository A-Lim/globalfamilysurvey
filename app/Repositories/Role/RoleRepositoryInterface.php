<?php
namespace App\Repositories;

use App\Role;
use Illuminate\Http\Request;

interface RoleRepositoryInterface
{
    /**
     * Retrieve all roles
     *
     * @return [Role]
     */
    public function all();

    /**
     * Create role
     *
     * @param Request $request
     * @return Role
     */
    public function create(Request $request);

    /**
     * Retrieve all roles
     *
     * @param Role $role
     * @param Request $request
     * @return null
     */
    public function update(Role $role, Request $request);

    /**
     * Query for datatable
     *
     * @return QueryBuilder
     */
    public function datatable_query();
}
