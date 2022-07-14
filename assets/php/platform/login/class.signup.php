<?php

	class Signup {

		private $db;
		
		private function get_ip() {
			return IP::encode(
				IP::only_ip()
			);
		}

		private function check_email() {
			return $this->db->query("SELECT count(*) FROM ws_clients WHERE email = ?", [
				$this->prepare_email()
			])[0]['count(*)'];
		}

		private function set_user_key() {
			return Hash::user_key(
				Random::slug(128) . $_POST['email'] . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']
			);
		}
		
		private function prepare_email() {
			$email	=	Clean::default($_POST['email']);
			return OpenSSL::encrypt($email);
		}
		
		private function random_username() {
			return Random::slug([ 16, 24 ]);
		}

		public function execute() {
			if (Validation::email('email', 'post')) {
				if ($this->check_email() == 0) {
					if ($this->db->query("INSERT INTO ws_clients(email, pass, name, ip, userkey, username) VALUES(?, ?, ?, ?, ?, ?)", [
						$this->prepare_email(),
						Hash::pass($_POST['pass']),
						Clean::default($_POST['name']),
						$this->get_ip(),
						$this->set_user_key(),
						$this->random_username(),
					])) {
						Callback::json(200, [
							'return' => 'success'
						]);
					} else {
						Callback::json(500, [
							'return' => 'error-created-db'
						]);
					}
				} else {
					Callback::json(500, [
						'return' => 'error-email-existed'
					]);
				}
			} else {
				Callback::json(500, [
					'return' => 'error-email-invalid'
				]);
			}
		}

		public function __construct() { $this->db = new DB; }

	}