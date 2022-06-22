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
		<div class="login">
			<div class="login-frame">
				<div class="fas fa-times"></div>

				<div class="tab actived">Login</div>
				<div class="tab">Register</div>
			</div>

			<div class="login-content">
				<div class="label">Email</div>
				<input type="text" placeholder="Your email">
				
				<div class="label">
					Password
					<a href="#" class="password">Forget your password ?</a>
				</div>

				<input type="password" placeholder="Your password">
				<button>Connect</button>
			</div>
		</div>
	</div>

	<?php Loader::js(); ?>
</body>
</html>