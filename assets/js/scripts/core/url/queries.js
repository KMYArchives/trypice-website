const Queries = {

	_base () {
		return URL.get_url().replace(
			/^(.+?)\/*?$/, "$1"
		) + '?'
	},

	_search_params (query) {
		return new URLSearchParams(
			query
		).toString()
	},

	_queries (append = false) {
		if (append) {
			return window.location.search.replace(
				'?', ''
			) + '&'
		} else {
			return ''
		}
	},

	_push (url, data = null, title = null) {
		window.history.pushState(
			data, title, url
		)
	},

	clean () {
		URL.push_url(
			URL.get_url().replace(
				/^(.+?)\/*?$/, "$1"
			)
		)
	},

	has (query) {
		return this.get(query) != null
	},

	get (query) {
		var match,
			result = [],
			regexp = new RegExp(
				'(?:\\?|&)' + query + '=(.*?)(?=&|$)', 'gi'
			)

		while (
			(
				match = regexp.exec(
					document.location.search
				)
			) !== null
		) {
			result.push(match[1])
		}

		return result[0]
	},

	remove (queries) {
		let params = new URLSearchParams(
			window.location.search
		)

		if (Array.isArray(queries)) {
			queries.forEach( query => {
				params.delete(query)
			})
		} else {
			params.delete(queries)
		}

		URL.change_url(
			this._base() + this._search_params(
				params
			)
		)

		if (window.location.search == '') {
			this.clean()			
		}
	},

	add (query, append = false) {
		if (history.pushState) {
			URL.change_url(
				this._base() + this._queries(
					append
				) + this._search_params(
					query
				)
			)
		}
	},

	update (query, value, append = false) {
		if (this.has(query)) {
			var url = Find.replace(
				window.location.href, Queries.get(
					query
				), value
			)
	
			URL.change_url(
				this._base() + Str.slice(
					url, '?', 1
				)
			)
		} else {
			this.add(query, value, true)
		}
	},

}