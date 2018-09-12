<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\IpUtils;

class IPAddresses
{
    /**
     * List of valid IPs.
     *
     * @var array
     */
    protected $ips = [
        '127.0.0.1',
        '188.102.29.159',
    ];

    /**
     * List of valid IP-ranges.
     *
     * @var array
     */
    protected $ipRanges = [
        '12.64.103.24',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        foreach ($request->getClientIps() as $ip) {
            if (!$this->isValidIp($ip) && !$this->isValidIpRange($ip)) {
                die('Unauthorized 403');
            }
        }

        return $next($request);
    }

    /**
     * Check if the given IP is valid.
     *
     * @param $ip
     * @return bool
     */
    protected function isValidIp($ip)
    {
        return in_array($ip, $this->ips);
    }

    /**
     * Check if the ip is in the given IP-range.
     *
     * @param $ip
     * @return bool
     */
    protected function isValidIpRange($ip)
    {
        return IpUtils::checkIp($ip, $this->ipRanges);
    }
}
