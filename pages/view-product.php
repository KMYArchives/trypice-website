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
	
		include_once 'assets/php/views/header.php';
		include_once 'assets/php/views/account-box.php';
		
	?>
	
	<div class="products-box" id="products-box"></div>

	<div class="content">
		<div class="index">
			<div class="view-product">
				<div class="navbar-product" id="navbar-product">
					<img src="https://localhost/website/yuki/image/OCwOaNPj4Fe9OASFaM70SucP0VDyLC.png">
					<div class="name">DBack Pro</div>
					
					<nav>
						<div class="menu actived">Features</div>
						<div class="menu">Screenshots</div>
						<div class="menu">Support</div>

						<div class="menu buy">Buy</div>
						<div class="menu download">Download</div>
					</nav>
				</div>
			</div>
		</div>
	</div>

	<?php
	
		Loader::js([
			'https://js.stripe.com/v3'
		]);
		
	?>
</body>
</html>