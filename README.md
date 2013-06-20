# PHP-Rest

ExpressJS-inspired web application mini-framework for PHP.

## Work-in-progress

This is a work in progress. The framework is still missing a lot of features. I'm only adding features as I need them for my projects.

## Usage

Don't forget to add or edit your .htaccess file. This will "catch" and send all requests to index.php

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
	
	$rest->debugMode = false; // remove this in production

	// Bind as many paths as you like.
	$rest->bind('get', 'users/', function(Request $req, Response $res) {
		$res->status = 200;
		$res->body = 'here you can list all users';
	});
	$rest->bind('get', 'users/:uid', function(Request $req, Response $res) {
		$res->status = 200;
		$res->body = 'here you can return user with uid: ' . $req->getParam('uid');
	});
	$rest->bind('get', 'users/:uid/follower/:fid', function(Request $req, Response $res) {
		$res->status = 200;
		$res->body = 'here you can return follower fid:' . $req->getParam('fid') . ' of user uid:' . $req->getParam('uid');
	});

	$rest->bind('post', 'users/', function(Request $req, Response $res) {
		$name = $req->getBodyParam('name');
		$email = $req->getBodyParam('email');
		$password = $req->getBodyParam('password');
		$user_id = createUser($name, $email, $password);
		$res->status = 201; // 201 - created
		$res->body = $user_id;
	});

	$rest->bind('put', 'users/:uid', function(Request $req, Response $res) {
		$id = $req->getParam('uid');
		$name = $req->getBodyParam('name');
		$email = $req->getBodyParam('email');
		$password = $req->getBodyParam('password');
		$ok = updateUser($id, $name, $email, $password);
		$res->status = 200;
		$res->body = $ok;
	});

	// Finally, we call the process method.
	$rest->process();
	// here you can modify the $rest->response before it's sent, but I don't recommend it.
	$rest->sendResponse();
	?>
	
### Catching Errors

If you throw an Exception in callback function, the exception code will be used as http status code, and the exception message will be sent in the body.
For instance, if you want to indicate that a specific resource is not found, you can simply throw an exception like this:

	throw( new Exception('user not found', 404) );
	
The framework will send the appropiate http status code (404) and your message will be sent in the body.

The same applies if you want to indicate a bad request, you can throw a 400 exception:

	throw( new Exception('email and address are required', 400) );

### Parse Errors and Fatal Errors

Parse errors and fatal errors aren't being caught yet. I need to figure out how to do it. MySQL errors are caught and sent as error 500.

### PHP v5.2 and older ###

The example above use anonymous functions or closures, but those are anoly available since PHP v5.3.0. If you're running an older version of PHP you can do something like this:

	function _listBananas(Request $req, Response $res) {
		$res->status = 200;
		$res->body = Array(...); // list of bananas
	}
	$rest->bind('get', 'bananas/', '_listBananas');

---------------------------
Updated 2013-06-20

