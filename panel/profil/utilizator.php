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
    $sqlMe = "SELECT id, isMedic, isMod FROM utilizatori WHERE CNP='$s_cnp'";
    $resultMe = $connection->query($sqlMe);
        if($row = $resultMe->fetch_assoc()) {
        $s_id = $row['id'];
        $s_medic = $row['isMedic'];
        $s_isMod = $row['isMod'];
        }
}

    if (isset($_GET['id']))
    {   
        if($s_medic == 1)
            $_SESSION['utilizator_edit'] = $_GET['id'];
        
        if($_GET['id'] == $s_id)
           header ('Location: https://hospiweb.novacdan.ro/panel/profil/eu');
        else
        {
         if (is_numeric($_GET['id'])){    
            $Gid = $_GET['id'];
            $sql = "SELECT * FROM utilizatori WHERE id='$Gid'";
            $result = $connection->query($sql);
            
            if ($result->num_rows > 0) {
                
                if($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $utilizator = $row['utilizator'];
                $cnp = $row['CNP'];
                $lastLogin = date("d-m-Y H:i" ,$row['lastLogin']);
                $mail = $row['mail'];
                $telefon = $row['telefon'];
                $sange = $row['sange'];
                $medic = $row['isMedic'];
                $stare = $row['stare'];
                $sex = $row['sex'];
                $judet = $row['judet'];
                $nascut = $row['nascut'];
                $nascutTimestamp = date( "d-m-Y", $nascut);
                $varsta = floor((time() - $nascut) / 31556926);
                $cEmail = $row['confirmedEmail'];
                $isMod = $row['isMod'];
                }
            }
            else {
               header ('Location: https://hospiweb.novacdan.ro/login');
            }
        } else header ('Location: https://hospiweb.novacdan.ro/login');
    }
    }
    else header ('Location: https://hospiweb.novacdan.ro/login');
    
    if ($medic == 0){
                            
     $select_aditional_pacient = "SELECT * FROM aditional_pacient WHERE accountID='$id'";
     $result_aditional_pacient = $connection->query($select_aditional_pacient);
        if($row = $result_aditional_pacient->fetch_assoc()) {
            $p_limbasec = $row['limbasec'];
            $p_greutate = $row['greutate'];
            $p_inaltime = $row['inaltime'];
            $p_vaccinuri = $row['vaccinuri'];
            $p_oredormit = $row['oredormit'];
            $p_dependenta = $row['dependenta'];
            $p_exfizice = $row['exfizice'];
            $p_domiciliu = $row['domiciliu'];
            $p_alergii = $row['alergii'];
            $p_intoleranta = $row['intoleranta'];
                                    
        }}

    else if ($medic == 1){
    $select_aditional_medic = "SELECT * FROM aditional_medic WHERE accountID='$id'";
    $result_aditional_medic = $connection->query($select_aditional_medic);
        if($row = $result_aditional_medic->fetch_assoc()) {
            $p_limbasec = $row['limbasec'];
            $p_spital = $row['spital'];
            $p_specializare = $row['specializare'];
            $p_program = $row['program'];
            $p_cabinet = $row['cabinet'];
            $p_pret = $row['pret'];
        }
        else {
            $p_limbasec = "Nespecificat";
            $p_specializare = "Nespecificat";
        }    
    
    }
    if ($s_medic == 1) {
        $query_relation = "SELECT * FROM medicperm WHERE medicID='$s_id' AND pacientID='$id' AND isAcc = 1";
        $result_relation = $connection->query($query_relation);
        if ($result_relation->num_rows > 0){
            $relation = true;
        } else
            $relation = false;
    } else if ($s_medic == 0) {
        $query_relation = "SELECT * FROM medicperm WHERE medicID='$id' AND pacientID='$s_id' AND isAcc = 1";
        $result_relation = $connection->query($query_relation);
        if ($result_relation->num_rows > 0){
            $relation = true;
        } else
            $relation = false;        
    }
    
    $select_avatar = "SELECT * FROM avatars WHERE accountID='$id'";
    $result_avatar = $connection->query($select_avatar);
        if($row_avatar = $result_avatar->fetch_assoc()) {
            $avatarName = $row_avatar['avatarName'];
        }    
