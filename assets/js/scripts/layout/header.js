const Header = {

	layout () {
		El.empty('header')
		El.append('header', `
			<div class='header-content'>
				<a href='./' class="logo"></a>

				<nav>
					<div class="item">About</div>
					<div class="item" id="${ Find.replace_all(products_btn, '#', '') }" onclick="Header.toggle_products()">Products</div>
					<div class="item">Workspace</div>

					<div class="item user" id="${ Find.replace_all(account_avatar, '#', '') }" onclick="Header.toggle_account()">
						<img src="${ URL.get_url_base() }yuki/image/avatar.png" alt="avatar-user">
					</div>
				</nav>
			</div>
		`)
	},

	toggle_account () {
		Login.verify()
		
		Classes.toggle(account_avatar, actived)
		El.hide([ products_box ])
		
		Classes.remove([
			products_btn,
		], actived)

		if (Classes.has(account_avatar, actived)) {
			El.show(account_box)
		} else {
			El.hide(account_box)
		}
	},

	toggle_products () {
		Classes.toggle(products_btn, actived)
		El.hide([ account_box ])

		Classes.remove([
			account_avatar,
		], actived)

		if (Classes.has(products_btn, actived)) {
			El.show(products_box)
		} else {
			El.hide(products_box)
		}
	},

}