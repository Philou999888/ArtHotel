<?
if($ADMIN["role"] < 1) {
	report("Fehlende Rechte.");
	die(go($GLOBAL["root"]."admin?s=logout"));
}

$bestandsfilter = $_REQUEST["bestandsfilter"];


?>

<h3>Fahrer-Statistiken</h3>

Zeige Statistik von: <br>
<form action="?" method="GET" id="filterform" style="display:inline;">
	<input type="hidden" name="s" value="<?=$s;?>">
	<select name="bestandsfilter" style="width:auto;padding:5px;border:black solid 1px;display:inline;">
		<option value="" onClick="document.getElementById('filterform').submit();"<?if(!$bestandsfilter){?> SELECTED<?}?>>Alle Fahrer</option>
		<?
		$result = $DB->q("SELECT * FROM admins WHERE supervisor = '".$ADMIN["id"]."' OR id = '".$ADMIN["id"]."' ORDER BY nachname");
		while($row = mysqli_fetch_array($result)) {
			?>
			<option value="<?=$row["id"];?>" onClick="document.getElementById('filterform').submit();"<?if($bestandsfilter == $row["id"]){?> SELECTED<?}?>>
				<?=$row["nachname"];?> <?=$row["vorname"];?>					
			</option>
			<?
		}
		?>
	</select>
	<input type="submit" value="OK">
</form>
<br style="clear:both;"><br style="clear:both;">

<?
$start = new DateTime($CONFIG["datum_systemstart"]);
$now = new DateTime();
$dayscount = $now->diff($start)->format("%a");
?>

<table class="umsatztbl">
	<tr>
		<td><b>Datum</b></td>
		<td><b>Erledigt</b></td>
		<td><b>Einnahmen</b></td>
		<td><b>50 %</b></td>
	</tr>

<?
$fahrten_all = 0;
$umsatz_all = 0;
$prov_all = 0;
$storno_all = 0;
$anz_storno_all = 0;
$akquiriert_all = 0;
$anz_akquiriert_all = 0;
$problem_all = 0;
$anz_problem_all = 0;

for($x = 0; $x <= $dayscount; $x++) {
	$current = new DateTime("-$x days");
	$current = $current->format('Y-m-d, D');
	
	$anz = 0;
	$umsatz = 0;
	$storniert = 0;
	$anz_storniert = 0;	
	$problem = 0;
	$anz_problem = 0;

	if($bestandsfilter) {
		$result = $DB->q("SELECT * FROM fahrten WHERE fahrt_datum = '".$current."' AND supervisor = '".$ADMIN["id"]."' AND fahrer = '".$bestandsfilter."' AND deleted = 0");
	}else{
		$result = $DB->q("SELECT * FROM fahrten WHERE fahrt_datum = '".$current."' AND supervisor = '".$ADMIN["id"]."' AND deleted = 0");
	}


	while($row = mysqli_fetch_array($result)) {
		if($row["status"] == 2) {
			$anz += 1;				
			$umsatz += $row["fahrpreis"];				

		}
		elseif($row["status"] == 3) {
			$anz_storniert += 1;
			$storniert += $row["fahrpreis"];		
		}
		elseif($row["status"] == 5) {
			$anz_problem += 1;
			$problem += $row["fahrpreis"];		
		}
	
	}
	
	$fahrten_all += $anz;
	$umsatz_all += $umsatz;
	$storno_all += $storniert;
	$anz_storno_all += $anz_storniert;
	$problem_all += $problem;
	$anz_problem_all += $anz_problem;
	?>
	
	<tr>
		<td><?=$current;?></td>
		<td><?=$anz;?></td>
		<td><?=number_format($umsatz, 2);?> €</td>
		<td><?=number_format($umsatz*0.5, 2);?> €</td>
	</tr>

	<?
}
?>

	<tr>
		<td><b>Gesamt</b></td>
		<td><b><?=$fahrten_all;?></b></td>
		<td><b><?=number_format($umsatz_all, 2);?> €</b></td>
		<td><b><?=number_format($umsatz_all*0.5, 2);?> €</b></td>
	</tr>

</table>

<br style="clear:both;"><br style="clear:both;"><br style="clear:both;">