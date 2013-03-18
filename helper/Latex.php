<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Helper for generating LaTeX documents.
 */
class Latex {
	public static function convertToLaTeX($s) {
		$s = str_replace('@', '$@$', $s);
		$s = str_replace('_', '\\_', $s);
		$s = str_replace('&', '\\&', $s);
		return $s;
	}

	public static function bruch() {
		return "\n\n\\nopagebreak[4]";
	}
}
