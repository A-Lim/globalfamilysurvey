<?php
namespace App\Repositories;

use Illuminate\Http\Request;

interface PermissionRepositoryInterface
{
    /**
     * Retrieve all permissions
     *
     * @return [Permission]
     */
    public function all();
}
