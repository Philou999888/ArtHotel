<?
if($ADMIN["role"] < 1) {
	report("Fehlende Rechte.");
	die(go($GLOBAL["root"]."de/admin?s=logout"));
}

$bestandsfilter = $_REQUEST["bestandsfilter"];
$tag = $_REQUEST["tag"];
?>

<h3>Supervisor-Abrechnung</h3>


<?
if($a == "einzelnachweise") {
	?>
	
	<br>
	<b>Detail Abrechnung von <?=$tag;?>:</b>
	<br><br>
	
	<table class="umsatztbl">
	<tr>
		<td><b>Zeitpunkt</b></td>
		<td><b>Fahrer</b></td>
		<td><b>Fahrt-ID</b></td>
		<td><b>Provision</b></td>
		<td><b>Grundlage</b></td>
	</tr>

	<?
	$sum = 0;
	
	$result = $DB->q("SELECT * FROM provisionen WHERE supervisor = '".$ADMIN["id"]."' AND date(zeitpunkt) = '".$tag."'");
	while($row = mysqli_fetch_array($result)) {
		$FAHRER = GetAdminById($row["fahrer"]);
		$sum += $row["betrag"];
		?>
		<tr>
			<td><?=$row["zeitpunkt"];?></td>
			<td><?if($row["fahrer"]){?> <?=$FAHRER["vorname"];?> <?=$FAHRER["nachname"];?> <?}else{?> - <?}?></td>
			<td><?if($row["fahrt"]){?> <?=$row["fahrt"];?> <?}else{?> - <?}?></td>
			<td><?=number_format($row["betrag"], 2);?> €</td>
			<td><small><?=$row["grundlage"];?></small></td>
		</tr>
		<?
	}	
	?>
	
		<tr>
			<td colspan="3"><b>Gesamt am <?=$tag;?></b></td>
			<td><b><?=$sum;?></b></td>
			<td>&nbsp;</td>
		</tr>
	
	</table>
	<br>
	
	<a href="?s=<?=$s;?>">&lArr; Zurück</a>
	
	<?
}else{
	?>


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
			<td><b>Provision</b></td>
			<td><b>Details</b></td>
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
		$curr_x = $current->format('Y-m-d');
		$current = $current->format('Y-m-d, D');
		
		$anz = 0;
		$umsatz = 0;
		$prov = 0;
		$storniert = 0;
		$anz_storniert = 0;	
		$problem = 0;
		$anz_problem = 0;

		if($bestandsfilter) {
			$result = $DB->q("SELECT * FROM fahrten WHERE fahrt_datum = '".$current."' AND supervisor = '".$ADMIN["id"]."' AND deleted = 0");
		}else{
			$result = $DB->q("SELECT * FROM fahrten WHERE fahrt_datum = '".$current."' AND supervisor = '".$ADMIN["id"]."' AND deleted = 0");
		}


		while($row = mysqli_fetch_array($result)) {
			if($row["status"] == 2) {
				$anz += 1;				
				$umsatz += $row["fahrpreis"];				

				$result2 = $DB->q("SELECT * FROM provisionen WHERE fahrt = '".$row["id"]."'");
				$THIS = mysqli_fetch_array($result2);			
				$prov += $THIS["betrag"];
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
		$prov_all += $prov;
		$storno_all += $storniert;
		$anz_storno_all += $anz_storniert;
		$problem_all += $problem;
		$anz_problem_all += $anz_problem;
		?>	
		<tr>
			<td><?=$current;?></td>
			<td><?=$anz;?></td>
			<td><?=number_format($umsatz, 2);?> €</td>
			<td><?=number_format($prov, 2);?> €</td>
			<td><a href="?s=<?=$s;?>&a=einzelnachweise&tag=<?=$curr_x;?>">&rArr; Protokoll</a></td>		
		</tr>
		<?
	}
	?>
		<tr>
			<td><b>Gesamt</b></td>
			<td><b><?=$fahrten_all;?></b></td>
			<td><b><?=number_format($umsatz_all, 2);?> €</b></td>
			<td><b><?=number_format($prov_all, 2);?> €</b></td>
			<td>-</td>
		</tr>
	</table>
	<?
}
?>




<br style="clear:both;"><br style="clear:both;"><br style="clear:both;">