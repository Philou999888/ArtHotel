<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include("mailfunctions.inc.php");


function Protokoll($text, $fahrer="0", $fahrt="0", $provision="0") {
	global $DB;

	$result = $DB->q("INSERT INTO protokoll SET 
		text = '".$text."', 
		fahrer = '".$fahrer."', 
		fahrt = '".$fahrt."', 
		provision = '".$provision."'");
}

function CreateActionToken() {
	global $DB;

	$code = md5(time())."-".rand(1,1000)."-".rand(1,1000)."-".rand(1,1000);
	$result = $DB->q("INSERT INTO actiontokens SET 
		code = '".$code."'");

	return $code;
}

function ActionTokenIsUnused($code) {
	global $DB;

	$result = $DB->q("SELECT * FROM actiontokens WHERE code = '".$code."' AND genutzt = 0");
	$exist = mysqli_num_rows($result);

	if($exist) {
		return true;
	}else{
		return false;
	}
}

function ActionTokenUsed($code) {
	global $DB;

	$result = $DB->q("UPDATE actiontokens SET genutzt = 1, zeitpunkt_genutzt = NOW() WHERE code = '".$code."'");
}

function GetAdminById($id) {
	global $DB;

	$result = $DB->q("SELECT * FROM admins WHERE id = '".$id."'");
	$ADM = mysqli_fetch_array($result);

	return $ADM;
}

function GutscheinErstellen($wert, $ablauf) {
	global $DB;
	
	for ($x = 0; $x <= 1000; $x++) {
		$code = strtoupper(substr(md5(time()+rand(1,100)), 0, 10));	
		$result = $DB->q("SELECT * FROM gutscheine WHERE code = '".$code."'");
		$exist = mysqli_num_rows($result);
		if(!$exist) { break; }
	}

	$result = $DB->q("INSERT INTO gutscheine SET 
		code = '".$code."', 
		wert = '".$wert."', 
		ablauf = '".$ablauf."'");
		
	return $code;
}

function mysqli_field_name($result, $field_offset)
{
    $properties = mysqli_fetch_field_direct($result, $field_offset);
    return is_object($properties) ? $properties->name : null;
}

function go($site)
{
	?>
	<script>
	window.location.href = '<?=$site;?>';
	</script>
	<?
}

function go_v($site,$time)
{
echo "<meta http-equiv=\"refresh\" content=\"$time; URL=$site\">";
}

function jsreport($output)
{
?>
<script>
sweetAlert("<?=$output;?>");
</script>
<?php
}

function report($output)
{
?>
<script language="javascript">
alert(unescape("<?php echo $output;?>"));
</script>
<?php
}

function swal($in1, $in2, $in3)
{
?>
<script>
sweetAlert("<?=$in1;?>", "<?=$in2;?>", "<?=$in3;?>");
</script>
<?php
}

function IsMobile() {

$useragent = $_SERVER['HTTP_USER_AGENT'];

if(preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) { return true; }

}

function DbAutoDump($CONFIG) {	
	$dbhost = $CONFIG["dbhost"];
	$dbuser = $CONFIG["dbuser"];
	$dbpassword = $CONFIG["dbpass"];
	$dbname = $CONFIG["dbname"];
	 
	$dumpfile = "backup/autodumps/autodump_".$dbname."_".date("Y-m-d_H-i-s").".sql";
	exec("mysqldump --user=$dbuser --password=$dbpassword --host=$dbhost $dbname > $dumpfile");
	
	if(file_exists($dumpfile)) {
		return $dumpfile;
	}else{
		return false;
	}
}

function ParseTextvorlagen($input, $BESTELLUNG, $RECHNUNG, $CFG, $TEXTVORLAGEN, $dlink) {	
	$output = $input;
	$output = str_replace("[[Vorname]]", $BESTELLUNG["firstname"], $output);
	$output = str_replace("[[Nachname]]", $BESTELLUNG["lastname"], $output);
	$output = str_replace("[[Downloadlink]]", $dlink, $output);
	$output = str_replace("[[Produktpreis]]", $CFG["produktpreis_symbol"]." ".$CFG["produktpreis"], $output);
	$output = str_replace("[[Rechnungsbetrag]]", $CFG["produktpreis_symbol"]." ".$RECHNUNG["amount"], $output);
	$output = str_replace("[[Bankverbindung]]", $CFG["bankverbindung"], $output);
	$output = str_replace("[[MailSignatur]]", $TEXTVORLAGEN["mail_signatur"], $output);
	$output = str_replace("[[Transaktionsnummer]]", $CFG["bank_prefix"].$RECHNUNG["id"], $output);	
	
	return $output;
}

function StornoRechnungPdfErstellen($FAHRT, $RECHN) {
	global $DB;
	global $GLOBAL;
	global $CONFIG;
	
	$rechnungs_nummer = "ATX".$RECHN["id"];
	$rechnungs_datum = date("d.m.Y");
	$pdfAuthor = $CONFIG["firmenname"];
	
	
	if($FAHRT["lang"] == "en") {
		$rechnungs_header = '
		<img src="'.$GLOBAL["root"].'assets/images/logo-inner.png"><br>
		'.$CONFIG["impressum"];

		$rechnungs_empfaenger = $FAHRT["vorname"]." ".$FAHRT["nachname"].'<br>'.$FAHRT["email"];

		$rechnungs_footer = "Please pay the bill in full within 7 days after the bills time stamp.For payment, use the bank account below. If you wish to use another payment method (such as Paypal) contact our support and we will assist you. 
		When using bank transfer, please use the following as payment reference: <b>".$rechnungs_nummer."</b>.
		<br><br>
		".$CONFIG["bankverbindung"]."
		<br><br>
		
		If you have any questions contact us at: office@vienna-airporttaxi-adam.com
		<br><br>
		
		Sincerly,<br>
		Team Adamtaxi";

		//Auflistung eurer verschiedenen Posten im Format [Produktbezeichnuns, Menge, Einzelpreis]
		$rechnungs_posten = array(
			array("No-Show ride on ".$FAHRT["fahrt_datum"], 1, $FAHRT["fahrpreis"]));

		//Höhe eurer Umsatzsteuer. 0.19 für 19% Umsatzsteuer
		$umsatzsteuer = 0.1; 

		$pdfName = $rechnungs_nummer.".pdf";


		//////////////////////////// Inhalt des PDFs als HTML-Code \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


		// Erstellung des HTML-Codes. Dieser HTML-Code definiert das Aussehen eures PDFs.
		// tcpdf unterstützt recht viele HTML-Befehle. Die Nutzung von CSS ist allerdings
		// stark eingeschränkt.

		$html = '
		<table cellpadding="5" cellspacing="0" style="width: 100%; ">
			<tr>
				<td>'.trim($rechnungs_header).'</td>
			   <td style="text-align: right">
		Bill No.: '.$rechnungs_nummer.'<br>
		Bill Date: '.$rechnungs_datum.'<br>
				</td>
			</tr>

			<tr>
				 <td style="font-size:1.3em; font-weight: bold;">
		<br><br>
		Bill
		<br>
				 </td>
			</tr>


			<tr>
				<td colspan="2"><b>Customer:</b><br>'.trim($rechnungs_empfaenger).'<br><small><i>(Residency not investigated)</i></small></td>
			</tr>
		</table>
		<br><br><br>

		<table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">
			<tr style="background-color: #cccccc; padding:5px;">
				<td style="padding:5px;"><b>Description</b></td>
				<td style="text-align: center;"><b>Amount</b></td>
				<td style="text-align: center;"><b>Unit Price</b></td>
				<td style="text-align: center;"><b>Price</b></td>
			</tr>';
					
			
		$gesamtpreis = 0;

		foreach($rechnungs_posten as $posten) {
			$menge = $posten[1];
			$einzelpreis = $posten[2];
			$preis = $menge*$einzelpreis;
			$gesamtpreis += $preis;
			$html .= '<tr>
						<td>'.$posten[0].'</td>
						<td style="text-align: center;">'.$posten[1].'</td>		
						<td style="text-align: center;">'.number_format($posten[2], 2, ',', '').' Euro</td>	
						<td style="text-align: center;">'.number_format($preis, 2, ',', '').' Euro</td>
					  </tr>';
		}
		$html .="</table>";



		$html .= '
		<hr>
		<table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">';
		if($umsatzsteuer > 0) {
			$netto = $gesamtpreis / (1+$umsatzsteuer);
			$umsatzsteuer_betrag = $gesamtpreis - $netto;
			
			$html .= '
					<tr>
						<td colspan="3">Subtotal (Net)</td>
						<td style="text-align: center;">'.number_format($netto , 2, ',', '').' Euro</td>
					</tr>
					<tr>
						<td colspan="3">Tax ('.intval($umsatzsteuer*100).'%)</td>
						<td style="text-align: center;">'.number_format($umsatzsteuer_betrag, 2, ',', '').' Euro</td>
					</tr>';
		}

		$html .='
					<tr>
						<td colspan="3"><b>Total: </b></td>
						<td style="text-align: center;"><b>'.number_format($gesamtpreis, 2, ',', '').' Euro</b></td>
					</tr>			
				</table>
		<br><br>
		
		<br>';

		if($umsatzsteuer == 0) {
			$html .= 'Nach § 6 Abs. 1 UStG wird keine Umsatzsteuer verrechnet.<br><br>';
		}
		
	}else{
		$rechnungs_header = '
		<img src="'.$GLOBAL["root"].'assets/images/logo-inner.png"><br>
		'.$CONFIG["impressum"];

		$rechnungs_empfaenger = $FAHRT["vorname"]." ".$FAHRT["nachname"].'<br>'.$FAHRT["email"];

		$rechnungs_footer = "Wir bitten um Begleichung der Rechnung innerhalb von 7 Tagen nach Erhalt. Bitte überweisen Sie den vollständigen Betrag an die untenstehende Bankverbindung. 
		Geben Sie bei der Überweisung unbedingt die folgende Rechnungenummer an: <b>".$rechnungs_nummer."</b>, damit Ihre Zahlung zugeordnet werden kann.
		<br><br>
		".$CONFIG["bankverbindung"]."
		<br><br>
		
		Bei Fragen wenden Sie sich bitte per E-Mail an: office@vienna-airporttaxi-adam.com
		<br><br>
		
		Herzliche Grüße,<br>
		Team Adamtaxi";

		//Auflistung eurer verschiedenen Posten im Format [Produktbezeichnuns, Menge, Einzelpreis]
		$rechnungs_posten = array(
			array("Nicht angetretene Fahrt vom ".$FAHRT["fahrt_datum"], 1, $FAHRT["fahrpreis"]));

		//Höhe eurer Umsatzsteuer. 0.19 für 19% Umsatzsteuer
		$umsatzsteuer = 0.1; 

		$pdfName = $rechnungs_nummer.".pdf";


		//////////////////////////// Inhalt des PDFs als HTML-Code \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


		// Erstellung des HTML-Codes. Dieser HTML-Code definiert das Aussehen eures PDFs.
		// tcpdf unterstützt recht viele HTML-Befehle. Die Nutzung von CSS ist allerdings
		// stark eingeschränkt.

		$html = '
		<table cellpadding="5" cellspacing="0" style="width: 100%; ">
			<tr>
				<td>'.trim($rechnungs_header).'</td>
			   <td style="text-align: right">
		Rechnungsnummer: '.$rechnungs_nummer.'<br>
		Rechnungsdatum: '.$rechnungs_datum.'<br>
				</td>
			</tr>

			<tr>
				 <td style="font-size:1.3em; font-weight: bold;">
		<br><br>
		Rechnung
		<br>
				 </td>
			</tr>


			<tr>
				<td colspan="2"><b>Kunde:</b><br>'.trim($rechnungs_empfaenger).'<br><small><i>(Keine Wohnsitzerhebung durchgeführt)</i></small></td>
			</tr>
		</table>
		<br><br><br>

		<table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">
			<tr style="background-color: #cccccc; padding:5px;">
				<td style="padding:5px;"><b>Bezeichnung</b></td>
				<td style="text-align: center;"><b>Menge</b></td>
				<td style="text-align: center;"><b>Einzelpreis</b></td>
				<td style="text-align: center;"><b>Preis</b></td>
			</tr>';
					
			
		$gesamtpreis = 0;

		foreach($rechnungs_posten as $posten) {
			$menge = $posten[1];
			$einzelpreis = $posten[2];
			$preis = $menge*$einzelpreis;
			$gesamtpreis += $preis;
			$html .= '<tr>
						<td>'.$posten[0].'</td>
						<td style="text-align: center;">'.$posten[1].'</td>		
						<td style="text-align: center;">'.number_format($posten[2], 2, ',', '').' Euro</td>	
						<td style="text-align: center;">'.number_format($preis, 2, ',', '').' Euro</td>
					  </tr>';
		}
		$html .="</table>";



		$html .= '
		<hr>
		<table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">';
		if($umsatzsteuer > 0) {
			$netto = $gesamtpreis / (1+$umsatzsteuer);
			$umsatzsteuer_betrag = $gesamtpreis - $netto;
			
			$html .= '
					<tr>
						<td colspan="3">Zwischensumme (Netto)</td>
						<td style="text-align: center;">'.number_format($netto , 2, ',', '').' Euro</td>
					</tr>
					<tr>
						<td colspan="3">Umsatzsteuer ('.intval($umsatzsteuer*100).'%)</td>
						<td style="text-align: center;">'.number_format($umsatzsteuer_betrag, 2, ',', '').' Euro</td>
					</tr>';
		}

		$html .='
					<tr>
						<td colspan="3"><b>Gesamtsumme: </b></td>
						<td style="text-align: center;"><b>'.number_format($gesamtpreis, 2, ',', '').' Euro</b></td>
					</tr>			
				</table>
		<br><br>
		
		<br>';

		if($umsatzsteuer == 0) {
			$html .= 'Nach § 6 Abs. 1 UStG wird keine Umsatzsteuer verrechnet.<br><br>';
		}
	}



	$html .= $rechnungs_footer;



	//////////////////////////// Erzeugung eures PDF Dokuments \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

	// TCPDF Library laden
	require_once('assets/tcpdf/tcpdf.php');

	// Erstellung des PDF Dokuments
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// Dokumenteninformationen
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor($pdfAuthor);
	$pdf->SetTitle('Rechnung '.$rechnungs_nummer);
	$pdf->SetSubject('Rechnung '.$rechnungs_nummer);


	// Header und Footer Informationen
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// Auswahl des Font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// Auswahl der MArgins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// Automatisches Autobreak der Seiten
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// Image Scale 
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// Schriftart
	$pdf->SetFont('dejavusans', '', 10);

	// Rechnungsseite erstellen
	$pdf->AddPage();
	$pdf->writeHTML($html, true, false, true, false, '');
	
	//Ausgabe der PDF

	//Variante 1: PDF direkt an den Benutzer senden:
	//$pdf->Output($pdfName, 'I');

	//Variante 2: PDF im Verzeichnis abspeichern:
	$pdf->Output(dirname(__FILE__).'/../storage/ausgangsrechnungen/'.$pdfName, 'F');
	//echo 'PDF herunterladen: <a href="'.$pdfName.'">'.$pdfName.'</a>';
	
}


?>