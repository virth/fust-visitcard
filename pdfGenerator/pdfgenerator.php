<?php

require('fpdf/fpdf.php');
require('fpdf/fpdi.php');

class pdfgenerator
{
	function pdfgenerator()
	{
		error_reporting(E_ALL | E_STRICT);
		ini_set('display_errors', 'On');
		//putenv('TZ=Europe/Berlin');
		date_default_timezone_set('UTC');
	}


	function generatePdf ($type, $sprache, $data, $filialnr, $menge)
	{

		$size = array(60,91);
		$pdf = new FPDI();
		$pdf-> AddFont('FrutigerLTStd-Black');
		$pdf-> AddFont('FrutigerLTStd-BlackCn');
		$pdf-> AddFont('FrutigerLTStd-Cn');
		$pdf-> AddFont('FrutigerLTStd-ExtraBlackCn');
		$pdf-> AddFont('FrutigerLTStd-Cn');;

		$pdf-> AddFont('FrutigerLTStd-Bold');
		$pdf-> AddFont('FrutigerLTStd-Light');
		$pdf-> AddFont('FrutigerLTStd-Roman');
		$pdf-> SetAutoPageBreak(false);
		$pdf-> addPage('mm', $size);
		
		$filename = $data[0];
		for ($i = 0; $i < sizeof($data); $i++) {
			
			$data[$i] = htmlspecialchars_decode($data[$i]);
			$data[$i] = utf8_decode($data[$i]);
		}


		if ($type == "verkauf")
			$pdf = $this->generateVerkauf($sprache, $data, $pdf, $size);
		else if ($type == "verkaufSpringer")
			$pdf = $this->generateVerkaufSpringer($sprache, $data, $pdf, $size);
		else if ($type == "kueBa")
			$pdf = $this->generateKueBa($sprache, $data, $pdf, $size);
		else if ($type == "eigenheim")
			$pdf = $this->generateEigenheim($sprache, $data, $pdf);
		else if ($type == "monteur")
			$pdf = $this->generateMonteur($sprache, $data, $pdf);
		else if ($type == "admin")
			$pdf = $this->generateAdmin($sprache, $data, $pdf);



		//PDF speichern
		$fname = $this->writePDF($pdf, $filename, $filialnr, $menge, $type);

		//Lese Empf�nger Adressen und schreibe E-Mails
		if ($type != "kueBa")
			$this->sendMail($fname, $menge, $filialnr);
		return $fname;
	}

	function customspecialchars($text)
	{
		return htmlspecialchars($text,ENT_COMPAT,'UTF-8', true);
	}


	private function writePDF($pdfToWrite, $name, $filialnr, $menge, $typ)
	{
		$now = date("H-i-s");//, strtotime(date('r')));
		$date = date("Y-m-d");
		$filename = strtolower($date.'_'.$typ.'_'.$name.'_'.$now."_".$menge.".pdf");
		$filename = str_replace("ö", "oe", $filename);
		$filename = str_replace("ä", "ae", $filename);
		$filename = str_replace("ü", "ue", $filename);
		$filename = str_replace(" ", "_", $filename);
		$filename = urlencode ($filename);

		$pdfToWrite->Output("vcards/".htmlspecialchars_decode($filename), "F");
		return $filename;
	}

	function sendMail($fname, $menge, $filialnr)
	{
		$datei = "conf.dat"; // Name der Datei
		$entrysArray = file($datei); // Datei in ein Array einlesen
		$anzentrys = sizeof($entrysArray);
		for ($i = 0; $i < $anzentrys; $i++)
		{
			$absendername = "FUST Online Portal";
			$absendermail = "Fust.Onlineportal@e-druck.ch";
			$betreff = "Bestellung Fust Visitenkarte";
			$text = "Guten Tag \n\n Soeben ist eine Bestellung für Filial Nr $filialnr eingegangen. \n\nBestellte Visitenkarte: $menge \n\n PDF: http://visitcard.ch/vcards/".urlencode($fname);;

			mail($entrysArray[$i], $betreff, $text, "From: $absendername <$absendermail>");
		}
	}

