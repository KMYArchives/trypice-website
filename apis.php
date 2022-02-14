<?php

	switch ($urlE[1]) {
		case 'core':
			include_once System::dir('apis') . 'core/core.php';
			break;

		case 'csrf':
			include_once System::dir('apis') . 'login/csrf.php';
			break;

		case 'login':
			include_once System::dir('apis') . 'login/login.php';
			break;

		case 'account':
			include_once System::dir('apis') . 'account/account.php';
			break;

		case 'otp-code':
			include_once System::dir('apis') . 'login/otp-code.php';
			break;
		
		default:
			Headers::setHttpCode(404);
			Headers::setContentType('application/json');
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}