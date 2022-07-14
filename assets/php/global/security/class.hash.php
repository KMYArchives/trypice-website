<?php

	class Hash {

		public static function token(string $token): string {
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

		public static function openssl(string $key): string {
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

		public static function openssl_iv(string $key): string {
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

		public static function user_key(string $user_key): string {
			return hash('tiger192,4',
				hash('haval256,5',
					hash('md5',
						base64_encode($user_key)
					)
				)
			);
		}

		public static function pass(string $pass_post, string $pass_db = null, bool $verify = false): bool|string {
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
