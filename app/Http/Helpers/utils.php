<?php

use App\ErrorLog;

function log_error($action, $error) {
    ErrorLog::create([
        'action' => $action,
        'error' => $error,
    ]);
}
