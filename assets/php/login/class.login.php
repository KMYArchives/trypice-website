<?php

	class Login {

		private $db, $clients, $details;

		public function login() {
			Headers::setContentType('application/json');

			if (Validation::email('email', 'post')) {
				$email	=	OpenSSL::encrypt(
					Clean::default($_POST['email'])
				);

				$query	=	$this->db->query("SELECT id, user_id, pass FROM ws_clients WHERE email = ?", [ $email ]);			
					
				if (count($query) > 0) {
					foreach ($query as $data) {
						$data['id'];
						$data['pass'];
						$data['user_id'];
					}
	
					if (Hash::pass($_POST['pass'], $data['pass'], true)) {
						if (Clean::default($_POST['client-id'])) {
							Headers::setHttpCode(200);

							echo json_encode([
								'return'	=>	'success',
								'id'		=>	$data['user_id'],
								'details'	=>	$this->details->login_details($data['user_id'])
							]);
						} else {
							Headers::setHttpCode(200);

							$this->set_user($data['user_id']);
							echo json_encode([ 'return' => 'success' ]);
						}
					} else {
						Headers::setHttpCode(403);
						echo json_encode([ 'return' => 'error-login-auth' ]);
					}
				} else {
					Headers::setHttpCode(403);
					echo json_encode([ 'return' => 'error-login-auth' ]);
				}
			} else {
				Headers::setHttpCode(403);
				echo json_encode([ 'return' => 'error-email' ]);
			}
		}

		public function sign_out() {
			Cookies::delete('user');

			Headers::setContentType('application/json');
			echo json_encode([ 'logoff' => true ]);
		}

		public function recovery() {
			$otp_code	=	new	OTPCode;
			$otp		=	Clean::slug($_POST['otp-code']);

			if ($otp->verify('reset', $otp)) {
				Headers::setContentType('application/json');
				
				if (Request::xss($_POST['new-pass']) == Request::xss($_POST['conf-pass'])) {
					if ($this->db->query("UPDATE ws_clients SET pass = ? WHERE username = ?", [
						Hash::pass($_POST['new-pass']),
						$otp_code->get_username('reset', $otp)
					])) {
						if ($otp_code->delete('reset', $otp)) {
							Headers::setHttpCode(200);
							echo json_encode([ 'return' => 'success' ]);
						} else {
							Headers::setHttpCode(403);
							echo json_encode([ 'return' => 'error-otp-deleted' ]);
						}
					} else {
						Headers::setHttpCode(500);
						echo json_encode([ 'return' => 'error-db' ]);
					}
				} else {
					Headers::setHttpCode(403);
					echo json_encode([ 'return' => 'error-pass-not-equals' ]);
				}
			} else {
				Headers::setHttpCode(403);
				echo json_encode([ 'return' => 'error-otp-code' ]);
			}
		}

		public function __construct() {
			$this->db		=	new DB; 
			$this->details	=	new Details;
			$this->clients	=	new Clients; 
		}

		public function check_logged() {
			Headers::setHttpCode(200);
			Headers::setContentType('application/json');
			
			if (Cookies::has('user')) {
				echo json_encode([ 'logged' => true ]);
			} else {
				echo json_encode([ 'logged' => false ]);
			}
		}
		
		public function set_user($user) {
			$value	=	OpenSSL::encrypt(
				Utils::random(18, true, true, true) . '-' . $user
			);

			return Cookies::create('user', $value, [
				'path'		=>	'/',
				'secure'	=>	true,
				'httpOnly'	=>	true,
				'domain'	=>	null,
				'sameSite'	=>	'strict',
				'expires'	=>	time() + (86400 * 30),
			]);
		}

	}