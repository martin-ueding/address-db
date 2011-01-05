<h2><?PHP echo _('part 1 of 3 &ndash; names and relations'); ?></h2>

<form action="person_create2.php" method="post">

<table>
<tr><th colspan="2"><?PHP echo _('name'); ?>:</th></tr>
<tr>
<td>Anrede:</td>
<td><?PHP show_select_anrede('anrede_r', ""); show_select_prafix('prafix_r', ""); ?></td>
</tr>
<tr>
<td><?PHP echo _('first name'); ?>:</td>
<td><?PHP echo '<input type="text" name="vorname" size="30" maxlength="100" />'; ?></td>
</tr>
<tr>
<td><?PHP echo _('middle name'); ?>:</td>
<td><?PHP echo '<input type="text" name="mittelname" size="30" maxlength="100" />'; ?></td>
</tr>
<tr>
<td><?PHP echo _('last name'); ?>:</td>
<td><?PHP echo '<input type="text" name="nachname" size="30" maxlength="100" />'; ?></td>
</tr>
<tr>
<td><?PHP echo _('suffix'); ?>:</td>
<td><?PHP show_select_suffix('suffix_r', ""); ?></td>
</tr>
<tr>
<td><?PHP echo _('maiden name'); ?>:</td>
<td><?PHP echo '<input type="text" name="geburtsname" size="30" maxlength="100" />'; ?></td>
</tr>
<tr>
<td><?PHP echo _('birth date'); ?>:</td>
<td><?PHP
show_select_zahlen('geb_t', 0, 1, 31, true);
show_select_zahlen('geb_m', 0, 1, 12, true);
show_select_zahlen('geb_j', 0, date("Y")-100, date("Y"), false);
?></td>
</tr>
</table>
<br><br>
<h3><?PHP echo _('relations'); ?>:</h3>

<?PHP
/* Beziehungen zu den Familienmitgliedern */
$erg = select_alle_fmg();
echo '<div class="box_596">';
	echo  _('Who knows this person?').'<br /><br />';
	while ($l = mysql_fetch_assoc($erg))
		{
		echo '<div class="input_block">';
		echo '<input type="checkbox" name="fmgs[]" value="'.$l['fmg_id'].'" id="fmg'.$l['fmg_id'].'" /> <label for="fmg'.$l['fmg_id'].'">'.$l['fmg']."</label>\n";
		echo '</div>';
		}
echo '</div>';
echo '<div class="box_596">';
	echo '<br /><br />';
	/* Gruppen */
	$erg = select_alle_gruppen();
	echo _('In which groups is this person?').'<br><br />';
	while ($l = mysql_fetch_assoc($erg))
		{
		echo '<div class="input_block">';
		echo '<input type="checkbox" name="gruppen[]" value="'.$l['g_id'].'" id="g'.$l['g_id'].'" /> <label for="g'.$l['g_id'].'">'.$l['gruppe']."</label>\n";
		echo '</div>';
		}
echo '</div>';
	echo '&nbsp;<br style="clear: left;" /><br /><input class="rand" type="text" name="neue_gruppe" size="30" maxlength="100" /> '._('create new group');
	?>
<br /><br />

<h2><?PHP echo _('part 2 of 3 &ndash; address'); ?></h2>

