<?php
namespace App\Repositories;

use App\RequestLog;
use Illuminate\Http\Request;

interface RequestLogRepositoryInterface
{
    /**
     * Create request log
     *
     * @param $status - 'success' / 'error'
     * @param $query - query parameters
     * @param $content - content of returned api in json format
     * @return RequestLog
     */
    public function create($status, $params, $content);

    /**
     * Return total requestlog count
     *
     * @return integer
     */
    public function total_count();

    /**
     * Return total requestlog count for today
     *
     * @return integer
     */
    public function today_count();

    /**
     * Query for datatable
     *
     * @return QueryBuilder
     */
    public function datatable_query();
}
