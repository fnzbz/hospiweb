<?php
	session_start();
	require '../../../includes/db.php';

	if(isset($_POST['exfizice']) && !empty($_POST['exfizice']) && isset($_POST['vaccinuri']) && !empty($_POST['vaccinuri']) && isset($_POST['submit']) && isset($_SESSION['id']) && isset($_SESSION['isMedic']) && $_SESSION['isMedic'] == 0)
	{
	    $id = $_SESSION['id'];
		$query = "SELECT * FROM aditional_pacient WHERE accountID = '$id'";
		$result = $connection->query($query);
    	if($row = $result->fetch_assoc()) {
    	   $lastModified = $row['lastModified'];
    	 }
    		$limbasec = filter_input(INPUT_POST, 'limbasec', FILTER_SANITIZE_STRING);
    		if (is_numeric($_POST['greutate']) && ($_POST['greutate'])<=300 && ($_POST['greutate'])>=0){
    		$greutate = filter_input(INPUT_POST, 'greutate', FILTER_SANITIZE_STRING);
    		}
    		else
    		$greutate = 0;
    		if (is_numeric($_POST['inaltime']) && ($_POST['inaltime'])<=280 && ($_POST['inaltime'])>=0){
    		$inaltime = filter_input(INPUT_POST, 'inaltime', FILTER_SANITIZE_STRING);
    		}
    		else
    		$inaltime = 0;
    		$vaccinuri = filter_input(INPUT_POST, 'vaccinuri', FILTER_SANITIZE_STRING);
    		$oredormit = filter_input(INPUT_POST, 'oredormit', FILTER_SANITIZE_STRING);
    		$dependenta = filter_input(INPUT_POST, 'dependenta', FILTER_SANITIZE_STRING);
    		$exfizice = filter_input(INPUT_POST, 'exfizice', FILTER_SANITIZE_STRING);
    		$domiciliu = filter_input(INPUT_POST, 'domiciliu', FILTER_SANITIZE_STRING);
    		$alergii = filter_input(INPUT_POST, 'alergii', FILTER_SANITIZE_STRING);
    		$intoleranta = filter_input(INPUT_POST, 'intoleranta', FILTER_SANITIZE_STRING);
    		
			if($result->num_rows)
			{
			  if ((time() - $lastModified) > 60 * 30){
			      
			    $time=time();     
				$query_Update = "UPDATE aditional_pacient SET limbasec = '$limbasec', greutate = '$greutate', inaltime = '$inaltime', vaccinuri = '$vaccinuri', oredormit = '$oredormit', dependenta = '$dependenta', exfizice = '$exfizice', domiciliu = '$domiciliu', alergii = '$alergii', intoleranta = '$intoleranta', lastModified = '$time' WHERE accountID = '$id'";
				mysqli_query($connection, $query_Update);

				header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?action=succes');
			  } else header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?action=eroare'); 
			}
			else
			{
			    $time=time();
				$query_Insert = "INSERT INTO aditional_pacient (accountID, limbasec, greutate, inaltime, vaccinuri, oredormit, dependenta, exfizice, domiciliu, alergii, intoleranta, lastModified ) VALUES ('$id', '$limbasec', '$greutate', '$inaltime', '$vaccinuri', '$oredormit', '$dependenta', '$exfizice', '$domiciliu', '$alergii', '$intoleranta', '$time')";
				mysqli_query($connection, $query_Insert);

				header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?action=succes');
			}
	}
	else
		header('Location: https://hospiweb.novacdan.ro/panel/profil/eu');
?>