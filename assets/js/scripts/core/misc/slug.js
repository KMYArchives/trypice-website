const Slug = {

	_gen (charset, n) {
		return charset.charAt(
			Math.floor(
				Math.random() * n
			)
		)
	},

	upper (length) {
		var value = '',
			charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'

		for (var i = 0, n = charset.length; i < length; ++i) { 
			value += this._gen(
				charset, n
			)
		}

		return value
	},

	lower (length) {
		var value = '',
			charset = 'abcdefghijklmnopqrstuvwxyz'

		for (var i = 0, n = charset.length; i < length; ++i) { 
			value += this._gen(
				charset, n
			)
		}

		return value
	},

	letters (length) {
		var value = '',
			charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'

		for (var i = 0, n = charset.length; i < length; ++i) { 
			value += this._gen(
				charset, n
			)
		}

		return value
	},

	numbers (length) {
		var value = '',
			charset = '0123456789'

		for (var i = 0, n = charset.length; i < length; ++i) { 
			value += this._gen(
				charset, n
			)
		}

		return value
	},

	range (min, max) {
		return this.basic(
			Math.floor(
				Math.random() * (
					max - min + 1
				) + min
			)
		)
	},

	custom (options) {
		var size

		if (Array.isArray(options.length)) {
			size = Math.floor(
				Math.random() * (
					options.length[0] - options.length[1] + 1
				) + options.length[1]
			)
		} else {
			size = options.length
		}

		return this.basic(
			size,
			options.charset
		)
	},

	basic (length, char = null) {
		var value = '',
			charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'

		if (char) { charset = char }
		for (var i = 0, n = charset.length; i < length; ++i) { 
			value += this._gen(
				charset, n
			)
		}

		return value
	},

}