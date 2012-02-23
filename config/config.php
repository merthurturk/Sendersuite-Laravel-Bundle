<?php
return array(

	/*
	|--------------------------------------------------------------------------
	| Debug mode
	|--------------------------------------------------------------------------
	|
	| When debug mode is enabled (debugmode => true), no emails sent but
	| sendersuite.email event is fired with the following parameters:
	|
	| * Connection configuration name
	| * Connection configuration array
	| * Recipient email address
	| * Email subject
	| * Email HTML body
	| * Email text body
	|
	| By listening to this event, you can make tests on your application without
	| spending your SenderSuite credits.
	|
	*/
	'debugmode' => false,

	/*
	|--------------------------------------------------------------------------
	| Default Sendersuite Connection
	|--------------------------------------------------------------------------
	|
	| The name of your default sendersuite connection. This connection will used
	| as the default for all sendersuite operations unless a different name is
	| given when performing said operation. This connection name should be
	| listed in the array of connections below.
	|
	*/
	'default' => 'production',

	/*
	|--------------------------------------------------------------------------
	| Sendersuite Connections
	|--------------------------------------------------------------------------
	|
	| All of the sendersuite connections used by your application. Many of your
	| applications will no doubt only use one connection; however, you have
	| the freedom to specify as many connections as you can handle.
	|
	| Each connection can have its own API key, from name and email address,
	| reply-to name and email address. This way you don't have to provide
	| these information each time you perform an operation. Only apiKey and
	| fromEmail is required, you can leave the rest blank.
	|
	| To get your API key, first login to SenderSuite (http://sendersuite.com)
	| and then go to "API Keys" screen.
	|
	| In order to send email from SenderSuite, you need to create a sender
	| on your SenderSuite account and use it as fromEmail.
	|
	*/
	'connections' => array(
		'production' => array(
			'apikey'		=> 's2-ickI-oLg0-zvBB-1rn0-cVpP',
			'fromname'		=> '',
			'fromemail'		=> 'mert.hurturk@gmail.com',
			'replytoname'	=> '',
			'replytoemail'	=> '',
		),
	),

);