<?php

	Callback::json(200, [
		'logo'				=>	System::images('logo'),
		'name'				=>	System::global('name'),
		'slogan'			=>	System::global('slogan'),
		'charset'			=>	System::global('charset'),
		'favicon'			=>	System::images('favicon'),
		'language'			=>	System::global('language'),
		'default_cover'		=>	System::images('user-cover'),
		'default_avatar'	=>	System::images('default-avatar'),
	]);