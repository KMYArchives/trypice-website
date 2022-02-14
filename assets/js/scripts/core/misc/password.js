const Password = {

	_gen (charset, n) {
		return charset.charAt(
			Math.floor(
				Math.random() * n
			)
		)
	},

	base64 (length) {
		return Base64.bota(
			this.generate(length)
		)
	},

	generate (length) {
		var value = '',
			charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@?!#$%&*^~<>(){}[]-_+=/|"'

		for (var i = 0, n = charset.length; i < length; ++i) { 
			value += this._gen(
				charset, n
			)
		}

		return value
	},

}