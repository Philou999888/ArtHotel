<?
$bestandsfilter = $_REQUEST["bestandsfilter"];



if($ADMIN["role"] != 2) {
	report("Fehlende Rechte.");
	die(go($GLOBAL["root"]."admin?s=logout"));
}

if($a == "acceptnew") {
	$fahrersel = $_REQUEST["fahrersel"];

	$result = $DB->q("SELECT * FROM fahrten WHERE id = '".$_REQUEST["id"]."'");
	$THIS = mysqli_fetch_array($result);
	$result = $DB->q("SELECT * FROM admins WHERE id = '".$fahrersel."'");
	$FAHRER = mysqli_fetch_array($result);	

	if($fahrersel == "storno") {
		$result = $DB->q("UPDATE fahrten SET status = 3 WHERE id = '".$THIS["id"]."'");		

		// Storno Mail
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = $CONFIG["smtphost"]; 
		$mail->Port = $CONFIG["smtpport"]; 
		$mail->SMTPAuth = true; 
		$mail->Username = $CONFIG["smtpuser"]; 
		$mail->Password = $CONFIG["smtppass"]; 
		$mail->SMTPSecure = $CONFIG["smtpsecure"]; 	
		$mail->setFrom($CONFIG["email"], $CONFIG["firmenname"]);
		$mail->addReplyTo($CONFIG["email"], $CONFIG["firmenname"]);
		$mail->addAddress($THIS["email"], $THIS["vorname"], $THIS["nachname"]);		
		$mail->isHTML(true);
		$mail->CharSet = 'utf-8';
		$mail->SetLanguage ("de");	

		if($THIS["lang"] == "en") {
			$mail->Subject = "Cancellation of your ride";
			$mail->Body = "
			<div style='width:50%;min-width:300px;margin:auto;padding:50px 0px 50px 0px;'>
				<img src='https://www.vienna-airporttaxi-adam.com/assets/images/logo-inner.png' style='width:150px;'>
				<br><br>
				
				Dear passenger!
				<br><br>
				We regret to inform your that your ride on ".date('d.m.Y', strtotime($THIS["fahrt_datum"]))." at ".sprintf("%02d", $THIS["fahrt_zeit_h"]).":".sprintf("%02d", $THIS["fahrt_zeit_m"])." has been cancelled. We wish you a very pleasant journey and would be happy to welcome you back at another time as our passenger.
				<br><br>
				You have questions or want to book another ride? Our team is happy to help you under the following hotline:<br>
				<h3>".$CONFIG["telnr"]."</h3>
				<br>
				Alternatively you can answer directly to this E-Mail or visit:<br>
				<a href='".$GLOBAL["root"]."'>www.vienna-airporttaxi-adam.com</a>
				<br><br>
				King regards,
				<br><br>
				Adam Taxi Vienna
			</div>
			";
		}else{
			$mail->Subject = "Stornierung Ihrer Fahrt";
			$mail->Body = "
			<div style='width:50%;min-width:300px;margin:auto;padding:50px 0px 50px 0px;'>
				<img src='https://www.vienna-airporttaxi-adam.com/assets/images/logo-inner.png' style='width:150px;'>
				<br><br>
				
				Sehr geehrter Fahrgast!
				<br><br>
				Wir bedauern, dass wir Ihre Fahrt am ".date('d.m.Y', strtotime($THIS["fahrt_datum"]))." um ".sprintf("%02d", $THIS["fahrt_zeit_h"]).":".sprintf("%02d", $THIS["fahrt_zeit_m"])." stornieren mussten. Wir wünschen Ihnen dennoch eine angenehme Reise und würden uns freuen, Sie in Zukunft bald wieder bei uns als Fahrgast begrüßen zu dürfen.
				<br><br>
				Haben Sie Fragen oder möchten eine andere Fahrt bei uns buchen? Dann ist unser Team gerne täglich telefonisch zu unseren Geschäftszeiten für Sie unter folgender Nummer erreichbar:<br>
				<h3>".$CONFIG["telnr"]."</h3>
				<br>
				Alternativ können Sie direkt auf diese E-Mail antworten oder uns auf unserer Website besuchen:<br>
				<a href='".$GLOBAL["root"]."'>www.vienna-airporttaxi-adam.com</a>
				<br><br>
				Mit freundlichen Grüßen
				<br><br>
				Adam Taxi Wien
			</div>
			";
		}

		$mail->send();

		// Storno log
		$result = $DB->q("INSERT INTO fahrten_stornos SET fahrt = '".$THIS["id"]."', supervisor = '".$ADMIN["id"]."'");

		Protokoll("Fahrt durch Supervisor ".$ADMIN["vorname"]." ".$ADMIN["nachname"]." storniert.", $THIS["fahrer"], $THIS["id"], 0);

		report("Fahrt von ".$THIS["vorname"]." ".$THIS["nachname"]." storniert!");
		die(go("?s=".$s));
	}
	elseif($fahrersel == "x" || $fahrersel == "xx") { 
		// Nothing
	} else {
		$result = $DB->q("UPDATE fahrten SET status = 1, fahrer = '".$fahrersel."', fahrer_seen = 0 WHERE id = '".$THIS["id"]."'");		
		
		if($THIS["autotyp"] == 1) { $fzg = "Standard - Max 2 Personen"; }
		elseif($THIS["autotyp"] == 2) { $fzg = "Kombi - Max 4 Personen"; }
		elseif($THIS["autotyp"] == 3) { $fzg = "Van - Max 8 Personen"; }
		
		if($THIS["typ"] == 1) { $abhol = "Flughafen Wien"; $ziel = $THIS["fahrtziel_adresse"].", ".$THIS["fahrtziel_ort"]; }else{ $abhol = $THIS["fahrtziel_adresse"].", ".$THIS["fahrtziel_ort"]; $ziel = "Flughafen Wien"; }
		
		$extras = "";
		if($THIS["kindersitze"]) { $extras .= $THIS["kindersitze"]." Kindersitze - "; }
		if($THIS["babyschalen"]) { $extras .= $THIS["babyschalen"]." Babyschalen"; }
		if(!$THIS["kindersitze"] && !$THIS["babyschalen"]) { $extras .= "<i>Keine</i>"; }

		// Bestätigungsmail Kunde
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = $CONFIG["smtphost"]; 
		$mail->Port = $CONFIG["smtpport"]; 
		$mail->SMTPAuth = true; 
		$mail->Username = $CONFIG["smtpuser"]; 
		$mail->Password = $CONFIG["smtppass"]; 
		$mail->SMTPSecure = $CONFIG["smtpsecure"]; 	
		$mail->setFrom($CONFIG["email"], $CONFIG["firmenname"]);
		$mail->addReplyTo($CONFIG["email"], $CONFIG["firmenname"]);
		$mail->addAddress($THIS["email"], $THIS["vorname"], $THIS["nachname"]);		
		$mail->isHTML(true);
		$mail->CharSet = 'utf-8';
		$mail->SetLanguage ("de");	

		if($THIS["lang"] == "en") {
			$mail->Subject = "Confirmation of your ride";
			$mail->Body = "
			<div style='width:50%;min-width:300px;margin:auto;padding:50px 0px 50px 0px;'>
				<img src='https://www.vienna-airporttaxi-adam.com/assets/images/logo-inner.png' style='width:150px;'>
				<br><br>
				
				Dear passenger!
				<br><br>
				We are happy that you chose us for your ride and will pick you up on ".date('d.m.Y', strtotime($THIS["fahrt_datum"]))." at ".sprintf("%02d", $THIS["fahrt_zeit_h"]).":".sprintf("%02d", $THIS["fahrt_zeit_m"])." 
				in the agreed upon place. In case you can't find your taxi, our driver will call you a few minutes after the agreed meeting time and help you.
				<br><br>
				For your ride there will be billed a fixed rate of ".$THIS["fahrpreis"]." €, no taxameter in use. Please pay your fare in cash after your ride directly to our driver. If you wish you can also pay by debit- or credit-card (third party fees apply) directly in the car.
				<br><br>
				<b>Summary of your booking:</b><br>
				Vehicle: ".$fzg."<br>
				Pickup place: ".$abhol."<br>
				Destination: ".$ziel."<br>
				Extras: ".$extras."
				<br><br>
				In case you want to change or cancel your order, please contact us at least 12 hours before your ride, so we can arrange this for you free of charge.
				<br><br>
				<b>Please make sure you get into the right taxi at the airport! Ask the driver for whom he is waiting. If you use a taxi from another company you might end up paying much more than our price and are still liable to pay for your ride with Adamtaxi.</b>
				<br><br>
				You have questions or want to book another ride? Our team is happy to help you under the following hotline:<br>
				<h3>".$CONFIG["telnr"]."</h3>
				<br>
				Alternatively you can answer directly to this E-Mail or visit:<br>
				<a href='".$GLOBAL["root"]."'>www.vienna-airporttaxi-adam.com</a>
				<br><br>
				King regards,
				<br><br>
				Adam Taxi Vienna
			</div>
			";	
		}else{
			$mail->Subject = "Bestätigung Ihrer Fahrt";
			$mail->Body = "
			<div style='width:50%;min-width:300px;margin:auto;padding:50px 0px 50px 0px;'>
				<img src='https://www.vienna-airporttaxi-adam.com/assets/images/logo-inner.png' style='width:150px;'>
				<br><br>
				
				Sehr geehrter Fahrgast!
				<br><br>
				Wir freuen uns, dass Sie sich für uns entschieden haben und werden Sie wie gewünscht am ".date('d.m.Y', strtotime($THIS["fahrt_datum"]))." um ".sprintf("%02d", $THIS["fahrt_zeit_h"]).":".sprintf("%02d", $THIS["fahrt_zeit_m"])." 
				am vereinbarten Ort abholen. Falls Sie das Taxi nicht finden können, wird unser Fahrer Sie wenige Minuten nach dem vereinbarten Abholtermin telefonisch kontaktieren. 
				<br><br>
				Für Ihre Fahrt wird ein Fixpreis von ".$THIS["fahrpreis"]." € berechnet, es kommt kein Taxameter zur Anwendung. Ihren Fahrpreis bezahlen Sie bitte nach der Fahrt 
				in Bar bei unserem Fahrer. Auf Wunsch können Sie auch im Taxi per Bankomat- oder Kreditkarte bezahlen (zzgl. einer vom Kartenunternehmen berechneten Servicegebühr).
				<br><br>
				<b>Zusammenfassung Ihrer Fahrt:</b><br>
				Fahrzeug: ".$fzg."<br>
				Abholort: ".$abhol."<br>
				Fahrziel: ".$ziel."<br>
				Extras: ".$extras."
				<br><br>
				Sollten sich Ihre Wünsche ändern oder Sie Ihre Fahrt stornieren wollen, bitten wir Sie uns mindestens 12 Stunden vor der Fahrt zu kontaktieren, damit dies kostenfrei möglich ist.
				<br><br>
				<b>Bitte achten Sie darauf, dass Sie am Flughafen in das richtige Taxi steigen! Fragen Sie den Fahrer, auf wen er wartet. Wenn Sie ein anderes Taxi nutzen, zahlen Sie möglicherweise deutlich mehr als den mit uns vereinbarten Preis und müssen dennoch Ihre Fahrt bei Adamtaxi bezahlen.</b>
				<br><br>
				Haben Sie Fragen oder möchten eine andere Fahrt bei uns buchen? Dann ist unser Team gerne täglich telefonisch zu unseren Geschäftszeiten für Sie unter folgender Nummer erreichbar:<br>
				<h3>".$CONFIG["telnr"]."</h3>
				<br>
				Alternativ können Sie direkt auf diese E-Mail antworten oder uns auf unserer Website besuchen:<br>
				<a href='".$GLOBAL["root"]."'>www.vienna-airporttaxi-adam.com</a>
				<br><br>
				Mit freundlichen Grüßen
				<br><br>
				Adam Taxi Wien
			</div>
			";
		}

		$mail->send();
		
		// Erinnerungsmail Fahrer
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = $CONFIG["smtphost"]; 
		$mail->Port = $CONFIG["smtpport"]; 
		$mail->SMTPAuth = true; 
		$mail->Username = $CONFIG["smtpuser"]; 
		$mail->Password = $CONFIG["smtppass"]; 
		$mail->SMTPSecure = $CONFIG["smtpsecure"]; 	
		$mail->setFrom($CONFIG["email"], $CONFIG["firmenname"]);
		$mail->addReplyTo($CONFIG["email"], $CONFIG["firmenname"]);
		$mail->addAddress($FAHRER["email"], $FAHRER["vorname"], $FAHRER["nachname"]);
		$mail->Subject = "Neue Fahrt wurde zugeteilt";
		$mail->isHTML(true);
		$mail->CharSet = 'utf-8';
		$mail->SetLanguage ("de");	
		$mail->Body = "
		<div style='width:50%;min-width:300px;margin:auto;padding:50px 0px 50px 0px;'>
			<img src='https://www.vienna-airporttaxi-adam.com/assets/images/logo-inner.png' style='width:150px;'>
			<br><br>
			
			Lieber Fahrer, Liebe Fahrerin,
			<br><br>
			Ihnen wurde soeben eine neue Fahrt zugeteilt. Bitte überprüfen Sie Ihre aktuellen Fahrten im Administrationsbereich.
			<br><br>
			Mit freundlichen Grüßen
			<br><br>
			Adam Taxi Wien
		</div>
		";
		$mail->send();

		Protokoll("Fahrt zugewiesen an Fahrer ".$FAHRER["nachname"]." ".$FAHRER["vorname"], $fahrersel, $THIS["id"], 0);

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

		Protokoll("Fahrt durch Admin entzogen und zurückgesetzt (ohne Provision).", $THIS["fahrer"], $THIS["id"], 0);

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

		Protokoll("Fahrt durch Admin (provisionspflichtig) entzogen und zurückgesetzt.", $THIS["fahrer"], $THIS["id"], $PROV["id"]);

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
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->Host = $CONFIG["smtphost"]; 
			$mail->Port = $CONFIG["smtpport"]; 
			$mail->SMTPAuth = true; 
			$mail->Username = $CONFIG["smtpuser"]; 
			$mail->Password = $CONFIG["smtppass"]; 
			$mail->SMTPSecure = $CONFIG["smtpsecure"]; 	
			$mail->setFrom($CONFIG["email"], $CONFIG["firmenname"]);
			$mail->addReplyTo($CONFIG["email"], $CONFIG["firmenname"]);
			$mail->addAddress($THIS["email"], $THIS["vorname"], $THIS["nachname"]);			
			$mail->isHTML(true);
			$mail->CharSet = 'utf-8';
			$mail->SetLanguage ("de");	

			if($THIS["lang"] == "en") { 
				// nothing
			}else{
				$mail->Subject = "Gratis 5€ Gutschein für Ihre nächste Fahrt";
				$mail->Body = "
				<div style='width:50%;min-width:300px;margin:auto;padding:50px 0px 50px 0px;'>
					<img src='https://www.vienna-airporttaxi-adam.com/assets/images/logo-inner.png' style='width:100px;'>
					<br><br>
					
					Sehr geehrter Fahrgast!
					<br><br>
					Wir bedanken uns vielmals, dass Sie sich bei Ihrer letzten Fahrt für Adamtaxi entschieden haben und hoffen, Sie hatten einen angenehmen Transfer!
					<br><br>
					Als Dankeschön möchten wir Ihnen gerne einen 5 € Gutschein für Ihre nächste Fahrt bei uns schenken und Sie bitten, uns kurz Ihren Eindruck von unserem Service mitzuteilen. 
					Die Umfrage besteht aus nur 2 Fragen und dauert weniger als eine Minute. Ihren Gutschein können Sie anschließend für eine beliebige Fahrt innerhalb der nächsten 3 Monate nutzen.
					<br><br>
					<a href='".$GLOBAL["linkroot"]."/kundenbewertung?token=".md5(md5($THIS["id"]))."' style='cursor:hand;'> <button style='color:black;background:#FEC619;padding:10px;margin:5px 0px;border:black solid 1px;cursor:hand;border-radius:10px;'>&rArr; Jetzt Gutschein holen</button></a><br>
					<br><br>
					Haben Sie Fragen oder möchten eine andere Fahrt bei uns buchen? Dann ist unser Team gerne täglich telefonisch zu unseren Geschäftszeiten für Sie unter folgender Nummer erreichbar:<br>
					<h3>".$CONFIG["telnr"]."</h3>
					<br>
					Alternativ können Sie direkt auf diese E-Mail antworten oder uns auf unserer Website besuchen:<br>
					<a href='".$GLOBAL["root"]."'>www.vienna-airporttaxi-adam.com</a>
					<br><br>
					Mit freundlichen Grüßen
					<br><br>
					Adam Taxi Wien
				</div>
				";

				$mail->send();
			}

			
		}		

		report("Fahrt archiviert!");
		die(go("?s=".$s));
	}
	elseif($actionsel == "mailneu") {
		if($THIS["autotyp"] == 1) { $fzg = "Standard - Max 2 Personen"; }
		elseif($THIS["autotyp"] == 2) { $fzg = "Kombi - Max 4 Personen"; }
		elseif($THIS["autotyp"] == 3) { $fzg = "Van - Max 8 Personen"; }
		
		if($THIS["typ"] == 1) { $abhol = "Flughafen Wien"; $ziel = $THIS["fahrtziel_adresse"].", ".$THIS["fahrtziel_ort"]; }else{ $abhol = $THIS["fahrtziel_adresse"].", ".$THIS["fahrtziel_ort"]; $ziel = "Flughafen Wien"; }
		
		$extras = "";
		if($THIS["kindersitze"]) { $extras .= $THIS["kindersitze"]." Kindersitze - "; }
		if($THIS["babyschalen"]) { $extras .= $THIS["babyschalen"]." Babyschalen"; }
		if(!$THIS["kindersitze"] && !$THIS["babyschalen"]) { $extras .= "<i>Keine</i>"; }
		
		// Bestätigungsmail Kunde
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = $CONFIG["smtphost"]; 
		$mail->Port = $CONFIG["smtpport"]; 
		$mail->SMTPAuth = true; 
		$mail->Username = $CONFIG["smtpuser"]; 
		$mail->Password = $CONFIG["smtppass"]; 
		$mail->SMTPSecure = $CONFIG["smtpsecure"]; 	
		$mail->setFrom($CONFIG["email"], $CONFIG["firmenname"]);
		$mail->addReplyTo($CONFIG["email"], $CONFIG["firmenname"]);
		$mail->addAddress($THIS["email"], $THIS["vorname"], $THIS["nachname"]);		
		$mail->isHTML(true);
		$mail->CharSet = 'utf-8';
		$mail->SetLanguage ("de");	

		if($THIS["lang"] == "en") {
			$mail->Subject = "Confirmation of your ride";
			$mail->Body = "
			<div style='width:50%;min-width:300px;margin:auto;padding:50px 0px 50px 0px;'>
				<img src='https://www.vienna-airporttaxi-adam.com/assets/images/logo-inner.png' style='width:150px;'>
				<br><br>
				
				Dear passenger!
				<br><br>
				We are happy that you chose us for your ride and will pick you up on ".date('d.m.Y', strtotime($THIS["fahrt_datum"]))." at ".sprintf("%02d", $THIS["fahrt_zeit_h"]).":".sprintf("%02d", $THIS["fahrt_zeit_m"])." 
				in the agreed upon place. In case you can't find your taxi, our driver will call you a few minutes after the agreed meeting time and help you.
				<br><br>
				For your ride there will be billed a fixed rate of ".$THIS["fahrpreis"]." €, no taxameter in use. Please pay your fare in cash after your ride directly to our driver. If you wish you can also pay by debit- or credit-card (third party fees apply) directly in the car.
				<br><br>
				<b>Summary of your booking:</b><br>
				Vehicle: ".$fzg."<br>
				Pickup place: ".$abhol."<br>
				Destination: ".$ziel."<br>
				Extras: ".$extras."
				<br><br>
				In case you want to change or cancel your order, please contact us at least 12 hours before your ride, so we can arrange this for you free of charge.
				<br><br>
				You have questions or want to book another ride? Our team is happy to help you under the following hotline:<br>
				<h3>".$CONFIG["telnr"]."</h3>
				<br>
				Alternatively you can answer directly to this E-Mail or visit:<br>
				<a href='".$GLOBAL["root"]."'>www.vienna-airporttaxi-adam.com</a>
				<br><br>
				King regards,
				<br><br>
				Adam Taxi Vienna
			</div>
			";	
		}else{
			$mail->Subject = "Bestätigung Ihrer Fahrt";
			$mail->Body = "
			<div style='width:50%;min-width:300px;margin:auto;padding:50px 0px 50px 0px;'>
				<img src='https://www.vienna-airporttaxi-adam.com/assets/images/logo-inner.png' style='width:150px;'>
				<br><br>
				
				Sehr geehrter Fahrgast!
				<br><br>
				Wir freuen uns, dass Sie sich für uns entschieden haben und werden Sie wie gewünscht am ".date('d.m.Y', strtotime($THIS["fahrt_datum"]))." um ".sprintf("%02d", $THIS["fahrt_zeit_h"]).":".sprintf("%02d", $THIS["fahrt_zeit_m"])." 
				am vereinbarten Ort abholen. Falls Sie das Taxi nicht finden können, wird unser Fahrer Sie wenige Minuten nach dem vereinbarten Abholtermin telefonisch kontaktieren. 
				<br><br>
				Für Ihre Fahrt wird ein Fixpreis von ".$THIS["fahrpreis"]." € berechnet, es kommt kein Taxameter zur Anwendung. Ihren Fahrpreis bezahlen Sie bitte nach der Fahrt 
				in Bar bei unserem Fahrer. Auf Wunsch können Sie auch im Taxi per Bankomat- oder Kreditkarte bezahlen (zzgl. einer vom Kartenunternehmen berechneten Servicegebühr).
				<br><br>
				<b>Zusammenfassung Ihrer Fahrt:</b><br>
				Fahrzeug: ".$fzg."<br>
				Abholort: ".$abhol."<br>
				Fahrziel: ".$ziel."<br>
				Extras: ".$extras."
				<br><br>
				Sollten sich Ihre Wünsche ändern oder Sie Ihre Fahrt stornieren wollen, bitten wir Sie uns mindestens 12 Stunden vor der Fahrt zu kontaktieren, damit dies kostenfrei möglich ist.
				<br><br>
				Haben Sie Fragen oder möchten eine andere Fahrt bei uns buchen? Dann ist unser Team gerne täglich telefonisch zu unseren Geschäftszeiten für Sie unter folgender Nummer erreichbar:<br>
				<h3>".$CONFIG["telnr"]."</h3>
				<br>
				Alternativ können Sie direkt auf diese E-Mail antworten oder uns auf unserer Website besuchen:<br>
				<a href='".$GLOBAL["root"]."'>www.vienna-airporttaxi-adam.com</a>
				<br><br>
				Mit freundlichen Grüßen
				<br><br>
				Adam Taxi Wien
			</div>
			";
		}

		$mail->send();

		report("Mail erneut gesendet!");
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
		$result = $DB->q("SELECT * FROM fahrten WHERE status = 0 OR status = 4 ORDER BY fahrt_datum, fahrt_zeit_h, fahrt_zeit_m");
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
						</select>
						<input type="submit" value="OK">
					</form>
				</td>
			</tr>
			<tr>
				<td colspan="7" style="padding:0px 0px 0px 10px !important;">
					<small><i>
					Bestellt: <?=$row["erstellt"];?>
					</i></small>
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
			$result = $DB->q("SELECT * FROM fahrten WHERE status != 0 AND status != 4 AND archiviert != 1 ORDER BY fahrt_datum, fahrt_zeit_h, fahrt_zeit_m");
		}else{
			$result = $DB->q("SELECT * FROM fahrten WHERE archiviert != 1 AND status != 0 AND status != 4 AND fahrer = '".$bestandsfilter."' ORDER BY fahrt_datum, fahrt_zeit_h, fahrt_zeit_m");
		}

		
		while($row = mysqli_fetch_array($result)) {
			$result2 = $DB->q("SELECT * FROM gutscheine WHERE id = '".$row["gutschein"]."'");
			$gsexist = mysqli_num_rows($result2);
			if($gsexist){ $GS = mysqli_fetch_array($result2); }
			?>
			<tr <?if($row["status"] == 3){ echo 'style="background:#E6E6E6;"';}elseif($row["status"] == 2){ echo 'style="background:#A9F5A9;"';}elseif($row["status"] == 5){ echo 'style="background:#BCA9F5;"';}?>>
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
				</td>
				<td>
						<?
						$result2 = $DB->q("SELECT * FROM admins WHERE id = '".$row["fahrer"]."'");
						$FAHRER = mysqli_fetch_array($result2);
						?>
						<?=$FAHRER["nachname"];?> <?=$FAHRER["vorname"];?>
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
			<?
			if($row["status"] == 5) { 
				$result3 = $DB->q("SELECT * FROM fahrten_probleme WHERE fahrt = '".$row["id"]."' AND fahrer = '".$row["fahrer"]."'");
				$PROB = mysqli_fetch_array($result3);
				$result4 = $DB->q("SELECT * FROM admins WHERE id = '".$row["fahrer"]."'");
				$FAHR = mysqli_fetch_array($result4);
				?>
				<tr style="background:#BCA9F5;">
					<td colspan="9" style="padding:0px 0px 0px 10px !important;">
						<small><i>
						! <?=$PROB["text"];?>. Gemeldet von <?=$FAHR["nachname"];?> <?=$FAHR["vorname"];?> am <?=$PROB["zeitpunkt_gemeldet"];?> !
						</i></small>
					</td>
				</tr>
				<?
			}
		}
		?>
	</table>
</div>

<br style="clear:both;"><br style="clear:both;"><br style="clear:both;">