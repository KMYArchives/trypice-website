<?php

	class Currencies {

		private function _load_symbols() {
			return json_decode(
				file_get_contents(System::dir('json') . 'currencies-symbols.json'), true
			);
		}

		private function _load_currencies() {
			return json_decode(
				file_get_contents(System::dir('json') . 'currencies.json'), true
			);
		}

		private function _name(string $code) {
			foreach ($this->_load_currencies() as $key) {
				if ($key['code'] == strtoupper($code)) {
					$name	=	ucwords($key['name']);
				}
			}

			return $name;
		}

		private function _code(string $code) {
			foreach ($this->_load_symbols() as $key) {
				if ($key['code'] == strtoupper($code)) {
					$symbol		=	$key['code'];
				}
			}

			return $symbol;
		}

		private function _symbol(string $code) {
			foreach ($this->_load_symbols() as $key) {
				if ($key['code'] == strtoupper($code)) {
					$symbol		=	$key['symbol'];
				}
			}

			return $symbol;
		}

		private function _api(float $amount, string $from, string $to) {
			return json_decode(
				file_get_contents("https://api.exchangerate.host/convert?from=$from&to=$to&amount=$amount")
			);
		}

		public function get() {
			$code 			=	Clean::slug($_GET['code']);
			
			$currencies		=	json_decode(
				file_get_contents(System::dir('json') . 'currencies.json'), true
			);

			foreach ($currencies as $key) {
				if ($key['code'] == strtoupper($code)) {
					$currency['code']	=	$this->_code($code);
					$currency['name']	=	$this->_name($code);
					$currency['symbol']	=	$this->_symbol($code);
				}
			}

			Callback::json(200, $currency);
		}

		public function list() {
			Callback::json(
				200, $this->_load_symbols()
			);
		}

		public function convert() {
			$to			=	Clean::slug($_GET['to']);
			$from		=	Clean::slug($_GET['from']);
			$amount		=	Clean::float($_GET['amount']);
			$response	=	$this->_api($amount, $from, $to);

			if ($response->success == true) {
				Callback::json(200, [
					'to'			=>	$this->_name($to),
					'from'			=>	$this->_name($from),
					'amount'		=>	$this->_symbol($from) . ' ' . number_format($amount, 2, '.', ','),
					'converted'		=>	[
						'code'		=>	$this->_code($to),
						'amount'	=>	$this->_symbol($to) . ' ' . number_format($response->result, 2, '.', ','),
					],
				]);
			} else {
				Callback::json(500, [
					'error'		=>	'Something went wrong...'
				]);
			}
		}

	}