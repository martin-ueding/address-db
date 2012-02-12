<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Session flash messages.
 *
 * @global array $_SESSION['messages']
 */

if (isset($_SESSION['messages']) && count($_SESSION['messages']) > 0) {
	echo '<div id="messages">';
	echo '<ul>';
	while (count($_SESSION['messages']) > 0) {
		echo '<li>'.array_pop($_SESSION['messages']).'</li>';
	}
	echo '</ul>';
	echo '</div>';
}
?>
