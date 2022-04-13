const HeaderList = {

	layout () {
		El.append(this.root_element(), `
			<div class='icons'>
				<div class='icon'>
					<div class='fas fa-arrow-left'></div>
				</div>

				<div class='icon'>
					<div class='fas fa-bars'></div>
				</div>
			</div>

			<div class="label"></div>
				
			<div class="filter-box">
				<div class="filter-label filter-license-btn"></div>
				<div class="filter-options filter-license-box"></div>
			</div>
			
			<input type='text' placeholder='Search...'>
		`)
	},

	text (text) {
		El.text(
			`${ this.root_element() } > .label`, text
		)
	},

	root_element () { return page_account_content + ' > .list > .list-header' }

}