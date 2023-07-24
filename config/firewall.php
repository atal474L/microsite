<?php

return [
	/**
	 * The groups with ipaddress that should be whitelisted
	 */
	'whitelist' => [
		'local' => [
			'localhost',
			'::1',
			'127.0.0.1',
			'192.168.*.*',
			'10.0.0.*'
		],
		'internal' => [
			'81.83.20.163',
		],
		'servers' => [
			'eu' => '127.0.0.1',
			'com' => '185.2.52.109',
			'org' => '185.2.52.108',
			'es' => '185.2.52.107',
			'uk' => '185.2.52.110',
			'de' => '94.176.98.100',
			'carmi' => '31.193.178.245',
			'pl' => '93.115.168.18',
			'll' => '185.2.54.54.143',
			'bobo' => '94.176.98.101',
			'thermae' => '188.93.153.110',
			'lenz' => '10.0.0.3',
			'curie' => '10.0.0.8',
			'mail' => '185.2.52.104',
			'me' => '185.2.52.111',
		],
	],

	/**
	 * The groups with ipaddress that should be blacklisted
	 */
	'blacklist' => [
		/*'group_1' => [
			'127.0.0.1',
			'192.168.0.*',
		],*/
	],

	/**
	 * It is possible to set a token that a can used to avoid the firewall middleware
	 * When there is no token set, the backdoor option will be disabled.
	 * The token can be used by appending it to the query string of the url as 'backdoor' parameter
	 */
	'backdoor' => env('BACKDOOR_TOKEN'),

	/**
	 * When a request is blocked it will redirect to the given url.
	 * When the url isn't set, the response status code and message wil be used.
	 */
	'redirect_to' => 'https://www.webatvantage.be/nl/home',

	/**
	 * The status code and message that should be send when a request is blocked.
	 */
	'response_status' => '403',
	'response_message' => ''
];
