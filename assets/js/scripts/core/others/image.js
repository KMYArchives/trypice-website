const Image = {

	set (elements, image) {
		Attr.set(elements, 'src', image.url)

		if (image.width) { Attr.set(elements, 'width', image.width) }
		if (image.height) { Attr.set(elements, 'width', image.height) }
		
		if (image.title) { Attr.set(elements, 'title', image.title) }
		if (image.alt_text) { Attr.set(elements, 'alt', image.alt_text) }
	},

	background (elements, image) {
		Attr.set(elements, 'style', `background-image: url('${
			image
		}')`)
	},

}