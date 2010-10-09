<?PHP
/* .Kalender mit einigen Anzeigen .... */
/* .Variablen uebernehmen. */
if($_POST["kalWoche"]){$kalWoche = $_POST["kalWoche"];}
else {$kalWoche = date("W");}
$woDiffz = ($kalWoche - date("W"));
/* .. */
/* .Den Montag der eingegebenen KalWoche festlegen. */
$monat = (int) date("n");
$tag = (int) date("j");
$jahr = (int) date("Y");
$stamp_1 = mktime(2, 0, 0, $monat, $tag, $jahr); /* .Feste Uhrzeit 2:00 des heutigen Tages. */
/* .. */
$wochenTag = date("w");
if($wochenTag == 0){$wochenTag = 7;} /* .Sonntag/Montag-Wochenanfangs-Prob abfangen. */
$tagDiffz = ($wochenTag-1);
$stamp_2 = ($stamp_1-($tagDiffz*60*60*24)); /* .Feste Uhrzeit 2:00 des vorherigen Montags. */
$stamp_3 = ($stamp_2+($woDiffz*60*60*24*7)); /* .Feste Uhrzeit 2:00 des gefragten Montags. */
/* .. */
/* .Variablen für die Ausgabe-Aufhübschung definieren. */
$WoTag[0] = "Sonntag";
$WoTag[1] = "Montag";
$WoTag[2] = "Dienstag";
$WoTag[3] = "Mittwoch";
$WoTag[4] = "Donnerstag";
$WoTag[5] = "Freitag";
$WoTag[6] = "Samstag";
$aktTag = $WoTag[date("w")];
/* .. */
$Monat[1] = "Januar";
$Monat[2] = "Februar";
$Monat[3] = "März";
$Monat[4] = "April";
$Monat[5] = "Mai";
$Monat[6] = "Juni";
$Monat[7] = "Juli";
$Monat[8] = "August";
$Monat[9] = "September";
$Monat[10] = "Oktober";
$Monat[11] = "November";
$Monat[12] = "Dezember";
$aktMonat = $Monat[date("n")];
/* .. */
$sZeit = "MEZ";
if(date("I") == 1){$sZeit = "MEZ(S)";}
/* .. */
$sJahr = "Nein";
if(date("L") == 1){$sJahr = "Ja";}
?>

<div id="kalender">Heute ist <?PHP echo $aktTag.',  <br>der '.date("d").'. '.$aktMonat.' '.date("Y"); ?></div>