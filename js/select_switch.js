// Copyright © 2011-2012 Martin Ueding <dev@martin-ueding.de>

// Adds a switch button to all input fields that consist of a regular input
// field and a select field.

$(initSwitchFields);

function initSwitchFields() {
	$("input.manual_area_code").hide(0).parent().children("input.manual_area_code").before("<img src=\'gfx/agt_reload.png\' class=\'switch_fields\' />");

	$("img.switch_fields").click(function () {
		if ($(this).parent().children("select").css("display") == "none") {
			$(this).parent().children("input.manual_area_code").hide(100, function() {
				$(this).parent().children("select").show(100);
			}).val("");
		}
		else {
			$(this).parent().children("select").hide(100, function () {
				$(this).parent().children("input.manual_area_code").show(100);
			}).val("1");
		}
	});
}