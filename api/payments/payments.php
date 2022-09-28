<?php

	switch ($urlE[2]) {
		case 'currencies':
			include_once 'currencies.php';
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}