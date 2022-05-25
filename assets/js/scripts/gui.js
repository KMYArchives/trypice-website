window.onload = e => {

	Home.content()
	Header.layout()

	HeaderList.layout()
	AccountBox.layout()
	AccountSidebar.layout()

	Classes.add([
		account_box,
		products_box,
	], 'animate__animated animate__zoomIn animate__faster')

	Events.scroll('body', e => {
		if (window.scrollY >= 50) {
			Classes.add('header', 'header-scroll-effect')
			Classes.add('.navbar-product', 'header-scroll-effect')
		} else {
			Classes.remove('header', 'header-scroll-effect')
			Classes.remove('.navbar-product', 'header-scroll-effect')
		}
	})
	
	Events.click(mask, e => { Modals.close_all() })

}