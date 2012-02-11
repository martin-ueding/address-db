<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Helper for zodiac signs.
 */
class ZodiacSign {
	/**
	 * Finds the zodiac sign to a given date.
	 *
	 * @param integer $tag Day.
	 * @param integer $monat Month.
	 * @return string Zodiac sign.
	 */
	public static function sternzeichen($tag, $monat) {
		$tagimmonat = date('z', mktime(0, 0, 0, $monat, $tag, 2001));

		if (0 <= $tagimmonat && $tagimmonat <
			date('z', mktime(0, 0, 0, 1, 21, 2001)))
			return _('Capricorn');

		if (date('z', mktime(0, 0, 0, 1, 21, 2001)) <= $tagimmonat &&
			$tagimmonat < date('z', mktime(0, 0, 0, 2, 20, 2001)))
			return _('Aquarius');

		if (date('z', mktime(0, 0, 0, 2, 20, 2001)) <= $tagimmonat &&
			$tagimmonat < date('z', mktime(0, 0, 0, 3, 20, 2001)))
			return _('Pisces');

		if (date('z', mktime(0, 0, 0, 3, 20, 2001)) <= $tagimmonat &&
			$tagimmonat < date('z', mktime(0, 0, 0, 4, 21, 2001)))
			return _('Aries');

		if (date('z', mktime(0, 0, 0, 4, 21, 2001)) <= $tagimmonat &&
			$tagimmonat < date('z', mktime(0, 0, 0, 5, 21, 2001)))
			return _('Taurus');

		if (date('z', mktime(0, 0, 0, 5, 21, 2001)) <= $tagimmonat &&
			$tagimmonat < date('z', mktime(0, 0, 0, 6, 22, 2001)))
			return _('Gemini');

		if (date('z', mktime(0, 0, 0, 6, 22, 2001)) <= $tagimmonat &&
			$tagimmonat < date('z', mktime(0, 0, 0, 7, 23, 2001)))
			return _('Cancer');

		if (date('z', mktime(0, 0, 0, 7, 23, 2001)) <= $tagimmonat &&
			$tagimmonat < date('z', mktime(0, 0, 0, 8, 24, 2001)))
			return _('Leo');

		if (date('z', mktime(0, 0, 0, 8, 24, 2001)) <= $tagimmonat &&
			$tagimmonat < date('z', mktime(0, 0, 0, 9, 24, 2001)))
			return _('Virgo');

		if (date('z', mktime(0, 0, 0, 9, 24, 2001)) <= $tagimmonat &&
			$tagimmonat < date('z', mktime(0, 0, 0, 10, 24, 2001)))
			return _('Libra');

		if (date('z', mktime(0, 0, 0, 10, 24, 2001)) <= $tagimmonat &&
			$tagimmonat < date('z', mktime(0, 0, 0, 11, 23, 2001)))
			return _('Scorpio');

		if (date('z', mktime(0, 0, 0, 11, 23, 2001)) <= $tagimmonat &&
			$tagimmonat < date('z', mktime(0, 0, 0, 12, 22, 2001)))
			return _('Sagittarius');

		if (date('z', mktime(0, 0, 0, 12, 22, 2001)) <= $tagimmonat &&
			$tagimmonat < date('z', mktime(0, 0, 0, 12, 31, 2001)))
			return _('Capricorn');
	}
}
?>
