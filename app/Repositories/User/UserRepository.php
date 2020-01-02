<?php
namespace App\Repositories;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function update(User $user, Request $request) {
        $data = $request->all();

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }
        
        $user->fill($data);
        $user->update();

        if (auth()->user()->hasRole('super_admin') && $request->filled('role_id')) {
            $user->roles()->sync([$request->role_id]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete(User $user, $forceDelete = false) {
        if ($forceDelete)
            $user->forceDelete();
        else
            $user->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function all() {
        return User::all();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id) {
        return User::find($id);
    }

    /**
     * {@inheritdoc}
     */
     public function datatable_query() {
         // build query
         return User::leftJoin('churches', 'churches.id', '=', 'users.church_id')
             ->join('role_user', 'role_user.user_id', '=', 'users.id')
             ->join('roles', 'roles.id', '=', 'role_user.role_id')
             ->where('users.deleted_at', null)
             ->whereNotIn('users.id', [auth()->user()->id])
             ->select('users.id', 'users.name', 'users.email', 'roles.label as role', 'churches.uuid as church_uuid', 'churches.network_uuid as network_uuid');
     }
}
