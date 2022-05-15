<?php

	class Clients {

		private $db;

		public function get_user() {
			return Str::last_slice(
				OpenSSL::decrypt(
					Cookies::get('user')
				), '-'
			);
		}

		public function req_user_id() {
			if ($_GET['username']) {
				return Clean::slug(
					$_GET['username'], 'Az09'
				);
			} else {
				return $this->get_id();
			}
		}
		
		public function get_id(string $user = null) {
			if ($user) {
				foreach ($this->db->query("SELECT id FROM ws_clients WHERE user_id = ?", [
					Clean::slug($user)
				]) as $data);
			} else {
				foreach ($this->db->query("SELECT id FROM ws_clients WHERE user_id = ?", [
					$this->get_user()
				]) as $data);
			}

			return $data['id'];
		}
		
		public function get_username(string $email) {
			$query	=	$this->db->query("SELECT id FROM ws_clients WHERE email = ?", [
				OpenSSL::encrypt(
					Clean::default($email)
				)
			]);

			foreach ($query as $data);
			
			if (count($query) > 0) {
				return $data['id'];
			} else {
				return false;
			}
		}

		public function __construct() { $this->db = new DB; }

	}