<!DOCTYPE html>
<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require '../includes/db.php'; 

if (!isset($_SESSION['CNP'])){
    header ('Location: https://hospiweb.novacdan.ro/login');
    }
else {
    $s_cnp = $_SESSION['CNP'];
    $sqlMe = "SELECT id, utilizator, CNP, isMedic FROM utilizatori WHERE CNP='$s_cnp'";
    $resultMe = $connection->query($sqlMe);
        if($rowMe = $resultMe->fetch_assoc()) {
        $s_id = $rowMe['id'];
        $s_utilizator = $rowMe['utilizator'];
        $s_CNP = $rowMe['CNP'];
        $s_medic = $rowMe['isMedic'];
        }
}
  $sql = 'SELECT * FROM utilizatori WHERE isMedic=1';
  $result = $connection->query($sql);
  
  $select_aditional_medic = "SELECT * FROM aditional_medic";
  $result_aditional_medic = $connection->query($select_aditional_medic);
?>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>HospiWeb | Panou - Doctori</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="../../regulament/assets/css/bootstrap-better-nav.css">
    <link rel="stylesheet" href="../regulament/assets/css/styles.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <style type="text/css">
        .image-medic-list-fluid{
            width: auto;
            height: auto;
            max-width: 200px;
            max-height: 200px;
            border-radius: 50%;
        }

        .errorMessageSearch {
            color: #17A2B8;
            font-size: 13px;
        }
    </style>
</head>

