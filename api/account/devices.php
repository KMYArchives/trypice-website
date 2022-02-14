<?php

	switch ($urlE[3]) {
		case 'add':
			Request::post([ 'ip', 'os', 'cpu', 'uuid', 'hostname', 'username' ]);
			$devices->create();
			break;

		case 'get':
			Request::get([ 'slug' ]);
			$devices->get();
			break;
			
		case 'edit':
			Request::post([ 'os', 'cpu', 'uuid', 'hostname', 'username' ]);
			$devices->edit();
			break;

		case 'list':
			Request::protect([ 'offset', 'favorited', 'term' ]);
			$devices->list();
			break;

		case 'delete':
			Request::post([ 'slug' ]);
			$devices->delete();
			break;

		case 'favorite':
			Request::post([ 'slug' ]);
			$devices->favorited();
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}