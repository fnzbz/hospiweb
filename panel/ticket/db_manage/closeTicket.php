<?php
	session_start();
	require '../../../includes/db.php';
	
  if (isset($_SESSION['ticketIDs'])){
	$ticketIDs = $_SESSION['ticketIDs'];
	$submitTicket = $_POST['submitTicket'];
	if(isset($submitTicket) && is_numeric($ticketIDs))
	{
    $sqlTickets = "SELECT id, status FROM tickets WHERE id='$ticketIDs'";
    $resultTickets = $connection->query($sqlTickets);
        if($rowTickets = $resultTickets->fetch_assoc()) {
        $ticketID = $rowTickets['id'];
        $status = $rowTickets['status'];
        } else header ('Location: https://hospiweb.novacdan.ro');
    if ($status == 1)  {     
        $id = $_SESSION['id'];
	    $nameCreator = $_SESSION['utilizator'];
	    $medicComment = $_SESSION['isMedic'];
	    $comment = '<strong>Acțiune utilizator:</strong> Tichetul a fost închis!';
	    $date = time();
		mysqli_query($connection, "UPDATE tickets SET status = 0  WHERE id = '$ticketID'");
		mysqli_query($connection, "INSERT INTO tickets_comments (accountID, ticketID, nameCreator, date, text, medicComment) VALUES ('$id', '$ticketID','$nameCreator','$date', '$comment', '$medicComment')");
		header('Location: https://hospiweb.novacdan.ro/panel/ticket/view?id='.$ticketID.'');
    } 
    else header('Location: https://hospiweb.novacdan.ro/panel/profil/eu');
    }
	else header('Location: https://hospiweb.novacdan.ro/panel/ticket/view?id='.$ticketID.'');
} else header('Location: https://hospiweb.novacdan.ro/panel/profil/eu');

?>