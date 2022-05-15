<?php

	class Format {

		public static function bytes(string|int $input): string {
			return sprintf(
				'%.02F', $input / pow(
					1024, floor(
						log($input) / log(1024)
					)
				)
			) * 1 . ' ' . [ 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' ][
				floor(
					log($input) / log(1024)
				)
			];
		}

		public static function float(float $value, int $decimals = 2): float {
			return number_format(
				$value, $decimals, '.', ','
			);
		}

		public static function timestamp(string $date, string $format): string {
			return date(
				$format, strtotime($date)
			);
		}

		public static function currency(float $value, string $currency = 'USD'): string {
			return '$' . number_format(
				$value, 2, '.', ','
			) . ' ' . $currency;
		}

		public static function date(string $input, string $format = 'Y-m-d H:i:s'): string {
			return date(
				$format, strtotime($input)
			);
		}

	}