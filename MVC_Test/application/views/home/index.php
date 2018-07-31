<!DOCTYPE html>
<?php session_start(); ?>
<html>
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="profile" href="https://gmpg.org/xfn/11">
      <meta name="description" content="Hospiweb este o platformă online ce îți permite să iei legătura cu medicul tău oricând și oriunde, fie de la tine de acasă, fie de la muncă, parc sau din vacanță!"/>
      <link rel="canonical" href="<?php echo URL; ?>"/>
      <meta property="og:locale" content="ro_RO"/>
      <meta property="og:locale:alternate" content="en_US"/>
      <meta property="og:type" content="website"/>
      <meta property="og:title" content="Platforma Medicala Online Romania - Hospiweb"/>
      <meta property="og:description" content="Hospiweb este o platformă online ce îți permite să iei legătura cu medicul tău oricând și oriunde, fie de la tine de acasă, fie de la muncă, parc sau din vacanță!"/>
      <meta property="og:url" content="<?php echo URL; ?>"/>
      <meta property="og:site_name" content="Hospiweb"/>
      <title>Hospiweb | Home</title>
      <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
      <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
      <link rel="stylesheet" href="assets/css/styles.css">
      <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon" />
   </head>
   <body>
      <section class="intro">
         <div class="container containercustom">
            <div class="row">
               <div class="col">
                  <h2>Dorești o consultație online?</h2>
                  <button class="btn btn-info" type="button" onclick="location.href = '/panel/profil';">Începe acum!</button>
               </div>
            </div>
         </div>
      </section>
      <nav class="navbar navbar-dark navbar-expand-md bg-info sticky logo">
         <div class="container">
            <a class="navbar-brand" href="<?php echo URL; ?>">&nbsp; &nbsp; &nbsp; &nbsp; HospiWeb</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
               <ul class="nav navbar-nav ml-auto">
                  <li class="nav-item" role="presentation"><a class="nav-link active special scroll-link" href="#howitworks">Cum funcționează?</a></li>
               </ul>
               <?php if(!isset($_SESSION['CNP'])): ?>
                  <ul class="nav navbar-nav ml-auto">
                      <li class="nav-item" role="presentation"><a class="nav-link active" href="https://hospiweb.novacdan.ro/login">Autentificare</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link active" href="<?php echo URL; ?>register">Înregistrare</a></li>
                  </ul> 
                <?php else: ?>
                      <ul class="profile-nav ml-auto">
                      <div class="dropdown profile">
                          <a class="dropdown-toggle" id="dropdownMenuLink" role="button" aria-expanded="true" aria-haspopup="true" href="#" data-toggle="dropdown">
                          <img alt="profile-avatar" src="<?php echo $photo_header; ?>">
                          <span id="name"><?php echo $name_header; ?></span>
                          </a>
                      <div class="dropdown-menu dropdown-menu-right snow" aria-labelledby="dropdownMenuLink">
                          <a class="dropdown-item" href="https://hospiweb.novacdan.ro/panel/profil/eu">
                              <i class="fa fa-user">&nbsp;
                              </i>
                              <span>Profilul meu</span>
                          </a>
                          <a class="dropdown-item" href="https://hospiweb.novacdan.ro/panel/pacienti">
                              <i class="fa fa-users">&nbsp;
                              </i>
                              <span>Pacienti</span>
                          </a> 
                          <a class="dropdown-item" href="https://hospiweb.novacdan.ro/panel/doctori">
                              <i class="fa fa-user-md">&nbsp;
                              </i>
                              <span>Doctori</span>
                          </a>
                          <a class="dropdown-item" href="https://hospiweb.novacdan.ro/panel/ticket/list">
                              <i class="fa fa-ticket">&nbsp;
                              </i>
                              <span>Tichete</span>
                          </a>                      
                          <a class="dropdown-item" style="color:red" href="https://hospiweb.novacdan.ro/panel/transplanturi">
                              <i class="fa fa-heart">&nbsp;
                              </i>
                              <span>Transplanturi</span>
                          </a>  
                          <div class="dropdown-divider"></div>
                          <form action="https://hospiweb.novacdan.ro/includes/logout.inc.php" method="POST">
                          <button class="btn dropdown-item" type="submit" name="logout"><i class="fa fa-unlock">&nbsp;</i>Deloghează-te</button>
                          </form>
                      </div>
                  </div>
                </ul>
                <?php endif ?>
            </div>
         </div>
      </nav>
      <section class="features-1 dark-knight">
         <div class="container-half container-half-left"></div>
         <div class="container-half container-half-right img-1"></div>
         <div class="container">
            <div class="row section-separator">
               <div class="col col-md-6">
                  <div class="inner">
                     <h2 class="section-heading-night">Întreține-ți sănătatea de acasă</h2>
                     <div class="detail-night">
                        <p>De azi înainte vei uita de vizitele plictisitoare și obositoare la cabinetul medical.&nbsp;</p>
                        <p>Hospiweb este o platformă online ce îți permite să iei legătura cu medicul tău oricând și oriunde, fie de la tine de acasă, fie de la muncă, parc sau din vacanță!</p>
                     </div>
                  </div>
                  <div class="mobile-photo mt-3 d-md-none"></div>
               </div>
            </div>
         </div>
      </section>
      <section class="features-1 second-banner">
         <div class="container-half-2 container-half-left img-2"></div>
         <div class="container-half container-half-right"></div>
         <div class="container">
            <div class="row section3-separator">
               <div class="col-md-6">
                  <div></div>
               </div>
               <div class="col-md-6">
                  <h2 class="section2-heading-night">Despre noi</h2>
                  <div class="detail-second">
                     <p>Dan și Radu (creatorii acestei platforme) sunt doi prieteni din orașul Galați pasionați de informatică și de orice înseamnă programare!</p>
                     <p>Proiectul Hospiweb a luat naștere pe 26 Aprilie 2018 datorită concursului Info-Educație unde lui Dan și lui Radu le-a venit ideea să revoluționeze medicina în România cu ajutorul soluției viitorului: Internetul :)</p>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <section id="howitworks" class="features-2">
         <div class="container section3-separator">
            <div class="section-header col-md-6">
               <h2 class="text-center section-heading">Cum funcționează?</h2>
               <p class="text-center sub-heading">Doctorul dumneavoastră va avea posibilitatea să vă urmărească starea de sănătate în timp real!<br /></p>
            </div>
            <div class="row features">
               <div class="col-sm-6 col-lg-4">
                  <i class="icon-heart icon text-center" style="color:#17a2b8;"></i>
                  <h3 class="title text-center">Ești consultat!</h3>
                  <p class="description text-center">Un doctor acreditat te va consulta online și îți va prescrie cel mai avantajos tratament, apoi îți va elibera rețeta virtuala!</p>
               </div>
               <div class="col-sm-6 col-lg-4">
                  <i class="icon-globe icon text-center" style="color:#17a2b8;"></i>
                  <h3 class="title text-center">Oriunde ai fi!</h3>
                  <p class="description text-center">De acum îți poți întreține sănătatea folosind doar un dispozitiv conectat la internet și un cont pe platforma noastră.</p>
               </div>
               <div class="col-sm-6 col-lg-4">
                  <i class="icon-graph icon text-center" style="color:#17a2b8;"></i>
                  <h3 class="title text-center">Statistici în timp real!</h3>
                  <p class="description text-center">Atât tu cât și doctorul tău veți dispune de statistici pentru a ușura determinarea stării tale de sănătate!</p>
               </div>
               <div class="col-sm-6 col-lg-4">
                  <i class="icon-calendar icon text-center" style="color:#17a2b8;"></i>
                  <h3 class="title text-center">EȘTI PROGRAMAT!</h3>
                  <p class="description text-center">Nu trebuie să-ți mai faci griji că uiți când ai programare la medic. Un membru din echipa noastră te va înștiința cu o zi înainte!</p>
               </div>
               <div class="col-sm-6 col-lg-4">
                  <i class="icon-phone icon text-center" style="color:#17a2b8;"></i>
                  <h3 class="title text-center">asistență live 24/7</h3>
                  <p class="description text-center">Pentru orice nelămurire poți suna la numărul afișat în tabul &#39;Contact&#39; iar un membru al echipei noastre te va ajuta cu orice informație ai nevoie!</p>
               </div>
               <div class="col-sm-6 col-lg-4">
                  <i class="icon-support icon text-center" style="color:#17a2b8;"></i>
                  <h3 class="title text-center">TRANSPLANTURI RAPIDE!</h3>
                  <p class="description text-center">Vei fi pus imediat ce doctorul tău consideră că este necesar pe o listă de așteptare rapidă ce va fi trimisă la toate spitalele din țara ta!</p>
               </div>
            </div>
         </div>
      </section>
      <footer>
         <div class="container">
            <div class="row">
               <div class="col-12">
                  <div class="footer-card bg-white rounded text-center">
                     <h2>începe noua eră a medicinei</h2>
                     <button class="btn btn-danger" type="button" onclick="location.href = '/panel/profil/eu';">Începe acum!</button>
                  </div>
               </div>
               <div class="col-12 text-center u-py-60">
                  <div class="footer-social">
                     <img class="img-fluid" src="assets/img/logominifooter.svg">
                     <ul class="list-inline social mt-4">
                        <li class="list-inline-item list-inline-item"><a href="https://facebook.ro"><i class="fa fa-facebook"></i></a></li>
                        <li class="list-inline-item list-inline-item"><a href="https://facebook.ro"><i class="fa fa-instagram"></i></a></li>
                        <li class="list-inline-item list-inline-item"><a href="https://facebook.ro"><i class="fa fa-youtube-play"></i></a></li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="row align-items-center no-gutters text-white" style="font-size:14px">
               <div class="col-md-4 col-lg-4 order-bottom text-center text-lg-left text-md-left"><span class="py-3 d-block">© 2018 Hospiweb toate drepturile rezervate</span></div>
               <div class="col-md-8 col-lg-8 order-top">
                  <ul class="list-inline footer-nav text-center text-lg-right">
                     <li class="list-inline-item"><a href="/regulament/termeni-si-conditii" class="p-2">Termeni și condiții</a><a href="/regulament/politica-de-securitate" class="p-2">Politica de confidențialitate</a></li>
                  </ul>
               </div>
            </div>
         </div>
      </footer>
      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/bootstrap/js/bootstrap.min.js"></script>
      <script src="assets/js/bootstrap-better-nav.js"></script>
      <script>
         $(document).ready(function(){
           $(".scroll-link").on('click', function(event) {
             if (this.hash !== "") {
               event.preventDefault();
               var hash = this.hash;
               $('html, body').animate({
                 scrollTop: $(hash).offset().top
               }, 800, function(){
         
                 window.location.hash = hash;
               });
             } 
           });
         });
      </script>
   </body>
</html>