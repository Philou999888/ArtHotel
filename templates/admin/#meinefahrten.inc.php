<h3 style="margin-top:0px;">Meine Fahrten</h3>

<?
if($a == "fahrtdone") {
	$result = $DB->q("SELECT * FROM fahrten WHERE id = '".$_REQUEST["id"]."' AND fahrer = '".$ADMIN["id"]."' AND deleted = 0");
	$THIS = mysqli_fetch_array($result);

	if($do == "save") {
		$result = $DB->q("UPDATE fahrten SET status = 2 WHERE id = '".$THIS["id"]."'");
		
		// Provision
		$result = $DB->q("INSERT INTO provisionen SET 
			fahrer = '".$ADMIN["id"]."', 
			supervisor = '".$ADMIN["supervisor"]."', 
			fahrt = '".$THIS["id"]."',
			betrag = '".($THIS["fahrpreis"]*$ADMIN["provisionssatz"]/100)."',
			grundlage = 'Fahrt erfolgreich durchgeführt'");
		$result = $DB->q("SELECT * FROM provisionen ORDER BY id DESC LIMIT 1");
		$PROV = mysqli_fetch_array($result);

		// Meldung
		$result = $DB->q("INSERT INTO fahrten_erledigungen SET 
			fahrer = '".$ADMIN["id"]."', 
			supervisor = '".$ADMIN["supervisor"]."', 
			fahrt = '".$THIS["id"]."', 
			provision = '".$PROV["id"]."'");

		// Protokoll
		Protokoll("Fahrt erfolgreich abgeschlossen.", $THIS["fahrer"], $THIS["id"], $PROV["id"]);
		?>
		<center>
		<b>Danke!</b>
		<br><br>
		<a href="?s=<?=$s;?>"><input type="button" value="Zur Übersicht" style="color:black;padding:5px 20px;"></a>
		</center>
		<?
	}else{
		?>
		<center>
		<b>Fahrt von <?=$THIS["vorname"];?> <?=$THIS["nachname"];?> erledigt und ordnungsgemäß am Fahrziel abgesetzt?</b>
		<br><br>
		<a href="?s=<?=$s;?>&a=fahrtdone&id=<?=$THIS["id"];?>&do=save"><input type="button" value="Ja, erledigt" style="color:black;padding:5px 20px;"></a>
		<br style="clear:both;"><br style="clear:both;">
		<a href="?s=<?=$s;?>"><input type="button" value="Nein, zurück" style="color:black;padding:5px 20px;"></a>
		</center>
		<?
	}
}
elseif($a == "fahrtproblem") {
	$result = $DB->q("SELECT * FROM fahrten WHERE id = '".$_REQUEST["id"]."' AND fahrer = '".$ADMIN["id"]."' AND deleted = 0");
	$THIS = mysqli_fetch_array($result);

	if($do == "ablehnen") {
		$result = $DB->q("UPDATE fahrten SET status = 4, fahrer = 0, fahrer_seen = 0 WHERE id = '".$THIS["id"]."'");		

		// Provision
		$result = $DB->q("INSERT INTO provisionen SET 
			fahrer = '".$ADMIN["id"]."', 
			supervisor = '".$ADMIN["supervisor"]."', 
			fahrt = '".$THIS["id"]."',
			betrag = '".($THIS["fahrpreis"]*$ADMIN["provisionssatz"]/100)."',
			grundlage = 'Fahrt als Fahrer abgelehnt'");
		$result = $DB->q("SELECT * FROM provisionen ORDER BY id DESC LIMIT 1");
		$PROV = mysqli_fetch_array($result);

		// Ablehnung
		$result = $DB->q("INSERT INTO fahrten_ablehnungen SET 
			fahrt = '".$THIS["id"]."', 
			supervisor = '".$ADMIN["supervisor"]."', 
			fahrer = '".$ADMIN["id"]."', 
			provision = '".$PROV["id"]."'");

		// Protokoll
		Protokoll("Fahrt von Fahrer provisionspflichtig abgelehnt.", $THIS["fahrer"], $THIS["id"], $PROV["id"]);
		?>
		<center>
		<b>Gespeichert.</b>
		<br><br>
		<a href="?s=<?=$s;?>"><input type="button" value="Zur Übersicht" style="color:black;padding:5px 20px;"></a>
		</center>
		<?
	}
	elseif($do == "kundenichtda") {
		$result = $DB->q("UPDATE fahrten SET status = 5 WHERE id = '".$THIS["id"]."'");
		$result = $DB->q("INSERT INTO fahrten_probleme SET 
			fahrt = '".$THIS["id"]."', 
			fahrer = '".$ADMIN["id"]."', 
			supervisor = '".$ADMIN["supervisor"]."', 
			text = 'Kunde nicht erschienen und telefonisch nicht erreichbar.'");

		// Protokoll
		Protokoll("Fahrer meldet Kunde nicht aufgetaucht, Fahrt nicht durchgeführt.", $THIS["fahrer"], $THIS["id"], 0);
		?>
		<center>
		<b>Gespeichert.</b>
		<br><br>
		<a href="?s=<?=$s;?>"><input type="button" value="Zur Übersicht" style="color:black;padding:5px 20px;"></a>
		</center>
		<?	
	}
	elseif($do == "zukleinestaxi") {
		$result = $DB->q("UPDATE fahrten SET status = 5 WHERE id = '".$THIS["id"]."'");
		$result = $DB->q("INSERT INTO fahrten_probleme SET 
			fahrt = '".$THIS["id"]."',
			fahrer = '".$ADMIN["id"]."', 
			supervisor = '".$ADMIN["supervisor"]."', 
			text = 'Kunde bestellte zu kleines Taxi, Fahrt nicht durchgeführt.'");

		// Protokoll
		Protokoll("Fahrer meldet Kunde bestellte zu kleines Taxi, Fahrt nicht angetreten.", $THIS["fahrer"], $THIS["id"], 0);
		?>
		<center>
		<b>Gespeichert.</b>
		<br><br>
		<a href="?s=<?=$s;?>"><input type="button" value="Zur Übersicht" style="color:black;padding:5px 20px;"></a>
		</center>
		<?
	}else{
		?>
		<center>
		<a href="?s=<?=$s;?>&a=fahrtproblem&id=<?=$THIS["id"];?>&do=ablehnen"><input type="button" value="Ich lehne diese Fahrt ab" style="color:black;padding:5px 20px;"></a>
		<br style="clear:both;"><br style="clear:both;">
		<a href="?s=<?=$s;?>&a=fahrtproblem&id=<?=$THIS["id"];?>&do=kundenichtda"><input type="button" value="Kunde nicht aufgetaucht" style="color:black;padding:5px 20px;"></a>
		<br style="clear:both;"><br style="clear:both;">
		<a href="?s=<?=$s;?>&a=fahrtproblem&id=<?=$THIS["id"];?>&do=zukleinestaxi"><input type="button" value="Kunde bestellte zu kleines Taxi" style="color:black;padding:5px 20px;"></a>
		<br style="clear:both;"><br style="clear:both;"><hr><br style="clear:both;">
		<a href="?s=<?=$s;?>"><input type="button" value="Abbrechen" style="color:black;padding:5px 20px;"></a>

		</center>
		<?
	}


}else{
	$result = $DB->q("SELECT * FROM fahrten WHERE fahrer = '".$ADMIN["id"]."' AND status = 1 AND deleted = 0 ORDER BY fahrt_datum, fahrt_zeit_h, fahrt_zeit_m");
	$num = mysqli_num_rows($result);
	if(!$num) {
		echo "<i>Derzeit keine offenen Fahrten.</i>";
	}
	?>

	<div class="accordion">
	<?
	while($row = mysqli_fetch_array($result)) {
		?>
		<h4 style="color:black;font-weight:normal;font-size:15px;line-height:20px;<?if(!$row["fahrer_seen"]){?>background:#F3F781 !important;<?}?>">
			<b># <?=$row["id"];?> 
			<?
			if($row["lang"] == "de"){?><img src="<?=$GLOBAL["root"];?>assets/images/at.png" style="height:10px;"><?}
			elseif($row["lang"] == "en"){?><img src="<?=$GLOBAL["root"];?>assets/images/en.png" style="height:10px;"><?}
			?>
			<?if(!$row["fahrer_seen"]){?> - NEU (!)<?}?></b><br>
			<?=$row["fahrt_datum"];?>, <?=sprintf("%02d", $row["fahrt_zeit_h"]);?>:<?=sprintf("%02d", $row["fahrt_zeit_m"]);?> Uhr<br>
			<b><? if($row["typ"] == 1){?> Vom Flughafen <?}else{?> Zum Flughafen <?}?></b>
		</h4>	
		<div>
			<div class="col-xs-6">
				<b>Auto</b><br>
				<? if($row["autotyp"] == 1){?> Limo <?}elseif($row["autotyp"] == 2){?> Kombi <?}elseif($row["autotyp"] == 3){?> Van <?} ?>
			</div>
			<div class="col-xs-6">
				<b>Preis</b><br>
				€ <?=$row["fahrpreis"];?>
			</div>
			<br style="clear:both;"><br style="clear:both;">
			<div class="col-xs-6">
				<b>Von</b><br>
				<? if($row["typ"] == 1){?> Flughafen<br><?=$row["meta_flugnummer"];?> <?}else{ echo $row["fahrtziel_adresse"]."<br>".$row["fahrtziel_ort"]; } ?>
			</div>
			<div class="col-xs-6">
				<b>Nach</b><br>
				<? if($row["typ"] == 2){?> Flughafen <?}else{ echo $row["fahrtziel_adresse"]."<br>".$row["fahrtziel_ort"]; } ?>
			</div>
			<br style="clear:both;"><br style="clear:both;">
			<div class="col-xs-6">
				<b>Extras</b><br>
				<? 
				if($row["kindersitze"] || $row["babyschalen"]) {
					if($row["kindersitze"]) { echo $row["kindersitze"]." Kinders.<br>"; }
					if($row["babyschalen"]) { echo $row["babyschalen"]." Babysch."; }
				}else{
					?>
					<i>Keine</i>
					<?
				}
				?>
			</div>
			<div class="col-xs-6">
				<b>Fahrgast</b><br>
				<?=$row["vorname"];?> <?=$row["nachname"];?><br>
				<?=$row["tel"];?>
			</div>
			<br style="clear:both;"><br style="clear:both;">
			<div class="col-xs-6">
				<a href="?s=<?=$s;?>&a=fahrtdone&id=<?=$row["id"];?>" style="color:black;">
					<img src="<?=$GLOBAL["root"];?>assets/images/check.png" style="height:30px;"> Erledigt
				</a>
			</div>
			<div class="col-xs-6">
				<a href="?s=<?=$s;?>&a=fahrtproblem&id=<?=$row["id"];?>" style="color:black;">
					<img src="<?=$GLOBAL["root"];?>assets/images/problem.png" style="height:30px;"> Problem
				</a>
			</div>

		</div>

		<?
		// Mark as seen
		if(!$row["fahrer_seen"]) {
			$result2 = $DB->q("UPDATE fahrten SET fahrer_seen = 1 WHERE id = '".$row["id"]."'");
		}
	}
	?>

	</div>
	<br style="clear:both;"><br style="clear:both;">

	<?
}


?>
