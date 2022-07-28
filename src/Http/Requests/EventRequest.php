<?php

namespace JustBetter\MagentoWebhooks\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'event' => 'required|string',
        ];
    }
}
