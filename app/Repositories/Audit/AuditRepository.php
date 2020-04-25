<?php
namespace App\Repositories;

use App\Audit;
use Illuminate\Http\Request;

class AuditRepository implements AuditRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all() {
        return Audit::orderBy('created_at')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id) {
        return Audit::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create(Request $request, $module, $action, $old = null, $new = null) {
        $data = [
            'module' => $module,
            'action' => $action,
            'request_header' => json_encode($request->header()),
            'request_ip' => $request->ip(),
            'input' => json_encode($request->except([
                'password', 
                'old_password', 
                'new_password', 
                'password_confirmation',
                '_token',
                '_method',
            ])),
        ];

        if ($old != null)
            $data['old'] = json_encode($old);

        if ($new != null)
            $data['new'] = json_encode($new);

        if (auth()->user())
            $data['user_id'] = auth()->user()->id;

        $audit = Audit::create($data);
        return $audit;
    }


    public function datatable_query() {
        return Audit::leftjoin('users', 'audits.user_id', '=', 'users.id')
                ->select('audits.id', 'audits.user_id', 'users.email', 'audits.module', 'audits.action', 'audits.request_ip', 'audits.created_at');
    }
}
