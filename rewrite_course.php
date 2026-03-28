<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Lesson;

$lessons = [];

// ============================================================
// LESSON 27 — "Šta je programiranje?" (subchapter 1.1)
// ============================================================
$lessons[27] = <<<'HTML'
<h1>Šta je programiranje?</h1>

<p><strong>Posle ove lekcije, moći ćeš da naterаš kompjuter da kaže bilo šta što požеliš!</strong> Zvuči moćno? Zato što jeste. Hajde da počnemo!</p>

<h2>🤖 Zamisli da imaš robota...</h2>

<p>Zamisli da ti neko pokloni robota. Ovaj robot je neverovatno poslušan — radi <strong>apsolutno SVE</strong> što mu kažeš. Ali postoji jedna caka: on je malo... bukvalan.</p>

<p>Ne možeš mu reći: "Hej robote, napravi mi sendvič." On ne zna šta je sendvič! Moraš mu objasniti korak po korak:</p>

<ol>
<li>Otvori kesu hleba</li>
<li>Izvadi dva parčeta</li>
<li>Stavi ih na sto</li>
<li>Otvori frižider</li>
<li>Uzmi šunku</li>
<li>Stavi šunku na jedno parče hleba</li>
<li>Stavi drugo parče hleba na vrh</li>
</ol>

<p>Ako preskočiš korak, robot će se zbuniti. Ako kažeš korake pogrešnim redom — dobijaš šunku na stolu i hleb u frižideru! 😄</p>

<p><strong>Programiranje je upravo to</strong> — pisanje preciznih uputstava (komandi) koje kompjuter izvršava korak po korak. Ti si šef, a kompjuter je tvoj poslušni robot.</p>

<h2>Zašto baš Python?</h2>

<p>Postoji mnogo programskih jezika na svetu — stotine! Mi ćemo učiti <strong>Python</strong> jer:</p>

<ul>
<li><strong>Najlakši je za početnike</strong> — čita se skoro kao engleski</li>
<li><strong>Koriste ga profesionalci</strong> — Google, Instagram, Netflix, NASA, pa čak i doktori i naučnici</li>
<li><strong>Može mnogo toga</strong> — igrice, aplikacije, veštačka inteligencija</li>
<li><strong>Brzo se uči</strong> — za samo par lekcija ćeš praviti prave programe!</li>
</ul>

<h2>Tvoja prva komanda: print()</h2>

<p>Hajde odmah da krenemo! U Python-u postoji komanda koja kaže kompjuteru: <strong>"Ispiši ovo na ekranu."</strong> Ta komanda se zove <code>print()</code>.</p>

<p>Zamisli da je <code>print()</code> kao megafon — šta god staviš u njega, kompjuter će to "izgovoriti" (ispisati na ekranu).</p>

<p>Klikni <strong>Run</strong> da pokreneš svoj prvi program:</p>

<div data-code-exercise="" startercode="print('Zdravo, svete!')" instructions="Klikni Run dugme. Ovo je tvoj prvi program ikada! Pogledaj šta se pojavi ispod."></div>

<p>Bravo! Upravo si pokrenuo svoj prvi program! 🎉 Hajde da razumemo šta se desilo:</p>

<ul>
<li><code>print</code> — ime komande (znači "ispiši")</li>
<li><code>(</code> i <code>)</code> — zagrade u koje stavljamo ono što želimo da ispišemo</li>
<li><code>'Zdravo, svete!'</code> — tekst koji smo hteli da se pojavi na ekranu</li>
</ul>

<h2>Zašto su nam potrebni navodnici?</h2>

<p>Primeti da smo tekst stavili između navodnika: <code>'Zdravo, svete!'</code></p>

<p>Zašto? Zato što kompjuter mora da zna razliku između <strong>komandi</strong> (koje on izvršava) i <strong>teksta</strong> (koji samo treba da ispiše). Navodnici su kao signal: "Ovo je tekst, nemoj da ga izvršavaš, samo ga prikaži!"</p>

<p>Možeš koristiti ili jednostruke navodnike <code>'ovako'</code> ili dvostruke <code>"ovako"</code> — oba su ispravna.</p>

<div data-code-exercise="" startercode="print('Ovo je sa jednostrukim navodnicima')&#10;print(&quot;Ovo je sa dvostrukim navodnicima&quot;)" instructions="Pokreni program. Oba načina rade potpuno isto!"></div>

<h2>Više komandi u nizu</h2>

<p>Program može imati koliko god hoćeš komandi! Kompjuter ih čita <strong>odozgo nadole</strong>, kao što ti čitaš knjigu — red po red, od prvog do poslednjeg.</p>

<div data-code-exercise="" startercode="print('Zdravo!')&#10;print('Ja sam kompjuter.')&#10;print('Uradicu sve sto mi kazes.')" instructions="Pokreni program. Primeti kako kompjuter ispisuje red po red, odozgo nadole."></div>

<p>Vidiš? Tri komande, tri reda teksta na ekranu. Svaki <code>print()</code> ispisuje tekst i automatski prelazi u novi red.</p>

<h2>Prazan red</h2>

<p>Ako želiš prazan red između teksta (za lepši izgled), koristi <code>print()</code> bez ičega unutra:</p>

<div data-code-exercise="" startercode="print('Prva recenica.')&#10;print()&#10;print('Druga recenica posle praznog reda.')" instructions="Pokreni i pogledaj kako print() bez teksta pravi prazan red."></div>

<h2>Probaj sam! — Napiši svoje ime</h2>

<p>Sada je tvoj red! Promeni tekst u programu ispod tako da kompjuter ispiše <strong>tvoje ime</strong>:</p>

<div data-code-exercise="" startercode="print('ovde napisi svoje ime')" instructions="Obrisi tekst 'ovde napisi svoje ime' i umesto njega napisi svoje pravo ime. Ne zaboravi navodnike!"></div>

<h2>Probaj sam! — Mini priča</h2>

<p>Napravi program koji ispisuje 5 redova — kratku priču o sebi! Na primer, kako se zoveš, koliko imaš godina, šta voliš da radiš, koji ti je omiljeni predmet, šta želiš da budeš kad porasteš.</p>

<div data-code-exercise="" startercode="print('Ja sam ...')&#10;print('Imam ... godina.')&#10;print('Volim da ...')&#10;print('Omiljeni predmet mi je ...')&#10;print('Kad porastem, zelim da budem ...')" instructions="Zameni ... sa svojim odgovorima. Svaki red treba da ima tvoje podatke!"></div>

<h2>Probaj sam! — Napravi crtež od slova</h2>

<p>Možeš koristiti <code>print()</code> i da napraviš "crteže" od slova! Probaj ovo:</p>

<div data-code-exercise="" startercode="print('  *  ')&#10;print(' *** ')&#10;print('*****')&#10;print(' *** ')&#10;print('  *  ')" instructions="Pokreni i pogledaj oblik! Pokusaj da promenis zvezdice u neko drugo slovo ili da napravis drugaciji oblik."></div>

<h2>Šta smo naučili? 📝</h2>

<ul>
<li><strong>Programiranje</strong> = pisanje preciznih uputstava za kompjuter, korak po korak</li>
<li><strong>Python</strong> = programski jezik koji ćemo koristiti, lak za učenje</li>
<li><strong>print()</strong> = komanda koja ispisuje tekst na ekranu</li>
<li>Tekst uvek stavljamo između <strong>navodnika</strong> (jednostrukih ili dvostrukih)</li>
<li>Kompjuter izvršava komande <strong>odozgo nadole</strong>, jednu po jednu</li>
<li><code>print()</code> bez teksta pravi <strong>prazan red</strong></li>
</ul>

<p>U sledećoj lekciji ćeš naučiti kako da napraviš svoje programe još lepšim i organizovanijim!</p>
HTML;


