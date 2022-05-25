const HeaderList = {

	layout () {
		if (El.has(
			this.root_element()
		)) {
			El.append(this.root_element(), `
				<div class='icons'>
					<div class='icon'>
						<div class='fas fa-arrow-left'></div>
					</div>
				</div>

				<div class="label"></div>
					
				<div class="filter-box">
					<div class="filter-label filter-license-btn"></div>
					<div class="filter-options filter-license-box"></div>
				</div>
				
				<input type='text' placeholder='Search...'>
			`)

			this.filter_list()
			this.text('My licenses')
		}
	},

	text (text) {
		if (El.has(
			this.root_element()
		)) {
			El.text(
				`${ this.root_element() } > .label`, text
			)
		}
	},

	filter_list () {
		FilterBox.text(filter_license_btn, 'All licenses')
		Classes.add(filter_box, 'animate__animated animate__zoomIn animate__faster')

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
	},

	root_element () { return page_account_content + ' > .list > .list-header' }

}