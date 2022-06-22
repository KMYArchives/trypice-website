<?php

	class Sessions {

		private $db, $clients, $products;

		public function __construct() {
			$this->db		=	new DB;
			$this->clients	=	new Clients;
			$this->products	=	new Products;
		}

		public function check_exists(): void {
			if ($this->db->query("SELECT COUNT(*) FROM ws_sessions WHERE session_id = ? AND product = ? AND username = ?", [
				Clean::slug($_POST['session']),
				Clean::slug($_POST['product']),
				$this->clients->get_id($_POST['username'])
			])[0]['COUNT(*)'] > 0) {
				Callback::json(200, [
					"return"	=>	"session-exists",
				]);
			} else {
				Callback::json(404, [
					"return"	=>	"session-not-exists",
				]);
			}
		}

		public function create(array $data): bool {
			Clean::slug($data['product']);
			Clean::slug($data['username']);

			if ($this->db->query("INSERT INTO ws_sessions(slug, ip, session_id, prod_id, username) VALUES(?, ?, ?, ?, ?)", [
				Random::slug([ 36, 48 ]),
				Clean::float($data['ip']),
				Clean::slug($data['session_id']),
				$this->products->get_id($data['product']), 
				$this->clients->get_id($data['username']),
			])) {
				return true;
			} else {
				return false;
			}
		}

	}