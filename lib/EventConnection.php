<?php
namespace Sendersuite;

/**
 * Laravel event connection class for debugging Sendersuite email sending.
 *
 * @author Mert Hurturk <mert.hurturk@gmail.com>
 */
class EventConnection implements ApiConnectionInterface
{
	public function send($data = array(), $config = array())
	{
		\Laravel\Event::fire('sendersuite.email.debug', array($data, $config));
	}
}