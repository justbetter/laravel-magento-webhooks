<?php

namespace JustBetter\MagentoWebhooks\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $event
 * @property ?array $data
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class EventLog extends Model
{
    protected $table = 'magento_webhooks_event_logs';

    protected $guarded = [];

    protected $casts = [
        'data' => 'array',
    ];
}
