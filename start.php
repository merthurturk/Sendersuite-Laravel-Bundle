<?php
Autoloader::namespaces(array(
    'Sendersuite' => Bundle::path('sendersuite').'lib',
));

// Register sendersuite in the IoC container
Laravel\IoC::singleton('sendersuite', function()
{
	$confProvider = new \Sendersuite\ConfigurationProvider();

	if (\Laravel\Config::get('sendersuite::config.debugmode')) {
		$apiConnection = new \Sendersuite\EventConnection();
	} else {
		$apiConnection = new \Sendersuite\HttpConnection();
	}

	$ssApi = new \Sendersuite\Api($apiConnection, $confProvider);

	return $ssApi;
});