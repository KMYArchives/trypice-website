<?php

	class Cookies {

		public static function _name(string $name): mixed {
			if (System::global('cookie_' . $name)) {
				return System::global('cookie_' . $name);
			} else {
				return $name;
			}
		}

		public static function has(string $name): bool {
			return isset(
				$_COOKIE[
					self::_name($name)
				]
			);
		}

		public static function create(array $data): void {
			setcookie(
				self::_name($data['name']),
				$data['value'],
				$data['expire'] ?? 0,
				$data['path'] ?? '/',
				$data['domain'] ?? null,
				$data['secure'] ?? false,
				$data['httpOnly'] ?? false
			);
		}

		public static function get(string $name): string {
			return $_COOKIE[
				self::_name($name)
			];
		}

		public static function delete(string $name): void {
			self::create([
				'value'		=>	'',
				'expire'	=>	time() - 3600,
				'name'		=>	self::_name($name),
			]);
		}

	}