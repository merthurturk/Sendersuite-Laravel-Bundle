<?php
Bundle::start('sendersuite');

use \Sendersuite\Api;

class ApiTest extends PHPUnit_Framework_TestCase {

	public function testReturnsTrueIfEmailIsSent()
	{
		$confProvider = $this->_getSimpleConfigurationProviderMock();

		$apiConnection = $this->getMock('\Sendersuite\ApiConnectionInterface',
			array('send'));
		$apiConnection->expects($this->once())
						->method('send')
						->will($this->returnValue(true));

		$api = new Api($apiConnection, $confProvider);

		$result = $api->sendEmail('mert.hurturk@gmail.com', 'Test subject',
			'HTML', 'text');

		$this->assertTrue($result);
	}

	public function testReturnsFalseIfEmailIsNotSent()
	{
		$confProvider = $this->_getSimpleConfigurationProviderMock();

		$apiConnection = $this->getMock('\Sendersuite\ApiConnectionInterface',
			array('send'));
		$apiConnection->expects($this->once())
						->method('send')
						->will($this->throwException(new \Sendersuite\Exception));

		$api = new Api($apiConnection, $confProvider);

		$result = $api->sendEmail('mert.hurturk@gmail.com', 'Test subject',
			'HTML', 'text');

		$this->assertFalse($result);
	}

	public function testIfNoConfigurationNameProvidedDefaultConfigurationIsUsed()
	{
		$confProvider = $this->getMock('\Sendersuite\ConfigurationProvider',
			array('getDefaultConfiguration'));
		$confProvider->expects($this->once())
						->method('getDefaultConfiguration')
						->will($this->returnValue(array()));

		$apiConnection = $this->_getSimpleApiConnectionMock();

		$api = new Api($apiConnection, $confProvider);

		$api->sendEmail('mert.hurturk@gmail.com', 'Test subject', 'HTML', 'text');
	}

	public function testIfConfigurationNameProvidedItIsUsed()
	{
		$confProvider = $this->getMock('\Sendersuite\ConfigurationProvider',
			array('getConfigurationFor'));
		$confProvider->expects($this->once())
						->method('getConfigurationFor')
						->with($this->equalTo('myconf'))
						->will($this->returnValue(array()));

		$apiConnection = $this->_getSimpleApiConnectionMock();

		$api = new Api($apiConnection, $confProvider);

		$api->sendEmail('mert.hurturk@gmail.com', 'Test subject', 'HTML',
			'text', 'myconf');
	}

	/**
     * @expectedException \Sendersuite\InvalidConnectionConfigException
     */
	public function testIfAnInvalidConfigurationNameProvidedThrowsInvalidConnectionConfigException()
	{
		$confProvider = $this->getMock('\Sendersuite\ConfigurationProvider',
			array('getConfigurationFor'));
		$confProvider->expects($this->once())
						->method('getConfigurationFor')
						->will($this->returnValue(null));

		$apiConnection = $this->_getSimpleApiConnectionMock();

		$api = new Api($apiConnection, $confProvider);

		$api->sendEmail('mert.hurturk@gmail.com', 'Test subject', 'HTML',
			'text', 'myinvalidconf');
	}

	public function testSendsDataAndConfigurationToConnectionObject()
	{
		$defaultConfiguration = array(
			'apikey'		=> '',
			'fromname'		=> '',
			'fromemail'		=> '',
			'replytoname'	=> '',
			'replytoemail'	=> ''
		);

		$sendData = array(
			'to'		=> 'mert.hurturk@gmail.com',
			'subject'	=> 'test subject',
			'htmlbody'	=> 'html body',
			'plainbody'	=> 'plain body'
		);

		$confProvider = $this->getMock('\Sendersuite\ConfigurationProvider');
		$confProvider->expects($this->once())
					->method('getDefaultConfiguration')
					->will($this->returnValue($defaultConfiguration));

		$apiConnection = $this->getMock('\Sendersuite\ApiConnectionInterface');

		$apiConnection->expects($this->once())
						->method('send')
						->with($this->equalTo($sendData),
							$this->equalTo($defaultConfiguration))
						->will($this->returnValue(false));

		$api = new Api($apiConnection, $confProvider);

		$api->sendEmail('mert.hurturk@gmail.com', 'test subject',
			'html body', 'plain body');
	}

	public function testAnEventIsFiredIfCantSendEmail()
	{
		$isEventFired = false;
		Event::listen('sendersuite.email.error', function() use (&$isEventFired)
		{
			$isEventFired = true;
		});

		$confProvider = $this->_getSimpleConfigurationProviderMock();

		$apiConnection = $this->_getSimpleApiConnectionMock();
		$apiConnection->expects($this->once())
						->method('send')
						->will($this->throwException(new \Sendersuite\Exception));

		$api = new Api($apiConnection, $confProvider);
		$api->sendEmail('to', 'subject', 'htmlbody', 'plainbody');
		$this->assertTrue($isEventFired);
	}







	/**
	 * UTILITY METHODS
	 */

	protected function _getSimpleApiConnectionMock()
	{
		return $this->getMock('\Sendersuite\ApiConnectionInterface');
	}

	protected function _getSimpleConfigurationProviderMock()
	{
		$mock = $this->getMock('\Sendersuite\ConfigurationProvider',
			array('getConfigurationFor', 'getDefaultConfiguration'));
		$mock->expects($this->any())
				->method('getConfigurationFor')
				->will($this->returnValue(array()));
		$mock->expects($this->any())
				->method('getDefaultConfiguration')
				->will($this->returnValue(array()));

		return $mock;
	}
}