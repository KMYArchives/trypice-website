<?php

	switch ($urlE[2]) {
		case 'backups':
			include_once 'backups.php';
			break;

		case 'app-files':
			include_once 'app-files.php';
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}