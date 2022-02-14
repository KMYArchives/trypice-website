<?php

	switch ($urlE[3]) {
		case 'list':
			Request::get([ 'slug' ]);
			Request::protect([ 'offset', 'term', 'trials' ]);
			$linked->list();
			break;

		case 'unlink':
			Request::post([ 'slug' ]);
			$linked->unlink();
			break;
			
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}