	public function mailcheck($mail)
	{
		$email = $pdfGenerator->customspecialchars($mail);
		if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email) )
		{
			return false;
		}

		return true;
	}

	private function generateVerkauf($sprache, $dataArray, $pdf, $size)
	{	$rueckseite = "";
		if ($sprache == 'D')
		{
			$furz = $pdf->setSourceFile("resource/template/vorlagen/Verkauf/VK_dt_Verkauf_VS_leer.pdf");
			$rueckseite = "resource/template/vorlagen/Verkauf/VK_dt_Verkauf_RS.pdf";
		}
		else if ($sprache == 'F')
		{
			$furz = $pdf->setSourceFile("resource/template/vorlagen/Verkauf/VK_franz_Verkauf_VS_leer.pdf");
			$rueckseite = "resource/template/vorlagen/Verkauf/VK_franz_Verkauf_RS.pdf";
		}
		else if ($sprache == 'I')
		{
			$furz = $pdf->setSourceFile("resource/template/vorlagen/Verkauf/VK_ital_Verkauf_VS_leer.pdf");
			$rueckseite = "resource/template/vorlagen/Verkauf/VK_ital_Verkauf_RS.pdf";
		}
		else
			return $pdf;

		$hdl = $pdf->ImportPage(1);
		$pdf-> useTemplate($hdl);

		$nummernPOS = 43;
		$mailPOS = 39.5;
		$adressePOS = 36;

		//Zeile Freier Wochentag
		if ($dataArray[8] != "")
		{
			$pdf-> SetFont('FrutigerLTStd-Cn','',8.5);
			$pdf-> SetXY(0, 46.5);
			$pdf->Cell(90,5,$dataArray[8],0,1,"C");
		}
		else
		{
			$nummernPOS = 46.5;
			$mailPOS = 43;
			$adressePOS = 39.5;
		}

		//Zeile Nummern
		$pdf-> SetFont('FrutigerLTStd-Cn','',8.5);
		$pdf-> SetXY(0, $nummernPOS);
		$pdf->Cell(90,5,$dataArray[7],0,1,"C");

		//Zeile Mail
		$pdf-> SetFont('FrutigerLTStd-Cn','',8.5);
		$pdf-> SetXY(0, $mailPOS);
		$pdf->Cell(90,5,$dataArray[6],0,1,"C");

		//Zeile Adresse
		$pdf = $this->writeAdress($dataArray[4], $dataArray[5], $dataArray[3], $adressePOS, $pdf);

		$add = 0;
		if ($dataArray[8] != "")
			$add = $add + 2;

		if ($dataArray[2] != "")
			$add = $add + 2.5;

		//Zeile Funktion 2
		$pdf-> SetFont('FrutigerLTStd-ExtraBlackCn','',8.5);
		$pdf-> SetXY(0, 32 - $add);
		$pdf-> Cell(90,5,$dataArray[2],0,1,"C");

		//Zeile Funktion 1
		$pdf-> SetFont('FrutigerLTStd-ExtraBlackCn','',8.5);
		$pdf-> SetXY(0, 29 - $add);
		$pdf-> Cell(90,5,$dataArray[1],0,1,"C");

		//Zeile Name
		$pdf-> SetFont('FrutigerLTStd-ExtraBlackCn','',14);
		$pdf-> SetXY(0, 24.8 - $add);
        $pdf-> Cell(90,5,$dataArray[0],0,1,"C");

		$anzahl = $pdf->setSourceFile($rueckseite);
		$pdf-> addPage('mm', $size);
		$hdl2 = $pdf->ImportPage(1);
		$pdf-> useTemplate($hdl2);

		return $pdf;
	}

	private function generateVerkaufSpringer($sprache, $dataArray, $pdf, $size)
	{
		$rueckseie = "";
		if ($sprache == 'D')
		{
			$furz = $pdf->setSourceFile("resource/template/vorlagen/Springer/VK_dt_Springer_VS_leer.pdf");
			$rueckseite = "resource/template/vorlagen/Springer/VK_dt_Springer_RS.pdf";
		}
		else if ($sprache == 'F')
		{
			$furz = $pdf->setSourceFile("resource/template/vorlagen/Springer/VK_franz_Springer_VS_leer.pdf");
			$rueckseite = "resource/template/vorlagen/Springer/VK_franz_Springer_RS.pdf";
		}
		else if ($sprache == 'I')
		{
			$furz = $pdf->setSourceFile("resource/template/vorlagen/Springer/VK_ital_Springer_VS_leer.pdf");
			$rueckseite = "resource/template/vorlagen/Springer/VK_ital_Springer_RS.pdf";
		}
		else
			return $pdf;



		$hdl = $pdf->ImportPage(1);
		$pdf-> useTemplate($hdl);


		//Zeile Nummern + MAIL Filiale 2
		$pdf-> SetFont('FrutigerLTStd-Cn','',8.5);
		$pdf-> SetXY(0, 45.5);
		$pdf->Cell(90,5,$dataArray[10],0,1,"C");

		//Zeile Adresse Filiale 2
		$pdf = $this->writeAdress($dataArray[8], $dataArray[9], $dataArray[7], 42, $pdf);

		//Zeile Nummern + MAIL Filiale 1
		$pdf-> SetFont('FrutigerLTStd-Cn','',8.5);
		$pdf-> SetXY(0, 37);
		$pdf->Cell(90,5,$dataArray[6],0,1,"C");

		//Zeile Adresse Filiale 1
		$pdf = $this->writeAdress($dataArray[4], $dataArray[5], $dataArray[3], 33.5, $pdf);

		//Zeile Funktion 2
		$pdf-> SetFont('FrutigerLTStd-ExtraBlackCn','',8.5);
		$pdf-> SetXY(0, 28.5);
		$pdf-> Cell(90,5,$dataArray[2],0,1,"C");

		//Zeile Funktion 1
		$pdf-> SetFont('FrutigerLTStd-ExtraBlackCn','',8.5);
		$pdf-> SetXY(0, 25.5);
		$pdf-> Cell(90,5,$dataArray[1],0,1,"C");

		//Zeile Name
		$pdf-> SetFont('FrutigerLTStd-ExtraBlackCn','',14);
		$pdf-> SetXY(0, 20.5);
		$pdf-> Cell(90,5,$dataArray[0],0,1,"C");

		$anzahl = $pdf->setSourceFile($rueckseite);
		$pdf-> addPage('mm', $size);
		$hdl2 = $pdf->ImportPage(1);
		$pdf-> useTemplate($hdl2);

		return $pdf;
	}

	private function generateKueBa($sprache, $dataArray, $pdf, $size)
	{
		$rueckseite = "";
		$abstandlinks = "47";

		if ($sprache == 'D')
		{
			$furz = $pdf->setSourceFile("resource/template/vorlagen/KueBa/VK_dt_KueBa_VS_leer.pdf");
			$rueckseite = "resource/template/vorlagen/KueBa/VK_dt_KueBa_RS.pdf";
			$abstandlinks = 47;
		}
		else if ($sprache == 'F')
		{
			$furz = $pdf->setSourceFile("resource/template/vorlagen/KueBa/VK_franz_KueBa_VS_leer.pdf");
			$rueckseite = "resource/template/vorlagen/KueBa/VK_franz_KueBa_RS.pdf";
			$abstandlinks = 51;
		}
		else if ($sprache == 'I')
		{
			$furz = $pdf->setSourceFile("resource/template/vorlagen/KueBa/VK_ital_KueBa_VS_leer.pdf");
			$rueckseite = "resource/template/vorlagen/KueBa/VK_ital_KueBa_RS.pdf";
			$abstandlinks = 51;
		}
		else
			return $pdf;


		$hdl = $pdf->ImportPage(1);
		$pdf-> useTemplate($hdl);

		//Zeile Adresse
		$pdf = $this->writeAdress($dataArray[12], $dataArray[13], $dataArray[11], 46.5, $pdf);

		$mailPos = 40.6;
		$diff = 3.5;

		//Zeile Mail
		$pdf-> SetFont('FrutigerLTStd-Cn','',8.5);
		$pdf-> SetXY($abstandlinks, $mailPos);
		$pdf-> Cell(40,5,$dataArray[10],0,1);

		//Zeile Mail TEXT
		$pdf-> SetFont('FrutigerLTStd-Cn','',8.5);
		$pdf-> SetXY(33.5, $mailPos);
		$pdf-> Cell(40,5,$dataArray[9],0,1);

		$mailPos = $mailPos - $diff;

		if ($dataArray[8] != "")
		{
			//Zeile FAX
			$pdf-> SetFont('FrutigerLTStd-Cn','',8.5);
			$pdf-> SetXY($abstandlinks, $mailPos);
			$pdf-> Cell(40,5,$dataArray[8],0,1);

			//Zeile Fax TEXT
			$pdf-> SetFont('FrutigerLTStd-Cn','',8.5);
			$pdf-> SetXY(33.5, $mailPos);
			$pdf-> Cell(40,5,$dataArray[7],0,1);
			$mailPos = $mailPos - $diff;
		}

		if ($dataArray[6] != "")
		{
			//Zeile Mobile
			$pdf-> SetFont('FrutigerLTStd-Cn','',8.5);
			$pdf-> SetXY($abstandlinks, $mailPos);
			$pdf-> Cell(40,5,$dataArray[6],0,1);

			//Zeile Mobile TEXT
			$pdf-> SetFont('FrutigerLTStd-Cn','',8.5);
			$pdf-> SetXY(33.5, $mailPos);
			$pdf-> Cell(40,5,$dataArray[5],0,1);
			$mailPos = $mailPos - $diff;
		}
		//Zeile Tel
		$pdf-> SetFont('FrutigerLTStd-Cn','',8.5);
		$pdf-> SetXY($abstandlinks, $mailPos);
		$pdf-> Cell(40,5,$dataArray[4],0,1);

		//Zeile Tel TEXT
		$pdf-> SetFont('FrutigerLTStd-Cn','',8.5);
		$pdf-> SetXY(33.5, $mailPos);
		$pdf-> Cell(40,5,$dataArray[3],0,1);

		$mailPos = $mailPos - $diff;

		//Funktion 2
		$pdf-> SetFont('FrutigerLTStd-ExtraBlackCn','',8.5);
		$pdf-> SetXY(33.5, 26.5);
		$pdf-> Cell(40,5,$dataArray[2],0,1);

		//Funktion 1
		$pdf-> SetFont('FrutigerLTStd-ExtraBlackCn','',8.5);
		$pdf-> SetXY(33.5, 23.5);
		$pdf-> Cell(40,5,$dataArray[1],0,1);

		//Zeile Name
		$pdf-> SetFont('FrutigerLTStd-ExtraBlackCn','',14);
		$pdf-> SetXY(33.5, 19);
		$pdf-> Cell(40,5,$dataArray[0],0,1);


		$anzahl = $pdf->setSourceFile($rueckseite);
		$pdf-> addPage('mm', $size);
		$hdl2 = $pdf->ImportPage(1);
		$pdf-> useTemplate($hdl2);

		return $pdf;
	}

	private function generateEigenheim($sprache, $dataArray, $pdf)
	{
		if ($sprache == 'D')
			$furz = $pdf->setSourceFile("resource/template/vorlagen/Umbau_Neubau/VK_dt_Umbau_Neubau_leer.pdf");
		else if ($sprache == 'F')
			$furz = $pdf->setSourceFile("resource/template/vorlagen/Umbau_Neubau/VK_franz_Umbau_Neubau_leer.pdf");
		else if ($sprache == 'I')
			$furz = $pdf->setSourceFile("resource/template/vorlagen/Umbau_Neubau/VK_ital_Umbau_Neubau_leer.pdf");
		else
			return $pdf;



		$hdl = $pdf->ImportPage(1);
		$pdf-> useTemplate($hdl);

		//Zeile Nummern
		$pdf-> SetFont('FrutigerLTStd-Cn','',8.5);
		$pdf-> SetXY(0, 46.5);
		$pdf->Cell(90,5,$dataArray[7],0,1,"C");

		//Zeile Mail
		$pdf-> SetFont('FrutigerLTStd-Cn','',8.5);
		$pdf-> SetXY(0, 43);
		$pdf->Cell(90,5,$dataArray[6],0,1,"C");

		//Zeile Adresse
		$pdf = $this->writeAdress($dataArray[4], $dataArray[5], $dataArray[3], 38, $pdf);

		//Zeile Funktion 2
		$pdf-> SetFont('FrutigerLTStd-ExtraBlackCn','',8.5);
		$pdf-> SetXY(0, 32.5);
		$pdf-> Cell(90,5,$dataArray[2],0,1,"C");

		//Zeile Funktion 1
		$pdf-> SetFont('FrutigerLTStd-ExtraBlackCn','',8.5);
		$pdf-> SetXY(0, 29.3);
		$pdf-> Cell(90,5,$dataArray[1],0,1,"C");

		//Zeile Name
		$pdf-> SetFont('FrutigerLTStd-ExtraBlackCn','',14);
		$pdf-> SetXY(0, 24);
		$pdf-> Cell(90,5,$dataArray[0],0,1,"C");

		return $pdf;
	}

	private function generateMonteur($sprache, $dataArray, $pdf)
	{
		if ($sprache == 'D')
			$furz = $pdf->setSourceFile("resource/template/vorlagen/Monteur/VK_dt_Monteur_leer.pdf");
		else if ($sprache == 'F')
			$furz = $pdf->setSourceFile("resource/template/vorlagen/Monteur/VK_franz_Monteur_leer.pdf");
		else if ($sprache == 'I')
			$furz = $pdf->setSourceFile("resource/template/vorlagen/Monteur/VK_ital_Monteur_leer.pdf");
		else
			return $pdf;

		$hdl = $pdf->ImportPage(1);
		$pdf-> useTemplate($hdl);

		//Zeile Region + Sparte
		$pdf-> SetFont('FrutigerLTStd-BlackCn','',8.5);
		$pdf-> SetXY(0, 38);
		$pdf-> Cell(90,5,$dataArray[3],0,1,"C");

		//Zeile Funktion 2
		$pdf-> SetFont('FrutigerLTStd-ExtraBlackCn','',8.5);
		$pdf-> SetXY(0, 31);
		$pdf-> Cell(90,5,$dataArray[2],0,1,"C");

		//Zeile Funktion 1
		$pdf-> SetFont('FrutigerLTStd-ExtraBlackCn','',8.5);
		$pdf-> SetXY(0, 27.8);
		$pdf-> Cell(90,5,$dataArray[1],0,1,"C");

		//Zeile Name
		$pdf-> SetFont('FrutigerLTStd-ExtraBlackCn','',14);
		$pdf-> SetXY(0, 22.5);
		$pdf-> Cell(90,5,$dataArray[0],0,1,"C");

		return $pdf;
	}

	private function generateAdmin($sprache, $dataArray, $pdf)
	{
		if ($sprache == 'D')
			$furz = $pdf->setSourceFile("resource/template/vorlagen/Administration/VK_dt_Administration_leer.pdf");
		else if ($sprache == 'F')
			$furz = $pdf->setSourceFile("resource/template/vorlagen/Administration/VK_franz_Administration_VS_leer.pdf");
		else if ($sprache == 'I')
			$furz = $pdf->setSourceFile("resource/template/vorlagen/Administration/VK_ital_Administration_leer.pdf");
		else
			return $pdf;



		$hdl = $pdf->ImportPage(1);
		$pdf-> useTemplate($hdl);

		//Zeile Nummern
		$pdf-> SetFont('FrutigerLTStd-Cn','',8.5);
		$pdf-> SetXY(0, 46.5);
		$pdf->Cell(90,5,$dataArray[7],0,1,"C");

		//Zeile Mail
		$pdf-> SetFont('FrutigerLTStd-Cn','',8.5);
		$pdf-> SetXY(0, 43);
		$pdf->Cell(90,5,$dataArray[6],0,1,"C");

		//Zeile Adresse
		$pdf = $this->writeAdress($dataArray[4], $dataArray[5], $dataArray[3], 39, $pdf);

		//Zeile Funktion 2

		$pdf-> SetFont('FrutigerLTStd-ExtraBlackCn','',8.5);
		$pdf-> SetXY(0, 31.5);
		$pdf-> Cell(90,5,$dataArray[2],0,1,"C");

		//Zeile Funktion 1
		$pdf-> SetFont('FrutigerLTStd-ExtraBlackCn','',8.5);
		$pdf-> SetXY(0, 28.3);
		$pdf-> Cell(90,5,$dataArray[1],0,1,"C");

		//Zeile Name
		$pdf-> SetFont('FrutigerLTStd-ExtraBlackCn','',14);
		$pdf-> SetXY(0, 23);
		$pdf-> Cell(90,5,$dataArray[0],0,1,"C");

		return $pdf;
	}


	private function writeAdress($street, $plzOrt, $FustAG, $heightStreet, $pdf)
	{
		$heightPipe = $heightStreet + 3.2;
		$heightFustAndOrt = $heightStreet + 3.5;
		$centerOfCard = 42.75;

		$vCardWidth= 90;

		$red = 243;
		$green = 110;
		$blue = 33;

		$splittedFustAG = explode(".", $FustAG);

		$pdf-> SetFont('FrutigerLTStd-BlackCn','',8.5);
		$totalLength = $pdf->GetStringWidth($FustAG.'   | '.$street.'  | '.$plzOrt);
		$FustLength = $pdf->GetStringWidth($FustAG.' ');
		$StreetLength = $pdf->GetStringWidth($FustAG.'   | '.$street);
		$startPointFustAG = ($vCardWidth - $totalLength) /2;

		if ($splittedFustAG[0] == 'Dipl')
		{
			$speziellesLeerzeichenA = 6.5;
			$speziellesLeerzeichenB = 12;
			$FustLength = $pdf->GetStringWidth($FustAG.' ');
		}
		else
		{
			$speziellesLeerzeichenA = 5;
			$speziellesLeerzeichenB = 11.6;
			$FustLength = $pdf->GetStringWidth($FustAG);
		}

		//schreibe Fust AG
		$pdf->SetTextColor(0);
		$pdf-> SetFont('FrutigerLTStd-BlackCn','',8.5);
		$pdf-> Text($startPointFustAG, $heightFustAndOrt, $splittedFustAG[0].'.');
		$pdf-> Text($startPointFustAG + $speziellesLeerzeichenA, $heightFustAndOrt, $splittedFustAG[1].'.');
		$pdf-> Text($startPointFustAG + $speziellesLeerzeichenB, $heightFustAndOrt, $splittedFustAG[2]);

		//schreibe vorderes Pipe
		$pdf->SetTextColor($red, $green, $blue);
		$pdf-> SetFont('FrutigerLTStd-Light','',8.5);
		$pdf-> Text($startPointFustAG + $FustLength - 0.3, $heightPipe, ' | ');
		$pdf-> SetFont('FrutigerLTStd-BlackCn','',8.5);
		$pdf->SetTextColor(0);


		//schreibe Strasse
		$pdf-> Text($startPointFustAG + $FustLength +2.5, $heightFustAndOrt, $street);

		//hinteres Pipe
		$pdf->SetTextColor($red, $green, $blue);
		$pdf-> SetFont('FrutigerLTStd-Light','',8.5);
		$pdf-> Text($startPointFustAG + $StreetLength -0.5, $heightPipe, ' | ');
		$pdf-> SetFont('FrutigerLTStd-BlackCn','',8.5);
		$pdf->SetTextColor(0);

		//ort und plz
		$pdf-> Text($startPointFustAG + $StreetLength +2.5, $heightFustAndOrt, $plzOrt);

		return $pdf;
	}

}

?>