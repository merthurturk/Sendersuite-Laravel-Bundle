<?php
namespace Sendersuite;

/**
 * Sendersuite API connection interface.
 *
 * @author Mert Hurturk <mert.hurturk@gmail.com>
 */
interface ApiConnectionInterface
{
	public function send($data = array(), $config = array());
}