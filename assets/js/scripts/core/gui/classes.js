const Classes = {

	_remove (elem, class_name) {
		if (Classes.has(elem, class_name)) {
			El.get(elem).classList.remove(class_name)
		}
	},

	_add_class (elem, class_name) {
		if (/\s/.test(class_name)) {
			class_name.split(' ').forEach( e => {
				El.get(elem).classList.add(e)
			})
		} else {
			El.get(elem).classList.add(class_name)
		}
	},

	_remove_class (elem, class_name) {
		if (/\s/.test(class_name)) {
			class_name.split(' ').forEach( class_css => {
				Classes._remove(elem, class_css)
			})
		} else {
			Classes._remove(elem, class_name)
		}
	},

	get (elem) {
		return El.get(elem).classList
	},

	add (elem, class_name) {
		if (Array.isArray(elem)) {
			elem.forEach( e => {
				Classes._add_class(e, class_name)
			})
		} else {
			Classes._add_class(elem, class_name)
		}
	},

	remove (elem, class_name, all = false) {
		if (all) {
			var elements = El.get(elem, 'selectorAll')

			for (var i = 0; i < elements.length; i++) {
				El.hide(elements[0].className)
			}
		} else {
			if (Array.isArray(elem)) {
				elem.forEach( e => {
					Classes._remove_class(e, class_name)
				})
			} else {
				Classes._remove_class(elem, class_name)
			}
		}
	},

	toggle (elem, class_name = act_class) {
		if (!Classes.has(elem, class_name)) {
			Classes.add(elem, class_name)
		} else {
			Classes.remove(elem, class_name)
		}
	},

	change (elem, rem_class, add_class) {
		Classes.remove(elem, rem_class)
		Classes.add(elem, add_class)
	},

	has (elem, class_name) {
		return El.get(elem).classList.contains(class_name)
	},

	replace (elem, old_class_name, new_class_name) {
		El.get(elem).classList.replace(
			old_class_name, new_class_name
		)
	},

	is_visible (elem) {
		var element = El.get(elem)
		return element.offsetWidth > 0 && element.offsetHeight > 0
	},

}