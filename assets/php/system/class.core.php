<?php

	class Core {

		public function basic() {
			Headers::setHttpCode(200);
			Headers::setContentType('application/json');

			echo json_encode([
				'name'				=>	Values::$basic['name'],
				'etag'				=>	Values::$basic['etag'],
				'company'			=>	Values::$basic['author'],
				'charset'			=>	Values::$basic['charset'],
				'language'			=>	Values::$basic['def_lang'],
				'links'				=>	[
					'base'			=>	Values::$assets['link'],
					'company'		=>	Values::$assets['core'],
					'api'			=>	Values::$assets['link'] . 'apis/',
				],
				'images'			=>	[
					'service'		=>	[
						'logo'		=>	Values::$images['logo'],
						'favicon'	=>	Values::$images['favicon'],
					],
					'company'		=>	[
						'logo'		=>	Values::$images['logo_company'],
						'favicon'	=>	Values::$images['favicon_company'],
					],
				]
			]);
		}

		public function json_read() {
			echo Files::read(Values::$assets['files'] . $_GET['file'] . '.json', [
				'json_encode'	=>	true,
			]);
		}
		
	}