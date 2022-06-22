<?php

	switch ($urlE[3]) {
		case 'get':
			Request::get([ 'code' ]);
			$currencies->get();
			break;

		case 'list':
			$currencies->list();
			break;

		case 'convert':
			Request::get([ 'to', 'amount' ]);
			$currencies->convert();
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}