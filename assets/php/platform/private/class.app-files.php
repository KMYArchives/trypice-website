<?php

	class AppFiles {

		private $db, $products;

		private function _get_download_link(array $data): string {
			return System::links('api_link') . "private/app-files/download?file={$data['file']}&product={$data['product']}";
		}

		public function __construct() {
			$this->db		=	new DB;
			$this->products	=	new Products;
		}

		public function download(): void {
			foreach ($this->db->query("SELECT new_name, original_name FROM ws_app_files WHERE slug = ? AND prod_id  = ?", [
				Clean::slug($_GET['file']),
				$this->products->get_id($_GET['product']),
			]) as $data);

			File::download([
				'file'	=>	$data['new_name'],
				'name'	=>	$data['original_name'],
				'path'	=>	System::dir('app_samples'),
			]);
		}

		public function list_all(): void {
			foreach ($this->db->query("SELECT slug, type, prod_id, new_name, original_name, added_in FROM ws_app_files WHERE prod_id = ?", [
				$this->products->get_id($_GET['product']),
			]) as $data) {
				$file				=	System::dir('app_samples') . $data['new_name'];
				
				$list[]				=	[
					'type'			=>	$data['type'],
					'new_name'		=>	$data['new_name'],
					'added_in'		=>	$data['added_in'],
					'original_name'	=>	$data['original_name'],
					'size'			=>	FileProperties::size($file),
					'mime'			=>	FileProperties::mime($file),
					'download'		=>	$this->_get_download_link([
						'file'		=>	$data['slug'],
						'product'	=>	Clean::slug($_GET['product']),
					]),
					
					'hashes'		=>	FileProperties::hashes($file, [
						'crc32', 'md5', 'sha1', 'sha256', 'sha384', 'sha512'
					]),
				];
			}
			Callback::json(200, [
				'list'	=>	$list,
				'total'	=>	$this->db->query("SELECT COUNT(*) FROM ws_app_files WHERE prod_id = ?", [
					$this->products->get_id($_GET['product']),
				])[0]['COUNT(*)'],
			]);
		}

	}