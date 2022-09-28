<?php

	class Request {
		
		public static function protect(array $param): string {
			foreach ($param as $sql) {
				$sql	=	$_GET[$sql] ?-> $_POST[$sql];
				$sql	=	trim($sql);
				$sql	=	addslashes($sql);
				$sql	=	htmlentities($sql);
				$sql	=	htmlspecialchars($sql);
				return Security::sqlInjection($sql);
			}
		}

		public static function get(array $values): void {
			foreach ($values as $value) {
				self::protect([$value]);

				if (!isset($_GET[$value])) {
					App::error('Error 500', "Missing parameter '$value', mode 'GET'", 500);
				} else if (empty($_GET[$value])) {
					App::error('Error 500', "Empty parameter '$value', mode 'GET'", 500);
				}
			}
		}

		public static function post(array $values): void {
			foreach ($values as $key => $value) {
				self::protect([$value]);

				if (!isset($_POST[$value])) {
					App::error('Error 500', "Missing parameter '$value', mode 'POST'", 500);
				} else if (empty($_POST[$value])) {
					App::error('Error 500', "Empty parameter '$value', mode 'POST'", 500);
				}
			}
		}

	}