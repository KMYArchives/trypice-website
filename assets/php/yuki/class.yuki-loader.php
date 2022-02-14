<?php

	abstract class YukiLoader {

		static $conf_path	=	__DIR__ . '/yuki.json';

		public static function configs() {
			return json_decode(
				file_get_contents(self::$conf_path), true
			);	
		}

		public static function name($file) {
			return end(
				explode("/", $file)
			);
		}

		public static function is_url($url) {
			if (preg_match('/^(http|https):\\/\\/[a-z0-9]+([\\-\\.]{1}[a-z0-9]+)*\\.[a-z]{2,5}((:[0-9]{1,5})?\\/.*)?$/i', $url)) {
				return true;
			} else {
				return false;
			}
		}

		public static function random($size) {
			$string		=	null;
			$char		=	[
				'num'	=>	'0123456789',
				'low'	=>	'abcdefghijklmnopqrstuvwxyz',
				'upp'	=>	'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
			];

			$string .= $char['low'];
			$string .= $char['upp'];
			$string .= $char['num'];

			for ($n = 0; $n <= $size; $n++) {
				$rand	=	mt_rand(0, strlen($string));
				$ret	.=	$string[$rand - 1];
			}

			return $ret;
		}

		public static function get_full_url() {
			return (
				isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http"
			) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		}

		private static function scandir($scan_dir) {
			$handle		=	opendir($scan_dir);

			while (($fileItem = readdir($handle)) !== false) {
				if (($fileItem == '.') || ($fileItem == '..')) continue;
				$fileItem	=	rtrim($scan_dir,'/') . '/' . $fileItem;
		
				if (is_dir($fileItem)) {
					foreach (self::scandir($fileItem) as $childFileItem) { yield $childFileItem; }
				} else {
					yield $fileItem;
				}
			}
		
			closedir($handle);
		}

		public static function read_content($file) {
			$file	=	self::configs()['paths']['js'] . self::configs()['paths']['bundle'] . $file;

			if (file_exists($file)) {
				return file_get_contents($file);
			} else {
				return 'error_404';
			}
		}

		public static function bytes($input, $addr = false) {
			if ($addr == true) { 
				$input = self::configs()['paths']['js'] . self::configs()['paths']['bundle'] . '/' . $input; 
			}

			$size	=	filesize($input);
			
			return sprintf(
				'%.02F', $size / pow(
					1024, floor(
						log($size) / log(1024)
					)
				)
			) * 1 . ' ' . ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'][
				floor(
					log($size) / log(1024)
				)
			];
		}

		public static function scripts() {
			$list	=	[];

			foreach (self::configs()['bundle'] as $n => $file) {
				$list[]			=	[
					"file"		=>	$file,
					"id"		=>	$n + 1,
					"size"		=>	self::bytes(self::configs()['paths']['js'] . self::configs()['paths']['bundle'] . $file . '.js'),
					"modified"	=>	date(
						"Y-m-d H:i:s", filemtime(self::configs()['paths']['js'] . self::configs()['paths']['bundle'] . $file . '.js')
					),
					"created"	=>	date(
						"Y-m-d H:i:s", filectime(self::configs()['paths']['js'] . self::configs()['paths']['bundle'] . $file . '.js')
					)
				];
			}

			return json_encode([
				"items"		=>	$list,
				"total"		=>	count($list),
				"version"	=>	self::configs()['version'],
			]);
		}

		public static function bundle_dir() {
			$list	=	[];
			$dir	=	self::configs()['paths']['js'] . self::configs()['paths']['bundle'];

			foreach (self::scandir($dir) as $n => $file) {
				$list[]			=	[
					"id"		=>	$n + 1,
					"name"		=>	self::name($file),
					"size"		=>	self::bytes($file),
					"file"		=>	str_replace([ self::configs()['paths']['js'], self::configs()['paths']['bundle'] ], '', $file),
					"modified"	=>	date( "Y-m-d H:i:s", filemtime($file) ),
					"created"	=>	date( "Y-m-d H:i:s", filectime($file) )
				];
			}

			return json_encode([
				"items"		=>	$list,
				"total"		=>	count($list),
				"version"	=>	self::configs()['version'],
			]);
		}

	}