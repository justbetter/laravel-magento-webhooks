<?php

namespace JustBetter\MagentoWebhooks\Actions;

use Illuminate\Support\Carbon;
use JustBetter\MagentoWebhooks\Contracts\CleansLogs;
use JustBetter\MagentoWebhooks\Models\EventLog;

class CleanLogs implements CleansLogs
{
    public function clean(Carbon $date): void
    {
        EventLog::query()
            ->where('created_at', '<', $date)
            ->delete();
    }

    public static function bind(): void
    {
        app()->singleton(CleansLogs::class, static::class);
    }
}
