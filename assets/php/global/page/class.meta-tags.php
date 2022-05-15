<?php

	class MetaTags {

		public static function robots() {
			echo "<meta name='robots' content='all'>";
		}

		public static function content_type() {
			echo "<meta name='Content-Type' content='text/html; charset=" . System::global('charset') . "'>";
		}

		public static function content_language() {
			echo "<meta name='Content-Language' content='" . System::global('language') . "'>";
		}

		public static function title(string $title = null) {
			if ($title) {
				echo "<title>$title</title>";
			} else {
				echo "<title>" . System::global('name') . "</title>";
			}
		}

		public static function author(string $author = null) {
			if ($author == null) {
				echo "<meta name='author' content='" . System::global('name') . "'>";
			} else {
				echo "<meta name='author' content='$author'>";
			}
		}

		public static function html_lang(string $lang = null) {
			if ($lang) {
				echo "<html lang='$lang'>";
			} else {
				echo "<html lang='" . System::global('language') . "'>";
			}
		}
		
		public static function keywords(array $keywords = []) {
			if ($keywords) {
				$words	=	'';

				foreach ($keywords as $keyword) {
					$words	.=	$keyword . ', ';
				}

				echo "<meta name='keywords' content='" . mb_substr(
					$words, 0, -2
				) . "'>";
			}
		}

		public static function favicon(string $favicon = null) {
			if ($favicon) {
				echo "<link rel='shortcut icon' href='$favicon'>";
			} else {
				echo "<link rel='shortcut icon' href='" . System::images('favicon') . "'>";
			}
		}
		
		public static function canonical(string $canonical = null) {
			if ($canonical) {
				echo "<link rel='canonical' href='$canonical'>";
			} else {
				echo "<link rel='canonical' href='" . System::links('website') . "'>";
			}
		}

		public static function description(string $description = null) {
			if ($description == null) {
				echo "<meta name='description' content='" . System::global('slogan') . "'>";
			} else {
				echo "<meta name='description' content='$description'>";
			}
		}

		public static function compatible(string $content = 'ie=edge') {
			echo "<meta http-equiv='X-UA-Compatible' content='$content'>";
		}

		public static function viewport(string $viewport = "width=device-width, initial-scale=1") {
			echo "<meta name='viewport' content='$viewport'>";
		}
		
	}