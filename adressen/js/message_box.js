// Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

// Fadeout messages box.
$(document).ready(function() {
	$("#messages").fadeOut(0).fadeIn(500).delay('.(5000*count($msgs)).').slideUp(1000);
});
