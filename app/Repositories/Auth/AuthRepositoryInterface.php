<?php
namespace App\Repositories;

use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    /**
     * Register user
     *
     * @param Request $request
     * @param string $password
     * @return User
     */
    public function register_user(Request $request, $password);

    /**
     * Register church + user
     *
     * @param Request $request
     * @param string $password
     * @return User
     */
    public function register_church(Request $request, $password);

    /**
     * Register network
     *
     * @param Request $request
     * @param string $password
     * @return User
     */
    public function register_network(Request $request, $password);
}
