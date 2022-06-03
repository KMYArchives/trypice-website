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
	<div class="confirm-mdl"></div>

	<header></header>
	<div class="account-box" id="account-box"></div>
	<div class="products-box" id="products-box"></div>

	<div class="content">
		<div class="account-side" id="account-sidebar"></div>

		<div class="account" id="page-account-content">
			<div class="list">
				<div class="list-header"></div>

				<div class="menu-box">
					<div class="item">View invoice</div>
					<div class="item">Download app</div>
					<div class="item">Help & Support</div>
				</div>

				<div class="info-box">
					<div class="header">
						<img src="https://i.imgur.com/IUK0LR0.png" alt="" srcset="">
						<div class="name">DBack Pro</div>
					</div>

					<div class="bar">
						<div class="fas fa-download"></div>
						<div class="fas fa-receipt"></div>
						<div class="fas fa-circle-question"></div>
					</div>

					<div class="label">ID: 175755670</div>
					<div class="label">Type: Personal</div>
					<div class="label">Devices: 4 of 4</div>
					<div class="label">Expire in: lifetime</div>
					<div class="label">Added in: 2022-04-12 21:28:17</div>

					<input value="CBZ2G-KJM9Q-QX6TH-N3SD6" id="license-key" readonly>
					<div class="fas fa-copy" title="Copy license key"></div>
				</div>

				<div class="list-content">
					<div class="section-header">
						<div class="label">Devices</div>

						<div class="fas fa-trash-alt"></div>
						<div class="fas fa-plus"></div>
					</div>

					<div class="item">
						<img src="https://i.imgur.com/IUK0LR0.png">

						<div class="name">DESKTOP-Q98CB6M</div>
						<div class="ip">192.168.0.1</div>
						<div class="system">Windows 10</div>
						<div class="date">0000-00-00 00:00:00</div>

						<div class="fas fa-trash-alt"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php Loader::js(); ?>
</body>
</html>