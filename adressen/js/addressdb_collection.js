function _switch(object) {
	if (document.getElementById(object).style.display == "none") {
		document.getElementById(object).style.display = "block";
	}
	else {
		document.getElementById(object).style.display = "none";
	}
}

function flipMenu(what, how) {
   document.getElementById(what).style.display = how;

   if (what != "suchbox") {
	   document.getElementById("suchbox").style.display = "none";
   }
}	   
