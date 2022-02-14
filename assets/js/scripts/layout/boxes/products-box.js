const ProductsBox = {

	layout () {
		El.empty(products_box)
		El.append(products_box, `
			<div class="input"></div>
			<div class="list"></div>
		`)
	},

	search (total) {
		if (total > 6) {
			El.append(`${ products_box } > .input`, `
				<input type="text" placeholder="Search products...">
			`)
		} else {
			El.empty(`${ products_box } > .input`)
		}
	},

	item (product) {
		El.append(`${ products_box } > .list`, `
			<a href="${ product.url }" class="product">
				<img src="${ product.logo.url }" alt="${ product.logo.name }">

				<div class="name">${ product.name }</div>
				<div class="slogan">${ product.slogan }</div>
			</a>
		`)
	},

	more_btn (total) {
		if (total > 6) {
			El.append(products_box, `<div class="more">Load more</div>`)
		} else {
			El.empty(`${ products_box } > .input`)
		}
	},

}