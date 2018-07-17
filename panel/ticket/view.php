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
    if (isset($_GET['id'])) {
        $Gid = $_GET['id'];
        if (is_numeric($Gid)) {
        $sqlTickets = "SELECT * FROM tickets WHERE id ='$Gid'" ;
        $resultTickets = $connection->query($sqlTickets);
        if($rowTickets = $resultTickets->fetch_assoc()) {
            $id = $rowTickets['id'];
            $accountID = $rowTickets['accountID'];
            $numeCreator = $rowTickets['numeCreator'];
            $subiect = $rowTickets['subiect'];
            $departament = $rowTickets['departament'];
            $data = $rowTickets['data'];
            $status = $rowTickets['status'];
            $urgenta = $rowTickets['urgenta'];    
            $text = $rowTickets['text'];
        
        if ($s_medic == 1 || $s_id == $accountID) {    
         $sqlComment = "SELECT * FROM tickets_comments WHERE ticketID ='$id' ORDER BY id ASC" ;
         $resultComment = $connection->query($sqlComment);
        }
            
        } else header ('Location: https://hospiweb.novacdan.ro/panel/ticket/list?eroare=2'); 
        
    } else header ('Location: https://hospiweb.novacdan.ro/panel/ticket/list?eroare=3'); 
    
    if ($s_medic == 0 && $accountID != $s_id) {
      header ('Location: https://hospiweb.novacdan.ro/panel/ticket/list?eroare=1');  
    }
        
    } else header ('Location: https://hospiweb.novacdan.ro/panel/ticket/list');

  
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
               <?php echo '<h5><span>Esti autentificat ca '.$s_utilizator;echo'!</h5><p> Aici poți vedea tichet-ul cu numărul #'.$id.':<p></span>'; ?>
            </div>
        </div>
    </section>
    <section class="ticket-view section-separator">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-header-text"><i class="fa fa-users"></i>&nbsp;iNFORMAȚII DESPRE TICHET<br /></h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled"><?php echo'
                                <li><strong>Nume creator</strong>: <a href="https://hospiweb.novacdan.ro/panel/profil/utilizator?id='.$accountID.'">'.$numeCreator.'</a></li>
                                <li><strong>Subiect</strong>: '.$subiect.'</li>
                                <li><strong>Urgență</strong>: '; 
                                    switch ($urgenta) {
                                        case 1: echo 'Ușoară';
                                        break;
                                        case 2: echo 'Medie';
                                        break;
                                        case 3: echo 'Ridicată';
                                        break;
                                        default: echo 'Fără';
                                    }
                                echo'</li>
                                <li><strong>Departament</strong>: '; 
                                    switch ($departament) {
                                        case 1: echo 'Tehnic';
                                        break;
                                        case 2: echo 'Informații';
                                        break;
                                        case 3: echo 'Medicină';
                                        break;
                                        default: echo 'Fără';
                                    }                            
                                echo'</li>
                                <li><strong>Dată creare</strong>: '.date("d-m-Y H:i", $data).'</li>';
                                echo '<li><strong>Status</strong>: ';
                                switch ($status) {
                                    case 0: echo '<span style="color:red; font-size: 13px">Închis</span>';
                                    break;
                                    case 1: echo '<span style="color:green; font-size: 13px">Deschis</span>';
                                    break;
                                    default: echo '<span style="color:gray; font-size: 13px">Stricat</span>';
                                }
                                echo '</li>';; 
                                ?>
                            </ul>
                        </div>
                    </div>
                <?php if ($s_medic == 0 && $status == 0) { echo '';} else { echo '
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-header-text"><i class="fa fa-gear"></i>&nbsp;Acțiuni tichet<br /></h6>
                                </div>
                                <div class="card-body">
                                    '; if ($s_medic == 1) {
                                        echo '<button class="btn btn-warning" data-toggle="modal" data-target="#stergeTicket" type="button" style="width:100%; margin-top:10px;">Șterge tichet-ul</button>';
                                    } 
                                       if ($status == 1) {
                                         echo '<button class="btn btn-danger" data-toggle="modal" data-target="#inchideTicket" type="button" style="width:100%; margin-top:10px;">Închide tichet-ul</button>';
                                    } else echo '';
                                    echo'
                                </div>
                            </div>
                        </div>
                    </div>'; }
                    echo '
                </div>
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-header-text"><i class="fa fa-th-list"></i>&nbsp;Conținut tichet #'.$id.'<br /></h6>
                        </div>
                        <div class="card-body">
                            <p class="card-text">'.$text.'</p>
                        </div>
                    </div>';
                   if (isset($_GET['eroare']) && $_GET['eroare']=='lungime'){
                    echo '<div role="alert" class="alert alert-danger">
                        <span><strong>Eroare! </strong>Comentariul trebuie să fie cuprins între 5 și 256 caractere!</span>
                    </div>'; }
                    echo '
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-header-text"><i class="fa fa-inbox"></i>&nbsp;Comentarii tichet<br /></h6>
                                </div>
                                <div class="card-body">';
                                if ($resultComment->num_rows > 0) { 
                                     while($rowComment = $resultComment->fetch_assoc()) {
                                         $idComment = $rowComment['id'];
                                         $accountIDComment = $rowComment['accountID'];
                                         $nameComment = $rowComment['nameCreator'];
                                         $dateComment = $rowComment['date'];
                                         $comment = $rowComment['text'];
                                         $medicComment = $rowComment['medicComment'];
                                      if ($medicComment == 1) { echo'
                                      <div class="comentariu-medic">
                                        <div class="comentariu-header"><span><a href="https://hospiweb.novacdan.ro/panel/profil/utilizator?id='.$accountIDComment.'">Dr. '.$nameComment.'&nbsp;<i class="fa fa-user-md"></i></a><span class="float-right"><i class="fa fa-clock-o"></i>&nbsp;'.date("d-m-Y H:i", $dateComment).'</span></span>
                                        </div>
                                        <hr style="margin:5px;" />
                                        <div><span>'.$comment.'</span></div>';}
                                      else { echo '
                                      <div class="comentariu">
                                        <div class="comentariu-header"><span><a href="https://hospiweb.novacdan.ro/panel/profil/utilizator?id='.$accountIDComment.'">'.$nameComment.'&nbsp;<i class="fa fa-ticket"></i></a><span class="float-right"><i class="fa fa-clock-o"></i>&nbsp;'.date("d-m-Y H:i", $dateComment).'</span></span>
                                        </div>
                                        <hr style="margin:5px;" />
                                        <div><span>'.$comment.'</span></div>';}
                                        
                                    echo '</div>';
                                }
                                } else {echo '<div class="comentariu"><div><span>Nu a fost gasit niciun comentariu la acest tichet!</span></div></div>'; } 
                                echo '
                                </div>';
                                if ($status == 1) { echo '
                                <div class="card-footer" style="background-color:white;">
                                    <span style="font-size:13px;">Răspunde la tichet:</span>
                                    <form action="db_manage/createComment.php" method="POST">
                                        <textarea name="comment" placeholder="Maxim 256 caractere" class="form-control" style="height:100px;"></textarea>
                                    <button name="submitComment" class="btn btn-success btn-sm" type="submit" style="margin-top:5px;">Postează</button>
                                    </form>
                                </div>';}
                            echo '</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>'; ?>
    </section>

<?php 
$_SESSION['ticketIDs'] = $id;

if($status == 1) {

echo '
<div id="inchideTicket" role="dialog" tabindex="-1" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Închide tichet-ul curent</h4>
            </div>
            <div class="modal-body">
                <span>Ești sigur că dorești să închizi acest tichet? Această acțiune este ireversibilă</span>
            </div>
            <div class="modal-footer">
            	<form action="db_manage/closeTicket.php" method="POST">
            	<button class="btn btn-success" name="submitTicket" type="submit" data-toggle="modal" data-target="#inchideTicket">Continuă</button>
            	</form>
            	<button class="btn btn-danger" data-toggle="modal" data-target="#inchideTicket">Întoarce-te</button>
            </div>
        </div>
    </div>
</div>';}
if ($s_medic == 1) {
echo' <div id="stergeTicket" role="dialog" tabindex="-1" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Șterge tichet-ul curent</h4>
            </div>
            <div class="modal-body">
                <span>Ești sigur că dorești să ștergi acest tichet? Această acțiune este ireversibilă</span>
            </div>
            <div class="modal-footer">
            	<form action="db_manage/deleteTicket.php" method="POST">
            	<button class="btn btn-success" name="submitStergeTicket" type="submit" data-toggle="modal" data-target="#stergeTicket">Continuă</button>
            	</form>
            	<button class="btn btn-danger" data-toggle="modal" data-target="#stergeTicket">Întoarce-te</button>
            </div>
        </div>
    </div>
</div>'; }
?>
 <?php include"../../includes/footer.php";?>
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../assets/js/functions.js"></script>
    <script src="../../assets/js/bootstrap-better-nav.js"></script>
</body>
</html>