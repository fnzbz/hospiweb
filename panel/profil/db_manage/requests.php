<?php
	session_start();
	require '../../../includes/db.php';

  if (isset($_SESSION['CNP']) && $_SESSION['isMedic'] == 1){
      if (isset($_POST['removePacient'])) {
        $id = filter_input(INPUT_POST, 'removePacient', FILTER_SANITIZE_STRING);
        $medicID = $_SESSION['id'];
        if (is_numeric($id)){
            $query = "SELECT id FROM medicperm WHERE id = '$id' AND medicID='$medicID'";
    		$result = $connection->query($query);
    		if ($result->num_rows > 0) {
    	        $queryDelete = "DELETE FROM medicperm WHERE id='$id' AND medicID='$medicID'";
    			mysqli_query($connection, $queryDelete);
    			header('Location: ' . $_SERVER['HTTP_REFERER']);
    		} else header('Location: https://hospiweb.novacdan.ro/login');
        } else header('Location: https://hospiweb.novacdan.ro/login');
      } else if (isset($_POST['acceptPacient'])) {
        $id = filter_input(INPUT_POST, 'acceptPacient', FILTER_SANITIZE_STRING);
        $medicID = $_SESSION['id'];
        $date = time();
        if (is_numeric($id)){
            $query = "SELECT id FROM medicperm WHERE id = '$id' AND medicID='$medicID'";
    		$result = $connection->query($query);
    		if ($result->num_rows > 0) {
    	        $queryUpdate = "UPDATE medicperm SET isAcc=1, date='$date' WHERE medicID='$medicID' AND id='$id'";
    			mysqli_query($connection, $queryUpdate);
    			header('Location: ' . $_SERVER['HTTP_REFERER']);
    		} else header('Location: https://hospiweb.novacdan.ro/login');
        } else header('Location: https://hospiweb.novacdan.ro/login');          
      };
  } else header('Location: https://hospiweb.novacdan.ro/login');
?>