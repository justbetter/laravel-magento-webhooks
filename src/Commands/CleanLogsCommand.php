<?php

namespace JustBetter\MagentoWebhooks\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use JustBetter\MagentoWebhooks\Jobs\CleanLogsJob;

class CleanLogsCommand extends Command
{
    protected $signature = 'magento:webhooks:clean-logs {--date=}';

    protected $description = 'Cleans event logs based on date';

    public function handle(): int
    {
        /** @var ?string $date */
        $date = $this->option('date');

        $date = $date !== null
            ? Carbon::parse($date)
            : now()->subMonth();

        CleanLogsJob::dispatch($date);

        return static::SUCCESS;
    }
}
