<!DOCTYPE html>
<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require '../../includes/db.php';  
if (!isset($_SESSION['CNP'])){
    header ('Location: https://hospiweb.novacdan.ro/login');
    }
else {
    $s_cnp = $_SESSION['CNP'];
    $sql = "SELECT id, utilizator, CNP, isMedic FROM utilizatori WHERE CNP='$s_cnp'";
    $result = $connection->query($sql);
        if($row = $result->fetch_assoc()) {
        $s_id = $row['id'];
        $s_utilizator = $row['utilizator'];
        $s_CNP = $row['CNP'];
        $s_medic = $row['isMedic'];
        }
}

 if ($s_medic == 0) {
  $sqlTickets = "SELECT * FROM tickets WHERE accountID ='$s_id' ORDER BY status DESC, id DESC, urgenta DESC" ;
  $resultTickets = $connection->query($sqlTickets);
 }
 else if ($s_medic == 1) {
     $sqlTickets = "SELECT * FROM tickets ORDER BY status DESC, id DESC, urgenta DESC" ;
     $resultTickets = $connection->query($sqlTickets);  
 }

$ticketTotals_Query = "SELECT COUNT(id) FROM tickets";
$resultTicket = $connection->query($ticketTotals_Query);
$rowsTickets = $resultTicket->fetch_assoc();
$ticketTotals = $rowsTickets['COUNT(id)'];

$ticketDeschis_Query = "SELECT COUNT(id) FROM tickets WHERE status = 1";
$resultTicket = $connection->query($ticketDeschis_Query);
$rowsTickets = $resultTicket->fetch_assoc();
$ticketOpen = $rowsTickets['COUNT(id)'];

$ticketClosed = $ticketTotals - $ticketOpen;
?>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HospiWeb | Panou - Doctori</title>
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="../../../regulament/assets/css/bootstrap-better-nav.css">
    <link rel="stylesheet" href="../../regulament/assets/css/styles.css">
    <link rel="stylesheet" href="../../assets/fonts/font-awesome.min.css">
    <meta charset="utf-8">
</head>

