<?php

	switch ($urlE[3]) {
		case 'list-all':
			Request::get([ 'product' ]);
			$app_files->list_all();
			break;

		case 'database':
			Request::get([ 'product' ]);
			$app_files->database();
			break;

		case 'download':
			Request::protect([ 'file', 'product' ]);
			$app_files->download();
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}