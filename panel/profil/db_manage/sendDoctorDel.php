<?php
	session_start();
	require '../../../includes/db.php';

    if (isset($_SESSION['CNP']) && $_SESSION['isMedic'] == 0 && isset($_POST['submitDoctorDel'])) {
        $id = filter_input(INPUT_POST, 'submitDoctorDel', FILTER_SANITIZE_STRING);
		$query = "SELECT id FROM utilizatori WHERE id = '$id' AND isMedic = 1";
		$result = $connection->query($query); 
		    if ($result->num_rows > 0) {
		    $medicId = $id;
		    $pacientId = $_SESSION['id'];
		    $querySend = "SELECT medicID FROM medicperm WHERE pacientID = '$pacientId' AND medicID = '$medicId' AND isAcc=1";
		    $resultSend = $connection->query($querySend); 
		    if ($resultSend->num_rows > 0) {
    			$queryInsert = "DELETE FROM medicperm WHERE pacientID = '$pacientId' AND medicID = '$medicId' LIMIT 1";
    			mysqli_query($connection, $queryInsert);
    			header('Location: https://hospiweb.novacdan.ro/panel/doctori');
		    } else {
    			header('Location: https://hospiweb.novacdan.ro/panel/doctori');}
		    } else header('Location: https://hospiweb.novacdan.ro/panel/doctori?eroare=negasit');
    }
	else header('Location: https://hospiweb.novacdan.ro/panel/profil/utilizator?id='.$id);
?>