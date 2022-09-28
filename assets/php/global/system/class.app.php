<?php

	class App {

		private static $errorStyle = "font-family: Consolas; background: #990000; color: whitesmoke; margin: 5px; padding: 10px; letter-spacing: .1em;";

		public static function view(array|string $views): void {
			if (is_array($views)) {
				foreach ($views as $view) {
					if (file_exists($view)) {
						include_once $view;
					} else {
						self::error('Error 404', "The view '$view' was not found...");
					}
				}
			} else {
				if (file_exists($views)) {
					include_once $views;
				} else {
					self::error('Error 404', "The view '$views' was not found...");
				}
			}
		}

		public static function error(string $name, string $error, int $code = 0): void {
			if ($code != 0) { Headers::setHttpCode($code); }
			
			echo "<div style='" . self::$errorStyle . "'>";
				echo "<b>$name</b>: $error";
			echo "</div>";
		}
		
	}