<?php

namespace JustBetter\MagentoWebhooks\Tests\Http\Controllers;

use Illuminate\Support\Facades\Bus;
use JustBetter\MagentoWebhooks\Jobs\EventJob;
use JustBetter\MagentoWebhooks\Tests\TestCase;

class EventControllerTest extends TestCase
{
    /** @test */
    public function it_can_dispatch_jobs(): void
    {
        Bus::fake();

        $this->postJson('magento/webhook', [
            'event' => '::event::',
            'some' => 'value',
        ]);

        Bus::assertDispatched(EventJob::class, function (EventJob $eventJob): bool {

            return $eventJob->event === '::event::'
                && $eventJob->data === ['some' => 'value'];

        });
    }

    /** @test */
    public function it_can_validate_requests(): void
    {
        Bus::fake();

        $this->postJson('magento/webhook', [
            'some' => 'value',
        ])->assertJsonValidationErrors([
            'event',
        ]);
    }
}
