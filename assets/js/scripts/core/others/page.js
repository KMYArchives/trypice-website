const Page = {

	title (text = null, append = true) {
		if (text != null) {
			if (append) {
				return document.title = document.title + ' ' + text
			}

			return document.title = text
		} else {
			return document.title
		}
	},

	keywords (keywords = null) {
		if (keywords != null) {
			return El.get('meta[name="keywords"]').content = keywords
		} else {
			return El.get('meta[name="keywords"]').content
		}
	},

}