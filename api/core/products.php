<?php

	switch ($urlE[3]) {
		case 'get':
			Request::get([ 'slug' ]);
			$products->get();
			break;

		case 'list':
			Request::protect([ 'offset' ]);
			$products->list();
			break;

		case 'list-licenses':
			Request::protect([ 'offset' ]);
			$products->list_license();
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}