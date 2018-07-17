<!DOCTYPE html>
<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require '../../includes/db.php';
if (!isset($_SESSION['CNP'])){
    header ('Location: https://hospiweb.novacdan.ro/login');
    }
else {

if (empty($_SESSION['key']))
$_SESSION['key'] = bin2hex(random_bytes(32));
require '../../includes/csrf.php';
$s_cnp = $_SESSION['CNP'];
$sql = "SELECT * FROM utilizatori WHERE CNP='$s_cnp'";
$result = $connection->query($sql);
    if($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $s_utilizator = $row['utilizator'];
    $s_CNP = $row['CNP'];
    $s_mail = $row['mail'];
    $s_telefon = $row['telefon'];
    $s_sange = $row['sange'];
    $s_medic = $row['isMedic'];
    $s_stare = $row['stare'];
    $s_sex = $row['sex'];
    $s_isMod = $row['isMod'];
    $s_lastLogin = date("d-m-Y H:i", $row['lastLogin']);
    $s_nascut = $row['nascut'];
    $s_nascutTimestamp = date( "d-m-Y", $s_nascut);
    $s_judet = $row['judet'];   
    $s_cEmail = $row['confirmedEmail'];
    $varsta = floor((time() - $s_nascut) / 31556926);
        
    }
}  

if ($s_medic!=1){
                            
     $select_aditional_pacient = "SELECT * FROM aditional_pacient WHERE accountID='$id'";
    $result_aditional_pacient = $connection->query($select_aditional_pacient);
        if($row = $result_aditional_pacient->fetch_assoc()) {
            $limbasec = $row['limbasec'];
            $greutate = $row['greutate'];
            $inaltime = $row['inaltime'];
            $vaccinuri = $row['vaccinuri'];
            $oredormit = $row['oredormit'];
            $dependenta = $row['dependenta'];
            $exfizice = $row['exfizice'];
            $domiciliu = $row['domiciliu'];
            $alergii = $row['alergii'];
            $intoleranta = $row['intoleranta'];
            $lastModified = (1800 + ($row['lastModified'] - time()));                        
        }}

else if ($s_medic!=0){
    $sqlRequests = "SELECT * FROM medicperm WHERE isAcc=0 AND medicID = '$id' ORDER BY date ASC" ;
    $resultRequests = $connection->query($sqlRequests);  
    $sqlPacients = "SELECT * FROM medicperm WHERE isAcc=1 AND medicID = '$id' ORDER BY date ASC" ;
    $resultPacients = $connection->query($sqlPacients);    
    $select_aditional_medic = "SELECT * FROM aditional_medic WHERE accountID='$id'";
    $result_aditional_medic = $connection->query($select_aditional_medic);
        if($row = $result_aditional_medic->fetch_assoc()) {
            $limbasec = $row['limbasec'];
            $spital = $row['spital'];
            $specializare = $row['specializare'];
            $program = $row['program'];
            $cabinet = $row['cabinet'];
            $pret = $row['pret'];
            $lastModified = (300 + ($row['lastModified'] - time()));
        }
        else {
            $limbasec = "Nu a fost setat";
            $specializare = "Nu a fost setat";
        }
}
        
?>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HospiWeb | Panou - Profilul meu</title>
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="../../../regulament/assets/css/bootstrap-better-nav.css">
    <link rel="stylesheet" href="../../regulament/assets/css/styles.css">
    <link rel="stylesheet" href="../../assets/fonts/font-awesome.min.css">
    <style>
        #Tutorial{
            display: none;
        }
        .form-group-single {
            margin-bottom: 1rem;
            margin-top: 1rem;
        }
    </style>
    <script src="../../assets/js/jquery.min.js"></script>
    <meta charset="utf-8">
</head>

