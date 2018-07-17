<?php
	session_start();
	require '../../../includes/db.php';

  if (isset($_SESSION['CNP'])){
    $priority = filter_input(INPUT_POST, 'trans_pacient', FILTER_SANITIZE_STRING);
	$mention = filter_input(INPUT_POST, 'text_trans', FILTER_SANITIZE_STRING);
	$id = $_SESSION['utilizator_edit'];
	if(isset($mention) && isset($priority) && is_numeric($priority) && isset($_POST['submitTransplant']))
	{
		$queryS = "SELECT COUNT(id) FROM transplanturi_pacient WHERE accountID = '$id'";
		$res = $connection->query($queryS); 
		$rowSearch = $res->fetch_assoc();
        $date = time();
		$medicName = $_SESSION['utilizator']; 
		if($rowSearch['COUNT(id)'] == 0){
			$query = "INSERT INTO transplanturi_pacient (accountID, priority, medicName, mention, date) VALUES ('$id', '$priority','$medicName', '$mention', '$date')";
			mysqli_query($connection, $query);
		}
		else{		
			$query = "UPDATE transplanturi_pacient SET medicName = '$medicName', priority = '$priority', mention = '$mention' WHERE accountID = '$id'";
			mysqli_query($connection, $query);
		}
		header('Location: https://hospiweb.novacdan.ro/panel/profil/utilizator?id='.$id);
	}
	else
		header('Location: https://hospiweb.novacdan.ro/panel/profil/utilizator?id='.$id);
  } else header('Location: https://hospiweb.novacdan.ro/login');
?>