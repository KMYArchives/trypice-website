<?php

	class Random {

		public static function uuid(): string {
			return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
				mt_rand(0, 0xffff), mt_rand(0, 0xffff),
				mt_rand(0, 0xffff),
				mt_rand(0, 0x0fff) | 0x4000,
				mt_rand(0, 0x3fff) | 0x8000,
				mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
			);
		}

		public static function uniqid(): string {
			return uniqid(
				mt_rand(), true
			);
		}

		public static function int(int $size): string {
			$string		=	'0123456789';

			for ($n = 1; $n <= $size; $n++) {
				$rand	=	mt_rand(1, strlen($string));
				$ret	.=	$string[$rand - 1];
			}

			return $ret;
		}

		public static function lower(int $size): string {
			$string		=	'abcdefghijklmnopqrstuvwxyz';

			for ($n = 1; $n <= $size; $n++) {
				$rand	=	mt_rand(1, strlen($string));
				$ret	.=	$string[$rand - 1];
			}

			return $ret;
		}

		public static function upper(int $size): string {
			$string		=	'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

			for ($n = 1; $n <= $size; $n++) {
				$rand	=	mt_rand(1, strlen($string));
				$ret	.=	$string[$rand - 1];
			}

			return $ret;
		}

		public static function special(int $size): string {
			$string		=	'?!@#$%*/&()[]{}+-_=.,;';

			for ($n = 1; $n <= $size; $n++) {
				$rand	=	mt_rand(1, strlen($string));
				$ret	.=	$string[$rand - 1];
			}

			return $ret;
		}

		public static function slug(int|array $size): string {
			$string		=	'0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

			if (is_array($size)) {
				if (is_int($size[0]) && is_int($size[1])) {
					$size	=	rand(
						$size[0], $size[1]
					);
				}
			}

			for ($n = 1; $n <= $size; $n++) {
				$rand	=	mt_rand(
					1, strlen($string)
				);
				
				$ret	.=	$string[$rand - 1];
			}

			return $ret;
		}

		public static function string(int|array $size, array $configs): string {
			$string		=	null;
			$char		=	[
				'num'	=>	'0123456789',
				'sym'	=>	'?!@#$%*/&()[]{}+-_=.,;',
				'low'	=>	'abcdefghijklmnopqrstuvwxyz',
				'upp'	=>	'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
			];

			if (is_array($size)) {
				if (is_int($size[0]) && is_int($size[1])) {
					$size	=	rand(
						$size[0], $size[1]
					);
				}
			}

			if ($configs['lower'] == true) { $string .= $char['low']; }
			if ($configs['upper'] == true) { $string .= $char['upp']; }
			if ($configs['numbers'] == true) { $string .= $char['num']; }
			if ($configs['special'] == true) { $string .= $char['sym']; }

			for ($n = 1; $n <= $size; $n++) {
				$rand	=	mt_rand(1, strlen($string));
				$ret	.=	$string[$rand - 1];
			}

			if ($configs['base64'] == true) { return base64_encode($ret); }
			return $ret;
		}

	}