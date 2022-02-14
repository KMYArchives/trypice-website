<?php

	switch ($urlE[3]) {
		case 'stats':
			$details->stats();
			break;

		case 'region':
			$details->region();
			break;

		case 'details':
			Request::protect([ 'username' ]);
			$details->details();
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}