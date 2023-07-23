<?php

namespace BetterUptime\Requests\Monitors;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetSingleMonitorRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected int $id,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/monitors/{$this->id}";
    }
}
