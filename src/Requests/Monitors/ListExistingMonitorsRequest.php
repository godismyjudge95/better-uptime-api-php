<?php

namespace BetterUptime\Requests\Monitors;

use BetterUptime\Data\MonitorData;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListExistingMonitorsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/monitors';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return $response->collect('data')->map(fn ($data) => MonitorData::fromData($data));
    }
}
