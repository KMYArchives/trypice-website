<?php

	class Clean {

		static $sql		=	[
			'=', '*', '!', '`', '.', ';', 'add', 'constraint', 'alter', 'column', 'table', 'between', 'case', 'check', 'create', 'index', 'database', 'replace', 'view', 'index', 'procedure', 'unique', 'delete', 'distint', 'default', 'drop', 'exec', 'exists', 'foreing', 'key', 'from', 'outer', 'inner', 'join', 'left', 'right', 'having', 'not', 'null', 'like', 'limit', 'set', 'order', 'primary', 'rownum', 'select', 'distinct', 'into', 'update', 'values', 'where', 'truncate', 'analyze', 'checksum', 'dump', 'tables', 'databases', 'count', 'show', 'insert'
		];

		static $html	=	[
			'script', 'video', 'audio', 'figure', 'link', 'src', 'header', 'body', 'footer', 'head', 'html', 'aside', 'div', 'section', 'select', 'option', 'form', 'input', 'button', 'embed', 'iframe', 'meta', 'keyword', 'charset', 'onmouseover', 'onmousedown', 'onmouseup', 'onmouseout', 'onblur', 'onchange'
		];

		static $javascript	=	[
			'byte', 'case', 'catch', 'char', 'const', 'let', 'var', 'continue', 'debugger', 'default', 'console', 'float', 'string', 'void', 'delete', 'double', 'true', 'false', 'foreach', 'function', 'public', 'private', 'public', 'native', 'interface', 'goto', 'finally', 'bool', 'boolean', 'else', 'instanceof', 'typeof', 'package', 'return', 'short', 'long', 'static', 'switch', 'synchronized', 'throw', 'throws', 'transient', 'void', 'volatie', 'while', 'with', 'yield', 'await', 'class', 'enum', 'export', 'import', 'extends', 'super', 'eval', 'array', 'date', 'break', 'inifinity', 'isfinite', 'isnan', 'isprototypeof', 'number', 'name', 'length', 'math', 'object', 'tostring', 'toint', 'undefined', 'valueof', 'transient', 'onmouseover', 'onmousedown', 'onmouseup', 'onmouseout', 'onblur', 'onchange', 'onfocus', 'onselect', 'onsubmit', 'onreset', 'onkeydown', 'ononkeypress', 'onkeyup', 'keycode', 'map', 'onload', 'onerror', 'onunload', 'omunresize', 'onclick', 'ondblclick', 'onsuccess', 'onerror'
		];

		static $protocols	=	[ '','ftp', 'ssh', 'sftp', 'smtp', 'pop3', 'http', 'https', 'mailto' ];

		static $special_chars	=	[ '"', "'", '`', '~', ',', ';', ':', '*', '(', ')', '[', ']', '{', '}', '<', '>', '^', '%', '?', '!', '&', '=', '/', '|' ];

		public static function sql_keywords(string $str) { return str_replace(self::$sql, '', $str); }

		public static function html_keywords(string $str) { return str_replace(self::$html, '', $str); }

		public static function js_keywords(string $str) { return str_replace(self::$javascript, '', $str); }

		public static function special_chars(string $str) { return str_replace(self::$special_chars, '', $str); }

		public static function protocols_keywords(string $str) { return str_replace(self::$protocols, '', $str); }

		public static function js(string $string) { return self::js_keywords($string); }

		public static function sql(string $string) { return self::sql_keywords($string); }

		public static function html(string $string) { return self::html_keywords($string); }

		public static function special(string $string) { return self::special_chars($string); }

		public static function protocols(string $string) { return self::protocols_keywords($string); }

		public static function float(string $string) { return preg_replace('/[^0-9.]/', '', $string); }

		public static function numbers(string $string) { return preg_replace('/[^0-9]/', '', $string); }

		public static function slug(string $string) { return preg_replace('/[^A-Za-z0-9]/', '', $string); }

		public static function string(string $string, string $case = 'Az09') { return preg_replace(self::regex($case), '', $string); }

		public static function regex(string $case) {
			return match($case) {
				'az'		=>	'/[^a-z]/',
				'AZ'		=>	'/[^A-Z]/',
				'Az'		=>	'/[^A-Za-z]/',
				'AZ09'		=>	'/[^A-Z0-9]/',
				'az09'		=>	'/[^a-z0-9]/',
				default		=>	'/[^A-Za-z]/',
				'Az09'		=>	'/[^A-Za-z0-9]/',
			};
		}

		public static function boolean(bool $value) {
			if (is_bool($value) == true) {
				return $value;
			} else {
				return false;
			}
		}

		public static function default(string $string) {
			$string		=	self::js($string);
			$string		=	self::sql($string);
			$string		=	self::html($string);
			$string		=	self::protocols($string);
			return self::special($string);
		}

		public static function cookies(string $string) {
			$string		=	self::js($string);
			$string		=	self::sql($string);
			$string		=	self::html($string);
			return self::protocols($string);
		}
		
		public static function variables(string $string) {
			$string		=	self::js($string);
			$string		=	self::protocols($string);
			return self::special($string);
		}

	}