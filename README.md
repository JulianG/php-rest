# PHP-Rest

ExpressJS-inspired web application framework for PHP.

## Wordk-in-progress

This is a work in progress. The framework is still missing a lot of features. I'm only adding features as I need them for my projects.

## Usage

Don't forget to add or edit your .htaccess file that will "catch" and send all requests to index.php

	DirectoryIndex index.php
	<IfModule mod_rewrite.c>
		RewriteEngine On
		RewriteRule ^$ index.php [QSA,L]
		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteCond %{REQUEST_FILENAME} !-d
		RewriteRule ^(.*)$ index.php [QSA,L]
	</IfModule>
	<ifModule mod_php5.c>
		php_flag display_errors On
	</IfModule>

Here's a sample index.php:

	<?php
	// Include the framework.
	require_once ('./rest/rest.php');

	// Create an instance.
	$rest = new Rest('/api/');

	// Bind as many paths as you like.
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

	// Finally, don't forget to call the start method.
	$rest -> start();
	?>