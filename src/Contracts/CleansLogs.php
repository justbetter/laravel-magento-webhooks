<?php

namespace JustBetter\MagentoWebhooks\Contracts;

use Illuminate\Support\Carbon;

interface CleansLogs
{
    public function clean(Carbon $date): void;
}
