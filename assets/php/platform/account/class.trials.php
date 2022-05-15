<?php

	class Trials {

		private $db, $clients;

		private function check_exists() {
			if ($key) {
				// code...
			}
		}

		public function get() {
			foreach ($this->db->query("SELECT slug, notify, expires_in, added_in, ws_products.name FROM ws_products, ws_trials WHERE slug = ? AND username = ? LIMIT 1" , [ 
				Clean::slug($_GET['slug']), 
				$this->clients->get_id() 
			]) as $data) {
				$data['product']		=	$data['name'];
				unset($data['name']);

				Callback::json(200, $data);
			}
		}

		public function list() {
			$sql_max	=	System::global('sql_max');
			$offset		=	($_GET['offset']) ? Clean::numbers($_GET['offset']) : 0;

			if (Clean::string($_GET['product'], 'az09') && !in_array($_GET['product'], [ null, 'all' ])) { 
				$prod_id	=	" AND prod_id = '" . Clean::numbers($_GET['product']) . "'"; 
			} else {
				$prod_id	=	'';
			}

			foreach ($this->db->query("SELECT slug, expires_in, added_in, ws_products.name FROM ws_products, ws_trials WHERE username = ? $prod_id LIMIT $offset, $sql_max", [
				$this->clients->get_id() 
			]) as $data) {
				$list[]				=	[
					'slug'			=>	$data['slug'],
					'product'		=>	$data['name'],
					'added_in'		=>	$data['added_in'],
					'expires_in'	=>	$data['expires_in'],
				];
			}

			Callback::json(200, [
				'list'	=>	$list,
				'total'	=>	$this->db->query("SELECT count(*) FROM ws_trials WHERE username = ? $prod_id", [
					$this->clients->get_id()
				])[0]['count(*)']
			]);
		}

		public function create() {}

		public function verify() {}

		public function __construct() {
            $this->db       =   new DB;
            $this->clients  =   new Clients;
        }

	}