<?php
	session_start();
	require '../../../includes/db.php';

	if(isset($_POST['text_simp']) && !empty($_POST['text_simp']))
	{
		$textNeMurdar = filter_input(INPUT_POST, 'text_simp', FILTER_SANITIZE_STRING);
		if(isset($_SESSION['id']))
		{
			$id = $_SESSION['id'];
			$query = "SELECT * FROM simptome_pacient WHERE accountID = '$id'";
			$result = $connection->query($query);
			if($result->num_rows)
			{
				$name = $_SESSION['utilizator'];
				$query_Update = "UPDATE simptome_pacient SET text = '$textNeMurdar', time = CURRENT_TIMESTAMP, medic = '$name' WHERE accountID = '$id'";
				mysqli_query($connection, $query_Update);

				header('Location: https://hospiweb.novacdan.ro/panel/profil/eu');
			}
			else
			{
				$name = $_SESSION['utilizator'];
				$query_Insert = "INSERT INTO simptome_pacient (accountID, text, medic) VALUES ('$id', '$textNeMurdar', '$name')";
				mysqli_query($connection, $query_Insert);

				header('Location: https://hospiweb.novacdan.ro/panel/profil/eu');
			}
		}
		else
			header('Location: https://hospiweb.novacdan.ro/login');
	}
	else
		header('Location: https://hospiweb.novacdan.ro/panel/profil/eu');
?>