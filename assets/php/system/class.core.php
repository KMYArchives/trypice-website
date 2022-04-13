<?php

	class Core {

		public function basic() {
			Callback::json(200, [
				'name'			=>	System::global('name'),
				'etag'			=>	System::global('etag'),
				'company'		=>	System::global('name'),
				'slogan'		=>	System::global('slogan'),
				'charset'		=>	System::global('charset'),
				'language'		=>	System::global('language'),
				'social_media'	=>	System::global('social_media_user'),
				'links'			=>	[
					'website'	=>	System::links('website'),
					'api'		=>	System::links('api_link'),
					'cloud'		=>	System::links('workspace'),
				],
			]);
		}

		public static function layout(string $view) {
			if (file_exists('layout/' . $view . '.html')) {
				include 'layout/' . $view . '.html';
			}
		}
		
	}