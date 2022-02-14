const Session = {

	get (key) {
		return Str.parse(
			sessionStorage.getItem(key)
		)
	},

	has (key) {
		if (this.get(key) != null) {
			return true
		} else {
			return false
		}
	},

	delete (key) {
		if (Array.isArray(key) != true) {
			if (sessionStorage.removeItem(key)) {
				return true
			} else {
				return false
			}
		} else {
			key.forEach( item => { sessionStorage.removeItem(item) })
			return true
		}
	},

	save (key, value) {
		if (sessionStorage.setItem(
			key, Str.stringify(value)
		)) {
			return true
		} else {
			return false
		}
	},

}