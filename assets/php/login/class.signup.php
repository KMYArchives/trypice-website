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
				Utils::random(128, true, true, true) . $_POST['email'] . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']
			);
		}
		
		private function prepare_email() {
			$email	=	Clean::default($_POST['email']);
			return OpenSSL::encrypt($email);
		}
		
		private function random_username() {
			return Utils::random(
				16, true, true, true
			);
		}

		public function execute() {
			if (Validation::email('email', 'post')) {
				Headers::setContentType('application/json');

				if ($this->check_email() == 0) {
					if ($this->db->query("INSERT INTO ws_clients(email, pass, name, ip, userkey, username) VALUES(?, ?, ?, ?, ?, ?)", [
						$this->prepare_email(),
						Hash::pass($_POST['pass']),
						Clean::default($_POST['name']),
						$this->get_ip(),
						$this->set_user_key(),
						$this->random_username(),
					])) {
						Headers::setHttpCode(200);
						echo json_encode([ 'return' => 'success' ]);
					} else {
						Headers::setHttpCode(500);
						echo json_encode([ 'return' => 'error-created-db' ]);
					}
				} else {
					Headers::setHttpCode(500);
					echo json_encode([ 'return' => 'error-email-existed' ]);
				}
			} else {
				Headers::setHttpCode(500);
				echo json_encode([ 'return' => 'error-email-invalid' ]);
			}
		}

		public function __construct() { $this->db = new DB; }

	}