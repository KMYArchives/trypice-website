const Account = {

	set_name (name) {
		El.text([
			account_box + '> .user > .name',
			account_sidebar + '> .user > .name'
		], name)
	},

	set_avatar (link) {
		Image.set([
			account_avatar + ' > img',
			account_box + '> .user > .avatar',
			account_sidebar + '> .user > .avatar',
		], {
			url: link,
			alt_text: 'avatar',
			title: 'Avatar of user'
		})
	},

	set_cover (cover) {
		Image.background([
			cover_box,
			cover_sidebar,
		], cover)
	},

}