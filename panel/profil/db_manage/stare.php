<?php
	session_start();
	require '../../../includes/db.php';

    if (isset ($_SESSION['isMedic']) && $_SESSION['isMedic'] == 1) {
	$stare = filter_input(INPUT_POST, 'stare_pacient', FILTER_SANITIZE_STRING);
	$id = $_SESSION['utilizator_edit'];
	if(isset($stare) && is_numeric($stare) && is_numeric($id))
	{
	    switch($stare) {
		case 0: mysqli_query($connection, "UPDATE utilizatori SET stare = 0 WHERE id = '$id'");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		break;
		case 1: mysqli_query($connection, "UPDATE utilizatori SET stare = 1 WHERE id = '$id'");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		break;
		case 2: mysqli_query($connection, "UPDATE utilizatori SET stare = 2 WHERE id = '$id'");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		break;
		case 3: mysqli_query($connection, "UPDATE utilizatori SET stare = 3 WHERE id = '$id'");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		break;
		default: header('Location: ' . $_SERVER['HTTP_REFERER']);
	    }
	}
	else
		header('Location: https://hospiweb.novacdan.ro/panel/profil/utilizator?id='.$id);
	} else header('Location: https://hospiweb.novacdan.ro/panel/profil/eu');

?>