<?php

	class CSRF {

		protected function code(): string {
			return Hash::token(
				Random::slug(64) . md5($_SERVER['REMOTE_ADDR']) . sha1($_SERVER['HTTP_USER_AGENT'])
			);
		}

		public function generate(): void {
			if (Cookies::has('csrf') == false) {
				Cookies::create([
					'name'		=>	'csrf',
					'value'		=>	$this->code(),
					'expire'	=>	time() + 300000
				]);
			}
		}

		public function validate(): string {
			if (Clean::string($_POST['csrf'], 'Az09') && Cookies::has('csrf') == true) {
				if (Cookies::get('csrf') != Clean::string(
					$_POST['csrf'], 'Az09'
				)) {
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

		public function get(): string { echo Cookies::get('csrf'); }

	}