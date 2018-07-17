<?php
	session_start();
	require '../../../includes/db.php';

	$stare = filter_input(INPUT_POST, 'stare_pacient', FILTER_SANITIZE_STRING);
	$id = $_SESSION['utilizator_edit'];
	if(isset($stare) && is_numeric($stare) && is_numeric($id))
	{
		$new_stare = mysqli_real_escape_string($connection, $stare);
		mysqli_query($connection, "UPDATE utilizatori SET stare = '$new_stare' WHERE id = '$id'");
		header('Location: https://hospiweb.novacdan.ro/panel/profil/utilizator?id='.$id);
	}
	else
		header('Location: https://hospiweb.novacdan.ro/panel/profil/utilizator?id='.$id);

?>