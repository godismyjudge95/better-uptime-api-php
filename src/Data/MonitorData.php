<?php

namespace BetterUptime\Data;

use BetterUptime\DataTypes\DomainExpiration;
use BetterUptime\DataTypes\MonitorType;
use BetterUptime\DataTypes\Region;
use BetterUptime\DataTypes\SslExpiration;
use DateTimeZone;
use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Traits\Responses\HasResponse;

class MonitorData implements WithResponse
{
    use HasResponse;

    /**
     * Returns a newly created monitor or validation errors.
     *
     * @param  null|int  $id
     * @param  null|MonitorType|string  $monitor_type
     * @param  null|string  $url The URL of your website or the host you want to ping (see monitor_type below).
     * @param  null|string  $pronounceable_name The name of the monitor
     * @param  bool  $email Send email alerts
     * @param  bool  $sms Send SMS alerts
     * @param  bool  $call Phone call alerts
     * @param  bool  $push Should we send a push notification to the on-call person?
     * @param  null|int  $check_frequency Check frequency (in seconds)
     * @param  object[]  $request_headers The request headers that will be send with the check
     * @param  int[]  $expected_status_codes An array of status codes you expect to receive from your website. These status codes are considered only if the monitor_type is expected_status_code.
     * @param  null|DomainExpiration|string  $domain_expiration How many days before the domain expires do you want to be alerted?
     * @param  null|SslExpiration|string  $ssl_expiration How many days before the SSL certificate expires do you want to be alerted?
     * @param  null|int  $policy_id Set the escalation policy for the monitor.
     * @param  bool  $follow_redirects Should we automatically follow redirects when sending the HTTP request?
     * @param  null|string  $required_keyword Required if monitor_type is set to keyword or udp. We will create a new incident if this keyword is missing on your page.
     * @param  null|int  $team_wait How long to wait before escalating the incident alert to the team. Leave blank to disable escalating to the entire team. In seconds.
     * @param  bool  $paused Set to true to pause monitoring — we won't notify you about downtime. Set to false to resume monitoring.
     * @param  null|int  $port Required if monitor_type is set to tcp, udp, smtp, pop, or imap. tcp and udp monitors accept any ports, while smtp, pop, and imap accept only the specified ports corresponding with their servers (e.g. 25,465,587 for smtp).
     * @param  Region[]  $regions An array of regions to set.
     * @param  null|string  $monitor_group_id Set this attribute if you want to add this monitor to a monitor group.
     * @param  null|int  $recovery_period How long the monitor must be up to automatically mark an incident as resolved after being down. In seconds.
     * @param  null|bool  $verify_ssl Should we verify SSL certificate validity?
     * @param  null|int  $confirmation_period How long should we wait after observing a failure before we start a new incident? In seconds.
     * @param  null|Method|string  $http_method HTTP Method used to make a request.
     * @param  null|int  $request_timeout How long to wait before timing out the request? In seconds.
     * @param  null|string  $request_body Request body for POST, PUT, PATCH requests.
     * @param  null|string  $auth_username Basic HTTP authentication username to include with the request.
     * @param  null|string  $auth_password Basic HTTP authentication password to include with the request.
     * @param  null|string  $maintenance_from Start of the maintenance window each day. We won't check your website during this window. Example: '01:00:00'
     * @param  null|string  $maintenance_to End of the maintenance window each day. Example: '03:00:00'
     * @param  null|DateTimeZone  $maintenance_timezone The timezone to use for the maintenance window each day. Defaults to UTC.
     * @param  bool  $remember_cookies Do you want to keep cookies when redirecting?
     * @param null|string $last_checked_at
     * @param null|string $status
     * @param null|string $paused_at
     * @param null|string $created_at
     * @param null|string $updated_at
     */
    public function __construct(
        readonly public ?int $id = null,
        readonly private MonitorType|string|null $monitor_type = null,
        readonly public ?string $url = null,
        readonly public ?string $pronounceable_name = null,
        readonly public bool $email = false,
        readonly public bool $sms = false,
        readonly public bool $call = false,
        readonly public bool $push = false,
        readonly public ?int $check_frequency = null, // maybe enum?
        readonly public array $request_headers = [], // maybe DTO?
        readonly public array $expected_status_codes = [], // maybe DTO?
        readonly private DomainExpiration|string|null $domain_expiration = null,
        readonly private SslExpiration|string|null $ssl_expiration = null,
        readonly public ?int $policy_id = null,
        readonly public bool $follow_redirects = false,
        readonly public ?string $required_keyword = null,
        readonly public ?int $team_wait = null,
        readonly public bool $paused = false,
        readonly public ?int $port = null,
        readonly private array $regions = [],
        readonly public ?string $monitor_group_id = null,
        readonly public ?int $recovery_period = null,
        readonly public bool $verify_ssl = false,
        readonly public ?int $confirmation_period = null,
        readonly private Method|string|null $http_method = null,
        readonly public ?int $request_timeout = null,
        readonly public ?string $request_body = null,
        readonly public ?string $auth_username = null,
        readonly public ?string $auth_password = null,
        readonly public ?string $maintenance_from = null,
        readonly public ?string $maintenance_to = null,
        readonly public DateTimeZone $maintenance_timezone,
        readonly public bool $remember_cookies = false,

        // Existing Monitor Attributes
        readonly public ?string $last_checked_at = null,
        readonly public ?string $status = null,
        readonly public ?string $paused_at = null,
        readonly public ?string $created_at = null,
        readonly public ?string $updated_at = null,
    ) {
    }

    public static function fromResponse(Response $response): self
    {
        return static::fromData($response->json());
    }

    public static function fromData($data): self
    {
        return new static($data['id'], ...$data['attributes']);
    }

    public function __get($attribute)
    {
        return match ($attribute) {
            'regions' => collect($this->regions)
                ->map(fn ($region) => Region::tryFrom($region ?? ''))
                ->filter(fn ($region) => $region)
                ->all(),
            'monitor_type' => MonitorType::tryFrom($this->monitor_type ?? ''),
            'http_method' => Method::tryFrom($this->http_method ?? ''),
            'ssl_expiration' => SslExpiration::tryFrom($this->ssl_expiration ?? 0),
            'domain_expiration' => DomainExpiration::tryFrom($this->domain_expiration ?? 0),
            default => $this->{$attribute},
        };
    }
}
