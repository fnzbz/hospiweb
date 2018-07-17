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
    $sql = "SELECT id, utilizator, CNP, isMedic FROM utilizatori WHERE CNP='$s_cnp'";
    $result = $connection->query($sql);
        if($row = $result->fetch_assoc()) {
        $s_id = $row['id'];
        $s_utilizator = $row['utilizator'];
        $s_CNP = $row['CNP'];
        $s_medic = $row['isMedic'];
        }
}
  $sqlPacienti = 'SELECT * FROM utilizatori WHERE isMedic=0 ORDER BY stare DESC' ;
  $resultPacienti = $connection->query($sqlPacienti);
  
?>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HospiWeb | Panou - Doctori</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="../../regulament/assets/css/bootstrap-better-nav.css">
    <link rel="stylesheet" href="../regulament/assets/css/styles.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <meta charset="utf-8">
</head>

<body>
 <?php include"../includes/header.php";?>  
    <section class="bunvenit">
        <div class="container">
            <div class="alert alert-light" role="alert">
               <?php echo '<h5><span>Esti autentificat ca '.$s_utilizator;echo'!</h5><p> Aici poti vedea pacientii Hospiweb:<p></span>'; ?>
            </div>
        </div>
    </section>
    <section class="w-content panou-optiuni section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="tab-content">
                                        <div class="tab-pane active">
                                                    <div class="table-content">
                                                        <div class="col-sm-12 table-responsive">
                                                            <br><h6>Optiuni cautare / sortare:</h6>
                                                            <div class="row">
                                                                <div class="col margin-search"><input class="form-control" id="searchPacientByName" type="text" placeholder="Cauta dupa numele pacientului..."><div class="errorMessageSearch" id="errorMessageName"></div></div>
                                                            </div><hr>
                                                            <div class="table-responsive">
                                                                <table class="table table-striped-profile  m-0 pacienti" id="Pacienti">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Nume</th>
                                                                            <th>Ultima autentificare</th>
                                                                            <th>G.S.</th>
                                                                            <th class="text-center">Stare</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        if ($resultPacienti->num_rows > 0) {
                                                                                while($row = $resultPacienti->fetch_assoc()) {
                                                                                    $utilizator = $row['utilizator'];
                                                                                    $id = $row['id'];
                                                                                    $cnp = $row['CNP'];
                                                                                    $sange = $row['sange'];
                                                                                    $isMedic = $row['isMedic'];
                                                                                    $stare = $row['stare'];
                                                                                    $lastLogin = date("d-m-Y H:i", $row['lastLogin']);
                                                                                    echo '<tr>';
                                                                                    if ($s_CNP==$cnp){
                                                                                    echo '<td><a href="https://hospiweb.novacdan.ro/panel/profil/eu">'.$utilizator;echo'</a></td>';}
                                                                                    else
                                                                                    echo '<td><a href="https://hospiweb.novacdan.ro/panel/profil/utilizator?id='.$id.'">'.$utilizator;echo'</a></td>';
                                                                                    echo '<td>'.$lastLogin.'</td>';
                                                                                    switch($sange){
                                                                                    case 1: echo'<td>0 (I)</td>';
                                                                                    break;
                                                                                    case 2: echo'<td>A (II)</td>';
                                                                                    break;
                                                                                    case 3: echo'<td>B (III)</td>'; 
                                                                                    break;
                                                                                    case 4: echo'<td>AB (IV)</td>'; 
                                                                                    break;
                                                                                    default: echo'<td >Nu a fost specificat</td>';
                                                                                }
                                                                                    
                                                                                    switch($stare){
                                                                                    case 0: echo'<td><h6 class="text-center"><span class="label" style="background-color:#000; color: #fff"><i class="fa fa-close"></i>&nbsp;Decedat</span></h6></td>';
                                                                                    break;
                                                                                    case 1: echo'<td><h6 class="text-center"><span class="label bg-turcoaz"><i class="fa fa-user"></i>&nbsp;Sanatos</span></h6></td>';
                                                                                    break;
                                                                                    case 2: echo'<td><h6 class="text-center"><span class="label bg-yellow"><i class="fa fa-heart"></i>&nbsp;Bolnav</span></h6></td>';
                                                                                    break;
                                                                                    case 3: echo'<td><h6 class="text-center"><span class="label bg-red"><i class="fa fa-warning"></i>&nbsp;Grav bolnav</span></h6></td>';
                                                                                    break;
                                                                                    default: echo'<td><h6 class="text-center"><span class="label" style="background-color:gray"><i class="fa fa-question"></i>&nbsp;Nespecificat</span></h6></td>';
                                                                                }
                                                                                    echo '</tr>';
                                                                                }
                                                                            }
                                                                            else {
                                                                               echo "<td>Nu s-au gasit utilizatori ai platformei in baza de date!</td>";
                                                                               echo "<td></td><td></td><td></td>";
                                                                            }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 <?php include"../includes/footer.php";?>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/functions.js"></script>
    <script src="../assets/js/bootstrap-better-nav.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {
           $("#searchPacientByName").keyup(function () {
               var errorMessage = "";
                if (isNumeric($("#searchPacientByName").val()) == true) {
                    errorMessage = "<span>Tutorial: Numele trebuie sa nu contina cifre</span>";    
                }
                if ((isNumeric($("#searchPacientByName").val()) == false) || ($("#searchPacientByName").val() == "")) {
                    searchPacientByName();
                }
                if (errorMessage != "") {
                    $("#errorMessageName").html(errorMessage);
                } else {
                    $("#errorMessageName").empty();
                }
               
           }); 
        });

</script>    
</body>
</html>