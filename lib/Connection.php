<?php
namespace Sendersuite;

use \Laravel\Config;

/**
 * SenderSuite connection class
 *
 * @author Mert Hurturk <mert.hurturk@gmail.com>
 **/
class Connection
{
	/**
	 * Determines if connection is in debug mode or not
	 *
	 * @var bool
	 **/
	protected $_debugMode = false;

	/**
	 * Last error code
	 *
	 * @var int
	 **/
	protected $_lastErrorCode = 0;

	/**
	 * Last error fields
	 *
	 * @var string
	 **/
	protected $_lastErrorFields = '';

	/**
	 * Sends email through SenderSuite
	 *
	 * @param string $toEmail Recipient email address
	 * @param string $subject Email subject
	 * @param string $htmlBody Email HTML body
	 * @param string $textBody Email text body
	 * @param string $connConfigName Connection configuration name to be used.
	 *
	 * @throws \Sendersuite\InvalidConnectionConfigException
	 * @throws \Sendersuite\ConnectionException
	 *
	 * @return bool
	 *
	 * @author Mert Hurturk <mert.hurturk@gmail.com>
	 **/
	public function sendEmail($toEmail, $subject, $htmlBody, $textBody = '', $connConfigName = NULL)
	{
		if (is_null($connConfigName))
			$connConfigName = Config::get('sendersuite::config.default');

		$connConfig = Config::get('sendersuite::config.connections.'.$connConfigName);

		if (is_null($connConfig)) {
			throw new InvalidConnectionConfigException(
				'SenderSuite connection configuration not found for key "'
				.$connConfigName.'"');
		}

		// If debug mode is enabled, do not send the email, only fire an event
		if ($this->isDebugModeEnabled()) {
			\Laravel\Event::fire('sendersuite.email', array(
				'connConfigName'=> $connConfigName,
				'connConfig'	=> $connConfig,
				'toEmail'		=> $toEmail,
				'subject'		=> $subject,
				'htmlBody'		=> $htmlBody,
				'textBody'		=> $textBody
			));
			return true;
		}

		$postData = array(
			'APIKey'		=> $connConfig['apikey'],
			'FromName'		=> $connConfig['fromname'],
			'From'			=> $connConfig['fromemail'],
			'ReplyToName'	=> $connConfig['replytoname'],
			'ReplyTo'		=> $connConfig['replytoemail'],
			'To'			=> $toEmail,
			'Subject'		=> $subject,
			'HTMLBody'		=> $htmlBody,
			'TextBody'		=> $textBody
		);

		$contextParams = array(
			'http' => array(
				'method' => 'POST',
				'content' => http_build_query($postData)
			)
		);

		$context = stream_context_create($contextParams);
		$fp = fopen('http://sendersuite.com/api/', 'rb', false, $context);
		if (! $fp) {
			throw new ConnectionException('SenderSuite connection can not be established');
		}
		$response = stream_get_contents($fp);

		if ($response === false) {
			throw new ConnectionException('SenderSuite connection returns invalid response');
		}

		$responseObject = json_decode($response);
		if ($responseObject->Success === true) {
			return true;
		} else {
			$this->_lastErrorCode = $responseObject->ErrorCode;
			$this->_lastErrorFields = $responseObject->ErrorFields;
			return false;
		}
	}

	/**
	 * Returns last error code and error fields received.
	 *
	 * For more information on error codes and fields, please check
	 * http://sendersuite.com/#help
	 *
	 * @return array
	 *
	 * @author Mert Hurturk <mert.hurturk@gmail.com>
	 **/
	public function getError()
	{
		return array($this->_lastErrorCode, $this->_lastErrorFields);
	}

	/**
	 * Enables or disables debug mode
	 *
	 * @param bool $bool
	 *
	 * @author Mert Hurturk <mert.hurturk@gmail.com>
	 */
	public function debugMode($bool)
	{
		if ($bool !== false && $bool !== true)
			$bool = false;

		$this->_debugMode = $bool;
	}

	/**
	 * Returns true if debug mode is enabled, otherwise returns false
	 *
	 * @return bool
	 *
	 * @author Mert Hurturk <mert.hurturk@gmail.com>
	 */
	public function isDebugModeEnabled()
	{
		return $this->_debugMode;
	}
}