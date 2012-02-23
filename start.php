<?php
Autoloader::namespaces(array(
    'Sendersuite' => Bundle::path('sendersuite').'lib',
));

// Register sendersuite in the IoC container
Laravel\IoC::singleton('sendersuite', function()
{
	$ssConnection = new \Sendersuite\Connection;
	$ssConnection->debugMode(Config::get('sendersuite::config.debugmode'));
	return $ssConnection;
});