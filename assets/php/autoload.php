<?php

	require_once 'vendor/autoload.php';
	require_once 'assets/php/yuki/autoload.php';

	foreach ([ 
		// Global
		'global/page/',
		'global/core/',
		'global/utils/',
		'global/system/',
		'global/security/',

		// Platform
		'platform/login/',
		'platform/public/',
		'platform/private/',
		'platform/account/',
		'platform/payments/',
		'platform/public/products/',
	] as $p) {
		foreach (scandir(__DIR__ . '/' . $p) as $file) {
			if (!in_array(
				substr($file, 0, 1), [ '_' ]
			) && is_file(
				__DIR__ . '/' . $p . $file
			) && pathinfo(
				$file, PATHINFO_EXTENSION
			) == 'php') {
				require_once $p . $file;
			}
		}
	}

	// Login
	$csrf			=	new CSRF;
	$login			=	new Login;
	$sign_up		=	new Signup;
	$otp_code		=	new OTPCode;

	// Public
	$menu			=	new Menu;
	$pages			=	new Pages;
	$prices			=	new Prices;
	$setups			=	new Setups;
	$support		=	new Support;
	$products		=	new Products;

	// Account
	$trials			=	new Trials;
	$linked			=	new Linked;
	$clients		=	new Clients;
	$devices		=	new Devices;
	$details		=	new Details;
	$licenses		=	new Licenses;

	// Private
	$app_files		=	new AppFiles;
	$app_backups	=	new AppBackups;