<h2>Teil 1/3 &ndash; Name und Bez&uuml;ge</h2>

<form action="person_create2.php" method="post">

<table>
<tr><th colspan="2">Name:</th></tr>
<tr>
<td>Anrede:</td>
<td><?PHP show_select_anrede('anrede_r', ""); show_select_prafix('prafix_r', ""); ?></td>
</tr>
<tr>
<td>Vorname:</td>
<td><?PHP echo '<input type="text" name="vorname" size="30" maxlength="100" />'; ?></td>
</tr>
<tr>
<td>2. Vorname:</td>
<td><?PHP echo '<input type="text" name="mittelname" size="30" maxlength="100" />'; ?></td>
</tr>
<tr>
<td>Nachname:</td>
<td><?PHP echo '<input type="text" name="nachname" size="30" maxlength="100" />'; ?></td>
</tr>
<tr>
<td>Suffix:</td>
<td><?PHP show_select_suffix('suffix_r', ""); ?></td>
</tr>
<tr>
<td>Geburtsname:</td>
<td><?PHP echo '<input type="text" name="geburtsname" size="30" maxlength="100" />'; ?></td>
</tr>
<tr>
<td>Geburtsdatum:</td>
<td><?PHP
show_select_zahlen('geb_t', 0, 1, 31, true);
show_select_zahlen('geb_m', 0, 1, 12, true);
show_select_zahlen('geb_j', 0, date("Y")-100, date("Y"), false);
?></td>
</tr>
</table>
<br><br>
<h3>Bez&uuml;ge:</h3>

<?PHP
/* Beziehungen zu den Familienmitgliedern */
$erg = select_alle_fmg();
echo '<div class="box_596">';
	echo 'Wer kennt diese Person?<br /><br />';
	while ($l = mysql_fetch_assoc($erg))
		{
		echo '<div class="input_block">';
		echo '<input type="checkbox" name="fmgs[]" value="'.$l['fmg_id'].'" /> '.$l['fmg']."\n";
		echo '</div>';
		}
echo '</div>';
echo '<div class="box_596">';
	echo '<br /><br />';
	/* Gruppen */
	$erg = select_alle_gruppen();
	echo 'In welchen Gruppen ist die Person?<br><br />';
	while ($l = mysql_fetch_assoc($erg))
		{
		echo '<div class="input_block">';
		echo '<input type="checkbox" name="gruppen[]" value="'.$l['g_id'].'" /> '.$l['gruppe']."\n";
		echo '</div>';
		}
echo '</div>';
	echo '&nbsp;<br style="clear: left;" /><br /><input class="rand" type="text" name="neue_gruppe" size="30" maxlength="100" /> Neue Gruppe anlegen';
	?>
<br /><br />

<h2>Teil 2/3 &ndash; Adresse</h2>

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
	echo ' onClick = "_switch(\'manuelle_eingabe\'); return true;"> Oder neue Adresse anlegen:';

	?>

	<div id="manuelle_eingabe" style="width: 600px; padding: 1px; border: 1px dotted gray; display: none">

	<table>
		
	<tr>
		<td>Strasse:</td>
		<td><?PHP echo '<input type="text" name="strasse" size="30" maxlength="100" />'; ?></td>
	</tr>
	
	<tr>
		<td>PLZ, Ort, Land:</td>
		<td><?PHP show_select_plz('plz_r', 0); show_select_ort('ort_r', 0); show_select_land('land_r', 0); ?></td>
	</tr>
	
	<tr>
		<td></td>
		<td><?PHP echo '<input type="text" name="plz" size="5" maxlength="5" />';  echo '<input type="text" name="ort" size="25" maxlength="100" />'; echo '<input type="text" name="land" size="30" maxlength="100" />'; ?></td>
	</tr>
				
	</table>

	<br /><br />

	Allgemeine Telefone:

	<table>
		<tr>
			<td>Privat:</td>
			<td><?PHP show_telefon_eingabe('privat', true) ?></td>
		</tr>
		<tr>
			<td>Arbeit:</td>
			<td><?PHP show_telefon_eingabe('arbeit', true) ?></td>
		</tr>
		<tr>
			<td>Mobil:</td>
			<td><?PHP show_telefon_eingabe('mobil', true) ?></td>
		</tr>
		<tr>
			<td>Fax:</td>
			<td><?PHP show_telefon_eingabe('fax', true) ?></td>
		</tr>
		<tr>
			<td>Aux:</td>
			<td><?PHP show_telefon_eingabe('aux', true) ?></td>
		</tr>
	</table>
		
	</div>
	<h2>Teil 3/3 &ndash; Pers&ouml;nliche Kontaktdaten</h2>

	<table>
		<tr>
			<td>Email privat:</td>
			<td><?PHP echo '<input type="text" name="email_privat" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Email Arbeit:</td>
			<td><?PHP echo '<input type="text" name="email_arbeit" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Email Sonstiges:</td>
			<td><?PHP echo '<input type="text" name="email_aux" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Homepage 1:</td>
			<td>http://<?PHP echo '<input type="text" name="hp1" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Homepage 2:</td>
			<td>http://<?PHP echo '<input type="text" name="hp2" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td>Privat:</td>
			<td><?PHP show_telefon_eingabe('privat', false) ?></td>
		</tr>
		<tr>
			<td>Arbeit:</td>
			<td><?PHP show_telefon_eingabe('arbeit', false) ?></td>
		</tr>
		<tr>
			<td>Mobil:</td>
			<td><?PHP show_telefon_eingabe('mobil', false) ?></td>
		</tr>
		<tr>
			<td>Fax:</td>
			<td><?PHP show_telefon_eingabe('fax', false) ?></td>
		</tr>
		<tr>
			<td>Aux:</td>
			<td><?PHP show_telefon_eingabe('aux', false) ?></td>
		</tr>
		
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td>Chat AIM:</td>
			<td><?PHP echo '<input type="text" name="chat_aim" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Chat MSN:</td>
			<td><?PHP echo '<input type="text" name="chat_msn" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Chat ICQ:</td>
			<td><?PHP echo '#<input type="text" name="chat_icq" size="9" maxlength="9" />'; ?></td>
		</tr>
		<tr>
			<td>Chat Yahoo:</td>
			<td><?PHP echo '<input type="text" name="chat_yim" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Chat Skype:</td>
			<td><?PHP echo '<input type="text" name="chat_skype" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Chat Sonstiges:</td>
			<td><?PHP echo '<input type="text" name="chat_aux" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr><td colspan="2">&nbsp; </td></tr>
		<tr>
			<td>Notizen:</td>
			<td><?PHP echo '<textarea name="pnotizen" rows="4" cols="30"></textarea>'; ?></td>
		</tr>
	</table>

<br /><br />
	
<input class="rand" type="submit" name="knopf" value="Speichern" /><br>&nbsp;
</form>
