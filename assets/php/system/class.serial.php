<?php

	class Serial {

		public $prefix = null;
		public $number_chunks = 5;
		public $serial_mask = null;
		public $chars_per_chunks = 5;
		public $includes_symbols = false;
		public $separate_chunk_text = '-';
		protected $available_characters = [];
		protected $total_available_characters = 0;

		protected function reset() {
			$this->number_chunks				=	5;
			$this->chars_per_chunks				=	5;
			$this->separate_chunk_text			=	'-';
			$this->serial_mask					=	null;
			$this->includes_symbols				=	false;
			$this->available_characters			=	$this->available_characters();
			$this->total_available_characters	=	count($this->available_characters);
		}
		
		protected function crc32_hash($data) {
			$str	=	'';
			$map	=	'0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$hash	=	bcadd(
				sprintf(
					'%u', crc32($data)
				), 0x100000000
			);
			
			do {
				$str	=	$map[
					bcmod($hash, 62)
				] . $str;
				
				$hash	=	bcdiv($hash, 62);
			}

			while ($hash >= 1);
			$str	=	strtoupper($str);
			
			return str_replace(
				'-', '', $str
			);
		}
		
		protected function validateProperties() {
			if (!is_numeric($this->total_available_characters)) { $this->reset(); }
			if (!is_array($this->available_characters) || empty($this->available_characters)) { $this->reset(); }
			if (!is_int($this->number_chunks) || !is_int($this->chars_per_chunks) || $this->number_chunks < 1 || $this->chars_per_chunks < 1) { $this->reset(); }
		}

		protected function count_slice($serial) {
			foreach (explode($this->separate_chunk_text, $serial) as $slice) {
				if (strlen($slice) != $this->chars_per_chunks) { return false; }
			}
			
			return true;
		}

		protected function count_chunks($serial) {
			if ($this->count_slice($serial, $this->separate_chunk_text) == $this->number_chunks) {
				return true;
			} else {
				return false;
			}
		}
		
		protected function available_characters() {
			if ($this->includes_symbols == true) {
				return [
					'@', '#', '&', '+', '$',
					'0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
					'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
				];
			}

			return [
				'0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
				'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
			];
		}
		
		protected function serial_mask($string, $mask) {
			$k		=	0;
			$out	=	'';

			for ($i = 0; $i <= strlen($mask) - 1; $i++) {
				if (in_array($mask[$i], ['#', '*', '?', 'X', 'x', 'Y', 'y', 'Z', 'z'])) {
					if (isset($string[$k])) { $out .= $string[$k++]; }
				} else {
					if (isset($mask[$i])) { $out .= $mask[$i]; }
				}
			}

			return $out;
		}

		public function create() {
			$output = '';
			$this->validateProperties();

			for ($chunk = 1; $chunk <= $this->number_chunks; $chunk++) {
				for ($letter = 1; $letter <= $this->chars_per_chunks; $letter++) {
					if (function_exists('mt_rand')) {
						$output .= $this->available_characters[mt_rand(0, ($this->total_available_characters - 1))];
					} else {
						$output .= $this->available_characters[array_rand($this->available_characters)];
					}
				}

				unset($letter);
				if ($chunk < $this->number_chunks) { $output .= $this->separate_chunk_text; }
			}
			
			if ($this->prefix != null) { 
				$this->prefix = $this->crc32_hash($this->prefix);
				$output = substr($this->prefix, 0, $this->chars_per_chunks) . $this->separate_chunk_text . $output;
			}
			
			if ($this->serial_mask != null) { 
				$output = $this->serial_mask(
					str_replace(['-', ' ', $this->separate_chunk_text], '', $output
				), $this->serial_mask); 
			}
			
			unset($chunk);
			return $output;
		}

		public function valid($serial) {
			if (strpos($serial, $this->separate_chunk_text)) {
				if ($this->count_chunks($serial) == true) {
					if ($this->includes_symbols == true) {
						if (preg_match('/[^a-zA-Z\d]/', $serial) == true && $this->count_slice($serial) == true) {
							return true;
						} else {
							return false;
						}
					} else {
						if ($this->count_slice($serial) == true) {
							return true;
						} else {
							return false;
						}
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		public function encode($serial) {
			return OpenSSL::encrypt(
				bin2hex($serial)
			);
		}

		public function decode($serial) {
			return hex2bin(
				OpenSSL::decrypt($serial)
			);
		}

		public function __construct($rules = []) {
			if ($rules['prefix'] != null) { $this->prefix = $rules['prefix']; }
			if ($rules['serial_mask'] != null) { $this->serial_mask = $rules['serial_mask']; }
			if ($rules['number_chunks'] != null) { $this->number_chunks = $rules['number_chunks']; }
			if ($rules['includes_symbols'] == true) { $this->includes_symbols = $rules['includes_symbols']; }
			if ($rules['chars_per_chunks'] != null) { $this->chars_per_chunks = $rules['chars_per_chunks']; }
			if ($rules['separate_chunk_text'] != null) { $this->separate_chunk_text = $rules['separate_chunk_text']; }

			$this->available_characters = $this->available_characters();
			$this->total_available_characters = count($this->available_characters);
		}

	}