// ============================================================
// LESSON 28 — "Tvoj prvi pravi program" (subchapter 1.2)
// ============================================================
$lessons[28] = <<<'HTML'
<h1>Tvoj prvi pravi program</h1>

<p>Već znaš da koristiš <code>print()</code> da ispišeš tekst. Sada ćemo naučiti kako da tvoji programi izgledaju <strong>profesionalno</strong>, i otkrićemo zašto su greške zapravo tvoji <strong>najbolji prijatelji</strong>!</p>

<h2>Ukrašavanje ispisa</h2>

<p>Zamisli da praviš poster ili pozivnicu. Ne bi napisao/la samo tekst — dodao/la bi neke linije, okvire, ukrase. U Python-u možeš uraditi isto!</p>

<p>Postoji trik: ako pomnožiš tekst brojem, Python će ga ponoviti toliko puta:</p>

<div data-code-exercise="" startercode="print('=' * 30)&#10;print('   MOJ PRVI PROGRAM')&#10;print('=' * 30)" instructions="Pokreni i pogledaj kako izgleda! Znak = se ponavlja 30 puta. Probaj da promenis broj ili znak."></div>

<p>Trik je jednostavan: <code>'=' * 30</code> znači "ponovi znak = trideset puta". Možeš koristiti bilo koji znak: <code>'-'</code>, <code>'*'</code>, <code>'~'</code>, <code>'#'</code>...</p>

<div data-code-exercise="" startercode="print('-' * 30)&#10;print('*' * 30)&#10;print('~' * 30)&#10;print('#' * 30)" instructions="Pogledaj kako razliciti znaci izgledaju. Koji ti se najvise svidja?"></div>

<h2>Pravi program: Vizit karta</h2>

<p>Hajde da napravimo pravu vizit kartu — kao one što odrasli imaju, ali tvoju!</p>

<div data-code-exercise="" startercode="print('+' + '-' * 28 + '+')&#10;print('|  Ime: Marko Markovic       |')&#10;print('|  Skola: OŠ Vuk Karadzic    |')&#10;print('|  Razred: 6-1               |')&#10;print('|  Hobi: programiranje!      |')&#10;print('+' + '-' * 28 + '+')" instructions="Zameni podatke svojim imenom, skolom, razredom i hobijem. Probaj da okvir izgleda lepo!"></div>

<h2>GREŠKE — tvoj novi najbolji prijatelj!</h2>

<p>Sada dolazi <strong>najvažnija stvar</strong> u celom kursu. Ozbiljno!</p>

<p>Kad program ne radi, dobiješ poruku o grešci — crveni tekst koji izgleda zastrašujuće. Ali zapravo, ta poruka ti <strong>govori tačno gde je problem</strong>! To je kao da ti učiteljica zaokruži grešku u testu i napiše "pogledaj ovde".</p>

<p><strong>Čak i najbolji programeri na svetu prave greške svaki dan.</strong> Razlika između početnika i profesionalca nije u tome ko pravi manje grešaka — nego ko ih brže pronalazi i ispravlja!</p>

<h3>Greška #1: Zaboravljen navodnik</h3>

<div data-code-exercise="" startercode="print('Zdravo svete!)" instructions="Pokreni ovaj program. Namerno ima gresku! Pogledaj poruku o gresci — pokusaj da je razumes, pa ispravi program."></div>

<p>Vidiš grešku? Fali navodnik na kraju teksta. Python kaže <code>SyntaxError</code> — to znači "ne razumem šta si napisao/la". Dodaj <code>'</code> posle uzvičnika da popraviš!</p>

<h3>Greška #2: Zaboravljena zagrada</h3>

<div data-code-exercise="" startercode="print('Zdravo svete!'" instructions="Pokreni i pogledaj gresku. Sta fali? Ispravi je!"></div>

<p>Fali zatvorena zagrada <code>)</code> na kraju! Svaka otvorena zagrada mora da se zatvori.</p>

<h3>Greška #3: Veliko slovo (Print umesto print)</h3>

<div data-code-exercise="" startercode="Print('Zdravo svete!')" instructions="Pokreni i pogledaj gresku. Python razlikuje velika i mala slova!"></div>

<p>Python kaže <code>NameError</code> — ne poznaje komandu <code>Print</code> sa velikim P. Komanda je <code>print</code> sa <strong>malim p</strong>. Python uvek razlikuje velika i mala slova!</p>

<h3>Kako čitati poruke o greškama?</h3>

<p>Svaka poruka o grešci sadrži dve bitne stvari:</p>
<ol>
<li><strong>Broj reda</strong> — gde se greška desila (npr. <code>line 1</code>)</li>
<li><strong>Tip greške</strong> — šta je problem (<code>SyntaxError</code>, <code>NameError</code>...)</li>
</ol>

<p>Kad dobiješ grešku: ne paničiš! Pogledaš broj reda, pogledaš taj red, i tražiš šta fali ili šta je pogrešno napisano.</p>

<h2>Komentari — poruke samom sebi</h2>

<p>Ponekad želiš da ostaviš <strong>belešku</strong> u svom programu — podsetnik šta taj deo koda radi. Za to koristimo znak <code>#</code>.</p>

<p>Sve posle <code>#</code> u tom redu kompjuter <strong>potpuno ignoriše</strong>. To je kao da pišeš olovkom na margini sveske — ti to vidiš, ali učiteljica ne čita.</p>

<div data-code-exercise="" startercode="# Ovo je komentar, kompjuter ga ignorise&#10;print('Zdravo!')  # i ovo je komentar&#10;# print('Ovo se nece ispisati jer je ceo red komentar')&#10;print('Cao!')" instructions="Pokreni program. Primeti da se komentari ne pojavljuju u ispisu. Samo print() komande se izvrsavaju!"></div>

<h2>Probaj sam! — Meni za restoran</h2>

<p>Napravi lep meni za izmišljeni restoran! Koristi ukrase, prazne redove i komentare:</p>

<div data-code-exercise="" startercode="# Moj restoran&#10;print('*' * 30)&#10;print('   RESTORAN KOD MARKA')&#10;print('*' * 30)&#10;print()&#10;print('--- Glavna jela ---')&#10;print('Pica Margarita .... 800 din')&#10;print('Pasta Bolonjeze ... 700 din')&#10;print()&#10;print('--- Deserti ---')&#10;print('Sladoled .......... 300 din')&#10;print()&#10;print('*' * 30)&#10;print('   Prijatno!')" instructions="Promeni ime restorana, dodaj svoja omiljena jela i cene. Probaj da bude sto lepse!"></div>

<h2>Probaj sam! — Poster za film ili igricu</h2>

<p>Napravi poster za tvoj omiljeni film ili igricu:</p>

<div data-code-exercise="" startercode="print('#' * 35)&#10;print('#' + ' ' * 33 + '#')&#10;print('#   Naziv: [tvoj film/igrica]   #')&#10;print('#   Zanr: [akcija/komedija...]   #')&#10;print('#   Ocena: [1-10]                #')&#10;print('#' + ' ' * 33 + '#')&#10;print('#' * 35)" instructions="Popuni podatke o svom omiljenom filmu ili igrici. Dodaj jos redova ako zelis!"></div>

<h2>Šta smo naučili? 📝</h2>

