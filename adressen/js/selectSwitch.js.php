<?php
// Copyright © 2011 Martin Ueding <dev@martin-ueding.de>

// adds a switch button to all input fields that consist of a regular input field and a select field

include('../../inc/setup_gettext.inc.php');

echo '$(initSwitchFields);';

echo 'function initSwitchFields() {';
	echo '$("input.manual_area_code").hide(0).parent().children("input.manual_area_code").before("<img src=\'gfx/agt_reload.png\' class=\'switch_fields\' title=\''._('switch between a select and a manual input').'\' />");';

	echo '$("img.switch_fields").click(function () {';
		echo 'if ($(this).parent().children("select").css("display") == "none") {';
			echo '$(this).parent().children("input.manual_area_code").hide(100, function() {$(this).parent().children("select").show(100);}).val("");';


		echo '}';
		echo 'else {';
			echo '$(this).parent().children("select").hide(100, function () {$(this).parent().children("input.manual_area_code").show(100);}).val("1");';

		echo '}';
		echo '});';
echo '}';
?>

