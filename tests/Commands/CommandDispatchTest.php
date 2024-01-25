<?php

namespace JustBetter\MagentoWebhooks\Tests\Commands;

use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\PendingCommand;
use JustBetter\MagentoWebhooks\Commands\CleanLogsCommand;
use JustBetter\MagentoWebhooks\Jobs\CleanLogsJob;
use JustBetter\MagentoWebhooks\Tests\TestCase;

class CommandDispatchTest extends TestCase
{
    /** @test */
    public function test_it_dispatches_job(): void
    {
        Bus::fake();

        /** @var PendingCommand $artisan */
        $artisan = $this->artisan(CleanLogsCommand::class);

        $artisan
            ->assertSuccessful()
            ->run();

        Bus::assertDispatched(CleanLogsJob::class);
    }

    /** @test */
    public function test_it_dispatches_with_date(): void
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
