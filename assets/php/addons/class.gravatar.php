<?php

	class Gravatar {

		public static function avatar(string $email): string {
			return md5(
				OpenSSL::decrypt(
					$email
				)
			);
		}

		public static function get(string $email, int $size = null): string {
			return sprintf(
				System::links('gravatar'),
				self::avatar($email),
				$size ?? 300
			);
		}

	}