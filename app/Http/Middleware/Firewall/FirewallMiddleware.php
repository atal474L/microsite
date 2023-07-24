<?php

namespace App\Http\Middleware\Firewall;

use Closure;
use Illuminate\Http\Request;

/**
 * Class FirewallMiddleware.
 *
 * @author Tom Six <tom@webatvantage>
 */
abstract class FirewallMiddleware
{
	abstract public function handle(Request $request, Closure $next, string ...$group);

	protected function getIpAddresses(string $type, string ...$group): array
	{
        $ipAddresses = [];

		if (! empty($group)) {
            foreach ($group as $groupName)
            {
                $ipAddresses[] = (array)config("firewall.$type.$groupName", []);
            }

		}
        else {
            $ipAddresses = (array)config("firewall.$type", []);
        }

		// Flatten the array with all IP-addresses of the groups
		return array_merge(...array_values($ipAddresses));
	}

	public function handleNoAccess(Request $request, Closure $next)
	{
		$backdoorToken = config('firewall.backdoor');

		if (isset($backdoorToken) && ! empty($backdoorToken) && $backdoorToken === $request->query('backdoor')) {
			return $next($request);
		}

		$redirectTo = config('firewall.redirect_to');

		if (! empty($redirectTo) && filter_var($redirectTo, FILTER_VALIDATE_URL)) {
			return redirect()->to($redirectTo);
		}

		$responseStatus = config('firewall.response_status', 403);
		$responseMessage = config('firewall.response_message');

		abort($responseStatus, $responseMessage);
	}
}
