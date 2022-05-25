const Login = {

	verify () {
		axios.get(`${ 
			Apis.core() 
		}login/check-logged`).then( callback => {
			if (callback.data.logged) {
				El.show(account_box + ' > .menu')
			} else {
				El.hide(account_box + ' > .menu')
			}
		})
	},

}