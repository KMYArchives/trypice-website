<?php

	class Callback {

		public static function redirect(string $url): string {
			Headers::setLocation($url);
		}

		public static function json(int $code, array $data): string {
			Headers::setHttpCode($code);
			Headers::setContentType('application/json');
			echo json_encode($data);
		}

		public static function html(int $code, string $data): string {
			Headers::setHttpCode($code);
			Headers::setContentType('text/html');
			echo $data;
		}

	}