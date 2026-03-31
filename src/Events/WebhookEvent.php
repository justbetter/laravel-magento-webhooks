<?php

declare(strict_types=1);

namespace JustBetter\MagentoWebhooks\Events;

abstract class WebhookEvent
{
    public function __construct(
        public string $event,
        public array $data
    ) {
        //
    }
}
