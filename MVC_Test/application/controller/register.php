<?php

	class Register extends Controller
	{
		public function index()
		{
			$errorPage = 0;
			require 'application/views/register.php';
		}

		public function signup()
		{
			$register_model = $this->loadModel('RegisterModel');
			if(isset($_POST['mail']) && isset($_POST['utilizator']) && isset($_POST['password']) && isset($_POST['CNP']) && isset($_POST['register']))
			{
				$Mail = $_POST['mail'];
				$Username = filter_input(INPUT_POST, 'utilizator', FILTER_SANITIZE_STRING);
				$CNP = filter_input(INPUT_POST, 'CNP', FILTER_SANITIZE_STRING);
				$Phone = filter_input(INPUT_POST, 'telefon', FILTER_SANITIZE_STRING);
				$Password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
				$cPassword = filter_input(INPUT_POST, 'confirmed-password', FILTER_SANITIZE_STRING);
				$bloodGroup = filter_input(INPUT_POST, 'sange', FILTER_SANITIZE_STRING);
				$Agreement = $_POST['agreement'];

				$cnpSex = $CNP[0];
				$Sex = 0;
				switch($cnpSex)
				{
					case 1:
						$Sex = 1;
						break;
					case 3:
						$Sex = 1;
						break;
					case 5:
						$Sex = 1;
						break;
					case 2:
						$Sex = 2;
						break;
					case 4:
						$Sex = 2;
						break;
					case 6:
						$Sex = 2;
						break;
					default:
						$Sex = 3;
						break;
				}

				$CNPAUX=$CNP;
				$verificare = $CNPAUX%10;
				$CNPAUX = intval($CNPAUX/10); 
				$verificareNo = 279146358279;
				$suma = 0;
				$x = $CNPAUX;

				for ($i=0;$i<12;$i++) 
				{
					$suma += ($x%10) * ($verificareNo%10); 
					$x = intval($x/10); 
					$verificareNo = intval($verificareNo/10);
				}

				$verificarea = $suma % 11; 
				if ($verificarea===10) 
					$verificarea=1;

				$sy = 0;
				switch($cnpSex)
				{
					case 1: 
						$sy = 19;
						break;
					case 2:
						$sy = 19;
						break;
					case 3: 
						$sy = 18;
						break;
					case 4:
						$sy = 18;
						break;
					default: 
						$sy = 20;
						break;
				}
				$year = $sy.$CNP[1].$CNP[2];
				$month = $CNP[3].$CNP[4];
				$day = $CNP[5].$CNP[6];

				$birthDate = $day.'-'.$month.'-'.$year;
				$birthTimestamp = strtotime($birthDate);

				$cityCnp = $CNP[7].$CNP[8];
				switch($cityCnp)
				{
				    case "01": $city='Alba';
				    break;
				    case "02": $city='Arad';
				    break;
				    case "03": $city='Arges';
				    break;
				    case "04": $city='Bacau';
				    break;
				    case "05": $city='Bihor';
				    break;
				    case "06": $city='Bistrita-Nasaud';
				    break;
				    case "07": $city='Botosani';
				    break;
				    case "08": $city='Brasov';
				    break;
				    case "09": $city='Braila';
				    break;
				    case "10": $city='Buzau';
				    break;
				    case "11": $city='Caras-Severin';
				    break;
				    case "12": $city='Cluj';
				    break;
				    case "13": $city='Constanta';
				    break;
				    case "14": $city='Covasna';
				    break;
				    case "15": $city='Dambovita';
				    break;
				    case "16": $city='Dolj';
				    break;
				    case "17": $city='Galati';
				    break;
				    case "18": $city='Gorj';
				    break;
				    case "19": $city='Harghita';
				    break;
				    case "20": $city='Hunedoara';
				    break;
				    case "21": $city='Ialomita';
				    break;
				    case "22": $city='Iasi';
				    break;
				    case "23": $city='Ilfov';
				    break;
				    case "24": $city='Maramures';
				    break;
				    case "25": $city='Mehedinti';
				    break;
				    case "26": $city='Mures';
				    break;
				    case "27": $city='Neamt';
				    break;
				    case "28": $city='Olt';
				    break;
				    case "29": $city='Prahova';
				    break;
				    case "30": $city='Satu Mare';
				    break;
				    case "31": $city='Salaj';
				    break;
				    case "32": $city='Sibiu';
				    break;
				    case "33": $city='Suceava';
				    break;
				    case "34": $city='Teleorman';
				    break;
				    case "35": $city='Timis';
				    break;
				    case "36": $city='Tulcea';
				    break;
				    case "37": $city='Vaslui';
				    break;
				    case "38": $city='Valcea';
				    break;
				    case "39": $city='Vrancea';
				    break;
				    case "40": $city='Bucuresti';
				    break;
				    case "41": $city='Bucuresti';
				    break;
				    case "42": $city='Bucuresti';
				    break;
				    case "43": $city='Bucuresti';
				    break;
				    case "44": $city='Bucuresti';
				    break;
				    case "45": $city='Bucuresti Sector 1';
				    break;
				    case "46": $city='Bucuresti Sector 2';
				    break;
				    case "47": $city='Bucuresti Sector 3';
				    break;
				    case "48": $city='Bucuresti Sector 4';
				    break;
				    case "49": $city='Bucuresti Sector 5';
				    break;
				    case "50": $city='Bucuresti Sector 6';
				    break;
				    case "51": $city='Calarasi';
				    break;
				    case "52": $city='Giurgiu';
				    break;
				}

				$passwordHashed = password_hash($Password, PASSWORD_DEFAULT);
				$errorPage = 0;
				if($register_model->checkUser($CNP))
					$errorPage = 1;
				else if($Password != $cPassword)
					$errorPage = 2;
				else if(!isset($Agreement))
					$errorPage = 3;
				else if(!filter_var($Mail, FILTER_VALIDATE_EMAIL))
					$errorPage = 4;
				//else if($verificare !== $verificarea)
					//$errorPage = 5;
				else if(!preg_match('/\b([A-Z]{1}[a-z]{1,30}[- ]{0,1}|[A-Z]{1}[- \']{1}[A-Z]{0,1}[a-z]{1,30}[- ]{0,1}|[a-z]{1,2}[ -\']{1}[A-Z]{1}[a-z]{1,30}){2,5}/', $Username))
					$errorPage = 6;
				else if(!preg_match('/^(?:(?:(?:00\s?|\+)40\s?|0)(?:7\d{2}\s?\d{3}\s?\d{3}|(21|31)\d{1}\s?\d{3}\s?\d{3}|((2|3)[3-7]\d{1})\s?\d{3}\s?\d{3}|(8|9)0\d{1}\s?\d{3}\s?\d{3}))$/', $Phone))
					$errorPage = 7;
				else if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/', $Password))
					$errorPage = 8;
				if($errorPage)
				{
					header('Location: '. URL .'register/error/'. $errorPage);
					die();
				}

				$data = array(
					':mail' => $Mail,
					':utilizator' => $Username,
					':cnp' => $CNP,
					':password' => $passwordHashed,
					':phone' => $Phone,
					':sex' => $Sex,
					':sange' => $bloodGroup,
					':nascut' => $birthTimestamp,
					':judet' => $city
				);
				$register_model->insertUser($data);
				header('Location: '. URL.'login/registerSuccess');
			}
			else
				header('Location: '. URL .'register');
		}

		public function error($errorCode)
		{
			$errorPage = $errorCode;
			require 'application/views/register.php';
		}
	}