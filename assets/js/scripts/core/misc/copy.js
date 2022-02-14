const Copy = {

	input (input) {
		El.select('#' + input.id)
		Events.command('copy')	
	},

	content (content) {
		var dummy = document.createElement('input')
		document.body.appendChild(dummy)
		dummy.setAttribute('value', content)
		dummy.select()

		if (Events.command('copy') == true) {
			document.body.removeChild(dummy)
			return true
		} else {
			document.body.removeChild(dummy)
			return false
		}
	},

}