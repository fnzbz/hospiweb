<!DOCTYPE html>
<html>
    <?php session_start(); ?>
    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HospiWeb | Politica de securitate</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="assets/css/bootstrap-better-nav.css">
    <link rel="stylesheet" href="assets/css/Features-Clean.css">
    <link rel="stylesheet" href="assets/css/Social-Icons.css">
    <link rel="stylesheet" href="assets/css/styles.css">
        <link rel="stylesheet" href="../../assets/fonts/font-awesome.min.css">
</head>

<body>
    <nav class="navbar navbar-dark navbar-expand-md bg-info sticky logo">
        <div class="container"><a class="navbar-brand" href="https://hospiweb.novacdan.ro/">&nbsp; &nbsp; &nbsp; &nbsp; HospiWeb</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
                class="collapse navbar-collapse" id="navcol-1">
                <?php if (!isset($_SESSION['CNP'])){ echo'
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="https://hospiweb.novacdan.ro/login">Autentificare</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="https://hospiweb.novacdan.ro/register">Înregistrare</a></li>
                </ul>';} else {
                        require_once '../includes/db.php';
        
                        $idHeader = $_SESSION['id'];
                        $queryHEADER = "SELECT * FROM utilizatori WHERE id = '$idHeader'";
                        
                        $resultHEADER = $connection->query($queryHEADER);
                        $rows_fetchHEADER = $resultHEADER->fetch_assoc();
                        
                        $sexHeader = $rows_fetchHEADER['sex'];
                        $isMedicHeader = $rows_fetchHEADER['isMedic'];
                        $utilizatorHeader = $rows_fetchHEADER['utilizator'];

                    echo'<ul class="profile-nav ml-auto">
                    <div class="dropdown profile">
                        <a class="dropdown-toggle" id="dropdownMenuLink" role="button" aria-expanded="true" aria-haspopup="true" href="#" data-toggle="dropdown">';
                        if ($sexHeader == '1' && $isMedicHeader != '0') { echo'
                        <img alt="profile-avatar" src="https://hospiweb.novacdan.ro/assets/img/mini-man-doctor.png">
                        <span> Dr. &nbsp;' .$utilizatorHeader; echo'</span>';}
                        else if ($sexHeader == '2' && $isMedicHeader != '0') { echo'
                        <img alt="profile-avatar" src="https://hospiweb.novacdan.ro/assets/img/mini-women-doctor.png">
                        <span> Dr. &nbsp;' .$utilizatorHeader; echo'</span>';} 
                        else if ($sexHeader == '1' && $isMedicHeader == '0') { echo'
                        <img alt="profile-avatar" src="https://hospiweb.novacdan.ro/assets/img/mini-man.png">
                        <span>'.$utilizatorHeader; echo'</span>';}                        
                        else if ($sexHeader == '2' && $isMedicHeader == '0') { echo'
                        <img alt="profile-avatar" src="https://hospiweb.novacdan.ro/assets/img/mini-women.png">
                        <span>' .$utilizatorHeader; echo'</span>';}
                        else { echo'
                        <img alt="profile-avatar" src="https://hospiweb.novacdan.ro/assets/img/mini-unisex.png">
                        <span>' .$utilizatorHeader; echo'</span>';}
                         echo '
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
                   </ul>';} ?>
        </div>
        </div>
    </nav>
    <section>
        <div class="container margine">
            <div class="card">
                <div class="card-body">
<h2 class="text-uppercase">Politica de securitate</h2>
<hr>
<h4>1. Prevederi generale</h4>
<p>Accesând platforma Hospiweb toți utilizatorii sunt de acord să respecte termenii de utilizare și legislația în vigoare. Politica prezentată în continuare vă explică ce fel de date pot fi colectate de Hospiweb, cum sunt acestea protejate și utilizate și cum pot fi dezvăluite. Totodată, are ca scop stabilirea unor norme de conduită pentru asigurarea unui nivel satisfăcător de protecție a datelor cu caracter personal prelucrate de către Hospiweb și se aplică colectării, folosirii, dezvăluirii și protejării informațiilor personale pe care decideți să ni le furnizați.</p>
<h4>2. Prelucrarea datelor cu caracter personal</h4>
<p>În paginile noastre de internet, Hospiweb nu va colecta niciun fel de date personale în legătură cu dvs. (de ex. numele dvs., adresa, numărul de telefon sau adresa de e-mail), dacă nu doriți să ni le furnizați (de ex. prin înregistrare, chestionare), sau dacă nu vă dați acordul sau dacă nu este altfel permis prin lege sau alte reglementări de protecție a datelor dvs. personale.</p>
<p>Conform cerințelor Legii nr. 677/2001 pentru protecția persoanelor cu privire la prelucrarea datelor cu caracter personal și libera circulație a acestor date, modificată și completată și ale Legii nr. 506/2004 privind prelucrarea datelor cu caracter personal și protecția vieții private în sectorul comunicațiilor electronice, Hospiweb are obligația de a administra în condiții de siguranță și numai pentru scopurile specificate datele personale pe care ni le furnizați despre dumneavoastră.</p>
<p>Conform Legii nr. 677/2001, beneficiați de dreptul de acces, de intervenție asupra datelor, dreptul de a nu fi supus unei decizii individuale și dreptul de a vă adresa justiției. Totodată, aveți dreptul să vă opuneți prelucrării datelor personale care vă privesc și să solicitați ștergerea datelor*. Pentru exercitarea acestor drepturi, vă puteți adresa cu o cerere scrisă, datată și semnată spre Hospiweb.</p>
<p>Observații:</p>
<p>*orice persoană are dreptul de a se opune, pentru motive legitime, la prelucrarea datelor ce o privesc. Acest drept de opoziție poate fi exclus pentru anumite prelucrări prevazute de lege (de ex.: prelucrări efectuate de serviciile financiare și fiscale, de poliție, justiție, securitate socială etc). Prin urmare, această mențiune nu poate figura dacă prelucrarea are un caracter obligatoriu;</p>
<h4>3. În ce scop utilizăm informațiile pe care le colectăm</h4>
<p>În cazul în care ne veți furniza datele dvs. personale, le vom utiliza în general pentru a răspunde solicitărilor dvs., pentru a vă intermedia accesul la informații specifice, oferte sau servicii și pentru a efectua verificări, cercetări și analize pentru a menține, proteja și dezvolta produsele sau serviciile pe care le oferim.</p>
<p>Pentru a vă ține la curent și a vă oferi o experiență cât mai completă pe platforma noastră Hospiweb, vom putea trimite știri, sfaturi privind abordarea unor probleme sau care să vă ajute să utilizați serviciile oferite de noi și alte notificări privind conținutul, ofertele de servicii, promoțiile și alte evenimente, din partea noastră, afiliaților și partenerilor noștri, prin intermediul e-mailului dvs. Prin aceasta vă exprimați acordul în acest sens și luați la cunoștință faptul că puteți avea obiecții și vă puteți revoca acordul oricând bifând opțiunile corespunzătoare de pe pagina profilului dvs. de utilizator.</p>
<p>Ne permitem de asemenea să monitorizăm modul în care folosiți serviciile pe care le oferim și să vă contactăm personal pentru a vă oferi sfaturi care să vă fie de ajutor în parcurgerea conținutului și în rezolvarea problemelor de pe platforma Hospiweb.</p>
<p>Hospiweb PB SRL va colecta, utiliza sau dezvălui datele personale furnizate de dvs. numai pentru scopurile indicate și conform acestei politici, cu excepția cazului în care comunicarea datelor: se referă la utilizarea datelor personale pentru orice scop adițional care se referă direct la scopul original pentru care datele personale au fost colectate și este necesară pentru a pregăti, negocia sau derula un contract pentru dvs., este solicitată prin lege sau de autoritățile guvernamentale sau juridice competente, este necesară pentru a stabili sau pentru a apăra un drept legal, este necesară pentru a preveni frauda sau alte activități ilegale, precum și împotriva atacurilor intenționate asupra sistemelor Hospiweb PB SRL de tehnologie a informației.</p>
<p>Revizuim practicile noastre de colectare, stocare și procesare de date pentru a ne asigura că procesăm, colectăm și stocăm numai acele date necesare pentru furnizarea sau îmbunătățirea serviciilor și activităților noastre. Luăm măsurile necesare în măsura posibilităților, pentru a ne asigura că datele personale pe care le procesăm sunt corecte, complete și actuale, dar depindem de dumneavoastră pentru a ne furniza date actualizate sau pentru a corecta datele personale acolo unde este necesar.</p>
<h4>4. Date de comunicare sau utilizare</h4>
<p>Prin utilizarea serviciilor de telecomunicații pentru a accesa pagina noastră de internet, datele dvs. de comunicare (de ex. adresa Internet protocol address) sau datele de utilizare (de ex. Informațiile de la început, de la sfârșit și extinderea fiecărui acces, precum și informațiile pentru serviciile de telecomunicații pe care le-ați accesat) sunt generate tehnic și se pot relaționa inteligibil la datele personale. În măsura în care există vreo necesitate de compilare, vor fi efectuate colectarea, procesarea și utilizarea datelor dvs. de comunicare sau de utilizare în conformitate cu cadrul legal aplicabil referitor la protecția datelor personale.</p>
<h4>5. Date non-personale colectate automat</h4>
<p>Când accesaţi paginile noastre de internet, putem colecta automat (nu prin înregistrare) date non-personale (de ex. Tipul de browser internet și sistemul de operare utilizat, numele domeniului paginii Web de pe care ați venit, numărul de vizite, durata medie petrecută pe site, paginile vizionate). Noi putem utiliza aceste date pentru a monitoriza gradul de atracție a paginilor noastre de internet și pentru a le îmbunătăți performanța sau conținutul.</p>
<h4>6. "Cookies" – Informații stocate automat în calculatorul dvs.</h4>
<p>Atunci când vizionați una din paginile noastre de internet, noi putem stoca unele date pe calculatorul dvs. sub forma unui "cookie" pentru a recunoaște automat calculatorul dvs. la următoarea vizită. Aceste Cookies ne pot fi de ajutor în multe feluri, de exemplu ele sunt necesare pentru a vă putea înregistra pe platformă. Dacă totuși nu doriți să primiți cookies, vă rugăm să configurați browser-ul de internet astfel încât să ștergeți tot ce înseamnă cookies de pe unitatea centrală a calculatorului, să le blocați sau să primiți un avertisment înainte ca ele să fie salvate.</p>
<h4>7. Securitate</h4>
<p>Pentru a proteja datele dvs. personale de distrugere accidentală sau ilegală, de pierdere sau alterare și de accesul unor persoane neautorizate, Hospiweb utilizează măsuri de securitate tehnice și organizatorice.</p>
<h4>8. Linkuri către alte pagini web</h4>
<p>Paginile web ale Hospiweb pot conține linkuri către alte pagini web. Hospiweb nu răspunde pentru practicile de securitate sau de conținutul altor pagini web.</p>
<h4>9. Întrebări și comentarii</h4>
<p>Hospiweb va răspunde la toate solicitările rezonabile pentru a revedea și datele dvs. personale, pentru a corecta, modifica sau șterge orice neregularități. Dacă aveți orice fel de întrebări sau comentarii în legătură cu Politica de securitate a datelor personale de la Hospiweb (de ex. revederea sau actualizarea datelor dvs. personale), vă rugăm să dați clic pe "Contact " în colțul din dreapta jos al acestei ferestre. Pe acea pagină veți găsi modalitățile prin care ne puteți contacta. Pe măsură ce internetul va avansa, va avansa și Politica noastră de securitate a datelor. Noi vom publica pe această pagină modificările la politica noastră de protecție a datelor personale. Vă rugăm să verificați în mod regulat această pagină pentru a fi la curent.</p>
		</div>
		    </div></div>
    </section>
<?php include"../includes/footer.php";?>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-better-nav.js"></script>
</body>

</html>