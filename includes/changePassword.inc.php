<?php
	session_start();
	
	require 'db.php';
	if(isset($_SESSION['CNP']))
    	header ('Location: https://hospiweb.novacdan.ro/');
	
	if(isset($_POST['password']) && !empty($_POST['password']) && isset($_SESSION['req-code']) && isset($_POST['cpass']) && !empty($_POST['cpass']) && isset($_POST['changepass']))
	{
		$pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
		$cpass = filter_input(INPUT_POST, 'cpass', FILTER_SANITIZE_STRING);
		$code = $_SESSION['req-code'];
		
		if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/', $pass)) {
            $link = 'Location: https://hospiweb.novacdan.ro/pass-reset?code='.$code.'&eroare=2';
            header($link);
            die(); 
        } else if ($pass != $cpass) {
		    $link = 'Location: https://hospiweb.novacdan.ro/pass-reset?code='.$code.'&eroare=1';
		    header($link);
		    die();            
        }
		
		else
		{
		    $hashed = password_hash($pass, PASSWORD_DEFAULT);
		    $querySelect_DB = "SELECT * FROM password_reset_req WHERE code = '$code'";
		    $result = $connection->query($querySelect_DB);
		    $row_req = $result->fetch_assoc();
		    $CNP = $row_req['CNP'];
            $queryUpdate = "UPDATE utilizatori SET password = '$hashed' WHERE CNP = '$CNP' LIMIT 1";
            mysqli_query($connection, $queryUpdate);
            $queryDelete = "DELETE FROM password_reset_req WHERE code = '$code' LIMIT 1";
            mysqli_query($connection, $queryDelete);
            header ('Location: https://hospiweb.novacdan.ro/login');
		}
	}
	else
		header ('Location: https://hospiweb.novacdan.ro/');
?>