const Events = {

	command (command) {
		document.execCommand(command)
	},

	setPageTitle (title) {
		document.title = title
	},

	click (element, callback) {
		El.get(element).addEventListener(
			'click', callback
		)
	},

	dblclick (element, callback) {
		El.get(element).addEventListener(
			'dblclick', callback
		)
	},

	keydown (element, callback) {
		El.get(element).addEventListener(
			'keydown', callback
		)
	},

	keyup (element, callback) {
		El.get(element).addEventListener(
			'keyup', callback
		)
	},

	keypress (element, callback) {
		El.get(element).addEventListener(
			'keypress', callback
		)
	},

	mouseover (element, callback) {
		El.get(element).addEventListener(
			'mouseover', callback
		)
	},

	mouseout (element, callback) {
		El.get(element).addEventListener(
			'mouseout', callback
		)
	},

	mousemove (element, callback) {
		El.get(element).addEventListener(
			'mousemove', callback
		)
	},

	mousedown (element, callback) {
		El.get(element).addEventListener(
			'mousedown', callback
		)
	},

	mouseup (element, callback) {
		El.get(element).addEventListener(
			'mouseup', callback
		)
	},

	scroll (element, callback) {
		El.get(element).addEventListener(
			'scroll', callback
		)
	},

	select (element, callback) {
		El.get(element).addEventListener(
			'select', callback
		)
	},

	change (element, callback) {
		El.get(element).addEventListener(
			'change', callback
		)
	},

	submit (element, callback) {
		El.get(element).addEventListener(
			'submit', callback
		)
	},

	reset (element, callback) {
		El.get(element).addEventListener(
			'reset', callback
		)
	},

	focus (element, callback) {
		El.get(element).addEventListener(
			'focus', callback
		)
	},

	blur (element, callback) {
		El.get(element).addEventListener(
			'blur', callback
		)
	},

	load (element, callback) {
		El.get(element).addEventListener(
			'load', callback
		)
	},

	unload (element, callback) {
		El.get(element).addEventListener(
			'unload', callback
		)
	},

	beforeunload (element, callback) {
		El.get(element).addEventListener(
			'beforeunload', callback
		)
	},

	resize (element, callback) {
		El.get(element).addEventListener(
			'resize', callback
		)
	},

	error (element, callback) {
		El.get(element).addEventListener(
			'error', callback
		)
	},

	abort (element, callback) {
		El.get(element).addEventListener(
			'abort', callback
		)
	},

	readystatechange (element, callback) {
		El.get(element).addEventListener(
			'readystatechange', callback
		)
	},

	loadstart (element, callback) {
		El.get(element).addEventListener(
			'loadstart', callback
		)
	},

	progress (element, callback) {
		El.get(element).addEventListener(
			'progress', callback
		)
	},

	loadend (element, callback) {
		El.get(element).addEventListener(
			'loadend', callback
		)
	},

	timeout (element, callback) {
		El.get(element).addEventListener(
			'timeout', callback
		)
	},

	loadeddata (element, callback) {
		El.get(element).addEventListener(
			'loadeddata', callback
		)
	},

	loadedmetadata (element, callback) {
		El.get(element).addEventListener(
			'loadedmetadata', callback
		)
	},

	canplay (element, callback) {
		El.get(element).addEventListener(
			'canplay', callback
		)
	},

}