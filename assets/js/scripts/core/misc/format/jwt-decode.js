const JWTDecode = {

	decode (token) {
		let parts = token.split('.')

		if (parts.length !== 3) {
			throw new Error('JWT must have 3 parts')
		}

		let decoded = this.urlBase64Decode(parts[1])
		if (!decoded) {
			throw new Error('Cannot decode the token')
		}

		return Str.parse(decoded)
	},

	urlBase64Decode (str) {
		let output = str.replace(
			/-/g, '+'
		).replace(
			/_/g, '/'
		);

		switch (output.length % 4) {
			case 0:
				break

			case 2:
				output += '=='
				break

			case 3:
				output += '='
				break
				
			default:
				throw new Error('Illegal base64url string!')
		}

		return this.b64DecodeUnicode(output)
	},

	b64DecodeUnicode (str) {
		return decodeURIComponent(
			Array.prototype.map.call(
				this.b64decode(str), 
			(c) => {
				return '%' + (
					'00' + c.charCodeAt(0).toString(16)
				).slice(-2)
			}).join('')
		);
	}

}