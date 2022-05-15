<?php

	switch ($urlE[3]) {
		case 'get':
			Request::get([ 'product', 'username' ]);
			$app_backups->get();
			break;

		case 'read':
			require_once 'backups/read.php';
			break;

		case 'sync':
			Request::post([ 'backup', 'product', 'username' ]);
			$app_backups->sync();
			break;

		case 'delete':
			Request::post([ 'product', 'username' ]);
			$products->list_license();
			break;

		case 'download':
			Request::protect([ 'product', 'username' ]);
			$app_backups->download();
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}