<?php
namespace App\Repositories;

use App\Permission;

use Illuminate\Http\Request;

class PermissionRepository implements PermissionRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all() {
        return \Cache::rememberForEver(Permission::CACHE_KEY, function() {
            return Permission::all();
        });
    }
}
