<?php 
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require '../../../includes/db.php';

    if (isset($_SESSION['CNP']) && isset($_POST['submitComment']) && isset($_POST['comment']) && !empty($_POST['comment'])){
    $ids = $_SESSION['ticketIDs'];
    $sqlTickets = "SELECT id, accountID, status FROM tickets WHERE id='$ids'";
    $resultTickets = $connection->query($sqlTickets);
        if($rowTickets = $resultTickets->fetch_assoc()) {
        $ticketID = $rowTickets['id'];
        $accountID = $rowTickets['accountID'];
        $status = $rowTickets['status'];
        } else header ('Location: https://novacdan.ro');
        
        if (($accountID == $_SESSION['id'] || $_SESSION['isMedic'] == 1) && $status == 1) {
            $id = $_SESSION['id'];
    	    $nameCreator = $_SESSION['utilizator'];
    	    $medicComment = $_SESSION['isMedic'];
    	    $comment =  filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
    	    $date = time();
    	    
    	    if (strlen($comment)<256 && 5<strlen($comment)) {
    	        $query = "INSERT INTO tickets_comments (accountID, ticketID, nameCreator, date, text, medicComment) VALUES ('$id', '$ticketID','$nameCreator','$date', '$comment', '$medicComment')";
    	        mysqli_query($connection, $query);
    		    header('Location: https://hospiweb.novacdan.ro/panel/ticket/view?id='.$ticketID.'');
    	    } else header  ('Location: https://hospiweb.novacdan.ro/panel/ticket/view?id='.$ticketID.'&eroare=lungime');
            
        } else header  ('Location: https://hospiweb.novacdan.ro/login');

    } else header ('Location: https://hospiweb.novacdan.ro/login');

?> 
