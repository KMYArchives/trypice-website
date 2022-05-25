const Attr = {

	_set (e, attr, value) {
		if (El.has(e)) {
			El.get(
				e
			).setAttribute(
				attr, value
			)
		}
	},

	set (el, attr, value) {
		if (Array.isArray(el)) {
			el.forEach( div => {
				this._set(div, attr, value)
			})
		} else {
			this._set(el, attr, value)
		}
	},

	get (el, attr) {
		return El.get(
			el
		).getAttribute(
			attr
		)
	},

	remove (el, attr) {
		El.get(
			el
		).removeAttribute(
			attr
		)
	},

	toggle (el, attr) {
		El.get(el).setAttribute(
			attr, El.get(
				el, attr
			) == 'true' ? 'false' : 'true'
		)
	},

	has (el, attr) {
		return El.get(
			el
		).hasAttribute(
			attr
		)
	},

	setData (el, attr, value) {
		El.get(
			el
		).dataset[attr] = value
	},

	getData (el, attr) {
		return El.get(
			el
		).dataset[attr]
	},

	removeData (el, attr) {
		delete El.get(
			el
		).dataset[attr]
	},

	toggleData (el, attr) {
		El.setData(
			el, attr, El.getData(
				el, attr
			) == 'true' ? 'false' : 'true'
		)
	},

	hasData (el, attr) {
		return El.get(
			el
		).dataset.hasOwnProperty(
			attr
		)
	},

}