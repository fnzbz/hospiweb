<!DOCTYPE html>
<?php
session_start();

if (isset($_SESSION['CNP'])){
    header ('Location: https://hospiweb.novacdan.ro/panel/profil/eu');
    }
?>

<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HospiWeb | Inregistrare</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="/regulament/assets/css/bootstrap-better-nav.css">
    <link rel="stylesheet" href="/regulament/assets/css/styles.css">
    <script src='https://www.google.com/recaptcha/api.js'></script>
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
    <section class="content section-separator">
        <div class="container">
            <div class="card login-form">
                <div class="card-header">
                    <h4 class="card-title">Creeaza-ti un cont</h4>
                </div>
                <div class="card-body">
                    <form action="/includes/singup.inc.php" method="POST">
                        <div class="form-group" id="username-group"><label>Nume complet (fara diacritice)</label><input class="form-control" type="text" required="" autocomplete="off" id="name" name="utilizator" rel="utilizator" minlenght="5"></div>
                        <div class="form-group" id="mail-group"><label>Adresa de email</label><input class="form-control" id="mail" type="email" name="mail" required="" inputmode="email" rel="mail"></div>
                        <div class="sange-form" id="sange-group"><label>Grupa sanguina</label><select required name="sange" class="form-control"><option value="1" selected>0 (I)</option><option value="2">A (II)</option><option value="3">B (III)</option>
                        <option value="4">AB (IV)</option></select></div><br>
                        <div class="form-group" id="password-group"><label>Parola</label><input class="form-control" id="pass" type="password" required="" autocomplete="off" minlength="8" name="password" rel="password"></div>
                        <div class="confirm-form" id="confirmed-password-group"><label>Confirma parola</label><input class="form-control" id="cpass" type="password" autocomplete="off" required="" name="confirmed-password" rel="confirmed-password"></div>
                        <div class="cnp-form" id="cnp-group"><label>Cod numeric personal</label><input class="form-control" type="text" id="CNP" name="CNP" required="" maxlength="13" minlength="13" inputmode="numeric"></div>
                        <div class="form-group" id="telephone-group"><label>Numar de telefon</label><input class="form-control" type="tel" id="tel" name="telefon" required="" inputmode="tel"></div>
                        <div class="form-group">
                            <div class="form-check"><label class="form-check-label"><input type="checkbox" class="form-check-input" name="agreement" value="acord"><span>Am citit si sunt de acord cu&nbsp;</span><a href="https://hospiweb.novacdan.ro/regulament/termeni-si-conditii">Termenii si conditiile</a></label></div>
                        </div>
                        <div class="form-actions"><button class="btn btn-success" type="submit" style="font-size:13px;" name="register">Creeaza cont</button></div>
                    </form>
                </div>
                <div class="text-center">
                     <?php
                    
                    $errors = [
                        '1' => 'CNP-ul introdus exista deja in baza de date!',
                        '2' => 'Parolele introduse nu coincid!',
                        '3' => 'Trebuie sa fii de acord cu termenii si conditile!',
                        '4' => 'Adresa de mail este invalida!',
                        '5' => 'CNP-ul introdus nu este valid!',
                        '6' => 'Numele introdus este invalid!',
                        '7' => 'Numarul de telefon introdus este invalid!',
                        '8' => 'Parola introdusa nu inteplineste toate criteriile!',
                    ];
                    
                    if (isset($_GET['eroare']) && in_array($_GET['eroare'], array_keys($errors))) { ?>
                       <div class="card-footer submitMessage"><div class="errorMessage"></div><hr><span>Eroare de submisie! <?= $errors[$_GET['eroare']]; ?></span></div>
                   <?php } else { ?>
                       <div class="card-footer submitMessage"><span class="text-center mb-0" style="color:#575962">Ai deja un cont? Atunci autentifică-te <a href="/login">aici</a>!</span><div class="errorMessage"></div>
                   <?php } ?>
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
   $("#name, #tel, #pass, #cpass, #mail, #CNP").keyup(function() {
     var errorMessage = "";
     var fieldsMissing = "";
        //////////////////////////////////////////////////////////////////////////////////
        if ($("#name").val() == "") {
                    
        fieldsMissing += " Nume; ";
                    
        }       
        
        else if (isName($("#name").val()) == false) {
                    
        errorMessage += "<span>Eroare locala! Numele introdus este invalid</span><br>";
                    
        }
        //////////////////////////////////////////////////////////////////////////////////
        if ($("#mail").val() == "") {
                    
        fieldsMissing += "Mail; ";
                    
        }         
        
        else if (isMail($("#mail").val()) == false) {
                    
        errorMessage += "<span>Eroare locala! Mail-ul introdus este invalid</span><br>";
                    
        }   
        //////////////////////////////////////////////////////////////////////////////////
        if ($("#pass").val() == "") {
                    
        fieldsMissing += "Parola; ";
                    
        } else  if (isPassword($("#pass").val()) == false) {
        
        errorMessage += "<span>Eroare locala! Parola trebuie sa fie cuprinsa intre 8 si 20 caractere si sa contina minim o litera si o cifra</span><br>";    
            
        }
        
        if ($("#cpass").val() == "") {
                    
        fieldsMissing += "Confirmare parola; ";
                    
        }        
        
        if (($("#pass").val() != $("#cpass").val()) && ($("#cpass").val() != "") && ($("#pass").val() != "") && (isPassword($("#pass").val()) == true)) {
                
        errorMessage += "<span>Eroare locala! Parolele nu coincid</span><br>";
                    
        }
        //////////////////////////////////////////////////////////////////////////////////
        if ($("#CNP").val() == "") {
                    
        fieldsMissing += "CNP; ";
                    
        }
        else if ((isNumeric($("#CNP").val()) == false) || ($("#CNP").val().length != 13)) {
                    
        errorMessage += "<span>Eroare locala! CNP-ul nu este valid!</span><br>"
                    
        }
        //////////////////////////////////////////////////////////////////////////////////
        if ($("#tel").val() == "") {
                    
        fieldsMissing += "Telefon; ";
                    
        }         
        
        else if (isPhone($("#tel").val()) == false) {
                    
        errorMessage += "<span>Eroare locala! Telefonul introdus este invalid</span><br>";
                    
        }
        //////////////////////////////////////////////////////////////////////////////////
        if (fieldsMissing != "") {
                    
        errorMessage += "<span style='color:OrangeRed'>Atentie! Urmatoarele campuri nu sunt completate: " + fieldsMissing + "</span>";
                    
        }        
        //////////////////////////////////////////////////////////////////////////////////
        if (errorMessage != "") {
                    
            $(".errorMessage").html(errorMessage);
                    
        } else {
                    
            $(".errorMessage").empty();
                    
        }        
        //////////////////////////////////////////////////////////////////////////////////
   });
});
</script>
</html>
