<?php

namespace Karlmonson\Ping;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;

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

	/**
	 * @var arr
	 */
	protected $dns;

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
			$this->responseCode = $e->getCode();
		} catch(ServerException $e) {
			$this->responseCode = $e->getCode();
		}

		return $this->responseCode;
	}

	public function checkA($host, $val)
	{
		$this->dns = collect(dns_get_record($host, DNS_A));
		$filtered = $this->dns->filter(function($item, $key) use($val) {
			return $item['ip'] == $val;
		});
		return $filtered->count() > 0;
	}

	public function checkCname($host, $val)
	{
		$this->dns = collect(dns_get_record($host, DNS_CNAME));
		$filtered = $this->dns->filter(function($item, $key) use($val) {
			return $item['target'] === $val;
		});
		return $filtered->count() > 0;
	}

	public function checkNameserver($host, $val)
	{
		$this->dns = collect(dns_get_record($host, DNS_NS));
		$filtered = $this->dns->filter(function($item, $key) use($val) {
			return $item['target'] === $val;
		});
		return $filtered->count() > 0;
	}
}
