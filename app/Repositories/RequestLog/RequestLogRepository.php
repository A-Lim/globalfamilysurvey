<?php
namespace App\Repositories;

use Carbon\Carbon;
use App\RequestLog;

use Illuminate\Http\Request;

class RequestLogRepository implements RequestLogRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create($status, $params = null, $content) {
        $data = [
            'status' => $status,
            'params' => $params != null ? json_encode($params) : null,
            'content' => $content
        ];
        return RequestLog::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function total_count() {
        return RequestLog::count();
    }

    /**
     * {@inheritdoc}
     */
    public function today_count() {
        return RequestLog::whereDate('created_at', Carbon::today())->count();
    }

    /**
     * {@inheritdoc}
     */
    public function datatable_query() {
        return RequestLog::select('id', 'status', 'created_at');
    }
}
