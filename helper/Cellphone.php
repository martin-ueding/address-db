<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Helper for cell phone numbers
 *
 * @package helper
 */
class Cellphone {
	/**
	 * Finds the cell phone carrier to an area code.
	 *
	 * The area code has to be given in the international form, as in +49-171.
	 *
	 * @param string $vw Area code.
	 * @return string Carrier name.
	 */
	public static function handybetreiber($vw) {
		switch ($vw) {
		case '+49-160': case '+49-170': case '+49-171': case '+49-175':
		case '+49-151':
			return '(T-Mobile)';
		case '+49-162': case '+49-172': case '+49-173': case '+49-174':
		case '+49-152':
			return '(Vodafone)';
		case '+49-163': case '+49-177': case '+49-178': case '+49-155':
		case '+49-157':
			return '(E-Plus)';
		case '+49-176': case '+49-179': case '+49-159':
			return '(O2)';
		}
	}
}
?>
