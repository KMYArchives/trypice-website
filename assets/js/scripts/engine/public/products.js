const Products = {

	init () {
		ProductsBox.layout()
		this.list_menu()
	},

	list_menu () {
		axios.get(Apis.core() + 'core/products/list').then( callback => {
			ProductsBox.search(callback.data.total)
			ProductsBox.more_btn(callback.data.total)
			_.forEach(callback.data.list, product => { ProductsBox.item(product) })
		})
	}

}