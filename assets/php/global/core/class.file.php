<?php

	class File {

		private static function _exists(string $file): bool {
			if (!file_exists($file)) {
				return false;
			}
		}

		private static function _del_file(string $path): void {
			if (file_exists($path)) {
				unlink($path);
			} else {
				throw new \InvalidArgumentException('File not found');
			}
		}

		public static function delete(string|array $file): bool {
			if (array($file)) {
				foreach ($file as $f) {
					self::_del_file($f);
				}
			} else {
				self::_del_file($file);
			}
		}

		public static function file_exists(string|array $file): bool {
			if (array($file)) {
				foreach ($file as $f) {
					self::_exists($f);
				}
			} else {
				self::_exists($file);
			}

			return true;
		}
		
		public static function download(array $options): void {
			if (self::file_exists($options['path'] . $options['file'])) {
				Headers::setExpires(0);
				Headers::setPragma('public');
				Headers::setCacheControl('must-revalidate');
				Headers::setContentDescription('File Transfer');
				Headers::setContentType('application/octet-stream');
				Headers::setContentDisposition('attachment', $options['name']);
				Headers::setContentLength(filesize($options['path'] . $options['file']));
				Headers::setContentDisposition('attachment; filename="' . basename($options['name']) . '"');

				flush();
				readfile($options['path'] . $options['file']);
				exit;
			} else {
				throw new \InvalidArgumentException('File not found');
			}
		}

		public static function read($file, $options = []) {
			if ($options['remote'] == false || $options['remote'] == null) {
				if (self::file_exists($file)) {
					$content	=	file_get_contents($file);
					if ($options['crypto'] == true) { $content = OpenSSL::decrypt($content); }
					if ($options['json_decode'] == true) { $content = json_decode($content, $options['force_decode']); }
					if ($options['json_encode'] == true) { $content = json_encode($content); }
	
					return $content;
				} else {
					throw new \InvalidArgumentException('File not found');
				}
			} else {
				$content	=	file_get_contents($file);
				if ($options['json_decode'] == true) { $content = json_decode($content, $options['force_decode']); }
				if ($options['json_encode'] == true) { $content = json_encode($content); }

				return $content;
			}
		}

		public static function upload($input, $target, $options = []) {
			if (in_array($_FILES[$from]['type'], $options['ext'])) {
				if ($_FILES[$from]['size'] <= $options['max_size']) {
					if (copy($_FILES[$from]['tmp_name'], $target)) {
						return true;
					} else {
						throw new \InvalidArgumentException('File not uploaded');
					}
				} else {
					throw new \InvalidArgumentException('The file size is bigger than allowed');
				}
			} else {
				throw new \InvalidArgumentException('File not supported');
			}
		}

		public static function create($file, $content, $options = []) {
			if ($options['hex_decode'] == true) { 
				$content	=	hex2bin(
					Clean::string(
						$content, 'Az09'
					)
				);
			}

			if ($options['json_decode'] == true) { $content = json_decode($content); }
			if ($options['json_encode'] == true) { $content = json_encode($content, $options['flags']); }
			if ($options['crypto'] == true) { $content = OpenSSL::encrypt($content); }
			if ($options['base64'] == true) { $content = file_get_contents($content); }

			if (file_put_contents($file, $content)) {
				return true;
			} else {
				throw new \InvalidArgumentException('File not created');
			}
		}

	}