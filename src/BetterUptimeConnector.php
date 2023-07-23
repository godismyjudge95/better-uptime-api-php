<?php

namespace BetterUptime;

use Saloon\Http\Connector;

class BetterUptimeConnector extends Connector
{
    public function __construct(
        protected string $apiToken,
    ) {
        $this->withTokenAuth($this->apiToken);
    }

    public function resolveBaseUrl(): string
    {
        return 'https://uptime.betterstack.com/api/v2';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    protected function defaultQuery(): array
    {
        return [];
    }

    public function defaultConfig(): array
    {
        return [
            'timeout' => 60,
        ];
    }
}
