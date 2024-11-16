<?php
ERROR_REPORTING(0);
session_start();

header("Content-Type: text/html; charset=utf-8");
setlocale(LC_TIME, 'de_DE', 'deu_deu');


global $GLOBAL;
global $CONFIG;

//Konfiguration laden
include("system/config.php");

//Basiskomponente laden
include("system/functions.php");
include("system/classes.php");

/*
//Datenbankverbindung herstellen
$DB = new dbConnection;
$DB->open($CONFIG["dbhost"], $CONFIG["dbuser"], $CONFIG["dbpass"], $CONFIG["dbname"]);

//Seiteneinstellungen laden
global $CONFIG;
$result = $DB->q("SELECT * FROM settings");
$CFG = mysqli_fetch_array($result);
*/


//Session Control
if(!$GLOBAL["uid"]) {
	if($_SESSION["uid"]) {
		$GLOBAL["uid"] = $_SESSION["uid"];
	}else{
	//Generate new session
	$sid = uniqid()."_".md5(time());
	$_SESSION["uid"] = $sid;
	$GLOBAL["uid"] = $_SESSION["uid"];
	}
}



/* 
Prüfen, ob der Besucher ein eingeloggter Admin ist. Wenn ja, dann Userdaten in $ADMIN laden.


$result = $DB->q("SELECT * FROM admins WHERE id = '".$_SESSION["uid"]."' AND md5(passwort) = '".$_SESSION["uid_code"]."' AND timeout > '".time()."'");
$exist = mysqli_num_rows($result);
if($exist)
{
	$ADMIN = mysqli_fetch_array($result);
	$ADMIN["eingeloggt"] = true;
}else{
	unset($ADMIN);
}
*/

//Wartungsmodus prüfen
if($CFG["seitenstatus"] == 2 && $GLOBAL["current_page"] == "home"){
echo "<h2>We are curerntly under planned maintenance and will be back shortly!</h2>";
die();
}


// Routing
if($GLOBAL["basedir"]) {
	$GLOBAL["current_page"] = str_replace($GLOBAL["basedir"], "", $_SERVER['REQUEST_URI']);
}else{
	$GLOBAL["current_page"] = substr($_SERVER['REQUEST_URI'], 0);
}

// Sprache erkennen
$GLOBAL["current_lang"] = substr($GLOBAL["current_page"], 0, 2);
if($GLOBAL["current_lang"] == "de" || $GLOBAL["current_lang"] == "en") {
	$GLOBAL["current_page"] = substr($GLOBAL["current_page"], 2);
}else{
	die(go($GLOBAL["root"]."de"));
}



$GLOBAL["linkroot"] = $GLOBAL["root"].$GLOBAL["current_lang"];


//Wenn GET-Parameter in URL vorhanden, dann entferne diesen aus dem Dateipfad
if(strpos($GLOBAL["current_page"], "?") !== false) {
	$GLOBAL["current_page"] = strstr($GLOBAL["current_page"], "?", true);
}

if(!$GLOBAL["current_page"]) {
	$GLOBAL["current_page"] = "home";
}


$tplpath = "templates/".$GLOBAL["current_lang"]."/".$GLOBAL["current_page"].".inc.php";


if(!file_exists($tplpath)) {	
	$tplpath = "templates/404.inc.php";
}

if(!file_exists($tplpath)) {
	echo "ERROR 404 - No Error Document";
}else{
	include($tplpath);
}


?>