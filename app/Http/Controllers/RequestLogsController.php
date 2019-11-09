<?php
namespace App\Http\Controllers;

use DataTables;
use App\Setting;
use App\RequestLog;

use App\Repositories\RequestLogRepositoryInterface;

class RequestLogsController extends Controller {
    private $requestLogRepository;

    public function __construct(RequestLogRepositoryInterface $requestLogRepositoryInterface) {
        $this->middleware('auth');
        $this->requestLogRepository = $requestLogRepositoryInterface;
    }

    public function show(RequestLog $requestLog) {
        $this->authorize('view', Setting::class);
        return view('requestlogs.show', compact('requestLog'));
    }

    public function stats() {
        $total_count = $this->requestLogRepository->total_count();
        $today_count = $this->requestLogRepository->today_count();
        return response()->json(['total_count' => $total_count, 'today_count' => $today_count]);
    }

    public function datatable() {
        $this->authorize('view', Setting::class);
        return Datatables::of($this->requestLogRepository->datatable_query())
            ->editColumn('id', function($requestLog) {
                return '<a href="/requestlogs/'.$requestLog->id.'">'.$requestLog->id.'</a>';
            })
            ->editColumn('status', function($requestLog) {
                $html = '';
                if ($requestLog->status == RequestLog::STATUS_ERROR) {
                    $html .= '<span class="label label-danger">'.RequestLog::STATUS_ERROR.'</span>';
                }

                if ($requestLog->status == RequestLog::STATUS_SUCCESS) {
                    $html .= '<span class="label label-success">'.RequestLog::STATUS_SUCCESS.'</span>';
                }
                return $html;
            })
            ->editColumn('created_at', function($requestLog) {
                return $requestLog->created_at->toDateTimeString();
            })
            ->rawColumns(['id', 'status'])
            ->make(true);
    }
}
