<?php

	class Linked {

		private $db, $clients;

		private function license_id(): int {
			foreach ($this->db->query("SELECT id FROM ws_licenses WHERE slug = ? OR username = ? LIMIT 1", [
				Clean::slug($_GET['slug']), 
				$this->clients->get_id()
			]) as $data);
			
			return $data['id'];
		}
		
		private function max_count_devices(array $data): bool {
			$query	=	$this->db->query("SELECT count(*), ws_keys_rules.max_devices FROM ws_keys_rules, ws_products, ws_licenses, ws_linked WHERE ws_linked.license_id = ? AND ws_linked.username = ? AND ws_licenses.prod_id = ws_linked.license_id", [
				$data['license'], 
				$data['username']
			])[0];

			if ($query['count(*)'] <= $query['max_devices']) {
				return true;
			} else {
				return false;
			}
		}

		public function list(): void {
			$license	=	$this->license_id();
			$sql_max	=	System::global('sql_max');

			$trials		=	($_GET['trials']) ? 'true' : 'false';
			$offset		=	($_GET['offset']) ? Clean::numbers($_GET['offset']) : 0;
			$term		=	($_GET['term']) ? " ws_devices.hostname LIKE '%" . Clean::default($_GET['term']) . "%' AND" : '';

			foreach ($this->db->query("SELECT ws_devices.slug, ws_devices.hostname, ws_devices.model, ws_linked.slug_item, ws_linked.added_in FROM ws_devices, ws_linked WHERE ws_linked.trials = '$trials' AND $term ws_linked.license_id = ? AND ws_linked.username = ? LIMIT $offset, $sql_max", [
				$license, 
				$this->clients->get_id()
			]) as $data) {
				$list[]			=	[
					'slug'		=>	$data['slug'],
					'model'		=>	$data['model'],
					'hostname'	=>	$data['hostname'],
					'added_in'	=>	$data['added_in'],
					'slug_item'	=>	$data['slug_item'],
				];
			}
			
			Callback::json(200, [
				'list'	=>	$list,
				'total'	=>	$this->db->query("SELECT count(*) FROM ws_devices, ws_linked WHERE ws_linked.trials = '$trials' AND $term ws_linked.license_id = ? AND ws_linked.username = ?", [
					$license, 
					$this->clients->get_id()
				])[0]['count(*)'],
			]);
		}

		public function unlink(): void {
			if ($this->db->query("DELETE FROM ws_linked WHERE slug_item = ? AND username = ?" , [
				Clean::slug($_POST['slug']), 
				$this->clients->get_id() 
			])) {
				Callback::json(200, [
					'return' => 'success'
				]);
			} else {
				Callback::json(500, [
					'return' => 'error-db-unlink'
				]);
			}
		}

		public function create(array $data): void {
			if ($this->max_count_devices([
				'license'	=>	$data['license'],
				'username'	=>	$data['username'],
			])) {
				$slug	=	Random::slug([ 36, 48 ]);

				if ($this->db->query("INSERT INTO ws_linked(slug_item, trials, device_id, license_id, username) VALUES(?, ?, ?, ?, ?)", [
					$slug, 
					$data['trials'],
					$data['device'],
					$data['license'],
					$data['username']
				])) {
					Callback::json(200, [ 
						'return' 		=> 'success',
						'slug-license'	=>	$data['slug'],
					]);
				} else {
					Callback::json(500, [
						'return' => 'error-db-linked'
					]);
				}
			} else {
				Callback::json(500, [
					'return' => 'error-max-devices'
				]);
			}
		}

		public function __construct() {
			$this->db		=	new DB;
			$this->clients	=	new Clients;
		}

	}