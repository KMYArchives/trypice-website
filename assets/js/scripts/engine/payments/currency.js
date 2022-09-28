const Currency = {

	list () {
		axios.get(`${
			Apis.core()
		}payments/currencies/list`).then( callback => {
			console.log(callback.data)
		})
	},

	convert (value, from, to) {
		axios.get(`${
			Apis.core()
		}payments/currencies/convert?from=${
			from
		}&to=${
			to
		}&amount=${
			value
		}`).then( callback => {
			console.log(callback.data)
		})
	},

}