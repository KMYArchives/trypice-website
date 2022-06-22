<div class="mask"></div>
<header>
	<div class='header-content'>
		<a href='./' class="logo"></a>

		<nav>
			<div class="item">About</div>
			<div class="item" id="products-btn" onclick="Header.toggle_products()">Products</div>
			<div class="item">Workspace</div>

			<div class="item user" id="account-avatar" onclick="Header.toggle_account()">
				<img src="<?php echo System::links('website') ?>assets/img/avatar.png" alt="avatar-user">
			</div>
		</nav>
	</div>
</header>