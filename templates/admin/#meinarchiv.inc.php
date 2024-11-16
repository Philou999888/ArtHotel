
<h3>Meine vergangenen Fahrten</h3>

<div style="width:100%;">
	<table class="fahrtenadmintbl" style="width:100%;">
		<tr>
			<th>#</th>
			<th>Zeit</th>			
			<th>Von</th>
			<th>Nach</th>
			<th>Kunde</th>
			<th>Preis</th>
		</tr>
		<?
		$result = $DB->q("SELECT * FROM fahrten WHERE fahrer = '".$ADMIN["id"]."' AND status != 1 AND deleted = 0 ORDER BY fahrt_datum DESC, fahrt_zeit_h DESC, fahrt_zeit_m DESC");
		
		while($row = mysqli_fetch_array($result)) {
			?>
			<tr <?if($row["status"] == 2){ echo 'style="background:#A9F5A9;"';}elseif($row["status"] == 3){ echo 'style="background:#E6E6E6;"';}elseif($row["status"] == 5){ echo 'style="background:#BCA9F5;"';}?>>
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
					€ <?=$row["fahrpreis"];?><br>
					<? if($row["autotyp"] == 1){?> Limo <?}elseif($row["autotyp"] == 2){?> Kombi <?}elseif($row["autotyp"] == 3){?> Van <?} ?><br>
				</td>
			</tr>
			<?
			if($row["status"] == 2) { 
				$result3 = $DB->q("SELECT * FROM fahrten_erledigungen WHERE fahrt = '".$row["id"]."' AND fahrer = '".$row["fahrer"]."'");
				$MELD = mysqli_fetch_array($result3);
				$result4 = $DB->q("SELECT * FROM admins WHERE id = '".$row["fahrer"]."'");
				$MELDER = mysqli_fetch_array($result4);
				?>
				<tr style="background:#A9F5A9;">
					<td colspan="9" style="padding:0px 0px 0px 10px !important;">
						<small><i>
					Erledigt markiert am <?=$MELD["zeitpunkt_erledigt"];?>.
						</i></small>
					</td>
				</tr>
				<?
			}
			elseif($row["status"] == 3) { 
				$result3 = $DB->q("SELECT * FROM fahrten_stornos WHERE fahrt = '".$row["id"]."' ORDER BY id DESC");
				$PROB = mysqli_fetch_array($result3);
				$result4 = $DB->q("SELECT * FROM admins WHERE id = '".$row["fahrer"]."'");
				$MELDER = mysqli_fetch_array($result4);
				?>
				<tr style="background:#E6E6E6;">
					<td colspan="9" style="padding:0px 0px 0px 10px !important;">
						<small><i>
						Storniert von Supervisor <?=$MELDER["vorname"];?> <?=$MELDER["nachname"];?> am <?=$PROB["zeitpunkt_storniert"];?>.
						</i></small>
					</td>
				</tr>
				<?
			}
			elseif($row["status"] == 5) { 
				$result3 = $DB->q("SELECT * FROM fahrten_probleme WHERE fahrt = '".$row["id"]."' AND fahrer = '".$row["fahrer"]."'");
				$PROB = mysqli_fetch_array($result3);
				$result4 = $DB->q("SELECT * FROM admins WHERE id = '".$row["fahrer"]."'");
				$MELDER = mysqli_fetch_array($result4);
				?>
				<tr style="background:#BCA9F5;">
					<td colspan="9" style="padding:0px 0px 0px 10px !important;">
						<small><i>
						<?=$PROB["text"];?>. Gemeldet von <?=$MELDER["nachname"];?> <?=$MELDER["vorname"];?> am <?=$PROB["zeitpunkt_gemeldet"];?>.
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