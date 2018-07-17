<?php

session_start();

require 'db.php';
require 'csrf.php';
if (isset($_POST['CNP']) && !empty($_POST['CNP']) && isset($_POST['password']) && isset($_POST['csrf']) && !empty($_POST['password']) && isset($_POST['login'])) {
    
    if (hash_equals($csrf, $_POST['csrf'])){
    
    $CNP = filter_input(INPUT_POST, 'CNP', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $lastLogin = time();
    $sql = "SELECT * FROM utilizatori WHERE CNP='$CNP'";
    $result = mysqli_query($connection, $sql);
    $row = $result->fetch_assoc();
    $hash = $row['password'];
    
    $check = password_verify($password, $hash);
    
    if ($check == 0) {
        header("Location: https://hospiweb.novacdan.ro/login?eroare=1");
        die();
        
    } else {
        
        $sql = "SELECT * FROM utilizatori WHERE CNP = '$CNP' AND password = '$hash'";
        $result = mysqli_query($connection, $sql);
        
        if (!$row = $result->fetch_assoc()) {
            header ('Location: https://hospiweb.novacdan.ro/login?eroare=1');
        } else {
            $_SESSION['id'] = $row['id'];
            $_SESSION['CNP'] = $row['CNP'];
            $_SESSION['mail'] = $row['mail'];
            $_SESSION['utilizator'] = $row['utilizator'];
            $_SESSION['telefon'] = $row['telefon'];
            $_SESSION['sex'] = $row['sex'];
            $_SESSION['sange'] = $row['sange'];
            $_SESSION['stare'] = $row['stare'];
            $_SESSION['isMedic'] = $row['isMedic'];
            $_SESSION['isMod'] = $row['isMod'];
            $resultLogin = mysqli_query($connection, "UPDATE utilizatori SET lastLogin='$lastLogin' WHERE CNP= '$CNP' AND password = '$hash'");
        }
        
        header("Location: https://hospiweb.novacdan.ro/login");
        
    }

    }   else { header ('Location: https://hospiweb.novacdan.ro/login'); }
} else {
    header ('Location: https://hospiweb.novacdan.ro/');
}

?>