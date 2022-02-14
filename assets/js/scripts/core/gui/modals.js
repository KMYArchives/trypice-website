const Modals = {
	
	show (modal) {
		if (Attr.has(modal, 'modal')) {
			modal = Attr.get(
				modal, 'modal'
			)
		}
	
		El.show([
			mask, modal
		])
	},
	
	close (window) {
		El.hide([
			mask, window
		])
	},

	all_modals () {
		return [
			modal,
			confirm_modal,
		]
	},
	
	close_all (clean_params = true, hide_mask = true) {
		var slice_url

		if (clean_params == true) {
			slice_url = Str.slice(
				Find.replace(
					URL.get_url(), 'localhost/', ''
				), '/', 3
			)
		
			Queries.remove([ 'i' ])
			Storage.delete([ 'cc-item', 'cc-list', 'cc-list2', 'ise-keyword', 'ise-editor-selection' ])
		}

		if (Find.search(URL.get_url(), 'account')) {
			if (Find.in_array(Params.get_last(), [ 
				'licenses', 'devices', 'settings', 'orders', 'cloud', 'hashes', 'diagrams', 'settings', 'table-models'
			]) != true) {
				Params.remove_last()
			}
		}
		
		if (hide_mask == true) { El.hide(mask) }

		El.hide(
			this.all_modals()
		)
		
		if (clean_params == true) {
			if (Find.in_array(slice_url, [ 
				'login', 'signup', 'forget', 'telemetry' 
			])) {
				Home.go_page()
			}
		}
	},

}