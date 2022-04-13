<?php

	class Headers {

		public static function core(): void {
			self::setXFrameOptions('deny');
			self::setEtag(System::global('etag'));
			self::setXContentTypeOptions('nosniff');
			self::setXXSSProtection('1; mode=block');
			self::setCacheControl('private; max-age=86400');
			self::setStrictTransportSecurity('max-age=86400');
			self::setAccessControlAllowOrigin(System::links('website'));
		}

		public static function get(string $name): string {
			return isset(
				$_SERVER[
					'HTTP_' . strtoupper(
						str_replace('-', '_', $name)
					)
				]
			) ? $_SERVER[
				'HTTP_' . strtoupper(
					str_replace('-', '_', $name)
				)
			] : null;
		}

		public static function setEtag(string $value): void { self::set('ETag', $value); }

		public static function setVary(string $value): void { self::set('Vary', $value); }

		public static function setPragma(string $value): void { self::set('Pragma', $value); }

		public static function setLocation(string $url): void { self::set('Location', $url); }

		public static function setExpires(string $date): void { self::set('Expires', $date); }
		
		public static function setHttpCode(string $code): void { self::set('HTTP/1.1', $code); }

		public static function setContentType(string $type): void { self::set('Content-Type', $type); }

		public static function set(string $type, string $value): void { header($type . ': ' . $value); }

		public static function setCacheControl(string $value): void { self::set('Cache-Control', $value); }

		public static function setLastModified(string $value): void { self::set('Last-Modified', $value); }

		public static function setXFrameOptions(string $value): void { self::set('X-Frame-Options', $value); }

		public static function setXXSSProtection(string $value): void { self::set('X-XSS-Protection', $value); }

		public static function setContentLanguage(string $value): void { self::set('Content-Language', $value); }

		public static function setContentLocation(string $value): void { self::set('Content-Location', $value); }

		public static function setContentEncoding(string $value): void { self::set('Content-Encoding', $value); }

		public static function setContentLength(string|int $length): void { self::set('Content-Length', $length); }

		public static function setContentDisposition(string $param): void { self::set("Content-Disposition", $param); }

		public static function setXContentTypeOptions(string $value): void { self::set('X-Content-Type-Options', $value); }

		public static function setStrictTransportSecurity(string $value): void { self::set('Strict-Transport-Security', $value); }

		public static function setContentDescription(string $description): void { self::set('Content-Description', $description); }

		public static function setAccessControlAllowOrigin(string $value): void { self::set('Access-Control-Allow-Origin', $value); }

	}