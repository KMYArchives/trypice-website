<?php

	switch ($urlE[3]) {
		case 'pay':
			$payments->get();
			break;

		case 'keys':
			StripeInit::get_params_rest();
			break;

		case 'discount':
			// code...
			break;

		case 'subscribe':
			// code...
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}