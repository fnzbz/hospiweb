<?php
	
	session_start();
	require 'db.php';

	if(isset($_SESSION['whichAccount_Delete']) && $_SESSION['isMedic'] == 1 && isset($_POST['submitDelAcc']))
	{
		$id = $_SESSION['whichAccount_Delete'];
		if (is_numeric($id)){
		$result = $connection->query("SELECT isMedic FROM utilizatori WHERE id = '$id'");
		    if($result->num_rows>0){
        		$db_query = "DELETE FROM utilizatori WHERE id = '$id'";
        		mysqli_query($connection, $db_query);
        		header("Location: https://hospiweb.novacdan.ro/panel/pacienti");
		    } header("Location: https://hospiweb.novacdan.ro/panel/pacienti");
	} else header("Location: https://hospiweb.novacdan.ro/panel/pacienti");
	}
	else
		header("Location: https://hospiweb.novacdan.ro/panel/pacienti");
?>