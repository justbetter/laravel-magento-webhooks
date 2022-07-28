<?php

namespace JustBetter\MagentoWebhooks\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use JustBetter\MagentoWebhooks\Contracts\DispatchesEvents;

class EventJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public int $tries = 3;

    public function __construct(
        public string $event,
        public array $data
    ) {
        $this->onQueue(config('magento-webhooks.queue'));
    }

    public function handle(DispatchesEvents $dispatchesEvents): void
    {
        $dispatchesEvents->dispatch(
            event: $this->event,
            data: $this->data
        );
    }

    public function tags(): array
    {
        return [
            $this->event,
        ];
    }
}
