<?php

require_once ('./rest/request.php');
require_once ('./rest/response.php');
require_once ('./rest/binder.php');

class Rest {

	private $request;
	private $response;

	private $binder;

	public function Rest($path_prefix) {
		$this -> binder = new Binder();
		$this -> request = new Request($path_prefix);
		$this -> response = new Response();
	}

	public function bind($method, $path, $callback) {
		$this -> binder -> bind($method, $path, $callback);
	}

	public function start() {
		$this -> binder -> process($this -> request, $this -> response);
		$this -> sendStatus();
		$this -> sendHeaders();
		$this -> sendBody();
	}

	private function sendStatus() {
		http_response_code( $this->response->status);
	}
	private function sendHeaders() {
		$headers = $this -> response -> headers;
		foreach ($headers as $header) {
			header( $header );
		}
	}
	private function sendBody() {
		echo $this->response->body;
	}

}
?>