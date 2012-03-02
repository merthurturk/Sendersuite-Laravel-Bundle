<?php
namespace Sendersuite;

/**
 * Sendersuite API class.
 *
 * Different type of connection and configuration provider objects can be
 * injected, which allows you to debug email sending easily on your application.
 *
 * @author Mert Hurturk <mert.hurturk@gmail.com>
 */
class API
{
	/**
	 * Connection object
	 * @var \Sendersuite\ApiConnectionInterface
	 */
	protected $_connection;

	/**
	 * Connection configuration provider object
	 * @var \Sendersuite\ConfigurationProvider
	 */
	protected $_configurationProvider;

	/**
	 * Constructor
	 *
	 * @param ApiConnectionInterface $conn Api connection to be used
	 * @param ConfigurationProvider $confProvider Connection configuration will
	 * 			will be fetched through this object
	 *
	 * @author Mert Hurturk <mert.hurturk@gmail.com>
	 */
	public function __construct(ApiConnectionInterface $conn,
		ConfigurationProvider $confProvider)
	{
		$this->_connection = $conn;
		$this->_configurationProvider = $confProvider;
	}

	/**
	 * Sends email
	 *
	 * @param string $to Recipient email address
	 * @param string $subject Subject of the email
	 * @param string $htmlBody HTML body of the email
	 * @param string $plainBody Plain text body of the email
	 * @param string $connConfigName Connection configuration name to be used
	 *
	 * @throws InvalidConnectionConfigException
	 *
	 * @return bool
	 *
	 * @author Mert Hurturk <mert.hurturk@gmail.com>
	 **/
	public function sendEmail($to, $subject, $htmlBody, $plainBody,
		$connConfigName = null)
	{
		$config = $this->_getConfigurationArray($connConfigName);

		if (! is_array($config))
			throw new InvalidConnectionConfigException(
				'Invalid Sendersuite connection configuration key: "'
				.$connConfigName.'"');

		$data = array(
			'to'		=> $to,
			'subject'	=> $subject,
			'htmlbody'	=> $htmlBody,
			'plainbody'	=> $plainBody
		);

		try {
			$this->_connection->send($data, $config);
			return true;
		} catch (Exception $e) {
			\Laravel\Event::fire('sendersuite.email.error', array(
				$data, $config, $e));
			return false;
		}
	}

	/**
	 * Returns connection configuration array
	 * @param  string $connConfigName Configuration key
	 * @return array|null
	 */
	protected function _getConfigurationArray($connConfigName = null)
	{
		return is_null($connConfigName)
			? $this->_configurationProvider->getDefaultConfiguration()
			: $this->_configurationProvider->getConfigurationFor(
				$connConfigName);
	}
}