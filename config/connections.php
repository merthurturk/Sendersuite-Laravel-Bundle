<?php
return array(

	/*
	|--------------------------------------------------------------------------
	| Debug mode
	|--------------------------------------------------------------------------
	|
	| When debug mode set is enabled (debugMode => true), instead of connecting
	| to Sendersuite server and sending an email, emails will be logged with
	| Laravel's Log class for debugging.
	*/
	'debugMode' => false,

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
	| these information each time you perform an operation.
	|
	| To get your API key,
	|
	*/
	'connections' => array(
		'production' => array(
			'apiKey'		=> '',
			'fromName'		=> '',
			'fromEmail'		=> '',
			'replyToName'	=> '',
			'replyToEmail'	=> '',
		),
	),

);