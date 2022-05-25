const AccountBox = {

	layout () {
		El.empty(account_box)
		El.append(account_box, `
			<div class="user">
				<div class="cover-box" id="${ Find.replace(cover_box, '#', '') }"></div>
				<img src="${ URL.get_url_base() }yuki/image/avatar.png" class="avatar">
				<div class="name">Connect to your account</div>
			</div>

			<div class="menu"></div>
		`)

		this.menu_items()
	},

	menu_items () {
		El.empty(account_box + ' > .menu')
		El.append(account_box + ' > .menu', `
			<div class="item">
				<div class="fa-solid fa-home-user"></div>
				View account
			</div>

			<div class="item">
				<div class="fa-solid fa-sign-out-alt"></div>
				Disconnect
			</div>
		`)
	},
	
}