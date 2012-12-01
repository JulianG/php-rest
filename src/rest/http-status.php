<?php

function getHTTPStatusText($status_code) {
	$codes = Array();
	$codes['100'] = 'Continue';
	$codes['101'] = 'Switching Protocols';
	$codes['200'] = 'OK';
	$codes['201'] = 'Created';
	$codes['202'] = 'Accepted';
	$codes['203'] = 'Non-Authoritative Information';
	$codes['204'] = 'No Content';
	$codes['205'] = 'Reset Content';
	$codes['206'] = 'Partial Content';
	$codes['300'] = 'Multiple Choices';
	$codes['301'] = 'Moved Permanently';
	$codes['302'] = 'Moved Temporarily';
	$codes['303'] = 'See Other';
	$codes['304'] = 'Not Modified';
	$codes['305'] = 'Use Proxy';
	$codes['400'] = 'Bad Request';
	$codes['401'] = 'Unauthorized';
	$codes['402'] = 'Payment Required';
	$codes['403'] = 'Forbidden';
	$codes['404'] = 'Not Found';
	$codes['405'] = 'Method Not Allowed';
	$codes['406'] = 'Not Acceptable';
	$codes['407'] = 'Proxy Authentication Required';
	$codes['408'] = 'Request Time-out';
	$codes['409'] = 'Conflict';
	$codes['410'] = 'Gone';
	$codes['411'] = 'Length Required';
	$codes['412'] = 'Precondition Failed';
	$codes['413'] = 'Request Entity Too Large';
	$codes['414'] = 'Request-URI Too Large';
	$codes['415'] = 'Unsupported Media Type';
	$codes['500'] = 'Internal Server Error';
	$codes['501'] = 'Not Implemented';
	$codes['502'] = 'Bad Gateway';
	$codes['503'] = 'Service Unavailable';
	$codes['504'] = 'Gateway Time-out';
	$codes['505'] = 'HTTP Version not supported';
	
	$rsp = $codes[$status_code];
	if (!$rsp)
		$rsp = '';

	return $rsp;
}
?>