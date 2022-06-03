<?php

	class AppActivate {

		private $db, $clients, $products;

		public function __construct() {
			$this->db		=	new DB;
			$this->clients	=	new Clients;
			$this->products	=	new Products;
		}

		public function verify(): void {}

		public function activate(): void {}

	}