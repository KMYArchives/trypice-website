<?php

	switch ($urlE[3]) {
		case 'get':
			Request::get([ 'slug' ]);
			$licenses->get();
			break;

		case 'list':
			Request::protect([ 'offset' ]);
			$licenses->list();
			break;

		case 'linked':
			Request::get([ 'slug' ]);
			Request::protect([ 'offset' ]);
			$licenses->linked();
			break;

		case 'create':
			Request::get([ 'paypal', 'product' ]);
			$licenses->create();
			break;

		case 'details':
			Request::get([ 'slug' ]);
			$licenses->details();
			break;

		case 'favorite':
			Request::post([ 'slug' ]);
			$licenses->favorite();
			break;

		case 'activation':
			Request::post([ 'ip', 'os', 'cpu', 'uuid', 'model', 'type', 'hostname', 'serial', 'product' ]);
			$licenses->activation();
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}