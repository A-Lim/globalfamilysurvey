<?php
namespace App\Repositories;

use App\Church;
use Illuminate\Http\Request;

interface ChurchRepositoryInterface
{
    /**
     * Retrieve all churches
     *
     * @return [Church]
     */
    public function all();

    /**
     * Retrieve church by id
     *
     * @param integer $id
     * @return Church
     */
    public function find($id);

    /**
     * Create church
     *
     * @param Request $request
     * @return Church
     */
    public function create(Request $request);


    /**
     * Retrieve church by id
     *
     * @param integer $id
     * @return Church
     */
    public function update(Church $church, Request $request);

    /**
     * Delete church
     *
     * @param Church $church
     * @return Church
     */
    public function delete(Church $church, $forceDelete = false);

    /**
     * Retrieve query for datatable
     *
     * @return QueryBuilder
     */
    public function datatable_query();
}
