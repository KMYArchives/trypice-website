const AccountSidebar = {

	layout () {
		if (Find.search(
			URL.get_url(), 'account'
		)) {
			El.empty(account_sidebar)
			El.append(account_sidebar, `
				<div class="user">
					<div class="cover-sidebar" id="${ Find.replace(cover_sidebar, '#', '') }"></div>
					<img src="${ URL.get_url_base() }yuki/image/avatar.png" class="avatar">
					<div class="name">Connect to your account</div>
				</div>

				<div class="menu"></div>
			`)

			this.menu_items()
		}
	},

	menu_items () {
		El.empty(account_sidebar + ' > .menu')
		El.append(account_sidebar + ' > .menu', `
			<div class="item actived">
				<div class="fa-solid fa-home"></div>
				Dashboard
			</div>

			<div class="item">
				<div class="fa-solid fa-fingerprint"></div>
				Tokens
			</div>

			<div class="item">
				<div class="fa-solid fa-desktop"></div>
				Devices
			</div>

			<div class="item">
				<div class="fa-solid fa-key"></div>
				Licenses
			</div>

			<div class="item">
				<div class="fa-solid fa-shopping-cart"></div>
				Orders
			</div>

			<div class="item">
				<div class="fa-solid fa-calendar-day"></div>
				Subscriptions
			</div>

			<div class="item">
				<div class="fa-solid fa-cog"></div>
				Settings
			</div>
		`)
	},
	
}