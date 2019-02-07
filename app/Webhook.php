<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    protected $guarded = [];

    const EVENT_RESPONSE_COMPLETED = 'response_completed';
    const EVENT_RESPONSE_DISQUALIFIED = 'response_disqualified';
    const EVENT_RESPONSE_UPDATED = 'response_updated';
    const EVENT_RESPONSE_CREATED = 'response_created';
    const EVENT_RESPONSE_DELETED = 'response_deleted';
    const EVENT_RESPONSE_OVERQUOTA = 'response_overquota';
    const EVENT_SURVEY_CREATED = 'survey_created';
    const EVENT_SURVEY_UPDATED = 'survey_updated';
    const EVENT_SURVEY_DELETED = 'survey_deleted';
    const EVENT_COLLECTOR_CREATED = 'collector_created';
    const EVENT_COLLECTOR_UPDATE = 'collector_updated';
    const EVENT_COLLECTOR_DELETED = 'collector_deleted';
    const EVENT_APP_INSTALLED = 'app_installed';
    const EVENT_APP_UNINSTALLED = 'app_uninstalled';

    const TYPE_SURVEY = 'survey';

    const EVENTS = [
        self::EVENT_RESPONSE_COMPLETED,
        self::EVENT_RESPONSE_DISQUALIFIED,
        self::EVENT_RESPONSE_UPDATED,
        self::EVENT_RESPONSE_CREATED,
        self::EVENT_RESPONSE_DELETED,
        self::EVENT_RESPONSE_OVERQUOTA,
        self::EVENT_SURVEY_CREATED,
        self::EVENT_SURVEY_UPDATED,
        self::EVENT_RESPONSE_DELETED,
        self::EVENT_RESPONSE_OVERQUOTA,
        self::EVENT_SURVEY_CREATED,
        self::EVENT_SURVEY_UPDATED,
        self::EVENT_SURVEY_DELETED,
        self::EVENT_COLLECTOR_CREATED,
        self::EVENT_COLLECTOR_UPDATE,
        self::EVENT_COLLECTOR_DELETED,
        self::EVENT_APP_INSTALLED,
        self::EVENT_APP_UNINSTALLED
    ];

    const TYPES = [
        self::TYPE_SURVEY
    ];

    public function survey() {
        return $this->hasOne(Survey::class);
    }
}
