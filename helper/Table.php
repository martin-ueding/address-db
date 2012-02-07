<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

class Table {
	public function __construct($erg, $from_with_get) {
		$this->erg = $erg;
		$this->from_with_get = $from_with_get;
	}

	public function html() {
		ob_start();

		echo '<table class="liste" cellpadding="0" cellspacing="0">';

		while ($l = mysql_fetch_assoc($this->erg)) {
			echo '<tr>';

			echo '<td>';
			echo '<a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($this->from_with_get).'">&raquo;</a>';
			echo '</td>';

			echo '<td align="right">';
			echo '<a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($this->from_with_get).'">'.$l['vorname'].'</a>';
			echo '</td>';

			echo '<td>';
			echo '<a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($this->from_with_get).'">'.$l['nachname'].'</a>';
			echo '</td>';

			echo '</tr>';
		}

		echo '</table>';

		return ob_get_clean();
	}
}
