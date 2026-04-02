<?php

declare(strict_types=1);

namespace JustBetter\MagentoWebhooks\Tests\Commands;

use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\PendingCommand;
use JustBetter\MagentoWebhooks\Commands\CleanLogsCommand;
use JustBetter\MagentoWebhooks\Jobs\CleanLogsJob;
use JustBetter\MagentoWebhooks\Tests\TestCase;

final class CleanLogsCommandTest extends TestCase
{
    public function test_it_can_dispatch_clean_logs_job(): void
    {
        Bus::fake();

        /** @var PendingCommand $artisan */
        $artisan = $this->artisan(CleanLogsCommand::class);

        $artisan
            ->assertSuccessful()
            ->run();

        Bus::assertDispatched(CleanLogsJob::class);
    }

    public function test_it_can_dispatch_clean_logs_job_with_date(): void
    {
        Bus::fake();

        /** @var PendingCommand $artisan */
        $artisan = $this->artisan(CleanLogsCommand::class, [
            '--date' => now()->subMonths(2),
        ]);

        $artisan
            ->assertSuccessful()
            ->run();

        Bus::assertDispatched(CleanLogsJob::class);
    }
}
