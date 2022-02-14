<?php

	switch ($urlE[2]) {
		case 'generate':
			Request::post([ 'email', 'type' ]);
			$otp_code->generate();
			break;
			
		case 'check-exists':
			Request::get([ 'slug' ]);
			$otp_code->check_exists();
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}