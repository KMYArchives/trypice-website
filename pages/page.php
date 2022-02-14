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
	<div class="mask"></div>

	<header></header>
	<div class="account-box" id="account-box"></div>
	<div class="products-box" id="products-box"></div>

	<div class="content">
		<div class="index">
			<h1 class="h1">We build tools for all</h1>
		</div>
	</div>

	<?php Loader::js(); ?>
</body>
</html>