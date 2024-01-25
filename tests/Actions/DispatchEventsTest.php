<?php

namespace JustBetter\MagentoWebhooks\Tests\Actions;

use Illuminate\Support\Facades\Event;
use JustBetter\MagentoWebhooks\Actions\DispatchEvents;
use JustBetter\MagentoWebhooks\Models\EventLog;
use JustBetter\MagentoWebhooks\Tests\Fakes\Events\FakeEvent;
use JustBetter\MagentoWebhooks\Tests\TestCase;

class DispatchEventsTest extends TestCase
{
    /** @test */
    public function it_can_dispatch_events_as_string(): void
    {
        Event::fake();

        config()->set('magento-webhooks.events', [
            'test-event' => FakeEvent::class,
        ]);

        /** @var DispatchEvents $dispatchEvents */
        $dispatchEvents = app(DispatchEvents::class);
        $dispatchEvents->dispatch('test-event', ['some' => 'value']);

        Event::assertDispatched(FakeEvent::class, function (FakeEvent $fakeEvent): bool {
            return $fakeEvent->event === 'test-event'
                && $fakeEvent->data === ['some' => 'value'];
        });
    }

    /** @test */
    public function it_can_dispatch_events_as_array(): void
    {
        Event::fake();

        config()->set('magento-webhooks.events', [
            'test-event' => [
                FakeEvent::class,
            ],
        ]);

        /** @var DispatchEvents $dispatchEvents */
        $dispatchEvents = app(DispatchEvents::class);
        $dispatchEvents->dispatch('test-event', ['some' => 'value']);

        Event::assertDispatched(FakeEvent::class, function (FakeEvent $fakeEvent): bool {
            return $fakeEvent->event === 'test-event'
                && $fakeEvent->data === ['some' => 'value'];
        });
    }

    /** @test */
    public function it_can_skip_dispatching_duplicate_events(): void
    {
        Event::fake();

        config()->set('magento-webhooks.events', [
            'test-event' => [
                FakeEvent::class,
                FakeEvent::class,
                FakeEvent::class,
            ],
        ]);

        /** @var DispatchEvents $dispatchEvents */
        $dispatchEvents = app(DispatchEvents::class);
        $dispatchEvents->dispatch('test-event', ['some' => 'value']);

        Event::assertDispatched(FakeEvent::class, function (FakeEvent $fakeEvent): bool {
            return $fakeEvent->event === 'test-event'
                && $fakeEvent->data === ['some' => 'value'];
        });
    }

    /** @test */
    public function it_can_skip_dispatching_events(): void
    {
        Event::fake();

        config()->set('magento-webhooks.events', []);

        /** @var DispatchEvents $dispatchEvents */
        $dispatchEvents = app(DispatchEvents::class);
        $dispatchEvents->dispatch('test-event', ['some' => 'value']);

        Event::assertNotDispatched(FakeEvent::class);
    }

    /** @test */
    public function it_logs_events_in_database(): void
    {
        Event::fake();

        config()->set('magento-webhooks.events', [
            'test-event' => [
                FakeEvent::class,
            ],
        ]);

        /** @var DispatchEvents $dispatchEvents */
        $dispatchEvents = app(DispatchEvents::class);
        $dispatchEvents->dispatch('test-event', ['some' => 'value']);

        $log = EventLog::query()
            ->where('event', '=', 'test-event')
            ->firstOrFail();

        $this->assertEquals([
            'some' => 'value',
        ], $log->data);
    }
}
