window.onload = e => {

	Header.layout()
	Products.init()
	AccountBox.layout()
	if (El.has(account_sidebar)) { AccountSidebar.layout() }

	Classes.add([
		account_box,
		products_box
	], 'animate__animated animate__zoomIn animate__faster')

	document.addEventListener('scroll', e => {
		if (window.scrollY >= 25) {
			Classes.add('header', 'header-scroll-effect')
		} else {
			Classes.remove('header', 'header-scroll-effect')
		}
	})

	Events.click(mask, e => { Modals.close_all() })

}