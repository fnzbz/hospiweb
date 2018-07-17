<?php
	session_start();
	require '../../../includes/db.php';
if (isset($_SESSION['CNP']) && $_SESSION['isMedic']==0){	//ATENTIE SA FIE PE 0 IS MEDIC!!!!
  if ($_SESSION['ticketDeschis'] < 3) {
    if (isset($_POST['submitTicket']) && isset($_POST['subiect']) && !empty($_POST['subiect']) && isset($_POST['departament']) && isset($_POST['urgenta']) && isset($_POST['text']) && !empty($_POST['text'])) {
    	
    	$id = $_SESSION['id'];
    	$numeCreator = $_SESSION['utilizator'];
    	$subiect = filter_input(INPUT_POST, 'subiect', FILTER_SANITIZE_STRING);
    	$departament = filter_input(INPUT_POST, 'departament', FILTER_SANITIZE_STRING);
    	$urgenta = filter_input(INPUT_POST, 'urgenta', FILTER_SANITIZE_STRING);
    	$text =  filter_input(INPUT_POST, 'text', FILTER_SANITIZE_STRING);
    	$data = time();
        
        if (strlen($subiect)>3 && strlen($subiect)<=32 && strlen($text)>3 && strlen($text)<=500) {
            $query = "INSERT INTO tickets (accountID, numeCreator, subiect, departament, urgenta, text, data) VALUES ('$id','$numeCreator','$subiect', '$departament','$urgenta','$text','$data')";
    		mysqli_query($connection, $query);
    		header('Location: https://hospiweb.novacdan.ro/panel/ticket/list?succes=adaugat');
        } else header('Location: https://hospiweb.novacdan.ro/panel/ticket/list?eroare=lungime');
    }
    else header ('Location:https://hospiweb.novacdan.ro/panel/ticket/list?eroare=no');
} else header ('Location:https://hospiweb.novacdan.ro/panel/ticket/list?eroare=submisii');
} else header ('Location:https://hospiweb.novacdan.ro/panel/ticket/list?eroare=medic');
?>