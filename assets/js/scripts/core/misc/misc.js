const Misc = {

	platform () {
		var platform = Str.slice(
			Str.slice(
				Find.replace_all(navigator.userAgent, ';', ''), '(', 1
			), ' ', 0
		).toLowerCase()

		return platform
	},

	gravatar (email) {
		if (Storage.has('gravatar') != true) {
			Encoder.toDataURL(Apis.gravatar(email), request => {
				Storage.save('gravatar', request)
				return request
			})
		} else {
			return Storage.get('gravatar')
		}
	},

	error_code (code) {
		switch (code) {
			case 'error-email': return 'Email invalid'
			case 'error-otp-invalid': return 'OTP Code invalid'
			case 'error-otp-expired': return 'OTP Code expired'
			case 'error-created-db': return 'Data not registered in DB'
			case 'error-email-exists': return 'The email already exists'
			case 'error-pass-matched': return 'Passwords are not the same'
			case 'error-login-auth': return 'Email or password are incorrect'
		}
	},

	download (link, name = null) {
		var a = document.createElement('a')
	
		a.href = link
		a.style.display = 'none'
		if (name) { a.download = name }

		document.body.appendChild(a)
		a.click()
	},

	change_type_input (input, element = 'toggle-type-input') {
		if (Attr.get(input, 'type') == 'password') {
			Attr.set(input, 'type', 'text')
			Classes.change(element, 'fa-eye-slash', 'fa-eye')
		} else {
			Attr.set(input, 'type', 'password')
			Classes.change(element, 'fa-eye', 'fa-eye-slash')
		}
	},

}