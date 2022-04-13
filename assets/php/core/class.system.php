<?php

	class System {

		public static function errors(string $level) {
			return match ($level) {
				default		=>	error_reporting(0),
				'none'		=>	error_reporting(0),
				'high'		=>	error_reporting(E_ALL),
				'low'		=>	error_reporting(E_ALL & ~E_NOTICE),
				'medium'	=>	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING),
				'default'	=>	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING),
			};
		}

		public static function dir(string $dir): string {
			return match($dir) {
				'apis'		=>	'api/',
				'pages'		=>	'pages/',
				'files'		=>	'files/',
				'setups'	=>	'setups/',
				'json'		=>	'assets/json/',
			};
		}

		public static function yuki(string $page): string {
			return match($page) {
				'js'	=>	self::links('website') . self::global('render') . 'js',
				'css'	=>	self::links('website') . self::global('render') . 'css',
				'json'	=>	self::links('website') . self::global('render') . 'json/',
				'image'	=>	self::links('website') . self::global('render') . 'image/',
			};
		}

		public static function links(string $link): string {
			return match($link) {
				'website'	=>	'https://localhost/website/',
				'workspace'	=>	'https://localhost/workspace/',
				'api_link'	=>	self::links('website') . 'apis/',
				'gravatar'	=>	'https://www.gravatar.com/avatar/%s?s=%s',
			};
		}

		public static function global(string $var): string {
			return match($var) {
				'sql_max'			=>	50,
				'language'			=>	'en-US',
				'charset'			=>	'UTF-8',
				'render'			=>	'yuki/',
				'name'				=>	'Trypice',
				'social_media_user'	=>	'Trypice',
				'slogan'			=>	'We build tools for all',
				'html_mail'			=>	'https://pastebin.com/raw/ZWK6P5iA',
				'etag'				=>	'91242c4a4111df4cd6be844dfa3b89b5',

				'cookie_user'		=>	'E7MvX8E68Z6RQ8ob0xeRMQgsOiZoGD0k',
				'cookie_csrf'		=>	'qP8H2ytAR4iw0T9pDKZC395o7yl8wdZ0',
				'cookie_log_err'	=>	'5x8K3aX4jzD3Ie8Bn4bOntYhlFmQ1uS7',
				'cookie_otp_code'	=>	'aUWqsXuIt7sf7kH12sBoAiHNdXhL3WqZ',
			};
		}

		public static function images(string $image): string {
			return match($image) {
				'logo'				=>	self::yuki('image') . 'logo.png',
				'logo_online'		=>	'https://i.imgur.com/CICxg8O.png',
				'default-avatar'	=>	self::yuki('image') . 'avatar.jpg',
				'favicon'			=>	self::yuki('image') . 'favicon.png',
				'user-cover'		=>	self::yuki('image') . 'user-cover.jpg',
				'cloud_icon'		=>	self::yuki('image') . 'cloud-icon.png',
			};
		}

	}