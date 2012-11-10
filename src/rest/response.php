<?php

class Response {

	public $status;
	public $body;
	public $headers;

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

}
?>