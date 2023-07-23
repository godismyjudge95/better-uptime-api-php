<?php

namespace BetterUptime\Requests\Monitors;

use BetterUptime\Data\MonitorData;
use BetterUptime\DataTypes\DomainExpiration;
use BetterUptime\DataTypes\MonitorType;
use BetterUptime\DataTypes\Region;
use BetterUptime\DataTypes\SslExpiration;
use DateTimeZone;
use Illuminate\Contracts\Queue\Monitor;
use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateNewMonitorRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * Returns a newly created monitor or validation errors.
     */
    public function __construct(
        protected Monitor $monitor,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/monitors';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return MonitorData::fromResponse($response);
    }
}
