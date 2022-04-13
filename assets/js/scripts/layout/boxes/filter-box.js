const FilterBox = {

	del (box, items) {
		var get_id, get_class_name

		_.forEach(items, item => {
			get_class_name = `${ 
				box
			} > .${ item }`

			get_id = `${ 
				box
			} > #${ item }`
			
			if (El.has(get_id)) {
				El.remove(get_id)
			} else {
				El.remove(get_class_name)
			}
		})
	},

	toggle (btn, box) {
		Classes.toggle(btn, actived)
		El.toggle(box)
	},

	actived (box, item) {
		var get_id, get_class_name

		El.get(`${ 
			box
		} > .btn-item`, 'selectorAll').forEach( btn => {
			get_class_name = `${ 
				box
			} > .${ Str.slice(
					btn.className, ' ', 1
				)
			}`

			get_id = `${ 
				box
			} > #${ 
				btn.id
			}`

			if (El.has(get_id)) {
				Classes.remove(get_id, 'option-actived')
			} else {
				Classes.remove(get_class_name, 'option-actived')
			}
		})

		Classes.add(`#${ item }`, 'option-actived')
	},

	text (btn, text = null) {
		if (text != null) {
			El.text(`${ btn }`, text)
		} else {
			El.text(btn)
		}
	},

	clean (box) { El.empty(box) },

	set (box, items, append = true) {
		var click = '',
			item_id = '',
			actived_class

		_.forEach(items, item => {
			item_id = Find.replace(item.id, '#', '')
			if (append != true) { this.clean() }

			if (item.click != undefined) {
				click = `onclick="${
					item.click
				}"`
			}
			
			if (item.actived != undefined && item.actived == true) {
				actived_class = 'option-actived'
			} else {
				actived_class = ''
			}
			
			El.append(box, `
				<div class="filter-option ${
					actived_class
				}" id="${
					item_id
				}" ${
					click
				}>${
					item.title
				}</div>
			`)

			click = ''
		})
	},

}