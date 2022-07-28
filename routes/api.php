<?php

use Illuminate\Support\Facades\Route;
use JustBetter\MagentoWebhooks\Http\Controllers\EventController;

Route::post('webhook', [EventController::class, 'process'])
    ->name('magento.webhook');
