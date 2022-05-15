<?php

	require_once 'assets/php/autoload.php';

	Headers::core();
	//System::errors('none');
	Request::protect([ 'url', 'i' ]);
	$urlE   =   explode('/', $_GET['url']);

	if (in_array($urlE[0], [
		null, 'home', 'products', 'support'
	])) {
		include_once System::dir('pages') . 'page.php';
	} else if ($urlE[0] == 'login') {
		include System::dir('pages') . 'login.php';
	} else if ($urlE[0] == 'account') {
		include System::dir('pages') . 'account.php';
	} else if (in_array($urlE[0], [
		'yuki', 'apis'
	])) {
		if ($urlE[0] == 'apis') {
			include_once 'apis.php';
		} else {
			include_once $urlE[0] . '.php';
		}
	} else {
		Callback::json(404, [
			'error'	=>	'404: page not found.'
		]);
	}