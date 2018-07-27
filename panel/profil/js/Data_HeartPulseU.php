<?php
    header('Content-Type: application/json');
    session_start();
    require '../../../includes/db.php';
    if (isset($_SESSION['utilizator_edit'])) {
        $id = $_SESSION['utilizator_edit'];
        
        $querySelectA = "SELECT CNP FROM utilizatori WHERE id = '$id'";
        $resultA = $connection->query($querySelectA);
        $rowsA = $resultA->fetch_assoc();
        $CNP = $rowsA['CNP'];
        
        $querySelect = "SELECT sistola, diastola, pulse, day FROM heartbeat_chart WHERE accountCNP = '$CNP' ORDER BY day";
        $result = $connection->query($querySelect);
            
        $data = array();
        foreach ($result as $row)
            $data[] = $row;
            
        print json_encode($data);
    } else die();
?>
