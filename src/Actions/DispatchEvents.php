<?php

namespace JustBetter\MagentoWebhooks\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use JustBetter\MagentoWebhooks\Contracts\DispatchesEvents;

class DispatchEvents implements DispatchesEvents
{
    public function dispatch(string $event, array $data): void
    {
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
