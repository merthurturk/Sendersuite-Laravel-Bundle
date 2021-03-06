<?php
return array(

	/*
	|--------------------------------------------------------------------------
	| Debug mode
	|--------------------------------------------------------------------------
	|
	| When debug mode is enabled, sendersuite.email.debug event is fired each
	| time an email is sent with Sendersuite bundle.
	|
	*/
	'debugmode' => false,

	/*
	|--------------------------------------------------------------------------
	| Default connection
	|--------------------------------------------------------------------------
	|
	| The name of your default sendersuite connection. This connection will used
	| as the default for all sendersuite operations unless a different name is
	| given when performing said operation. This connection name should be
	| listed in the array of connections below.
	|
	*/
	'defaultconnection' => 'production',

	/*
	|--------------------------------------------------------------------------
	| Connections
	|--------------------------------------------------------------------------
	|
	| All of the sendersuite connections used by your application. Many of your
	| applications will no doubt only use one connection; however, you have
	| the freedom to specify as many connections as you can handle.
	|
	| Each connection can have its own API key, from name and email address,
	| reply-to name and email address. This way you don't have to provide
	| these information each time you perform an operation. Only apikey and
	| fromemail is required, the rest are optional.
	|
	| To get your API key, first login to SenderSuite (http://sendersuite.com)
	| and then go to "API Keys" screen.
	|
	| In order to send email from SenderSuite, you need to create a sender
	| on your SenderSuite account and use it as fromemail.
	|
	*/
	'connections' => array(
		'production' => array(
			'apikey'		=> '',
			'fromname'		=> '',
			'fromemail'		=> '',
			'replytoname'	=> '',
			'replytoemail'	=> '',
		)
	),

);