<?PHP

	echo '<select size="5" name="adresse_r">';
	$sql = 'SELECT * FROM ad_adressen, ad_plz, ad_orte, ad_laender WHERE plz_r=plz_id && ort_r=o_id && land_r=l_id ORDER BY plz, ortsname, strasse;';
	$erg = mysql_query($sql);

	while ($l = mysql_fetch_assoc($erg)) {
		echo '<option value="'.$l['ad_id'].'">'.$l['plz'].' '.$l['ortsname'].' - '.$l['strasse'].'</option>';
	} 
	echo '</select>';
	
	echo '<br /><br />';

	echo '<br /><input type="checkbox" id="adresswahl" name="adresswahl" value="manuell"';
	echo ' onClick = "_switch(\'manuelle_eingabe\'); return true;"> '._('or enter a new address').':';

	?>

	<div id="manuelle_eingabe" style="width: 600px; padding: 1px; border: 1px dotted gray; display: none">

	<table>
		
	<tr>
		<td><?PHP echo _('street'); ?>:</td>
		<td><?PHP echo '<input type="text" name="strasse" size="30" maxlength="100" />'; ?></td>
	</tr>
	
	<tr>
		<td><?PHP echo _('postral code, city and country'); ?>:</td>
		<td><?PHP show_select_plz('plz_r', 0); show_select_ort('ort_r', 0); show_select_land('land_r', 0); ?></td>
	</tr>
	
	<tr>
		<td></td>
		<td><?PHP echo '<input type="text" name="plz" size="5" maxlength="5" />';  echo '<input type="text" name="ort" size="25" maxlength="100" />'; echo '<input type="text" name="land" size="30" maxlength="100" />'; ?></td>
	</tr>
				
	</table>

	<br /><br />

	<?PHP echo _('general telephones'); ?>:

	<table>
		<tr>
			<td><?PHP echo _('private'); ?>:</td>
			<td><?PHP show_telefon_eingabe('privat', true) ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('work'); ?>:</td>
			<td><?PHP show_telefon_eingabe('arbeit', true) ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('work'); ?>:</td>
			<td><?PHP show_telefon_eingabe('mobil', true) ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('fax'); ?>:</td>
			<td><?PHP show_telefon_eingabe('fax', true) ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('aux'); ?>:</td>
			<td><?PHP show_telefon_eingabe('aux', true) ?></td>
		</tr>
	</table>
		
	</div>
	<h2><?PHP echo _('part 3 of 3 &ndash; personal contact information'); ?></h2>

	<table>
		<tr>
			<td><?PHP echo _('email private'); ?>:</td>
			<td><?PHP echo '<input type="text" name="email_privat" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('email work'); ?>:</td>
			<td><?PHP echo '<input type="text" name="email_arbeit" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('email other'); ?>:</td>
			<td><?PHP echo '<input type="text" name="email_aux" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('homepage 1'); ?>:</td>
			<td>http://<?PHP echo '<input type="text" name="hp1" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('homepage 2'); ?>:</td>
			<td>http://<?PHP echo '<input type="text" name="hp2" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td><?PHP echo _('private'); ?>:</td>
			<td><?PHP show_telefon_eingabe('privat', false) ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('work'); ?>:</td>
			<td><?PHP show_telefon_eingabe('arbeit', false) ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('mobile'); ?>:</td>
			<td><?PHP show_telefon_eingabe('mobil', false) ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('fax'); ?>:</td>
			<td><?PHP show_telefon_eingabe('fax', false) ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('aux'); ?>:</td>
			<td><?PHP show_telefon_eingabe('aux', false) ?></td>
		</tr>
		
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td><?PHP echo _('Chat AIM'); ?>:</td>
			<td><?PHP echo '<input type="text" name="chat_aim" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('Chat MSN'); ?>:</td>
			<td><?PHP echo '<input type="text" name="chat_msn" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('Chat ICQ'); ?>:</td>
			<td><?PHP echo '#<input type="text" name="chat_icq" size="9" maxlength="9" />'; ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('Chat Yahoo!'); ?>:</td>
			<td><?PHP echo '<input type="text" name="chat_yim" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('Chat Skype'); ?>:</td>
			<td><?PHP echo '<input type="text" name="chat_skype" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td><?PHP echo _('Chat Jabber/XMPP'); ?>:</td>
			<td><?PHP echo '<input type="text" name="chat_aux" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr><td colspan="2">&nbsp; </td></tr>
		<tr>
			<td><?PHP echo _('notes'); ?>:</td>
			<td><?PHP echo '<textarea name="pnotizen" rows="4" cols="30"></textarea>'; ?></td>
		</tr>
	</table>

<br /><br />
	
<input class="rand" type="submit" name="knopf" value="<?PHP echo _('save'); ?>" /><br />&nbsp;
</form>
