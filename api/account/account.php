<?php

	switch ($urlE[2]) {
		case 'trials':
			include_once 'trials.php';
			break;

		case 'orders':
			include_once 'orders.php';
			break;

		case 'linked':
			include_once 'linked.php';
			break;

		case 'clients':
			include_once 'clients.php';
			break;

		case 'devices':
			include_once 'devices.php';
			break;

		case 'licenses':
			include_once 'licenses.php';
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}