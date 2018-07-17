<!DOCTYPE html>
<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require '../../includes/db.php';  
if (!isset($_SESSION['CNP']) || $_SESSION['isMedic']==1){
    header ('Location: https://hospiweb.novacdan.ro/panel/ticket/list?eroare=medic');
    }
else {
    $s_cnp = $_SESSION['CNP'];
    $sql = "SELECT utilizator FROM utilizatori WHERE CNP='$s_cnp'";
    $result = $connection->query($sql);
        if($row = $result->fetch_assoc()) {
        $s_utilizator = $row['utilizator'];
        }
}
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
               <?php echo '<h5><span>Esti autentificat ca '.$s_utilizator;echo'!</h5><p> Aici poti vedea pacientii Hospiweb:<p></span>'; ?>
            </div>
        </div>
    </section>
    <section class="ticket-create">
        <div class="container">
            <div class="card" style="margin-top:20px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6" style="margin-bottom:20px;">
                            <form action="db_manage/createTicket.php" method="POST">
                            <div class="sectiune"><label style="color:gray;">Subiect:</label>
                            <input name="subiect" required type="text" class="form-control" /></div>
                            <div class="sectiune"><label style="color:gray;">Departament:</label>
                            <select name="departament" class="form-control">
                                <option value="1" selected>Tehnic</option>
                                <option value="2">Informații</option>
                                <option value="3">Medicină</option>
                            </select></div>
                            <div class="sectiune"><label style="color:gray;">Urgență:</label>
                            <select name="urgenta" class="form-control">
                                <option value="3">Ridicată</option>
                                <option value="2" selected>Medie</option>
                                <option value="1">Ușoară</option>
                            </select></div>
                            <div class="sectiune"><label style="color:gray;">Scrie problema ta mai jos:</label>
                                <textarea name="text" required class="form-control-lg form-control"></textarea></div>
                                <button name="submitTicket" class="btn btn-success" type="submit">Trimite ticket</button></div>
                            </form>    
                            <div class="col-md-6">
                            <h6>Întrebări frecvente:</h6>
                            <p class="intrebari">Î: Platforma este gratuită?<br /></p>
                            <p class="intrebari">R: Da, însă anumite servicii oferite de medici pot costa bani.<br /></p>
                            <hr />
                            <h6>Informații trimitere ticket de ajutor:</h6>
                            <p>*Fiecare ticket va primi un răspuns în maxim 48 ore de la creearea acestuia de la un membru al echipei HospiWeb.</p>
                            <p>*Dacă problema este rezolvată până la răspunsul unui membru al echipei puteți închide ticketul apasând pe butonul &quot;Închide ticket&quot; aflat în partea inferioară a interfeței.</p>
                            <p>*Puteți avea deschise maxim 3 tickete de ajutor simultan.</p>
                            <hr />
                            <h6>Regulament trimitere ticket de ajutor:</h6>
                            <p>*Aveți obligația ca în ticket să folosiți un limbaj decent, în caz contrar riscați ștergerea contului.</p>
                            <p style="color:red;">*Nu aveți voie să deschideți două sau mai multe tickete simultan pe același motiv.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 <?php include"../../includes/footer.php";?>
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../assets/js/functions.js"></script>
    <script src="../../assets/js/bootstrap-better-nav.js"></script>
</body>
</html>