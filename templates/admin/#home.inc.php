<?
// Anzahl Fahrten
$result = $DB->q("SELECT * FROM fahrten WHERE fahrer = '".$ADMIN["id"]."'");
$fahrten = mysqli_num_rows($result);

// Anzahl erfolgreiche Fahrten
$result = $DB->q("SELECT * FROM fahrten WHERE fahrer = '".$ADMIN["id"]."' AND status = 2");
$erledigt = mysqli_num_rows($result);

// Summe Umsatz
$result = $DB->q("SELECT * FROM fahrten WHERE fahrer = '".$ADMIN["id"]."' AND status != 3 AND status != 5");
$umsatz = 0;
while($row = mysqli_fetch_array($result)) {
	$umsatz += $row["fahrpreis"];
}


$result = $DB->q("SELECT * FROM provisionen WHERE fahrer = '".$ADMIN["id"]."'");
$provisionen = 0;
while($row = mysqli_fetch_array($result)) {
	$provisionen += $row["betrag"];
}

?>


<h3 style="margin-top:0px;">Ihre Statistik</h3>

Sie haben <b><?=$fahrten;?> Fahrten erhalten</b>, wovon bisher <b><?=$erledigt;?> erfolgreich abgeschlossen</b> wurden.
<br><br>

Sie haben insgesamt <b><?=number_format($umsatz, 2);?> € Umsatz</b> erzielt.

<?
if($ADMIN["direktverrechnung"]) {
	?>
	<br><br>
	Davon fallen bisher in Summe <b><?=number_format($provisionen, 2);?> € Provisionen</b> an.
	<?
}
?>
