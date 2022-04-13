<?php

	class Licenses {

		private $db, $serial, $devices, $clients;
		private $cols	=	"id, slug, prod_id, username, added_in";

		public function get() {
			foreach ($this->db->query("SELECT slug, favorited, order_id, serial_number, frequency, added_in, ws_products.name FROM ws_products, ws_licenses WHERE slug = ? AND username = ? LIMIT 1" , [ 
				Clean::slug($_GET['slug']), 
				$this->clients->get_id() 
			]) as $data) {
				$data['product']		=	$data['name'];
				$data['serial_number']	=	$this->serial->decode($data['serial_number']);

				unset($data['name']);
				Callback::json(200, $data);
			}
		}
		
		public function list() {
			$sql_max	=	System::global('sql_max');
			$offset		=	($_GET['offset']) ? Clean::numbers($_GET['offset']) : 0;

			if (Clean::string($_GET['favorited'], 'az') && !in_array($_GET['favorited'], [ 'false' ])) { 
				$favorited	=	"AND favorited = '" . Clean::string($_GET['favorited'], 'az') . "'"; 
			} else {
				$favorited	=	'';
			}

			foreach ($this->db->query("SELECT slug, favorited, frequency, added_in, ws_products.name FROM ws_products, ws_licenses WHERE username = ? $favorited LIMIT $offset, $sql_max", [
				$this->clients->get_id() 
			]) as $data) {
				$list[]			=	[
					'product'	=>	$data['name'],
					'slug'		=>	$data['slug'],
					'added_in'	=>	$data['added_in'],
					'favorited'	=>	$data['favorited'],
					'frequency'	=>	$data['frequency'],
				];
			}

			Callback::json(200, [
				'list'	=>	$list,
				'total'	=>	$this->db->query("SELECT count(*) FROM ws_licenses WHERE username = ? $prod_id $favorited", [
					$this->clients->get_id()
				])[0]['count(*)']
			]);
		}

		public function create() {
			$slug		=	Random::slug([ 36, 48 ]);

			$prod_id	=	$this->product_name(
				Clean::string($_GET['product'], 'az')
			);
			
			if ($this->db->query("INSERT INTO ws_licenses(slug, prod_id, unique_key, serial_number, username) VALUES(?, ?, ?, ?, ?)", [
				$slug,
				$prod_id,
				Random::string(32, true, true, true, true),
				$this->serial->encode($this->serial->create()),
					
				$this->clients->get_id(),
			])) {
				Callback::redirect(System::links('website') . "account/licenses?i=$slug");
			} else {
				Callback::json(500, [
					'return' => 'error-db-create-license'
				]);
			}
		}

		public function details() {
			foreach ($this->db->query("SELECT slug, serial_number, frequency, added_in FROM ws_licenses WHERE slug = ? LIMIT 1" , [ 
				Clean::slug($_GET['slug'])
			]) as $data) {
				$data['serial_number']	=	$this->serial->decode($data['serial_number']);
				Callback::json(200, $data);
			}
		}

		public function favorite() {
			foreach ($this->db->query("SELECT slug, favorited, username FROM ws_licenses WHERE slug = ? AND username = ? LIMIT 1" , [ 
				Clean::slug($_POST['slug']), 
				$this->clients->get_id() 
			]) as $data);

			if ($data['favorited'] == 'true') {
				$favorited	=	'false';
			} else {
				$favorited	=	'true';
			}

			if ($this->db->query("UPDATE ws_licenses SET favorited = ? WHERE slug = ? AND username = ?", [
				$favorited,
				$data['slug'],
				$data['username'],
			])) {
				Callback::json(200, [ 
					'return'	=>	'success',
					'favorited'	=>	$favorited
				]);
			} else {
				Callback::json(500, [
					'return' => 'error-favorite-license'
				]);
			}
		}

		public function activation() {
			Headers::setContentType('application/json');
			$serial_number	=	Clean::default($_POST['serial']);

			if ($this->serial->valid($serial_number) && Validation::uuid('uuid', 'post')) {
				Headers::setHttpCode(200);

				$this->devices->create([
					'trials'		=>	'false',
					'license'		=>	$this->get_data('id'),
					'slug-license'	=>	$this->get_data('slug'),
					'prod-id'		=>	$this->get_data('prod_id'),
					'username'		=>	$this->get_data('username'),
				]);
			} else {
				Callback::json(500, [
					'return' => 'error-serial'
				]);
			}
		}

		public function __construct() {
			$this->db		=	new DB;
			$this->serial	=	new Serial;
			$this->linked	=	new Linked;
			$this->devices	=	new Devices;
			$this->clients	=	new Clients;
		}

		public function get_data($return, $slug = null) {
			if ($slug == null) {
				foreach ($this->db->query("SELECT " . $this->cols . " FROM ws_licenses WHERE serial_number = ?" , [ 
					$this->serial->encode(
						Clean::default($_POST['serial'])
					)
				]) as $data) {
					return $data[$return];
				}
			} else {
				foreach ($this->db->query("SELECT " . $this->cols . " FROM ws_licenses WHERE slug = ?" , [ 
					Clean::slug($slug)
				]) as $data) {
					return $data[$return];
				}
			}
		}

	}