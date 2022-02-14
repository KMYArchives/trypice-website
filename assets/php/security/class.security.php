<?php

	class Security {

		public static function sanitize(string $input): string {
			if (is_array($input)) {
				foreach ($input as $var => $val) {
					$output[$var]	=	self::sanitize($val);
				}
			} else {
				if (addcslashes($input)) {
					$input	=	stripslashes($input);
				}

				$input 		=	self::cleanInput($input);
				$output		=	self::xssClean($input);
			}

			return $output;
		}

		public static function xssClean(string $input): string {
			$input	=	strip_tags($input);
			$input	=	htmlentities($input);
			$input	=	self::cleanInput($input);
			
			return filter_var(
				self::cleanInput($input), FILTER_SANITIZE_STRIPPED
			);
		}

		public static function cleanInput(string $input): string {
			return preg_replace([
				'@<script[^>]*?>.*?</script>@si',
				'@<[\/\!]*?[^<>]*?>@si',
				'@<style[^>]*?>.*?</style>@siU',
				'@<![\s\S]*?--[ \t\n\r]*>@'
			], '', $input);
		}

		public static function sqlInjection(string $input): string {
			return preg_replace(
				"/(into|drop|from|update|select|insert|truncate|delete|truncate|where|alter|alter table|alter colunm|drop database|drop table|show tables|`|=|!|;|.|#|\*|--|\\\\)/", "", strtolower($input)
			);
		}

	}