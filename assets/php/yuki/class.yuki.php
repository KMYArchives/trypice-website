<?php

	require_once 'vendor/autoload.php';

	use MatthiasMullie\Minify;

	class Yuki {

		private $css, $js;

		public function configs() {
			return json_decode(
				file_get_contents(__DIR__ . '/yuki.json'), true
			);	
		}

		private function css_file($file) {
			return file_get_contents(
				$this->configs()['paths']['css'] . $file . '.css'
			);
		}
		
		private function force_gzip($file) {
			return gzencode(
				file_get_contents($file), $this->configs()['options']['level'], FORCE_GZIP
			);
		}

		private function compress($type_file) {
			header("Etag: '" . $this->configs()['options']['etag'] . "'");

			header('Pragma: public');
			ob_start('ob_gzhandler');

			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
			header('Cache-Control: max-age=' .$this->configs()['options']['maxage'] . ', must-revalidate');
			header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $this->configs()['options']['maxage']));

			if ($type_file == 'css') {
				header('Content-type: text/css; charset=UTF-8');
			} else if ($type_file == 'js') {
				header('Content-type: text/javascript; charset=UTF-8');
			}

			header('Vary: Accept-Encoding');
			header('Content-Encoding: deflate');
			header('Content-Encoding: gzip');
		}

		public function js($input) {
			if (is_dir($this->configs()['paths']['js'])) {
				foreach ($this->configs()['bundle'] as $file) {
					$this->js->add($this->configs()['paths']['js'] . $this->configs()['paths']['bundle'] . $file . '.js');
					$this->force_gzip($this->configs()['paths']['js'] . $this->configs()['paths']['bundle'] . $file . '.js');
				}

				if (is_array($input)) {
					foreach ($input as $file) {
						$this->js->add($this->configs()['paths']['js'] . $file . '.js');
						$this->force_gzip($this->configs()['paths']['js'] . $file . '.js');
					}
				} else {
					$this->js->add($this->configs()['paths']['js'] . $input . '.js');
					$this->force_gzip($this->configs()['paths']['js'] . $input . '.js');
				}

				$this->compress('js');
				echo $this->js->minify();
			}
		}
		
		public function css($input) {
			$content	=	'';

			if (is_dir($this->configs()['paths']['css'])) {
				if (is_array($input)) {
					foreach ($input as $file) {
						$content	.=	$this->css_file($file);
						$this->force_gzip($this->configs()['paths']['css'] . $file . '.css');
					}
				} else {
					$content	.=	$this->css_file($input);
					$this->force_gzip($this->configs()['paths']['css'] . $input . '.css');
				}

				$this->compress('css');
				echo $content;
			}
		}

		public function json($input) {
			header('Content-type: application/json');

			echo file_get_contents(
				$this->configs()['paths']['json'] . $input . '.json'
			);
		}

		public function image($input) {
			$ext	=	end(
				explode(
					'.', $input
				)
			);

			$size	=	filesize(
				$this->configs()['paths']['image'] . $input
			);

			if (is_dir($this->configs()['paths']['image'])) {
				header("Content-Type: image/$ext");
				header("Content-Length: " . $size);
				readfile($this->configs()['paths']['image'] . $input);
			}
		}

		public function __construct() {
			$this->js	=	new Minify\JS;
			$this->css	=	new Minify\CSS;
		}

	}