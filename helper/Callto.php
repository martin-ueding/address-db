<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Builds callto:// links.
 */
class Callto {
	/**
	 * Build a link to call with Skype.
	 *
	 * @param string $nummer Telephone number.
	 * @return string HTML link.
	 */
	public static function skplnk($nummer) {
		if ($nummer[0] != "+")
			$nummer = "+49" . substr($nummer, 1, strlen($nummer)-1);

		return '<a href="Callto://'.$nummer.'"><img src="gfx/10/skype10.png" /></a>';
	}
}
?>
