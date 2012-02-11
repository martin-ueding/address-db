<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Helper for date.
 */
class DateFormat {
	/**
	 * Calculates the age for a given birthday.
	 *
	 * @param integer $tag Day.
	 * @param integer $monat Month.
	 * @param integer $jahr Year.
	 * @return integer Age.
	 */
	public static function alter($tag, $monat, $jahr) { // j, n
		$alter = date("Y") - $jahr;
		if ($monat > date("n") || ($monat == date("n") && $tag > date("j")))
			$alter--;
		return $alter;
	}

	/**
	 * Gives a casual, human readable form of the date.
	 *
	 * @global string $date_format
	 * @param integer $stamp Timestamp.
	 * @return string Date string.
	 */
	public static function intelligent_date ($stamp) {
		global $date_format;
		$diff = time() - $stamp;

		// if the date is in the past ...
		if ($diff >= 0) {
			if ($diff < 15)
				return _('just now');
			else if ($diff < 60)
				return _('within in the last minute');
			else if ($diff < 7200)
				return sprintf(_('%d minutes ago'), round($diff/60));
			else if ($diff < 86400)
				return sprintf(_('%d hours ago'), round($diff/3600));
			else if ($stamp == 0)
				return _('never');
			else
				return _('on the').' '.date($date_format, $stamp);
		}
		else {
			return _('in the future ...');
		}
	}
}
?>
