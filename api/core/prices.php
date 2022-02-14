<?php

	switch ($urlE[3]) {
		case 'get':
			Request::get([ 'slug' ]);
			$prices->get();
			break;

		case 'list':
			Request::get([ 'slug' ]);
			$prices->list();
			break;

		case 'validate-discount':
			Request::post([ 'coupon' ]);
			$prices->validate_discount();
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}