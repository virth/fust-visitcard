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
	$Errmessage =	 "<script type='text/javascript'>alert ('E-mail doit étre entré sans @fust.ch');</script>";
}
	if (isset($_POST['mobile'])) 
	{
		$mobile = $pdfGenerator->customspecialchars(trim($_POST['mobile']));
	    $array = str_split($mobile);
		if (count($array) < 13 && count($array) > 1)
			$Errmessage = "<script type='text/javascript'>alert ('Le né de mobil néa pas le format correct. Veuillez le corriger comme suit: 071 123 45 78');</script>";
		else if (count($array) > 1)
			if ($array[3] != " " || $array[7] != " " || $array[10] != " ")
				$Errmessage = "<script type='text/javascript'>alert ('Le né de mobil néa pas le format correct. Veuillez le corriger comme suit: 071 123 45 78');</script>";
	}
	if (isset($_POST['phone']))
	{
		$phone = $pdfGenerator->customspecialchars(trim($_POST['phone']));
	    $array = str_split($phone);
		if (count($array) < 13)
			$Errmessage = "<span class='red' style=\"font-size:10px;\">Le né de téléphone néa pas le format correct. Veuillez le corriger comme suit: 071 123 45 78</span>";
		else
			if ($array[3] != " " || $array[7] != " " || $array[10] != " ")
				$Errmessage = "<span class='red' style=\"font-size:10px;\">Le né de téléphone néa pas le format correct. Veuillez le corriger comme suit: 071 123 45 78</span>";
	}
	if (isset($_POST['fax']))
	{
		$fax = $pdfGenerator->customspecialchars(trim($_POST['fax']));
	    $array = str_split($fax);
		if (count($array) < 13 && count($array) > 1)
			$Errmessage = "<script type='text/javascript'>alert ('Le né de fax néa pas le format correct. Veuillez le corriger comme suit: 071 123 45 78');</script>";
		else if (count($array) > 1)
			if ($array[3] != " " || $array[7] != " " || $array[10] != " ")
				$Errmessage = "<script type='text/javascript'>alert ('Le né de fax néa pas le format correct. Veuillez le corriger comme suit: 071 123 45 78');</script>";
	}
	
	if (isset($_POST['order']))
	{
		if(isset($_FILES['thefile']) && $_FILES['thefile']['size'] <  10485760)
		{
			$filename = $pdfGenerator->generatePdf
				(
					"kueBa", 
					"F", 
					array
					(
						$vorname.' '.$name,  //0
						$function1,  //1
						$function2,  // 2
						'Téléphone:', //3
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

					$message = 'Merci pour votre commandation! <br /> <a href="vcards/'.urlencode($filename).'" target="_blank">Visionner PDF<br />  <a href="index.php?site=cardSelection&language=f">Commander nouvelle carte de visite</a>';
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
var agree=confirm("étes-vous sure, que vous voulez comander? Avez vous controllé tous les textes?");
if (agree)
	return true ;
else
	return false ;
}
</script>



				<h3>cuisines/bains/rénovation </h3>
		
				<form action="index.php?site=formularKueBa&language=f" method="post" enctype="multipart/form-data">
					<table class="formularTabelle">	
						<tr>
						  <td align="right">Numér filiale:</td>
						  <td>
								<input name="filialnr" type="text" size="6" maxlength="10"  value="<?php echo $filialnr; ?>">
								<span class="tabellenKommentar" >
									(pour usage interne)
								</span>
							</td>
						</tr>
						<tr>
						  <td align="right">Nom:</td>
						  <td><input name="name" type="text" size="30" maxlength="20" value="<?php echo $name;?>"></td>
						</tr>
						<tr>
						  <td align="right">Prénom:</td>
						  <td><input name="vorname" type="text" size="30" maxlength="20" value="<?php echo $vorname;?>"></td>
						</tr>
						<tr>
						  <td align="right">Fonction 1:</td>
						  <td>
							<select name="function1" type="text" size="1" maxlength="36" value="<?php echo $function1;?>">
							<option <?php if ($function1 == "Consultation/planification/vente")  { echo 'selected'; } ?>>Consultation/planification/vente</option>
							<option <?php if ($function1 == "Chef de succursale")  { echo 'selected'; } ?>>Chef de succursale</option>
							<option <?php if ($function1 == "Chef de vente régional")  { echo 'selected'; } ?>>Chef de vente régional</option>
							<option <?php if ($function1 == "Service de montage")  { echo 'selected'; } ?>>Service de montage</option>
							<option <?php if ($function1 == "Montage")  { echo 'selected'; } ?>>Montage</option>
							<option <?php if ($function1 == "Monteur de service")  { echo 'selected'; } ?>>Monteur de service</option>
							</select>
						  </td>
						</tr>
						<tr>
						  <td align="right">Fonction 2:</td>
						  <td><input name="function2" type="text" size="30" maxlength="33" value="<?php echo $function2;?>"></td>
						</tr>
						<tr>
						  <td align="right">Rue:</td>
						  <td><input name="street" type="text" size="30" maxlength="20" value="<?php echo $street;?>"></td>
						</tr>
						<tr>
						  <td align="right">NAP/lieu:</td>
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
						  <td align="right">Téléphone:</td>
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
								<input type="submit" value="vue d'ensemble" name="preview">
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
							<td>(Costume foncé, cravate. Votre RVL doit considérer le portrait préalablement comme bon)</td>
						</tr>
						<tr>
							<td align="right">Nombre:</td>
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
				<img src="resource/template/vorlagen/KueBa/VK_franz_KueBa_VS_leer.jpg" width="400px" />
				<div class="view-formularKueBa-vorschau-name"><?php echo $vorname; echo ' '; echo $name; ?></div>
				<div class="view-formularKueBa-vorschau-function1"><?php echo $function1; echo ' '; echo $sparte ?></div>
				<div class="view-formularKueBa-vorschau-function2"><?php echo $function2; ?></div>
				<div class="view-formularKueBa-vorschau-adressZeile"><?php echo 'Ing. dipl. Fust SA <span class="orange">|</span> '; echo $street; echo ' <span class="orange">|</span> '; echo $zip; ?></div>
				<div class="view-formularKueBa-vorschau-nummern">
					<?php 
					if ($phone != "") 
					{ 
						echo 'Téléphone: <span class="view-formularKueBa-nummer-vorschau">'; 
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
				<img src="resource/template/vorlagen/KueBa/VK_franz_KueBa_RS.jpg" width="400px" />
			</div>
		</div>
	</body>
</html>


