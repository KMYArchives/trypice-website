const ProductsList = {
	
	item (product) {
		El.append(`${ products_list }`, `
			<a href="${ product.url }" class="product">
				<img src="${ product.logo.url }" alt="${ product.logo.name }">
				<div class="name">${ product.name }</div>
				<div class="desc">${ product.slogan }</div>
			</a>
		`)
	},

}