<?php

	class Products {

		private $db, $images, $setups, $features;

		public function get(): void {
			foreach ($this->db->query("SELECT * FROM ws_products WHERE slug = ?", [ 
				Clean::slug($_GET['slug']) 
			]) as $data);

			Callback::json(200, [
				'id'				=>	$data['id'],
				'name'				=>	$data['name'],
				'slogan'			=>	$data['slogan'],
				'features'			=>	$this->features->list($data['id']),
				'platforms'			=>	$this->setups->platforms($data['id']),
				'images'			=>	[
					'logo'			=>	$this->images->logo($data['id']),
					'preview'		=>	$this->images->preview($data['id']),
					'screenshots'	=>	$this->images->screenshots($data['id']),
				],
			]);
		}

		public function list(): void {
			$sql_max	=	System::global('sql_max');
			$offset		=	($_GET['offset']) ? Clean::numbers($_GET['offset']) : 0;
			$query		=	$this->db->query("SELECT * FROM ws_products WHERE status = 'true' LIMIT $offset, $sql_max");

			foreach ($query as $data) {
				$list[]			=	[
					'name'		=>	$data['name'],
					'slug'		=>	$data['slug'],
					'slogan'	=>	$data['slogan'],
					'added_in'	=>	$data['added_in_item'],
					'logo'		=>	$this->images->logo($data['id']),
					'preview'	=>	$this->images->preview($data['id']),
					'url'		=>	System::links('website') . $data['slug'],
				];
			}

			Callback::json(200, [
				'list'	=>	$list,
				'total'	=>	$this->db->query("SELECT COUNT(*) FROM ws_products WHERE status = 1")[0]['COUNT(*)'],
			]);
		}

		public function __construct() {
			$this->db			=	new DB;
			$this->images		=	new Images;
			$this->setups		=	new Setups;
			$this->features		=	new Features;
		}

		public function list_license(): void {
			$sql_max	=	System::global('sql_max');
			$offset		=	($_GET['offset']) ? Clean::numbers($_GET['offset']) : 0;

			foreach ($this->db->query("SELECT id, name FROM ws_products WHERE status = 'true' LIMIT $offset, $sql_max") as $data) {
				$list[]		=	[
					'id'	=>	$data['id'],
					'name'	=>	$data['name'],
				];
			}

			Callback::json(200, [
				'list'	=>	$list,
				'total'	=>	$this->db->query("SELECT COUNT(*) FROM ws_products WHERE status = 'true'")[0]['COUNT(*)'],
			]);
		}

		public function get_id(string $product): string {
			foreach ($this->db->query("SELECT id FROM ws_products WHERE slug_item = ?", [ 
				Clean::slug($product)
			]) as $data);

			return $data['id'];
		}

		public function get_data(mixed $product, string $field): string {
			foreach ($this->db->query("SELECT * FROM ws_products WHERE id = ?", [ 
				Clean::numbers($product)
			]) as $data);

			return $data[$field];
		}

	}