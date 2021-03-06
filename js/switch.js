// Copyright © 2012-2013 Martin Ueding <dev@martin-ueding.de>

$(document).ready(function () {
	// Fold the `manuelle_eingabe` if the checkbox is not set.
	if ($('#adresswahl:checked').val() === undefined) {
		$('#manuelle_eingabe').slideUp(0);
	}

	$('#adresswahl').click(function () {
		$('#manuelle_eingabe').slideToggle(500);
		initSwitchFields();
	});

});

function _switch(object) {
	if (document.getElementById(object).style.display != "block") {
		document.getElementById(object).style.display = "block";
	}
	else {
		document.getElementById(object).style.display = "none";
	}
}
