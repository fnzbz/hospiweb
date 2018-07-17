<?php
	session_start();
	require '../../../includes/db.php';

    if (isset($_SESSION['CNP']) && $_SESSION['isMedic'] == 0 && isset($_POST['submitDoctorReq'])) {
        $id = filter_input(INPUT_POST, 'submitDoctorReq', FILTER_SANITIZE_STRING);
		$query = "SELECT id FROM utilizatori WHERE id = '$id' AND isMedic = 1";
		$result = $connection->query($query); 
		    if ($result->num_rows > 0) {
		    $medicId = $id;
		    $pacientId = $_SESSION['id'];
		    $namePacient = $_SESSION['utilizator'];
		    $date = time();
		    $querySend = "SELECT medicID FROM medicperm WHERE pacientID = '$pacientId' AND medicID = '$medicId'";
		    $resultSend = $connection->query($querySend); 
		    if ($resultSend->num_rows > 0) {
		        header('Location: https://hospiweb.novacdan.ro/panel/doctori?eroare=limita');
		    } else {
    			$queryInsert = "INSERT INTO medicperm (pacientID, namePacient, medicID, date) VALUES ('$pacientId', '$namePacient','$medicId', '$date')";
    			mysqli_query($connection, $queryInsert);
    			header('Location: https://hospiweb.novacdan.ro/panel/doctori?action=succes');	}
		    } else header('Location: https://hospiweb.novacdan.ro/panel/doctori?eroare=negasit');
    }
	else header('Location: https://hospiweb.novacdan.ro/panel/profil/utilizator?id='.$id);
?>