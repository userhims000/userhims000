<?php

class WP_Caveo_Cache_Call_Builder
{
	protected $_method = 'GET';

	protected $_base_url = 'http://localhost:1337/';

	protected $_url = '';

	protected $_payload = [];

	protected $_test = false;

	public function __construct($url)
	{
		$this->_url = $url;
	}

	public function setMethod ($method): self
	{
		$this->_method = $method;

		return $this;
	}

	public function setPayload (Array $payload): self
	{
		$this->_payload = $payload;

		return $this;
	}

	public function setTest (Bool $bool): self
	{
		$this->_test = $bool;

		return $this;
	}

	public function run (): array
	{
		if ($this->_test) {
			$this->dumpTestData();
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->getUrl());
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->_method);

		if (count($this->_payload) > 0) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->_payload));
			curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = json_decode(curl_exec($ch), true) ?? [];

		if (curl_error($ch)) {
			$error_msg = curl_error($ch);

			if ($_SERVER['REMOTE_ADDR'] === "109.109.102.102") {
				echo "Error - Process: {$this->getUrl()} ($this->_method): ". $error_msg;
				echo "<br><hr>";
			}

		}

		curl_close($ch);

		return $output;
	}

	protected function getUrl(): string
	{
		return "{$this->_base_url}{$this->_url}?" . http_build_query($this->_payload);
	}

	protected function dumpTestData (): void
	{
		var_dump($this->_method);
		var_dump($this->_url);
		var_dump($this->_payload);
		echo "<br><br>";
		var_dump($this->getUrl());
		echo "<br><br>";
		exit;
	}
}
