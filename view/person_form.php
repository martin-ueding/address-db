<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('../helper/SelectHelper.php');
?>

<form action="<?php echo $form_target; ?>" method="post">

<?php if (isset($p_id)): ?>
<input type="hidden" name="p_id" value="<?PHP echo $p_id; ?>" />
<?php endif; ?>

	<h1><?php echo $heading; ?></h1>

	<h2><?PHP echo sprintf(_('part %d of %d'), 1, 3).' &ndash; '._('names and relations'); ?></h2>

<table>
	<tr><th colspan="2"><?PHP echo _('name'); ?>:</th></tr>
	<tr>
		<td><?PHP echo _('form of address'); ?>:</td>
		<td><?PHP SelectHelper::show_select_anrede('anrede_r', (isset($person_loop['anrede_r']) ? $person_loop['anrede_r'] : null)); SelectHelper::show_select_prafix('prafix_r', (isset($person_loop['prafix_r']) ? $person_loop['prafix_r'] : null)); ?></td>
	</tr>
	<tr>
		<td><?PHP echo _('first name'); ?>:</td>
		<td><?PHP echo '<input type="text" name="vorname" value="'.(isset($person_loop['vorname']) ? $person_loop['vorname'] : null).'" size="30" maxlength="100" />'; ?></td>
	</tr>
	<tr>
		<td><?PHP echo _('middle name'); ?>:</td>
		<td><?PHP echo '<input type="text" name="mittelname" value="'.(isset($person_loop['mittelname']) ? $person_loop['mittelname'] : null).'" size="30" maxlength="100" />'; ?></td>
	</tr>
	<tr>
		<td><?PHP echo _('last name'); ?>:</td>
		<td><?PHP echo '<input type="text" name="nachname" value="'.(isset($person_loop['nachname']) ? $person_loop['nachname'] : null).'" size="30" maxlength="100" />'; ?></td>
	</tr>
	<tr>
		<td><?PHP echo _('suffix'); ?>:</td>
		<td><?PHP SelectHelper::show_select_suffix('suffix_r', (isset($person_loop['suffix_r']) ? $person_loop['suffix_r'] : null)); ?></td>
	</tr>
	<tr>
		<td><?PHP echo _('maiden name'); ?>:</td>
		<td><?PHP echo '<input type="text" name="geburtsname" value="'.(isset($person_loop['geburtsname']) ? $person_loop['geburtsname'] : null).'" size="30" maxlength="100" />'; ?></td>
	</tr>
	<tr>
		<td><?PHP echo _('birth date'); ?>:</td>
		<td><?PHP
		SelectHelper::show_select_zahlen('geb_t', (isset($person_loop['geb_t']) ? $person_loop['geb_t'] : null), 1, 31, true);
SelectHelper::show_select_zahlen('geb_m', (isset($person_loop['geb_m']) ? $person_loop['geb_m'] : null), 1, 12, true);
SelectHelper::show_select_zahlen('geb_j', (isset($person_loop['geb_j']) ? $person_loop['geb_j'] : null), date("Y")-100, date("Y"), false);
		?></td>
	</tr>
</table>
<br><br>
<h3><?PHP echo _('relations'); ?>:</h3>

<?PHP
	/* Beziehungen zu den Familienmitgliedern */
	$erg = Queries::select_alle_fmg();
echo '<div class="box_596">';
	echo _('Who knows this person?').'<br /><br />';
	while ($l = mysql_fetch_assoc($erg))
		{
		echo '<div class="input_block">';
		echo '<input type="checkbox" name="fmgs[]" value="'.$l['fmg_id'].'" id="fmg'.$l['fmg_id'].'"';
		if (!empty($checked_fmgs) && in_array($l['fmg_id'], $checked_fmgs))
			echo ' checked';
		 echo ' /> <label for="fmg'.$l['fmg_id'].'">'.$l['fmg']."</label>\n";
		 echo '</div>';
		}
echo '</div>';
echo '<div class="box_596">';
	echo '<br /><br />';
	/* Gruppen */
	$erg = Queries::select_alle_gruppen();
	echo _('In which groups is this person?').'<br><br />';
	while ($l = mysql_fetch_assoc($erg))
		{
		echo '<div class="input_block">';
		echo '<input type="checkbox" name="gruppen[]" value="'.$l['g_id'].'" id="g'.$l['g_id'].'"';
		if (!empty($checked_groups) && in_array($l['g_id'], $checked_groups))
			echo ' checked';
		 echo ' /> <label for="g'.$l['g_id'].'">'.$l['gruppe']."</label>\n";
		 echo '</div>';
		}
