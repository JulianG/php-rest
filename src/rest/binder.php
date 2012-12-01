<?php

class Binder {

	private $bindings;

	public function Binder() {
		$this -> bindings = Array();
	}

	public function bind($method, $path, $callback) {
		$method = strtoupper($method);
		array_push($this -> bindings, Array('method' => $method, 'path' => $path, 'callback' => $callback));
	}

	public function process(Request $req, Response $res) {
		$req -> method = strtoupper($req -> method);
		$bindings = $this -> getMatchingBindings($req);
		if (count($bindings) > 0) {
			foreach ($bindings as $b) {
				// each match generates a different list of parameters
				$req -> params = $b['params'];
				$b['callback']($b['req'], $res);
			}
		} else {
			throw new Exception('Not Found', 404);
		}
	}

	private function getMatchingBindings($req) {
		$list = Array();
		foreach ($this->bindings as $binding) {
			if ($binding['method'] == "ALL" || $binding['method'] == $req -> method) {
				$params = $this -> getMatchingParams($binding['path'], $req -> path);
				if ($params !== NULL) {
					$binding['params'] = Array();
					foreach ($params as $key => $val) {
						$binding['params'][$key] = $val;
					}
					$binding['req'] = $req;
					array_push($list, $binding);
				}
			}
		}
		return $list;
	}

	private function getMatchingParams($expression, $path) {
		$params = Array();
		$expression_parts = $this -> removeEmptyStrings(explode('/', $expression));
		$path_parts = $this -> removeEmptyStrings(explode('/', $path));
		$ok = true;
		if (count($expression_parts) == count($path_parts)) {
			for ($i = 0; $i < count($expression_parts) && $ok; $i++) {
				if (substr($expression_parts[$i], 0, 1) == ":") {
					$key = substr($expression_parts[$i], 1);
					$params[$key] = $path_parts[$i];
				} else {
					if ($expression_parts[$i] != $path_parts[$i]) {
						$ok = false;
						$params = NULL;
					} else {
						//$params = Array();
					}
				}
			}
		} else {
			$params = NULL;
		}
		return $params;
	}

	private function removeEmptyStrings($array) {
		$new_array = Array();
		foreach ($array as $item) {
			if ($item != '')
				array_push($new_array, $item);
		}
		return $new_array;
	}

}
?>