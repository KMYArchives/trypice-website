<?php

	class CurrencyConvertCodes {

		private $_api_url, $_api_cache_code;

		public function __construct() {
			System::load_env();

			$this->_api_url			=	str_replace(
				'${EXCHANGE_RATE_API_KEY}', $_ENV['EXCHANGE_RATE_API_KEY'], $_ENV['EXCHANGE_RATE_API_URL']
			);

			$this->_api_cache_code	=	Values::$assets['json'] . 'currencies/' . $_ENV['EXCHANGE_RATE_API_CODE_FILE_NAME'];
		}

	}