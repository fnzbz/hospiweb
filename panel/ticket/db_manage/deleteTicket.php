<?php
	session_start();
	require '../../../includes/db.php';
	$ticketIDs = $_SESSION['ticketIDs'];
	$submitStergeTicket = $_POST['submitStergeTicket'];
	if(isset($submitStergeTicket) && is_numeric($ticketIDs) && $_SESSION['isMedic'] == 1)
	{
		mysqli_query($connection, "DELETE FROM tickets WHERE id = '$ticketIDs'");
		header('Location: https://hospiweb.novacdan.ro/panel/ticket/list?succes=sterge');
	}
	else
		header('Location: https://hospiweb.novacdan.ro/panel/ticket/list');

?>