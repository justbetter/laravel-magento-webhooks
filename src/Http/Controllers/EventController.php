<?php

namespace JustBetter\MagentoWebhooks\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use JustBetter\MagentoWebhooks\Http\Requests\EventRequest;
use JustBetter\MagentoWebhooks\Jobs\EventJob;

class EventController extends Controller
{
    public function process(EventRequest $request): JsonResponse
    {
        EventJob::dispatch(
            $request->get('event'),
            $request->except('event'),
        );

        return response()->json();
    }
}
