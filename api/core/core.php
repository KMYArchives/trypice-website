<?php

	switch ($urlE[2]) {
		case 'stripe':
			include_once 'stripe.php';
			break;

		case 'engine':
			include_once 'engine.php';
			break;

		case 'prices':
			include_once 'prices.php';
			break;

		case 'setups':
			include_once 'setups.php';
			break;

		case 'products':
			include_once 'products.php';
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}