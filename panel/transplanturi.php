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
    $sql = "SELECT utilizator, CNP, isMedic FROM utilizatori WHERE CNP='$s_cnp'";
    $result = $connection->query($sql);
        if($row = $result->fetch_assoc()) {
        $s_utilizator = $row['utilizator'];
        $s_CNP = $row['CNP'];
        $s_medic = $row['isMedic'];
        }
}
  $sqlTrans = 'SELECT * FROM transplanturi_pacient ORDER BY priority DESC';
  $resultTrans = $connection->query($sqlTrans);
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
               <?php echo '<h5><span>Esti autentificat ca '.$s_utilizator;echo'!</h5><p> Aici poti vedea lista de asteptare a transplanturilor:<p></span>'; ?>
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
                                                                <div class="col-md-6 margin-search"><input class="form-control" id="searchTransplantByName" type="text" placeholder="Cauta dupa numele primitorului..."><div class="errorMessageSearch" id="errorMessageName"></div></div>
                                                                <div class="col-md-6 margin-search"><select class="form-control" id="searchTransplantByGS" type="text"><option disabled>Cauta dupa grupa sanguina...</option><option value="0 (I)">0 (I)</option>
                                                                ><option value="A (II)">A (II)</option>><option value="B (III)">B (III)</option>><option value="AB (IV)">AB (IV)</option></select><div class="errorMessageSearch" id="errorMessageGS"></div></div>
                                                            </div><hr>
                                                            <div class="table-responsive">
                                                                <table class="table table-striped-transplanturi m-0 transplanturi" id="Transplanturi">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Data</th>
                                                                            <th>Nume</th>
                                                                            <th>G.S.</th>
                                                                            <th>Mentiuni</th>                                                    
                                                                            <th class="text-center">Prioritate</th>
                                                                            <?php 
                                                                            if ($s_medic == 1){
                                                                            echo'<th class="text-center"><i class="fa fa-gear"></i></th>';  
                                                                            }
                                                                            ?>
                                                                            
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        if ($resultTrans->num_rows > 0) {
                                                                            
       
                                                                                while($row = $resultTrans->fetch_assoc()) {
                                                                                    $date = $row['date'];
                                                                                    $mentiune = $row['mention'];
                                                                                    $prioritate = $row['priority'];
                                                                                    $id = $row['accountID'];
                                                                                      
                                                                                    $select = "SELECT sange, utilizator, CNP FROM utilizatori WHERE id = '$id'";
                                                                                    $resultQ = $connection->query($select);
                                                                                    $rowsQ = $resultQ->fetch_assoc();
                                                                                    
                                                                                    $utilizator = $rowsQ['utilizator'];
                                                                                    $sange = $rowsQ['sange'];
                                                                                    $cnp = $rowsQ['CNP'];
                                                                                    
                                                                                    echo '<tr>';
                                                                                    echo '<td>'.date("d-m-Y H:i", $date).'</td>';
                                                                                    if ($s_CNP==$cnp){
                                                                                    echo '<td class="NameTrans"><a href="https://hospiweb.novacdan.ro/panel/profil/eu">'.$utilizator;echo'</a></td>';}
                                                                                    else
                                                                                    echo '<td class="NameTrans"><a href="https://hospiweb.novacdan.ro/panel/profil/utilizator?id='.$id.'">'.$utilizator;echo'</a></td>';
                                                                                    
                                                                                    switch($sange){
                                                                                    case 1: echo'<td class="GSTrans">0 (I)</td>';
                                                                                    break;
                                                                                    case 2: echo'<td class="GSTrans">A (II)</td>';
                                                                                    break;
                                                                                    case 3: echo'<td class="GSTrans">B (III)</td>'; 
                                                                                    break;
                                                                                    case 4: echo'<td class="GSTrans">AB (IV)</td>'; 
                                                                                    break;
                                                                                    default: echo'<td>Nu a fost specificat</td>';
                                                                                    }
                                                                                    echo '<td>'. $mentiune . '</td>';
                                                                                    switch($prioritate){
                                                                                        case 1: echo'<td><h6 class="text-center"><span class="label" style="background-color:green"><i class="fa fa-user"></i>&nbsp;Scazuta</span></h6></td>';
                                                                                        break;
                                                                                        case 2: echo'<td><h6 class="text-center"><span class="label bg-yellow"><i class="fa fa-heart"></i>&nbsp;Medie</span></h6></td>';
                                                                                        break;
                                                                                        case 3: echo'<td><h6 class="text-center"><span class="label bg-red"><i class="fa fa-warning"></i>&nbsp;Ridicata</span></h6></td>';
                                                                                        break;
                                                                                        default: echo'<td><h6 class="text-center"><span class="label" style="background-color:gray"><i class="fa fa-question"></i>&nbsp;Nespecificata</span></h6></td>';
                                                                                    }
                                                                                    
                                                                                    if ($s_medic == 1) {
                                                                                    echo'<td class="text-center"><form class="text-center" method="POST" action="profil/db_manage/deleteInfoTabs.php">
                                                            	                		<input type="hidden" name="id" value="'.$row['id'].'">
                                                            	                		<button class="btn" type="submit" name="deleteTrans" style="box-shadow:none; background-color:transparent;">
                                                            	                		<i class="fa fa-trash" style="color: darkred"></i>
                                                            	                		</button></form></td>';
                                                                                    }
                                                                                    
                                                                                    echo '</tr>';
                                                                                     }
                                                                            }
                                                                            else {
                                                                               echo "<tr><td>Nu s-au gasit oameni ce au nevoie de un transplant!</td>";
                                                                               echo"<td></td><td></td><td></td><td></td>";
                                                                               if ($s_medic == 1){ echo "<td></td></tr>";} else echo"</tr>";
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
           $("#searchTransplantByName").keyup(function () {
               var errorMessage = "";
                if (isNumeric($("#searchTransplantByName").val()) == true) {
                    errorMessage = "<span>Tutorial: Numele trebuie sa nu contina cifre</span>";    
                }
                if ((isNumeric($("#searchTransplantByName").val()) == false) || ($("#searchTransplantByName").val() == "")) {
                    searchTransplantByName();
                }
                if (errorMessage != "") {
                    $("#errorMessageName").html(errorMessage);
                } else {
                    $("#errorMessageName").empty();
                }
               
           }); 
        });

    </script>    
    <script type="text/javascript">

        $(document).ready(function () {
           $("#searchTransplantByGS").change(function () {
                if ($("#searchTransplantByGS").val()) {
                    searchTransplantByGS();
                }
           }); 
        });

    </script>   
</body>
</html>