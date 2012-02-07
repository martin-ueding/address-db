<?PHP
// Copyright (c) 2011-2012 Martin Ueding <dev@martin-ueding.de>

class SelectHelper {
	public static function show_select_vorwahlen ($name, $aktiv) {
		echo '<select size="1" name="'.$name.'">';

		$erg = Queries::select_alle_vorwahlen();
		while ($l = mysql_fetch_assoc($erg)) {
			if ((empty($aktiv) && $l['v_id'] == 1) || $aktiv == $l['v_id'])
				echo '<option value="'.$l['v_id'].'" selected>';
			else
				echo '<option value="'.$l['v_id'].'">';

			echo $l['vorwahl'].'</option>';
		}

		echo '</select>';
	}

	public static function show_select_anrede ($name, $aktiv) {
		echo '<select size="1" name="'.$name.'">';

		$erg = Queries::select_alle_anreden();
		while ($l = mysql_fetch_assoc($erg)) {
			if ($aktiv == $l['a_id'])
				echo '<option value="'.$l['a_id'].'" selected>';
			else
				echo '<option value="'.$l['a_id'].'">';

			echo _($l['anrede']).'</option>';
		}

		echo '</select>';
	}

	public static function show_select_prafix ($name, $aktiv) {
		echo '<select size="1" name="'.$name.'">';

		$erg = Queries::select_alle_prafixe();
		while ($l = mysql_fetch_assoc($erg)) {
			if ($aktiv == $l['prafix_id'])
				echo '<option value="'.$l['prafix_id'].'" selected>';
			else
				echo '<option value="'.$l['prafix_id'].'">';

			echo $l['prafix'].'</option>';
		}

		echo '</select>';
	}

	public static function show_select_suffix ($name, $aktiv) {
		echo '<select size="1" name="'.$name.'">';

		$erg = Queries::select_alle_suffixe();
		while ($l = mysql_fetch_assoc($erg)) {
			if ($aktiv == $l['s_id'])
				echo '<option value="'.$l['s_id'].'" selected>';
			else
				echo '<option value="'.$l['s_id'].'">';

			echo $l['suffix'].'</option>';
		}

		echo '</select>';
	}

	public static function show_select_plz ($name, $aktiv) {

		echo '<select size="1" name="'.$name.'">';

		$erg = Queries::select_alle_plz();
		while ($l = mysql_fetch_assoc($erg)) {
			if ($aktiv == $l['plz_id'])
				echo '<option value="'.$l['plz_id'].'" selected>';
			else
				echo '<option value="'.$l['plz_id'].'">';

			echo $l['plz'].'</option>';
		}

		echo '</select>';
	}

	public static function show_select_ort ($name, $aktiv) {

		echo '<select size="1" name="'.$name.'">';

		$erg = Queries::select_alle_orte();
		while ($l = mysql_fetch_assoc($erg)) {
			if ($aktiv == $l['o_id'])
				echo '<option value="'.$l['o_id'].'" selected>';
			else
				echo '<option value="'.$l['o_id'].'">';

			echo $l['ortsname'].'</option>';
		}

		echo '</select>';
	}

	public static function show_select_land ($name, $aktiv) {

		echo '<select size="1" name="'.$name.'">';

		$erg = Queries::select_alle_laender();
		while ($l = mysql_fetch_assoc($erg)) {
			if ($aktiv == $l['l_id'])
				echo '<option value="'.$l['l_id'].'" selected>';
			else
				echo '<option value="'.$l['l_id'].'">';

			echo $l['land'].'</option>';
		}

		echo '</select>';
	}

	public static function show_select_zahlen ($name, $aktiv, $start, $ende, $normal) {
		echo '<select size="1" name="'.$name.'">';
		echo '<option value="0">-</option>';

		if ($normal) {
			for ($i = $start; $i <= $ende; $i++) {
				if ($i == $aktiv)
					echo '<option value="'.$i.'" selected>';
				else
					echo '<option value="'.$i.'">';

				echo $i.'</option>';
			}
		}
		else {
			for ($i = $ende; $i > $start; $i--) {
				if ($i == $aktiv)
					echo '<option value="'.$i.'" selected>';
				else
					echo '<option value="'.$i.'">';

				echo $i.'</option>';
			}
		}
		echo '</select>';
	}

	public static function show_telefon_eingabe ($typ, $familie, $loop=null) {
		if ($familie)
			$p = 'f';
		else
			$p = '';
		echo '<nobr>';

		echo '<input type="text" class="manual_area_code" name="'.$p.'vw_'.$typ.'_eingabe" value="'.($loop != null && isset($loop[$p.'vw_'.$typ.'_eingabe']) ? $loop[$p.'vw_'.$typ.'_eingabe'] : "").'" size="5" maxlength="20" />'; 
		SelectHelper::show_select_vorwahlen($p.'vw_'.$typ.'_id', ($loop != null ? $loop[$p.'vw_'.$typ.'_r'] : ""));
		echo '<input type="text" name="'.$p.'tel_'.$typ.'" value="'.($loop != null && isset ($loop[$p.'tel_'.$typ]) ? $loop[$p.'tel_'.$typ] : "").'" size="25" maxlength="100" />';
		echo '</nobr>';
	}
}
?>