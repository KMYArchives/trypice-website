const El = {

	_text (el, text) {
		if (text == null) {
			return El.get(el).innerText
		} else {
			El.get(el).innerText = text
		}
	},

	get (el, type = null) {
		switch (type) {
			case 'id':
				return document.getElementById(el)

			case 'class':
				return document.getElementsByClassName(el)

			case 'tag':
				return document.getElementsByTagName(el)

			case 'name':
				return document.getElementsByName(el)

			case 'selector':
				return document.querySelector(el)

			case 'child':
				return document.querySelector(el).childNodes

			case 'selectorAll':
				return document.querySelectorAll(el)

			default:
				return document.querySelector(el)
		}
	},

	show (el) {
		if (Array.isArray(el)) {
			for (let i = 0; i < el.length; i++) {
				El.get(el[i]).style.display = 'block'
			}
		} else {
			El.get(el).style.display = 'block'
		}
	},

	hide (el) {
		if (Array.isArray(el)) {
			for (let i = 0; i < el.length; i++) {
				El.get(el[i]).style.display = 'none'
			}
		} else {
			El.get(el).style.display = 'none'
		}
	},

	html (el) {
		return El.get(el).innerHTML
	},

	toggle (el) {
		var status

		var i = setInterval( e => {
			if (status) {
				clearInterval(i)
			} else {
				status = El.get(el).style.display
				El.get(el).style.display = status == 'none' ? 'block' : 'none'
			}
		}, 1)
	},

	append (el, html) {
		El.get(el).innerHTML += html
	},

	prepend (el, html) {
		El.get(el).innerHTML = html + El.get(el).innerHTML
	},

	remove (el) {
		if (El.has(el)) {
			El.get(el).remove()
		}
	},
	
	removeChild (el) {
		if (El.has(el)) {
			El.get(el).removeChild(
				El.get(el).childNodes[0]
			)
		}
	},

	removeChilds (el) {
		if (El.has(el)) {
			while (El.get(el).childNodes.length > 0) {
				El.get(el).removeChild(El.get(el).childNodes[0])
			}
		}
	},

	text (el, text = null) {
		if (Array.isArray(el)) {
			el.forEach( div => {
				this._text(div, text)
			})
		} else {
			this._text(el, text)
		}
	},

	select (el) {
		El.get(el).select()
	},

	empty (el) {
		if (Array.isArray(el)) {
			for (let i = 0; i < el.length; i++) {
				El.get(el[i]).innerHTML = ''
			}
		} else {
			El.get(el).innerHTML = ''
		}
	},

	has (el) {
		return El.get(el) != null
	},

	is_visible (el) {
		return El.get(el).style.display == 'block'
	},

	is_hidden (el) {
		return El.get(el).style.display == 'none'
	},

	is_empty (el) {
		return El.get(el).innerHTML == ''
	},

	count (el) {
		return El.get(el, 'selectorAll').length
	},

	contains (el, child) {
		return El.get(el).contains(El.get(child))
	},

	value (el, value = null) {
		if (value != null) {
			El.get(el).value = value
		} else {
			return El.get(el).value
		}
	},

}