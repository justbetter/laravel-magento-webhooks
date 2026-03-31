<?php

declare(strict_types=1);

namespace JustBetter\MagentoWebhooks\Tests\Http\Controllers;

use Illuminate\Support\Facades\Bus;
use JustBetter\MagentoWebhooks\Jobs\EventJob;
use JustBetter\MagentoWebhooks\Tests\TestCase;

final class EventControllerTest extends TestCase
{
    public function test_it_can_dispatch_jobs(): void
    {
        Bus::fake();

        $this->postJson('magento/webhook', [
            'event' => '::event::',
            'some' => 'value',
        ]);

        Bus::assertDispatched(EventJob::class, fn (EventJob $eventJob): bool => $eventJob->event === '::event::' && $eventJob->data === ['some' => 'value']);
    }

    public function test_it_can_validate_requests(): void
    {
        Bus::fake();

        $this->postJson('magento/webhook', [
            'some' => 'value',
        ])->assertJsonValidationErrors([
            'event',
        ]);
    }
}
