<?php
	session_start();
	require '../../../includes/db.php';

	$sistola = filter_input(INPUT_POST, 'sistola', FILTER_SANITIZE_STRING);
	$diastola = filter_input(INPUT_POST, 'diastola', FILTER_SANITIZE_STRING);
	$pulse = filter_input(INPUT_POST, 'puls', FILTER_SANITIZE_STRING);

	if(isset($sistola) && isset($diastola) && !empty($sistola) && !empty($diastola) && isset($pulse) && !empty($pulse))
	{
		if(is_numeric($sistola) && is_numeric($diastola) && is_numeric($pulse) && $sistola <= 250 && $sistola >= 70 && $pulse <= 200 && $pulse >= 40 )
		{
			$cnp = $_SESSION['CNP'];
			$query = "SELECT * FROM heartbeat_chart WHERE accountCNP = '$cnp' ORDER BY keyID DESC LIMIT 1";

			$result = $connection->query($query);

			if(!($result->num_rows))
			{
				$query_Chart = "INSERT INTO heartbeat_chart (accountCNP, sistola, diastola, pulse, day, timestamp) VALUES ('$cnp', '$sistola', '$diastola', '$pulse', '1', UNIX_TIMESTAMP())";
				mysqli_query($connection, $query_Chart);
				header('Location: https://hospiweb.novacdan.ro/panel/profil/eu');
			}
			else
			{
				$rows = $result->fetch_assoc();
				$timestamp = $rows['timestamp'];

				if(($timestamp - ($timestamp % 86400)) + 86400 <= time())
				{
					$day = $rows['day'];
					$day = $day + 1;
					$query_Chart = "INSERT INTO heartbeat_chart (accountCNP, sistola, diastola, pulse, day, timestamp) VALUES ('$cnp', '$sistola', '$diastola', '$pulse', '$day', UNIX_TIMESTAMP())";
					mysqli_query($connection, $query_Chart);
					header('Location: https://hospiweb.novacdan.ro/panel/profil/eu');
				}
				else
					header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?eroaregraf=3');
			}
		}
		else
			header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?eroaregraf=2');

	}
	else
		header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?eroaregraf=1');

?>