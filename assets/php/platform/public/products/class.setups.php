<?php

	class Setups {

		private $db;

		public function get(): void {
			foreach ($this->db->query("SELECT *, ws_products.name FROM ws_setups, ws_products WHERE prod_id = ? AND platform = ? AND status = 'true'", [
				Clean::numbers($_GET['product']), 
				Clean::string($_GET['platform'], 'az')
			]) as $data);
			
			Callback::json(200, [
				'icon'				=>	$data['icon'],
				'arch'				=>	$data['arch'],
				'file'				=>	$data['file'],
				'product'			=>	$data['name'],
				'channel'			=>	$data['channel'],
				'version'			=>	$data['version'],
				'platform'			=>	$data['platform'],
				'added_in'			=>	$data['added_in'],
				'file_size'			=>	$data['file_size'],
				'min_os_version'	=>	$data['min_os_version'],
				'download'			=>	System::links('website') . 'dl/' . $data['slug'],
				'hashes'			=>	FileProperties::hashes(System::dir('setups') . $data['setup'], [
					'md5', 'sha1', 'sha256', 'sha384', 'sha512', 'crc32', 'adler32', 'whirlpool'
				]),
			]);
		}

		public function list(): void {
			$sql_max	=	System::global('sql_max');
			$offset		=	($_GET['offset']) ? Clean::numbers($_GET['offset']) : 0;

			foreach ($this->db->query("SELECT slug, icon, platform, arch, min_os_version, added_in FROM ws_setups WHERE prod_id = ? LIMIT $offset, $sql_max", [
				Clean::numbers($_GET['slug'])
			]) as $data) {
				$list[]					=	[
					'slug'				=>	$data['slug'],
					'icon'				=>	$data['icon'],
					'arch'				=>	$data['arch'],
					'platform'			=>	$data['platform'],
					'added_in'			=>	$data['added_in'],
					'min_os_version'	=>	$data['min_os_version'],
				];
			}
			
			Callback::json(200, [
				'list'	=>	$list,
				'total'	=>	count($list),
			]);
		}

		public function download(string $slug): void {
			$query	=	$this->db->query("SELECT file, setup FROM ws_setups WHERE slug = ? AND enabled = 'true'", [
				Clean::slug($slug)
			]);

			foreach ($query as $data);
			
			if ($query) {
				if (File::file_exists(System::dir('setups') . $data['setup'])) {
					Headers::setContentType('application/json');
					Headers::setHttpCode(200);

					File::download([
						'name'	=>	$data['file'],
						'file'	=>	$data['setup'],
						'path'	=>	System::dir('setups'),
					]);
				} else {
					Callback::json(404, [
						'return'	=>	'error',
						'message'	=>	'Unknown error' 
					]);
				}
			} else {
				Callback::json(403, [ 'error' => 'Argument invalid...' ]);
			}
		}

		public function platforms(int $prod_id): array {
			$sql_max	=	System::global('sql_max');
			$offset		=	($_GET['offset']) ? Clean::numbers($_GET['offset']) : 0;

			foreach ($this->db->query("SELECT icon, platform FROM ws_setups WHERE prod_id = ? LIMIT $offset, $sql_max", [
				$prod_id
			]) as $data) {
				$list[]			=	[
					'icon'		=>	$data['icon'],
					'platform'	=>	$data['platform'],
				];
			}
			
			return $list;
		}

		public function __construct() { $this->db =	new DB; }

	}