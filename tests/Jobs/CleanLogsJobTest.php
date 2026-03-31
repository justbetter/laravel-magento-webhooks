<?php

declare(strict_types=1);

namespace JustBetter\MagentoWebhooks\Tests\Jobs;

use JustBetter\MagentoWebhooks\Contracts\CleansLogs;
use JustBetter\MagentoWebhooks\Jobs\CleanLogsJob;
use JustBetter\MagentoWebhooks\Tests\TestCase;
use Mockery\MockInterface;

final class CleanLogsJobTest extends TestCase
{
    public function test_it_can_clean_event_logs(): void
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
