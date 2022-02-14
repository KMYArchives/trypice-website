<?php

	switch ($urlE[3]) {
		case 'pay':
			Request::post([ 'email', 'token', 'price', 'prod_name', 'currency' ]);
			$orders->pay();
			break;

		case 'get':
			Request::get([ 'slug' ]);
			$orders->get();
			break;

		case 'list':
			Request::protect([ 'offset', 'term' ]);
			$orders->list();
			break;
			
		case 'get-keys':
			StripeInit::get_params_rest();
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}