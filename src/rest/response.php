<?php

class Response {

	public $status;
	public $headers;
	public $body;
	public $exception;

	public function Response() {
		$this -> status = 200;
		$this -> headers = Array();
	}

	public function addHeader($header) {
		array_push($this -> header, $header);
	}

	public function clearHeaders() {
		$this -> headers = Array();
	}

	public function getBodyString() {
		if (is_string($this -> body))
			return $this -> body;
		//
		return json_encode($this -> body);
	}

}
?>