<?php

	require 'db.php';
	require 'functionEmail.php';
	session_start();

	if(!empty($_GET['code']) && isset($_GET['code']) && isset($_SESSION['CNP']))
	{
		$code = $_GET['code'];
		$selectQuery = "SELECT * FROM email_confirm WHERE code = '$code'";
		$result = $connection->query($selectQuery);
		$rows = $result->num_rows;
		$emailVars = $result->fetch_assoc();
		if($rows)
		{
			if($emailVars['dTimestamp'] > time())
			{
				$id = $emailVars['accountID'];
				$new_email = $emailVars['email'];
				$queryConfMail = "SELECT confirmedEmail FROM utilizatori WHERE id = '$id'";
    			$resultConfMail = $connection->query($queryConfMail);
    			$row = $resultConfMail->fetch_assoc();

    			$confirmedEmail = $row['confirmedEmail'];
    			if($confirmedEmail)
    			{
    				if($emailVars['timesValidated'] == 0)
    				{
	    				$newCode = genRandStr(30); 

	    				$queryUpdate = "UPDATE email_confirm SET code = '$newCode', cTimestamp = UNIX_TIMESTAMP(), dTimestamp = UNIX_TIMESTAMP()+1800, timesValidated = 1 WHERE accountID = '$id' AND code = '$code'";
	    				mysqli_query($connection, $queryUpdate);

	    				generateEmail($new_email, $newCode, 'includes/verifyEmail', 'panel/profil/eu', '1', '1');
    				    header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?succes=3');
    				}
    				else
    				{
    					$queryUpdate = "UPDATE utilizatori SET confirmedEmail = 1, mail = '$new_email' WHERE id = '$id'";
    					mysqli_query($connection, $queryUpdate);

    					$queryDelete = "DELETE FROM email_confirm WHERE code = '$code' AND accountID = '$id'";
    					mysqli_query($connection, $queryDelete);
                        //S-a facut schimbare e-mail   
    				    header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?succes=4');
    				}
    			}
    			else
    			{
    			  
    				$queryUpdate = "UPDATE utilizatori SET confirmedEmail = 1, mail = '$new_email' WHERE id = '$id'";
    				mysqli_query($connection, $queryUpdate);

    				$queryDelete = "DELETE FROM email_confirm WHERE code = '$code'";
    				mysqli_query($connection, $queryDelete);

    				header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?succes=4');
    			}
			}
			else
				header('Location: https://hospiweb.novacdan.ro/panel/profil/eu');
		}
		else
			header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?eroare=2');
	}
	else
		header('Location: https://hospiweb.novacdan.ro/panel/profil/eu');

?>