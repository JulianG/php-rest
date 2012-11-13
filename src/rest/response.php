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
		return (json_encode($this -> body));
	}

}
?>