<?php

	switch ($urlE[3]) {
		case 'get':
			Request::get([ 'slug' ]);
			$trials->get();
			break;

		case 'list':
			Request::protect([ 'offset', 'product' ]);
			$trials->list();
			break;

		case 'verify':
			Request::protect([ 'slug' ]);
			Request::post([ 'username', 'product' ]);
			$trials->verify();
			break;

		case 'create':
			Request::get([ 'username', 'product' ]);
			$trials->create();
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}