<?php

	match ($urlE[1]) {
		default			=>	Callback::json(404, [
			'error'		=>	'Argument invalid...',
		]),

		'core'			=>	include_once System::dir('apis') . 'core/core.php',
		'csrf'			=>	include_once System::dir('apis') . 'login/csrf.php',
		'login'			=>	include_once System::dir('apis') . 'login/login.php',
		'otp-code'		=>	include_once System::dir('apis') . 'login/otp-code.php',
		'account'		=>	include_once System::dir('apis') . 'account/account.php',
	};