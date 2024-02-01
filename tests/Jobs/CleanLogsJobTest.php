<?php

namespace JustBetter\MagentoWebhooks\Tests\Jobs;

use JustBetter\MagentoWebhooks\Contracts\CleansLogs;
use JustBetter\MagentoWebhooks\Jobs\CleanLogsJob;
use JustBetter\MagentoWebhooks\Tests\TestCase;
use Mockery\MockInterface;

class CleanLogsJobTest extends TestCase
{
    /** @test */
    public function it_can_clean_event_logs(): void
    {
        $date = now()->subMonth();

        $this->mock(CleansLogs::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('clean')
                ->once()
                ->andReturn();
        });

        CleanLogsJob::dispatch($date);
    }
}
