const URL = {

	get_url_base () {
		if (window.location.host == 'localhost') { 
			return window.location.origin + '/' + window.location.pathname.split('/')[1] + '/' 
		}
		
		return window.location.origin + '/'
	},

	change_url (url) {
		this.push_url(
			url.split('.').slice(-1)[0]
		)
	},

	get_url (check_slash) {
		if (check_slash) {
			if (Params.get_last() != '/') {
				return window.location.origin + window.location.pathname + '/'
			} else {
				return window.location.origin + window.location.pathname.replace(
					/^(.+?)\/*?$/, "$1"
				)
			}
		} else {
			return window.location.origin + window.location.pathname.replace(
				/^(.+?)\/*?$/, "$1"
			) + '/'
		}
	},

	open_url (url, url_base = true) {
		if (url_base == true) {
			window.location.href = this.get_url_base() + url
		} else {
			window.location.href = url
		}
	},

	push_url (url, data = null, title = null) {
		window.history.pushState(
			data, title, url
		)
	},

}