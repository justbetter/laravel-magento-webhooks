<?php

namespace JustBetter\MagentoWebhooks\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use JustBetter\MagentoWebhooks\Contracts\DispatchesEvents;
use JustBetter\MagentoWebhooks\Models\EventLog;

class DispatchEvents implements DispatchesEvents
{
    public function dispatch(string $event, array $data): void
    {
        EventLog::query()->create([
            'event' => $event,
            'data' => $data,
        ]);

        $events = config('magento-webhooks.events');

        if (! isset($events[$event])) {
            return;
        }

        $webhooks = Arr::wrap($events[$event]);

        collect($webhooks)
            ->unique()
            ->each(function (string $webhook) use ($event, $data): void {
                Event::dispatch(
                    app($webhook, [
                        'event' => $event,
                        'data' => $data,
                    ])
                );
            });
    }

    public static function bind(): void
    {
        app()->singleton(DispatchesEvents::class, static::class);
    }
}
