<?php

	match($urlE[1]) {
		'js'	=>	$yuki->js('index'),
		'css'	=>	$yuki->css('index'),
		'json'	=>	$yuki->json($urlE[2]),
		'image'	=>	$yuki->image($urlE[2]),
		'video'	=>	$yuki->video($urlE[2]),
		
		default	=>	Headers::setLocation(
			System::links('website')
		),
	};