<?

$bestandsfilter = $_REQUEST["bestandsfilter"];

if($ADMIN["role"] != 2) {
	report("Fehlende Rechte.");
	die(go($GLOBAL["root"]."admin?s=logout"));
}


if($a == "fahrtaction") {
	$actionsel = $_REQUEST["actionsel"];

	$result = $DB->q("SELECT * FROM fahrten WHERE id = '".$_REQUEST["id"]."'");
	$THIS = mysqli_fetch_array($result);
	$result = $DB->q("SELECT * FROM admins WHERE id = '".$THIS["fahrer"]."'");
	$FAHRER = mysqli_fetch_array($result);	

	if($actionsel == "entarchivieren") {
		$result = $DB->q("UPDATE fahrten SET archiviert = 0 WHERE id = '".$THIS["id"]."'");	

		report("Fahrt reaktiviert!");
		die(go("?s=".$s));
	}
	elseif($actionsel == "feedbackgutschein") {		
		$result = $DB->q("UPDATE fahrten SET remarketing_gesendet = 1 WHERE id = '".$THIS["id"]."'");
		
		// Mail Gutschein mit Umfrage für Erstkunden
		SendGutscheinUmfrageMailKunde($THIS);

		report("Gutschein-Einladung verschickt!");
		die(go("?s=".$s));
	}
	elseif($actionsel == "stornorechnung") {
		$FAHRT = $THIS;
		
		$result = $DB->q("SELECT * FROM rechnungen WHERE fahrt = '".$FAHRT["id"]."'");
		$exist = mysqli_num_rows($result);
		if($exist) {
			// Rechnung existiert schon
			$RECHN = mysqli_fetch_array($result);
		}else{
			// Rechnung neu erstellen
			$result = $DB->q("INSERT INTO rechnungen SET fahrt = '".$FAHRT["id"]."', status = '0', betrag = '".$FAHRT["fahrpreis"]."'");
			$result = $DB->q("SELECT * FROM rechnungen ORDER BY id DESC LIMIT 1");		
			$RECHN = mysqli_fetch_array($result);
			
			// PDF erstellen
			StornoRechnungPdfErstellen($FAHRT, $RECHN);
		}
		
		SendStornoRechnungMailKunde($FAHRT, $RECHN);	

		report("Stornorechnung erstellt und gesendet!");
		die(go("?s=".$s));
	}
	elseif($actionsel == "provisionnachverr") {
		$SUPERV = GetAdminById($THIS["supervisor"]);
		
		// Provision an Supervisor verrechnen
		$result = $DB->q("INSERT INTO provisionen SET 
			supervisor = '".$SUPERV["id"]."', 
			fahrt = '".$THIS["id"]."', 
			betrag = '".($THIS["fahrpreis"]*$SUPERV["provisionssatz"]/100)."',
			grundlage = 'Provision durch Administrator aufgrund Fahrerverschulden an Supervisor nachverrechnet.'");
		$result = $DB->q("SELECT * FROM provisionen WHERE supervisor = '".$SUPERV["id"]."' ORDER BY id DESC LIMIT 1");
		$PROV = mysqli_fetch_array($result);

		Protokoll("Fahrt-Provision durch Administrator ".$ADMIN["vorname"]." ".$ADMIN["nachname"]." an SV nachverrechnet.", 0, $THIS["id"], $PROV["id"]);

		report("Fahrt Provision an Supervisor nachverrechnet!");
		die(go("?s=".$s));
	}
}

?>

<h3>Archivierte Fahrten</h3>
Zeige Fahrten von: 
<form action="?" method="GET" id="filterform" style="display:inline;">
	<input type="hidden" name="s" value="<?=$s;?>">
	<select name="bestandsfilter" style="width:auto;padding:5px;border:black solid 1px;display:inline;">
		<option value="" onClick="document.getElementById('filterform').submit();"<?if(!$bestandsfilter){?> SELECTED<?}?>>Alle</option>
		<?
		$result = $DB->q("SELECT * FROM admins ORDER BY nachname");
		while($row = mysqli_fetch_array($result)) {
			?>
			<option value="<?=$row["id"];?>" onClick="document.getElementById('filterform').submit();"<?if($bestandsfilter == $row["id"]){?> SELECTED<?}?>>
				<?=$row["nachname"];?> <?=$row["vorname"];?>					
			</option>
			<?
		}
		?>
	</select>
</form>
<br style="clear:both;"><br style="clear:both;">

<div style="width:100%;">
	<table class="fahrtenadmintbl" style="width:100%;">
		<tr>
			<th>#</th>
			<th>Zeit</th>			
			<th>Von</th>
			<th>Nach</th>
			<th>Kunde</th>
			<th>Preis</th>
			<th>Fahrer</th>
			<th>Aktion</th>
		</tr>
		<?
		if(!$bestandsfilter) {
			$result = $DB->q("SELECT * FROM fahrten WHERE archiviert = 1 ORDER BY fahrt_datum DESC, fahrt_zeit_h DESC, fahrt_zeit_m DESC");
		}else{
			$result = $DB->q("SELECT * FROM fahrten WHERE archiviert = 1 AND fahrer = '".$bestandsfilter."' ORDER BY fahrt_datum, fahrt_zeit_h, fahrt_zeit_m DESC");
		}
		
		while($row = mysqli_fetch_array($result)) {
			$result2 = $DB->q("SELECT * FROM rechnungen WHERE fahrt = '".$row["id"]."'");
			$hasbill = mysqli_num_rows($result2);
			$result2 = $DB->q("SELECT * FROM provisionen WHERE fahrt = '".$row["id"]."'");
			$hasprov = mysqli_num_rows($result2);
			
			if($row["status"] == 2){ $color = "#A9F5A9"; }
			elseif($row["status"] == 3){ $color = "#E6E6E6"; }
			elseif($row["status"] == 5){ $color = "#BCA9F5"; }
			else{ $color = "white"; }
			?>
			<tr style="background-color:<?=$color;?>;border-top:black solid 1px;">
				<td>
					<?=$row["id"];?><br>
					<?
					if($row["lang"] == "de"){?><img src="<?=$GLOBAL["root"];?>assets/images/at.png" style="height:10px;"><?}
					elseif($row["lang"] == "en"){?><img src="<?=$GLOBAL["root"];?>assets/images/en.png" style="height:10px;"><?}
					?>
				</td>
				<td>
					<?=$row["fahrt_datum"];?>, <?=sprintf("%02d", $row["fahrt_zeit_h"]);?>:<?=sprintf("%02d", $row["fahrt_zeit_m"]);?><br>
					<div style="font-weight:bold;">
						<? 
						if($row["kindersitze"]) { echo $row["kindersitze"]." KS, "; }
						if($row["babyschalen"]) { echo $row["babyschalen"]." BS"; }
						?>	
					</div>			
				</td>				
				<td>
					<? if($row["von_adresse"]){ echo $row["von_adresse"]."<br>"; }?>
					<?=$row["von_ort"];?>
					<? if($row["typ"] == 1){ echo "<br>".$row["meta_flugnummer"]; }?>
				</td>
				<td>
					<? if($row["zu_adresse"]){ echo $row["zu_adresse"]."<br>"; }?>
					<?=$row["zu_ort"];?>
				</td>
				<td>
					<?=$row["vorname"];?> <?=$row["nachname"];?><br>
					<?=$row["tel"];?><br>
					<?=$row["email"];?>
				</td>
				<td>
					<nobr>€ <?=$row["fahrpreis"];?></nobr><br>
					<? if($row["autotyp"] == 1){?> Limo <?}elseif($row["autotyp"] == 2){?> Kombi <?}elseif($row["autotyp"] == 3){?> Van <?} ?><br>
					<nobr><?if($hasprov){?><img src="<?=$GLOBAL["root"];?>assets/images/provision.png" style="height:15px;"><?}?>
					<?if($hasbill){?><img src="<?=$GLOBAL["root"];?>assets/images/bill.png" style="height:15px;"><?}?></nobr><br>
				</td>
				<td>
					<?
					$FAHRER = GetAdminById($row["fahrer"]);
					$SUPER = GetAdminById($row["supervisor"]);
					?>
					<?=$FAHRER["nachname"];?> <?=$FAHRER["vorname"];?><br>
					<small><i>(<?=$SUPER["nachname"];?>)</i></small>
				</td>
				<td>
					<form action="?s=<?=$s;?>&a=fahrtaction&id=<?=$row["id"];?>" id="b<?=$row["id"];?>f" method="POST">
						<select name="actionsel">
							<option value="x" SELECTED>Auswahl...</option>
							<option value="entarchivieren" onClick="document.getElementById('b<?=$row["id"];?>f').submit();">Un-Archive</option>
							<option value="xx">---</option>
							<option value="feedbackgutschein" onClick="document.getElementById('b<?=$row["id"];?>f').submit();">5€ Gutschein senden</option>
							<?
							if($row["status"] != 2) {
								?>
								<option value="xx">---</option>
								<option value="stornorechnung" onClick="document.getElementById('b<?=$row["id"];?>f').submit();">Stornorechnung senden</option>							
								<option value="provisionnachverr" onClick="document.getElementById('b<?=$row["id"];?>f').submit();">Provision Nachverr.</option>
								<?
							}
							?>
						</select>
						<input type="submit" value="OK">
						<?if($row["remarketing_gesendet"]){?> <img src="<?=$GLOBAL["root"];?>assets/images/coupon.png" style="height:10px;padding-left:10px;"> <?}?>
					</form>
				</td>
			</tr>
			<tr style="background-color:<?=$color;?>">
				<td colspan="8" style="padding:0px 0px 0px 10px !important;border-bottom:black solid 1px;">
					<small><i>					
					Bestellt: <?=$row["erstellt"];?><br>					
					<?
					if($row["status"] == 2) { 
						$result3 = $DB->q("SELECT * FROM fahrten_erledigungen WHERE fahrt = '".$row["id"]."' AND fahrer = '".$row["fahrer"]."'");
						$MELD = mysqli_fetch_array($result3);
						$result4 = $DB->q("SELECT * FROM admins WHERE id = '".$row["fahrer"]."'");
						$MELDER = mysqli_fetch_array($result4);
						?>
						Als erledigt markiert von <?=$MELDER["nachname"];?> <?=$MELDER["vorname"];?> am <?=$MELD["zeitpunkt_erledigt"];?>.
						<?
					}
					elseif($row["status"] == 3) { 
						$result3 = $DB->q("SELECT * FROM fahrten_stornos WHERE fahrt = '".$row["id"]."' ORDER BY id DESC");
						$PROB = mysqli_fetch_array($result3);
						$SUPERV = GetAdminById($PROB["supervisor"]);
						?>
						Storniert von <?=$SUPERV["nachname"];?> <?=$SUPERV["vorname"];?> am <?=$PROB["zeitpunkt_storniert"];?> !
						<?
					}
					elseif($row["status"] == 5) { 
						$result3 = $DB->q("SELECT * FROM fahrten_probleme WHERE fahrt = '".$row["id"]."' ORDER BY id DESC");
						$PROB = mysqli_fetch_array($result3);
						$result4 = $DB->q("SELECT * FROM admins WHERE id = '".$row["fahrer"]."'");
						$FAHR = mysqli_fetch_array($result4);
						?>
						<?=$PROB["text"];?>. Gemeldet von <?=$FAHR["nachname"];?> <?=$FAHR["vorname"];?> am <?=$PROB["zeitpunkt_gemeldet"];?> !
						<?
					}
					?>					
					</i></small>
				</td>
			</tr>			
			<?
		}
		?>
	</table>
</div>

<br style="clear:both;"><br style="clear:both;"><br style="clear:both;">