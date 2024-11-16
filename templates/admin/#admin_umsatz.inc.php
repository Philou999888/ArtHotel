<h3>Tageslosungen</h3>

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
		<td style="color:#848484;"><b>Stornos</b></td>
		<td style="color:#642EFE;"><b>Problem</b></td>
		<td style="color:#A5D995;"><b>Akquiriert</b></td>
		<td style="color:#A5D995;"><b>FPE</b></td>
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
$fpe_all = 0;

for($x = 0; $x <= $dayscount; $x++) {
	$current = new DateTime("-$x days");
	$current = $current->format('Y-m-d, D');
	
	$anz = 0;
	$umsatz = 0;
	$prov = 0;
	$storniert = 0;
	$anz_storniert = 0;	
	$akquiriert = 0;
	$anz_akquiriert = 0;
	$problem = 0;
	$anz_problem = 0;
	$fpe = 0;
	
	$result = $DB->q("SELECT * FROM fahrten WHERE fahrt_datum = '".$current."'");
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
	
	$result = $DB->q("SELECT * FROM fahrten WHERE date(erstellt) = '".$current."'");
	$anz_akquiriert = mysqli_num_rows($result);
	while($row = mysqli_fetch_array($result)) {
		$akquiriert += $row["fahrpreis"];
		$fpe += $row["fahrpreis"]*0.8*0.3;
	}		
	
	$fahrten_all += $anz;
	$umsatz_all += $umsatz;
	$prov_all += $prov;
	$storno_all += $storniert;
	$anz_storno_all += $anz_storniert;
	$akquiriert_all += $akquiriert;
	$anz_akquiriert_all += $anz_akquiriert;
	$problem_all += $problem;
	$anz_problem_all += $anz_problem;
	$fpe_all += $fpe;
	?>
	
	<tr>
		<td><?=$current;?></td>
		<td><?=$anz;?></td>
		<td><?=number_format($umsatz, 2);?> €</td>
		<td><?=number_format($prov, 2);?> €</td>
		<td style="color:#848484;"><i><?=number_format($storniert, 2);?> € (<?=$anz_storniert;?>)</i></td>
		<td style="color:#642EFE;"><i><?=number_format($problem, 2);?> € (<?=$anz_problem;?>)</i></td>
		<td style="color:#A5D995;"><i><?=number_format($akquiriert, 2);?> € (<?=$anz_akquiriert;?>)</i></td>
		<td style="color:#A5D995;"><i><?=number_format($fpe, 2);?> €</i></td>
	</tr>

	<?
}
?>

	<tr>
		<td><b>Gesamt</b></td>
		<td><b><?=$fahrten_all;?></b></td>
		<td><b><?=number_format($umsatz_all, 2);?> €</b></td>
		<td><b><?=number_format($prov_all, 2);?> €</b></td>
		<td style="color:#848484;"><i><b><?=number_format($storno_all, 2);?> € (<?=$anz_storno_all;?>)</b></i></td>
		<td style="color:#642EFE;"><i><b><?=number_format($problem_all, 2);?> € (<?=$anz_problem_all;?>)</b></i></td>
		<td style="color:#A5D995;"><i><b><?=number_format($akquiriert_all, 2);?> € (<?=$anz_akquiriert_all;?>)</b></i></td>
		<td style="color:#A5D995;"><i><b><?=number_format($fpe_all, 2);?> €</b></i></td>
	</tr>

</table>

<br style="clear:both;"><br style="clear:both;"><br style="clear:both;">