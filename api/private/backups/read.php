<?php

	switch ($urlE[4]) {
		case 'data':
			Request::get([ 'product', 'username', 'table' ]);
			$app_backups_sqlite->show_data();
			break;

		case 'tables':
			Request::get([ 'product', 'username' ]);
			$app_backups_sqlite->show_tables();
			break;

		case 'struct':
			Request::get([ 'product', 'username', 'table' ]);
			$app_backups_sqlite->show_struct();
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}