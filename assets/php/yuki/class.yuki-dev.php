<?php

	require_once 'vendor/autoload.php';
	require_once 'class.yuki-loader.php';

	use MatthiasMullie\Minify;

	class YukiDev extends YukiLoader {

		private $css, $js;

		public function bundle() {
			$conf				=	YukiLoader::configs();
			$conf['bundle']		=	json_decode($_POST['scripts']);
			
			header('Content-type: application/json');
			if (file_put_contents(parent::$conf_path, json_encode($conf, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT))) {
				echo json_encode('success');
			} else {
				echo json_encode('error-writed');
			}
		}

		public function delete() {
			header('Content-type: application/json');
			if (file_exists(parent::configs()['paths']['js'] . parent::configs()['paths']['bundle'] . $_POST['file'])) {
				if (unlink(parent::configs()['paths']['js'] . parent::configs()['paths']['bundle'] . $_POST['file'])) {
					echo json_encode('success'); 
				} else {
					echo json_encode('error-deleted');
				}
			} else {
				echo json_encode('error-404');
			}
		}

		public function download() {
			if (parent::is_url($_POST['from']) == false) {
				echo json_encode('error_url');
				die;
			}

			$js_name	=	parent::name($_POST['from']);
			$file_name	=	str_replace([ 
				'.min', 'min.', '.dist', 'dist.', '.src', 'src.' 
			], '', $js_name);

			header('Content-type: application/json');
			if (file_put_contents(
				parent::configs()['paths']['js'] . parent::configs()['paths']['bundle'] . $path . $file_name,
				$this->content_js($_POST['from'])
			)) {
				echo json_encode('success');
			} else {
				echo json_encode('error_save');
			}
		}

		public function __construct() {
			$this->js	=	new Minify\JS;
			$this->css	=	new Minify\CSS;
		}

		public function read_js_file() {
			header('Content-type: text/javascript; charset=UTF-8');
			$content	=	parent::read_content($_GET['file']);

			if ($_GET['unminify'] == 'true') {
				$beautify	=	new JSBeautify($content);
				echo $beautify->getResult();
			} else if (!isset($_GET['unminify']) || $_GET['unminify'] == 'false') {
				echo $content;
			}
		}

		public function list_scripts() { echo parent::scripts(); }

		public function list_bundles() { echo parent::bundle_dir(); }

		public function content_js($content) { return file_get_contents($content); }

	}