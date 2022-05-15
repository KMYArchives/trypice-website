<?php

	class Login {

		private $db, $clients, $details;

		public function login() {
			if (Validation::email('email', 'post')) {
				$email	=	OpenSSL::encrypt($_POST['email']);
				$query	=	$this->db->query("SELECT id, user_id, pass FROM ws_clients WHERE email = ?", [ $email ]);			
					
				if (count($query) > 0) {
					foreach ($query as $data);
	
					if (Hash::pass($_POST['pass'], $data['pass'], true)) {
						if (Clean::slug($_POST['origin']) == 'app') {
							Callback::json(200, [
								'return'	=>	'success',
								'id'		=>	$data['user_id'],
								'details'	=>	$this->details->login_details($data['user_id'])
							]);
						} else if (Clean::slug($_POST['origin']) == 'web') {
							$this->set_user($data['user_id']);
							Callback::json(200, [ 'return' => 'success' ]);
						}
					} else {
						Callback::json(403, [ 'return' => 'error-login-auth-pass' ]);
					}
				} else {
					Callback::json(403, [ 'return' => 'error-login-auth-email' ]);
				}
			} else {
				Callback::json(403, [ 'return' => 'error-email' ]);
			}
		}

		public function sign_out() {
			Cookies::delete('user');
			Callback::json(200, [ 'logoff' => true ]);
		}

		public function recovery() {
			$otp_code	=	new	OTPCode;
			$otp		=	Clean::slug($_POST['otp-code']);

			if ($otp->verify('reset', $otp)) {
				if (Request::xss($_POST['new-pass']) == Request::xss($_POST['conf-pass'])) {
					if ($this->db->query("UPDATE ws_clients SET pass = ? WHERE username = ?", [
						Hash::pass($_POST['new-pass']),
						$otp_code->get_username('reset', $otp)
					])) {
						if ($otp_code->delete('reset', $otp)) {
							Callback::json(200, [ 'return' => 'success' ]);
						} else {
							Callback::json(403, [ 'return' => 'error-otp-deleted' ]);
						}
					} else {
						Callback::json(500, [ 'return' => 'error-db' ]);
					}
				} else {
					Callback::json(403, [ 'return' => 'error-pass-not-equals' ]);
				}
			} else {
				Callback::json(403, [ 'return' => 'error-otp-code' ]);
			}
		}

		public function __construct() {
			$this->db		=	new DB; 
			$this->details	=	new Details;
			$this->clients	=	new Clients; 
		}

		public function check_logged() {
			if (Cookies::has('user')) {
				Callback::json(200, [ 'logged' => true ]);
			} else {
				Callback::json(200, [ 'logged' => false ]);
			}
		}
		
		public function set_user($user) {
			$value	=	OpenSSL::encrypt(
				Random::string(
					18, true, true, true
				) . '-' . $user
			);

			return Cookies::create([
				'name'		=>	'user',
				'value'		=>	$value,
				'path'		=>	'/',
				'secure'	=>	true,
				'httpOnly'	=>	true,
				'domain'	=>	null,
				'sameSite'	=>	'strict',
				'expires'	=>	time() + (86400 * 30),
			]);
		}

	}