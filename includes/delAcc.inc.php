<?php
	
	session_start();
	require 'db.php';

	if(isset($_SESSION['whichAccount_Delete']) && ($_SESSION['isMedic'] == 1 || $_SESSION['isMod'] == 1) && isset($_POST['submitDelAcc']))
	{
		$id = $_SESSION['whichAccount_Delete'];
		if (is_numeric($id)){
		$result = $connection->query("SELECT * FROM utilizatori WHERE id = '$id'");
		$resultAvatar = $connection->query("SELECT * FROM avatars WHERE accountID = '$id'");
		if($row = $result->fetch_assoc()) {
            $isMod = $row['isMod'];
        }
		    if($result->num_rows>0 && $isMod==0){
        		$db_query = "DELETE FROM utilizatori WHERE id = '$id' LIMIT 1";
        		mysqli_query($connection, $db_query);
        		if($resultAvatar->num_rows>0){
            		if($row = $resultAvatar->fetch_assoc()) {
                        $actualAvatar = $row['avatarName'];
                    }
                    unlink('../panel/profil/uploads/avatars/'.$actualAvatar);
                    header("Location: https://hospiweb.novacdan.ro/panel/pacienti");
        		}
        		header("Location: https://hospiweb.novacdan.ro/panel/pacienti");
		    } else header("Location: " . $_SERVER["HTTP_REFERER"]);
	} else header("Location: " . $_SERVER["HTTP_REFERER"]);
} else header("Location: https://hospiweb.novacdan.ro/panel/profil/eu");
?>