echo '</div>';
	echo '&nbsp;<br style="clear: left;" /><br /><input class="rand" type="text" name="neue_gruppe" size="30" maxlength="100" /> '._('create new group');
	?>
	
	
	<h2><?PHP echo sprintf(_('part %d of %d'), 2, 3).' &ndash; '._('address'); ?></h2>
	
	<?PHP
	if (isset($person_loop['adresse_r'])) {
		if (Queries::adresse_mehrfach_benutzt($person_loop['adresse_r'])) {
			echo '&nbsp;<br /><b>'._('address change affects').':</b> <br /><br />';
			echo '<input type="radio" name="werziehtum" value="einer"';
			if ($werziehtum == 'einer' || $haushalt == 1)
				echo ' checked';
			echo ' /> '._('only this person');

			if ($haushalt != 1) {

				echo '<br />';

				echo '<input type="radio" name="werziehtum" value="alle"';
				if ($werziehtum == 'alle' && $haushalt != 1)
					echo ' checked';
				echo ' /> '._('everybody that lives here');
			}

			echo '<input type="hidden" name="haushalt" value="'.$haushalt.'" />';


			echo '<br /><br />';

		}
	}


	echo '<select size="1" name="adresse_r">';
	$sql = 'SELECT * FROM ad_adressen, ad_plz, ad_orte, ad_laender WHERE plz_r=plz_id && ort_r=o_id && land_r=l_id ORDER BY plz, ortsname, strasse;';
	$erg = mysql_query($sql);

	while ($l = mysql_fetch_assoc($erg)) {
		echo '<option value="'.$l['ad_id'].'"';
		if (((isset($person_loop['adresse_r']) ? $person_loop['adresse_r'] : null) == $l['ad_id']) || (!isset($person_loop['adresse_r']) && $l['ad_id'] == 1))
			echo ' selected';

		echo '>'.$l['plz'].' '.$l['ortsname'].' - '.$l['strasse'].'</option>';
	} 
	echo '</select>';
	
