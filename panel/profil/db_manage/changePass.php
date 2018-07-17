<?php
    session_start();
    require '../../../includes/db.php';
    require '../../../includes/csrf.php';
	if(!isset($_SESSION['CNP']))
    	header ('Location: https://hospiweb.novacdan.ro/login');
    else {
        $CNP = $_SESSION['CNP'];
    }
    	
    if(isset($_POST['actualPass']) && !empty($_POST['actualPass']) && isset($_POST['changePass']) && isset($_POST['csrf']) && !empty($_POST['changePass']) && isset($_POST['submitChangePass'])) {
        
    if (hash_equals($csrf, $_POST['csrf'])){    
        
        $oldPassword = filter_input(INPUT_POST, 'actualPass', FILTER_SANITIZE_STRING);
        $newPassword = filter_input(INPUT_POST, 'changePass', FILTER_SANITIZE_STRING);
        $newPasswordConfirm = filter_input(INPUT_POST, 'changePassConfirm', FILTER_SANITIZE_STRING);
        
     if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/', $newPassword)) {
        if ($newPassword == $newPasswordConfirm) {
        
            $sql = "SELECT * FROM utilizatori WHERE CNP='$CNP'";
            $result = mysqli_query($connection, $sql);
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];
            $checkOld = password_verify($oldPassword, $hashedPassword);
            
                if ($checkOld == 1) {
                    
                    $checkNew = password_verify($newPassword, $hashedPassword);
                    
                        if ($checkNew == 0) {
                            $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                            $queryUpdate = "UPDATE utilizatori SET password = '$newHashedPassword' WHERE CNP = '$CNP' LIMIT 1";
                            mysqli_query($connection, $queryUpdate);
                            header ('Location: https://hospiweb.novacdan.ro/panel/profil/eu?succes=changePass');
                        } else header ('Location: https://hospiweb.novacdan.ro/panel/profil/eu?eroare=aceeasiParola');
                    
                } else header ('Location: https://hospiweb.novacdan.ro/panel/profil/eu?eroare=parolaGresita'); // Parola veche nu e aia din baza de date
            
        } else header ('Location: https://hospiweb.novacdan.ro/panel/profil/eu?eroare=nuCoincid'); // Cele doua parole nu coincid
     } else header ('Location: https://hospiweb.novacdan.ro/panel/profil/eu?eroare=criterii'); // Nu indeplineste toate criteriile
    } else header ('Location: https://hospiweb.novacdan.ro/panel/profil/eu');
    } else header ('Location: https://hospiweb.novacdan.ro/panel/profil/eu');
?>