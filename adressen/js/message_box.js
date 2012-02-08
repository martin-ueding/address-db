// Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

// Fadeout messages box.
$(document).ready(function() {
	$("#messages").fadeOut(0).fadeIn(500).click(function () {
		$(this).slideUp(1000);
	})
});
