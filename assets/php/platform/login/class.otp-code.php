<?php

	class OTPCode {
		
		private $db, $clients;

		private function type($type) {
			return match (Clean::string($type, 'az')) {
				default		=>	false,
				'login'		=>	'login',
				'reset'		=>	'reset',
				'confirm'	=>	'confirm',
				'register'	=>	'register',
			};
		}

		public function generate() {
			if (Validation::email('email', 'post')) {
				$slug		=	Random::slug([ 36, 48 ]);
				$otp		=	Random::string(12, true, true, true);
				$username	=	$this->clients->get_username($_POST['email']);
				
				if ($username != false) {
					$query	=	$this->db->query("SELECT email, name FROM ws_clients WHERE id = ?", [ $username ]);
					foreach ($query as $data);

					Headers::setContentType('application/json');
					if ($this->db->query("INSERT INTO ws_otp_code(slug, code, type, username) VALUES (?, ?, ?, ?)", [
						$slug, $otp, $this->type($_POST['type']), $username,
					])) {
						if (Email::sender([
							'body'		=>	$otp,
							'type'		=>	'otp',
							'name'		=>	$data['name'],
							'subject'	=>	$this->type($_POST['type']),
							'email'		=>	OpenSSL::decrypt($data['email']),
						])) {
							Callback::json(200, [
								'slug'		=>	$slug,
								'return'	=>	'success'
							]);
						} else {
							Callback::json(500, [ 'return' => 'error-email-sender' ]);
						}
					} else {
						Callback::json(500, [ 'return' => 'error-insert-db' ]);
					}
				} else {
					Callback::json(500, [ 'return' => 'error-username' ]);
				}
			} else {
				Callback::json(500, [ 'return' => 'error-email-invalid' ]);
			}
		}

		public function __construct() {
			$this->db		=	new DB;
			$this->clients	=	new Clients;
		}
		
		public function check_exists() {
			if (count(
				$this->db->query("SELECT slug FROM ws_otp_code WHERE slug = ?", [
					Clean::slug($_GET['slug'])
				])
			) > 0) {
				Callback::json(200, [ 'return' => 'success' ]);
			} else {
				Callback::json(500, [ 'return' => 'error-otp-invalid' ]);
			}
		}

		public function delete($type, $code) {
			if ($this->db->query("DELETE FROM ws_otp_code WHERE type = ? AND code = ?", [
				$this->type($type), Clean::slug($code),
			])) {
				return true;
			} else {
				return false;
			}
		}
		
		public function verify($type, $code) {
			$query	=	$this->db->query("SELECT id FROM ws_otp_code WHERE type = ? AND code = ?", [
				$this->otp_type($type), 
				$code
			]);

			if (count($query) > 0) {
				return true;
			} else {
				return false;
			}
		}

		public function get_username($type, $code) {
			$query	=	$this->db->query("SELECT username FROM ws_otp_code WHERE type = ? AND code = ?", [
				$this->otp_type($type),
				$code
			]);

			foreach ($query as $data);
			return $data['username'];
		}
	
	}