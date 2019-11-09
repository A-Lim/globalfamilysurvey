<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\User;

interface UserRepositoryInterface
{
    /**
     * Update user
     *
     * @param User $user
     * @param Request $request
     * @return null
     */
    public function update(User $user, Request $request);

    /**
     * Delete user
     *
     * @param User $user
     * @param bool $forceDelete - Permanently delete
     * @return null
     */
    public function delete(User $user, $forceDelete = false);

    /**
     * Retrieve all users
     *
     * @return [User]
     */
    public function all();

    /**
     * Retrieve all user by id
     *
     * @param int $id
     * @return User
     */
    public function find($id);

    /**
     * Retrieve query for datatable
     *
     * @return QueryBuilder
     */
     public function datatable_query();
}
