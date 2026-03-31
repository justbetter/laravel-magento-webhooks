<?php

declare(strict_types=1);

namespace JustBetter\MagentoWebhooks\Tests\Jobs;

use JustBetter\MagentoWebhooks\Contracts\DispatchesEvents;
use JustBetter\MagentoWebhooks\Jobs\EventJob;
use JustBetter\MagentoWebhooks\Tests\TestCase;
use Mockery\MockInterface;

final class EventJobTest extends TestCase
{
    public function test_it_can_dispatch_events(): void
    {
        $this->mock(DispatchesEvents::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('dispatch')
                ->with('::event::', ['some' => 'value'])
                ->once()
                ->andReturn();
        });

        EventJob::dispatch('::event::', ['some' => 'value']);
    }

    public function test_it_has_correct_tags(): void
    {
        $job = new EventJob('::event::', []);

        $this->assertSame(['::event::'], $job->tags());
    }
}
