<?php

namespace JustBetter\MagentoWebhooks\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;
use JustBetter\MagentoWebhooks\Contracts\CleansLogs;

class CleanLogsJob implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(
        protected Carbon $date,
    ) {
        $this->onQueue(config('magento-webhooks.queue.default'));
    }

    public function handle(CleansLogs $contract): void
    {
        $contract->clean($this->date);
    }
}