echo '<br /><br />';

	echo '<br /><input type="checkbox" id="adresswahl" name="adresswahl" value="manuell"';
	if (isset($adresswahl) && $adresswahl == 'manuell')
		echo ' checked';

	// TODO use jQuery to do this
	echo ' onClick = "_switch(\'manuelle_eingabe\'); return true;"> '._('or enter a new address').':';

	?>

	<div id="manuelle_eingabe" style="width: 600px; padding: 1px; border: 1px dotted gray; display: <?PHP if($adresswahl == 'manuell'){echo 'block';} else {echo 'none';}?>;">

	<table>
		
	<tr>
		<td><?PHP echo _('street'); ?>:</td>
		<td><?PHP echo '<input type="text" name="strasse" value="'.(isset($person_loop['strasse']) ? $person_loop['strasse'] : null).'" size="30" maxlength="100" />'; ?></td>
	</tr>
	
	<tr>
		<td><?PHP echo _('postral code, city and country'); ?>:</td>
		<td><?PHP
		echo '<div>';
		echo '<input type="text" name="plz" value="" size="5" maxlength="5" class="manual_area_code" />';
		SelectHelper::show_select_plz('plz_r', (isset($person_loop['plz_r']) ? $person_loop['plz_r'] : null));
		echo '</div>';
		echo '<div>';
		echo '<input type="text" name="ort" value="" size="25" maxlength="100" class="manual_area_code" />';
		SelectHelper::show_select_ort('ort_r', (isset($person_loop['ort_r']) ? $person_loop['ort_r'] : null));
		echo '</div>';
		echo '<div>';
		echo '<input type="text" name="land" value="" size="30" maxlength="100" class="manual_area_code" />';
		SelectHelper::show_select_land('land_r', (isset($person_loop['land_r']) ? $person_loop['land_r'] : null));
		echo '</div>';
		?></td>
	</tr>
	
	</table>

	<br /><br />

	<?PHP echo _('general telephones'); ?>:

	<table>
		<tr>
			<td><?PHP echo _('private'); ?>:</td>
			<td class="switchInput"><?PHP SelectHelper::show_telefon_eingabe('privat', true, $person_loop) ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('work'); ?>:</td>
			<td><?PHP SelectHelper::show_telefon_eingabe('arbeit', true, $person_loop) ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('mobile'); ?>:</td>
			<td><?PHP SelectHelper::show_telefon_eingabe('mobil', true, $person_loop) ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('fax'); ?>:</td>
			<td><?PHP SelectHelper::show_telefon_eingabe('fax', true, $person_loop) ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('other'); ?>:</td>
			<td><?PHP SelectHelper::show_telefon_eingabe('aux', true, $person_loop) ?></td>
		</tr>
	</table>
		
	</div>


	
	<br /><br />
		<h2><?PHP echo sprintf(_('part %d of %d'), 3, 3).' &ndash; '._('personal contact information'); ?></h2>

	<table>
		<tr>
			<td><?PHP echo _('email private'); ?>:</td>
			<td><?PHP echo '<input type="text" name="email_privat" value="'.(isset($person_loop['email_privat']) ? $person_loop['email_privat'] : null).'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('email work'); ?>:</td>
			<td><?PHP echo '<input type="text" name="email_arbeit" value="'.(isset($person_loop['email_arbeit']) ? $person_loop['email_arbeit'] : null).'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('email other'); ?>:</td>
			<td><?PHP echo '<input type="text" name="email_aux" value="'.(isset($person_loop['email_aux']) ? $person_loop['email_aux'] : null).'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('homepage 1'); ?>:</td>
			<td>http://<?PHP echo '<input type="text" name="hp1" value="'.(isset($person_loop['hp1']) ? $person_loop['hp1'] : null).'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('homepage 2'); ?>:</td>
			<td>http://<?PHP echo '<input type="text" name="hp2" value="'.(isset($person_loop['hp2']) ? $person_loop['hp2'] : null).'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td><?PHP echo _('private'); ?>:</td>
			<td><?PHP SelectHelper::show_telefon_eingabe('privat', false, $person_loop) ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('work'); ?>:</td>
			<td><?PHP SelectHelper::show_telefon_eingabe('arbeit', false, $person_loop) ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('mobile'); ?>:</td>
			<td><?PHP SelectHelper::show_telefon_eingabe('mobil', false, $person_loop) ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('fax'); ?>:</td>
			<td><?PHP SelectHelper::show_telefon_eingabe('fax', false, $person_loop) ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('other'); ?>:</td>
			<td><?PHP SelectHelper::show_telefon_eingabe('aux', false, $person_loop) ?></td>
		</tr>
		
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td><?PHP echo _('chat AIM'); ?>:</td>
			<td><?PHP echo '<input type="text" name="chat_aim" value="'.(isset($person_loop['chat_aim']) ? $person_loop['chat_aim'] : null).'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('chat MSN'); ?>:</td>
			<td><?PHP echo '<input type="text" name="chat_msn" value="'.(isset($person_loop['chat_msn']) ? $person_loop['chat_msn'] : null).'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('chat ICQ'); ?>:</td>
			<td><?PHP echo '#<input type="text" name="chat_icq" value="'.(isset($person_loop['chat_icq']) ? $person_loop['chat_icq'] : null).'" size="9" maxlength="9" />'; ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('chat Yahoo!'); ?>:</td>
			<td><?PHP echo '<input type="text" name="chat_yim" value="'.(isset($person_loop['chat_yim']) ? $person_loop['chat_yim'] : null).'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('chat Skype'); ?>:</td>
			<td><?PHP echo '<input type="text" name="chat_skype" value="'.(isset($person_loop['chat_skype']) ? $person_loop['chat_skype'] : null).'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('chat Jabber/XMPP'); ?>:</td>
			<td><?PHP echo '<input type="text" name="chat_aux" value="'.(isset($person_loop['chat_aux']) ? $person_loop['chat_aux'] : null).'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr><td colspan="2">&nbsp; </td></tr>
		<tr>
			<td><?PHP echo _('notes'); ?>:</td>
			<td><?PHP echo '<textarea name="pnotizen" rows="4" cols="30">'.(isset($person_loop['pnotizen']) ? $person_loop['pnotizen'] : null).'</textarea>'; ?></td>
		</tr>
	</table>
	
	<br />
	
	<input class="rand" type="submit" name="knopf" value="<?PHP echo _('save'); ?>" />
</form>