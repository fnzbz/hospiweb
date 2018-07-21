<?php
	session_start();
	require '../../../includes/db.php';
if (isset($_SESSION['utilizator']) && $_SESSION['isMedic'] == 1) {
	$medicName = $_SESSION['utilizator'];
    if (isset($_POST['deleteCons'])){
        if (is_numeric($_POST['id'])){
        $cid = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        }
        $sqldelcons = "DELETE FROM consultatii_pacient WHERE id='$cid' AND medicName='$medicName'";
        $resultcons = $connection->query($sqldelcons);
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit;
    }
    else if (isset($_POST['deleteTreat'])){
        if (is_numeric($_POST['id'])){
        $tid = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        }
        $sqldeltreat = "DELETE FROM tratament_pacient WHERE id='$tid' AND medicName='$medicName'";
        $resulttreat = $connection->query($sqldeltreat);
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit;        
    }
    else if (isset($_POST['deleteTrans'])){
        if (is_numeric($_POST['id'])){
        $trid = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        }
        $sqldeltrans = "DELETE FROM transplanturi_pacient WHERE id='$trid' AND medicName='$medicName'";
        $resulttrans = $connection->query($sqldeltrans);
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit;        
    }
    else {
        header('Location: https://hospiweb.novacdan.ro/panel/profil/eu');
        exit;
    }
} else {
        header('Location: https://hospiweb.novacdan.ro/panel/profil/eu');
        exit;
    }
?>