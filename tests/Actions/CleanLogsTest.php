<?php

declare(strict_types=1);

namespace JustBetter\MagentoWebhooks\Tests\Actions;

use JustBetter\MagentoWebhooks\Actions\CleanLogs;
use JustBetter\MagentoWebhooks\Models\EventLog;
use JustBetter\MagentoWebhooks\Tests\TestCase;

final class CleanLogsTest extends TestCase
{
    public function test_it_cleans_logs(): void
    {
        EventLog::query()->create([
            'event' => 'some-event',
            'data' => ['some' => 'value'],
            'created_at' => now()->subMonths(2),
        ]);

        EventLog::query()->create([
            'event' => 'some-event',
            'data' => ['some' => 'value'],
            'created_at' => now(),
        ]);

        /** @var CleanLogs $action */
        $action = app(CleanLogs::class);
        $action->clean(now()->subMonth());

        $this->assertEquals(1, EventLog::query()->count());
    }
}
