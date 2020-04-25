<?php
namespace App\Repositories;

use App\Audit;
use Illuminate\Http\Request;

interface AuditRepositoryInterface
{
    /**
     * Retrieve all categories
     *
     * @return [Audit]
     */
    public function all();

    /**
     * Retrieve audit by id
     *
     * @param integer $id
     * @return Audit
     */
    public function find($id);


    /**
     * Create audit
     *
     * @param Request $request
     * @param string $module
     * @param string $action
     * @return Audit
     */
    public function create(Request $request, $module, $action);
}
