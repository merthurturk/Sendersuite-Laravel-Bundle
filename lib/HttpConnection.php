<?php
namespace Sendersuite;

/**
 * Laravel http api connection class for Sendersuite email sending.
 *
 * @author Mert Hurturk <mert.hurturk@gmail.com>
 */
class HttpConnection implements ApiConnectionInterface
{
	public function send($data = array(), $config = array())
	{
		$postData = array(
			'APIKey'		=> $config['apikey'],
			'FromName'		=> $config['fromname'],
			'From'			=> $config['fromemail'],
			'ReplyToName'	=> $config['replytoname'],
			'ReplyTo'		=> $config['replytoemail'],
			'To'			=> $data['to'],
			'Subject'		=> $data['subject'],
			'HTMLBody'		=> $data['htmlbody'],
			'TextBody'		=> $data['plainbody']
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
			throw new ApiException('Sendersuite API returned error code: '
				.$responseObject->ErrorCode.' and fields: "'
				.implode(',', $responseObject->ErrorFields).'"');
			return false;
		}
	}
}