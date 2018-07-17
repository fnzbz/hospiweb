<?php
	session_start();
	require '../../../includes/db.php';

	if(isset($_POST['submitEditGrad']) && $_SESSION['isMod'] == 1)
	{
		$id = $_POST['submitEditGrad'];
		if (is_numeric($id)) {
		    $result = $connection->query("SELECT isMedic FROM utilizatori WHERE id = '$id'");
		    if($result->num_rows>0){
    		    $db_query = "UPDATE utilizatori SET isMedic = 1 WHERE id = '$id' AND isMedic = 0";
    		    mysqli_query($connection, $db_query);
    		    header('Location: ' . $_SERVER['HTTP_REFERER']); 
		    } else header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else header('Location: ' . $_SERVER['HTTP_REFERER']);
	} else header('Location: ' . $_SERVER['HTTP_REFERER']);
?>