<body>
 <?php include"../includes/header.php";?>  
    <section class="bunvenit">
        <div class="container">
            <div class="alert alert-light" role="alert">
               <?php echo '<h5><span>Esti autentificat ca '.$s_utilizator;echo'!</h5><p> Aici poti vedea doctorii Hospiweb:<p></span>'; ?>
            </div>
        </div>
    </section>
    <section>
    <div class="container">
    <?php 
    if (isset($_GET['eroare']) && $_GET['eroare']=='limita'){
    echo '<div role="alert" class="alert alert-danger">
        <span><strong>Eroare! </strong>Ai trimis deja o cerere acestui medic sau acest medic deja te are în lista sa.</span>
    </div>'; }
    if (isset($_GET['eroare']) && $_GET['eroare']=='negasit'){
    echo '<div role="alert" class="alert alert-danger">
        <span><strong>Eroare! </strong>Medicul solicitat nu există în baza noastră de date!</span>
    </div>'; }
    if (isset($_GET['action']) && $_GET['action']=='succes'){
    echo '<div role="alert" class="alert alert-success">
        <span><strong>Succes! </strong>Cererea ta a fost trimisă către doctor!</span>
    </div>'; }
    ?>
        <div class="card">
            <div class="card-body">
                <h6>Optiuni cautare / sortare:</h6>
                <div class="row">
                    <div class="col-md-6 margin-search"><input type="text" id="searchDoctorByName" placeholder="Cauta dupa numele medicului..." class="form-control" /><div id="errorMessageName" class="errorMessageSearch"></div></div>
                    <div class="col-md-6 margin-search"><input type="number" id="searchDoctorByTelephone" placeholder="Cauta dupa numarul de telefon..." class="form-control" /><div id="errorMessageTelephone" class="errorMessageSearch"></div></div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="w-content panou-optiuni section-padding" style="padding-top:0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div id="listaDoctori">
<?php
    if ($result->num_rows > 0) {
   
        while($row = $result->fetch_assoc()) {
            
            $id = $row['id'];
            $utilizator = $row['utilizator'];
            $cnp = $row['CNP'];
            $medic = $row['isMedic'];
            $lastLogin = date("d-m-Y H:i", $row['lastLogin']);
            $telefon = $row['telefon'];
            $mail = $row['mail'];
            $sex = $row['sex'];
            $id = $row['id']; 
            $judet = $row['judet'];
            
            $sqlPacients = "SELECT * FROM medicperm WHERE isAcc=1 AND medicID = '$id' AND pacientID = '$s_id'" ;
            $resultPacients = $connection->query($sqlPacients);  
            if ($resultPacients->num_rows > 0) {
                $relation = true;
            } else {
                $relation = false;
            }
            
            $constructor = "SELECT * FROM aditional_medic WHERE accountID = '$id'";
            $resultConst = $connection->query($constructor);
            $medic_rows = $resultConst->fetch_assoc();
            
            $select_avatar = "SELECT * FROM avatars WHERE accountID='$id'";
            $result_avatar = $connection->query($select_avatar);
                if($row_avatar = $result_avatar->fetch_assoc()) {
                    $avatarName = $row_avatar['avatarName'];
                }               
                
            $p_specializare = $medic_rows['specializare'];
            $p_cabinet = $medic_rows['cabinet'];
            $p_pret = $medic_rows['pret'];
            $p_limbasec = $medic_rows['limbasec'];
            $p_program = $medic_rows['program'];
            
            $p_specializare = ($p_specializare == '') ? ('Nespecificat') : ($medic_rows['specializare']);
            $p_program = ($p_program == '') ? ('Nu a fost setat') : ($medic_rows['program']);
            $p_pret = ($p_pret == '') ? ('Nu a fost setat') : ($medic_rows['pret']);
            $p_limbasec = ($p_limbasec == '') ? ('Nu cunosc') : ($medic_rows['limbasec']);
            $p_cabinet = ($p_cabinet == '') ? ('Nu a fost setata') : ($medic_rows['cabinet']);
            
        if($medic!=1){
            echo'';
        }
          else {
                  echo '
                <div class="card doctor">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-xl-3">
                                <div class="poza-profil">';
                               if ($result_avatar->num_rows > 0) {
                               echo'<img class="image-medic-list-fluid" src="profil/uploads/avatars/'.$avatarName.'">';
                               } else {                                
                                if ($sex == 1){echo'
                                <img src="../regulament/assets/img/profil-doctor.png" class="image-medic-list-fluid" />';}
                                else if ($sex == 2){echo'
                                <img src="../regulament/assets/img/profil-doctor-girl.png" class="image-medic-list-fluid" />';}
                               }
                                echo'
                                </div>
                                <div class="text-center">
                                    <h6 style="margin-top:7px;">';
                                    if ($p_pret == "") {
                                        $p_pret = "Nu a fost setat";
                                    }
                                    echo''.$p_pret.'</h6>
                                    <h6><span class="label bg-purple"><i class="fa fa-graduation-cap"></i>'.$p_specializare.'</span></h6>';
                                if ($s_medic == 0 && $relation == false) { echo '   
                                    <button class="btn btn-light" type="button" data-toggle="modal" data-target="#selectDoctor'.$id.'">Selecteaza</button>
                                    <div id="selectDoctor'.$id.'" role="dialog" tabindex="-1" class="modal fade">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Vrei să continui?</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Această acțiune va trimite cererea ta către doctorul <br>'.$utilizator.'!</p><p style="color: red">Dacă este acceptată, acesta va avea posibilitatea de a-ți vedea datele personale precum CNP-ul!</p>
                                            </div>
                                            <div class="modal-footer">
                                            	<form action="profil/db_manage/sendDoctorReq.php" method="POST">
                                            	<button class="btn btn-success" name="submitDoctorReq" value="'.$id.'" type="submit" data-toggle="modal" data-target="#selectDoctor'.$id.'">Continuă</button>
                                            	</form>
                                            	<button class="btn btn-danger" data-toggle="modal" data-target="#selectDoctor'.$id.'">Întoarce-te</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                                } else if ($s_medic == 0 && $relation == true) { echo '   
                                    <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#deleteDoctor'.$id.'">Deselecteaza</button>
                                    <div id="deleteDoctor'.$id.'" role="dialog" tabindex="-1" class="modal fade">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Vrei să continui?</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Această acțiune va înlătura permisiunile doctorului <br>'.$utilizator.' ce le are asupra ta!</p><p style="color: #8870c9">Acesta nu va mai putea să-ți vizualizeze datele personale!</p>
                                            </div>
                                            <div class="modal-footer">
                                            	<form action="profil/db_manage/sendDoctorDel.php" method="POST">
                                            	<button class="btn btn-success" name="submitDoctorDel" value="'.$id.'" type="submit" data-toggle="modal" data-target="#deleteDoctor'.$id.'">Continuă</button>
                                            	</form>
                                            	<button class="btn btn-danger" data-toggle="modal" data-target="#deleteDoctor'.$id.'">Întoarce-te</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                                }
                                echo '
                                </div>
                            </div>
                            <div class="col centered">
                            <hr>';
                              if ($s_CNP == $cnp) { echo'
                                <h4><a class="numeDoctor" href="https://hospiweb.novacdan.ro/panel/profil/eu">Dr. '.$utilizator.'</a></h4>';}
                              else { echo'
                                <h4'; if ($relation == true) { echo ' class="numeMyDoctor"'; } echo '><a class="numeDoctor" href="https://hospiweb.novacdan.ro/panel/profil/utilizator?id='.$id.'">Dr. '.$utilizator.'</a></h4>';}  
                              
                                echo'<div class="sectiune"><label class="labela" style="font-size:15px;'; if ($relation == true) {echo' color: #8870c9'; }echo '">Despre medic:</label>
                                    <p>Judet: '.$judet.'<br /><span class="telDoctor">Telefon: '.$telefon.'</span><br />Ultima autentificare: '.$lastLogin.' <br />Mail: '.$mail.'<br />Limbă secundară vorbită: '; 
                                                            switch($p_limbasec){
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
                                                            } echo'<br /></p>
                                </div>
                                <div class="sectiune"><label class="labela" style="font-size:15px;'; if ($relation == true) {echo' color: #8870c9'; }echo '">Despre consultații:</label>
                                    <p><strong>Program: ';                                   
                                    echo''.$p_program.'</strong><br /><strong>Adresă: ';
                                    echo ''.$p_cabinet.'</strong><br /></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
                  }
        }
    }
    else {
       echo '
        <div class="card">
            <div class="card-body text-center">
                <h6>Nu s-a găsit niciun doctor in baza noatră de date!</h6>
            </div>
        </div>';
    }
?>              </div>
            </div>
        </div>
    </div>
</section>
 <?php include"../includes/footer.php";?>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/functions.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/bootstrap-better-nav.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {
           $("#searchDoctorByName").keyup(function () {
               var errorMessage = "";
                if (isNumeric($("#searchDoctorByName").val()) == true) {
                    errorMessage = "<span>Tutorial: Numele trebuie sa nu contina cifre</span>";    
                }
                if ((isNumeric($("#searchDoctorByName").val()) == false) || ($("#searchDoctorByName").val() == "")) {
                    searchDoctorByName();
                }
                if (errorMessage != "") {
                    $("#errorMessageName").html(errorMessage);
                } else {
                    $("#errorMessageName").empty();
                }
               
           }); 
           
           $("#searchDoctorByTelephone").keyup(function () {
               var errorMessage = "";
                
                //Stiu ca exista functia $.isNumeric dar imi vine mai usor asa
                
                if (isNumeric($("#searchDoctorByTelephone").val()) == false ) {
                    errorMessage = "<span>Tutorial: Numarul de telefon trebuie sa fie in format numeric</span>";    
                }

                
                if ((isNumeric($("#searchDoctorByTelephone").val()) == true) || ($("#searchDoctorByTelephone").val() == "")) {
                    searchDoctorByTelephone();
                }
                
                if (errorMessage != "") {
                    $("#errorMessageTelephone").html(errorMessage);
                } else {
                    $("#errorMessageTelephone").empty();
                }
                
                
           });
        });

</script>
</body>
</html>