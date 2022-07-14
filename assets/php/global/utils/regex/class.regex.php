<?php

	class Regex {

		public static function ip(string $ip): string {
			return preg_match('/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/', $ip);
		}

		public static function int(string $int): string {
			return preg_match('/^[0-9]+$/', $int);
		}

		public static function url(string $url): string {
			return preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url);
		}

		public static function hex(string $hex): string {
			return preg_match('/^[a-f0-9]+$/i', $hex);
		}

		public static function name(string $name): string {
			return preg_match('/^[a-zA-Z ]+$/', $name);
		}

		public static function hash(string $hash): string {
			return preg_match('/^[a-z0-9]{8,128}$/', $hash);
		}

		public static function date(string $date): string {
			return preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date);
		}

		public static function time(string $time): string {
			return preg_match('/^[0-9]{2}:[0-9]{2}$/', $time);
		}

		public static function email(string $email): string {
			return preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,6}$/', $email);
		}

		public static function phone(string $phone): string {
			return preg_match('/^[0-9]{10}$/', $phone);
		}

		public static function alpha(string $string): string {
			return preg_match('/^[a-zA-Z]+$/', $string);
		}

		public static function hexColor(string $hex): string {
			return preg_match('/^#?([a-f0-9]{6}|[a-f0-9]{3})$/i', $hex);
		}

		public static function rgbColor(string $rgb): string {
			return preg_match('/^rgb\(((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(,\s?)?){2}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\)$/', $rgb);
		}

		public static function rgbaColor(string $rgba): string {
			return preg_match('/^rgba\(((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(,\s?)?){3}(0?\.\d+|1(\.0+)?)\)$/', $rgba);
		}

		public static function address(string $address): string {
			return preg_match('/^[a-zA-Z0-9\s\-,.#]+$/', $address);
		}

		public static function alphaDash(string $string): string {
			return preg_match('/^[a-zA-Z0-9_\-]+$/', $string);
		}

		public static function dateTime(string $dateTime): string {
			return preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}$/', $dateTime);
		}

		public static function alphaNumeric(string $string): string {
			return preg_match('/^[a-zA-Z0-9]+$/', $string);
		}

		public static function alphaDashDot(string $string): string {
			return preg_match('/^[a-zA-Z0-9_\-\.]+$/', $string);
		}

	}