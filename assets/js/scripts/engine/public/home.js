const Home = {

	init () {
		if (Params.get_last() == '') {
			El.empty(page_content)
			
			El.append(page_content, `
				<div class="index">
					<div class='intro'>
						<div class='intro-text'>We build tools for all</div>
					</div>

					<div class='products'>
						<div class='products-area'></div>
					</div>
				</div>
			`)
		}
	},

	content () {
		this.init()
		Products.init()
		this.set_default_data()
	},

	set_default_data () {
		axios.get(
			Apis.core() + 'private/details'
		).then( callback => {
			cache.set('dataDefault', callback.data, 60000)
			
			El.text(products_h1, callback.data.slogan)
			Account.set_avatar(callback.data.default_avatar)
		})
	},

}