<?php

	class Prices {

		private $db;

		public function get(): void {
			foreach ($this->db->query("SELECT *, ws_products.name FROM ws_prices, ws_products WHERE slug = ?", [ 
				Clean::slug($_GET['slug']) 
			]) as $data);
			
			Headers::setHttpCode(200);
			Headers::setContentType('application/json');
			echo json_encode([
				'product'		=>	$data['name'],
				'price'			=>	$data['price'],
				'prod_id'		=>	$data['prod_id'],
				'license'		=>	$data['license'],
				'refunds'		=>	$data['refunds'],
				'exchange'		=>	$data['exchange'],
				'discount'		=>	$data['discount'],
				'currency'		=>	$data['currency'],
			]);
		}

		public function list(): void {
			$sql_max	=	System::global('sql_max');
			$offset		=	($_GET['offset']) ? Clean::numbers($_GET['offset']) : 0;

			foreach ($this->db->query("SELECT slug, license, frequency, price, currency, ws_products.name FROM ws_prices, ws_products WHERE prod_id = ?", [ 
				Clean::numbers($_GET['slug'])
			]) as $data) {
				$list[]			=	[
					'slug'		=>	$data['slug'],
					'product'	=>	$data['name'],
					'price'		=>	$data['price'],
					'license'	=>	$data['license'],
					'currency'	=>	$data['currency'],
					'frequency'	=>	$data['frequency'],
				];
			}
			
			Headers::setHttpCode(200);
			Headers::setContentType('application/json');
			echo json_encode([
				'list'	=>	$list,
				'total'	=>	count($list),
			]);
		}

		public function __construct() { $this->db =	new DB; }

	}