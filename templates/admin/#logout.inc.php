<?
$result = $DB->q("UPDATE admins SET timeout = '0' WHERE id = '".$ADMIN["id"]."'");
unset($ADMIN);

go($GLOBAL["linkroot"]."home");
?>
