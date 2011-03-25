// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

// adds a switch button to all input fields that consist of a regular input field and a select field

$(initSwitchFields);

function initSwitchFields() {
	$("input.manual_area_code").hide(1000).parent().children("input.manual_area_code").before("<img src='gfx/agt_reload.png' class='switch_fields' title='switch between a select and a manual input' />");

	$("img.switch_fields").click(function () {
		if ($(this).parent().children("select").css("display") == "none") {
			$(this).parent().children("input.manual_area_code").hide().val("");
			$(this).parent().children("select").show();
			
		}
		else {
			$(this).parent().children("input.manual_area_code").show();
			$(this).parent().children("select").hide();
		}
		});
}

