<?php

	class CSRF {

		protected function code() {
			return Hash::token(
				Random::string(64, true, true, true) . 
				md5($_SERVER['REMOTE_ADDR']) . 
				sha1($_SERVER['HTTP_USER_AGENT'])
			);
		}

		public function generate() {
			if (Cookies::has('csrf') == false) {
				return Cookies::create([ 
					'csrf', $this->code(), time() + 300000 
				]);
			}
		}

		public function validate() {
			if (Clean::string($_POST['csrf'], 'Az09') && Cookies::has('csrf') == true) {
				if (Cookies::get('csrf') != Clean::string($_POST['csrf'], 'Az09')) {
					Cookies::remove('csrf');
					$this->generate();
					return false;
				} else {
					return true;
				}
			} else {
				return false;
			}
		}

		public function get() { echo Cookies::get('csrf'); }

	}