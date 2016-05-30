<?php
	if(isset($_GET['site']))
	{
		switch ($_GET['site']) 
		{
    		case 'login':
        		include_once 'views/login.php';
        		break;
    		case 'logout':
  				include_once 'views/logout.php';
  				break;
    		case 'languageSelection':
  				include_once 'views/languageSelection.php';
  				break;
			case 'cardSelection':
				if(isset($_GET['language']))
					switch ($_GET['language']) 
					{
						case 'd':
						include_once 'views/cardSelection/cardSelectionD.php';
						break;
						
						case 'f':
						include_once 'views/cardSelection/cardSelectionF.php';
						break;
						
						case 'i':
						include_once 'views/cardSelection/cardSelectionI.php';
						break;
					}
				else
					include_once	'views/comingSoon.php';
				break;
			
			case 'formularAdmin':
				if(isset($_GET['language']))
					switch ($_GET['language']) 
					{
						case 'd':
						include_once 'views/formulare/formularAdmin/adminD.php';
						break;
						
						case 'f':
						include_once 'views/formulare/formularAdmin/adminF.php';
						break;
						
						case 'i':
						include_once 'views/formulare/formularAdmin/adminI.php';
						break;
					}
				else
					include_once	'views/comingSoon.php';
				break;


	                     case 'formularKueBa':
				if(isset($_GET['language']))
					switch ($_GET['language']) 
					{
						case 'd':
						include_once 'views/formulare/formularKueBa/formularKueBaD.php';
						break;
						
						case 'f':
						include_once 'views/formulare/formularKueBa/formularKueBaF.php';
						break;
						
						case 'i':
						include_once 'views/formulare/formularKueBa/formularKueBaI.php';
						break;
					}
				else
					include_once	'views/comingSoon.php';
				break;
				
					
			case 'formularVerkauf':
				if(isset($_GET['language']))
					switch ($_GET['language']) 
					{
						case 'd':
						include_once 'views/formulare/formularVerkauf/verkaufD.php';
						break;
						
						case 'f':
						include_once 'views/formulare/formularVerkauf/verkaufF.php';
						break;
						
						case 'i':
						include_once 'views/formulare/formularVerkauf/verkaufI.php';
						break;
					}
				else
					include_once	'views/comingSoon.php';
				break;
				
			case 'formularVerkaufSpringer':
				if(isset($_GET['language']))
					switch ($_GET['language']) 
					{
						case 'd':
						include_once 'views/formulare/formularVerkaufSpringer/verkaufSpringerD.php';
						break;
						
						case 'f':
						include_once 'views/formulare/formularVerkaufSpringer/verkaufSpringerF.php';
						break;
						
						case 'i':
						include_once 'views/formulare/formularVerkaufSpringer/verkaufSpringerI.php';
						break;
					}
				else
					include_once	'views/comingSoon.php';
				break;

                           case 'formularEigenheim':
				if(isset($_GET['language']))
					switch ($_GET['language']) 
					{
						case 'd':
						include_once 'views/formulare/formularEigenheim/formularEigenheimD.php';
						break;
						
						case 'f':
						include_once 'views/formulare/formularEigenheim/formularEigenheimF.php';
						break;
						
						case 'i':
						include_once 'views/formulare/formularEigenheim/formularEigenheimI.php';
						break;
					}
				else
					include_once	'views/comingSoon.php';
				break;
			
	                  case 'formularVerkaufSpringer':
				if(isset($_GET['language']))
					switch ($_GET['language']) 
					{
						case 'd':
						include_once 'views/formulare/formularKueba/formularKuebaD.php';
						break;
						
						case 'f':
						include_once 'views/formulare/formularKueba/formularKuebaF.php';
						break;
						
						case 'i':
						include_once 'views/formulare/formularKueba/formularKuebaI.php';
						break;
					}
				else
					include_once	'views/comingSoon.php';
				break;



	                  case 'formularMonteur':
				if(isset($_GET['language']))
					switch ($_GET['language']) 
					{
						case 'd':
						include_once 'views/formulare/formularMonteur/formularMonteurD.php';
						break;
						
						case 'f':
						include_once 'views/formulare/formularMonteur/formularMonteurF.php';
						break;
						
						case 'i':
						include_once 'views/formulare/formularMonteur/formularMonteurI.php';
						break;
					}
				else
					include_once	'views/comingSoon.php';
				break;
			
			case 'cs':
				include_once 'views/comingSoon.php';
				break;
							
  			default:
    			include_once 'views/login.php';
    			break;
		}
	}
	else
	{
		include_once 'views/login.php';
	}
?>