<?php
    
    session_start();

    if(isset($_SESSION['CNP'])):
        header ('Location:  '. URL .'panel/profil');
    endif
?>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HospiWeb | Inregistrare</title>
    <link rel="stylesheet" href="<?php echo URL; ?>assets/panel_public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="<?php echo URL; ?>assets/panel_public/css/bootstrap-better-nav.css">
    <link rel="stylesheet" href="<?php echo URL; ?>assets/panel_public/css/styles.css">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <meta charset="utf-8">
</head>

<body>
    <nav class="navbar navbar-dark navbar-expand-md bg-info logo">
        <div class="container"><a class="navbar-brand" href="<?php echo URL; ?>">&nbsp; &nbsp; &nbsp; &nbsp; HospiWeb</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
                class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="<?php echo URL; ?>login">Autentificare</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="<?php echo URL; ?>register">Inregistrare</a></li>
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
                    <form action="<?php echo URL; ?>register/signup" method="POST">
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
                     <?php if($errorPage == 1): ?>
                       <div class="card-footer submitMessage"><div class="errorMessage"></div><hr><span>Eroare de submisie! CNP-ul introdus exista deja in baza de date!</span></div>
                    <?php elseif ($errorPage == 2): ?>
                       <div class="card-footer submitMessage"><div class="errorMessage"></div><hr><span>Eroare de submisie! Parolele introduse nu coincid!</span></div>
                    <?php elseif ($errorPage == 3): ?>
                       <div class="card-footer submitMessage"><div class="errorMessage"></div><hr><span>Eroare de submisie! Trebuie sa fii de acord cu termenii si conditile!</span></div>
                    <?php elseif ($errorPage == 4): ?>
                       <div class="card-footer submitMessage"><div class="errorMessage"></div><hr><span>Eroare de submisie! Adresa de mail este invalida!</span></div>
                    <?php elseif ($errorPage == 5): ?>
                       <div class="card-footer submitMessage"><div class="errorMessage"></div><hr><span>Eroare de submisie! CNP-ul introdus nu este valid!</span></div>
                    <?php elseif ($errorPage == 6): ?>
                       <div class="card-footer submitMessage"><div class="errorMessage"></div><hr><span>Eroare de submisie! Numele introdus este invalid!</span></div>
                    <?php elseif ($errorPage == 7): ?>
                       <div class="card-footer submitMessage"><div class="errorMessage"></div><hr><span>Eroare de submisie! Numarul de telefon introdus este invalid!</span></div>
                    <?php elseif ($errorPage == 8): ?>
                       <div class="card-footer submitMessage"><div class="errorMessage"></div><hr><span>Eroare de submisie! Parola introdusa nu inteplineste toate criteriile!</span></div>
                    <?php else: ?>
                        <div class="card-footer submitMessage"><span class="text-center mb-0" style="color:#575962">Ai deja un cont? Atunci autentifică-te <a href="/login">aici</a>!</span><div class="errorMessage"></div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </section>
    <script src="<?php echo URL; ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo URL; ?>assets/js/functions.js"></script>
    <script src="<?php echo URL; ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo URL; ?>assets/js/bootstrap-better-nav.js"></script>
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