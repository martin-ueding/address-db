<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

class Missing {
	public function __construct($filter, $from_with_get) {
		$sql = 'SELECT * FROM ad_per '.$filter->join().' WHERE '.$filter->where().' ORDER BY nachname, vorname;';
		$erg = mysql_query($sql);
		$i = 0;
		while ($l = mysql_fetch_assoc($erg)) {
			# TODO Use CSS for zebra.
			$this->daten[] = '<tr class="'.($i++ % 2 == 0 ? 'hell' : 'dunkel').'"><td><a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($from_with_get).'">&raquo;</a></td><td><a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($from_with_get).'">'.$l['vorname'].'</a></td><td><a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($from_with_get).'">'.$l['nachname'].'</a></td></tr>';
		}
	}

	public function html() {
		ob_start();


		/* Daten anzeigen */

		if (isset($this->daten) && count($this->daten) > 0) {
			echo '<table id="liste">';

			foreach($this->daten as $zeile)
				echo $zeile;	

			echo '</table>';
		}

		else
			echo _('nothing found');

		return ob_get_clean();
	}
}

?>
