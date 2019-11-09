<?php
namespace App\Repositories;

use Illuminate\Http\Request;

interface CountryRepositoryInterface
{
    /**
     * Retrieve all countries
     *
     * @return [Country]
     */
    public function all();


    /**
     * Retrieve all countries for select option
     *
     * @return [Country]
     */
    public function all_options();

    /**
     * Retrieve country by id
     *
     * @param integer $id
     * @return Country
     */
    public function find($id);
}
