const Numbers = {

	month (month) {
		switch (month) {
			case 1: return 'January'
			case 2: return 'February'
			case 3: return 'March'
			case 4: return 'April'
			case 5: return 'May'
			case 6: return 'June'
			case 7: return 'July'
			case 8: return 'August'
			case 9: return 'September'
			case 10: return 'October'
			case 11: return 'November'
			case 12: return 'December'
		}
	},

	float (float) {
		var x = 0,
			r = '',
			n = float.toString()
	
		for (var i = n.length; i > 0; i--) {
			r += n.substr(i - 1, 1) + (x == 2 && i != 1 ? '.' : '')
			x = x == 2 ? 0 : x + 1
		}
	
		return r.split('').reverse().join('')
	},

	discount (price, discount) {
		return price - (
			price * (discount / 100)
		)
	},
	
	bytes (bytes, decimals = 2) {
		bytes = parseInt(bytes)
		if (bytes === 0) { return '0 Bytes' }
	
		var k = 1024,
			dm = decimals < 0 ? 0 : decimals,
			i = Math.floor(Math.log(bytes) / Math.log(k)),
			sizes = [ 'Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' ]
			
		return parseFloat(
			(bytes / Math.pow(k, i)).toFixed(dm)
		) + ' ' + sizes[i]
	},
	
	percent (x, y, p = 100, fxd = 1) { 
		return (
			x * p / y
		).toFixed(fxd) + '%' 
	},

	currency (value, currency, locale = 'en-US') {
		return value.toLocaleString(locale, {
			style: 'currency',
			currency: currency,
		})
	},

}