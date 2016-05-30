<?php
	session_start(); 
	if(!isset($_SESSION['username']))
		header("location:index.php"); // Re-direct to index.php


	require('pdfGenerator/pdfgenerator.php');
	$pdfGenerator = new pdfGenerator();
	$anz ="";
	$message ="";
	$filialnr= "";
	$name = "";	
	$vorname = "";
	$function1 ="";
	$function2 ="";
	$sparte ="";
	$street = "";
	$zip = "";
	$mail ="";
	$mailEnding = "@fust.ch";
	$mobile ="";
	$phone = "";
	$fax ="";
	$freierTag = "";
	$Errmessage = "";

	if (isset($_POST['anz']))
			$anz = $pdfGenerator->customspecialchars(trim($_POST['anz']));
	if (isset($_POST['filialnr']))
		$filialnr = $pdfGenerator->customspecialchars(trim($_POST['filialnr']));
	if (isset($_POST['vorname']))
		$vorname = $pdfGenerator->customspecialchars(trim($_POST['vorname']));
	if (isset($_POST['name']))
		$name = $pdfGenerator->customspecialchars(trim($_POST['name']));
	if (isset($_POST['function1'])) 
		$function1 = $pdfGenerator->customspecialchars(trim($_POST['function1']));
	if (isset($_POST['function2'])) 
		$function2 = $pdfGenerator->customspecialchars(trim($_POST['function2']));
	if (isset($_POST['sparte'])) 
		$sparte = $pdfGenerator->customspecialchars(trim($_POST['sparte']));
	if (isset($_POST['street']))
		$street = $pdfGenerator->customspecialchars(trim($_POST['street']));
	if (isset($_POST['zip'])) 
		$zip = $pdfGenerator->customspecialchars(trim($_POST['zip']));
	if (isset($_POST['mail'])) 
{
		$mail = $pdfGenerator->customspecialchars(trim($_POST['mail']));
	if (strpos($mail,'@') != false)
	$Errmessage =	 "<script type='text/javascript'>alert ('E-mail deve essere inserito senza @fust.ch');</script>";
}
	if (isset($_POST['mobile'])) 
	{
		$mobile = $pdfGenerator->customspecialchars(trim($_POST['mobile']));
	    $array = str_split($mobile);
		if (count($array) < 13 && count($array) > 1)
			$Errmessage = "<script type='text/javascript'>alert ('Il nummero di mobil non � corretto. V prego di formatare il nummero nel mode seguente: 071 123 45 78');</script>";
		else if (count($array) > 1)
			if ($array[3] != " " || $array[7] != " " || $array[10] != " ")
				$Errmessage = "<script type='text/javascript'>alert ('Il nummero di mobil non � corretto. V prego di formatare il nummero nel mode seguente: 071 123 45 78');</script>";
	}
	if (isset($_POST['phone']))
	{
		$phone = $pdfGenerator->customspecialchars(trim($_POST['phone']));
	    $array = str_split($phone);
		if (count($array) < 13)
			$Errmessage = "<span class='red' style=\"font-size:10px;\">Il nummero di telefono non � corretto. V prego di formatare il nummero nel mode seguente: 071 123 45 78</span>";
		else
			if ($array[3] != " " || $array[7] != " " || $array[10] != " ")
				$Errmessage = "<span class='red' style=\"font-size:10px;\">Il nummero di telefono non � corretto. V prego di formatare il nummero nel mode seguente: 071 123 45 78</span>";
	}
	if (isset($_POST['fax']))
	{
		$fax = $pdfGenerator->customspecialchars(trim($_POST['fax']));
	    $array = str_split($fax);
		if (count($array) < 13 && count($array) > 1)
			$Errmessage = "<script type='text/javascript'>alert ('Il nummero di fax non � corretto. V prego di formatare il nummero nel mode seguente: 071 123 45 78');</script>";
		else if (count($array) > 1)
			if ($array[3] != " " || $array[7] != " " || $array[10] != " ")
				$Errmessage = "<script type='text/javascript'>alert ('Il nummero di fax non � corretto. V prego di formatare il nummero nel mode seguente: 071 123 45 78');</script>";
	}
	
	if (isset($_POST['order']))
	{	
		if(isset($_FILES['thefile']) && $_FILES['thefile']['size'] <  10485760)
		{
			$filename = $pdfGenerator->generatePdf
				(
					"kueBa", 
					"I", 
					array
					(
						$vorname.' '.$name,  //0
						$function1,  //1
						$function2,  // 2
						'Telefono:', //3
						$phone, //4
						'Mobile:', //5
						$mobile, //6
						'Fax:', //7
						$fax, //8
						'E-Mail:', //9
						$mail.$mailEnding, //10
						'Ing. dipl. Fust SA ',  //11
						$street,  //12
						$zip  //13
					), 
					$filialnr, 
					$anz
				);
					$pdfGenerator->sendMail($filename, $anz, $filialnr);
				if (move_uploaded_file($_FILES['thefile']['tmp_name'],"fotos/".$filename.$_FILES['thefile']['name']))
				{

					$message = 'Grazie per la vostra ordinazione <br /> <a href="vcards/'.urlencode($filename).'" target="_blank">Visionare PDF<br />  <a href="index.php?site=cardSelection&language=i">Ordinare nuova carta da visita</a>';
				}
				else
					$message = "Fehler beim Foto Upload! Ihre Bestellung konnte nicht abgeschlossen werden!";
		}
		else
			die("Datei zu gross!");
	}	

