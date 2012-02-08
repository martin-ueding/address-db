// Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

function _switch(object) {
	if (document.getElementById(object).style.display != "block") {
		document.getElementById(object).style.display = "block";
	}
	else {
		document.getElementById(object).style.display = "none";
	}
}
