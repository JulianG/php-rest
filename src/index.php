<?php
require_once ('./rest/rest.php');

$rest = new Rest('/api/');

$rest -> bind('get', 'users/', function($req, $res) {
	$res -> status = 200;
	$res -> body = 'here you can list all users';
});
$rest -> bind('get', 'users/:uid', function($req, $res) {
	$res -> status = 200;
	$res -> body = 'here you can return user with uid: ' . $req->params['uid'];
});
$rest -> bind('get', 'users/:uid/follower/:fid', function($req, $res) {
	$res -> status = 200;
	$res -> body = 'here you can return follower fid:' . $req->params['fid'] . ' of user uid:' . $req->params['uid'];
});

$rest -> start();
?>