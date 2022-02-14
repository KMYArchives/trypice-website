<?php

	class Clean {

		static $sql		=	[
			'=', '*', '!', '`', '.', ';', 'add', 'constraint', 'alter', 'column', 'table', 'between', 'case', 'check', 'create', 'index', 'database', 'replace', 'view', 'index', 'procedure', 'unique', 'delete', 'distint', 'default', 'drop', 'exec', 'exists', 'foreing', 'key', 'from', 'outer', 'inner', 'join', 'left', 'right', 'having', 'not', 'null', 'like', 'limit', 'set', 'order', 'primary', 'rownum', 'select', 'distinct', 'into', 'update', 'values', 'where', 'truncate', 'analyze', 'checksum', 'dump', 'tables', 'databases', 'count', 'show', 'insert'
		];

		static $html	=	[
			'script', 'video', 'audio', 'figure', 'link', 'src', 'header', 'body', 'footer', 'head', 'html', 'aside', 'div', 'section', 'select', 'option', 'form', 'input', 'button', 'embed', 'iframe', 'meta', 'keyword', 'charset', 'onmouseover', 'onmousedown', 'onmouseup', 'onmouseout', 'onblur', 'onchange'
		];

		static $javascript	=	[
			'byte', 'case', 'catch', 'char', 'const', 'let', 'var', 'continue', 'debugger', 'default', 'console', 'float', 'string', 'void', 'delete', 'double', 'true', 'false', 'foreach', 'function', 'public', 'private', 'protected', 'native', 'interface', 'goto', 'finally', 'bool', 'boolean', 'else', 'instanceof', 'typeof', 'package', 'return', 'short', 'long', 'static', 'switch', 'synchronized', 'throw', 'throws', 'transient', 'void', 'volatie', 'while', 'with', 'yield', 'await', 'class', 'enum', 'export', 'import', 'extends', 'super', 'eval', 'array', 'date', 'break', 'inifinity', 'isfinite', 'isnan', 'isprototypeof', 'number', 'name', 'length', 'math', 'object', 'tostring', 'toint', 'undefined', 'valueof', 'transient', 'onmouseover', 'onmousedown', 'onmouseup', 'onmouseout', 'onblur', 'onchange', 'onfocus', 'onselect', 'onsubmit', 'onreset', 'onkeydown', 'ononkeypress', 'onkeyup', 'keycode', 'map', 'onload', 'onerror', 'onunload', 'omunresize', 'onclick', 'ondblclick', 'onsuccess', 'onerror'
		];

		static $protocols	=	[ '','ftp', 'ssh', 'sftp', 'smtp', 'pop3', 'http', 'https', 'mailto' ];

		static $special_chars	=	[ '"', "'", '`', '´', '~', ',', ';', ':', '*', '(', ')', '[', ']', '{', '}', '<', '>', '^', '%', '?', '!', '&', '=', '/', '|' ];

		protected static function sql_keywords($str) { return str_replace(self::$sql, '', $str); }

		protected static function html_keywords($str) { return str_replace(self::$html, '', $str); }

		protected static function js_keywords($str) { return str_replace(self::$javascript, '', $str); }

		protected static function special_chars($str) { return str_replace(self::$special_chars, '', $str); }

		protected static function protocols_keywords($str) { return str_replace(self::$protocols, '', $str); }

		public static function js($string) { return self::js_keywords($string); }

		public static function sql($string) { return self::sql_keywords($string); }

		public static function html($string) { return self::html_keywords($string); }

		public static function special($string) { return self::special_chars($string); }

		public static function protocols($string) { return self::protocols_keywords($string); }

		public static function numbers($string) { return preg_replace('/[^0-9]/', '', $string); }

		public static function slug($string) { return preg_replace('/[^A-Za-z0-9]/', '', $string); }

		public static function string($string, $case = 'Az09') { return preg_replace(self::regex($case), '', $string); }

		protected static function regex($case) {
			switch ($case) {
				case 'az':
					return '/[^a-z]/';
					break;

				case 'AZ':
					return '/[^A-Z]/';
					break;

				case 'Az':
					return '/[^A-Za-z]/';
					break;

				case 'AZ09':
					return '/[^A-Z0-9]/';
					break;

				case 'az09':
					return '/[^a-z0-9]/';
					break;

				case 'Az09':
					return '/[^A-Za-z0-9]/';
					break;
					
				default:
					return '/[^A-Za-z]/';
					break;
			}
		}

		public static function boolean($value) {
			if (is_bool($value) == true) {
				return $value;
			} else {
				return false;
			}
		}

		public static function default($string) {
			$string		=	self::js($string);
			$string		=	self::sql($string);
			$string		=	self::html($string);
			$string		=	self::protocols($string);
			return self::special($string);
		}

		public static function cookies($string) {
			$string		=	self::js($string);
			$string		=	self::sql($string);
			$string		=	self::html($string);
			return self::protocols($string);
		}
		
		public static function variables($string) {
			$string		=	self::js($string);
			$string		=	self::protocols($string);
			return self::special($string);
		}

	}