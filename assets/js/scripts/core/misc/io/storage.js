const Storage = {

	get (key) {
		return Str.parse(
			localStorage.getItem(key)
		)
	},

	has (key) {
		if (this.get(key) != null || this.get(key) != undefined) {
			return true
		} else {
			return false
		}
	},

	delete (key) {
		if (Array.isArray(key) != true) {
			if (localStorage.removeItem(key)) {
				return true
			} else {
				return false
			}
		} else {
			key.forEach( item => { localStorage.removeItem(item) })
			return true
		}
	},

	save (key, value) {
		if (localStorage.setItem(
			key, Str.stringify(value)
		)) {
			return true
		} else {
			return false
		}
	},

}