// Copyright © 2011-2013 Martin Ueding <dev@martin-ueding.de>

// Adds a switch button to all input fields that consist of a regular input
// field and a select field.

var plz_status = "block";
var city_status = "block";
var country_status = "block";

function showInput(that) {
	$(that).parent().children("select").hide(100, function () {
		$(that).parent().children("input.manual_area_code").show(100);
	}).val("1");
}

function showSelect(that) {
	$(that).parent().children("input.manual_area_code").hide(100, function() {
		$(that).parent().children("select").show(100);
	}).val("");
}

function addSwitchButton() {
	$("input.manual_area_code").parent().children("input.manual_area_code").before("<img src=\'gfx/agt_reload.png\' class=\'switch_fields\' />");
}

function initSwitchFields() {
	$("input.manual_area_code").each(function (i) {
		item = $(this);
		if (item.val() == "") {
			showSelect(item);
		}
		else {
			showInput(item);
		}
	});
}

function addSwitchHandler() {
	$("img.switch_fields").click(function () {
		if ($(this).parent().children("select").css("display") == "none") {
			showSelect(this);
		}
		else {
			showInput(this);
		}
	});
}

$(addSwitchButton);
$(initSwitchFields);
$(addSwitchHandler);
