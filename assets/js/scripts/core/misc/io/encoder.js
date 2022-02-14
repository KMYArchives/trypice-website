const Encoder = {

	hex2bin (hex) {
		var str = ''
	
		for (var i = 0; i < hex.length; i += 2) {
			var v = parseInt(hex.substr(i, 2), 16)
			if (v) { str += String.fromCharCode(v) }
		}
		
		return str
	},

	bin2hex (string) {
		var str = ''
		
		for (var i = 0; i < string.length; i++) { 
			str += string[i].charCodeAt(0).toString(16) 
		}
		
		return str
	},

	toDataURL (url, callback) {
		var xhr = new XMLHttpRequest()
	
		xhr.onload = e => {
			var reader = new FileReader()
			reader.onloadend = e => { callback(reader.result) }
			reader.readAsDataURL(xhr.response)
		}
	
		xhr.open('GET', url)
		xhr.responseType = 'blob'
		xhr.send()
	},

	base64_encode (string) { return btoa(string) },
	
	base64_decode (string) { return atoa(string) },
	
	toTimestamp (date_time) { return Date.parse(date_time) / 1000 },

}