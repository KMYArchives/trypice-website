<?php

	switch ($urlE[3]) {
		case 'get':
			Request::get([ 'product', 'platform' ]);
			$setups->get();
			break;

		case 'list':
			Request::get([ 'slug' ]);
			$setups->list();
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}