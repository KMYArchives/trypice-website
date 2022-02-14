<?php

	switch ($urlE[3]) {
		case 'telemetry':
			// code...
			break;
		
		default:
			echo json_encode([ 'error' => 'Argument invalid...' ]);
			break;
	}