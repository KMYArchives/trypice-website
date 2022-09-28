<!DOCTYPE html>
<?php MetaTags::html_lang(); ?>
<head>
	<?php
	
		Loader::css();

		MetaTags::title();
		MetaTags::favicon();

		MetaTags::robots();
		MetaTags::viewport();
		MetaTags::keywords();
		MetaTags::canonical();
		MetaTags::description();

		MetaTags::compatible();
		MetaTags::content_type();
		MetaTags::content_language();

		MetaTagsSocial::og_url();
		MetaTagsSocial::og_type();
		MetaTagsSocial::og_title();
		MetaTagsSocial::og_image();
		MetaTagsSocial::og_description();

		MetaTagsSocial::twitter_card();
		MetaTagsSocial::twitter_site();
		MetaTagsSocial::twitter_title();
		MetaTagsSocial::twitter_image();
		MetaTagsSocial::twitter_creator();
		MetaTagsSocial::twitter_description();

	?>
</head>
<body>
	<?php
	
		App::view([
			'assets/php/views/header.php',
			'assets/php/views/account-box.php'
		]);
		
	?>

	<div class="products-box" id="products-box"></div>
	<section class="content"></section>

	<?php
	
		Loader::js([
			'https://checkout.stripe.com/checkout.js'
		]);
		
	?>
</body>
</html>