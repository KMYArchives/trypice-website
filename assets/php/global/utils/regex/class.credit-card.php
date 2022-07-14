<?php

	class CreditCard {

		public static function cvc(string $cvc): string {
			return preg_match('/^[0-9]{3,4}$/', $cvc);
		}

		public static function name(string $name): string {
			return preg_match('/^[a-zA-Z ]+$/', $name);
		}

		public static function number(string $number): string {
			return preg_match('/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/', $number);
		}

		public static function expiry(string $expiry): string {
			return preg_match('/^[0-9]{2}\/[0-9]{2}$/', $expiry);
		}

	}