?>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HospiWeb | Panou - Vizualizeaza profil</title>
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="../../regulament/assets/css/bootstrap-better-nav.css">
    <link rel="stylesheet" href="../../regulament/assets/css/styles.css">
    <link rel="stylesheet" href="../../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="https://hospiweb.novacdan.ro/panel/profil/js/jquery-ui.css">
    <link rel="stylesheet" href="https://hospiweb.novacdan.ro/panel/profil/js/jquery-ui.theme.css">
    <link rel="stylesheet" href="https://hospiweb.novacdan.ro/panel/profil/js/jquery-ui-timepicker-addon.css">
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="https://hospiweb.novacdan.ro/panel/profil/js/jquery-ui.js"></script>
    <script src="https://hospiweb.novacdan.ro/panel/profil/js/jquery-ui-sliderAccess.js"></script>
    <script src="https://hospiweb.novacdan.ro/panel/profil/js/jquery-ui-timepicker-addon.js"></script>      
    <script type="text/javascript">
        $(document).ready(function(){
           $(".date").datetimepicker({
               minDate: -0,
               maxDate: "+6m",
               dateFormat: "dd-mm-yy",
           }); 
        });
    </script>
    <meta charset="utf-8">
</head>

<body>
 <?php include"../../includes/header.php";?>
    <section class="bunvenit">
        <div class="container">
            <div class="alert alert-light" role="alert">
               <?php echo '<h5><span>Vizualizezi profilul lui'; if ($medic == 1) echo ' Dr. '; echo ' '.$utilizator;echo'!</span></h5>';
               if ($s_isMod == 1 && $relation == false) { echo '<p style="color:green; font-size: 13px">INFO: Poti vizualiza datele personale deoarece esti moderator!</p>'; }
               if ($s_medic == 1 && $relation == true) {
                    echo '<span style="font-size:13px; color: #17A2B8">INFO: Acesta este unul dintre pacienții dumneavoastră!</span>';}
               else if ($s_medic == 0 && $relation == true) {
                    echo '<span style="font-size:13px; color: #8870c9">INFO: Acest doctor te are in lista sa ca și pacient!</span>';
               }
               ?>
            </div>
        </div>
    </section>
    <section class="w-content panou-optiuni section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <div class="card faq-left">
                        <div class="poza-profil">
                        <?php 
                       if ($result_avatar->num_rows > 0) {
  
                       echo'<img class="avatar-fluid" src="uploads/avatars/'.$avatarName.'">';
   
                       } else {
                        if ($sex == 1 && $medic != 0)
                        echo'
                        <img class="avatar-fluid" src="../../regulament/assets/img/profil-doctor.png">';
                              else if($sex == 2 && $medic != 0)
                        echo'<img class="avatar-fluid" src="../../regulament/assets/img/profil-doctor-girl.png">';
                              else if ($sex == 1 &&  $medic == 0)
                        echo'<img class="avatar-fluid" src="../../regulament/assets/img/profil-boy.png">';
                              else if ($sex == 2 &&  $medic == 0)
                        echo'<img class="avatar-fluid" src="../../regulament/assets/img/profil-girl.png">';
                              else 
                        echo'<img class="avatar-fluid" src="../../regulament/assets/img/no.png">';
                       }
                              
                              ?>
                        </div>
                        <div class="card-block">
                            <?php echo'<h5 class="text-center">' .$utilizator;echo'</h5>' ?>
                        <?php
                        if(($s_medic==1 && $medic!=1) || ($s_isMod == 1 && $isMod == 0)){
                            echo'<h6 class="text-center"><a href="" data-toggle="modal" data-target="#stergecont" style="color:red; font-size:13px">Sterge contul &nbsp;<i class="fa fa-trash"></i></a></h6>';
                            $_SESSION['whichAccount_Delete'] = $_GET['id'];
                        }
                       if($s_medic==1 && $medic!=1){
                            echo'<h6 class="text-center"><a href="" data-toggle="modal" data-target="#editarestare" style="color:orange; font-size:13px">Editeaza starea &nbsp;<i class="fa fa-pencil"></i></a></h6>';
                        }
                        if($s_isMod == 1 && $isMod == 0 && $medic == 0) {
                            echo'<h6 class="text-center"><a href="" data-toggle="modal" data-target="#editaregrad" style="color:green; font-size:13px">Seteaza medic &nbsp;<i class="fa fa-user-plus"></i></a></h6>';    
                        }
                        ?>
                        <?php
                        if ($isMod == 1) echo '<h6 class="text-center"><span class="label" style="background-color:green"><i class="fa fa-gear"></i>&nbsp;Moderator</span></h6>'; 
                        if($medic==1) echo'
                            <h6 class="text-center"><span class="label bg-purple"><i class="fa fa-graduation-cap"></i>&nbsp;'.$p_specializare.'</span></h6>'; 
                        else{
                        switch($stare){
                            case 0: echo'<h6 class="text-center"><span class="label" style="background-color:#000; color: #fff"><i class="fa fa-close"></i>&nbsp;Pacient - Decedat</span></h6>';
                            break;
                            case 1: echo'<h6 class="text-center"><span class="label bg-turcoaz"><i class="fa fa-user"></i>&nbsp;Pacient - Sanatos</span></h6>';
                            break;
                            case 2: echo'<h6 class="text-center"><span class="label bg-yellow"><i class="fa fa-heart"></i>&nbsp;Pacient - Bolnav</span></h6>';
                            break;
                            case 3: echo'<h6 class="text-center"><span class="label bg-red"><i class="fa fa-warning"></i>&nbsp;Pacient - Grav bolnav</span></h6>';
                            break;
                            default: echo'';
                        }}
                        ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-9">
                    <?php if($s_medic ==1 && $medic!=1){
                    	$num_rows_cons = $connection->query("SELECT COUNT(id) FROM consultatii_pacient WHERE accountID = '$id'");
                    	$rows_count_cons = $num_rows_cons->fetch_assoc();
                    	$num_cons = $rows_count_cons['COUNT(id)'];

                    	$num_rows_trans = $connection->query("SELECT COUNT(id) FROM transplanturi_pacient WHERE accountID = '$id'");
                    	$rows_count_trans = $num_rows_trans->fetch_assoc();
                    	$num_trans = $rows_count_trans['COUNT(id)'];
                    	
                    	$num_rows_treat = $connection->query("SELECT COUNT(id) FROM tratament_pacient WHERE accountID = '$id'");
                    	$rows_count_treat = $num_rows_treat->fetch_assoc();
                    	$num_treat = $rows_count_treat['COUNT(id)'];
                        echo'
                    <div class="header-profil">
                        <ul class="nav nav-tabs md-tabs tab-timeline">
                            <li class="profile-nav-item"><a class="nav-link" href="" data-toggle="modal" data-target="#modalConsultation">Consultatii
                            &nbsp;<span class="label" style="background-color: #F39C12; border-radius: 50%">'.$num_cons.'</span></h6></a></li>
                            <li class="profile-nav-item"><a href="" class="nav-link" data-toggle="modal" data-target="#modalTratament">Tratament
                            &nbsp;<span class="label" style="background-color: #F39C12; border-radius: 50%">'.$num_treat.'</span></h6></a></li>
                            <li class="profile-nav-item"><a href="" data-toggle="modal" data-target="#modalTransplant" class="nav-link">Transplanturi
                            &nbsp;<span class="label" style="background-color: #F39C12; border-radius: 50%">'.$num_trans.'</span></h6></a></li>
                        </ul>
                    </div>';}?>
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-header-text">INFORMATII GENERALE</h6>
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
                                                                        <?php
                                                                        if ($medic == 1){ echo '';}
                                                                        else{
                                                                        echo'
                                                                        <tr>
                                                                            <td style="color:#17a2b8;">CNP:</td>';
                                                                           
                                                                           if (($s_medic==1 && $relation == true) || $s_isMod == 1){
                                                                           echo'<td style="text-center">'.$cnp; echo'</td>';}
                                                                           else
                                                                           echo'<td style="text-center">XXXXXXXXXXXXX</td>';
                                                                           
                                                                        '</tr>';
                                                                        } ?>
                                                                        <tr>
                                                                            <td style="color:#17a2b8;">Sex:</td>
                                                                            <?php  
                                                                            switch($sex){
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
                                                                           <?php echo'<td style="text-center">'.$nascutTimestamp; echo' ('.$varsta; echo' ani) </td>'; ?>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="color:#17a2b8;">Ultima autentificare:</td>
                                                                            <?php echo'<td style="text-center">'.$lastLogin.'</td>'; ?>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="color:#17a2b8;">Telefon:</td>
                                                                           <?php 
                                                                           if (($s_medic==1 && $relation == true) || $s_isMod == 1){
                                                                           echo'<td style="text-center">'.$telefon; echo'</td>';}
                                                                           else if ($medic==1){
                                                                           echo'<td style="text-center">'.$telefon; echo'</td>';}
                                                                           else
                                                                           echo'<td style="text-center">07XXXXXXXX</td>';
                                                                           ?>
                                                                        </tr>
                                                                            <td style="color:#17a2b8;">Judet: </td>
                                                                            <?php echo'<td style="text-center">'.$judet; echo'</td>'; ?>
                                                                        <?php 
                                                                        if($medic==1){
                                                                            echo'';
                                                                        } else { 
                                                                        echo'
                                                                        <tr>
                                                                            <td style="color:#17a2b8;">Grupă sanguină:</td>';
                                                                            switch($sange){
                                                                                case 1: echo'<td style="text-center">0 (I)</td>';
                                                                                break;
                                                                                case 2: echo'<td style="text-center">A (II)</td>';
                                                                                break;
                                                                                case 3: echo'<td style="text-center">B (III)</td>'; 
                                                                                break;
                                                                                case 4: echo'<td style="text-center">AB (IV)</td>'; 
                                                                                break;
                                                                                default: echo'<td style="text-center">Nu a fost specificat</td>';}
                                                                            echo'</tr>';
                                                                            }
                                                                            ?>                                                                            

                                                                        <tr>
                                                                            <td style="color:#17a2b8;">Mail: <?php if (($cEmail == 0) && ($s_medic == 1)) echo'(Nevalidat)'; ?></td>
                                                                            <?php 
                                                                            if (($s_medic==1 && $relation == true) || $s_isMod == 1){
                                                                            echo'<td style="text-center">'.$mail; echo'</td>';}
                                                                            else if ($medic==1){
                                                                            echo'<td style="text-center">'.$mail; echo'</td>';   
                                                                            }
                                                                            else
                                                                            echo'<td style="text-center">Nu poti vedea acest lucru</td>';
                                                                            ?>
                                                                        </tr>                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-xl-6 margine-sus">
                                                           <?php 
                                                            $id = $_GET['id'];
                                                            $query = "SELECT * FROM diagnostic_pacient WHERE accountID = '$id'";
                                                            $result = $connection->query($query);
                                                            $row_diag = $result->fetch_assoc();
                                                            if($row_diag['text'] == '')
                                                                $row_diag['text'] = "Nu a fost setat niciun diagnostic.";
                                                            
                                                            $queryS = "SELECT * FROM simptome_pacient WHERE accountID = '$id'";
                                                            $resultS = $connection->query($queryS);
                                                            $row_simp = $resultS->fetch_assoc();
                                                            if($row_simp['text'] == '')
                                                                $row_simp['text'] = "Nu a fost setat niciun simptom.";
                                                            
                                                            if($medic != 1 && ($s_medic==1 || $s_isMod == 1)){echo'
                                                            <div class="table-responsive" id="diagnostice">
                                                                <table class="table simptome">
                                                                 <thead>
                                                                    <tr>
                                                                        <th>
                                                                            Simptomele pacientului:<button class="btn float-right" style="color:#fff; box-shadow:none; background-color:transparent;" id="toggleSimptom"><i id="toggleSimptomIcon" class="fa fa-minus-circle" style="font-size:20px"></i></button>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="Simptom">
                                                                    <tr>
                                                                        <td>
                                                                 <p>' . $row_simp['text'] . '</p>';
                                                                if($resultS->num_rows > 0)
                                                                {
                                                                    echo '<hr><p style="font-size: 10px;color:#fff">Editat la: ' . $row_simp['time'] . ' de catre: ' . $row_simp['medic'] . '<br /></p></td></tr></tbody></table></div>';
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
                                                                             Diagnosticul pacientului:&nbsp'; 
                                                                            if ($s_medic == 1) {   
                                                                             echo '<button type="button" name="add" id="add" data-toggle="modal" data-target="#modalDiag" class="btn" style="color:#fff; box-shadow:none; background-color:transparent;"><i class="fa fa-edit"></i></button>';} echo '<button class="btn float-right" style="color:#fff; box-shadow:none; background-color:transparent;" id="toggleDiagnostic"><i id="toggleDiagnosticIcon" class="fa fa-minus-circle" style="font-size:20px"></i></button>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="Diagnostics">
                                                                    <tr>
                                                                        <td>
                                                                <p>'. $row_diag['text'] .'</p>';
                                                                if($result->num_rows > 0)
                                                                {
                                                                    echo '<hr><p style="font-size: 10px;color:#fff">Editat la: ' . $row_diag['time'] . ' de catre: Dr. '. $row_diag['medic'] .'<br /></p></td></tr></tbody></table></div>';
                                                                }
                                                                else
                                                                {
                                                                    echo '</td></tr></tbody></table></div>';
                                                                }
                                                            }?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php if(($s_medic==1 || $s_isMod==1) && $medic==0){echo'   
                            <div class="card">
                            <div class="card-header">
                                <h6 class="card-header-text">INFORMAȚII ADIȚIONALE</h6><button class="btn float-right" style="color: rgba(51, 51, 51, 0.85); box-shadow:none; background-color:transparent;" id="toggleAdditional"><i id="toggleAdditionalIcon" class="fa fa-minus-circle" style="font-size:24px"></i></button>
                            </div>
                            <div class="card-body" id="Additional">
                                <div class="view-info">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="informatii-generale">
                                                <div class="row">
                                                    <div class="col-lg-12 col-xl-6">
                                                            <div class="sectiune"><label class="labela">Limbă secundară cunoscută:</label><select disabled class="profile-input"><option selected>
                                                            ';switch($p_limbasec){
                                                                case 1: echo 'Nu cunosc';
                                                                break;
                                                                case 2: echo 'Engleza';
                                                                break;
                                                                case 3: echo 'Franceza';
                                                                break;
                                                                case 4: echo 'Germana';
                                                                break;
                                                                case 5: echo 'Italiana';
                                                                break;
                                                                case 6: echo 'Spaniola';
                                                                break;    
                                                                case 7: echo 'Rusa';
                                                                break;
                                                                case 8: echo 'Alta';
                                                                break;
                                                                default: echo 'Nu a fost setat';
                                                            }
                                                             echo'</option></select></div>
                                                    <div class="sectiune"><label class="labela">Greutate (kg):</label>
                                                        <input disabled type="text" class="profile-input" value="'.$p_greutate.'"/></div>
                                                    <div class="sectiune"><label class="labela">Înălțime (cm):</label>
                                                        <input disabled type="text" class="profile-input" value="'.$p_inaltime.'"/></div>
                                                    <div class="sectiune"><label class="labela">Are toate vaccinurile obligatorii făcute?:</label>
                                                        <select disabled class="profile-input">
                                                        <option selected>';
                                                        switch($p_vaccinuri){
                                                            case 1: echo 'Da';
                                                            break;
                                                            case 2: echo 'Nu';
                                                            break;
                                                            case 3: echo 'Nu stie';
                                                            break;
                                                            default: echo 'Nu a fost setat';
                                                        }
                                                        echo'</option></select></div>
                                                 <div class="sectiune"><label class="labela">Cate ore doarme in medie pe zi:</label>
                                                        <select disabled class="profile-input">
                                                        <option selected>';
                                                        switch($p_oredormit){
                                                            case 1: echo '1-3';
                                                            break;
                                                            case 2: echo '4-6';
                                                            break;
                                                            case 3: echo '7-9';
                                                            break;
                                                            case 4: echo '10-12';
                                                            break;
                                                            default: echo 'Nu a fost setat';
                                                        }
                                                        echo'</option></select></div></div>
                                            <div class="col-lg-12 col-xl-6">
                                                <div class="sectiune"><label class="labela">Dependenta:</label>
                                                        <select disabled class="profile-input">
                                                        <option selected>';
                                                        switch($p_dependenta){
                                                            case 1: echo 'Alcool';
                                                            break;
                                                            case 2: echo 'Nicotina';
                                                            break;
                                                            case 3: echo 'Etnobotanice';
                                                            break;
                                                            case 4: echo 'De nimic';
                                                            break;
                                                            default: echo 'Nu a fost setat';
                                                        }
                                                        echo'</option></select></div>
                                                <div class="sectiune"><label class="labela">Adresa de domiciliu:</label>
                                                        <input disabled type="text" class="profile-input" value="'.$p_domiciliu.'" placeholder="Nu a fost setat"/></div>        
                                                <div class="sectiune"><label class="labela">Face exercitii fizice?:</label>
                                                        <select disabled class="profile-input">
                                                        <option selected>';
                                                        switch($p_exfizice){
                                                            case 1: echo 'Da';
                                                            break;
                                                            case 2: echo 'Nu';
                                                            break;
                                                            default: echo 'Nu a fost setat';
                                                        }
                                                        echo'</option></select></div>
                                                <div class="sectiune"><label class="labela">Alergii:</label><input disabled type="text" value="'.$p_alergii.'" placeholder="Nu a fost setat" class="profile-input"/></div>
                                                <div class="sectiune"><label class="labela">Intoleranță la medicamente / alimente:</label><input disabled type="text" class="profile-input" value="'.$p_intoleranta.'" placeholder="Nu a fost setat"/></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-header-text">Statisticile pacientului</h6><button class="btn float-right" style="color: rgba(51, 51, 51, 0.85); box-shadow:none; background-color:transparent;" id="toggleGraph"><i id="toggleGraphIcon" class="fa fa-minus-circle" style="font-size:24px"></i></button> 
                                        </div>
                                        <div class="card-body" id="Graph">
                                            <div class="row">
                                                <canvas id="myChartU"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>'; } 
                            else if ($medic==1) { echo'
                                <div class="card">
                                <div class="card-header">
                                    <h6 class="card-header-text">INFORMAȚII ADIȚIONALE</h6><button class="btn float-right" style="color: rgba(51, 51, 51, 0.85); box-shadow:none; background-color:transparent;" id="toggleAdditional"><i id="toggleAdditionalIcon" class="fa fa-minus-circle" style="font-size:24px"></i></button>
                                </div>
                                <div class="card-body" id="Additional">
                                    <div class="view-info">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="informatii-generale">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-xl-6">
                                                            <div class="sectiune"><label class="labela">Limbă secundară cunoscută:</label><select disabled class="profile-input"><option selected>
                                                            ';switch($p_limbasec){
                                                                case 1: echo 'Nu cunosc';
                                                                break;
                                                                case 2: echo 'Engleza';
                                                                break;
                                                                case 3: echo 'Franceza';
                                                                break;
                                                                case 4: echo 'Germana';
                                                                break;
                                                                case 5: echo 'Italiana';
                                                                break;
                                                                case 6: echo 'Spaniola';
                                                                break;    
                                                                case 7: echo 'Rusa';
                                                                break;
                                                                case 8: echo 'Alta';
                                                                break;
                                                            }
                                                            echo'</option></select></div>
                                                            <div class="sectiune"><label style="color:rgb(255,100,221);">Specializarea:</label><select disabled class="profile-input"><option selected>'.$p_specializare.'</option></select></div>
                                                            <div class="sectiune"><label class="labela">Adresă cabinet propriu (Dacă există):</label><input disabled placeholder="Nu a fost setat" value="'.$p_cabinet.'" type="text" class="profile-input" /></div>
                                                        </div>
                                                <div class="col-lg-12 col-xl-6">
                                                    <div class="sectiune"><label class="labela">Spitalul de proveniență:</label></div><input disabled type="text" class="profile-input" value="'.$p_spital.'" placeholder="Nu a fost setat" />
                                                    <div class="sectiune"><label class="labela">Program consultații:</label><input disabled type="text" class="profile-input" value="'.$p_program.'" placeholder="Nu a fost setat" /></div>
                                                    <div class="sectiune"><label class="labela">Preț aproximativ / consultație:</label><input disabled type="text" class="profile-input" value="'.$p_pret.'" placeholder="Nu a fost setat" /></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>';  }                          
                            ?>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 <?php include"../../includes/footer.php";?>

<?php if ($s_medic == 1) { echo '
<div id="modalDiag" role="dialog" tabindex="-1" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editare profil</h4>
            </div>
            <div class="modal-body">
                <h6>Diagnosticul pacientului:</h6>
                <form action="db_manage/diagnostic.php" method="POST" id="insert_form_diag">
                    <textarea class="form-control" required id="input_dtype" name="text_diag"></textarea>
                 
            </div>
            <div class="modal-footer"><button class="btn btn-info" type="submit">Salvează</button></form>
            <button class="btn btn-danger" data-toggle="modal" data-dimiss="modal" data-target="#modalDiag">Închide</button></div>
        </div>
    </div>
</div>';
} ?>

<div id="modalConsultation" role="dialog" tabindex="-1" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editare profil</h4>
            </div>
            <div class="modal-body">
                <span class="notification">Opțiuni pentru consultații pacient:</span>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" name="ConsultationView" data-toggle="modal" data-target="#modalConsultationView">
                    <a data-toggle="modal" data-dimiss="modal"  data-target="#modalConsultation">Vizualizează</a>
                </button>
                <button class="btn btn-info" data-toggle="modal" data-target="#modalConsultationInsert">
                    <a data-toggle="modal" data-dimiss="modal" data-target="#modalConsultation">Introdu</a></button>
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
                	$id = $_GET['id'];
                	$result = $connection->query("SELECT * FROM consultatii_pacient WHERE accountID = '$id' ORDER BY id DESC");
	                	if($result->num_rows){
	                	while($row = $result->fetch_assoc())
	                	{
	                		echo '<div class="alert alert-warning" role="alert">'; ?>
	                		<?php echo'
	                		<form class="float-right" method="POST" action="db_manage/deleteInfoTabs.php">
	                		<input type="hidden" name="id" value="'.$row['id'].'">
	                		<button class="btn" type="submit" name="deleteCons" style="box-shadow:none; background-color:transparent;">
	                		    <span style="font-size:12px;color:darkred;"><i class="fa fa-trash"></i></span>
	                		</button></form>'; ?>
	                		<?php
	                		echo'<span class="notification">Consultație stabilită de Dr. ' . $row['medicName'] . ' în data de ' .date('d-m-Y G:i', strtotime($row['date'])). ' '. $row['time'] .'</span><hr><p>Mențiuni: ' . $row['mention'] . '</p></div><br/>';
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
<div id="modalConsultationInsert" role="dialog" tabindex="-1" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Introducere consultații pacient:</h4>
            </div>
            <div class="modal-body">
                <form action="db_manage/consultatii.php" method="POST" id="insert_form_consultatii">
                	<div class="form-group">
                	<h6>Setează data consultației:</h6>
                	<input type="text"  placeholder="DD-MM-YYYY HH:MM" id="date_cons" class="form-control date" autocomplete="off" required name="date_cons"></input>
                	</div>
                	<h6>Mențiuni (vizibile pentru pacient):</h6>
                	<textarea class="form-control" id="input_ctype" name="text_cons"></textarea>
            </div>
            <div class="modal-footer">
                <div class="errorMessageConsultation"></div>
            	<button class="btn btn-info" type="submit">Salvează</button></form>
            	<button class="btn btn-danger" data-toggle="modal" data-target="#modalConsultationInsert">Închide</button></div>
        </div>
    </div>
</div>


<div id="modalTransplant" role="dialog" tabindex="-1" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Introducere pe lista de asteptare:</h4>
            </div>
            <div class="modal-body">
                <form action="db_manage/transplanturi.php" method="POST" id="insert_form_consultatii">
                	<div class="form-group">
                	<h6>Selectează prioritatea în listă</h6>
                	<select class="form-control" name="trans_pacient">
	                    <option value="1">Scăzută</option>
	                    <option value="2" selected>Normală</option>
	                    <option value="3">Ridicată</option>
                	</select>
                	</div>
                	<div class="form-group">
                	<h6>Mențiuni:</h6>
                	<textarea class="form-control" placeholder="Precizarea organului necesar pentru transplant" id="input_ctype" required name="text_trans"></textarea>
            		</div>
        </div>
                <div class="modal-footer">
            	    <button name="submitTransplant" class="btn btn-info" type="submit" data-toggle="modal" data-target="#modalTransplant">Salvează</button></form>
            	    <button class="btn btn-danger" data-toggle="modal" data-target="#modalTransplant">Închide</button></div>
    </div>
</div>
</div>
<div id="editarestare" role="dialog" tabindex="-1" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Actualizeaza starea pacientului:</h4></div>
            <div class="modal-body">
                <p>Selecteaza de mai jos starea apoi apasa &quot;Actualizeaza&quot;.</p>
                <form action="db_manage/stare.php" method="POST" id="insert_form_stare">
                <select class="form-control" name="stare_pacient">
                    <option value="1" selected>Sanatos</option>
                    <option value="2">Bolnav</option>
                    <option value="3">Grav bolnav</option>
                    <option value="0">Decedat</option>
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" type="submit">Actualizeaza</button></form>
                <button class="btn btn-light" type="button" data-dismiss="modal">Inchide</button>
            </div>
    	</div>
	</div>
</div>

<div id="stergecont" role="dialog" tabindex="-1" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editare profil</h4>
            </div>
            <div class="modal-body">
                <p style="font-size:15px">Ești sigur că dorești să ștergi acest cont?</p>
            </div>
            <div class="modal-footer">
            	<form action="https://hospiweb.novacdan.ro/includes/delAcc.inc.php" method="POST">
            	<button class="btn btn-success" type="submit" data-toggle="modal" name="submitDelAcc" data-target="#stergecont">Continuă</button>
            	</form>
            	<button class="btn btn-danger" data-toggle="modal" data-target="#stergecont">Nu</button>
            </div>
        </div>
    </div>
</div>

<?php if ($s_isMod == 1) {
echo'
<div id="editaregrad" role="dialog" tabindex="-1" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editare stare</h4>
            </div>
            <div class="modal-body">
                <p style="font-size:15px">Ești sigur că dorești să promovezi acest pacient ca medic?</p>
            </div>
            <div class="modal-footer">
            	<form action="db_manage/editGrad.php" method="POST">
            	<button class="btn btn-success" value='.$id.' type="submit" name="submitEditGrad" data-toggle="modal" data-target="#editaregrad">Continuă</button>
            	</form>
            	<button class="btn btn-danger" data-toggle="modal" data-target="#editaregrad">Nu</button>
            </div>
        </div>
    </div>
</div>'; } ?>

<div id="modalTratament" role="dialog" tabindex="-1" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editare profil</h4>
            </div>
            <div class="modal-body">
                <span class="notification">Opțiuni tratamente pacient:</span>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" data-toggle="modal" data-target="#modalTratamentView">
                    <a data-toggle="modal" data-dimiss="modal" data-target="#modalTratament">Vizualizează</a>
                </button>
                <button class="btn btn-info" data-toggle="modal" data-target="#modalTratamentInsert">
                    <a data-toggle="modal" data-dimiss="modal" data-target="#modalTratament">Introdu</a>
                </button>
            </div>
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
                	$id = $_GET['id'];
                	$result = $connection->query("SELECT * FROM tratament_pacient WHERE accountID = '$id' ORDER BY id DESC");
	                if($result->num_rows){
	                	while($row = $result->fetch_assoc())
	                	{
	                		echo '<div class="alert alert-warning" role="alert">'; ?>
	                	<?php echo'
	                		<form class="float-right" method="POST" action="db_manage/deleteInfoTabs.php">
	                		<input type="hidden" name="id" value="'.$row['id'].'">
	                		<button class="btn" type="submit" name="deleteTreat" style="box-shadow:none; background-color:transparent;">
	                		    <span style="font-size:12px;color:darkred;"><i class="fa fa-trash"></i></span>
	                		</button></form>'; ?>
	                	    <?php echo'
	                		<span class="notification">Tratament stabilit de Dr. ' . $row['medicName'] . ' în data de ' .date('d-m-Y G:i', strtotime($row['startDate'])). ' până în data de  '.date('d-m-Y G:i', strtotime($row['endDate'])).'</span><hr><p>Prescripție: ' . $row['treatment'] . '</p></div><br/>';
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

<div id="modalTratamentInsert" role="dialog" tabindex="-1" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Introducere tratamente pacient:</h4>
            </div>
            <div class="modal-body">
                <form action="db_manage/tratamente.php" method="POST" id="insert_form_consultatii">
                	<div class="form-group">
                	<h6>Setează data finală a tratamentului:</h6>
                	<input type="text" autocomplete="off" id="date_treat" placeholder="DD-MM-YYYY HH:MM" class="form-control date" required name="date_treat"></input>
                	</div>
                	<h6>Tratament:</h6>
                	<textarea class="form-control" id="input_ctype" required name="text_treat"></textarea>
            </div>
                <div class="modal-footer">
                    <div class="errorMessageTreatment"></div>
                	<button class="btn btn-info" type="submit">Salvează</button></form>
                	<button class="btn btn-danger" data-toggle="modal" data-target="#modalTratamentInsert">Închide</button></div>
        </div>
    </div>
</div>
    <script src="https://hospiweb.novacdan.ro/panel/profil/js/Chart.min.js"></script>
    <script src="https://hospiweb.novacdan.ro/panel/profil/js/chart_app_users.js"></script>  
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../assets/js/bootstrap-better-nav.js"></script>
    
    <script type="text/javascript">
        function isDateTime(dateTime) {
        var reDateTime = /^(((0[1-9]|[12]\d|3[01])\-(0[13578]|1[02])\-((19|[2-9]\d)\d{2}))|((0[1-9]|[12]\d|30)\-(0[13456789]|1[012])\-((19|[2-9]\d)\d{2}))|((0[1-9]|1\d|2[0-8])\-02\-((19|[2-9]\d)\d{2}))|(29\-02\-((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))\s([0-1][0-9]|[2][0-3]):([0-5][0-9])$/;
        return reDateTime.test(dateTime);
    }

    $(document).ready(function(){


        $("#date_treat").keyup(function() {
            
            var errorMessageTreatment = "";
            
            if ((isDateTime($("#date_treat").val()) == false) && ($("#date_treat").val() != "")) {
                    
            errorMessageTreatment += "<span>Eroare: Data introdusa este invalida</span><br>";
                    
            }
   
            
            if (errorMessageTreatment != "") {
                    
                $(".errorMessageTreatment").html(errorMessageTreatment);
                    
            } else {
                    
                $(".errorMessageTreatment").empty();
                    
            }
        });
        
        $("#date_cons").keyup(function() {
            
            var errorMessageConsultation = "";
            
            if ((isDateTime($("#date_cons").val()) == false) && ($("#date_cons").val() != "")) {
                    
            errorMessageConsultation += "<span>Eroare: Data introdusa este invalida</span><br>";
                    
            }
            
            
            if (errorMessageConsultation != "") {
                    
                $(".errorMessageConsultation").html(errorMessageConsultation);
                    
            } else {
                    
                $(".errorMessageConsultation").empty();
                    
            }
        });
    });
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
</body>
</html>
