<?php

declare(strict_types=1);

namespace JustBetter\MagentoWebhooks\Contracts;

interface DispatchesEvents
{
    public function dispatch(string $event, array $data): void;
}
