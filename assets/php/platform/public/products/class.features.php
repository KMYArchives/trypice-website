<?php

	class Features {

		private $db;

		public function list(int $prod_id): array {
			return [
				'coming soon'
			];
		}

		public function __construct() { $this->db = new DB; }

	}