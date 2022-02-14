<?php

	require_once 'class.hash.php';

	class OpenSSL extends Hash {

		static $config	=	[
			'method'	=>	'AES-256-CBC',
			'iv'		=>	'U@rt1#5Yk&%H+=8C',
			'key'		=>	'GeUy4kqfFDw4XhRfgHhi3hIAb01N6EspT886UHXXWmDN7s5A',
			'keys'		=>	[ '4O547VgPamADHdYLfd12LKCVmB9aIFuK', '2MoaFjB0FII1xFavQx37XFe65MPdPG9z' ],
		];

		protected static function merge($type, $user_key = null) {
			if ($type == 'key') {
				return parent::openssl(self::$config['keys'][0] . self::$config['key'] . $user_key . self::$config['keys'][1]);
			} else if ($type == 'iv') {
				return parent::openssl_iv(self::$config['iv']);
			}
		}

		public static function encrypt($input, $user_key = null) {
			if ($user_key != null) {
				return openssl_encrypt($input, self::$config['method'], self::merge('key', $user_key), 0, self::merge('iv'));
			}

			return openssl_encrypt($input, self::$config['method'], self::merge('key'), 0, self::merge('iv'));
		}

		public static function decrypt($input, $user_key = null) {
			if ($user_key != null) {
				return openssl_decrypt($input, self::$config['method'], self::merge('key', $user_key), 0, self::merge('iv'));
			}

			return openssl_decrypt($input, self::$config['method'], self::merge('key'), 0, self::merge('iv'));
		}

		public static function pbkdf($string, $salt = 12, $key_size = 40, $iterations = 10000, $algo = 'sha256') {
			return bin2hex(
				openssl_pbkdf2(
					$string, openssl_random_pseudo_bytes($salt), $key_size, $iterations, $algo
				)
			);
		}

	}