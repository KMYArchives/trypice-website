const Str = {
	
	capitalize (string) {
		if (typeof string !== 'string') return ''
		return string.charAt(0).toUpperCase() + string.slice(1)
	},

	slug (val, replaceBy = '-') {
		var patterns = {
			c: /\xE7/g,
			C: /\xC7/g,
			n: /\xF1/g,
			N: /\xD1/g,
			a: /[\xE0-\xE6]/g,
			A: /[\xC0-\xC6]/g,
			e: /[\xE8-\xEB]/g,
			E: /[\xC8-\xCB]/g,
			i: /[\xEC-\xEF]/g,
			I: /[\xCC-\xCF]/g,
			o: /[\xF2-\xF6]/g,
			O: /[\xD2-\xD6]/g,
			u: /[\xF9-\xFC]/g,
			U: /[\xD9-\xDC]/g,
		}

		for (var letter in patterns) {
			val = Find.replace(
				val, patterns[letter], letter
			)
		}

		val = val.toLowerCase()
		val = Find.replace(val, /[^a-z0-9\-]/g, " ")
		val = Find.replace(val, / {2,}/g, " ")
		val = val.trim()
		val = Find.replace(val, /\s/g, replaceBy)
		return val
	},
	
	cut (string, length, ending = '...') {
		if (string.length > length) {
			return string.substring(0, length - ending.length) + ending
		} else {
			return string
		}
	},

	parse (json_content) { return JSON.parse(json_content) },

	slice (string, char, slice) { return string.split(char)[slice] },
	
	stringify (json_content, indent = 4) { return JSON.stringify(json_content, null, indent) },

}