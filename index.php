<?php

	require_once 'assets/php/autoload.php';

	Headers::core();
	error_reporting(0);
	Request::protect([ 'url', 'i' ]);
	$urlE   =   explode('/', $_GET['url']);

	if (in_array($urlE[0], [
		null, 'home', 'product', 'products', 'support'
	])) {
		App::view(System::dir('pages') . 'page.php');
	} else if ($urlE[0] == 'login') {
		App::view(System::dir('pages') . 'login.php');
	} else if ($urlE[0] == 'account') {
		App::view(System::dir('pages') . 'account.php');
	} else if ($products->check_slug($urlE[0])) {
		App::view(System::dir('pages') . 'view-product.php');
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