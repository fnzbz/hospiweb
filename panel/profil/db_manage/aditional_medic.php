<?php
	session_start();
	require '../../../includes/db.php';

	if(isset($_POST['specializare']) && !empty($_POST['specializare']) && isset($_POST['submit']) && isset($_SESSION['id']) && isset($_SESSION['isMedic']) && $_SESSION['isMedic'] == 1)
	{
	$id = $_SESSION['id'];
	$query = "SELECT * FROM aditional_medic WHERE accountID = '$id'";
	$result = $connection->query($query);
	 if($row = $result->fetch_assoc()) {
	    $lastModified = $row['lastModified'];
	 } 
		$limbasec = filter_input(INPUT_POST, 'limbasec', FILTER_SANITIZE_STRING);
		$spital = filter_input(INPUT_POST, 'spital', FILTER_SANITIZE_STRING);
		$specializare = filter_input(INPUT_POST, 'specializare', FILTER_SANITIZE_STRING);
		$program = filter_input(INPUT_POST, 'program', FILTER_SANITIZE_STRING);
		$cabinet = filter_input(INPUT_POST, 'cabinet', FILTER_SANITIZE_STRING);
		$pret = filter_input(INPUT_POST, 'pret', FILTER_SANITIZE_STRING);

			if($result->num_rows)
			{
			   if ((time() - $lastModified) > 60 * 5){
			       
			    $time=time();
				$query_Update = "UPDATE aditional_medic SET limbasec = '$limbasec', spital = '$spital', specializare = '$specializare', program = '$program', cabinet = '$cabinet', pret = '$pret', lastModified = '$time' WHERE accountID = '$id'";
				mysqli_query($connection, $query_Update);

				header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?action=succes');
				
				} else header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?action=eroare'); 
			}
			else
			{
			    $time=time();
				$query_Insert = "INSERT INTO aditional_medic (accountID, limbasec, spital, specializare, program, cabinet, pret, lastModified) VALUES ('$id', '$limbasec', '$spital', '$specializare', '$program', '$cabinet', '$pret', '$time' )";
				mysqli_query($connection, $query_Insert);

				header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?action=succes');
			}

	}
	else
		header('Location: https://hospiweb.novacdan.ro/panel/profil/eu');
?>