 # Hospiweb

Hospiweb este o platformă online ce îți permite să iei legătura cu medicul tău oricând și oriunde, fie de la tine de acasă, fie de la muncă, parc sau din vacanță!

### Cum funcționează?

Platforma Hospiweb beneficiază de un sistem avansat de înregistrare a contului, datele personale fiind extrase chiar din CNP-ul utilizatorului fără a fi necesară introducerea inițială a acestora (datele putând fi ulterior actualizate de către utilizatori). Odată ce utilizatorul a făcut primul contact cu platforma un tutorial și niște tooltips-uri explicative îi sar în ajutor pentru a îi face o experiență cât mai plăcută! Utilizatorii sunt împărțiți în "Medici" și "Pacienți" fiecare putând avea adițional funcția de "Moderator" ce oferă câteva permisiuni în plus posesorului...
     
### Tehnologii 

* HTML 5
* CSS 3
* Bootstrap 4
* JavaScript (jQuery)
* PHP 7
* MySQL

Pentru realizarea tuturor elementelor artistice prezente pe platformă (desene, ilustrații) s-a folosit Adobe Illustrator CC & Adobe Photoshop CC

```
*Nicio resursă (înafară de fonturi) nu a fost preluată din surse externe.
```

## Creatori

* **Novac Dan Andrei** - *Full Stack Developer* 
* **Vrînceanu Radu Tudor** - *Database Engineer* 

#### Contributii - Novac Dan Andrei
* Realizarea tuturor desenelor, ilustrațiilor și designe-ul platformei (Realizarea tuturor fișierelor CSS).
* Realizarea structurii site-ului astfel încât să fie vizibil pe orice device (Bootstrap).
* Realizarea sistemului de înregistrare cont împreună cu toate sistemele ce se regăsesc în acesta din care menționăm în mod special: Validator CNP, Extragere date personale automat din CNP, Avertizare în timp real a greșelilor de redactare (folosind jQuery)
* Realizarea sistemului de autentificare ce vine însoțit de protecție împotriva CSRF, și Anti-Brute Force (reCaptcha v2)
* Realizarea paginii MyProfile (eu.php) împreună cu majoritatea funcțiilor din care menționăm în mod special: Sistemul de schimbare a pozei de profil, sistemul de modificare a parolei curente, sistemul de introducere simptome, sistemul de introducere informații adiționale.
* Implementarea pe mai multe pagini de pe platformă a unor îndrumări sub formă de Spoiler sau Tooltipsuri cu rol de a ajuta utilizatorul.
* Realizarea paginii unde se pot vizualiza toți pacienții de pe platformă (pacienti.php) însoțit de un sistem de sortare după nume.
* Realizarea paginii unde se pot vizualiza toți doctorii de pe platforma (doctori.php) însoțit de un sistem de sortare după nume sau număr de telefon. Pacienții vor avea posibilitatea de a acorda permisiunea medicilor de a le vedea datele personale.
* Realizarea paginii unde se pot vizualiza toți pacienții de pe platformă ce au nevoie de un transplant (transplanturi.php) însoțit de un sistem de sortare după nume sau grupă sanguină.
* Realizarea Main Page-ului (index.php).
* Realizarea sistemului de tichete împărțit în 3 fișiere .php (list, view, create) împreună cu majoritatea funcțiilor cu care vine însoțit din care amintim: Sistemul de vizualizare a tichetelor în funcție de statutul utilizatorului (doctorii vor vedea toate tichetele disponibile împreună cu o mică statistică vizibilă deasupra listei, iar pacienții vor vedea doar tichetele deschise de ei cu opțiunea de a creea un nou tichet), sistemul de creare a tichetelor ce poate fi utilizat doar de pacienți, sistemul de vizualizare a tichetelor ce poate fi folosind atât de pacienți cât și de doctori (acesta vine însoțit cu un sistem de comentarii și două opțiuni: Închide Tichet-ul și Șterge Tichetul, cea din urmă putând fi folosită doar de doctori).
* Realizarea sistemului User Profile (utilizator.php) ce permite vizualizarea altor profiluri decât cel a utilizatorului. Sistemul User Profile este împărțit în patru grade de permisiuni
1. Primul este dacă utilizatorul este pacient și vizualizează profilul unui medic, în acest caz va putea vizualiza informațiile adiționale introduse de medic cât și telefon și adresa sa de mail.
2. Al doilea este dacă utilizatorul este pacient și vizualizează profilul unui pacient, în acest caz acesta nu va putea vizualiza datele sensibile ale pacientului (ex. Mail, CNP, Telefon, Afecțiuni, Informații adiționale)
3. Al treilea este dacă utilizatorul este medic și vizualizează profilul unui pacient ce nu îi aparține, în acest caz acesta va avea toate permisiunile, mai puțin vizualizarea CNP-ului, numărului de telefon și adresei de mail.
4. Al patrulea este dacă utilizatorul este medic și vizualizează profilul unui pacient ce îi aparține, în acest caz acesta va avea toate permisiunile, inclusiv cele de vizualizare.
5. Cazul suplimentar este acela dacă utilizatorul este Moderator. În aces caz indiferent de ce statut are, va putea vizualiza orice fel de date personale, iar în plus va avea opțiunea de a promova un pacient în statutul de doctor.

#### Contributii colective (Novac Dan Andrei & Vrînceanu Radu Tudor)
* Sistem de ștergere a unui cont de către un doctor atunci când acesta se află pe profilul unui utilizator (Vrînceanu Radu - Sistem inițial & Novac Dan - Rescriere pentru adaptarea la noile sisteme și evitarea vulnerabilităților).
* Sistem de introducere de tratamente, consultații, punere pe lista de așteptare a unui pacient de către un doctor (Vrînceanu Radu - Sistem inițial & Novac Dan - Rescriere pentru adaptarea la noile sisteme și evitarea vulnerabilităților). 
* Relaționarea tabelelor în baza de date.
* Sistemul de parolă pierdută sau uitată (Vrînceanu Radu - Sistem inițial & Novac Dan - Rescriere pentru adaptarea la noile sisteme și evitarea vulnerabilităților).
* Sistemul de validare mail (Vrînceanu Radu - Sistem inițial & Novac Dan - Adăugarea unor protecții suplimentare și mesaje de atenționare)

#### Contributii - Vrînceanu Radu Tudor
* Sistemul de introducere a statisticilor de către pacienți (Puls, Sistola, Diastola) folosind Chart.js.
* Proceduri și evenimente în baza de date.

## License

Acest proiect este licențiat de GPL 3.0 - verifică [LICENSE](LICENSE) pentru detalii!
