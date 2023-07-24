<?php

namespace App\Http\Middleware\Firewall;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class WhiteListMiddleware.
 *
 * @author Tom Six <tom@webatvantage>
 */
class BlacklistMiddleware extends FirewallMiddleware
{
	public function handle(Request $request, Closure $next, string ...$group)
	{
		$blockedIps = $this->getIpAddresses('blacklist', ...$group);
		$clientIp = $request->getClientIp();

        foreach ($blockedIps as $blockedIp)
        {
            if (Str::is($blockedIp, $clientIp)) {
                return $this->handleNoAccess($request, $next);
            }
        }

		return $next($request);
	}
}