<ul>
<li>Množenje teksta brojem: <code>'=' * 20</code> ponavlja znak 20 puta</li>
<li><strong>Greške su normalne</strong> i poruke o greškama nam <strong>pomažu</strong> da ih pronađemo</li>
<li>Tri česte greške: zaboravljen navodnik, zaboravljena zagrada, veliko slovo</li>
<li><strong>Komentari</strong> (<code>#</code>) su beleške u kodu koje kompjuter ignoriše</li>
</ul>

<p>U sledećoj lekciji ćeš naučiti o <strong>promenljivim</strong> — kutijama u koje možeš staviti podatke i koristiti ih koliko god puta hoćeš!</p>
HTML;


// ============================================================
// LESSON 30 — "Tipovi podataka — brojevi i tekst" (subchapter 2.2)
// ============================================================
$lessons[30] = <<<'HTML'
<h1>Tipovi podataka — brojevi i tekst</h1>

<p>Znaš da promenljive čuvaju podatke kao kutije. Ali sve kutije nisu iste! Neke čuvaju brojeve, neke tekst. Hajde da naučimo koje <strong>tipove podataka</strong> Python poznaje.</p>

<h2>Tri vrste podataka</h2>

<p>Zamisli da imaš tri različite kutije:</p>

<ul>
<li><strong>int</strong> (celi brojevi) — kao kad brojiš jabuke: 1, 2, 3, 42, 100. Nema decimala!</li>
<li><strong>float</strong> (decimalni brojevi) — kao temperatura: 36.6, ili cena: 2.50. Ima tačku!</li>
<li><strong>str</strong> (tekst / string) — bilo šta između navodnika: 'Zdravo', "Marko", '123'</li>
</ul>

<div data-code-exercise="" startercode="# Celi brojevi (int)&#10;jabuke = 5&#10;print(jabuke)&#10;&#10;# Decimalni brojevi (float)&#10;temperatura = 36.6&#10;print(temperatura)&#10;&#10;# Tekst (str)&#10;ime = 'Marko'&#10;print(ime)" instructions="Pokreni program. Tri promenljive, tri razlicita tipa podataka!"></div>

<h2>Velika zabuna: '100' protiv 100</h2>

<p>Ovo je <strong>najvažnija stvar</strong> u ovoj lekciji, pa pažljivo pročitaj!</p>

<p>Zamisli ovo:</p>
<ul>
<li><code>100</code> (bez navodnika) — to je <strong>broj</strong>. Kao da imaš 100 jabuka na stolu. Možeš ih sabirati, oduzimati, deliti.</li>
<li><code>'100'</code> (sa navodnicima) — to je <strong>tekst</strong>. Kao da si napisao/la "100" na papiru. To je crtež broja, ne pravi broj!</li>
</ul>

<p>Pogledaj šta se dešava kad ih sabiramo:</p>

<div data-code-exercise="" startercode="# Sabiranje BROJEVA&#10;print(100 + 100)&#10;&#10;# Sabiranje TEKSTA&#10;print('100' + '100')" instructions="Pokreni i pogledaj razliku! Brojevi se sabiraju matematicki. Tekst se lepi jedan uz drugi!"></div>

<p>Vidiš? <code>100 + 100 = 200</code> (matematika), ali <code>'100' + '100' = '100100'</code> (lepljenje teksta)! Kod teksta, <code>+</code> ne sabira — nego <strong>spaja</strong> tekst jedan uz drugi.</p>

<h2>type() — pitaj Python koji je tip</h2>

<p>Ako nisi siguran/sigurna koji je tip neke vrednosti, pitaj Python! Komanda <code>type()</code> ti kaže:</p>

<div data-code-exercise="" startercode="print(type(42))&#10;print(type(3.14))&#10;print(type('Zdravo'))&#10;print(type('100'))" instructions="Pokreni i pogledaj odgovore. Primeti da je '100' tipa str (tekst), ne int (broj)!"></div>

<p>Python odgovara: <code>&lt;class 'int'&gt;</code>, <code>&lt;class 'float'&gt;</code>, ili <code>&lt;class 'str'&gt;</code>.</p>

<h2>Pretvaranje tipova</h2>

<p>Ponekad trebaš da pretvoriš jedan tip u drugi. Zamisli to kao presipanje iz jedne kutije u drugu:</p>

<ul>
<li><code>int()</code> — pretvara u ceo broj (ako može)</li>
<li><code>float()</code> — pretvara u decimalni broj</li>
<li><code>str()</code> — pretvara u tekst</li>
</ul>

<div data-code-exercise="" startercode="# Tekst u broj&#10;tekst = '50'&#10;broj = int(tekst)&#10;print(broj + 10)&#10;&#10;# Broj u tekst&#10;godine = 12&#10;poruka = 'Imam ' + str(godine) + ' godina'&#10;print(poruka)" instructions="Pokreni program. Vidis kako int() pretvara tekst u broj, a str() pretvara broj u tekst?"></div>

<h2>Kviz — pogodi tip!</h2>

<p>Pokušaj da pogodиш koji je tip svake vrednosti <strong>pre</strong> nego što pokreneš program:</p>

<div data-code-exercise="" startercode="# Pogodi tip svake vrednosti!&#10;print(type(42))       # int, float ili str?&#10;print(type('42'))     # int, float ili str?&#10;print(type(3.0))      # int, float ili str?&#10;print(type('Zdravo')) # int, float ili str?&#10;print(type(True))     # iznenadjenje!" instructions="Prvo pogodi odgovore u glavi, pa onda pokreni da proveris! Koliko si pogodio/la?"></div>

<h2>Probaj sam! — Mini kalkulator</h2>

<p>Napravi program koji sabira dva broja koja ti upišeš u kodu:</p>

<div data-code-exercise="" startercode="# Promeni ove brojeve kako zelis&#10;prvi_broj = 25&#10;drugi_broj = 17&#10;&#10;zbir = prvi_broj + drugi_broj&#10;razlika = prvi_broj - drugi_broj&#10;&#10;print('Prvi broj: ' + str(prvi_broj))&#10;print('Drugi broj: ' + str(drugi_broj))&#10;print('Zbir: ' + str(zbir))&#10;print('Razlika: ' + str(razlika))" instructions="Promeni vrednosti promenljivih prvi_broj i drugi_broj. Probaj razlicite brojeve!"></div>

<h2>Šta smo naučili? 📝</h2>

<ul>
<li><strong>int</strong> = celi brojevi (5, 42, 100)</li>
<li><strong>float</strong> = decimalni brojevi (3.14, 36.6)</li>
<li><strong>str</strong> = tekst ('Zdravo', '100')</li>
<li><code>'100'</code> je TEKST, <code>100</code> je BROJ — to je velika razlika!</li>
<li><code>type()</code> proverava tip podatka</li>
<li><code>int()</code>, <code>float()</code>, <code>str()</code> pretvaraju između tipova</li>
</ul>

<p>U sledećoj lekciji ćeš naučiti kako da razgovaraš sa kompjuterom — kako da korisnik <strong>unese</strong> podatke dok program radi!</p>
HTML;


// ============================================================
// LESSON 31 — "Razgovor sa kompjuterom — input()" (subchapter 2.3)
// ============================================================
$lessons[31] = <<<'HTML'
<h1>Razgovor sa kompjuterom — input()</h1>

<p>Do sada smo mi pisali sve podatke unapred. Ali šta ako želiš da <strong>korisnik</strong> nešto ukuca dok program radi? Za to postoji komanda <code>input()</code>!</p>

<h2>Kompjuter pita, korisnik odgovara</h2>

<p>Komanda <code>input()</code> radi ovako:</p>
<ol>
<li>Kompjuter ispiše pitanje na ekranu</li>
<li>Program se <strong>zaustavi i čeka</strong> da korisnik nešto ukuca</li>
<li>Kad korisnik pritisne Enter, odgovor se sačuva u promenljivoj</li>
</ol>

<div data-code-exercise="" startercode="ime = input('Kako se zoves? ')&#10;print('Zdravo, ' + ime + '!')" instructions="Pokreni program. Kompjuter ce te pitati za ime — ukucaj ga i pritisni Enter!"></div>

<p>Vidiš kako je to lako? <code>input('pitanje')</code> prikaže pitanje i sačeka odgovor.</p>

<h2>ZAMKA: input() uvek vraća TEKST!</h2>

<p>Ovo je <strong>jako važno</strong> da zapamtiš: sve što korisnik ukuca, <code>input()</code> tretira kao <strong>tekst</strong>. Čak i ako korisnik ukuca broj!</p>

<p>Pogledaj šta se dešava:</p>

<div data-code-exercise="" startercode="godine = input('Koliko imas godina? ')&#10;print(type(godine))&#10;# godine je TEKST, ne broj!&#10;# print(godine + 1)  # OVO BI BILA GRESKA!" instructions="Pokreni i ukucaj broj. Pogledaj tip — bice str (tekst), ne int (broj)!"></div>

<p>Čak i ako ukucaš <code>12</code>, Python to vidi kao tekst <code>'12'</code>, ne kao broj <code>12</code>. Zato ne možeš odmah da računaš sa tim!</p>

<h2>Rešenje: pretvori u broj!</h2>

<p>Setimo se prošle lekcije — <code>int()</code> pretvara tekst u ceo broj, a <code>float()</code> u decimalni. Kombinujemo to sa <code>input()</code>:</p>

<div data-code-exercise="" startercode="# Za tekst — ne treba nista&#10;ime = input('Ime: ')&#10;&#10;# Za ceo broj — omotaj sa int()&#10;godine = int(input('Godine: '))&#10;&#10;# Za decimalan broj — omotaj sa float()&#10;visina = float(input('Visina u metrima (npr. 1.55): '))&#10;&#10;print('Zdravo, ' + ime + '!')&#10;print('Imas ' + str(godine) + ' godina.')&#10;print('Visok/a si ' + str(visina) + 'm.')" instructions="Pokreni i odgovori na pitanja. Sada program moze da radi sa brojevima!"></div>

<h2>Recept za pamćenje 📋</h2>

<p>Zapamti ova tri obrasca:</p>

<ul>
<li>Za <strong>tekst</strong>: <code>promenljiva = input('pitanje')</code></li>
<li>Za <strong>ceo broj</strong>: <code>promenljiva = int(input('pitanje'))</code></li>
<li>Za <strong>decimalan broj</strong>: <code>promenljiva = float(input('pitanje'))</code></li>
</ul>

<h2>Probaj sam! — Luda priča (Mad Libs)</h2>

<p>Napravi program koji pita korisnika za reči, pa napravi smešnu priču sa tim rečima!</p>

<div data-code-exercise="" startercode="# Pitaj za reci&#10;ime = input('Unesi neko ime: ')&#10;zivotinja = input('Unesi neku zivotinju: ')&#10;broj = input('Unesi neki broj: ')&#10;&#10;# Napravi smesnu pricu&#10;print()&#10;print('Jednog dana, ' + ime + ' je setao/la ulicom.')&#10;print('Odjednom, ogromna ' + zivotinja + ' je iskocila!')&#10;print(ime + ' je pobegao/la i trcao/la ' + broj + ' kilometara.')&#10;print('Kraj!')" instructions="Pokreni i odgovaraj na pitanja. Sto ludje reci uneses, smesnija je prica! Dodaj jos pitanja i redova price."></div>

<h2>Probaj sam! — Kalkulator godina</h2>

<p>Napravi program koji pita za ime i godinu rođenja, pa izračuna koliko imaš godina:</p>

<div data-code-exercise="" startercode="ime = input('Kako se zoves? ')&#10;godina_rodjenja = int(input('Koje si godine rodjen/a? '))&#10;&#10;godine = 2026 - godina_rodjenja&#10;&#10;print('Zdravo, ' + ime + '!')&#10;print('Ti imas ' + str(godine) + ' godina.')" instructions="Pokreni program i unesi svoje podatke. Da li je tacno izracunao godine?"></div>

<h2>Šta smo naučili? 📝</h2>

<ul>
<li><code>input()</code> pita korisnika za podatke i čeka odgovor</li>
<li><code>input()</code> <strong>uvek vraća tekst</strong> (str)</li>
<li>Za brojeve koristimo <code>int(input())</code> ili <code>float(input())</code></li>
<li>Možemo praviti interaktivne programe koji razgovaraju sa korisnikom!</li>
</ul>

<p>U sledećoj lekciji ćeš naučiti sve matematičke operacije u Python-u — postаćeš pravi kalkulator!</p>
HTML;


// ============================================================
// LESSON 32 — "Python kao kalkulator" (subchapter 3.1)
// ============================================================
$lessons[32] = <<<'HTML'
<h1>Python kao kalkulator</h1>

<p>Python može da računa umesto tebe! I nije samo sabiranje i oduzimanje — Python zna i neke trikove koje tvoj džepni kalkulator ne ume. Hajde da istražimo!</p>

<h2>Osnovne operacije</h2>

<p>Ove sigurno poznаješ iz matematike:</p>

<div data-code-exercise="" startercode="print(10 + 3)   # Sabiranje&#10;print(10 - 3)   # Oduzimanje&#10;print(10 * 3)   # Mnozenje&#10;print(10 / 3)   # Deljenje" instructions="Pokreni i pogledaj rezultate. Primeti da deljenje daje decimalan broj!"></div>

<p>Primeti da <code>10 / 3</code> daje <code>3.3333...</code> — Python uvek daje tačan rezultat deljenja, sa decimalama.</p>

<h2>Specijalne operacije</h2>

<p>Sada dolaze tri operatora koje možda ne poznаješ, ali su <strong>super korisni</strong>:</p>

<h3>// — Celobrojno deljenje (koliko celih puta stane?)</h3>

<p>Zamisli da imaš 10 bombona i deliš ih na 3 druga. Svako dobija <strong>3 cele</strong> bombоne (niko ne dobija pola bombоne!).</p>

<div data-code-exercise="" startercode="print(10 // 3)  # Koliko celih puta 3 stane u 10?&#10;print(7 // 2)   # Koliko celih puta 2 stane u 7?&#10;print(20 // 6)  # Koliko celih puta 6 stane u 20?" instructions="Pokreni i proveri rezultate. // baca decimale i daje samo ceo deo."></div>

<h3>% — Ostatak pri deljenju (šta ostane?)</h3>

<p>Posle deljenja 10 bombona na 3 druga, svako dobije 3, ali <strong>ostane 1</strong> bombona. To je ostatak!</p>

<div data-code-exercise="" startercode="print(10 % 3)  # 10 podeljeno na 3: ostatak je 1&#10;print(7 % 2)   # 7 podeljeno na 2: ostatak je 1&#10;print(20 % 6)  # 20 podeljeno na 6: ostatak je 2" instructions="Pokreni. Operator % daje ono sto ostane posle deljenja."></div>

<h3>** — Stepenovanje (pomnoži sam sa sobom)</h3>

<div data-code-exercise="" startercode="print(2 ** 3)   # 2 * 2 * 2 = 8&#10;print(5 ** 2)   # 5 * 5 = 25&#10;print(10 ** 3)  # 10 * 10 * 10 = 1000" instructions="Pokreni. Operator ** mnozi broj sam sa sobom vise puta."></div>

<h2>Redosled operacija</h2>

<p>Isti pravila kao u matematici! Prvo množenje i deljenje, pa tek onda sabiranje i oduzimanje:</p>

<div data-code-exercise="" startercode="# Bez zagrada: prvo mnozenje, pa sabiranje&#10;print(2 + 3 * 4)    # = 2 + 12 = 14&#10;&#10;# Sa zagradama: prvo ono u zagradi&#10;print((2 + 3) * 4)  # = 5 * 4 = 20" instructions="Pokreni i pogledaj razliku. Zagrade menjaju redosled, isto kao u matematici!"></div>

<h2>Probaj sam! — Kalkulator</h2>

<p>Napravi kalkulator koji pita za dva broja i pokazuje sve operacije:</p>

<div data-code-exercise="" startercode="a = int(input('Unesi prvi broj: '))&#10;b = int(input('Unesi drugi broj: '))&#10;&#10;print('--- Rezultati ---')&#10;print(str(a) + ' + ' + str(b) + ' = ' + str(a + b))&#10;print(str(a) + ' - ' + str(b) + ' = ' + str(a - b))&#10;print(str(a) + ' * ' + str(b) + ' = ' + str(a * b))&#10;print(str(a) + ' / ' + str(b) + ' = ' + str(a / b))" instructions="Pokreni i unesi dva broja. Program pokazuje sve operacije! Probaj razlicite brojeve."></div>

<h2>Probaj sam! — Obim i površina pravougaonika</h2>

<div data-code-exercise="" startercode="a = int(input('Duzina stranice a: '))&#10;b = int(input('Duzina stranice b: '))&#10;&#10;obim = 2 * (a + b)&#10;povrsina = a * b&#10;&#10;print('Obim pravougaonika: ' + str(obim))&#10;print('Povrsina pravougaonika: ' + str(povrsina))" instructions="Unesi duzine stranica. Program izracunava obim i povrsinu!"></div>

<h2>Probaj sam! — Kalkulator džeparca</h2>

<p>Ako dobijaš džeparac svake nedelje, koliko ćeš imati za mesec dana? Za godinu?</p>

<div data-code-exercise="" startercode="nedeljni = int(input('Koliko dzeparca dobijas nedeljno (u dinarima)? '))&#10;&#10;mesecno = nedeljni * 4&#10;godisnje = nedeljni * 52&#10;&#10;print('Nedeljno: ' + str(nedeljni) + ' din')&#10;print('Mesecno (4 nedelje): ' + str(mesecno) + ' din')&#10;print('Godisnje (52 nedelje): ' + str(godisnje) + ' din')&#10;print()&#10;print('Za godinu dana ces imati ' + str(godisnje) + ' dinara!')" instructions="Unesi koliko dzeparca dobijas. Pogledaj koliko se skupi za godinu dana!"></div>

<h2>Šta smo naučili? 📝</h2>

<ul>
<li><code>+</code> <code>-</code> <code>*</code> <code>/</code> — osnovne operacije</li>
<li><code>//</code> — celobrojno deljenje (bez decimala)</li>
<li><code>%</code> — ostatak pri deljenju</li>
<li><code>**</code> — stepenovanje</li>
<li>Zagrade menjaju redosled operacija, isto kao u matematici</li>
</ul>

<p>U sledećoj lekciji ćeš naučiti cool trikove sa tekstom — kako da ga okreneš, VIČEŠ, šapućeš i mnogo više!</p>
HTML;


// ============================================================
// LESSON 33 — "Igranje sa tekstom" (subchapter 3.2)
// ============================================================
$lessons[33] = <<<'HTML'
<h1>Igranje sa tekstom</h1>

<p>Tekst u Python-u nije samo za čitanje — možeš da se igraš sa njim na mnogo zanimljivih načina! Hajde da naučimo trikove koji će ti programi učiniti mnogo zanimljivijim.</p>

<h2>Podsetnik: f-stringovi</h2>

<p>Iz prethodnih lekcija znaš da možeš koristiti <code>f-string</code> da staviš promenljive direktno u tekst. Samo dodaš slovo <code>f</code> ispred navodnika i staviš promenljivu u vitičaste zagrade:</p>

<div data-code-exercise="" startercode="ime = 'Marko'&#10;godine = 12&#10;print(f'Zdravo, ja sam {ime} i imam {godine} godina!')" instructions="Pokreni. f-string je najlaksi nacin da ubacis promenljive u tekst!"></div>

<h2>VIKANJE i šaputanje</h2>

<p>Možeš pretvoriti tekst u SVA VELIKA ili sva mala slova:</p>

<div data-code-exercise="" startercode="poruka = 'Zdravo Svete'&#10;&#10;print(poruka.upper())  # SVA VELIKA SLOVA — VIKANJE!&#10;print(poruka.lower())  # sva mala slova — saputanje..." instructions="Pokreni. .upper() pretvara u velika, .lower() u mala slova."></div>

<h2>Brojanje slova sa len()</h2>

<p>Komanda <code>len()</code> broji koliko znakova ima u tekstu (uključujući razmake!):</p>

<div data-code-exercise="" startercode="rec = 'Python'&#10;print(f'Rec \'{rec}\' ima {len(rec)} slova.')&#10;&#10;recenica = 'Ja ucim Python'&#10;print(f'Recenica ima {len(recenica)} znakova (i razmaci se broje!).')" instructions="Pokreni i proveri. Razmaci i znakovi interpunkcije se takodje broje!"></div>

<h2>Pristupanje pojedinačnim slovima</h2>

<p>Svako slovo u tekstu ima svoju <strong>poziciju</strong> (indeks). ALI — Python počinje da broji od <strong>0</strong>, ne od 1!</p>

<p>Zamisli tekst kao niz kutijica, svaka sa jednim slovom:</p>

<div data-code-exercise="" startercode="rec = 'PYTHON'&#10;# Pozicije: P=0, Y=1, T=2, H=3, O=4, N=5&#10;&#10;print(rec[0])   # Prvo slovo&#10;print(rec[1])   # Drugo slovo&#10;print(rec[-1])  # Poslednje slovo (negativan broj = od kraja!)" instructions="Pokreni. [0] je prvo slovo, [-1] je poslednje. Pokusaj i druge pozicije!"></div>

<h2>Isecanje teksta (slicing)</h2>

<p>Možeš uzeti deo teksta koristeći <code>[od:do]</code>:</p>

<div data-code-exercise="" startercode="rec = 'PROGRAMIRANJE'&#10;&#10;print(rec[0:3])   # Prva 3 slova: PRO&#10;print(rec[0:7])   # Prvih 7: PROGRAM&#10;print(rec[7:])    # Od 7. do kraja: IRANJE" instructions="Pokreni. [0:3] znaci od pozicije 0 do pozicije 3 (ali 3 se ne racuna)."></div>

<h2>Ponavljanje teksta</h2>

<p>Ovo već znaš iz lekcije 2! Tekst pomnožen brojem se ponavlja:</p>

<div data-code-exercise="" startercode="print('ha' * 3)    # hahaha&#10;print('la' * 5)    # lalalalala&#10;print('-' * 30)    # linija od crtica" instructions="Pokreni. Mnozenje teksta brojem ga ponavlja vise puta!"></div>

<h2>Probaj sam! — Generator nadimaka</h2>

<p>Napravi program koji uzima ime i pravi razne varijante:</p>

<div data-code-exercise="" startercode="ime = input('Unesi svoje ime: ')&#10;&#10;print(f'Tvoje ime: {ime}')&#10;print(f'VIKANJE: {ime.upper()}')&#10;print(f'saputanje: {ime.lower()}')&#10;print(f'Broj slova: {len(ime)}')&#10;print(f'Prvo slovo: {ime[0]}')&#10;print(f'Poslednje slovo: {ime[-1]}')&#10;print(f'Prva 3 slova: {ime[0:3]}')&#10;print(f'Ponovljeno: {ime * 3}')" instructions="Unesi svoje ime i pogledaj sve varijante! Dodaj jos neke ako ti padne na pamet."></div>

<h2>Probaj sam! — Tajni kod</h2>

<p>Napravi program koji prikazuje poziciju svakog slova u imenu:</p>

<div data-code-exercise="" startercode="ime = input('Unesi rec: ')&#10;&#10;print(f'Tajni kod za rec \'{ime}\':')&#10;print(f'Slovo na poziciji 0: {ime[0]}')&#10;print(f'Slovo na poziciji 1: {ime[1]}')&#10;print(f'Slovo na poziciji 2: {ime[2]}')&#10;print(f'Ukupno slova: {len(ime)}')" instructions="Unesi rec koja ima bar 3 slova. Dodaj jos redova za ostale pozicije!"></div>

<h2>Šta smo naučili? 📝</h2>

<ul>
<li><code>.upper()</code> — sva velika slova, <code>.lower()</code> — sva mala slova</li>
<li><code>len()</code> — broji znakove u tekstu</li>
<li><code>[0]</code>, <code>[1]</code>, <code>[-1]</code> — pristup pojedinačnim slovima</li>
<li><code>[0:3]</code> — isecanje dela teksta</li>
<li><code>'tekst' * 3</code> — ponavljanje teksta</li>
</ul>

<p>U sledećoj lekciji kompjuter će naučiti da <strong>donosi odluke</strong> — ako je nešto tačno, uradi jedno, inače uradi drugo!</p>
HTML;


// ============================================================
// LESSON 34 — "Da ili ne? — uslovi" (subchapter 4.1)
// ============================================================
$lessons[34] = <<<'HTML'
<h1>Da ili ne? — uslovi</h1>

<p>Do sada su tvoji programi radili isto svaki put. Ali pravi programi <strong>donose odluke</strong>! Kao čuvar na vratima koji pita: "Imaš li kartu?" Ako da — uđi. Ako ne — ne možeš.</p>

<h2>Tačno i Netačno — True i False</h2>

<p>Python ima dva specijalna odgovora: <code>True</code> (tačno, da) i <code>False</code> (netačno, ne). Koristi ih kad poredi stvari:</p>

<div data-code-exercise="" startercode="print(5 > 3)    # Da li je 5 vece od 3? True!&#10;print(2 > 10)   # Da li je 2 vece od 10? False!&#10;print(7 == 7)   # Da li je 7 jednako 7? True!&#10;print(5 == 3)   # Da li je 5 jednako 3? False!" instructions="Pokreni. Python odgovara True (tacno) ili False (netacno) na svako pitanje."></div>

<h2>Operatori poređenja</h2>

<p>Evo svih načina na koje Python poredi stvari:</p>

<ul>
<li><code>==</code> — da li je jednako (DVA znaka jednako! Jedan = je za promenljive)</li>
<li><code>!=</code> — da li je različito</li>
<li><code>&gt;</code> — da li je veće</li>
<li><code>&lt;</code> — da li je manje</li>
<li><code>&gt;=</code> — da li je veće ili jednako</li>
<li><code>&lt;=</code> — da li je manje ili jednako</li>
</ul>

<div data-code-exercise="" startercode="a = 10&#10;b = 5&#10;&#10;print(f'{a} == {b}: {a == b}')&#10;print(f'{a} != {b}: {a != b}')&#10;print(f'{a} > {b}: {a > b}')&#10;print(f'{a} < {b}: {a < b}')" instructions="Pokreni. Probaj da menjas vrednosti a i b i pogledaj kako se odgovori menjaju."></div>

<h2>if — AKO je tačno, uradi ovo</h2>

<p>Komanda <code>if</code> kaže kompjuteru: "Ako je ovaj uslov tačan, onda izvrši ovaj kod."</p>

<p><strong>Dva pravila koja su JAKO važna:</strong></p>
<ol>
<li>Posle uslova <strong>uvek ide dvotačka</strong> <code>:</code></li>
<li>Kod koji pripada if-u mora biti <strong>uvučen za 4 razmaka</strong> (tab)</li>
</ol>

<div data-code-exercise="" startercode="uzrast = int(input('Koliko imas godina? '))&#10;&#10;if uzrast >= 18:&#10;    print('Mozes da vozis auto!')&#10;    print('Ti si punoletan/a.')" instructions="Pokreni i unesi broj. Ako je 18 ili vise, videces poruku. Ako je manje — nista se ne desava."></div>

<h2>if/else — AKO da uradi ovo, INAČE uradi ono</h2>

<p>Šta ako želimo da se nešto desi i kad uslov NIJE tačan? Koristimo <code>else</code>:</p>

<div data-code-exercise="" startercode="lozinka = input('Unesi lozinku: ')&#10;&#10;if lozinka == 'python123':&#10;    print('Tacna lozinka! Dobrodosao/la!')&#10;else:&#10;    print('Pogresna lozinka! Pristup odbijen.')" instructions="Pokreni i probaj tacnu lozinku (python123) i pogresnu. Pogledaj razliku!"></div>

<div data-code-exercise="" startercode="godine = int(input('Koliko imas godina? '))&#10;&#10;if godine >= 18:&#10;    print('Mozes da glasas na izborima!')&#10;else:&#10;    preostalo = 18 - godine&#10;    print(f'Jos {preostalo} godina do glasanja.')" instructions="Unesi razlicite godine i pogledaj odgovore."></div>

<h2>Probaj sam! — Pogodi broj</h2>

<p>Da li je tajanstveni broj veći ili manji od 50?</p>

<div data-code-exercise="" startercode="tajanstveni_broj = 37&#10;&#10;odgovor = int(input('Pogodi broj (1-100): '))&#10;&#10;if odgovor == tajanstveni_broj:&#10;    print('BRAVO! Pogodio/la si!')&#10;else:&#10;    if odgovor > tajanstveni_broj:&#10;        print('Previse! Broj je manji.')&#10;    else:&#10;        print('Premalo! Broj je veci.')" instructions="Pokusaj da pogodis broj! Pogledaj kako program daje razlicite odgovore."></div>

<h2>Probaj sam! — Kviz sa bodovima</h2>

<div data-code-exercise="" startercode="bodovi = 0&#10;&#10;odgovor1 = input('Glavnigrad Srbije? ')&#10;if odgovor1 == 'Beograd':&#10;    print('Tacno!')&#10;    bodovi = bodovi + 1&#10;else:&#10;    print('Netacno! Odgovor je Beograd.')&#10;&#10;odgovor2 = input('Koliko dana ima nedelja? ')&#10;if odgovor2 == '7':&#10;    print('Tacno!')&#10;    bodovi = bodovi + 1&#10;else:&#10;    print('Netacno! Odgovor je 7.')&#10;&#10;odgovor3 = input('Koji je programski jezik najlaksi za pocetnike? ')&#10;if odgovor3 == 'Python':&#10;    print('Tacno!')&#10;    bodovi = bodovi + 1&#10;else:&#10;    print('Netacno! Odgovor je Python.')&#10;&#10;print(f'Tvoj rezultat: {bodovi}/3')" instructions="Odgovaraj na pitanja i skupljaj bodove! Dodaj jos pitanja ako zelis."></div>

<h2>Šta smo naučili? 📝</h2>

<ul>
<li><code>True</code> i <code>False</code> — Python-ov način da kaže da/ne</li>
<li>Operatori poređenja: <code>==</code>, <code>!=</code>, <code>&gt;</code>, <code>&lt;</code>, <code>&gt;=</code>, <code>&lt;=</code></li>
<li><code>if</code> — izvrši kod samo ako je uslov tačan</li>
<li><code>else</code> — izvrši kod ako uslov NIJE tačan</li>
<li>Posle <code>if</code> i <code>else</code> uvek ide <code>:</code> i sledeći red mora biti uvučen</li>
</ul>

<p>U sledećoj lekciji ćeš naučiti šta da radiš kad imaš <strong>više od dva izbora</strong> — elif!</p>
HTML;


// ============================================================
// LESSON 35 — "Više izbora — elif" (subchapter 4.2)
// ============================================================
$lessons[35] = <<<'HTML'
<h1>Više izbora — elif</h1>

<p>Šta ako nemaš samo dva izbora (da/ne) nego <strong>više</strong>? Semafor ima tri boje: crvena, žuta, zelena. Ocene idu od 1 do 5. Za to koristimo <code>elif</code>!</p>

<h2>elif = "inače, ako..."</h2>

<p><code>elif</code> je skraćenica od "else if" — znači "inače, ako je ovo tačno...". Možeš imati koliko god hoćeš elif-ova:</p>

<div data-code-exercise="" startercode="boja = input('Koja je boja na semaforu? (crvena/zuta/zelena) ')&#10;&#10;if boja == 'crvena':&#10;    print('STOJ! Cekaj.')&#10;elif boja == 'zuta':&#10;    print('PRIPREMI SE!')&#10;elif boja == 'zelena':&#10;    print('KRENI! Mozes da predjes.')&#10;else:&#10;    print('To nije boja semafora!')" instructions="Pokreni i probaj razlicite boje. Sta se desi ako ukucas nesto sto nije boja?"></div>

<h2>Kalkulator ocena</h2>

<p>Hajde da napravimo program koji pretvara bodove u ocene:</p>

<div data-code-exercise="" startercode="bodovi = int(input('Koliko bodova imas (0-100)? '))&#10;&#10;if bodovi >= 90:&#10;    print('Ocena: 5 (odlican!)')&#10;elif bodovi >= 75:&#10;    print('Ocena: 4 (vrlo dobar)')&#10;elif bodovi >= 60:&#10;    print('Ocena: 3 (dobar)')&#10;elif bodovi >= 45:&#10;    print('Ocena: 2 (dovoljan)')&#10;else:&#10;    print('Ocena: 1 (nedovoljan)')" instructions="Unesi razlicite bodove i proveri ocene. Da li se slazes sa granicama?"></div>

<h2>Probaj sam! — Savetnik za odevanje</h2>

<p>Program koji na osnovu temperature predlaže šta da obučeš:</p>

<div data-code-exercise="" startercode="temp = int(input('Koliko je stepeni napolju? '))&#10;&#10;if temp >= 30:&#10;    print('Vruce! Obuci kratke rukave i ponesi vodu.')&#10;elif temp >= 20:&#10;    print('Prijatno. Majica i pantalone su OK.')&#10;elif temp >= 10:&#10;    print('Sveže. Ponesi duks ili laku jaknu.')&#10;elif temp >= 0:&#10;    print('Hladno! Obuci jaknu, sal i kapu.')&#10;else:&#10;    print('Ispod nule! Obuci SVE sto imas!')" instructions="Unesi razlicite temperature. Dodaj jos saveta ako zelis!"></div>

<h2>Probaj sam! — Kalkulator sa menijem</h2>

<div data-code-exercise="" startercode="print('--- KALKULATOR ---')&#10;print('1. Sabiranje')&#10;print('2. Oduzimanje')&#10;print('3. Mnozenje')&#10;print('4. Deljenje')&#10;&#10;izbor = input('Izaberi operaciju (1-4): ')&#10;a = int(input('Prvi broj: '))&#10;b = int(input('Drugi broj: '))&#10;&#10;if izbor == '1':&#10;    print(f'{a} + {b} = {a + b}')&#10;elif izbor == '2':&#10;    print(f'{a} - {b} = {a - b}')&#10;elif izbor == '3':&#10;    print(f'{a} * {b} = {a * b}')&#10;elif izbor == '4':&#10;    print(f'{a} / {b} = {a / b}')&#10;else:&#10;    print('Nepoznata operacija!')" instructions="Izaberi operaciju, unesi brojeve i pogledaj rezultat!"></div>

<h2>Logički operatori: and, or, not</h2>

<p>Ponekad treba da proverиš <strong>više uslova odjednom</strong>:</p>

<ul>
<li><code>and</code> — OBA uslova moraju biti tačna (kao "i")</li>
<li><code>or</code> — bar JEDAN uslov mora biti tačan (kao "ili")</li>
<li><code>not</code> — okreće tačno u netačno i obrnuto (kao "ne")</li>
</ul>

<div data-code-exercise="" startercode="domaci = input('Da li si zavrsio/la domaci? (da/ne) ')&#10;soba = input('Da li si pospremio/la sobu? (da/ne) ')&#10;&#10;if domaci == 'da' and soba == 'da':&#10;    print('Mozes na zurku! Zabavi se!')&#10;elif domaci == 'da' or soba == 'da':&#10;    print('Uradio/la si jedno, ali treba i drugo!')&#10;else:&#10;    print('Prvo zavrsi obaveze!')" instructions="Probaj razlicite kombinacije odgovora (da/da, da/ne, ne/da, ne/ne)."></div>

<h2>Šta smo naučili? 📝</h2>

<ul>
<li><code>elif</code> — dodaje još izbora između <code>if</code> i <code>else</code></li>
<li>Možeš imati koliko god hoćeš <code>elif</code>-ova</li>
<li><code>and</code> — oba uslova moraju biti tačna</li>
<li><code>or</code> — bar jedan uslov mora biti tačan</li>
<li><code>not</code> — okreće tačno u netačno</li>
</ul>

<p>U sledećoj lekciji učimo <strong>petlje</strong> — kako da kompjuter ponovi nešto 100 puta bez da pišeš 100 linija koda!</p>
HTML;


// ============================================================
// LESSON 36 — "Ponavljanje — for petlja" (subchapter 5.1)
// ============================================================
$lessons[36] = <<<'HTML'
<h1>Ponavljanje — for petlja</h1>

<p>Šta ako želiš da ispišeš "Zdravo!" 100 puta? Da napišeš 100 puta <code>print('Zdravo!')</code>? Naravno da ne! Za to postoje <strong>petlje</strong> — komande koje ponavljaju kod koliko god puta treba.</p>

<h2>for petlja — ponovi tačno X puta</h2>

<p>Komanda <code>for</code> kaže: "Ponovi ovaj kod određeni broj puta." Koristi se zajedno sa <code>range()</code>:</p>

<div data-code-exercise="" startercode="for i in range(5):&#10;    print('Zdravo!')" instructions="Pokreni. 'Zdravo!' se ispisuje 5 puta! range(5) znaci ponovi 5 puta."></div>

<p>Kao i kod <code>if</code>, posle <code>for</code> ide <code>:</code> i kod mora biti uvučen.</p>

<h2>range() — objašnjenje</h2>

<p><code>range()</code> pravi niz brojeva. Može se koristiti na tri načina:</p>

<div data-code-exercise="" startercode="# range(5) = brojevi 0, 1, 2, 3, 4&#10;print('range(5):')&#10;for i in range(5):&#10;    print(i)&#10;&#10;print()&#10;&#10;# range(1, 6) = brojevi 1, 2, 3, 4, 5&#10;print('range(1, 6):')&#10;for i in range(1, 6):&#10;    print(i)" instructions="Pokreni. Primeti: range(5) pocinje od 0! range(1, 6) pocinje od 1 i ide do 5."></div>

<div data-code-exercise="" startercode="# range(0, 11, 2) = svaki drugi broj od 0 do 10&#10;print('Parni brojevi do 10:')&#10;for i in range(0, 11, 2):&#10;    print(i)" instructions="Treci broj u range() je korak. Ovde je korak 2, pa preskace svaki drugi broj."></div>

<h2>Koristimo brojač</h2>

<p>Promenljiva <code>i</code> u petlji menja svoju vrednost svaki put. Možemo je koristiti:</p>

<div data-code-exercise="" startercode="# Tablica mnozenja za broj 7&#10;print('Tablica mnozenja za 7:')&#10;for i in range(1, 11):&#10;    rezultat = 7 * i&#10;    print(f'7 x {i} = {rezultat}')" instructions="Pokreni. Petlja prolazi kroz brojeve 1-10 i za svaki racuna 7 puta taj broj."></div>

<h2>Probaj sam! — Tablica množenja</h2>

<p>Napravi tablicu množenja za bilo koji broj koji korisnik unese:</p>

<div data-code-exercise="" startercode="broj = int(input('Za koji broj zelis tablicu mnozenja? '))&#10;&#10;print(f'Tablica mnozenja za {broj}:')&#10;print('-' * 20)&#10;for i in range(1, 11):&#10;    print(f'{broj} x {i} = {broj * i}')" instructions="Unesi broj i dobices njegovu tablicu mnozenja od 1 do 10!"></div>

<h2>Probaj sam! — Mašina za sabiranje</h2>

<p>Program koji pita korisnika za nekoliko brojeva i sabere ih:</p>

<div data-code-exercise="" startercode="koliko = int(input('Koliko brojeva zelis da saberes? '))&#10;zbir = 0&#10;&#10;for i in range(1, koliko + 1):&#10;    broj = int(input(f'Unesi broj {i}: '))&#10;    zbir = zbir + broj&#10;&#10;print(f'Zbir svih brojeva: {zbir}')" instructions="Unesi koliko brojeva zelis, pa ih redom ukucaj. Program ce sabrati sve!"></div>

<h2>Probaj sam! — Crtanje uzorka</h2>

<p>Napravi stepenice od zvezdica:</p>

<div data-code-exercise="" startercode="visina = int(input('Koliko redova zelis? '))&#10;&#10;for i in range(1, visina + 1):&#10;    print('*' * i)" instructions="Unesi broj redova. Svaki red ima jednu zvezdicu vise! Probaj i sa drugim znakovima."></div>

<h2>Šta smo naučili? 📝</h2>

<ul>
<li><code>for i in range(x):</code> — ponavlja kod x puta</li>
<li><code>range(5)</code> = 0,1,2,3,4 — <code>range(1,6)</code> = 1,2,3,4,5</li>
<li><code>range(0,10,2)</code> = 0,2,4,6,8 — treći broj je korak</li>
<li>Promenljiva <code>i</code> menja vrednost svaki prolaz kroz petlju</li>
<li>Kod unutar petlje mora biti uvučen</li>
</ul>

<p>U poslednjoj lekciji ćeš naučiti drugu vrstu petlje — <code>while</code> — za kad ne znaš unapred koliko puta treba da se ponovi!</p>
HTML;


// ============================================================
// LESSON 37 — "Ponavljaj dok... — while petlja" (subchapter 5.2)
// ============================================================
$lessons[37] = <<<'HTML'
<h1>Ponavljaj dok... — while petlja</h1>

<p><code>for</code> petlja je super kad znaš koliko puta treba da ponoviš. Ali šta ako ne znaš? Na primer: "Pogađaj dok ne pogodиš" — ne znaš da li će korisnik pogoditi iz prvog ili iz stotog pokušaja!</p>

<h2>while = "ponavljaj DOK JE uslov tačan"</h2>

<p>Komanda <code>while</code> ponavlja kod <strong>sve dok je uslov tačan</strong>. Čim uslov postane netačan, petlja se zaustavlja.</p>

<div data-code-exercise="" startercode="# Pogadjanje lozinke&#10;lozinka = ''&#10;&#10;while lozinka != 'python':&#10;    lozinka = input('Unesi lozinku: ')&#10;&#10;print('Tacna lozinka! Dobrodosao/la!')" instructions="Pokreni i pokusaj razne lozinke. Program ce pitati ponovo i ponovo dok ne ukucas 'python'."></div>

<h2>Odbrojavanje</h2>

<div data-code-exercise="" startercode="broj = 10&#10;&#10;while broj > 0:&#10;    print(broj)&#10;    broj = broj - 1&#10;&#10;print('START!!!')" instructions="Pokreni i gledaj odbrojavanje! Promenljiva broj se smanjuje za 1 svaki put."></div>

<h2>OPASNOST: Beskonačna petlja!</h2>

<p>Šta se desi ako uslov <strong>nikad ne postane netačan</strong>? Petlja se vrti ZAUVEK! To se zove <strong>beskonačna petlja</strong> i to je najčešća greška sa while petljom.</p>

<p>Na primer, ovo bi se vrtelo zauvek (NE pokreći ovo!):</p>

<pre><code># OPASNO - ovo se nikad ne zaustavlja!
# x = 5
# while x > 0:
#     print(x)
#     # Zaboravili smo x = x - 1 !!!</code></pre>

<p>Pravilo: <strong>unutar while petlje, nešto mora da menja uslov</strong> tako da on pre ili kasnije postane netačan!</p>

<h2>Probaj sam! — Pogodi broj</h2>

<p>Napravi igru gde kompjuter "misli" broj, a ti pogađaš uz pomoć:</p>

<div data-code-exercise="" startercode="tajanstveni = 42&#10;pokusaj = 0&#10;broj_pokusaja = 0&#10;&#10;print('Mislim broj izmedju 1 i 100. Pogodi!')&#10;&#10;while pokusaj != tajanstveni:&#10;    pokusaj = int(input('Tvoj pokusaj: '))&#10;    broj_pokusaja = broj_pokusaja + 1&#10;    &#10;    if pokusaj > tajanstveni:&#10;        print('Previse! Pokusaj manji broj.')&#10;    elif pokusaj < tajanstveni:&#10;        print('Premalo! Pokusaj veci broj.')&#10;    else:&#10;        print(f'BRAVO! Pogodio/la si iz {broj_pokusaja}. pokusaja!')" instructions="Pogadjaj broj! Program ti daje pomoc — govori ti da li je tvoj broj preveliki ili premali."></div>

<h2>Probaj sam! — Bankomat</h2>

<p>Napravi jednostavan bankomat:</p>

<div data-code-exercise="" startercode="stanje = 1000&#10;print(f'Dobrodosao/la! Stanje: {stanje} din')&#10;&#10;while stanje > 0:&#10;    iznos = int(input('Koliko zelis da podignes? '))&#10;    &#10;    if iznos > stanje:&#10;        print('Nemas dovoljno novca!')&#10;    else:&#10;        stanje = stanje - iznos&#10;        print(f'Podigao/la si {iznos} din.')&#10;        print(f'Preostalo stanje: {stanje} din')&#10;&#10;print('Stanje je 0. Dovidjenja!')" instructions="Podizi novac dok ne potrosis sve! Probaj da podignes vise nego sto imas."></div>

<h2>Sve što smo naučili u celom kursu! 🎓</h2>

<p>Stani na trenutak i pogledaj koliko toga sada znaš:</p>

<ul>
<li><strong>print()</strong> — ispisivanje teksta</li>
<li><strong>Promenljive</strong> — kutije za čuvanje podataka</li>
<li><strong>input()</strong> — razgovor sa korisnikom</li>
<li><strong>Tipovi podataka</strong> — int, float, str</li>
<li><strong>Operatori</strong> — +, -, *, /, //, %, **</li>
<li><strong>Stringovi</strong> — .upper(), .lower(), len(), isecanje</li>
<li><strong>if / elif / else</strong> — donošenje odluka</li>
<li><strong>and, or, not</strong> — kombinovanje uslova</li>
<li><strong>for petlja</strong> — ponavljanje tačan broj puta</li>
<li><strong>while petlja</strong> — ponavljanje dok je uslov tačan</li>
</ul>

<p><strong>Ovo su isti gradivni blokovi koje koriste profesionalni programeri!</strong> Razlika je samo u tome što oni kombinuju ove blokove na kompleksnije načine — ali osnova je ista.</p>

<p>Nastavi da vežbaš, pravi svoje male programe, eksperimentиši — i zapamti: svaka greška te čini boljim programerom! 💪</p>
HTML;


// ============================================================
// Now update each lesson in the database
// ============================================================

$skipIds = [29]; // Already rewritten, skip

$updated = 0;
$errors = [];

foreach ($lessons as $id => $content) {
    if (in_array($id, $skipIds)) {
        echo "SKIP: Lesson $id (already rewritten)\n";
        continue;
    }

    $lesson = Lesson::find($id);
    if (!$lesson) {
        $errors[] = "Lesson $id not found!";
        echo "ERROR: Lesson $id not found!\n";
        continue;
    }

    // Trim whitespace from beginning/end of content
    $lesson->content = trim($content);
    $lesson->save();

    $charCount = strlen($lesson->content);
    echo "UPDATED: Lesson $id — {$lesson->title} ({$charCount} chars)\n";
    $updated++;
}

echo "\n=== DONE ===\n";
echo "Updated: $updated lessons\n";
echo "Skipped: " . count($skipIds) . " lessons\n";
echo "Errors: " . count($errors) . "\n";

if (!empty($errors)) {
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
}
