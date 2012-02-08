<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

class DateFormat {
	public static function alter($tag, $monat, $jahr) { // j, n
		$alter = date("Y") - $jahr;
		if ($monat > date("n") || ($monat == date("n") && $tag > date("j")))
			$alter--;
		return $alter;
	}

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
				return printf(_('%d minutes ago'), round($diff/60));
			else if ($diff < 86400)
				return printf(_('%d hours ago'), round($diff/3600));
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