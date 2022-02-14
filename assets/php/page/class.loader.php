<?php

	class Loader {

		public static function js(array $files = []): void {
			echo "<script async defer src='" . System::yuki('js') . "'></script>";
			
			if ($files) {
				foreach ($files as $file) {
					echo "<script async defer src='$file'></script>";
				}
			}
		}

		public static function css(array $files = []): void {
			echo "<link rel='stylesheet' crossorigin='anonymous' href='" . System::yuki('css') . "'>";
			
			if ($files) {
				foreach ($files as $file) {
					echo "<link rel='stylesheet' crossorigin='anonymous' href='$file'>";
				}
			}
		}

	}