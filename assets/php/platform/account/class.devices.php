<?php

	class Devices {

		private $db, $clients, $linked;

		private function get_id(string $slug): int {
			foreach ($this->db->query("SELECT id FROM ws_devices WHERE slug = ? LIMIT 1", [ 
				$slug 
			]) as $data);
			
			return $data['id'];
		}

		private function get_prod_id(string $slug): int {
			foreach ($this->db->query("SELECT prod_id FROM ws_licenses WHERE slug = ? LIMIT 1", [ 
				$slug 
			]) as $data);

			return $data['prod_id'];
		}

		private function check_exists(string $uuid, int|string $username): bool {
			if (count(
				$this->db->query("SELECT id FROM ws_devices WHERE uuid = ? AND username = ? LIMIT 1", [
					$uuid, $username
				])
			) > 0) {
				return true;
			} else {
				return false;
			}
		}

		public function get(): void {
			foreach ($this->db->query("SELECT ip, uuid, hostname, os, arch, cpu, model, favorited, added_in FROM ws_devices WHERE username = ? AND slug = ?", [
				$this->clients->get_id(), 
				Clean::slug($_GET['slug']),
			]) as $data) {
				$data['region']		=	IP::decode($data['ip'], true);
				$data['ip']			=	OpenSSL::decrypt($data['ip']);
				$data['uuid']		=	OpenSSL::decrypt($data['uuid']);
				
				Callback::json(200, $data);
			}
		}
		
		public function list(): void {
			$sql_max	=	System::global('sql_max');
			$offset		=	($_GET['offset']) ? Clean::numbers($_GET['offset']) : 0;

			if (Clean::default($_GET['term'])) {
				$term	=	 "AND hostname LIKE '%" . Clean::default($_GET['term']) . "%'";
			} else {
				$term	=	'';
			}

			if (Clean::string($_GET['favorited'], 'az') && !in_array($_GET['favorited'], [ 'false' ])) { 
				$favorited	=	"AND favorited = '" . Clean::string($_GET['favorited'], 'az') . "'"; 
			} else {
				$favorited	=	'';
			}

			foreach ($this->db->query("SELECT slug, hostname, os, favorited, added_in FROM ws_devices WHERE username = ? $term $favorited LIMIT $offset, $sql_max", [
				$this->clients->get_id()
			]) as $data) {
				$list[]			=	[
					'os'		=>	$data['os'],
					'slug'		=>	$data['slug'],
					'type'		=>	$data['type'],
					'hostname'	=>	$data['hostname'],
					'added_in'	=>	$data['added_in'],
					'favorited'	=>	$data['favorited'],
				];
			}
			
			Callback::json(200, [
				'list'	=>	$list,
				'total'	=>	$this->db->query("SELECT count(*) FROM ws_devices WHERE username = ? $term $favorited", [
					$this->clients->get_id()
				])[0]['count(*)']
			]);
		}

		public function delete(): void {
			$slug	=	Clean::slug($_POST['slug']);
			
			foreach ($this->db->query("SELECT id FROM ws_devices WHERE slug = ? AND username = ?", [
				$slug, $this->clients->get_id(),
			]) as $data);

			if ($this->db->query("DELETE FROM ws_devices WHERE slug = ? AND username = ?" , [
				$slug, 
				$this->clients->get_id() 
			])) {
				$this->linked->unlink($data['id']);
			} else {
				Callback::json(500, [
					'return' => 'error-db'
				]);
			}
		}

		public function favorited(): void {
			foreach ($this->db->query("SELECT slug, favorited, username FROM ws_devices WHERE slug = ? AND username = ? LIMIT 1" , [ 
				Clean::slug($_POST['slug']),
				$this->clients->get_id() 
			]) as $data);

			if ($data['favorited'] == 'true') {
				$favorited	=	'false';
			} else {
				$favorited	=	'true';
			}

			if ($this->db->query("UPDATE ws_devices SET favorited = ? WHERE slug = ? AND username = ?", [
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
					'return' => 'error-favorited-device'
				]);
			}
		}

		public function edit(array $data): void {
			if ($this->db->query("UPDATE ws_devices SET os = ?, cpu = ?, arch = ?, hostname = ? WHERE uuid = ? AND username = ?", [
				Clean::default($_POST['os']),
				Clean::default($_POST['cpu']),
				Clean::default($_POST['arch']),
				Clean::default($_POST['hostname']),

				$data['uuid'],
				$data['username']
			])) {
				Callback::json(200, [ 
					'return'	=>	'success',
					'slug'		=>	$data['slug'],
					'prod_id'	=>	$this->get_prod_id($data['slug']),
				]);
			} else {
				Callback::json(500, [
					'return' => 'error-db-edit-device'
				]);
			}
		}

		public function __construct() {
			$this->db		=	new DB;
			$this->linked	=	new Linked;
			$this->clients	=	new Clients;
		}

		public function create($data): void {
			$slug	=	Random::slug([ 36, 48 ]);
			$uuid	=	OpenSSL::encrypt(
				Clean::default($_POST['uuid'])
			);
			
			if ($this->check_exists($uuid, $data['username']) != true) {
				if ($this->db->query("INSERT INTO ws_devices(slug, uuid, hostname, ip, os, cpu, arch, username) VALUES(?, ?, ?, ?, ?, ?, ?, ?)", [
					$slug,
					$uuid,
					Clean::default($_POST['hostname']),
					OpenSSL::encrypt($_POST['ip']),
					IP::encode($_POST['ip']),
					Clean::default($_POST['os']),
					Clean::default($_POST['cpu']),
					Clean::default($_POST['arch']),
					
					$data['username'],
				])) {
					$this->linked->create([
						'license'	=>	$data['license'],
						'username'	=>	$data['username'],
						'device'	=>	$this->get_id($slug),
						'slug'		=>	$data['slug-license'],
					]);
				} else {
					Callback::json(500, [
						'return' => 'error-db-devices'
					]);
				}
			} else {
				$this->edit([
					'uuid'		=>	$uuid,
					'license'	=>	$data['license'],
					'username'	=>	$data['username'],
					'device'	=>	$this->get_id($slug),
					'slug'		=>	$data['slug-license'],
				]);
			}
		}

	}