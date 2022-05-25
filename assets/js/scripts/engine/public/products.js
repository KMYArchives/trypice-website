const Products = {

	list () {
		axios.get(
			Apis.core() + 'core/products/list'
		).then( callback => {
			ProductsBox.search(callback.data.total)
			ProductsBox.more_btn(callback.data.total)

			_.forEach(callback.data.list, product => {
				ProductsBox.item(product)
				ProductsList.item(product)
			})
		})
	},

	init () {
		ProductsBox.layout()
		setTimeout( e => { this.list() }, 1000)
	},

}