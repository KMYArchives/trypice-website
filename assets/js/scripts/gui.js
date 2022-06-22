window.onload = e => {

	Login.verify()
	
	Home.content()
	HeaderList.layout()

	Classes.add([
		account_box,
		products_box,
	], 'animate__animated animate__zoomIn animate__faster')

	Events.scroll('body', e => {
		if (window.scrollY >= 50) {
			Classes.add('header', 'header-scroll-effect')
		} else {
			Classes.remove('header', 'header-scroll-effect')
		}
	})
	
	Events.click(mask, e => { Modals.close_all() })

}