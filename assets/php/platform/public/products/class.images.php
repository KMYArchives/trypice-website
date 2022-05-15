<?php

	class Images {

		private $db;

		public function logo(int $prod_id): array {
			foreach ($this->db->query("SELECT name, filename FROM ws_images WHERE prod_id = ? AND type = 'logo'", [ 
				$prod_id
			]) as $data) {
				return [
					'name'	=>	$data['name'],
					'url'	=>	System::yuki('image') . $data['filename'],
				];
			}
		}

		public function preview(int $prod_id): array {
			foreach ($this->db->query("SELECT name, filename FROM ws_images WHERE prod_id = ? AND type = 'screenshots' AND preview = 'true'", [ 
				$prod_id
			]) as $data) {
				return [
					'name'	=>	$data['name'],
					'url'	=>	System::yuki('image') . $data['filename'],
				];
			}
		}

		public function screenshots(int $prod_id): array {
			$sql_max	=	System::global('sql_max');
			$offset		=	($_GET['offset']) ? Clean::numbers($_GET['offset']) : 0;

			foreach ($this->db->query("SELECT name, title, filename FROM ws_images WHERE prod_id = ? AND type = 'screenshots' LIMIT $offset, $sql_max", [ 
				$prod_id
			]) as $data) {
				$list[]		=	[
					'name'	=>	$data['name'],
					'title'	=>	$data['title'],
					'url'	=>	System::yuki('image') . $data['filename'],
				];
			}

			return $list;
		}

		public function __construct() { $this->db = new DB; }

	}