<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Helper for navigation links.
 *
 * @package helper
 */
class Navigation {
	/**
	 * Creates a link in the navigation.
	 *
	 * @param string $mode The mode this link points to.
	 * @param string $active_mode The currently active mode.
	 * @param string $text Link test.
	 * @return string HTML.
	 */
	public static function nav_action_link($mode, $active_mode, $text) {
		$class = $mode == $active_mode ? 'class="active"' : '';
		$link = '<li><a href="index.php?mode='.$mode.'" '.$class.'>'.$text.'</a></li>';
		return $link;
	}

	/**
	 * Creates a spacer item.
	 *
	 * @return string HTML.
	 */
	public static function spacer() {
		return '<li>&nbsp;</li>';
	}
}
?>
