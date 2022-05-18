<?php

	class Str {

		public static function last_slice($string, $char) {
			return end(
				explode($char, $string)
			);
		}

		public static function count_slice($string, $char) {
			return count(
				explode($char, $string)
			);
		}

		public static function slice($string, $char, $slice) {
			return substr(
				$string, $slice, strpos(
					$string, $char
				)
			);
		}

		public static function search($string, $find, $pos = false) {
			if (strpos($string, $find) != false) {
				if ($pos == true) {
					return strpos($string, $find);
				} else {
					return true;
				}
			} else {
				return false;
			}
		}

		public static function cut($string, $limit, $word_wrap = true) {
			if (strlen($string) <= $limit) {
				return $string;
			} else {
				if ($word_wrap == true) {
					return trim(
						substr($string, 0, $limit)
					) . '...';
				} else if ($word_wrap == false) {
					$ls_spa	=	strrpos(
						substr($string, 0, $limit), ' '
					);
					
					return trim(
						substr($string, 0, $lst_sp)
					) . '...';
				}
			}
		}

	}