include_once('views/header.php');

?>	

<script LANGUAGE="JavaScript">
function confirmSubmit()
{
$('#loadingGif').removeAttr('style');
var agree=confirm("Siete sicuri di volere ordinare? Avete controllato ancora bene tutti i testi?");
if (agree)
	return true ;
else
	return false ;
}
</script>

				<h3>cucine/bagni/rinnovi</h3>
		
				<form action="index.php?site=formularKueBa&language=i" method="post" enctype="multipart/form-data">
					<table class="formularTabelle">	
						<tr>
						  <td align="right">Numero filiale:</td>
						  <td>
								<input name="filialnr" type="text" size="6" maxlength="10"  value="<?php echo $filialnr; ?>"> 
								<span class="tabellenKommentar" >
									 (per scopi interni � necessario)
								</span>
							</td>
						</tr>
						<tr>
						  <td align="right">Cognome:</td>
						  <td><input name="name" type="text" size="30" maxlength="20" value="<?php echo $name;?>"></td>
						</tr>
						<tr>
						  <td align="right">Nome:</td>
						  <td><input name="vorname" type="text" size="30" maxlength="20" value="<?php echo $vorname;?>"></td>
						</tr>
						<tr>
						  <td align="right">Funzione 1:</td>
						  <td>
							<select name="function1" type="text" size="1" maxlength="36" value="<?php echo $function1;?>">
							<option <?php if ($function1 == "Consulenza/pianificazione/vendita")  { echo 'selected'; } ?>>Consulenza/pianificazione/vendita</option>
							<option <?php if ($function1 == "Responsabile filiale")  { echo 'selected'; } ?>>Responsabile filiale</option>
							<option <?php if ($function1 == "Responsabile regionale")  { echo 'selected'; } ?>>Responsabile regionale</option>
							<option <?php if ($function1 == "Servizio di montaggio")  { echo 'selected'; } ?>>Servizio di montaggio</option>
							<option <?php if ($function1 == "Addetto al montaggio di servizio")  { echo 'selected'; } ?>>Addetto al montaggio di servizio</option>
							</select>
						  </td>
						</tr>
						<tr>
						  <td align="right">Funzione 2:</td>
						  <td><input name="function2" type="text" size="30" maxlength="33" value="<?php echo $function2;?>"></td>
						</tr>
						<tr>
						  <td align="right">Via:</td>
						  <td><input name="street" type="text" size="30" maxlength="20" value="<?php echo $street;?>"></td>
						</tr>
						<tr>
						  <td align="right">NAP/luego:</td>
						  <td><input name="zip" type="text" size="30" maxlength="20" value="<?php echo $zip;?>"></td>
						</tr>
						<tr>
						  <td align="right">E-Mail:</td>
						  <td>
							<input name="mail" type="text" size="30" maxlength="25" value="<?php echo $mail;?>">
							<?php echo $mailEnding; ?>
						</td>
						</tr>
						<tr>
						  <td align="right">Telefono:</td>
						  <td><input name="phone" type="text" size="30" maxlength="36" value="<?php echo $phone;?>"><?php echo $Errmessage; ?></td>
						</tr>
						<tr>
						  <td align="right">Mobile:</td>
						  <td><input name="mobile" type="text" size="30" maxlength="36" value="<?php echo $mobile;?>"></td>
						</tr>
						<tr>
						  <td align="right">Fax:</td>
						  <td><input name="fax" type="text" size="30" maxlength="36" value="<?php echo $fax;?>"></td>
						</tr>
						<tr>
							<td style="padding-top:10;">
								<input type="submit" value="verduta" name="preview">
							</td>
							<td>
								<img src="./resource/loading.gif" height="25px" style="display:none;" id="loadingGif"/>
							</td>
						</tr>
						<tr>
							<td style=padding-top:60px;><p>&nbsp;</p></td>
							<td style=padding-top:60px;>
								<hr width="100%" noshade class="view-AllFormular-HorizontalLine" size="5" />
							</td>
						</tr>
						<tr>
							<td align="right">Foto Upload (max 10mb):</td>		
							<td><input name="thefile" type="file" size="30" maxlength="36"></td>
							<td>(Abito scuro, cravatta. L�immagine deve essere prima verificata dall� RVL.)</td>
						</tr>
						<tr>
							<td align="right">ordine:</td>
							<td>
								<select name="anz" size="1">
	      							<option>100</option>
									<option>300</option>
								</select>
								<input type="submit" value=" commande " name="order"  onClick="return confirmSubmit()" <?php if($Errmessage != "") echo("disabled= 	\"disabled\""); ?>>
							</td>
						</tr>
					</table>
				</form>
				<?php echo $message; ?>
			<div class="vorschaufenster" >
				<img src="resource/template/vorlagen/KueBa/VK_ital_KueBa_VS_leer.jpg" width="400px" />
				<div class="view-formularKueBa-vorschau-name"><?php echo $vorname; echo ' '; echo $name; ?></div>
				<div class="view-formularKueBa-vorschau-function1"><?php echo $function1; echo ' '; echo $sparte ?></div>
				<div class="view-formularKueBa-vorschau-function2"><?php echo $function2; ?></div>
				<div class="view-formularKueBa-vorschau-adressZeile"><?php echo 'Ing. dipl. Fust SA <span class="orange">|</span> '; echo $street; echo ' <span class="orange">|</span> '; echo $zip; ?></div>
				<div class="view-formularKueBa-vorschau-nummern">
					<?php 
					if ($phone != "") 
					{ 
						echo 'Telefono: <span class="view-formularKueBa-nummer-vorschau">'; 
						echo $phone; 
						echo '</span><br />'; 
					} 
					if ($mobile != "") 
					{  
						echo 'Mobile: <span class="view-formularKueBa-nummer-vorschau">'; 
						echo $mobile; 
						echo '</span><br />'; 
					}  
					if ($fax != "") 
					{  
						echo 'Fax: <span class="view-formularKueBa-nummer-vorschau">'; 
						echo $fax; 
						echo '</span><br />'; 
					} 
					if ($mail != "") 
					{  
						echo 'E-Mail: <span class="view-formularKueBa-nummer-vorschau">'; 
						echo $mail;
						echo $mailEnding;
						echo '</span>'; 
					}  
					?>
				</div>
			</div>
			<div class="vorschaufenster-rueckseite">
				<img src="resource/template/vorlagen/KueBa/VK_ital_KueBa_RS.jpg" width="400px" />
			</div>
		</div>
	</body>
</html>

