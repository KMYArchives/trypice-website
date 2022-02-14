const Find = {

	search (string, find) {
		if (string.search(find) != -1) {
			return true
		} else {
			return false
		}
	},

	in_array (string, array) {
		for (var i = 0; i < string.length; i++) {
			if (array[i] == string) { return true }
		}
		
		return false
	},

	array_remove_item (array, value) {
		var index = array.indexOf(value)
		if (index > -1) { array.splice(index, 1) }
		return array
	},

	replace_all (string, find, replace) {
		return string.replace(
			new RegExp(
				find.replace(
					/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1"
				), 'g'
			), replace
		)
	},

	replace_multiple (string, find, replace) {
		for (var i = 0; i < find.length; i++) {
			string = string.replace(
				new RegExp(find[i], "g"), replace[i]
			)
		}
	
		return string
	},

	replace (string, find, replace) { return string.replace(find, replace) }

}