<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

class Navigation {
	public static function nav_action_link($mode, $active_mode, $text) {
		$class = $mode == $active_mode ? 'class="active"' : '';
		$link = '<li><a href="index.php?mode='.$mode.'" '.$class.'>'.$text.'</a></li>';
		return $link;
	}

	public static function spacer() {
		return '<li>&nbsp;</li>';
	}
}
?>
