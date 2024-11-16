<?
if($a == "submit")
{
$result = $DB->q("SELECT * FROM admins WHERE username = '".$_REQUEST["username"]."' AND passwort = '".md5($_REQUEST["passwort"])."'");
$exist = mysqli_num_rows($result);
	if(!$exist)
	{
		$error = true;
	}else{
		$THIS = mysqli_fetch_array($result);
		$_SESSION["uid"] = $THIS["id"];
		$_SESSION["uid_code"] = md5(md5($_REQUEST["passwort"]));
		$result = $DB->q("UPDATE admins SET timeout = '".(time()+86400)."' WHERE id = '".$THIS["id"]."'");
		go_v($GLOBAL["linkroot"]."/admin", "1");
		$success = true;
	}
}
?>

<div class="ot-panel-block panel-light">
	<div class="shortcode-content">	
									
		<center>
		
		<form action="?s=login&a=submit" method="POST">
		
		<table class="fahrerlogin">
		<tr><td><b>Username:</b></td><td><input type="text" name="username" style="width:100%;height:30px;border:black solid 1px;"></td></tr>
		<tr><td><b>Passwort:</b></td><td><input type="password" name="passwort" style="width:100%;height:30px;border:black solid 1px;"></td></tr>
		<tr><td colspan="2"><input type="submit" value="Einloggen" style="width:100%;"></td></tr>
		<?
		if($success)
		{
			?>
			<tr>
				<td colspan="2" style="text-align:center;">
						<p style="color:green;font-weight:bold;">
						Login erfolgreich!<br>Sie werden gleich weitergeleitet...
						</p>
				</td>
			</tr>
			<?
		}
		elseif($error)
		{
			?>
			<tr>
				<td colspan="2" style="text-align:center;">
						<p style="color:red;font-weight:bold;">
						<i class="fa fa-warning"></i><br>
						Unbekannte Logindaten!<br>Bitte erneut versuchen.</p>
				</td>
			</tr>
			<?
		}
		?>
		</table>
		
		</form>
		
		</center>
	
	</div>
</div>

