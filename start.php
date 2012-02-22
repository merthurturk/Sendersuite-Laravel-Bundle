<?php
Autoloader::namespaces(array(
    'Sendersuite' => Bundle::location('sendersuite').'lib',
));

// Register sendersuite in the IoC container
Laravel\IoC::singleton('sendersuite.default', function()
{
	$ssConnection = new \Sendersuite\Connection;
	$ssConnection->setAPIkey(Config::item('sendersuite:connections.default.apiKey'));
	$ssConnection->setFrom(Config::item('sendersuite:connections.default.fromName'),
		Config::item('sendersuite:connections.default.fromEmail'));
	$ssConnection->setReplyTo(Config::item('sendersuite:connections.default.replyToName'),
		Config::item('sendersuite:connections.default.replyToEmail'));
	$ssConnection->debugMode(Config::item('sendersuite:debugMode'));

	return $ssConnection;
});