<?php

namespace App\Http\Controllers;

use App\Audit;
use DataTables;
use Illuminate\Http\Request;

use App\Repositories\AuditRepositoryInterface;

class AuditsController extends Controller {

    private $auditRepository;

    public function __construct(AuditRepositoryInterface $auditRepositoryInterface) {
        $this->middleware('auth');
        $this->auditRepository = $auditRepositoryInterface;
    }

    public function index() {
        $this->authorize('view', Audit::class);
        return view('audits.index');
    }

    public function show(Audit $audit) {
        $this->authorize('view', Audit::class);
        return view('audits.show', compact('audit'));
    }

    public function datatable() {
        return Datatables::of($this->auditRepository->datatable_query())
            ->addIndexColumn()
            ->addColumn('actions', function($audit) {
                $html = '';
                if (auth()->user()->can('view', Audit::class)) {
                    $html .= view_button('audits', $audit->id).' ';
                }
                return $html;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
