<?php

	class Regex {

		public static function int($int) {
			return preg_match('/^[0-9]+$/', $int);
		}

		public static function email($email) {
			return preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,6}$/', $email);
		}

		public static function phone($phone) {
			return preg_match('/^[0-9]{10}$/', $phone);
		}

		public static function date($date) {
			return preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date);
		}

		public static function time($time) {
			return preg_match('/^[0-9]{2}:[0-9]{2}$/', $time);
		}

		public static function name($name) {
			return preg_match('/^[a-zA-Z ]+$/', $name);
		}

		public static function dateTime($dateTime) {
			return preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}$/', $dateTime);
		}

		public static function url($url) {
			return preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url);
		}

		public static function ip($ip) {
			return preg_match('/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/', $ip);
		}

		public static function alpha($string) {
			return preg_match('/^[a-zA-Z]+$/', $string);
		}

		public static function alphaNumeric($string) {
			return preg_match('/^[a-zA-Z0-9]+$/', $string);
		}

		public static function alphaDash($string) {
			return preg_match('/^[a-zA-Z0-9_\-]+$/', $string);
		}

		public static function alphaDashDot($string) {
			return preg_match('/^[a-zA-Z0-9_\-\.]+$/', $string);
		}

		public static function hash($hash) {
			return preg_match('/^[a-z0-9]{32}$/', $hash);
		}

		public static function hex($hex) {
			return preg_match('/^[a-f0-9]+$/i', $hex);
		}

		public static function hexColor($hex) {
			return preg_match('/^#?([a-f0-9]{6}|[a-f0-9]{3})$/i', $hex);
		}

		public static function rgbColor($rgb) {
			return preg_match('/^rgb\(((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(,\s?)?){2}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\)$/', $rgb);
		}

		public static function rgbaColor($rgba) {
			return preg_match('/^rgba\(((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(,\s?)?){3}(0?\.\d+|1(\.0+)?)\)$/', $rgba);
		}

		public static function address($address) {
			return preg_match('/^[a-zA-Z0-9\s\-,.#]+$/', $address);
		}

	}