<body>
 <?php include"../../includes/header.php";?>
    <section class="bunvenit">
        <div class="container">
            <div class="card">
                <div class="card-block" style="padding:0">
                    <div class="alert alert-light" role="alert">
                       <?php 
                       if ($s_medic == 0){
                       echo '<br><h5>Bun venit, '.$s_utilizator;echo'!</h5>
                       <div id="Tutorial">
                       <p style="font-size: 13px">Mai jos îți poți vedea și actualiza statisticile în timp real ca mai apoi un medic să te poată consulta!
                       <br>Pentru a facilita calitatea serviciilor noastre te rugam să completezi regulat, cu informații corecte toate câmpurile aflate mai jos!</p>
                       <p style="font-size: 13px;color:#138496">Tutorial! Pentru ca un medic să poată să vă consulte trebuie să îi acordați accesul. Puteți face asta <br> intrând pe profilul lui. Puteți găsi toți medicii <a href="https://hospiweb.novacdan.ro/panel/doctori"><i>aici</i></a>.</p></div>
                       <button class="btn btn-light text-center" id="toggletutorial" style="font-size:13px" type="button">Arată tutorial</button>'; 
    
                           
                       }
                       else { echo'<br><h5>Bun venit, Dr. '.$s_utilizator;echo'!</h5>
                       <div id="Tutorial">
                       <p style="font-size: 13px">Platforma Hospiweb va ureaza o zi usoara de munca si speram sa va bucurati de facilitatile oferite de noi!
                       <br>In cazul in care intampinati probleme in utilizarea platformei luati legatura cu un operator al platformei!</p>
                       <p style="font-size:12px; color:#138496">Sfat: Pentru ca pacientilor sa le fie mai usor sa ia legatura cu dumneavoastra va rugam completati si actualizati regulat cu informatii<br> corecte toate campurile de mai jos!</p></div>
                       <button class="btn btn-light text-center" id="toggletutorial" style="font-size:13px" type="button">Arată tutorial</button>';   
                       }
                       ?>
                    
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if (isset($_GET['eroare']) && $_GET['eroare']==1) { echo '
    <div class="container">
         <div role="alert" class="alert alert-danger"><span><strong>Eroare! </strong>Mailul introdus este invalid sau câmpul nu a fost completat!</span></div>
    </div>
    ';} else if (isset($_GET['eroare']) && $_GET['eroare']==2) { echo '
    <div class="container">
         <div role="alert" class="alert alert-danger"><span><strong>Eroare! </strong>Cererea solicitată este invalidă!</span></div>
    </div>
    ';} else if (isset($_GET['eroare']) && $_GET['eroare']==5) { echo '
    <div class="container">
         <div role="alert" class="alert alert-danger"><span><strong>Eroare! </strong>Mailul introdus este deja validat!</span></div>
    </div>
    ';} else if (isset($_GET['eroare']) && $_GET['eroare']==3) { echo '
    <div class="container">
         <div role="alert" class="alert alert-danger"><span><strong>Eroare! </strong>Cererea a expirat!</span></div>
    </div>
    ';} 
    
       if (isset($_GET['succes']) && $_GET['succes']==1) { echo '
    <div class="container">
         <div role="alert" class="alert alert-success"><span><strong>Succes! </strong>'; if ($s_cEmail == 1) { echo 'Un mail de confirmare a fost trimis către actuala ta adresă de mail. '; } else if ($s_cEmail == 0) { echo 'Un mail de confirmare a fost trimis către adresa de mail introdusă anterior. '; } echo 'În cazul în care nu-l primești nu uita să verifici folderul SPAM!</span></div>
    </div>
    ';} else if ((isset($_GET['succes']) && $_GET['succes']==2) || (isset($_GET['succes']) && $_GET['succes']==4)) { echo '
    <div class="container">
         <div role="alert" class="alert alert-success"><span><strong>Succes! </strong>Mailul a fost schimbat și validat!</span></div>
    </div>
    ';} else if (isset($_GET['succes']) && $_GET['succes']==3) { echo '
    <div class="container">
         <div role="alert" class="alert alert-success"><span><strong>Succes! </strong>Un mail de confirmare a fost trimis către noua ta adresă. În cazul în care nu-l primești nu uita să verifici folderul SPAM!</span></div>
    </div>
    ';} 
    
        if (isset($_GET['succes']) && $_GET['succes']=='changePass') { echo '
    <div class="container">
         <div role="alert" class="alert alert-success"><span><strong>Succes! </strong>Parola contului a fost schimbată!</span></div>
    </div>';}
        if (isset($_GET['eroare']) && $_GET['eroare']=='parolaGresita') { echo '
    <div class="container">
         <div role="alert" class="alert alert-danger"><span><strong>Eroare! </strong>Parola actuală a contului este greșită!</span></div>
    </div>';}
        if (isset($_GET['eroare']) && $_GET['eroare']=='nuCoincid') { echo '
    <div class="container">
         <div role="alert" class="alert alert-danger"><span><strong>Eroare! </strong>Parolele noi introduse nu coincid!</span></div>
    </div>';}
       if (isset($_GET['eroare']) && $_GET['eroare']=='aceeasiParola') { echo '
    <div class="container">
         <div role="alert" class="alert alert-danger"><span><strong>Eroare! </strong>Parola introdusă este deja parola actuală a contului!</span></div>
    </div>';}
        if (isset($_GET['eroare']) && $_GET['eroare']=='criterii') { echo '
    <div class="container">
         <div role="alert" class="alert alert-danger"><span><strong>Eroare! </strong>Parola trebuie sa fie cuprinsă între 8 și 20 caractere și să conțină minim o litera și o cifră!</span></div>
    </div>';}
    ?>
    <section class="w-content panou-optiuni section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <div class="card faq-left">
                        <?php if ($s_sex == '1' && $s_medic != '0')
                        echo'
                        <div class="poza-profil"><img src="../../regulament/assets/img/profil-doctor.png" class="img-fluid"></div>';
                              else if($s_sex == '2' && $s_medic != '0')
                        echo'<div class="poza-profil"><img src="../../regulament/assets/img/profil-doctor-girl.png" class="img-fluid"></div>';
                              else if ($s_sex == '1' && $s_medic == '0')
                        echo'<div class="poza-profil"><img src="../../regulament/assets/img/profil-boy.png" class="img-fluid"></div>';
                              else if ($s_sex == '2' && $s_medic == '0')
                        echo'<div class="poza-profil"><img src="../../regulament/assets/img/profil-girl.png" class="img-fluid"></div>';
                              else 
                        echo'<div class="poza-profil"><img src="../../regulament/assets/img/no.png" class="img-fluid"></div>';
                              
                              ?>
                        <div class="card-block">
                            <?php echo'<h5 class="text-center">' .$s_utilizator;echo'</h5>' ?>
                        <?php
                        if ($s_isMod == 1) echo '<h6 class="text-center"><span class="label" style="background-color:green"><i class="fa fa-gear"></i>&nbsp;Moderator</span></h6>'; 
                        if($s_medic=='1') echo'
                            <h6 class="text-center"><span class="label bg-purple"><i class="fa fa-graduation-cap"></i>&nbsp;'.$specializare.'</span></h6>'; 
                        else{
                        switch($s_stare){
                            case 0: echo'<h6 class="text-center"><span class="label" style="background-color:#000; color: #fff"><i class="fa fa-close"></i>&nbsp;Pacient - Decedat</span></h6>';
                            break;
                            case 1: echo'<h6 class="text-center"><span class="label bg-turcoaz"><i class="fa fa-user"></i>&nbsp;Pacient - Sanatos</span></h6>';
                            break;
                            case 2: echo'<h6 class="text-center"><span class="label bg-yellow"><i class="fa fa-heart"></i>&nbsp;Pacient - Bolnav</span></h6>';
                            break;
                            case 3: echo'<h6 class="text-center"><span class="label bg-red"><i class="fa fa-warning"></i>&nbsp;Pacient - Grav bolnav</span></h6>';
                            break;
                            default: echo'';
                        }} ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-9">
                    <?php if($s_medic==1){
                        echo'
                    <div id="modalRequests" role="dialog" tabindex="-1" class="modal fade">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Listă așteptare pacienți</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive" style="font-size:13px;">
                                        <table class="table pacienti table-striped-profile">
                                            <thead>
                                                <tr>
                                                    <th style="border-bottom: 0">Nume</th>
                                                    <th style="border-bottom: 0">Data</th>
                                                    <th style="border-bottom: 0"></th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                              if ($resultRequests->num_rows > 0) {
                                                  while($rowReq = $resultRequests->fetch_assoc()) {
                                                   $reqID = $rowReq['id'];
                                                   $pacientID = $rowReq['pacientID'];
                                                   $namePacient = $rowReq['namePacient'];
                                                   $date = date("d-m-Y H:i", $rowReq['date']);
                                                   $i++;
                                                   echo '<tr>
                                                            <td><a href="htttps://hospiweb.novacdan.ro/panel/profil/utilizator?id='.$pacientID.'">'.$namePacient.'</a></td>
                                                            <td>'.$date.'</td>
                                                            <td><form action="db_manage/requests.php" method="POST" ><button class="btn float-right" value="'.$reqID.'" type="submit" type="submit" name="removePacient" style="color:#fff; box-shadow:none; background-color:transparent; margin:0"><i class="fa fa-window-close" style="font-size:13px; color:red"></i></button>
                                                            <button class="btn float-right" type="submit" value="'.$reqID.'" name="acceptPacient" style="color:#fff; box-shadow:none; background-color:transparent; margin:0"><i class="fa fa-check-square" style="font-size:13px; color:green"></i></button></form></td>
                                                        </tr>';
                                                  }
                                            } else { $i = 0; echo '
                                                <tr><td>Nu au fost gasita nicio cerere!</td><td></td><td></td></tr>';
                                            }
                                            echo '</tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                <button class="btn btn-danger" data-toggle="modal" data-target="#modalRequests">Închide</button></div>
                            </div>
                        </div>
                    </div>    
                    <div class="header-profil">
                        <ul class="nav nav-tabs md-tabs tab-timeline">
                            <li class="profile-nav-item-doctor"><a href="" class="nav-link" data-toggle="modal" data-target="#modalRequests">Cereri de la pacienți în așteptare
                            &nbsp;<span class="label ball">'.$i.'</span></h6></a></li>
                        </ul>
                    </div>';}
                    else { 
                        $num_rows_cons = $connection->query("SELECT COUNT(id) FROM consultatii_pacient WHERE accountID = '$id'");
                    	$rows_count_cons = $num_rows_cons->fetch_assoc();
                    	$num_cons = $rows_count_cons['COUNT(id)'];
                    	
                    	$num_rows_trans = $connection->query("SELECT COUNT(id) FROM transplanturi_pacient WHERE accountID= '$id'");
                    	$rows_count_trans = $num_rows_trans->fetch_assoc();
                    	$num_trans = $rows_count_trans['COUNT(id)'];
                    	
                    	$num_rows_treat = $connection->query("SELECT COUNT(id) FROM tratament_pacient WHERE accountID = '$id'");
                    	$rows_count_treat = $num_rows_treat->fetch_assoc();
                    	$num_treat = $rows_count_treat['COUNT(id)'];
                    echo'
                    <div class="header-profil">
                        <ul class="nav nav-tabs md-tabs tab-timeline">
                            <li class="profile-nav-item"><a href="" class="nav-link" data-toggle="modal" data-target="#modalConsultationView">Consultatii
                            &nbsp;<span class="label ball">'.$num_cons.'</span></h6></a></li>
                            <li class="profile-nav-item"><a href="" class="nav-link" data-toggle="modal" data-target="#modalTratamentView">Tratament
                            &nbsp;<span class="label ball">'.$num_treat.'</span></h6></a></li>
                            <li class="profile-nav-item"><a href="" data-toggle="modal" data-target="#modalTransplant" class="nav-link">Transplanturi
                            &nbsp;<span class="label ball">'.$num_trans.'</span></h6></a></li>
                        </ul>
                    </div>';}?>
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-header-text">INFORMAȚII GENERALE&nbsp;</h6>
                                    <a href="#" data-toggle="tooltip" title="Acestea sunt informatiile preluate la inregistrarea contului! Unele introduse de tine, altele preluate automat din CNP-ul tau!"><i class="fa fa-info-circle"></i></a>
                                </div>
                                <div class="card-body">
                                    <div class="view-info">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="informatii-generale">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-xl-6">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped-profile">
                                                                    <thead>
                                                                        <tr></tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php echo'
                                                                        <tr>
                                                                            <td style="color:#17a2b8;">CNP:</td>
                                                                            <td style="text-center">'.$s_CNP; '</td>'; ?>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="color:#17a2b8;">Parolă:</td>
                                                                            <td><button name="changePass" class="btn btn-light" id="changePass" type="button" data-target="#modalChangePass" data-toggle="modal" style="padding:2px;font-size:13px;color:#575962;">Schimbă</button></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="color:#17a2b8;">Sex:</td>
                                                                            <?php  
                                                                            switch($s_sex){
                                                                                case 1: echo'<td style="text-center">Masculin</td>';
                                                                                break;
                                                                                case 2: echo'<td style="text-center">Feminin</td>';
                                                                                break;
                                                                                case 3: echo'<td style="text-center">Nu conteaza</td>'; 
                                                                                break;
                                                                                default: echo'<td style="text-center">Nu a fost specificat</td>'; 
                                                                            }
                                                                            ?>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="color:#17a2b8;">Dată naștere:</td>
                                                                            <?php echo'<td style="text-center">'.$s_nascutTimestamp; echo' ('.$varsta; echo' ani) </td>'; ?>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="color:#17a2b8;">Ultima autentificare:</td>
                                                                            <?php echo'<td style="text-center">'.$s_lastLogin.'</td>'; ?>
                                                                        </tr>                                                                        
                                                                        <tr>
                                                                            <td style="color:#17a2b8;">Telefon:</td>
                                                                            <?php echo'<td style="text-center">'.$s_telefon; echo'</td>'; ?>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="color:#17a2b8;">Judet: </td>
                                                                            <?php echo'<td style="text-center">'.$s_judet; echo'</td>'; ?>
                                                                        </tr>                                                                        
                                                                        <?php if ($s_medic == '1') { echo ''; }
                                                                        else { echo'
                                                                        <tr>
                                                                            <td style="color:#17a2b8;">Grupă sanguină:</td>';
                                                                            
                                                                            switch($s_sange){
                                                                                case 1: echo'<td style="text-center">0 (I)</td>';
                                                                                break;
                                                                                case 2: echo'<td style="text-center">A (II)</td>';
                                                                                break;
                                                                                case 3: echo'<td style="text-center">B (III)</td>'; 
                                                                                break;
                                                                                case 4: echo'<td style="text-center">AB (IV)</td>'; 
                                                                                break;
                                                                                default: echo'<td style="text-center">Nu a fost specificat</td>';
                                                                            }}
                                                                            ?>                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="color:#17a2b8;">Mail: <?php if ($s_cEmail == 0) echo'(Nevalidat)'; ?></td>
                                                                            <?php echo'<td style="text-center">'.$s_mail; echo' <button name="changeMail" class="btn" id="changeMail" style="color:#17a2b8; padding: 0; box-shadow:none; background-color:transparent;" type="button" data-target="#modalChangeMail" data-toggle="modal"><i style="font-size:13px" class="fa fa-pencil"></i></button></td>'; ?>
                                                                        </tr>                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-xl-6 margine-sus">
                                                           <?php
                                                           if($s_medic != 1){
                                                            $querySelect = "SELECT * FROM simptome_pacient WHERE accountID = '$id'";
                                                            $res = $connection->query($querySelect);
                                                            $row_simp = $res->fetch_assoc();
                                                            
                                                            if($row_simp['text'] == '')
                                                                $row_simp['text'] = "Nu a fost stabilit niciun simptom.";
                                                            $querySELECT_diag = "SELECT * FROM diagnostic_pacient WHERE accountID = '$id'";
                                                            $res_diag = $connection->query($querySELECT_diag);
                                                            $row_diag = $res_diag->fetch_assoc();
                                                            $rows_diag = $res_diag->num_rows;
                                                            
                                                            if($row_diag['text'] == '')
                                                                $row_diag['text'] = "Nu a fost stabilit niciun diagnostic.";
                                                            echo'
                                                            <div class="table-responsive" id="diagnostice">
                                                                <table class="table simptome">
                                                                 <thead>
                                                                    <tr>
                                                                        <th>
                                                                            Simptomele mele:&nbsp<button type="button" name="add" id="add" data-toggle="modal" data-target="#modalSimp" class="btn" style="color:#fff; box-shadow:none; background-color:transparent;"><i class="fa fa-edit"></i></button><button class="btn float-right" style="color:#fff; box-shadow:none; background-color:transparent;" id="toggleSimptom"><i id="toggleSimptomIcon" class="fa fa-minus-circle" style="font-size:20px"></i></button>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="Simptom">
                                                                    <tr>
                                                                        <td>
                                                                <p>' . $row_simp['text'] . '</p>';
                                                                if($res->num_rows > 0)
                                                                {
                                                                    echo '<hr><p style="font-size: 10px; color:#fff">Editat la: ' . $row_simp['time'] . ' de catre: '. $row_simp['medic'] .'<br /></p></td></tr></tbody></table></div>';
                                                                }
                                                                else
                                                                {
                                                                    echo '</td></tr></tbody></table></div>';
                                                                }
                                                            echo'<br>'; 
                                                            echo '
                                                            <div class="table-responsive" id="diagnostice">
                                                                <table class="table diagnostic">
                                                                <thead>
                                                                    <tr>
                                                                        <th>
                                                                            Diagnostic actual:<button class="btn float-right" style="color:#fff; box-shadow:none; background-color:transparent;" id="toggleDiagnostic"><i id="toggleDiagnosticIcon" class="fa fa-minus-circle" style="font-size:20px"></i></button>
                                                                        </th>
                                                                    </tr>
                                                                <thead>
                                                                <tbody id="Diagnostics">
                                                                    <tr>
                                                                        <td>
                                                                <p>'. $row_diag['text'] .'</p>';
                                                                if($rows_diag){
                                                                    echo '<hr><p style="font-size: 10px;color:#fff;">Editat la: ' . $row_diag['time'] . ' de catre: Dr. '. $row_diag['medic'] .'<br /></p></td></tr></tbody></table></div>';
                                                                }
                                                                else
                                                                    echo '</td></tr></tbody></table></div>';
                                                                } else if ($s_medic == 1) {
                                                                echo '
                                                                <div class="table-responsive">
                                                                    <table class="table listapacienti table-striped-doctor">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>
                                                                                Lista pacienților:
                                                                                </th>
                                                                                <th></th>
                                                                                <th><button class="btn float-right" style="color:#fff; box-shadow:none; background-color:transparent;" id="togglePacienti"><i id="togglePacientiIcon" class="fa fa-minus-circle" style="font-size:20px"></i></button></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="listaPacienti">';
                                                                        if ($resultPacients->num_rows > 0) {
                                                                             while($rowPcs = $resultPacients->fetch_assoc()) {
                                                                             $idReq = $rowPcs['id'];     
                                                                             $idPacient = $rowPcs['pacientID'];
                                                                             $namePacient = $rowPcs['namePacient'];
                                                                             $datePacient = $rowPcs['date'];
                                                                            echo '<tr>
                                                                                    <td><a href="https://hospiweb.novacdan.ro/panel/profil/utilizator?id='.$idPacient.'">'.$namePacient.'</a></td>
                                                                                    <td><span>'.date("d-m-Y H:i", $datePacient).'</span></td>
                                                                                    <td><form action="db_manage/requests.php" method="POST"><button class="btn float-right" value="'.$idReq.'" name="removePacient" type="submit" style="color:#fff; box-shadow:none; background-color:transparent;"><i class="fa fa-trash" style="font-size:13px;"></i></button></form></td>
                                                                                  </tr>'; }
                                                                        } else echo'<tr><td><span>Nu au fost gasiti pacienti</span></td><td></td><td></td></tr>';
                                                                       echo ' </tbody>
                                                                    </table>
                                                                </div>
                                                                ';}
                                                                
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                            <?php if($s_medic==1){
            
                                echo '<div class="card">
                                <div class="card-header">
                                    <h6 class="card-header-text">INFORMAȚII ADIȚIONALE</h6><button class="btn float-right" style="color: rgba(51, 51, 51, 0.85); box-shadow:none; background-color:transparent;" id="toggleAdditional"><i id="toggleAdditionalIcon" class="fa fa-minus-circle" style="font-size:24px"></i></button>
                                    <a href="#" data-toggle="tooltip" title="Acestea sunt informatiile pe care va trebui sa le actualizezi in mod regulat pentru ca pacientii tai sa afle mai multe despre tine!"><i class="fa fa-info-circle"></i></a>
                                </div>
                                                            '; 
                            if (isset($_GET['action']) && $_GET['action']=='succes'){
                                echo '<div class="card-header">
                                        <div role="alert" class="alert alert-success" style="margin-bottom: 0px"><span>Informatiile au fost actualizate cu succes!</span></div>
                                    </div>';
                            } else if (isset($_GET['action']) && $_GET['action']=='eroare' && $lastModified >= 0){
                                echo '<div class="card-header">
                                        <div role="alert" class="alert alert-danger" style="margin-bottom: 0px"><span>Va trebui să așteptați '.$lastModified.' secunde înainte de a putea trimite o nouă cerere!</span></div>
                                    </div>';
                            } else if (isset($_GET['action']) && $_GET['action']=='eroare' && $lastModified <= 0){
                                echo '<div class="card-header">
                                        <div role="alert" class="alert alert-danger" style="margin-bottom: 0px"><span>Timpul de așteptare s-a terminat, acum poți trimite o nouă cerere!</span></div>
                                    </div>';
                            }
                            
                            echo'
                                <div class="card-body" id="Additional">
                                    <div class="view-info">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="informatii-generale">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-xl-6">
                                                        <form action="db_manage/aditional_medic.php" method="POST">
                                                            <div class="sectiune"><label class="labela">Limbă secundară cunoscută:</label>
                                                                    <select class="profile-input" name="limbasec">
                                                                    <option value="1"'; if ($limbasec == 1) echo 'selected';echo'>Nu cunosc</option>
                                                                    <option value="2"'; if ($limbasec == 2) echo 'selected';echo'>Engleza</option>
                                                                    <option value="3"'; if ($limbasec == 3) echo 'selected';echo'>Franceza</option>
                                                                    <option value="4"'; if ($limbasec == 4) echo 'selected';echo'>Germana</option>
                                                                    <option value="5"'; if ($limbasec == 5) echo 'selected';echo'>Italiana</option>
                                                                    <option value="6"'; if ($limbasec == 6) echo 'selected';echo'>Spaniola</option>
                                                                    <option value="7"'; if ($limbasec == 7) echo 'selected';echo'>Rusa</option>
                                                                    <option value="8"'; if ($limbasec == 8) echo 'selected';echo'>Alta</option>
                                                                    </select></div>
                                                            <div class="sectiune"><label style="color:rgb(255,100,221);">Specializarea:</label>
                                                                    <select class="profile-input" name="specializare">	
                                                                    <option value="Alergologie si imunologie"'; if ($specializare == "Alergologie si imunologie") echo 'selected';echo'>Alergologie si imunologie</option>
                                                                    <option value="Anatomie patologica"'; if ($specializare == "Anatomie patologica") echo 'selected';echo'>Anatomie patologica</option>
                                                                    <option value="Anestezie si terapie intensiva"'; if ($specializare == "Anestezie si terapie intensiva") echo 'selected';echo'>Anestezie si terapie intensiva</option>
                                                                    <option value="Boli infectioase"'; if ($specializare == "Boli infectioase") echo 'selected';echo'>Boli infectioase</option>
                                                                    <option value="Cardiologie"'; if ($specializare == "Cardiologie") echo 'selected';echo'>Cardiologie</option>
                                                                    <option value="Chirurgie cardiovasculara"'; if ($specializare == "Chirurgie cardiovasculara") echo 'selected';echo'>Chirurgie cardiovasculara</option>
                                                                    <option value="Chirurgie generala"'; if ($specializare == "Chirurgie generala") echo 'selected';echo'>Chirurgie generala</option>
                                                                    <option value="Chirurgie ortopedica pediatrica"'; if ($specializare == "Chirurgie ortopedica pediatrica") echo 'selected';echo'>Chirurgie ortopedica pediatrica</option>
                                                                    <option value="Chirurgie pediatrica"'; if ($specializare == "Chirurgie pediatrica") echo 'selected';echo'>Chirurgie pediatrica</option>
                                                                    <option value="Chirurgie plastica"'; if ($specialziare == "Chirurgie plastica") echo 'selected';echo'>Chirurgie plastica</option>
                                                                    <option value="Chirurgie toracica"'; if ($specializare == "Chirurgie toracica") echo 'selected';echo'>Chirurgie toracica</option>
                                                                    <option value="Chirurgie vasculara"'; if ($specializare == "Chirurgie vasculara") echo 'selected';echo'>Chirurgie vasculara</option>
                                                                    <option value="Dermatologie"'; if ($specializare == "Dermatologie") echo 'selected';echo'>Dermatologie</option>
                                                                    <option value="Endocrinologie"'; if ($specializare == "Endocrinologie") echo 'selected';echo'>Endocrinologie</option>
                                                                    <option value="Gastroenterologie"'; if ($specializare == "Gastroenterologie") echo 'selected';echo'>Gastroenterologie</option>
                                                                    <option value="Gastroenterologie pediatrica"'; if ($specializare == "Gastroenterologie pediatrica") echo 'selected';echo'>Gastroenterologie pediatrica</option>
                                                                    <option value="Geriatrie si gerontologie"'; if ($specializare == "Geriatrie si gerontologie") echo 'selected';echo'>Geriatrie si gerontologie</option>
                                                                    <option value="Ginecologie obstetrica"'; if ($specializare == "Ginecologie obstetrica") echo 'selected';echo'>Ginecologie obstetrica</option>
                                                                    <option value="Hematologie"'; if ($specializare == "Hematologie") echo 'selected';echo'>Hematologie</option>
                                                                    <option value="Medic de familie"'; if ($specializare == "Medic de familie") echo 'selected';echo'>Medic de familie</option>
                                                                    <option value="Medicina de urgenta"'; if ($specializare == "Medicina de urgenta") echo 'selected';echo'>Medicina de urgenta</option>
                                                                    <option value="Medicina fizica si de reabilitare"'; if ($specializare == "Medicina fizica si de reabilitare") echo 'selected';echo'>Medicina fizica si de reabilitare</option>
                                                                    <option value="Medicina interna"'; if ($specializare == "Medicina interna") echo 'selected';echo'>Medicina interna</option>
                                                                    <option value="Medicina legala"'; if ($specializare == "Medicina legala") echo 'selected';echo'>Medicina legala</option>
                                                                    <option value="Medicina sportiva"'; if ($specializare == "Medicina sportiva") echo 'selected';echo'>Medicina sportiva</option>
                                                                    <option value="Nefrologie"'; if ($specializare == "Nefrologie") echo 'selected';echo'>Nefrologie</option>
                                                                    <option value="Nefrologie pediatrica"'; if ($specializare == "Nefrologie pediatrica") echo 'selected';echo'>Nefrologie pediatrica</option>
                                                                    <option value="Neonatologie nou nascuti"'; if ($specializare == "Neonatologie nou nascuti") echo 'selected';echo'>Neonatologie nou nascuti</option>
                                                                    <option value="Neurochirurgie"'; if ($specializare == "Neurochirurgie") echo 'selected';echo'>Neurochirurgie</option>
                                                                    <option value="Neurologie"'; if ($specializare == "Neurologie") echo 'selected';echo'>Neurologie</option>
                                                                    <option value="Neurologie pediatrica"'; if ($specializare == "Neurologie pediatrica") echo 'selected';echo'>Neurologie pediatrica</option>
                                                                    <option value="Neuropsihiatrie"'; if ($specializare == "Neuropsihiatrie") echo 'selected';echo'>Neuropsihiatrie</option>
                                                                    <option value="Nutritie si diabet"'; if ($specializare == "Nutritie si diabet") echo 'selected';echo'>Nutritie si diabet</option>
                                                                    <option value="O.R.L."'; if ($specializare == "O.R.L.") echo 'selected';echo'>O.R.L.</option>
                                                                    <option value="Oftalmologie"'; if ($specializare == "Oftalmologie") echo 'selected';echo'>Oftalmologie</option>
                                                                    <option value="Oncologie"'; if ($specializare == "Oncologie") echo 'selected';echo'>Oncologie</option>
                                                                    <option value="Oncologie pediatrica"'; if ($specializare == "Oncologie pediatrica") echo 'selected';echo'>Oncologie pediatrica</option>
                                                                    <option value="Ortopedie pediatrica"'; if ($specializare == "Ortopedie pediatrica") echo 'selected';echo'>Ortopedie pediatrica</option>
                                                                    <option value="Ortopedie si traumatologie"'; if ($specializare == "Ortopedie si traumatologie") echo 'selected';echo'>Ortopedie si traumatologie</option>
                                                                    <option value="Pediatrie"'; if ($specializare == "Pediatrie") echo 'selected';echo'>Pediatrie</option>
                                                                    <option value="Pneumologie"'; if ($specializare == "Pneumologie") echo 'selected';echo'>Pneumologie</option>
                                                                    <option value="Pneumologie pediatrica"'; if ($specializare == "Pneumologie pediatrica") echo 'selected';echo'>Pneumologie pediatrica</option>
                                                                    <option value="Podiatrie"'; if ($specializare == "Podiatrie") echo 'selected';echo'>Podiatrie</option>
                                                                    <option value="Psihiatrie"'; if ($specializare == "Psihiatrie") echo 'selected';echo'>Psihiatrie</option>
                                                                    <option value="Psihiatrie pediatrica"'; if ($specializare == "Psihiatrie pediatrica") echo 'selected';echo'>Psihiatrie pediatrica</option>
                                                                    <option value="Psihologie"'; if ($specializare == "Psihologie") echo 'selected';echo'>Psihologie</option>
                                                                    <option value="Psihoterapie"'; if ($specializare == "Psihoterapie") echo 'selected';echo'>Psihoterapie</option>
                                                                    <option value="Radiologie Imagistica"'; if ($specializare == "Radiologie Imagistica") echo 'selected';echo'>Radiologie Imagistica</option>
                                                                    <option value="Reumatologie"'; if ($specializare == "Reumatologie") echo 'selected';echo'>Reumatologie</option>
                                                                    <option value="Stomatologie"'; if ($specializare == "Stomatologie") echo 'selected';echo'>Stomatologie</option>
                                                                    <option value="Urologie"'; if ($specializare == "Urologie") echo 'selected';echo'>Urologie</option>
                                                                    </select></div>
                                                        <div class="sectiune"><label class="labela">Adresă cabinet propriu (Dacă există):</label><input type="text" value="'.$cabinet.'" class="profile-input" name="cabinet" /></div>
                                                </div>
                                                <div class="col-lg-12 col-xl-6">
                                                    <div class="sectiune"><label class="labela">Spitalul de proveniență:</label></div>
                                                                    <input type="text" class="profile-input" name="spital" value="'.$spital.'" placeholder="ex. Spitalul de Urgență X Localitatea Y" />
                                                    <div class="sectiune"><label class="labela">Program consultații:</label>
                                                                    <input type="text" class="profile-input" name="program" value="'.$program.'" placeholder="ex. Luni-Vineri / 12:00 - 15:00" /></div>
                                                    <div class="sectiune"><label class="labela">Preț pe consultație:</label>
                                                                    <input type="text" class="profile-input" name="pret" value="'.$pret.'" placeholder="ex. 250 lei / ora" /></div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-info" name="submit" type="submit" style="width:100%;font-size:13px;">Actualizează informațiile</button></form>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>';
                            }
                            else{
                            echo'
                            <div class="card">
                            <div class="card-header">
                                <h6 class="card-header-text">INFORMAȚII ADIȚIONALE</h6><button class="btn float-right" style="color: rgba(51, 51, 51, 0.85); box-shadow:none; background-color:transparent;" id="toggleAdditional"><i id="toggleAdditionalIcon" class="fa fa-minus-circle" style="font-size:24px"></i></button>
                                    <a href="#" data-toggle="tooltip" title="Acestea sunt informatiile pe care va trebui sa le actualizezi in mod regulat pentru ca doctorul tau sa te poata supraveghea mai bine"><i class="fa fa-info-circle"></i></a>
                            </div>
                            '; 
                            if (isset($_GET['action']) && $_GET['action']=='succes'){
                                echo '<div class="card-header">
                                        <div role="alert" class="alert alert-success" style="margin-bottom: 0px"><span>Informațiile au fost actualizate cu succes!</span></div>
                                    </div>';
                            }
                            else if (isset($_GET['action']) && $_GET['action']=='eroare' && $lastModified >= 0){
                                echo '<div class="card-header">
                                        <div role="alert" class="alert alert-danger" style="margin-bottom: 0px"><span>Va trebui să așteptați '.$lastModified.' secunde înainte de a putea trimite o nouă cerere!</span></div>
                                    </div>';
                            } else if (isset($_GET['action']) && $_GET['action']=='eroare' && $lastModified <= 0){
                                echo '<div class="card-header">
                                        <div role="alert" class="alert alert-danger" style="margin-bottom: 0px"><span>Timpul de așteptare s-a terminat, acum poți trimite o nouă cerere!</span></div>
                                    </div>';
                            }
                            echo'
                            <div class="card-body" id="Additional">
                                <div class="view-info">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="informatii-generale">
                                                <div class="row">
                                                    <div class="col-lg-12 col-xl-6">
                                                    <form action="db_manage/aditional_pacient.php" method="POST">
                                                    <div class="sectiune"><label class="labela">Limbă secundară cunoscută:</label>
                                                        <select class="profile-input" name="limbasec">
                                                        <option value="1"'; if ($limbasec == 1) echo 'selected';echo'>Nu cunosc</option>
                                                        <option value="2"'; if ($limbasec == 2) echo 'selected';echo'>Engleza</option>
                                                        <option value="3"'; if ($limbasec == 3) echo 'selected';echo'>Franceza</option>
                                                        <option value="4"'; if ($limbasec == 4) echo 'selected';echo'>Germana</option>
                                                        <option value="5"'; if ($limbasec == 5) echo 'selected';echo'>Italiana</option>
                                                        <option value="6"'; if ($limbasec == 6) echo 'selected';echo'>Spaniola</option>
                                                        <option value="7"'; if ($limbasec == 7) echo 'selected';echo'>Rusa</option>
                                                        <option value="8"'; if ($limbasec == 8) echo 'selected';echo'>Alta</option>
                                                        </select></div>
                                                    <div class="sectiune"><label class="labela">Greutate (kg):</label>
                                                        <input type="text" class="profile-input" value="'.$greutate.'" name="greutate" maxlength="3" /></div>
                                                    <div class="sectiune"><label class="labela">Înălțime (cm):</label>
                                                        <input type="text" class="profile-input" value="'.$inaltime.'" name="inaltime" maxlength="3" /></div>
                                                    <div class="sectiune"><label class="labela">Ai toate vaccinurile obligatorii făcute?:</label>
                                                        <select class="profile-input" name="vaccinuri">
                                                        <option value="1"'; if ($vaccinuri == 1) echo 'selected';echo'>Da</option>
                                                        <option value="2"'; if ($vaccinuri == 2) echo 'selected';echo'>Nu</option>
                                                        <option value="3"'; if ($vaccinuri == 3) echo 'selected';echo'>Nu stiu</option>
                                                        </select></div>
                                                    <div class="sectiune"><label class="labela">Câte ore dormi în medie pe zi?:</label>
                                                        <select class="profile-input" name="oredormit">
                                                        <option value="1"'; if ($oredormit == 1) echo 'selected';echo'>1-3</option>
                                                        <option value="2"'; if ($oredormit == 2) echo 'selected';echo'>4-6</option>
                                                        <option value="3"'; if ($oredormit == 3) echo 'selected';echo'>7-9</option>
                                                        <option value="4"'; if ($oredormit == 4) echo 'selected';echo'>10-12</option>
                                                        </select></div>
                                            </div>
                                            <div class="col-lg-12 col-xl-6">
                                                <div class="sectiune"><label class="labela">De ce esti dependent?:</label>
                                                        <select class="profile-input" name="dependenta">
                                                        <option value="1"'; if ($dependenta == 1) echo 'selected';echo'>Alcool</option>
                                                        <option value="2"'; if ($dependenta == 2) echo 'selected';echo'>Nicotina</option>
                                                        <option value="3"'; if ($dependenta == 3) echo 'selected';echo'>Etnobotanice</option>
                                                        <option value="4"'; if ($dependenta == 4) echo 'selected';echo'>De nimic</option>
                                                        </select></div>
                                                <div class="sectiune"><label class="labela">Adresa de domiciliu:</label>
                                                        <input type="text" class="profile-input" value="'.$domiciliu.'" placeholder="ex. str. X, bl. Y, ap. Z, Oras" name="domiciliu" /></div>
                                                <div class="sectiune"><label class="labela">Faci exerciții fizice?:</label></div>
                                                        <select class="profile-input" name="exfizice">
                                                        <option value="1"'; if ($exfizice == 1) echo 'selected';echo'>Da</option>
                                                        <option value="2"'; if ($exfizice == 2) echo 'selected';echo'>Nu</option>
                                                        </select>
                                                <div class="sectiune"><label class="labela">Ai alergii? (Dacă da scriele mai jos):</label>
                                                        <input type="text" value="'.$alergii.'" class="profile-input" placeholder="Te rugam spune-ne la ce esti alergic" name="alergii" /></div>
                                                <div class="sectiune"><label class="labela">Ai intoleranță la medicamente / alimente?:</label>
                                                        <input type="text" value="'.$intoleranta.'" class="profile-input" placeholder="Te rugam spune-ne la ce ai intoleranta" name="intoleranta" /></div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-info" name="submit" type="submit" style="width:100%;font-size:13px;">Actualizeaza informațiile</button></form>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>';
                            echo'
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-header-text">Statisticile tale <button name="add" class="btn" id="add" style="color:#17a2b8; box-shadow:none; background-color:transparent;" type="button" data-target="#modalEditChart" data-toggle="modal"><i class="fa fa-pencil"></i></button></h6>
                                            <button class="btn float-right" style="color: rgba(51, 51, 51, 0.85); box-shadow:none; background-color:transparent;" id="toggleGraph"><i id="toggleGraphIcon" class="fa fa-minus-circle" style="font-size:24px"></i></button> 
                                             <a href="#" data-toggle="tooltip" title="Recomandam sa va luati tensiunea in mod regulat! Acest lucru este obligatoriu daca aveti probleme cardiovasculare!"><i class="fa fa-info-circle"></i></a>
                                        
                                        </div>';
                                        if(isset($_GET['eroaregraf']))
                                        {
                                            $mesaj = 'none';
                                            switch($_GET['eroaregraf'])
                                            {
                                                case 3:
                                                    {
                                                        $mesaj = 'Trebuie sa astepti urmatoarea zi pentru a introduce un nou set de valori';
                                                        break;
                                                    }
                                                case 2:
                                                    {
                                                        $mesaj = 'Datele introduse nu sunt corecte, asigură-te că scrii valoarea în sute, nu în zeci!';
                                                        break;
                                                    }
                                                case 1:
                                                    {
                                                        $mesaj = 'Datele nu au fost introduse';
                                                        break;
                                                    }
                                                default:
                                                    {
                                                        $mesaj = 'none';
                                                        break;
                                                    }
                                            }
                                               
                                            echo '<div class="card-header">
                                                <div role="alert" class="alert alert-danger"><span>'. $mesaj .'</span></div>
                                            </div>';
                                        }
                                        echo'<div class="card-body" id="Graph">
                                            <div class="row">
                                                <canvas id="myChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 <?php include"../../includes/footer.php";?>
 <div id="modalSimp" role="dialog" tabindex="-1" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editare profil</h4>
            </div>
            <div class="modal-body">
                <h6>Scrie mai jos ce simptome ai:</h6>
                <form action="db_manage/simptom.php" method="POST" id="insert_form_simp">
                    <textarea class="form-control" required id="input_dtype" name="text_simp"></textarea>
            </div>
            <div class="modal-footer">
            <button class="btn btn-info" type="submit">Salvează</button></form>
            <button class="btn btn-danger" data-toggle="modal" data-target="#modalSimp">Închide</button></div>
        </div>
    </div>
</div>
<div id="modalTransplant" role="dialog" tabindex="-1" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Lista de așteptare:</h4>
            </div>
            <div class="modal-body">
            <?php
                    $result = $connection->query("SELECT * FROM transplanturi_pacient WHERE accountID = '$id'");
	                if($result->num_rows){
	                    $row = $result->fetch_assoc();
	                    $prioritate = $row['priority'];
	                    switch($prioritate)
	                    {
	                        case 0:
	                            {
	                                $prioritate = "Nespecificată";
	                                break;
	                            }
	                        case 1:
	                            {
	                                $prioritate = "Scăzută";
	                                break;
	                            }
	                        case 2:
	                            {
	                                $prioritate = "Normală";
	                                break;
	                            }
	                        case 3:
	                            {
	                                $prioritate = "Ridicată";
	                                break;
	                            }
	                    }
	                	echo '<div class="alert alert-warning" role="alert"><span class="notification">Ai fost plasat în lista de așteptare pentru transplanturi de către Dr. ' . $row['medicName'] . ' prioritate: ' . $prioritate . '</span><hr><p>Mențiuni: ' . $row['mention'] . '</p></div><br/>';
                	}
                	else
                		echo '<span class="notification">Nu ai nevoie de nici un transplant momentan.</span>';
            ?>
            </div>
                <div class="modal-footer">
            	    <button class="btn btn-danger" data-toggle="modal" data-target="#modalTransplant">Închide</button>
                </div>
        </div>
    </div>
</div>
<div id="modalChangeMail" role="dialog" tabindex="-1" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><span style="font-size:13px">
                <h4 class="modal-title"><?php if ($s_cEmail == 0) echo'Validare e-mail cont:'; else if ($s_cEmail == 1) echo 'Schimbare e-mail cont:' ?></h4>
            </div>
            <div class="modal-body">
             <?php if ($s_cEmail == 0) echo'<span style="color:red; font-size:13px">Mailul tău este nevalidat</span><br><span style="font-size:13px">Scrie mai jos o adresă de mail pe care va trebui să o validezi!</span>';
                   else if ($s_cEmail == 1) echo'<span style="color:green; font-size:13px">Mailul tău este validat</span><br><span style="font-size:13px">Scrie mai jos noua adresă de mail pe care va trebui să o validezi!</span>';?>
                <form action="db_manage/eValidate.php" method="POST">
                    <div class="form-group-single">
                        <input class="form-control" type="text" name="email_change" required <?php echo 'value = '.$s_mail.'';?>>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" type="submit">Salvează</button></form>
                <button class="btn btn-danger" data-toggle="modal" data-target="#modalChangeMail">Închide</button>
            </div>
        </div>
    </div>
</div>
<div id="modalConsultationView" role="dialog" tabindex="-1" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Vizualizare consultații pacient:</h4>
            </div>
            <div class="modal-body">
                <?php
                	$result = $connection->query("SELECT * FROM consultatii_pacient WHERE accountID = '$id'");
	                	if($result->num_rows){
	                	while($row = $result->fetch_assoc())
	                	{
	                		echo '<div class="alert alert-warning" role="alert"><span class="notification">Consultație stabilită de Dr. ' . $row['medicName'] . ' în data de ' . $row['date'] . ' '. $row['time'] .'</span><hr><p>Mențiuni: ' . $row['mention'] . '</p></div><br/>';
	                		
	                	}
                	}
                	else
                		echo '<span class="notification">Nicio consultație nu a fost stabilită recent.</span>';
                ?> 
            </div>
            <div class="modal-footer"><button class="btn btn-danger" data-toggle="modal" data-target="#modalConsultationView">Închide</button></div></form>
        </div>
    </div>
</div>
<div id="modalTratamentView" role="dialog" tabindex="-1" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Vizualizare tratamente pacient:</h4>
            </div>
            <div class="modal-body">
                <?php
                	$result = $connection->query("SELECT * FROM tratament_pacient WHERE accountID = '$id' ORDER BY id DESC");
	                if($result->num_rows){
	                	while($row = $result->fetch_assoc())
	                	{
	                		echo '<div class="alert alert-warning" role="alert"><span class="notification">Tratament stabilit de Dr. ' . $row['medicName'] . ' în data de ' . $row['startDate'] . ' până în data de  '. $row['endDate'] .'</span><hr><p>Prescripție: ' . $row['treatment'] . '</p></div><br/>';
	                	}
                	}
                	else
                		echo '<span class="notification">Niciun tratament nu a fost stabilit recent.</span>';
                ?> 
            </div>
            <div class="modal-footer"><button class="btn btn-danger" data-toggle="modal" data-target="#modalTratamentView">Închide</button></div></form>
        </div>
    </div>
</div>
<div id="modalEditChart" role="dialog" tabindex="-1" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editare profil</h4>
            </div>
            <div class="modal-body">
                <h6>Introducere valori tensiune:</h6>
                <form action="db_manage/chart.php" method="POST" id="insert_form_simp">
                    <div class="form-group">
                	<h6>Introdu valoarea minimă (diastola):</h6>
                        <input class="form-control" type="text" name="diastola" required=""  inputmode="numeric">
                    </div>
                    <div class="form-group">
                	<h6>Introdu valoarea maximă (sistola):</h6>
                        <input class="form-control" type="text" name="sistola" required=""  inputmode="numeric">
                    </div>
                    <div class="form-group">
                	<h6>Introdu valoarea pulsului:</h6>
                        <input class="form-control" type="text" name="puls" required=""  inputmode="numeric">
                    </div>
            </div>
            <div class="modal-footer"><button class="btn btn-info" type="submit">Salvează</button></form>
            <button class="btn btn-danger" data-toggle="modal" data-target="#modalEditChart">Închide</button></div>
        </div>
    </div>
</div>
<div id="modalChangePass" role="dialog" tabindex="-1" class="modal fade show">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Schimbare parolă:</h4>
            </div>
            <div class="modal-body">
                <span>Îți poți schimba parola completând câmpurile de mai jos:</span>
                <form action="db_manage/changePass.php" method="POST">
                <div class="row" style="margin-top:12px;">
                    <div class="col">
                        <span style="font-size:13px">Parola curentă:</span>
                        <input name="actualPass" type="password" class="form-control" /></div>
                </div>
                <div class="row" style="margin-top:8px;">
                    <div class="col-md-6">
                        <span style="font-size:13px">Parola nouă:</span>
                        <input name="changePass" type="password" class="form-control" />
                        <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                    </div>
                    <div class="col-md-6">
                        <span style="font-size:13px">Confirmă parola nouă:</span>
                        <input name="changePassConfirm" type="password" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button name="submitChangePass" class="btn btn-info" type="submit">Schimbă</button></form>
            <button class="btn btn-danger" type="button" data-dismiss="modal">Închide</button></div>
        </div>
    </div>
</div>

    <script src="https://hospiweb.novacdan.ro/panel/profil/js/Chart.min.js"></script>
    <script src="https://hospiweb.novacdan.ro/panel/profil/js/chart_app.js"></script>
    <script src= "https://hospiweb.novacdan.ro/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://hospiweb.novacdan.ro/assets/js/bootstrap-better-nav.js"></script>
    <script type="text/javascript">
        $("#toggletutorial").click(function(){
            if ($("#Tutorial").css("display")=="none"){
            $("#Tutorial").fadeIn();
            $("#toggletutorial").html("Ascunde tutorial");
            } else {
            $("#Tutorial").fadeOut();
            $("#toggletutorial").html("Arată tutorial");
            }
        })
    </script>
    <script type="text/javascript">
        $("#toggleSimptom").click(function(){
            if ($("#Simptom").css("display")=="none"){
            $("#Simptom").toggle();
            $("#toggleSimptomIcon").attr("class", "fa fa-minus-circle");
            } else {
            $("#Simptom").toggle();
            $("#toggleSimptomIcon").attr("class", "fa fa-plus-circle");
            }
        })
    </script> 
    <script type="text/javascript">
        $("#toggleDiagnostic").click(function(){
            if ($("#Diagnostics").css("display")=="none"){
            $("#Diagnostics").toggle();
            $("#toggleDiagnosticIcon").attr("class", "fa fa-minus-circle");
            } else {
            $("#Diagnostics").toggle();
            $("#toggleDiagnosticIcon").attr("class", "fa fa-plus-circle");
            }
        })
    </script>  
    <script type="text/javascript">
        $("#toggleAdditional").click(function(){
            if ($("#Additional").css("display")=="none"){
            $("#Additional").toggle();
            $("#toggleAdditionalIcon").attr("class", "fa fa-minus-circle");
            } else {
            $("#Additional").toggle();
            $("#toggleAdditionalIcon").attr("class", "fa fa-plus-circle");
            }
        })
    </script>  
    <script type="text/javascript">
        $("#toggleGraph").click(function(){
            if ($("#Graph").css("display")=="none"){
            $("#Graph").toggle();
            $("#toggleGraphIcon").attr("class", "fa fa-minus-circle");
            } else {
            $("#Graph").toggle();
            $("#toggleGraphIcon").attr("class", "fa fa-plus-circle");
            }
        })
    </script> 
    <script type="text/javascript">
        $("#togglePacienti").click(function(){
            if ($("#listaPacienti").css("display")=="none"){
            $("#listaPacienti").toggle();
            $("#togglePacientiIcon").attr("class", "fa fa-minus-circle");
            } else {
            $("#listaPacienti").toggle();
            $("#togglePacientiIcon").attr("class", "fa fa-plus-circle");
            }
        })
    </script>  
    <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
</script>
    
</body>
</html>
