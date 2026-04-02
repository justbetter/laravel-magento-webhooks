<?php

declare(strict_types=1);

namespace JustBetter\MagentoWebhooks\Contracts;

use Illuminate\Support\Carbon;

interface CleansLogs
{
    public function clean(Carbon $date): void;
}
