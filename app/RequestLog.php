<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model {
    protected $fillable = ['status', 'params', 'content', 'created_at', 'updated_at'];

    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';

    const DAILY_LIMIT = 500;
}
