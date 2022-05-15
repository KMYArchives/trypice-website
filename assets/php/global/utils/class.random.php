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

		public static function uniqid (): string {
			return uniqid(
				mt_rand(), true
			);
		}

		public static function slug(int|array $size): string {
			$string		=	'0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

			if (is_array($size)) {
				$size	=	rand(
					$size[0], $size[1]
				);
			}

			for ($n = 1; $n <= $size; $n++) {
				$rand	=	mt_rand(
					1, strlen($string)
				);
				
				$ret	.=	$string[$rand - 1];
			}

			return $ret;
		}

		public static function string(int $size, bool $low, bool $upp, bool $num, bool $sym = false): string {
			$string		=	null;
			$char		=	[
				'num'	=>	'0123456789',
				'sym'	=>	'?!@#$%*/&()[]{}+-_=.,;',
				'low'	=>	'abcdefghijklmnopqrstuvwxyz',
				'upp'	=>	'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
			];

			if ($low) { $string .= $char['low']; }
			if ($upp) { $string .= $char['upp']; }
			if ($num) { $string .= $char['num']; }
			if ($sym) { $string .= $char['sym']; }

			for ($n = 1; $n <= $size; $n++) {
				$rand	=	mt_rand(1, strlen($string));
				$ret	.=	$string[$rand - 1];
			}

			return $ret;
		}

	}