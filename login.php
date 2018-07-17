<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION['CNP'])){
    header ('Location: https://hospiweb.novacdan.ro/panel/profil/eu');
    } else
if (empty($_SESSION['key']))
    $_SESSION['key'] = bin2hex(random_bytes(32));
    require 'includes/csrf.php';

?>

<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HospiWeb | Login</title>
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
                    <h4 class="card-title">Introdu datele de logare mai jos</h4>
                </div>
                <div class="card-body">
                    <form action="/includes/login.inc.php" method="POST">
                       <div class="cnp-form" id="cnp-group"><label>Cod numeric personal</label><input class="form-control" type="text" name="CNP" required="" maxlength="13" minlength="13" inputmode="numeric"></div>
                        <div class="form-group" id="password-group"><label>Parola</label><input type="password" required class="form-control" name="password" rel="password" /></div>
                        <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                        <div class="form-actions"><button class="btn btn-success" name="login" type="submit" style="font-size:13px;">Autentificare</button></div>
                    </form>
                </div>
                <?php
                    if (isset($_GET['eroare']) && $_GET['eroare'] == '1'){
                       echo '<div class="card-footer"><span id="spanError">Eroare: CNP-ul sau parola introdusa nu exista in baza de date!</span></div>';
                   } else if (isset($_GET['eroare']) && $_GET['eroare'] == '2'){
                       echo '<div class="card-footer"><span id="spanError">Eroare: A intervenit o eroare, asigura-te ca ai introdus datele corect!</span></div>';
                   } else if (isset($_GET['actiune']) && $_GET['actiune']=='succes'){
                        echo'<div class="card-footer"><span id="spanSuccess">Succes: Contul a fost creat, acum te pot autentifica!</span></div>';
                   } else {
                       echo '<div class="card-footer">
                    <p class="text-center mb-0 small">Mi-am uitat parola. <a href="/challenge">Trimite-mi un email de resetare!</a></p>
                    </div>';
                   }
                    ?>
            </div>
        </div>
    </section>
<?php include"includes/footer.php";?>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-better-nav.js"></script>
</body>

</html>