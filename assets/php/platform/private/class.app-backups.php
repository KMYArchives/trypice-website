<?php

	class AppBackups {

		private $db, $clients, $products;

		private function _check_file_size(): bool {
			if ($this->_get_file_input('size') < 1024 * 1024 * System::global('max_backup_size')) {
				return true;
			} else {
				return false;
			}
		}

		public function _delete(array $data): void {
			if (File::delete(System::dir('app_backups') . $data['filename'])) {
				Callback::json(200, [
					"return"	=>	"success",
					"message"	=>	"Backup deleted successfully",
				]);
			}
		}

		private function _update(array $data): void {
			if ($this->db->query("UPDATE ws_backups SET filename = ?, updated_in = ? WHERE prod_id = ? AND username = ?", [
				$data['filename'],
				date('Y-m-d H:i:s'),

				$data['product'],
				$data['username'],
			])) {
				Callback::json(200, [
					"return"	=>	"success",
					"image"		=>	$data['filename'],
					"message"	=>	"File Updated Successfully",
				]);
			}
		}

		private function _get_ext(string $file): string {
			return strtolower(
				pathinfo(
					$file, PATHINFO_EXTENSION
				)
			);
		}

		private function _insert(string $fileName): void {
			if ($this->db->query("INSERT INTO ws_backups(filename, slug, prod_id, username) VALUES(?, ?, ?, ?)", [
				$fileName,
				Random::slug([ 36, 48 ]),
				$this->products->get_id($_POST['product']),
				$this->clients->get_id($_POST['username']),
			])) {
				Callback::json(200, [
					"return"	=>	"success",
					"image"		=>	$fileName,
					"message"	=>	"File Uploaded Successfully",
				]);
			}
		}

		private function _check_file_ext(array $ext): bool {
			if (in_array($this->_get_ext($this->_get_file_input('name')), $ext)) {
				return true;
			} else {
				return false;
			}
		}

		private function _check_exists(bool $get = false): bool {
			if (!$get) {
				$product	=	$_POST['product'];
				$username	=	$_POST['username'];
			} else {
				$product	=	$_GET['product'];
				$username	=	$_GET['username'];
			}

			foreach ($this->db->query("SELECT id FROM ws_backups WHERE prod_id = ? AND username = ?", [
				$this->products->get_id($product),
				$this->clients->get_id($username),
			]) as $data);

			if (isset($data['id'])) {
				return true;
			} else {
				return false;
			}
		}

		private function _get_file_name(bool $get = false): string {
			if (!$get) {
				$product	=	$_POST['product'];
				$username	=	$_POST['username'];
			} else {
				$product	=	$_GET['product'];
				$username	=	$_GET['username'];
			}

			foreach ($this->db->query("SELECT filename FROM ws_backups WHERE prod_id = ? AND username = ?", [
				$this->products->get_id($product),
				$this->clients->get_id($username),
			]) as $data);

			return $data['filename'];
		}

		private function _upload(string $fileName, array $ext): bool {
			if ($this->_check_file_ext($ext) && $this->_check_file_size()) {
				if (move_uploaded_file(
					$this->_get_file_input('tmp_name'), System::dir('app_backups') . $fileName
				)) {
					return false;
				}
			} else {
				return false;
			}

			return false;
		}

		private function _get_download_page(string $product, string $username): string {
			return System::links('api_link') . "private/backups/download?product=$product&username=$username";
		}

		private function _get_file_input(string $data): string { return $_FILES['backup'][$data]; }

		private function _new_file_name(string $file): string { return Random::slug([ 36, 48 ]) . "." . $this->_get_ext($file); }

		public function get(): void {
			foreach ($this->db->query("SELECT slug, prod_id, filename, added_in, updated_in FROM ws_backups WHERE prod_id = ? AND username = ?", [
				$this->products->get_id($_GET['product']), 
				$this->clients->get_id($_GET['username'])
			]) as $data);
			
			$file						=	System::dir('app_backups') . $data['filename'];
			$slug						=	$this->products->get_data($data['prod_id'], 'slug_item');

			$data['product']['slug']	=	$slug;
			$data['product']['name']	=	$this->products->get_data($data['prod_id'], 'name');

			$data['file']['mime']		=	FileProperties::mime($file);
			$data['file']['size']		=	FileProperties::size($file);
			$data['file']['download']	=	$this->_get_download_page($slug, $_GET['username']);
			$data['file']['hashes']		=	FileProperties::hashes($file, [ 'crc32', 'md5', 'sha1', 'sha256', 'sha384', 'sha512' ]);

			unset($data['slug']);
			unset($data['prod_id']);
			unset($data['filename']);

			Callback::json(200, $data);
		}

		public function sync(): void {
			Headers::setAccessControlAllowOrigin("*");
			Headers::setAccessControlAllowsMethods("POST");
			Headers::setAccessControlAllowsHeaders("Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");

			if (!$this->_check_exists()) {
				$check_exists	=	false;
				$fileName		=	$this->_new_file_name($this->_get_file_input('name'));
			} else {
				$check_exists	=	true;
				$fileName		=	$this->_get_file_name();
			}
			
			if ($this->_upload($fileName, [
				'db', 'zip'
			])) {
				if (!$check_exists) {
					$this->_insert($fileName);
				} else {
					$this->_update([
						'filename'	=>	$fileName,
						'product'	=>	$this->products->get_id($_POST['product']),
						'username'	=>	$this->clients->get_id($_POST['username']),
					]);
				}
			} else {	
				Callback::json(500, [
					"return"	=>	"error-upload-file",
					"message"	=>	"Sorry, only supported files are allowed",
				]);
			}
		}

		public function __construct() {
			$this->db		=	new DB;
			$this->clients	=	new Clients;
			$this->products	=	new Products;
		}

		public function delete(): void {
			if ($this->_check_exists()) {
				foreach ($this->db->query("SELECT slug, filename FROM ws_backups WHERE prod_id = ? AND username = ?", [
					$this->products->get_id($_POST['product']), 
					$this->clients->get_id($_POST['username'])
				]) as $data);
	
				if ($this->db->query("DELETE FROM ws_backups WHERE slug = ? AND username = ?" , [
					$data['slug'], 
					$data['username']
				])) {
					$this->_delete($data['filename']);
				} else {
					Callback::json(500, [ 'return' => 'error-db-unlink-backup' ]);
				}
			}
		}

		public function download(): void {
			if ($this->_check_exists(true)) {
				foreach ($this->db->query("SELECT filename FROM ws_backups WHERE prod_id = ? AND username = ?", [
					$this->products->get_id($_GET['product']), 
					$this->clients->get_id($_GET['username'])
				]) as $data);

				File::download([
					'file'	=>	$data['filename'],
					'path'	=>	System::dir('app_backups'),
					'name'	=>	$_GET['product'] . '.' . $this->_get_ext($data['filename']),
				]);
			}
		}

	}