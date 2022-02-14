<?php

	class CurrencyConvert {

		private $_api_url, $_api_cache;

		private function _read() {
			return File::read(
				$this->_api_cache
			);
		}

		private function _read_online(string $from) {
			return File::read($this->_api_url . $from, [
				'remote'		=>	true,
				'json_decode'	=>	true,
			]);
		}

		private function _save(string $from = 'USD'): void {
			File::create($this->_api_cache, $this->_read_online($from), [
				'json_encode'	=>	true,
				'flags'			=>	JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
			]);
		}

		private function _get_currency(string $currency): float {
			$data = json_decode(
				$this->_read(), true
			)['conversion_rates'];

			foreach ($data as $key => $value) {
				if ($key == $currency) {
					return $value;
				}
			}
		}

		public function __construct() {
			System::load_env();

			$this->_api_url		=	str_replace(
				'${EXCHANGE_RATE_API_KEY}', $_ENV['EXCHANGE_RATE_API_KEY'], $_ENV['EXCHANGE_RATE_API_URL']
			) . 'latest/';

			$this->_api_cache	=	Values::$assets['json'] . $_ENV['EXCHANGE_RATE_API_CACHE_FILE_NAME'];
		}

		public function convert(float $value, string $currency): float {
			if (!file_exists($this->_api_cache)) { $this->_save(); }

			return Format::float(
				$this->_get_currency($currency) * $value, 2, '.', ','
			);
		}

	}