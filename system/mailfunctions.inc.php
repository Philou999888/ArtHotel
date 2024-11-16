<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function SendStornoMailKunde($FAHRT) {
	global $CONFIG;
	global $GLOBAL;

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
	$mail->addAddress($FAHRT["email"], $FAHRT["vorname"], $FAHRT["nachname"]);		
	$mail->isHTML(true);
	$mail->CharSet = 'utf-8';
	$mail->SetLanguage ("de");	

	if($FAHRT["lang"] == "en") {
		$mail->Subject = "Cancellation of your ride";
		$mail->Body = "
		<div style='width:50%;min-width:300px;margin:auto;padding:50px 0px 50px 0px;'>
			<img src='https://www.vienna-airporttaxi-adam.com/assets/images/logo-inner.png' style='width:150px;'>
			<br><br>
			
			Dear passenger!
			<br><br>
			We regret to inform your that your ride on ".date('d.m.Y', strtotime($FAHRT["fahrt_datum"]))." at ".sprintf("%02d", $FAHRT["fahrt_zeit_h"]).":".sprintf("%02d", $FAHRT["fahrt_zeit_m"])." has been cancelled. We wish you a very pleasant journey and would be happy to welcome you back at another time as our passenger.
			<br><br>
			You have questions or want to book another ride? Our team is happy to help you under the following hotline:<br>
			<h3>".$CONFIG["telnr"]."</h3>
			<br>
			Alternatively you can answer directly to FAHRT E-Mail or visit:<br>
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
			Wir bedauern, dass wir Ihre Fahrt am ".date('d.m.Y', strtotime($FAHRT["fahrt_datum"]))." um ".sprintf("%02d", $FAHRT["fahrt_zeit_h"]).":".sprintf("%02d", $FAHRT["fahrt_zeit_m"])." stornieren mussten. Wir wünschen Ihnen dennoch eine angenehme Reise und würden uns freuen, Sie in Zukunft bald wieder bei uns als Fahrgast begrüßen zu dürfen.
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
}

function SendEarlyConfirmKunde($FAHRT) {
	global $CONFIG;
	global $GLOBAL;

	if($FAHRT["autotyp"] == 1) { $fzg = "Standard - Max 2 Personen"; }
	elseif($FAHRT["autotyp"] == 2) { $fzg = "Kombi - Max 4 Personen"; }
	elseif($FAHRT["autotyp"] == 3) { $fzg = "Van - Max 8 Personen"; }
	
	$extras = "";
	if($FAHRT["kindersitze"]) { $extras .= $FAHRT["kindersitze"]." Kindersitze - "; }
	if($FAHRT["babyschalen"]) { $extras .= $FAHRT["babyschalen"]." Babyschalen"; }
	if(!$FAHRT["kindersitze"] && !$FAHRT["babyschalen"]) { $extras .= "<i>Keine</i>"; }

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
	$mail->addAddress($FAHRT["email"], $FAHRT["vorname"], $FAHRT["nachname"]);		
	$mail->isHTML(true);
	$mail->CharSet = 'utf-8';
	$mail->SetLanguage ("de");	

	if($FAHRT["lang"] == "en") {
		$mail->Subject = "We received your booking!";
		$mail->Body = "
		<div style='width:50%;min-width:300px;margin:auto;padding:50px 0px 50px 0px;'>
			<img src='https://www.vienna-airporttaxi-adam.com/assets/images/logo-inner.png' style='width:150px;'>
			<br><br>
			
			Dear passenger!
			<br><br>
			We received your request for a ride with Adamtaxi on ".date('d.m.Y', strtotime($FAHRT["fahrt_datum"]))." at ".sprintf("%02d", $FAHRT["fahrt_zeit_h"]).":".sprintf("%02d", $FAHRT["fahrt_zeit_m"]).". 
			<br><br>
			Our system will now find the perfect driver for you and confirm once the booking has been accepted. Usually this happens within 60 minutes of your booking, but can sometimes take up to two hours (especially at night time or holidays). 
			For your ride there will be billed a fixed rate of ".$FAHRT["fahrpreis"]." €, no taxameter in use. Please pay your fare in cash after your ride directly to our driver. If you wish you can also pay by debit- or credit-card (third party fees apply) directly in the car.
			<br><br>
			<b>Summary of your booking:</b><br>
			Vehicle: ".$fzg."<br>
			From: ".$FAHRT["von_adresse"]." ".$FAHRT["von_ort"]."<br>
			To: ".$FAHRT["zu_adresse"]." ".$FAHRT["zu_ort"]."<br>
			Extras: ".$extras."
			<br><br>
			In case you want to change or cancel your order, please contact us at least 12 hours before your ride, so we can arrange for you free of charge.
			<br><br>
			<b>Please make sure to turn on your phone before your designated pickup time! Our driver will call you on arrival and confirm the exact meeting place.</b>
			<br><br>
			For pickup at the airport: Be sure to get into the right Taxi. Ask the driver for whom he is waiting. If you use a taxi from another company you might end up paying much more than our price and are still liable to pay for your (not used) ride with Adamtaxi.</b>
			<br>
			If you have any questions or wish to book another ride you can answer directly to this E-Mail or visit:<br>
			<a href='".$GLOBAL["root"]."'>www.vienna-airporttaxi-adam.com</a>
			<br><br>
			King regards,
			<br><br>
			Adam Taxi Vienna
		</div>
		";	
	}else{
		$mail->Subject = "Fahrtbuchung erhalten";
		$mail->Body = "
		<div style='width:50%;min-width:300px;margin:auto;padding:50px 0px 50px 0px;'>
			<img src='https://www.vienna-airporttaxi-adam.com/assets/images/logo-inner.png' style='width:150px;'>
			<br><br>
			
			Sehr geehrter Fahrgast!
			<br><br>
			Wir haben Ihre Buchung für Ihre Fahrt am ".date('d.m.Y', strtotime($FAHRT["fahrt_datum"]))." um ".sprintf("%02d", $FAHRT["fahrt_zeit_h"]).":".sprintf("%02d", $FAHRT["fahrt_zeit_m"])." 
			erhalten. Unser System sucht nun den passenden Fahrer für Sie und wird Sie automatisch verständigen, sobald Ihre Buchung aktzeptiert wurde. Dies geschieht normalerweise innerhalb von 60 Minuten, kann aber unter manchen Umstände (Nachts, Feiertags) auch etwas länger dauern. 
			<br><br>
			Für Ihre Fahrt wird ein Fixpreis von ".$FAHRT["fahrpreis"]." € berechnet, es kommt kein Taxameter zur Anwendung. Ihren Fahrpreis bezahlen Sie bitte nach der Fahrt 
			in Bar bei unserem Fahrer. Auf Wunsch können Sie auch im Taxi per Bankomat- oder Kreditkarte bezahlen (zzgl. einer vom Kartenunternehmen berechneten Servicegebühr).
			<br><br>
			<b>Zusammenfassung Ihrer Fahrt:</b><br>
			Fahrzeug: ".$fzg."<br>
			Abholort: ".$FAHRT["von_adresse"]." ".$FAHRT["von_ort"]."<br>
			Fahrtziel: ".$FAHRT["zu_adresse"]." ".$FAHRT["zu_ort"]."<br>
			Extras: ".$extras."
			<br><br>
			Sollten sich Ihre Wünsche ändern oder Sie Ihre Fahrt stornieren wollen, bitten wir Sie uns mindestens 12 Stunden vor der Fahrt zu kontaktieren, damit dies kostenfrei möglich ist.
			<br><br>
			<b>Bitte schalten Sie zur Abholung unbedingt Ihr Handy ein! Unser Fahrer wird Sie wenige Minuten vor Eintreffen anrufen, um den genauen Treffpunkt zu bestätigen.</b>
			<br><br>
			Bei Abholungen vom Flughafen gehen Sie bitte sicher, dass Sie in das richtige Taxi steigen. Fragen Sie den Fahrer, auf wen er wartet. 
			Wenn Sie ein anderes Taxi nutzen, zahlen Sie möglicherweise deutlich mehr als den mit uns vereinbarten Preis und müssen dennoch Ihre (nicht angetretene) Fahrt bei Adamtaxi bezahlen.</b>
			<br><br>
			Haben Sie Fragen oder möchten eine andere Fahrt bei uns buchen? 
			Dann können Sie direkt auf diese E-Mail antworten oder uns auf unserer Website besuchen:<br>
			<a href='".$GLOBAL["root"]."'>www.vienna-airporttaxi-adam.com</a>
			<br><br>
			Mit freundlichen Grüßen
			<br><br>
			Adam Taxi Wien
		</div>
		";
	}

	$mail->send();
}


function SendAuftragsMailKunde($FAHRT) {
	global $CONFIG;
	global $GLOBAL;

	if($FAHRT["autotyp"] == 1) { $fzg = "Standard - Max 2 Personen"; }
	elseif($FAHRT["autotyp"] == 2) { $fzg = "Kombi - Max 4 Personen"; }
	elseif($FAHRT["autotyp"] == 3) { $fzg = "Van - Max 8 Personen"; }
	
	$extras = "";
	if($FAHRT["kindersitze"]) { $extras .= $FAHRT["kindersitze"]." Kindersitze - "; }
	if($FAHRT["babyschalen"]) { $extras .= $FAHRT["babyschalen"]." Babyschalen"; }
	if(!$FAHRT["kindersitze"] && !$FAHRT["babyschalen"]) { $extras .= "<i>Keine</i>"; }

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
	$mail->addAddress($FAHRT["email"], $FAHRT["vorname"], $FAHRT["nachname"]);		
	$mail->isHTML(true);
	$mail->CharSet = 'utf-8';
	$mail->SetLanguage ("de");	

	if($FAHRT["lang"] == "en") {
		$mail->Subject = "Confirmation of your ride";
		$mail->Body = "
		<div style='width:50%;min-width:300px;margin:auto;padding:50px 0px 50px 0px;'>
			<img src='https://www.vienna-airporttaxi-adam.com/assets/images/logo-inner.png' style='width:150px;'>
			<br><br>
			
			Dear passenger!
			<br><br>
			We are happy that you chose us for your ride and will pick you up on ".date('d.m.Y', strtotime($FAHRT["fahrt_datum"]))." at ".sprintf("%02d", $FAHRT["fahrt_zeit_h"]).":".sprintf("%02d", $FAHRT["fahrt_zeit_m"])." 
			in the agreed upon place. 
			<br><br>
			For your ride there will be billed a fixed rate of ".$FAHRT["fahrpreis"]." €, no taxameter in use. Please pay your fare in cash after your ride directly to our driver. If you wish you can also pay by debit- or credit-card (third party fees apply) directly in the car.
			<br><br>
			<b>Summary of your booking:</b><br>
			Vehicle: ".$fzg."<br>
			From: ".$FAHRT["von_adresse"]." ".$FAHRT["von_ort"]."<br>
			To: ".$FAHRT["zu_adresse"]." ".$FAHRT["zu_ort"]."<br>
			Extras: ".$extras."
			<br><br>
			In case you want to change or cancel your order, please contact us at least 12 hours before your ride, so we can arrange FAHRT for you free of charge.
			<br><br>
			<b>Please make sure to turn on your phone before your designated pickup time! Our driver will call you on arrival and confirm the exact meeting place.</b>
			<br><br>
			For pickup at the airport: Be sure to get into the right Taxi. Ask the driver for whom he is waiting. If you use a taxi from another company you might end up paying much more than our price and are still liable to pay for your (not used) ride with Adamtaxi.</b>
			<br>
			You have questions or want to book another ride? Our team is happy to help you under the following hotline:<br>
			<h3>".$CONFIG["telnr"]."</h3>
			<br>
			Alternatively you can answer directly to FAHRT E-Mail or visit:<br>
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
			Wir freuen uns, dass Sie sich für uns entschieden haben und werden Sie wie gewünscht am ".date('d.m.Y', strtotime($FAHRT["fahrt_datum"]))." um ".sprintf("%02d", $FAHRT["fahrt_zeit_h"]).":".sprintf("%02d", $FAHRT["fahrt_zeit_m"])." 
			am vereinbarten Ort abholen. 
			<br><br>
			Für Ihre Fahrt wird ein Fixpreis von ".$FAHRT["fahrpreis"]." € berechnet, es kommt kein Taxameter zur Anwendung. Ihren Fahrpreis bezahlen Sie bitte nach der Fahrt 
			in Bar bei unserem Fahrer. Auf Wunsch können Sie auch im Taxi per Bankomat- oder Kreditkarte bezahlen (zzgl. einer vom Kartenunternehmen berechneten Servicegebühr).
			<br><br>
			<b>Zusammenfassung Ihrer Fahrt:</b><br>
			Fahrzeug: ".$fzg."<br>
			Abholort: ".$FAHRT["von_adresse"]." ".$FAHRT["von_ort"]."<br>
			Fahrtziel: ".$FAHRT["zu_adresse"]." ".$FAHRT["zu_ort"]."<br>
			Extras: ".$extras."
			<br><br>
			Sollten sich Ihre Wünsche ändern oder Sie Ihre Fahrt stornieren wollen, bitten wir Sie uns mindestens 12 Stunden vor der Fahrt zu kontaktieren, damit dies kostenfrei möglich ist.
			<br><br>
			<b>Bitte schalten Sie zur Abholung unbedingt Ihr Handy ein! Unser Fahrer wird Sie wenige Minuten vor Eintreffen anrufen, um den genauen Treffpunkt zu bestätigen.</b>
			<br><br>
			Bei Abholungen vom Flughafen gehen Sie bitte sicher, dass Sie in das richtige Taxi steigen. Fragen Sie den Fahrer, auf wen er wartet. 
			Wenn Sie ein anderes Taxi nutzen, zahlen Sie möglicherweise deutlich mehr als den mit uns vereinbarten Preis und müssen dennoch Ihre (nicht angetretene) Fahrt bei Adamtaxi bezahlen.</b>
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
}

function SendAuftragsMailFahrer($FAHRT, $FAHRER) {
	global $CONFIG;
	global $GLOBAL;

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
}

function SendAuftragsMailSupervisor($SUPERVIS) {
	global $CONFIG;
	global $GLOBAL;
	global $DB;
	
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
	$mail->addAddress($SUPERVIS["email"], $SUPERVIS["vorname"], $SUPERVIS["nachname"]);
	$mail->Subject = "Neue Bestellung für Supervisor";
	$mail->isHTML(true);
	$mail->CharSet = 'utf-8';
	$mail->SetLanguage ("de");	
	$mail->Body = "
	<div style='width:50%;min-width:300px;margin:auto;padding:50px 0px 50px 0px;'>
		<img src='https://www.vienna-airporttaxi-adam.com/assets/images/logo-inner.png' style='width:150px;'>
		<br><br>
		
		Lieber Supervisor,
		<br><br>
		Es wurde soeben eine neue Fahrt bestellt, die auf Zuteilung wartet.
		<br><br>
		Mit freundlichen Grüßen
		<br><br>
		Adam Taxi Wien
	</div>
	";
	$mail->send();
}

function SendGutscheinUmfrageMailKunde($FAHRT) {
	global $CONFIG;
	global $GLOBAL;

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
	$mail->addAddress($FAHRT["email"], $FAHRT["vorname"], $FAHRT["nachname"]);			
	$mail->isHTML(true);
	$mail->CharSet = 'utf-8';
	$mail->SetLanguage ("de");	

	if($FAHRT["lang"] == "en") { 
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
			<a href='".$GLOBAL["linkroot"]."/kundenbewertung?token=".md5(md5($FAHRT["id"]))."' style='cursor:hand;'> <button style='color:black;background:#FEC619;padding:10px;margin:5px 0px;border:black solid 1px;cursor:hand;border-radius:10px;'>&rArr; Jetzt Gutschein holen</button></a><br>
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

function SendGutscheinMailKunde($FAHRT, $gs) {
	global $CONFIG;
	global $GLOBAL;

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
	$mail->addAddress($FAHRT["email"], $FAHRT["vorname"], $FAHRT["nachname"]);			
	$mail->isHTML(true);
	$mail->CharSet = 'utf-8';
	$mail->SetLanguage ("de");	

	if($FAHRT["lang"] == "en") { 
		// nothing
	}else{
		$mail->Subject = "Ihr 5€ Gutschein für die nächste Fahrt";
		$mail->Body = "
		<div style='width:50%;min-width:300px;margin:auto;padding:50px 0px 50px 0px;'>
			<img src='".$GLOBAL["root"]."assets/images/logo-inner.png' style='width:150px;'>
			<br><br>
			
			Sehr geehrter Fahrgast!
			<br><br>
			Wir bedanken uns für Ihre Mithilfe an der Verbesserung unseres Services!
			<br><br>
			Sie können Ihren Gutschein über folgende Links einlösen:
			<br><br>
			<a href='".$GLOBAL["linkroot"]."/vom-flughafen?gs=".$gs."' style='cursor:hand;'> <button style='color:black;background:#FEC619;padding:10px;margin:5px 0px;border:black solid 1px;cursor:hand;border-radius:10px;'>&rArr; Gutschein - Vom Flughafen holen</button></a><br>
			<a href='".$GLOBAL["linkroot"]."/zum-flughafen?gs=".$gs."' style='cursor:hand;'> <button style='color:black;background:#FEC619;padding:10px;margin:5px 0px;border:black solid 1px;cursor:hand;border-radius:10px;'>&rArr; Gutschein - Zum Flughafen bringen</button></a>
			<br><br>
			Falls Sie Unterstützung brauchen, rufen Sie uns gerne jederzeit an.<br>
			<b>Ihr Gutschein Code lautet: ".$gs."</b>
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

function SendStornoRechnungMailKunde($FAHRT, $RECHN) {
	global $CONFIG;
	global $GLOBAL;
	
	$billpath = "storage/ausgangsrechnungen/ATX".$RECHN["id"].".pdf";

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
	$mail->addAddress($FAHRT["email"], $FAHRT["vorname"], $FAHRT["nachname"]);		
	$mail->isHTML(true);
	$mail->CharSet = 'utf-8';
	$mail->SetLanguage ("de");	
	$mail->addAttachment($billpath, 'Bill-'.$FAHRT["nachname"].'.pdf');	

	if($FAHRT["lang"] == "en") {
		$mail->Subject = "Cancellation Bill for your ride";
		$mail->Body = "
		<div style='width:50%;min-width:300px;margin:auto;padding:50px 0px 50px 0px;'>
			<img src='https://www.vienna-airporttaxi-adam.com/assets/images/logo-inner.png' style='width:150px;'>
			<br><br>
			
			Dear Mr. / Ms. ".$FAHRT["nachname"].",
			<br><br>
			since you did not participate in the booked and confirmed ride on ".date('d.m.Y', strtotime($FAHRT["fahrt_datum"]))." at ".sprintf("%02d", $FAHRT["fahrt_zeit_h"]).":".sprintf("%02d", $FAHRT["fahrt_zeit_m"])." and we were not able to reach you for clarification, we hereby send you the bill for the trip fare.
			<br><br>
			Please note that bookings from our online formular are legally binding and we reserve a spot for you in our system which prevents other guests from booking.
			Therefore we have to charche the full trip fare amount. In case that you change your plans, you can always cancel the pickup until 12 hours before the designated time of pickup to save on unnecesary costs.
			<br><br>
			Please make sure to pay the bill on time to prevent it going to our international debt collection partner which can come with high additional costs.
			<br><br>
			If you have any questions, you can answer directly to this E-Mail and our support will get back to you as soon as possible.
			<br><br>
			King regards,
			<br><br>
			Adam Taxi Vienna
		</div>
		";	
	}else{
		$mail->Subject = "Stornorechnung für Ihre Fahrt";
		$mail->Body = "
		<div style='width:50%;min-width:300px;margin:auto;padding:50px 0px 50px 0px;'>
			<img src='https://www.vienna-airporttaxi-adam.com/assets/images/logo-inner.png' style='width:150px;'>
			<br><br>
			
			Sehr geehrte/r Herr/Frau ".$FAHRT["nachname"].",
			<br><br>
			da Sie Ihre bei uns gebuchte und bestätigte Fahrt am ".date('d.m.Y', strtotime($FAHRT["fahrt_datum"]))." um ".sprintf("%02d", $FAHRT["fahrt_zeit_h"]).":".sprintf("%02d", $FAHRT["fahrt_zeit_m"])." nicht angetreten haben und wir Sie nicht erreich konnten, übermitteln wir Ihnen hiermit im Anhang die Rechnung über den angefallenen Fahrpreis.
			<br><br>
			Beachten Sie bitte, dass Bestellungen über unser Onlineformular rechtsverbindlich sind und Sie, wenn Sie die Fahrt ohne Stornierung nicht antreten, den Fahrpreis in voller Höhe zu zahlen schuldig sind.
			<br><br>
			Um derartige Unannehmlichkeiten in Zukunft zu vermeiden bitten wir Sie, nur Fahrten zu bestellen welche Sie sicher antreten werden bzw. uns innerhalb der vorgesehenen Stornierungsfrist von 12 Stunden abzusagen, damit unsere Fahrer nicht grundlos zum Abholort fahren.
			<br><br>
			Mit freundlichen Grüßen
			<br><br>
			Adam Taxi Wien
		</div>
		";
	}

	$mail->send();
}




?>