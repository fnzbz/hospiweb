<!DOCTYPE html>
<?php
session_start();
require 'includes/db.php';

if (isset($_SESSION['CNP'])){
    header ('Location: https://hospiweb.novacdan.ro/');
}

if(isset($_GET['code']))
{
    if(preg_match("#^[a-zA-Z0-9]+$#", $_GET['code']))
    {
        $code = $_GET['code'];
        $query = "SELECT * FROM password_reset_req WHERE code = '$code'";
        $result = $connection->query($query);
        $rows = $result->num_rows;
        $_SESSION['req-code'] = $code;
        
        if($rows)
        {
            $row = $result->fetch_assoc();
            if($row['expireTimestamp'] < time())
            {
                $query_del = "DELETE FROM password_reset_req WHERE code = '$code'";
                mysqli_query($connection, $query_del);
                header ('Location: https://hospiweb.novacdan.ro/');
            }
        }
        else
            header ('Location: https://hospiweb.novacdan.ro/');
    }
    else
        header ('Location: https://hospiweb.novacdan.ro/');
}
else
    header ('Location: https://hospiweb.novacdan.ro/');
?>

<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HospiWeb | Password Reset</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="/regulament/assets/css/bootstrap-better-nav.css">
    <link rel="stylesheet" href="/regulament/assets/css/styles.css">
    <meta charset="utf-8">
</head>

<body>
    <nav class="navbar navbar-dark navbar-expand-md bg-info logo">
        <div class="container"><a class="navbar-brand" href="https://hospiweb.novacdan.ro/">&nbsp; &nbsp; &nbsp; &nbsp; HospiWeb</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
                class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="https://hospiweb.novacdan.ro/login">Autentificare</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="https://hospiweb.novacdan.ro/register">Inregistrare</a></li>
                </ul>
        </div>
        </div>
    </nav>
    <section class="content login-separator">
        <div class="container">
            <div class="card login-form">
                <div class="card-header">
                    <h4 class="card-title">Introdu o parola pentru contul tau</h4>
                </div>
                <div class="card-body">
                    <form action="includes/changePassword.inc.php" method="POST">
                        <div class="form-group" id="password-group"><label>Parola</label><input class="form-control" id="pass" type="password" required="" autocomplete="off" minlength="8" name="password" rel="password"></div>
                        <div class="confirm-form" id="confirmed-password-group"><label>Confirma parola</label><input class="form-control" id="cpass" type="password" minlength="8" autocomplete="off" required="" name="cpass" rel="confirmed-password"></div>
                        <div class="form-actions"><button class="btn btn-success" name="changepass" type="submit" style="font-size:13px;">Salvează</button></div>
                    </form>
                </div>
                <?php
                    if (isset($_GET['eroare']) && $_GET['eroare'] == '1'){
                       echo '<div class="card-footer submitMessage"><div class="errorMessage"></div><hr><span>Eroare de submisie! Cele doua parole nu coincid!</span></div>';}
                    else if (isset($_GET['eroare']) && $_GET['eroare'] == '2'){
                         echo '<div class="card-footer submitMessage"><div class="errorMessage"></div><hr><span>Eroare de submisie! Parola introdusa nu indeplineste toate criteriile!</span></div>';}
                    else {
                       echo'<div class="card-footer errorMessage"></div>';
                   }
                ?>
                </div>
            </div>
        </div>
    </section>
<?php include"includes/footer.php";?>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/functions.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-better-nav.js"></script>
</body>
<script>
$(document).ready(function () {
   $("#pass, #cpass").keyup(function () {
       var errorMessage = "";
        
        if ((isPassword($("#pass").val()) == false) && ($("#pass").val() != "")) {
        
        errorMessage += "<span>Eroare locala! Parola trebuie sa fie cuprinsa intre 8 si 20 caractere si sa contina minim o litera si o cifra</span><br>";    
            
        }
        

        if (($("#pass").val() != $("#cpass").val()) && ($("#cpass").val() != "") && ($("#pass").val() != "") && (isPassword($("#pass").val()) == true)) {
                
        errorMessage += "<span>Eroare locala! Parolele nu coincid</span><br>";
                    
        }        
        
        if (errorMessage != "") {
                    
            $(".errorMessage").html(errorMessage);
                    
        } else {
                    
            $(".errorMessage").empty();
                    
        } 
       
   });
   

});
</script>
</html>