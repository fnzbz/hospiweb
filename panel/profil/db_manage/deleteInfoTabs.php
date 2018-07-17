<?php
	session_start();
	require '../../../includes/db.php';
	$medicName = $_SESSION['utilizator'];
    if (isset($_POST['deleteCons'])){
        $cid = $_POST['id'];
        $sqldelcons = "DELETE FROM consultatii_pacient WHERE id='$cid' AND medicName='$medicName'";
        $resultcons = $connection->query($sqldelcons);
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit;
    }
    else if (isset($_POST['deleteTreat'])){
        $tid = $_POST['id'];
        $sqldeltreat = "DELETE FROM tratament_pacient WHERE id='$tid' AND medicName='$medicName'";
        $resulttreat = $connection->query($sqldeltreat);
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit;        
    }
    else if (isset($_POST['deleteTrans'])){
        $trid = $_POST['id'];
        $sqldeltrans = "DELETE FROM transplanturi_pacient WHERE id='$trid' AND medicName='$medicName'";
        $resulttrans = $connection->query($sqldeltrans);
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit;        
    }
    else {
        header('Location: https://hospiweb.novacdan.ro/panel/profil/eu');
        exit;
    }
?>