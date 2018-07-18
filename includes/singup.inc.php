<?php

require 'db.php';

if (!empty($_POST['mail']) && !empty($_POST['utilizator']) && !empty($_POST['password']) && !empty($_POST['CNP']) && isset($_POST['mail']) && isset($_POST['utilizator']) && isset($_POST['password']) && isset($_POST['CNP']) && isset($_POST['register'])){  

$mail = $_POST['mail'];
$utilizator = filter_input(INPUT_POST, 'utilizator', FILTER_SANITIZE_STRING);
$CNP = filter_input(INPUT_POST, 'CNP', FILTER_SANITIZE_STRING);
$telefon = filter_input(INPUT_POST, 'telefon', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$confirmedpassword = filter_input(INPUT_POST, 'confirmed-password', FILTER_SANITIZE_STRING);
$cnpsex = $CNP[0];
if ($cnpsex == 1 || $cnpsex == 3 || $cnpsex == 5 ){
    $sex = 1;
}
else if ($cnpsex == 2 || $cnpsex == 4 || $cnpsex == 6){
    $sex = 2;
}
else {
    $sex = 3;
}
$sange = filter_input(INPUT_POST, 'sange', FILTER_SANITIZE_STRING);
$agreement = $_POST['agreement'];

$CNPAUX=$CNP;

$verificare = $CNPAUX%10;
$CNPAUX = intval($CNPAUX/10); 
$verificareNo = 279146358279;

$suma = 0;

$x = $CNPAUX;

for ($i=0;$i<12;$i++) {
	$suma += ($x%10) * ($verificareNo%10); 
	$x = intval($x/10); 
	$verificareNo = intval($verificareNo/10);
}

$verificarea = $suma % 11; 

if ($verificarea===10) 
	$verificarea=1;

if ($cnpsex == 1 || $cnpsex == 2) { $sy = 19; }
else if ($cnpsex == 3 || $cnpsex == 4) { $sy = 18; }
else if ($cnpsex == 5 || $cnpsex == 6) { $sy = 20; }
$an = $sy.$CNP[1].$CNP[2];
$luna = $CNP[3].$CNP[4];
$zi = $CNP[5].$CNP[6];
$nascut = $zi."-".$luna."-".$an;
$nascutTimestamp = strtotime($nascut);
$judetcnp = $CNP[7].$CNP[8];

switch ($judetcnp){
    case "01": $judet='Alba';
    break;
    case "02": $judet='Arad';
    break;
    case "03": $judet='Arges';
    break;
    case "04": $judet='Bacau';
    break;
    case "05": $judet='Bihor';
    break;
    case "06": $judet='Bistrita-Nasaud';
    break;
    case "07": $judet='Botosani';
    break;
    case "08": $judet='Brasov';
    break;
    case "09": $judet='Braila';
    break;
    case "10": $judet='Buzau';
    break;
    case "11": $judet='Caras-Severin';
    break;
    case "12": $judet='Cluj';
    break;
    case "13": $judet='Constanta';
    break;
    case "14": $judet='Covasna';
    break;
    case "15": $judet='Dambovita';
    break;
    case "16": $judet='Dolj';
    break;
    case "17": $judet='Galati';
    break;
    case "18": $judet='Gorj';
    break;
    case "19": $judet='Harghita';
    break;
    case "20": $judet='Hunedoara';
    break;
    case "21": $judet='Ialomita';
    break;
    case "22": $judet='Iasi';
    break;
    case "23": $judet='Ilfov';
    break;
    case "24": $judet='Maramures';
    break;
    case "25": $judet='Mehedinti';
    break;
    case "26": $judet='Mures';
    break;
    case "27": $judet='Neamt';
    break;
    case "28": $judet='Olt';
    break;
    case "29": $judet='Prahova';
    break;
    case "30": $judet='Satu Mare';
    break;
    case "31": $judet='Salaj';
    break;
    case "32": $judet='Sibiu';
    break;
    case "33": $judet='Suceava';
    break;
    case "34": $judet='Teleorman';
    break;
    case "35": $judet='Timis';
    break;
    case "36": $judet='Tulcea';
    break;
    case "37": $judet='Vaslui';
    break;
    case "38": $judet='Valcea';
    break;
    case "39": $judet='Vrancea';
    break;
    case "40": $judet='Bucuresti';
    break;
    case "41": $judet='Bucuresti';
    break;
    case "42": $judet='Bucuresti';
    break;
    case "43": $judet='Bucuresti';
    break;
    case "44": $judet='Bucuresti';
    break;
    case "45": $judet='Bucuresti Sector 1';
    break;
    case "46": $judet='Bucuresti Sector 2';
    break;
    case "47": $judet='Bucuresti Sector 3';
    break;
    case "48": $judet='Bucuresti Sector 4';
    break;
    case "49": $judet='Bucuresti Sector 5';
    break;
    case "50": $judet='Bucuresti Sector 6';
    break;
    case "51": $judet='Calarasi';
    break;
    case "52": $judet='Giurgiu';
    break;
    
}

$password_hashed = password_hash($password, PASSWORD_DEFAULT);

$sql = "SELECT CNP FROM utilizatori WHERE CNP='$CNP'";
$result = mysqli_query($connection, $sql);
$check = mysqli_num_rows($result);

if ($check > 0){
    header('Location: https://hospiweb.novacdan.ro/register?eroare=1');
    die();
} else if($password!=$confirmedpassword) {
    header('Location: https://hospiweb.novacdan.ro/register?eroare=2');
    die();   
} else if (!isset($agreement)){
    header('Location: https://hospiweb.novacdan.ro/register?eroare=3');
    die();  
} else if ($verificarea!==$verificare) {
    header('Location: https://hospiweb.novacdan.ro/register?eroare=5');
    die(); 
} else if (!preg_match('/\b([A-Z]{1}[a-z]{1,30}[- ]{0,1}|[A-Z]{1}[- \']{1}[A-Z]{0,1}[a-z]{1,30}[- ]{0,1}|[a-z]{1,2}[ -\']{1}[A-Z]{1}[a-z]{1,30}){2,5}/', $utilizator)) {
    header('Location: https://hospiweb.novacdan.ro/register?eroare=6');
    die();
} else if (!preg_match('/^(?:(?:(?:00\s?|\+)40\s?|0)(?:7\d{2}\s?\d{3}\s?\d{3}|(21|31)\d{1}\s?\d{3}\s?\d{3}|((2|3)[3-7]\d{1})\s?\d{3}\s?\d{3}|(8|9)0\d{1}\s?\d{3}\s?\d{3}))$/', $telefon)){
    header('Location: https://hospiweb.novacdan.ro/register?eroare=7');
    die(); 
} else if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/', $password)) {
    header('Location: https://hospiweb.novacdan.ro/register?eroare=8');
    die(); 
} else {
    
if  (filter_var($mail, FILTER_VALIDATE_EMAIL)) {


$sql = "INSERT INTO utilizatori (mail, utilizator, CNP, password, telefon, sex, sange, nascut, judet) VALUES ('$mail', '$utilizator','$CNP','$password_hashed','$telefon','$sex','$sange','$nascutTimestamp','$judet')";
$result = mysqli_query($connection, $sql);
 
header ('Location: https://hospiweb.novacdan.ro/login?actiune=succes');

} else {
    header ('Location: https://hospiweb.novacdan.ro/register?eroare=4');
}
}
} else {
    header ('Location: https://hospiweb.novacdan.ro/');
}


?>

