<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Pretty prints a person query result.
 */
class Table {
	/**
	 * Create a new table out of a database result.
	 *
	 * @param mixed $erg MySQL database result.
	 */
	public function __construct($erg) {
		$this->erg = $erg;
	}

	/**
	 * Render HTML.
	 *
	 * @return HTML.
	 */
	public function html() {
		ob_start();

		echo '<table class="liste" cellpadding="0" cellspacing="0">';

		while ($l = mysql_fetch_assoc($this->erg)) {
			echo '<tr>';

			echo '<td>';
			echo '<a href="?mode=Person::view&id='.$l['p_id'].'">&raquo;</a>';
			echo '</td>';

			echo '<td align="right">';
			echo '<a href="?mode=Person::view&id='.$l['p_id'].'">'.
				$l['vorname'].'</a>';
			echo '</td>';

			echo '<td>';
			echo '<a href="?mode=Person::view&id='.$l['p_id'].'">'.
				$l['nachname'].'</a>';
			echo '</td>';

			echo '</tr>';
		}

		echo '</table>';

		return ob_get_clean();
	}
}