<body>
 <?php include"../../includes/header.php";?>  
    <section class="bunvenit">
        <div class="container">
            <div class="alert alert-light" role="alert">
               <?php echo '<h5><span>Esti autentificat ca '.$s_utilizator;echo'!</h5>'; if ($s_medic == 1) { echo '<p> Aici poți vedea toate ticketele de pe platformă:<p></span>'; } else echo '<p> Aici poți vedea ticketele create de tine:<p></span>'; ?>
            </div>
            <?php 
           if (isset($_GET['succes']) && $_GET['succes']=='sterge'){
            echo '<div role="alert" class="alert alert-success">
                <span><strong>Succes! </strong>Ticket-ul a fost șters!</span>
            </div>'; }    
           if (isset($_GET['succes']) && $_GET['succes']=='adaugat'){
            echo '<div role="alert" class="alert alert-success">
                <span><strong>Succes! </strong>Ticket-ul a fost adaugat cu succes!</span>
            </div>'; }  
            if (isset($_GET['eroare']) && $_GET['eroare']=="medic"){
            echo '<div role="alert" class="alert alert-danger">
                <span><strong>Eroare! </strong>Medicii nu pot trimite tickete de ajutor!</span>
            </div>'; }
            if (isset($_GET['eroare']) && $_GET['eroare']=="nu"){
            echo '<div role="alert" class="alert alert-danger">
                <span><strong>Eroare! </strong>Unul sau mai multe câmpuri nu au fost completate!</span>
            </div>'; }
            if (isset($_GET['eroare']) && $_GET['eroare']=="nu"){
            echo '<div role="alert" class="alert alert-danger">
                <span><strong>Eroare! </strong>Unul sau mai multe câmpuri nu au fost completate!</span>
            </div>'; }
            if (isset($_GET['eroare']) && $_GET['eroare']=="lungime"){
            echo '<div role="alert" class="alert alert-danger">
                <span><strong>Eroare! </strong>Formularul completat de tine este prea scurt sau prea lung!</span>
            </div>'; }
            if (isset($_GET['eroare']) && $_GET['eroare']=="submisii" && $s_medic == 0){
                if ($_SESSION['ticketDeschis'] < 3) {
                    echo '<div role="alert" class="alert alert-success">
                        <span><strong>Eroare! </strong>Poti avea maxim 3 tickete deschise simultan! Acum poti deschide un nou ticket!</span>
                    </div>'; }
                else { echo'<div role="alert" class="alert alert-danger">
                        <span><strong>Eroare! </strong>Poti avea maxim 3 tickete deschise simultan!</span>
                    </div>' ;}
            }
            if (isset($_GET['eroare']) && $_GET['eroare']==1){
            echo '<div role="alert" class="alert alert-danger">
                <span><strong>Eroare! </strong>Pacienții pot vedea doar ticketele create de ei!</span>
            </div>'; }
            if (isset($_GET['eroare']) && $_GET['eroare']==2){
            echo '<div role="alert" class="alert alert-danger">
                <span><strong>Eroare! </strong>Acest ticket nu a fost găsit în baza noastră de date!</span>
            </div>'; }
            if (isset($_GET['eroare']) && $_GET['eroare']==3){
            echo '<div role="alert" class="alert alert-danger">
                <span><strong>Eroare! </strong>Anti SQL Injection!</span>
            </div>'; }?>
        </div>
        
    </section>
<section class="ticket-view section-padding">
    <div class="container">
        <div class="card" style="margin-top:20px;">
            <div class="card-body">
                <?php if ($s_medic == 0) { echo'
                <form action="create">
                <button class="btn btn-success" type="submit" style="margin:0 0 20px 0;">Creează un nou ticket</button></form>'; }
                else {
                    echo '<p><h6>Statisticile ticketelor</h6></p>
                    <p><span>Numar total tickete:</span> <span class="label ball">'.$ticketTotals.'</span> <span>  Numar tickete deschise:</span> <span class="label ball">'.$ticketOpen.'</span> <span>Numar tickete inchise: </span><span class="label ball">'.$ticketClosed.'</span></p><hr>';
                }
                ?>
                <div class="table-responsive">
                    <table  class="table table-striped-profile ticket">
                        <thead>
                            <tr><?php
                                if ($s_medic == 1){
                                    echo'<th>ID</th>';
                                }
                                if ($s_medic == 1){
                                    echo'<th>Creator</th>';
                                }
                                ?>
                                <th>Departament</th>
                                <th>Subiect</th>
                                <th>Dată creare</th>
                                <th>Status</th>
                                <th>Urgență</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if ($resultTickets->num_rows > 0) {
                                while($rowTickets = $resultTickets->fetch_assoc()) {
                                    $id = $rowTickets['id'];
                                    $accountID = $rowTickets['accountID'];
                                    $subiect = $rowTickets['subiect'];
                                    $departament = $rowTickets['departament'];
                                    $data = $rowTickets['data'];
                                    $status = $rowTickets['status'];
                                    $urgenta = $rowTickets['urgenta'];
                                    $numeCreator = $rowTickets['numeCreator'];
                                
                            echo'
                            <tr>';
                                if ($s_medic == 1){    
                                    echo'<td>#'.$id.'</td>';
                                }
                                if ($s_medic == 1) {
                                    echo'<td><a href="https://hospiweb.novacdan.ro/panel/profil/utilizator?id='.$accountID.'">'.$numeCreator.'</a></td>';
                                }
                                echo '<td>';
                                switch ($departament) {
                                    case 1: echo 'Tehnic';
                                    break;
                                    case 2: echo 'Informații';
                                    break;
                                    case 3: echo 'Medicină';
                                    break;
                                    default: echo 'Fără';
                                }
                                echo '</td>
                                <td><a href="https://hospiweb.novacdan.ro/panel/ticket/view?id='.$id.'">'.$subiect.'</a></td>
                                <td>'.date('d-m-Y H:i', $data).'</td>
                                <td>';
                                switch ($status) {
                                    case 1: echo'<span class="label" style="background-color:green; font-size: 13px">Deschis</span>';
                                    break;
                                    case 0: echo'<span class="label" style="background-color:red; font-size: 13px">Închis</span>';
                                    break;
                                    default: echo '<span class="label" style="background-color:gray; font-size: 13px">Stricat</span>';
                                }
                               echo '</td>
                                <td>';
                                switch ($urgenta) {
                                    case 1: echo 'Ușoară';
                                    break;
                                    case 2: echo 'Medie';
                                    break;
                                    case 3: echo 'Ridicată';
                                    break;
                                    default: echo 'Fără';
                                }
                                echo '</td>
                            </tr>';
                                }
                            } else {
                            if ($s_medic == 0) {
                            echo '<tr><td>Nu ai niciun ticket creat!</td><td></td><td></td><td></td><td></td></tr>'; }
                            else echo '<tr><td>Nu exista niciun ticket pe platforma!</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>'; }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
 <?php 
    $_SESSION['ticketDeschis'] = $ticketOpen;
    include"../../includes/footer.php";?>
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../assets/js/functions.js"></script>
    <script src="../../assets/js/bootstrap-better-nav.js"></script>
</body>
</html>