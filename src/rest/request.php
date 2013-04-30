<?php

class Request {

	public $method;
	public $path;
	public $params;
	public $body;
	public $query;
	public $headers;

	private $pathPrefix;

	public function Request($path_prefix) {
		$this -> pathPrefix = $path_prefix;
		$this -> init();
	}

	private function init() {
		$this -> method = $this -> getMethod();
		$this -> path = $this -> getPath();
		$this -> headers = $this -> getHeaders();
		$this -> body = $_POST;
		$this -> query = $_GET;
	}

	private function getMethod() {
		return $_SERVER['REQUEST_METHOD'];
	}

	private function getRequest() {
		return parse_url($_SERVER['REQUEST_URI']);
	}

	private function getPath() {
		$r = $this -> getRequest();
		$path = $r['path'];
		$prefix_len = strlen($this -> pathPrefix);
		if (substr($path, 0, $prefix_len) == $this -> pathPrefix) {
			$path = substr($path, $prefix_len);
		}
		return $path;
	}

	private function getHeaders() {
		$headers = array();
		foreach ($_SERVER as $k => $v) {
			if (substr($k, 0, 5) == "HTTP_") {
				$k = str_replace('_', ' ', substr($k, 5));
				$k = str_replace(' ', '-', ucwords(strtolower($k)));
				$headers[$k] = $v;
			}
		}
		return $headers;
	}

}
?>
