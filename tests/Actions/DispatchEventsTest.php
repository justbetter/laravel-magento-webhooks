<?php

declare(strict_types=1);

namespace JustBetter\MagentoWebhooks\Tests\Actions;

use Illuminate\Support\Facades\Event;
use JustBetter\MagentoWebhooks\Actions\DispatchEvents;
use JustBetter\MagentoWebhooks\Models\EventLog;
use JustBetter\MagentoWebhooks\Tests\Fakes\Events\FakeEvent;
use JustBetter\MagentoWebhooks\Tests\TestCase;

final class DispatchEventsTest extends TestCase
{
    public function test_it_can_dispatch_events_as_string(): void
    {
        Event::fake();

        config()->set('magento-webhooks.events', [
            'test-event' => FakeEvent::class,
        ]);

        /** @var DispatchEvents $dispatchEvents */
        $dispatchEvents = app(DispatchEvents::class);
        $dispatchEvents->dispatch('test-event', ['some' => 'value']);

        Event::assertDispatched(FakeEvent::class, fn (FakeEvent $fakeEvent): bool => $fakeEvent->event === 'test-event'
            && $fakeEvent->data === ['some' => 'value']);
    }

    public function test_it_can_dispatch_events_as_array(): void
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

        Event::assertDispatched(FakeEvent::class, fn (FakeEvent $fakeEvent): bool => $fakeEvent->event === 'test-event'
            && $fakeEvent->data === ['some' => 'value']);
    }

    public function test_it_can_skip_dispatching_duplicate_events(): void
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

        Event::assertDispatched(FakeEvent::class, fn (FakeEvent $fakeEvent): bool => $fakeEvent->event === 'test-event'
            && $fakeEvent->data === ['some' => 'value']);
    }

    public function test_it_can_skip_dispatching_events(): void
    {
        Event::fake();

        config()->set('magento-webhooks.events', []);

        /** @var DispatchEvents $dispatchEvents */
        $dispatchEvents = app(DispatchEvents::class);
        $dispatchEvents->dispatch('test-event', ['some' => 'value']);

        Event::assertNotDispatched(FakeEvent::class);
    }

    public function test_it_logs_events_in_database(): void
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
