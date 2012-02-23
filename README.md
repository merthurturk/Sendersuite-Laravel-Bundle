# SenderSuite Bundle, by Mert Hurturk

SenderSuite bundle lets you to send transactional emails from your Laravel application through your SenderSuite account easily.

In order to use this bundle, you need to have a SenderSuite account, which you can create one here: http://sendersuite.com/#signup

To get a SenderSuite connection instance:

	$ssConnection = IoC::resolve('sendersuite');

By default SenderSuite bundle uses `production` connection configuration setup on bundle configuration. You can create as many connection configurations as you like and use any of your SenderSuite connection configurations by passing the configuration to `sendEmail` method. Here is an example:

	$ssConnection = IoC::resolve('sendersuite');
	$connConfigName = 'testconnection';
	$ssConnection->sendEmail('mert.hurturk@gmail.com', 'Subject', 'HTML Body', 'Text Body', $connConfigName);

## Error Handling

`sendEmail` method returns true if email is successfully sent, otherwise false. However, when there is a connection issue or a configuration issue, it throws exceptions.

* Bugs: https://github.com/merthurturk/Sendersuite-Laravel-Bundle/issues

# SenderSuite, by Octeth

SenderSuite is a transactional email delivery gateway for both websites and applications.

* Homepage: http://sendersuite.com