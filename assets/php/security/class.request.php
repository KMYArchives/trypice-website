<?php

	class Request {

		private static function _error(array $debug) {
			echo match ($debug['type']) {
				'cookie'	=>	"Missing cookie: " . $debug['param'] . " (mode: " . strtoupper($debug['mode']) . ")\n",
				'empty'		=>	"Empty parameter: " . $debug['param'] . " (mode: " . strtoupper($debug['mode']) . ")\n",
				'missing'	=>	"Missing parameter: " . $debug['param'] . " (mode: " . strtoupper($debug['mode']) . ")\n",
			};
		}
		
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
					Headers::setHttpCode(403);

					self::_error([
						'mode'	=>	'get',
						'param'	=>	$value,
						'type'	=>	'missing',
					]);

					die;
				} else if (empty($_GET[$value])) {
					Headers::setHttpCode(403);
					
					self::_error([
						'mode'	=>	'get',
						'param'	=>	$value,
						'type'	=>	'empty',
					]);

					die;
				}
			}
		}

		public static function post(array $values): void {
			foreach ($values as $key => $value) {
				self::protect([$value]);

				if (!isset($_POST[$value])) {
					self::_error([
						'mode'	=>	'post',
						'param'	=>	$value,
						'type'	=>	'missing',
					]);
				} else if (empty($_POST[$value])) {
					self::_error([
						'mode'	=>	'post',
						'param'	=>	$value,
						'type'	=>	'empty',
					]);
				}
			}
		}

		public static function validate_request (string $cookie, array $params, string $mode): bool {
			if (Cookies::has($cookie)) {
				if ($mode == 'get') {
					self::get($params);
				} else {
					self::post($params);
				}
			} else {
				self::_error([
					'param'	=>	$cookie,
					'mode'	=>	'cookie',
					'type'	=>	'cookie',
				]);

				die;
			}
		}

	}