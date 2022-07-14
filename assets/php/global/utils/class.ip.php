<?php

	class IP {

		static $apis	=	[
			'method3'	=>	'https://api.ipify.org',
			'method1'	=>	'http://free.ipwhois.io/json/{ip}',
			'params'	=>	'country,region,regionName,city,zip,lat,lon,timezone',
			'method2'	=>	'http://ip-api.com/json/{ip}?fields=country,region,regionName,city,zip,lat,lon,timezone',
		];

		private static function domain(string $url): string {
			return explode(
				'/', preg_replace(
					"(^https?://)", '', $url
				)
			)[0];
		}

		public static function only_ip(): string {
			return File::read(self::api(null, 'method3'), [
				'remote'	=>	true,
			]);
		}

		public static function encode(string $ip): string {
			return OpenSSL::encrypt(
				self::plain($ip)
			);
		}

		public static function reverse(string $domain): string { 
			return gethostbyname(
				self::domain($domain)
			);
		}

		private static function api(string $ip, string $method): string {
			return str_replace(
				'{ip}', Clean::default($ip), self::$apis[$method]
			);
		}

		public static function decode(string $ip, bool $json = false): string {
			Headers::setHttpCode(200);
			Headers::setContentType('application/json');
			
			return File::read(
				self::api(
					OpenSSL::decrypt($ip), 'method1'
				), [
					'remote'		=>	true,
					'json_decode'	=>	$json,
				]
			);
		}

		public static function plain(string $ip, string $method = 'method1'): string {
			return File::read(
				self::api($ip, $method), [
					'remote'	=>	true
				]
			);
		}

		public static function location(string $ip, string $method = 'method1'): string { return self::plain($ip, $method); }

	}