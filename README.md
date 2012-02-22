# SenderSuite Bundle, by Mert Hurturk

SenderSuite bundle lets you to send emails from your Laravel application through your SenderSuite account easily.

In order to use this bundle, you need to have a SenderSuite account, which you can create one here: http://sendersuite.com/#signup

To get a SenderSuite connection instance:

	$ssConnection = IoC::resolve('sendersuite.default');

You can create as many connection configurations as you like and register your own SenderSuite connections with those configurations in the IoC container. Here is the default configuration registration:

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

* Bugs: https://github.com/merthurturk/Sendersuite-Laravel-Bundle/issues

# SenderSuite, by Octeth

SenderSuite is a transactional email delivery gateway for both websites and applications.

* Homepage: http://sendersuite.com