<?php
	require '../../../includes/db.php';
	require '../../../includes/functionEmail.php';
	session_start();
    
    if(!empty($_POST['email_change']) && isset($_POST['email_change']) && isset($_SESSION['CNP']))
    {	
    	$id = $_SESSION['id'];

    	$queryConfMail = "SELECT confirmedEmail, mail FROM utilizatori WHERE id = '$id'";
    	$resultConfMail = $connection->query($queryConfMail);
    	$row = $resultConfMail->fetch_assoc();

    	$confirmedEmail = $row['confirmedEmail'];
    	$currentMail = $row['mail'];
    	
    	if(($confirmedEmail == 0) || ($confirmedEmail == 1 && $currentMail != $_POST['email_change']))
    	{
        	$codeValidate = genRandStr(32);
    
        	$sendTo = '';
        	if($confirmedEmail)
        		$sendTo = $currentMail;
        	else
        		$sendTo = filter_var($_POST['email_change'], FILTER_VALIDATE_EMAIL);
    
        	$new_email = $sendTo;
    
    
        	$sqlSelect = "SELECT id FROM email_confirm WHERE accountID = '$id' LIMIT 1";
        	$resultS = $connection->query($sqlSelect);
        	$rows = $resultS->num_rows;
    
        	if($rows)
        	{
        		$sqlUpdate = "UPDATE email_confirm SET code = '$codeValidate', email = '$new_email' WHERE accountID = '$id'";
        		mysqli_query($connection, $sqlUpdate);
        	}
        	else
        	{
    			$sqlInsert = "INSERT INTO email_confirm (accountID, code, email, cTimestamp, dTimestamp) VALUES ('$id', '$codeValidate', '$new_email', UNIX_TIMESTAMP(), UNIX_TIMESTAMP() + 1800)";
    			mysqli_query($connection, $sqlInsert);
        	}
    		generateEmail($sendTo, $codeValidate, 'includes/verifyEmail', 'panel/profil/eu', '1', '1');
    		    //success - 1 inseamna ca e-mailul s-a trimis ii spui sa isi verifice e-mailul actual si daca nu sa incerce sa se uite ori in spam sau sa contacteze un scripter.
    		header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?succes=1');
    	}
    	else
    	    header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?eroare=5');
    }
    else
        header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?eroare=1'); //Asta verifica daca pacientul a trimis campul gol sau mailul este invalid.
?>