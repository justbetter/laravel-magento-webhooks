<?php

namespace JustBetter\MagentoWebhooks\Contracts;

interface DispatchesEvents
{
    public function dispatch(string $event, array $data): void;
}
