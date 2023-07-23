<?php

namespace BetterUptime\Requests\Monitors;

use BetterUptime\Data\MonitorData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateExistingMonitorRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * Update existing monitor configuration. Send only the parameters you wish to change (eg. url)
     */
    public function __construct(
        protected MonitorData $monitor
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/monitors/{$this->monitor->id}";
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return MonitorData::fromResponse($response);
    }
}
