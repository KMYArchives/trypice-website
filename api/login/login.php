<?php

	switch ($urlE[2]) {
		case 'login':
			Request::post([ 'email', 'pass', 'origin' ]);
			$login->login();
			break;

		case 'signup':
			Request::post([ 'name', 'email', 'pass' ]);
			$sign_up->execute();
			break;
			
		case 'logoff':
			$login->sign_out();
			break;

		case 'recovery':
			Request::post([ 'code', 'new-pass', 'conf-pass' ]);
			$login->recovery();
			break;

		case 'check-logged':
			$login->check_logged();
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}