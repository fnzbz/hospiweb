<?php

require '../../../includes/db.php';
session_start();

if (isset($_SESSION['CNP'])) {
    $photoID = $_SESSION['id'];
    $query = "SELECT * FROM avatars WHERE accountID = '$photoID'";
	$result = $connection->query($query);
    if (isset($_POST['upload-image'])) {
    $photo = $_FILES['photo'];
    $photoName = $_FILES['photo']['name'];
    $photoTmpName = $_FILES['photo']['tmp_name'];
    $photoSize = $_FILES['photo']['size'];
    $photoError = $_FILES['photo']['error'];
    $photoType = $_FILES['photo']['type'];
    $photoExtension = explode('.', $photoName);
    $photoActualExtension = strtolower(end($photoExtension));
    $allowed = array('jpg', 'jpeg', 'png');
    $photoDimensions = getimagesize($photoTmpName);
    $photoWidth = $photoDimensions[0];
    $photoHeight = $photoDimensions[1];
    if (in_array($photoActualExtension, $allowed)) {
        if ($photoError === 0){
            if ($photoSize <= 2097152 && $photoHeight > 250 && $photoWidth <= $photoHeight) {
                $photoNameNew = uniqid($photoID).".".$photoActualExtension;
                $photoDestination = '../uploads/avatars/'.$photoNameNew;
                move_uploaded_file($photoTmpName, $photoDestination);
        		if ($result->num_rows > 0) {
            		if($row = $result->fetch_assoc()) {
                        $actualAvatar = $row['avatarName'];
                    } 
        		    if(unlink('../uploads/avatars/'.$actualAvatar)) {
            		$queryUPDATE = "UPDATE avatars SET avatarName = '$photoNameNew' WHERE accountID = '$photoID'"; 
            		mysqli_query($connection, $queryUPDATE);           		    
            		header("Location: " . $_SERVER["HTTP_REFERER"]);
        		    } else {
        		    header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?avatar=negasit');       
        		    }
        		} else {
            		$queryINSERT = "INSERT INTO avatars (accountID, avatarName) VALUES ('$photoID', '$photoNameNew')";
    			    mysqli_query($connection, $queryINSERT);
    			    header("Location: " . $_SERVER["HTTP_REFERER"]);
        		}
            } else {
                header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?avatar=dimensiune');
            }
        } else {
            header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?avatar=eroare');
        }
    } else {
        header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?avatar=extensie');
    }

    } else if (isset($_POST['delete-image'])){
    		if ($result->num_rows > 0) {
        		if($row = $result->fetch_assoc()) {
                    $actualAvatar = $row['avatarName'];
                } 
    		    if(unlink('../uploads/avatars/'.$actualAvatar)) {
            		$queryDELETE = "DELETE FROM avatars WHERE accountID = '$photoID'";
    			    mysqli_query($connection, $queryDELETE);  
    			    header("Location: " . $_SERVER["HTTP_REFERER"]);
    		    } else {
    		        header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?avatar=negasit');  
    		    }
    		} else {
        		header('Location: https://hospiweb.novacdan.ro/panel/profil/eu?avatar=negasit');     		    
    		}        
    } else header("Location: " . $_SERVER["HTTP_REFERER"]);  
} else header("Location: " . $_SERVER["HTTP_REFERER"]);


?>
