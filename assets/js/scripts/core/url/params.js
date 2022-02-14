const Params = {

	set (param) {
		URL.push_url(
			URL.get_url().replace(
				/^(.+?)\/*?$/, "$1"
			) + '/' + param.replace(
				/\//g, ''
			)
		)
	},

	get_last (url) {
		if (url) {
			return url.split('/').slice(-1)[0] 
		} else {
			return window.location.pathname.split('/').slice(-1)[0] 
		}
	},

	remove_last () {
		URL.push_url(
			URL.get_url().substring(
				0, URL.get_url().length - this.get_last().length - 2
			)
		)
	},

}