<?
if($ADMIN["role"] < 2) {
	report("Fehlende Rechte.");
	die(go($GLOBAL["root"]."admin?s=logout"));
}


$bestandsfilter = $_REQUEST["bestandsfilter"];


if($a == "acceptnew") {
	$fahrersel = $_REQUEST["fahrersel"];

	$result = $DB->q("SELECT * FROM fahrten WHERE id = '".$_REQUEST["id"]."'");
	$THIS = mysqli_fetch_array($result);
	$result = $DB->q("SELECT * FROM admins WHERE id = '".$fahrersel."'");
	$FAHRER = mysqli_fetch_array($result);

	if($fahrersel == "storno") {
		$result = $DB->q("UPDATE fahrten SET status = 3 WHERE id = '".$THIS["id"]."'");

		// Stornobestätigung an Kunde
		SendStornoMailKunde($THIS);

		// Storno log
		$result = $DB->q("INSERT INTO fahrten_stornos SET fahrt = '".$THIS["id"]."', supervisor = '".$ADMIN["id"]."'");

		Protokoll("Fahrt durch Administrator ".$ADMIN["vorname"]." ".$ADMIN["nachname"]." storniert (keine Provision).", $THIS["fahrer"], $THIS["id"], $PROV["id"]);

		report("Fahrt von ".$THIS["vorname"]." ".$THIS["nachname"]." storniert!");
		die(go("?s=".$s));
	}
	elseif($fahrersel == "stornosupervisorprov") {
		$result = $DB->q("UPDATE fahrten SET status = 3 WHERE id = '".$THIS["id"]."'");
		$SUPERV = GetAdminById($THIS["supervisor"]);
		
		// Provision an Supervisor verrechnen
		$result = $DB->q("INSERT INTO provisionen SET 
			supervisor = '".$SUPERV["id"]."', 
			fahrt = '".$THIS["id"]."', 
			betrag = '".($THIS["fahrpreis"]*$SUPERV["provisionssatz"]/100)."',
			grundlage = 'Fahrt durch Administrator (für Supervisor provisionspflichtig) storniert.'");
		$result = $DB->q("SELECT * FROM provisionen WHERE supervisor = '".$SUPERV["id"]."' ORDER BY id DESC LIMIT 1");
		$PROV = mysqli_fetch_array($result);

		// Stornobestätigung an Kunde
		SendStornoMailKunde($THIS);

		// Storno log
		$result = $DB->q("INSERT INTO fahrten_stornos SET fahrt = '".$THIS["id"]."', supervisor = '".$ADMIN["id"]."'");

		Protokoll("Fahrt durch Supervisor ".$ADMIN["vorname"]." ".$ADMIN["nachname"]." provisionspflichtig storniert.", 0, $THIS["id"], $PROV["id"]);

		report("Fahrt von ".$THIS["vorname"]." ".$THIS["nachname"]." storniert und Provision an Supervisor verrechnet!");
		die(go("?s=".$s));
	}
	elseif($fahrersel == "delete") {		
		$result = $DB->q("UPDATE fahrten SET deleted = 1 WHERE id = '".$THIS["id"]."'");

		Protokoll("Fahrt durch Administrator ".$ADMIN["vorname"]." ".$ADMIN["nachname"]." gelöscht.", 0 , $THIS["id"]);

		report("Fahrt gelöscht!");
		die(go("?s=".$s));
	}
	elseif($fahrersel == "x" || $fahrersel == "xx") { 
		// Nothing
	} else {
		$result = $DB->q("UPDATE fahrten SET status = 1, fahrer = '".$fahrersel."', fahrer_seen = 0 WHERE id = '".$THIS["id"]."'");		
		
		// Bestätigung an Kunde
		SendAuftragsMailKunde($THIS);
		
		// Bestätigung an Fahrer
		SendAuftragsMailFahrer($THIS, $FAHRER);

		Protokoll("Fahrt zugewiesen an Fahrer ".$FAHRER["nachname"]." ".$FAHRER["vorname"]." durch Administrator ".$ADMIN["vorname"]." ".$ADMIN["nachname"], $fahrersel, $THIS["id"], 0);

		report("Fahrt zugewiesen und bestätigt.");
		die(go("?s=".$s));
	}
}
elseif($a == "fahrtaction") {
	$actionsel = $_REQUEST["actionsel"];

	$result = $DB->q("SELECT * FROM fahrten WHERE id = '".$_REQUEST["id"]."'");
	$THIS = mysqli_fetch_array($result);
	$result = $DB->q("SELECT * FROM admins WHERE id = '".$THIS["fahrer"]."'");
	$FAHRER = mysqli_fetch_array($result);	

	if($actionsel == "entzieh") {
		$result = $DB->q("UPDATE fahrten SET status = 0, fahrer = 0, fahrer_seen = 0 WHERE id = '".$THIS["id"]."'");		

		Protokoll("Fahrt durch Administrator ".$ADMIN["vorname"]." ".$ADMIN["nachname"]." entzogen und zurückgesetzt (ohne Provision).", $THIS["fahrer"], $THIS["id"], 0);

		report("Fahrt von ".$THIS["vorname"]." ".$THIS["nachname"]." entzogen und zurückgesetzt!");
		die(go("?s=".$s));
	}
	elseif($actionsel == "entziehprov") {
		$result = $DB->q("UPDATE fahrten SET status = 0, fahrer = 0, fahrer_seen = 0 WHERE id = '".$THIS["id"]."'");	

		// Provision
		$result = $DB->q("INSERT INTO provisionen SET 
			fahrer = '".$THIS["fahrer"]."', 
			fahrt = '".$THIS["id"]."',
			betrag = '".($THIS["fahrpreis"]*$FAHRER["provisionssatz"]/100)."',
			grundlage = 'Fahrt provisionspflichtig durch Admin weitergegeben'");
		$result = $DB->q("SELECT * FROM provisionen ORDER BY id DESC LIMIT 1");
		$PROV = mysqli_fetch_array($result);

		Protokoll("Fahrt durch Administrator ".$ADMIN["vorname"]." ".$ADMIN["nachname"]." (provisionspflichtig) entzogen und zurückgesetzt.", $THIS["fahrer"], $THIS["id"], $PROV["id"]);

		report("Fahrt provisionspflichtig entzogen und zurückgesetzt!");
		die(go("?s=".$s));
	}
	elseif($actionsel == "archivieren") {
		$result = $DB->q("UPDATE fahrten SET archiviert = 1 WHERE id = '".$THIS["id"]."'");	
		
		$result = $DB->q("SELECT * FROM fahrten WHERE (email = '".$THIS["email"]."' OR tel = '".$THIS["tel"]."') AND id != '".$THIS["id"]."'");
		$exist = mysqli_num_rows($result);
		
		if(!$exist && $THIS["status"] == 2) {
			$result = $DB->q("UPDATE fahrten SET remarketing_gesendet = 1 WHERE id = '".$THIS["id"]."'");
			
			// Mail Gutschein mit Umfrage für Erstkunden
			SendGutscheinUmfrageMailKunde($THIS);	
		}		

		report("Fahrt archiviert!");
		die(go("?s=".$s));
	}
	elseif($actionsel == "mailneu") {
		// Bestätigung an Kunde
		SendAuftragsMailKunde($THIS);

		Protokoll("Bestätigungsmail durch Administrator ".$ADMIN["vorname"]." ".$ADMIN["nachname"]." erneut an Kunde gesenet.");

		report("Mail erneut gesendet!");
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

<h3 style="margin:0px 0px 30px 0px;">Neue Fahrten</h3>

<div style="width:100%;">
	<table class="fahrtenadmintbl" style="width:100%;">
		<tr>
			<th>#</th>
			<th>Zeit</th>			
			<th>Von</th>
			<th>Nach</th>
			<th>Kunde</th>
			<th>Preis</th>
			<th>Fahrer zuweisen</th>
		</tr>
		<?
		$result = $DB->q("SELECT * FROM fahrten WHERE (status = 0 OR status = 4) AND deleted = 0 ORDER BY fahrt_datum, fahrt_zeit_h, fahrt_zeit_m");
		while($row = mysqli_fetch_array($result)) {
			$result2 = $DB->q("SELECT * FROM gutscheine WHERE id = '".$row["gutschein"]."'");
			$gsexist = mysqli_num_rows($result2);
			if($gsexist){ $GS = mysqli_fetch_array($result2); }
			?>
			<tr<?if($row["status"] == 4){?> style="background:#FAAC58;"<?}?>>
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
					<?
					if($gsexist) {
						?>
						<s style="color:gray;">€ <?=$row["fahrpreis"]+$GS["wert"];?></s><br>
						€ <?=$row["fahrpreis"];?><br>
						<?
					}else{
						?>
						€ <?=$row["fahrpreis"];?><br>
						<?
					}
					?>					
					<? if($row["autotyp"] == 1){?> Limo <?}elseif($row["autotyp"] == 2){?> Kombi <?}elseif($row["autotyp"] == 3){?> Van <?} ?><br>
				</td>
				<td>
					<form action="?s=<?=$s;?>&a=acceptnew&id=<?=$row["id"];?>" id="n<?=$row["id"];?>f" method="POST">
						<select name="fahrersel">
							<option value="x">Auswahl...</option>
							<?
							$result2 = $DB->q("SELECT * FROM admins ORDER BY nachname");
							while($row2 = mysqli_fetch_array($result2)) {
								?>
								<option value="<?=$row2["id"];?>" onClick="document.getElementById('n<?=$row["id"];?>f').submit();">
									<?=$row2["nachname"];?> <?=$row2["vorname"];?>										
								</option>
								<?
							}
							?>
							<option value="xx">---</option>
							<option value="storno" onClick="document.getElementById('n<?=$row["id"];?>f').submit();">Stornieren</option>
							<option value="stornosupervisorprov" onClick="document.getElementById('n<?=$row["id"];?>f').submit();">Stornieren + Provision Superv.</option>
							<option value="xx">---</option>
							<option value="delete" onClick="document.getElementById('n<?=$row["id"];?>f').submit();">Löschen</option>
						</select>
						<input type="submit" value="OK">
					</form>
				</td>
			</tr>
			<tr>
				<td colspan="7" style="padding:0px 0px 0px 10px !important;">
					<small><i>Bestellt: <?=$row["erstellt"];?></i></small>
				</td>
			</tr>
			<?
			if($row["status"] == 4) { 
				$result3 = $DB->q("SELECT * FROM fahrten_ablehnungen WHERE fahrt = '".$row["id"]."'");
				$ABL = mysqli_fetch_array($result3);
				$result4 = $DB->q("SELECT * FROM admins WHERE id = '".$ABL["fahrer"]."'");
				$ABLEHNER = mysqli_fetch_array($result4);
				?>
				<tr style="background:#FAAC58;">
					<td colspan="7" style="padding:0px 0px 0px 10px !important;">
						<small><i>
						! Abgelehnt von <?=$ABLEHNER["nachname"];?> <?=$ABLEHNER["vorname"];?> am <?=$ABL["zeitpunkt_abgelehnt"];?> !
						</i></small>
					</td>
				</tr>
				<?
			}
		}
		?>
	</table>
</div>

<br>
<hr>

<h3>Aktuelle Fahrten</h3>
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
	<input type="submit" value="OK">
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
			$result = $DB->q("SELECT * FROM fahrten WHERE status != 0 AND status != 4 AND archiviert != 1 AND deleted = 0 ORDER BY fahrt_datum, fahrt_zeit_h, fahrt_zeit_m");
		}else{
			$result = $DB->q("SELECT * FROM fahrten WHERE archiviert != 1 AND status != 0 AND status != 4 AND fahrer = '".$bestandsfilter."' AND deleted = 0 ORDER BY fahrt_datum, fahrt_zeit_h, fahrt_zeit_m");
		}

		
		while($row = mysqli_fetch_array($result)) {
			$result2 = $DB->q("SELECT * FROM gutscheine WHERE id = '".$row["gutschein"]."'");
			$gsexist = mysqli_num_rows($result2);
			if($gsexist){ $GS = mysqli_fetch_array($result2); }
			
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
					<?
					if($gsexist) {
						?>
						<nobr><s style="color:gray;">€ <?=$row["fahrpreis"]+$GS["wert"];?></s></nobr><br>
						<nobr>€ <?=$row["fahrpreis"];?></nobr><br>
						<?
					}else{
						?>
						<nobr>€ <?=$row["fahrpreis"];?></nobr><br>
						<?
					}
					?>					
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
							<?
							if($row["status"] != 1) {
								?>
								<option value="archivieren" onClick="document.getElementById('b<?=$row["id"];?>f').submit();">Archivieren</option>
								<?
							}
							?>
							
							<?
							if($row["status"] == 1) {
								?>
								<option value="mailneu" onClick="document.getElementById('b<?=$row["id"];?>f').submit();">Resend Bestätigung</option>
								<option value="xx">---</option>
								<option value="entzieh" onClick="document.getElementById('b<?=$row["id"];?>f').submit();">Entziehen</option>
								<option value="entziehprov" onClick="document.getElementById('b<?=$row["id"];?>f').submit();">Entziehen + Provision</option>
								<?
							}
							?>
						</select>
						<input type="submit" value="OK">
					</form>
				</td>
			</tr>
			<tr style="background-color:<?=$color;?>;border-bottom:black solid 1px;">
				<td colspan="8" style="padding:0px 0px 0px 10px !important;">
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