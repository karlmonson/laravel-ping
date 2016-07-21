<?php

namespace Karlmonson\Ping;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

class Ping
{
	/**
	 * @var \GuzzleHttp\Client
	 */
	protected $client;

	/**  
	 * @var int 
	 */
	protected $responseCode;

	/** 
	 * @var int 
	 */
	protected $timeout = 5;

	/** 
	 * @var bool 
	 */
	protected $allowRedirects = true;

	public function __construct()
	{
		$this->client = new Client([
			'timeout' => $this->timeout,
			'allow_redirects' => $this->allowRedirects,
		]);
	}

	public function check($url)
	{
		try {
			$response = $this->client->get($url);
			$this->responseCode = $response->getStatusCode();
		} catch(ClientException $e) {
			$response = $e->getResponse();
			$this->responseCode = $response->getStatusCode();
		} catch(ConnectException $e) {
			$response = $e->getResponse();
			$this->responseCode = $response->getStatusCode();
		}

		return $this->responseCode;
	}
}
