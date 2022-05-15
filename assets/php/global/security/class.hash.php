<?php

	class Hash {

		public static function token(string $token) {
			return hash('ripemd256',
				hash('haval256,5',
					hash('gost',
						hash('sha256',
							hash('md5', 
								base64_encode($token)
							)
						)
					)
				)
			);
		}

		public static function openssl(string $key) {
			return hash('ripemd256',
				hash('haval256,5',
					hash('gost',
						hash('tiger192,4',
							hash('md5',
								hash('sha256',
									base64_encode($key)
								)
							)
						)
					)
				)
			);
		}

		public static function openssl_iv(string $key) {
			return substr(
				hash('gost',
					hash('tiger192,4',
						hash('md5',
							hash('sha256',
								base64_encode($key)
							)
						)
					)
				), 0, 16
			);
		}

		public static function user_key(string $user_key) {
			return hash('tiger192,4',
				hash('haval256,5',
					hash('md5',
						base64_encode($user_key)
					)
				)
			);
		}

		public static function pass(string $pass_post, string $pass_db = null, bool $verify = false) {
			if ($verify == false) {
				return password_hash(
					$pass_post, PASSWORD_ARGON2I
				);
			} else if ($verify == true) {
				if (password_verify(
					$pass_post, $pass_db
				)) {
					return true;
				} else {
					return false;
				}
			}
		}

	}
