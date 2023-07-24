<?php

namespace App\Http\Middleware\Firewall;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WhitelistMiddleware extends FirewallMiddleware
{
	public function handle(Request $request, Closure $next, string ...$group)
	{
		$allowedIps = $this->getIpAddresses('whitelist', ...$group);
		$clientIp = $request->getClientIp();

        foreach ($allowedIps as $allowedIp)
        {
            if (Str::is($allowedIp, $clientIp)) {
                return $next($request);
            }
        }

		return $this->handleNoAccess($request, $next);
	}
}
