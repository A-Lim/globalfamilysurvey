<?php
namespace App\Repositories;

use Illuminate\Http\Request;

interface NetworkRepositoryInterface
{
    /**
     * Retrieve all networks
     *
     * @return [Network]
     */
    public function all();

    /**
     * Retrieve network by id
     *
     * @param integer $id
     * @return Network
     */
    public function find($id);
}
