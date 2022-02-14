const Account = {

	set_name (name) {
		El.text([
			account_box + '> .user > .name',
			account_sidebar + '> .user > .name'
		], name)
	},

	set_avatar (url) {
		Attr.set([
			account_avatar + ' > img',
			account_box + '> .user > .avatar',
			account_sidebar + '> .user > .avatar',
		], 'src', url)
	},

	set_cover (cover) {
		Attr.set([
			cover_box,
			cover_sidebar,
		], 'style', `background-image: url('${ cover }')`)
	},

}