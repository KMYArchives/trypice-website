<?php

	class CreditCard {

		public static function number($number) {
			return preg_match('/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/', $number);
		}

		public static function cvc($cvc) {
			return preg_match('/^[0-9]{3,4}$/', $cvc);
		}

		public static function expiry($expiry) {
			return preg_match('/^[0-9]{2}\/[0-9]{2}$/', $expiry);
		}

		public static function name($name) {
			return preg_match('/^[a-zA-Z ]+$/', $name);
		}

	}