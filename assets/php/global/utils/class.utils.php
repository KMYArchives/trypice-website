<?php

	class Utils {

		public static function load_env() {
			$dotenv		=	Dotenv\Dotenv::createImmutable(__DIR__);
			$dotenv->load();
		}

		public static function show_errors(string $level) {
			return match ($level) {
				default		=>	error_reporting(0),
				'none'		=>	error_reporting(0),
				'high'		=>	error_reporting(E_ALL),
				'low'		=>	error_reporting(E_ALL & ~E_NOTICE),
				'medium'	=>	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING),
				'default'	=>	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING),
			};
		}

	}