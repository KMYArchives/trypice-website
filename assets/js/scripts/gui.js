window.onload = e => {

	Header.layout()
	Products.init()
	AccountBox.layout()

	HeaderList.layout()
	HeaderList.text('My licenses')
	if (El.has(account_sidebar)) { AccountSidebar.layout() }

	Classes.add([
		filter_box,
		account_box,
		products_box,
	], 'animate__animated animate__zoomIn animate__faster')

	Events.scroll('body', e => {
		if (window.scrollY >= 25) {
			Classes.add('header', 'header-scroll-effect')
		} else {
			Classes.remove('header', 'header-scroll-effect')
		}
	})

	FilterBox.set(filter_license_box, [
		{
			actived: true,
			id: 'all-licenses',
			title: 'All licenses',
		},
		{
			id: 'actived-licenses',
			title: 'Actived licenses',
		},
		{
			id: 'expired-licenses',
			title: 'Expired licenses',
		},
		{
			id: 'cancelled-licenses',
			title: 'Cancelled licenses',
		},
	])

	Events.click(filter_license_btn, e => {
		FilterBox.toggle(
			filter_license_btn,
			filter_license_box
		)
	})
	
	Events.click(mask, e => { Modals.close_all() })

	FilterBox.text(filter_license_btn, 'All licenses')

}