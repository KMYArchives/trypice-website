<?php

	class Validation {

		public static function ip($string, $request = null) {
			if (in_array($request, [ 'post', 'get' ])) {
				if ($request == 'get') {
					$string		=	$_GET[$string];
				} else {
					$string		=	$_POST[$string];
				}
			}

			if (filter_var($string, FILTER_VALIDATE_IP)) {
				return true;
			} else {
				return false;
			}
		}

		public static function int($string, $request = null) {
			if (in_array($request, [ 'post', 'get' ])) {
				if ($request == 'get') {
					$string		=	$_GET[$string];
				} else {
					$string		=	$_POST[$string];
				}
			}

			if (filter_var($string, FILTER_VALIDATE_INT)) {
				return true;
			} else {
				return false;
			}
		}

		public static function url($string, $request = null) {
			if (in_array($request, [ 'post', 'get' ])) {
				if ($request == 'get') {
					$string		=	$_GET[$string];
				} else {
					$string		=	$_POST[$string];
				}
			}

			if (filter_var($string, FILTER_VALIDATE_URL)) {
				return true;
			} else {
				return false;
			}
		}

		public static function hash($string, $request = null) {
			if (in_array($request, [ 'post', 'get' ])) {
				if ($request == 'get') {
					$string		=	$_GET[$string];
				} else {
					$string		=	$_POST[$string];
				}
			}

			if (preg_match("/[a-z0-9]{8,128}/", $string)) {
				return true;
			} else {
				return false;
			}
		}

		public static function uuid($string, $request = null) {
			if (in_array($request, [ 'post', 'get' ])) {
				if ($request == 'get') {
					$string		=	$_GET[$string];
				} else {
					$string		=	$_POST[$string];
				}
			}

			if (preg_match("/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/", $string)) {
				return true;
			} else {
				return false;
			}
		}

		public static function float($string, $request = null) {
			if (in_array($request, [ 'post', 'get' ])) {
				if ($request == 'get') {
					$string		=	$_GET[$string];
				} else {
					$string		=	$_POST[$string];
				}
			}

			if (filter_var($string, FILTER_VALIDATE_FLOAT)) {
				return true;
			} else {
				return false;
			}
		}

		public static function email($string, $request = null) {
			if (in_array($request, [ 'post', 'get' ])) {
				if ($request == 'get') {
					$string		=	$_GET[$string];
				} else {
					$string		=	$_POST[$string];
				}
			}

			if (filter_var($string, FILTER_VALIDATE_EMAIL)) {
				return true;
			} else {
				return false;
			}
		}

		public static function domain($string, $request = null) {
			if (in_array($request, [ 'post', 'get' ])) {
				if ($request == 'get') {
					$string		=	$_GET[$string];
				} else {
					$string		=	$_POST[$string];
				}
			}

			if (filter_var($string, FILTER_VALIDATE_DOMAIN)) {
				return true;
			} else {
				return false;
			}
		}

		public static function base64($string, $request = null) {
			if (in_array($request, [ 'post', 'get' ])) {
				if ($request == 'get') {
					$string		=	$_GET[$string];
				} else {
					$string		=	$_POST[$string];
				}
			}

			if (preg_match("/^[-A-Za-z0-9+=]{1,50}|=[^=]|={3,}$/", $string)) {
				return true;
			} else {
				return false;
			}
		}

		public static function boolean($string, $request = null) {
			if (in_array($request, [ 'post', 'get' ])) {
				if ($request == 'get') {
					$string		=	$_GET[$string];
				} else {
					$string		=	$_POST[$string];
				}
			}

			if (is_bool($string)) {
				return true;
			} else {
				return false;
			}
		}

		public static function date($string, $format = 'Y-m-d', $request = null) {
			if (in_array($request, [ 'post', 'get' ])) {
				if ($request == 'get') {
					$string		=	$_GET[$string];
				} else {
					$string		=	$_POST[$string];
				}
			}

			try {
				$fTime	=	new DateTime($string);
				$fTime->format($format);
				
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

	}