<?php
$path = realpath(dirname(__FILE__)) . '/';
require_once ($path . 'http-status.php');
require_once ($path . 'request.php');
require_once ($path . 'response.php');
require_once ($path . 'binder.php');

function handleError($errno, $errstr, $errfile, $errline, array $errcontext)
{
    throw new ErrorException($errstr . ' ' . $errno , $errno, 0, $errfile, $errline);
}	

class Rest {

	public $debugMode = false;
	public $request;
	public $response;

	private $binder;

	public $contentType = 'application/json; charset=UTF-8';
	// charset=iso-8859-1

	public function Rest($path_prefix, $debugMode = false) {
		$this -> binder = new Binder();
		$this -> request = new Request($path_prefix);
		$this -> response = new Response();
		$this -> debugMode = $debugMode;
	}

	public function bind($method, $path, $callback) {
		$this -> binder -> bind($method, $path, $callback);
	}

	public function process() {
		set_error_handler('handleError');
		try {
			$this -> binder -> process($this -> request, $this -> response);
		} catch( Exception $e) {
			$this -> response -> status = (is_numeric($e -> getCode())) ? $e -> getCode() : 500;
			$this -> response -> body = ($this -> debugMode) ? $e -> getMessage() : 'Internal Server Error.';
			$this -> response -> exception = $e;
		}
		restore_error_handler();
	}

	/**
	 * Sends the status code, headers and body
	 */
	public function sendResponse() {
		$this -> sendStatus();
		$this -> sendHeaders();
		$this -> sendBody();
	}

	private function sendStatus() {		
		$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
		$status_code = (int) $this -> response -> status;
		$status_text = getHTTPStatusText( $status_code );
		header($protocol . ' ' . $status_code . ' ' . $status_text); 
	}

	private function sendHeaders() {
		$headers = $this -> response -> headers;
		foreach ($headers as $header) {
			header($header);
		}
		header('Content-type: ' . $this -> contentType);
	}

	private function sendBody() {
		if ($this -> response -> exception != NULL && $this -> response -> status >= 500 && $this -> response -> status < 600 && $this -> debugMode) {
			echo $this -> response -> exception;
		} else {
			echo $this -> response -> getBodyString();
		}
	}

}
?>