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
        		    echo 'Fotografia nu a fost gasita ca sa poata fi stearsa';       
        		    }
        		} else {
            		$queryINSERT = "INSERT INTO avatars (accountID, avatarName) VALUES ('$photoID', '$photoNameNew')";
    			    mysqli_query($connection, $queryINSERT);
    			    header("Location: " . $_SERVER["HTTP_REFERER"]);
        		}
            } else {
                echo "Fotografia depaseste 2mb, latimea este mai mare ca si inaltimea sau este prea mica in inaltime (dimensiune minima: 250px)";
            }
        } else {
            echo "S-a produs o eroare in uploadarea pozei";
        }
    } else {
        echo "Fisierul nu are extensia potrivita ('$photoActualExtension')";
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
    		    echo 'Fotografia nu a fost gasita ca sa fie stearsa';       
    		    }
    		} else {
        		echo 'Fotografia nu a fost stearsa (Delete Button)';       		    
    		}        
    } else header('Location: https://google.ro');  
} else header('Location: https://google.ro');


?>