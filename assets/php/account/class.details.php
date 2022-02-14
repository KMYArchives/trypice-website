<?php

	class Details {

		private $db, $clients;

		public function stats() {
			$client		=	$this->clients->get_id();
			
			Headers::setHttpCode(200);
			Headers::setContentType('application/json');
			echo json_encode([
				'orders'		=>	$this->db->query("SELECT count(*) FROM ws_orders WHERE username = '$client'")[0]['count(*)'],
				'linked'		=>	$this->db->query("SELECT count(*) FROM ws_linked WHERE username = '$client'")[0]['count(*)'],
				'devices'		=>	$this->db->query("SELECT count(*) FROM ws_devices WHERE username = '$client'")[0]['count(*)'],
				'licenses'		=>	$this->db->query("SELECT count(*) FROM ws_licenses WHERE username = '$client'")[0]['count(*)'],
				'subscriptions'	=>	$this->db->query("SELECT count(*) FROM ws_subscriptions WHERE username = '$client'")[0]['count(*)'],
			]);
		}

		public function region() {
			foreach ($this->db->query("SELECT ip FROM ws_clients WHERE id = ?", [ 
				$this->clients->get_id(),
				Clean::slug($_GET['username'])
			]) as $data);

			Headers::setHttpCode(200);
			Headers::setContentType('application/json');
			echo IP::decode($data['ip']);
		}

		public function details() {
			foreach ($this->db->query("SELECT name, email, gender, username, confirmed FROM ws_clients WHERE id = ? OR user_id = ?", [ 
				$this->clients->get_id(),
				Clean::slug($_GET['username'])
			]) as $data) {
				$data['gravatar']	=	Utils::gravatar($data['email']);
				$data['email']		=	OpenSSL::decrypt($data['email']);
				$data['username']	=	OpenSSL::decrypt($data['username']);
			}

			Headers::setHttpCode(200);
			Headers::setContentType('application/json');
			echo json_encode($data);
		}

		public function __construct() {
			$this->db		=	new DB;
			$this->clients	=	new Clients;
		}

		public function login_details($user_id = null) {
			foreach ($this->db->query("SELECT name, email, gender, username, confirmed FROM ws_clients WHERE user_id = ?", [ 
				Clean::slug($user_id)
			]) as $data) {
				$data['gravatar']	=	Gravatar::get($data['email']);
				$data['email']		=	OpenSSL::decrypt($data['email']);
				$data['username']	=	OpenSSL::decrypt($data['username']);
			}

			return $data;
		}

	}