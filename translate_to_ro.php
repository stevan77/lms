<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Lesson;
use App\Models\Chapter;
use App\Models\Subchapter;

// ============================================================
// 1. Update Romanian chapter titles
// ============================================================
$chapterTitles = [
    14 => 'Introducere în programare',
    15 => 'Variabile și tipuri de date',
    16 => 'Calcule și operatori',
    17 => 'Luarea deciziilor — if/else',
    18 => 'Repetare — bucle',
];

foreach ($chapterTitles as $id => $title) {
    $ch = Chapter::find($id);
    if ($ch) {
        $ch->title = $title;
        $ch->save();
        echo "Chapter $id => $title\n";
    }
}

// ============================================================
// 2. Update Romanian subchapter titles
// ============================================================
$subchapterTitles = [
    21 => 'Ce este programarea?',
    22 => 'Primul tău program',
    23 => 'Ce sunt variabilele?',
    24 => 'Tipuri de date',
    25 => 'Citirea datelor — input()',
    26 => 'Operatori matematici',
    27 => 'Lucrul cu textul',
    28 => 'Condiții și comparații',
    29 => 'if, elif și else',
    30 => 'Bucla for',
    31 => 'Bucla while',
];

foreach ($subchapterTitles as $id => $title) {
    $sc = Subchapter::find($id);
    if ($sc) {
        $sc->title = $title;
        $sc->save();
        echo "Subchapter $id => $title\n";
    }
}

// ============================================================
// 3. Update Romanian lesson titles
// ============================================================
$lessonTitles = [
    38 => 'Ce este programarea?',
    39 => 'Primul tău program adevărat',
    40 => 'Ce sunt variabilele?',
    41 => 'Tipuri de date — numere și text',
    42 => 'Discuție cu calculatorul — input()',
    43 => 'Python ca un digitron',
    44 => 'Jocuri cu textul',
    45 => 'Da sau nu? — condiții',
    46 => 'Mai multe opțiuni — elif',
    47 => 'Repetare — bucla for',
    48 => 'Repetă cât timp... — bucla while',
];

foreach ($lessonTitles as $id => $title) {
    $l = Lesson::find($id);
    if ($l) {
        $l->title = $title;
        $l->save();
        echo "Lesson $id title => $title\n";
    }
}

// ============================================================
// 4. Set translated content for each Romanian lesson
// ============================================================

$lessonContent = [];

// --- LESSON 38: Ce este programarea? ---
$lessonContent[38] = '<h1>Ce este programarea?</h1>

<p><strong>După această lecție, vei putea să faci calculatorul să spună orice dorești!</strong> Sună puternic? Pentru că așa este. Hai să începem!</p>

<h2>🤖 Imaginează-ți că ai un robot...</h2>

<p>Imaginează-ți că cineva ți-a dăruit un robot. Acest robot este incredibil de ascultător — face <strong>absolut TOT</strong> ce-i spui. Dar există o problemă: el este puțin... literal.</p>

<p>Nu-i poți spune: „Hei robot, fă-mi un sandviș." El nu știe ce e un sandviș! Trebuie să-i explici pas cu pas:</p>

<ol>
<li>Deschide punga de pâine</li>
<li>Scoate două felii</li>
<li>Pune-le pe masă</li>
<li>Deschide frigiderul</li>
<li>Ia șunca</li>
<li>Pune șunca pe o felie de pâine</li>
<li>Pune cealaltă felie de pâine deasupra</li>
</ol>

<p>Dacă sari peste un pas, robotul se va încurca. Dacă spui pașii în ordinea greșită — primești șunca pe masă și pâinea în frigider! 😄</p>

<p><strong>Programarea este exact asta</strong> — scrierea unor instrucțiuni precise (comenzi) pe care calculatorul le execută pas cu pas. Tu ești șeful, iar calculatorul este robotul tău ascultător.</p>

<h2>De ce tocmai Python?</h2>

<p>Există multe limbaje de programare în lume — sute! Noi vom învăța <strong>Python</strong> pentru că:</p>

<ul>
<li><strong>Este cel mai ușor pentru începători</strong> — se citește aproape ca limba engleză</li>
<li><strong>Îl folosesc profesioniștii</strong> — Google, Instagram, Netflix, NASA, și chiar și doctori și oameni de știință</li>
<li><strong>Poate face multe lucruri</strong> — jocuri, aplicații, inteligență artificială</li>
<li><strong>Se învață repede</strong> — în doar câteva lecții vei crea programe adevărate!</li>
</ul>

<h2>Prima ta comandă: print()</h2>

<p>Hai să începem imediat! În Python există o comandă care îi spune calculatorului: <strong>„Afișează asta pe ecran."</strong> Această comandă se numește <code>print()</code>.</p>

<p>Imaginează-ți că <code>print()</code> e ca un megafon — orice pui în el, calculatorul îl va „rosti" (afișa pe ecran).</p>

<p>Apasă <strong>Run</strong> pentru a rula primul tău program:</p>

<div data-code-exercise="" startercode="print(\'Zdravo, svete!\')" instructions="Apasă butonul Run. Acesta este primul tău program! Uită-te ce apare mai jos."></div>

<p>Bravo! Tocmai ai rulat primul tău program! 🎉 Hai să înțelegem ce s-a întâmplat:</p>

<ul>
<li><code>print</code> — numele comenzii (înseamnă „afișează")</li>
<li><code>(</code> și <code>)</code> — paranteze în care punem ceea ce vrem să afișăm</li>
<li><code>\'Zdravo, svete!\'</code> — textul pe care am vrut să apară pe ecran</li>
</ul>

<h2>De ce avem nevoie de ghilimele?</h2>

<p>Observă că am pus textul între ghilimele: <code>\'Zdravo, svete!\'</code></p>

<p>De ce? Pentru că calculatorul trebuie să știe diferența între <strong>comenzi</strong> (pe care le execută) și <strong>text</strong> (care doar trebuie afișat). Ghilimelele sunt ca un semnal: „Acesta este text, nu-l executa, doar afișează-l!"</p>

<p>Poți folosi fie ghilimele simple <code>\'așa\'</code> fie duble <code>"așa"</code> — ambele sunt corecte.</p>

<div data-code-exercise="" startercode="print(\'Ovo je sa jednostrukim navodnicima\')&#10;print(&quot;Ovo je sa dvostrukim navodnicima&quot;)" instructions="Rulează programul. Ambele moduri funcționează exact la fel!"></div>

<h2>Mai multe comenzi în serie</h2>

<p>Programul poate avea oricâte comenzi dorești! Calculatorul le citește <strong>de sus în jos</strong>, așa cum citești o carte — rând cu rând, de la primul până la ultimul.</p>

<div data-code-exercise="" startercode="print(\'Zdravo!\')&#10;print(\'Ja sam kompjuter.\')&#10;print(\'Uradicu sve sto mi kazes.\')" instructions="Rulează programul. Observă cum calculatorul afișează rând cu rând, de sus în jos."></div>

<p>Vezi? Trei comenzi, trei rânduri de text pe ecran. Fiecare <code>print()</code> afișează text și trece automat la un rând nou.</p>

<h2>Rând gol</h2>

<p>Dacă vrei un rând gol între texte (pentru un aspect mai frumos), folosește <code>print()</code> fără nimic înăuntru:</p>

<div data-code-exercise="" startercode="print(\'Prva recenica.\')&#10;print()&#10;print(\'Druga recenica posle praznog reda.\')" instructions="Rulează și uită-te cum print() fără text creează un rând gol."></div>

<h2>Încearcă singur! — Scrie-ți numele</h2>

<p>Acum este rândul tău! Schimbă textul din programul de mai jos pentru ca calculatorul să afișeze <strong>numele tău</strong>:</p>

<div data-code-exercise="" startercode="print(\'ovde napisi svoje ime\')" instructions="Șterge textul \'ovde napisi svoje ime\' și în loc scrie numele tău adevărat. Nu uita ghilimelele!"></div>

<h2>Încearcă singur! — Mini poveste</h2>

<p>Creează un program care afișează 5 rânduri — o scurtă poveste despre tine! De exemplu, cum te cheamă, câți ani ai, ce îți place să faci, care este materia ta preferată, ce vrei să fii când vei fi mare.</p>

<div data-code-exercise="" startercode="print(\'Ja sam ...\')&#10;print(\'Imam ... godina.\')&#10;print(\'Volim da ...\')&#10;print(\'Omiljeni predmet mi je ...\')&#10;print(\'Kad porastem, zelim da budem ...\')" instructions="Înlocuiește ... cu răspunsurile tale. Fiecare rând trebuie să conțină datele tale!"></div>

<h2>Încearcă singur! — Fă un desen din litere</h2>

<p>Poți folosi <code>print()</code> și pentru a face „desene" din litere! Încearcă asta:</p>

<div data-code-exercise="" startercode="print(\'  *  \')&#10;print(\' *** \')&#10;print(\'*****\')&#10;print(\' *** \')&#10;print(\'  *  \')" instructions="Rulează și uită-te la formă! Încearcă să schimbi steluțele cu altă literă sau să faci o altă formă."></div>

<h2>Ce am învățat? 📝</h2>

<ul>
<li><strong>Programarea</strong> = scrierea unor instrucțiuni precise pentru calculator, pas cu pas</li>
<li><strong>Python</strong> = limbajul de programare pe care-l vom folosi, ușor de învățat</li>
<li><strong>print()</strong> = comanda care afișează text pe ecran</li>
<li>Textul îl punem întotdeauna între <strong>ghilimele</strong> (simple sau duble)</li>
<li>Calculatorul execută comenzile <strong>de sus în jos</strong>, una câte una</li>
<li><code>print()</code> fără text creează un <strong>rând gol</strong></li>
</ul>

<p>În lecția următoare vei învăța cum să-ți faci programele și mai frumoase și mai organizate!</p><h2>Temă pentru acasă: Prezintă-te!</h2>
<p>Scrie un program care afișează <strong>5 propoziții despre tine</strong>. Programul trebuie să afișeze:</p>
<ol>
<li>Numele și prenumele tău</li>
<li>Câți ani ai</li>
<li>În ce clasă ești</li>
<li>Care este materia ta preferată la școală</li>
<li>Ce îți place să faci în timpul liber</li>
</ol>
<p>Fiecare propoziție trebuie să fie într-un <code>print()</code> separat. Formatează frumos cu antet și linii.</p><div data-code-exercise="" startercode="# DOMACI ZADATAK: Predstavi se!&#10;# Napravi program koji ispisuje 5 recenica o tebi&#10;# Koristi print() za svaku recenicu&#10;&#10;print(\'=============================\')&#10;print(\'       O MENI\')&#10;print(\'=============================\')&#10;# Tvoj kod ide ovde:&#10;&#10;&#10;&#10;print(\'=============================\')&#10;" instructions="Înlocuiește comentariile cu comenzi print() care afișează datele tale. Fă să arate frumos!"></div>';

// --- LESSON 39: Primul tău program adevărat ---
$lessonContent[39] = '<h1>Primul tău program adevărat</h1>

<p>Deja știi să folosești <code>print()</code> pentru a afișa text. Acum vom învăța cum să facă programele tale să arate <strong>profesional</strong>, și vom descoperi de ce erorile sunt de fapt cei mai buni <strong>prieteni ai tăi</strong>!</p>

<h2>Decorarea afișajului</h2>

<p>Imaginează-ți că faci un poster sau o invitație. Nu ai scrie doar text — ai adăuga niște linii, chenare, decorațiuni. În Python poți face la fel!</p>

<p>Există un truc: dacă înmulțești textul cu un număr, Python îl va repeta de atâtea ori:</p>

<div data-code-exercise="" startercode="print(\'=\' * 30)&#10;print(\'   MOJ PRVI PROGRAM\')&#10;print(\'=\' * 30)" instructions="Rulează și uită-te cum arată! Semnul = se repetă de 30 de ori. Încearcă să schimbi numărul sau semnul."></div>

<p>Trucul este simplu: <code>\'=\' * 30</code> înseamnă „repetă semnul = de treizeci de ori". Poți folosi orice semn: <code>\'-\'</code>, <code>\'*\'</code>, <code>\'~\'</code>, <code>\'#\'</code>...</p>

<div data-code-exercise="" startercode="print(\'-\' * 30)&#10;print(\'*\' * 30)&#10;print(\'~\' * 30)&#10;print(\'#\' * 30)" instructions="Uită-te cum arată diferite semne. Care ți se pare cel mai frumos?"></div>

<h2>Program adevărat: Carte de vizită</h2>

<p>Hai să facem o carte de vizită adevărată — ca cele pe care le au adulții, dar a ta!</p>

<div data-code-exercise="" startercode="print(\'+\' + \'-\' * 28 + \'+\')&#10;print(\'|  Ime: Marko Markovic       |\')&#10;print(\'|  Skola: OŠ Vuk Karadzic    |\')&#10;print(\'|  Razred: 6-1               |\')&#10;print(\'|  Hobi: programiranje!      |\')&#10;print(\'+\' + \'-\' * 28 + \'+\')" instructions="Înlocuiește datele cu numele tău, școala, clasa și hobby-ul tău. Încearcă să faci chenarul să arate frumos!"></div>

<h2>ERORILE — noul tău cel mai bun prieten!</h2>

<p>Acum vine <strong>cel mai important lucru</strong> din tot cursul. Serios!</p>

<p>Când programul nu funcționează, primești un mesaj de eroare — text roșu care arată înfricoșător. Dar de fapt, acel mesaj îți <strong>spune exact unde este problema</strong>! Este ca și cum profesoara ți-ar încercui greșeala în test și ar scrie „uită-te aici".</p>

<p><strong>Chiar și cei mai buni programatori din lume fac greșeli în fiecare zi.</strong> Diferența dintre un începător și un profesionist nu este cine face mai puține greșeli — ci cine le găsește și le corectează mai repede!</p>

<h3>Eroare #1: Ghilimeaua uitată</h3>

<div data-code-exercise="" startercode="print(\'Zdravo svete!)" instructions="Rulează acest program. Are o eroare intenționată! Uită-te la mesajul de eroare — încearcă să-l înțelegi, apoi repară programul."></div>

<p>Vezi eroarea? Lipsește ghilimeaua de la sfârșitul textului. Python spune <code>SyntaxError</code> — asta înseamnă „nu înțeleg ce ai scris". Adaugă <code>\'</code> după semnul exclamării pentru a repara!</p>

<h3>Eroare #2: Paranteza uitată</h3>

<div data-code-exercise="" startercode="print(\'Zdravo svete!\'" instructions="Rulează și uită-te la eroare. Ce lipsește? Repară!"></div>

<p>Lipsește paranteza închisă <code>)</code> la sfârșit! Fiecare paranteză deschisă trebuie închisă.</p>

<h3>Eroare #3: Literă mare (Print în loc de print)</h3>

<div data-code-exercise="" startercode="Print(\'Zdravo svete!\')" instructions="Rulează și uită-te la eroare. Python face diferența între litere mari și mici!"></div>

<p>Python spune <code>NameError</code> — nu cunoaște comanda <code>Print</code> cu P mare. Comanda este <code>print</code> cu <strong>p mic</strong>. Python întotdeauna face diferența între litere mari și mici!</p>

<h3>Cum citim mesajele de eroare?</h3>

<p>Fiecare mesaj de eroare conține două lucruri importante:</p>
<ol>
<li><strong>Numărul rândului</strong> — unde s-a produs eroarea (de ex. <code>line 1</code>)</li>
<li><strong>Tipul erorii</strong> — care este problema (<code>SyntaxError</code>, <code>NameError</code>...)</li>
</ol>

<p>Când primești o eroare: nu intri în panică! Te uiți la numărul rândului, te uiți la acel rând, și cauți ce lipsește sau ce este scris greșit.</p>

<h2>Comentarii — mesaje pentru tine însuți</h2>

<p>Uneori vrei să lași o <strong>notiță</strong> în programul tău — un memento despre ce face acea parte de cod. Pentru asta folosim semnul <code>#</code>.</p>

<p>Tot ce este după <code>#</code> pe acel rând, calculatorul <strong>ignoră complet</strong>. Este ca și cum ai scrie cu creionul pe marginea caietului — tu vezi, dar profesoara nu citește.</p>

<div data-code-exercise="" startercode="# Ovo je komentar, kompjuter ga ignorise&#10;print(\'Zdravo!\')  # i ovo je komentar&#10;# print(\'Ovo se nece ispisati jer je ceo red komentar\')&#10;print(\'Cao!\')" instructions="Rulează programul. Observă că comentariile nu apar în afișaj. Doar comenzile print() se execută!"></div>

<h2>Încearcă singur! — Meniu pentru restaurant</h2>

<p>Creează un meniu frumos pentru un restaurant imaginar! Folosește decorațiuni, rânduri goale și comentarii:</p>

<div data-code-exercise="" startercode="# Moj restoran&#10;print(\'*\' * 30)&#10;print(\'   RESTORAN KOD MARKA\')&#10;print(\'*\' * 30)&#10;print()&#10;print(\'--- Glavna jela ---\')&#10;print(\'Pica Margarita .... 800 din\')&#10;print(\'Pasta Bolonjeze ... 700 din\')&#10;print()&#10;print(\'--- Deserti ---\')&#10;print(\'Sladoled .......... 300 din\')&#10;print()&#10;print(\'*\' * 30)&#10;print(\'   Prijatno!\')" instructions="Schimbă numele restaurantului, adaugă mâncărurile tale preferate și prețuri. Încearcă să fie cât mai frumos!"></div>

<h2>Încearcă singur! — Poster pentru film sau joc</h2>

<p>Creează un poster pentru filmul sau jocul tău preferat:</p>

<div data-code-exercise="" startercode="print(\'#\' * 35)&#10;print(\'#\' + \' \' * 33 + \'#\')&#10;print(\'#   Naziv: [tvoj film/igrica]   #\')&#10;print(\'#   Zanr: [akcija/komedija...]   #\')&#10;print(\'#   Ocena: [1-10]                #\')&#10;print(\'#\' + \' \' * 33 + \'#\')&#10;print(\'#\' * 35)" instructions="Completează datele despre filmul sau jocul tău preferat. Adaugă mai multe rânduri dacă dorești!"></div>

<h2>Ce am învățat? 📝</h2>

<ul>
<li>Înmulțirea textului cu un număr: <code>\'=\' * 20</code> repetă semnul de 20 de ori</li>
<li><strong>Erorile sunt normale</strong> iar mesajele de eroare ne <strong>ajută</strong> să le găsim</li>
<li>Trei erori frecvente: ghilimeaua uitată, paranteza uitată, litera mare</li>
<li><strong>Comentariile</strong> (<code>#</code>) sunt notițe în cod pe care calculatorul le ignoră</li>
</ul>

<p>În lecția următoare vei învăța despre <strong>variabile</strong> — cutii în care poți pune date și le poți folosi de câte ori dorești!</p><h2>Temă pentru acasă: Creează un poster</h2>
<p>Creează un program care afișează <strong>un poster pentru filmul, serialul sau jocul tău preferat</strong>. Posterul trebuie să conțină:</p>
<ol>
<li>Titlul filmului/serialului/jocului (cu litere mari folosind LITERE MARI în text)</li>
<li>Scurtă descriere în 2-3 propoziții</li>
<li>Nota ta de la 1 la 5 stele (scrie * pentru fiecare stea)</li>
<li>De ce le recomanzi altora să vadă/joace</li>
</ol>
<p>Folosește <code>print(\'*\' * 30)</code> pentru linii decorative și <code>print()</code> pentru rânduri goale.</p><div data-code-exercise="" startercode="# DOMACI ZADATAK: Poster za omiljeni film/seriju/igricu&#10;# Koristi print() za svaki red&#10;# Koristi print(\'*\' * 30) za dekorativne linije&#10;# Koristi print() za prazan red&#10;&#10;print(\'*\' * 30)&#10;# Tvoj kod:&#10;&#10;&#10;&#10;print(\'*\' * 30)" instructions="Creează un poster frumos. Folosește * pentru linii, rânduri goale pentru spațiu, și # pentru comentarii."></div>';

// --- LESSON 40: Ce sunt variabilele? ---
$lessonContent[40] = '<h1>Ce sunt variabilele?</h1>

<p>Hai să gândim așa. Când joci un joc, ai un <strong>rezultat</strong> — un număr de puncte. Acel număr se schimbă în timp ce joci: la început este 0, apoi 10, apoi 50... Dar se numește mereu la fel — „rezultat".</p>

<p>Ei bine, aceasta este o variabilă! O variabilă este ca o <strong>cutie cu nume</strong>. Cutia se numește mereu la fel, dar ceea ce este înăuntru se poate schimba.</p>

<p>Imaginează-ți că ai trei cutii:</p>
<ul>
<li>Pe prima cutie scrie <strong>ime</strong> — o deschizi, înăuntru scrie „Ana"</li>
<li>Pe a doua scrie <strong>godine</strong> — înăuntru este numărul 12</li>
<li>Pe a treia scrie <strong>razred</strong> — înăuntru scrie „6"</li>
</ul>

<p>În Python, cutiile le facem așa de simplu:</p>

<div data-code-exercise="" startercode="# Pravimo tri kutije (promenljive)&#10;ime = \'Ana\'&#10;godine = 12&#10;razred = \'6\'&#10;&#10;# Pogledajmo šta je u kutijama&#10;print(ime)&#10;print(godine)&#10;print(razred)" instructions="Apasă Run. Vezi — Python a memorat ce am pus în fiecare cutie și a afișat pe ecran."></div>

<p>Vezi ce s-a întâmplat? Am scris <code>ime = \'Ana\'</code> și Python a memorat că cutia <code>ime</code> conține textul „Ana". Când scriem <code>print(ime)</code>, Python deschide acea cutie și afișează ce este înăuntru.</p>

<h2>Cum se creează o variabilă?</h2>

<p>Rețeta este mereu aceeași:</p>
<pre><code>numele_cutiei = valoarea</code></pre>

<p>În partea stângă este <strong>numele</strong> cutiei, apoi vine semnul <strong>=</strong> (asta înseamnă „pune în cutie"), iar în partea dreaptă este <strong>valoarea</strong> pe care o punem înăuntru.</p>

<div data-code-exercise="" startercode="# Probaj da napraviš svoje promenljive:&#10;moje_ime = \'ovde napiši svoje ime\'&#10;moj_razred = \'ovde napiši svoj razred\'&#10;moja_godina = 0  # ovde stavi koliko imaš godina&#10;&#10;print(\'Ja sam\', moje_ime)&#10;print(\'Idem u\', moj_razred, \'razred\')&#10;print(\'Imam\', moja_godina, \'godina\')" instructions="Înlocuiește valorile cu datele tale. Numărul de ani scrie-l FĂRĂ ghilimele pentru că este un număr, nu text!"></div>

<h2>De ce se numesc VARIABILE?</h2>

<p>Pentru că le poți <strong>schimba</strong> valoarea! Imaginează-ți că joci un joc și colectezi puncte:</p>

<div data-code-exercise="" startercode="bodovi = 0&#10;print(f\'Počinjem igru! Imam {bodovi} bodova.\')&#10;&#10;# Rešio sam prvi zadatak, dobijam 10 bodova&#10;bodovi = 10&#10;print(f\'Rešio sam prvi zadatak! Sada imam {bodovi} bodova.\')&#10;&#10;# Rešio sam drugi zadatak, dobijam još 15&#10;bodovi = bodovi + 15&#10;print(f\'Rešio sam i drugi! Sada imam {bodovi} bodova.\')&#10;&#10;# Bonus: dupliram bodove!&#10;bodovi = bodovi * 2&#10;print(f\'Bonus! Sada imam {bodovi} bodova!\')" instructions="Rulează și urmărește cum se schimbă punctele. Fii atent la linia bodovi = bodovi + 15 — aceasta înseamnă: ia valoarea veche, adaugă 15, și pune înapoi în cutie."></div>

<p>Acest lucru este foarte important de înțeles: <code>bodovi = bodovi + 15</code> NU înseamnă că punctele sunt egale cu punctele plus 15 (ar fi o expresie matematică absurdă). În programare, <code>=</code> înseamnă <strong>„pune în cutie"</strong>. Deci această linie spune:</p>
<ol>
<li>Uită-te câte puncte ai în prezent (25)</li>
<li>Adaugă 15 la asta (25 + 15 = 40)</li>
<li>Pune noul rezultat (40) înapoi în cutia „bodovi"</li>
</ol>

<h2>Cum combinăm textul cu variabilele?</h2>

<p>Deja ai observat că folosim <code>f</code> în fața ghilimelelor. Acesta este <strong>f-string</strong> — cel mai ușor mod de a pune variabile în text. Pui variabilele în acolade <code>{}</code>:</p>

<div data-code-exercise="" startercode="ime = \'Marko\'&#10;godine = 13&#10;sport = \'košarka\'&#10;&#10;# f-string: stavi f ispred navodnika, promenljive u {}&#10;print(f\'Zdravo! Ja sam {ime}.\')&#10;print(f\'Imam {godine} godina.\')&#10;print(f\'Volim da igram {sport}.\')&#10;print()&#10;print(f\'{ime} ima {godine} godina i igra {sport}.\')" instructions="Schimbă numele, anii și sportul. Uită-te cum {} inserează automat valoarea variabilei în text."></div>

<p>Există și alte moduri, dar f-string este de departe cel mai ușor. Programatorii profesioniști îl folosesc cel mai mult.</p>

<h2>Reguli pentru numele variabilelor</h2>

<p>Ca la școală — există reguli! Numele variabilelor:</p>

<table>
<tr><th>Regulă</th><th>Corect</th><th>Incorect</th></tr>
<tr><td>Se folosesc litere mici</td><td><code>ime</code>, <code>godine</code></td><td><code>Ime</code>, <code>GODINE</code></td></tr>
<tr><td>Mai multe cuvinte — liniuța de jos</td><td><code>omiljeni_predmet</code></td><td><code>omiljeni predmet</code></td></tr>
<tr><td>Nu începe cu număr</td><td><code>razred6</code></td><td><code>6razred</code></td></tr>
<tr><td>Fără spații</td><td><code>moje_ime</code></td><td><code>moje ime</code></td></tr>
<tr><td>Fără caractere speciale</td><td><code>broj_telefona</code></td><td><code>broj-telefona</code></td></tr>
</table>

<div data-code-exercise="" startercode="# Ovo radi:&#10;moj_broj = 42&#10;print(moj_broj)&#10;&#10;# A ovo neće raditi — odkomentariši i probaj:&#10;# moj broj = 42     # razmak u imenu&#10;# 1broj = 42        # počinje brojem" instructions="Rulează programul, apoi decomentează (șterge #) liniile care sunt greșite și uită-te ce eroare primești."></div>

<h2>Rândul tău: Creează un profil!</h2>

<p>Creează un program care stochează date despre cel mai bun prieten sau prietenă a ta în variabile, apoi le afișează frumos folosind f-string.</p>

<div data-code-exercise="" startercode="# Popuni podatke o najboljem drugu/drugarici&#10;ime_druga = \'...\'&#10;godine_druga = 0&#10;omiljeni_sport = \'...\'&#10;omiljena_hrana = \'...\'&#10;omiljeni_predmet = \'...\'&#10;&#10;# Ispiši sve koristeći f-string&#10;print(\'=== PROFIL MOGA DRUGA ===\')&#10;print()&#10;print(f\'Ime: {ime_druga}\')&#10;# Dodaj ispis za ostale promenljive korišćenjem f-stringa&#10;# print(f\'Godine: {...}\')&#10;# print(f\'Sport: {...}\')&#10;# itd.&#10;print()&#10;print(\'========================\')" instructions="Completează toate variabilele cu date reale și adaugă print(f\'...\') pentru fiecare. Folosește f-string!"></div>

<h2>Ce am învățat?</h2>
<ul>
<li><strong>Variabila</strong> este o cutie cu nume în care punem o valoare</li>
<li>Le creăm cu: <code>nume = valoare</code></li>
<li>Semnul <code>=</code> înseamnă „pune în cutie", NU „egal"</li>
<li>Valoarea se poate schimba: <code>bodovi = bodovi + 10</code></li>
<li><strong>f-string</strong> este cel mai ușor mod de a pune variabile în text: <code>f\'Imam {godine} godina\'</code></li>
<li>Numele variabilelor: litere mici, fără spații, nu încep cu număr</li>
</ul><h2>Temă pentru acasă: Stochează date</h2>
<p>Creează un program care folosește <strong>cel puțin 6 variabile</strong> pentru a descrie animalul tău de companie (sau unul imaginar dacă nu ai). Folosește f-string pentru afișare.</p>
<p>Variabilele trebuie să fie:</p>
<ol>
<li><code>vrsta</code> — de ex. „câine", „pisică", „hamster"</li>
<li><code>ime_ljubimca</code> — numele animalului tău</li>
<li><code>godine_ljubimca</code> — câți ani are (număr!)</li>
<li><code>boja</code> — ce culoare are</li>
<li><code>tezina</code> — cât cântărește în kg (număr zecimal!)</li>
<li><code>voli_da</code> — ce îi place să facă</li>
</ol><div data-code-exercise="" startercode="# DOMACI ZADATAK: Moj ljubimac&#10;# Napravi 6 promenljivih i ispisi ih sa f-stringom&#10;&#10;vrsta = \'\'&#10;ime_ljubimca = \'\'&#10;godine_ljubimca = 0&#10;boja = \'\'&#10;tezina = 0.0&#10;voli_da = \'\'&#10;&#10;# Ispisi sve koristeci f-string:&#10;print(f\'=== Moj {vrsta} ===\')&#10;# Dodaj ispis za svaku promenljivu&#10;" instructions="Completează toate variabilele și adaugă f-string print pentru fiecare. Folosește tipuri diferite: str, int, float!"></div>';

// --- LESSON 41: Tipuri de date — numere și text ---
$lessonContent[41] = '<h1>Tipuri de date — numere și text</h1>

<p>Știi că variabilele stochează date ca niște cutii. Dar nu toate cutiile sunt la fel! Unele stochează numere, altele text. Hai să învățăm ce <strong>tipuri de date</strong> cunoaște Python.</p>

<h2>Trei tipuri de date</h2>

<p>Imaginează-ți că ai trei cutii diferite:</p>

<ul>
<li><strong>int</strong> (numere întregi) — ca atunci când numeri mere: 1, 2, 3, 42, 100. Fără zecimale!</li>
<li><strong>float</strong> (numere zecimale) — ca temperatura: 36.6, sau prețul: 2.50. Are punct!</li>
<li><strong>str</strong> (text / string) — orice între ghilimele: \'Salut\', "Marko", \'123\'</li>
</ul>

<div data-code-exercise="" startercode="# Celi brojevi (int)&#10;jabuke = 5&#10;print(jabuke)&#10;&#10;# Decimalni brojevi (float)&#10;temperatura = 36.6&#10;print(temperatura)&#10;&#10;# Tekst (str)&#10;ime = \'Marko\'&#10;print(ime)" instructions="Rulează programul. Trei variabile, trei tipuri diferite de date!"></div>

<h2>Marea confuzie: \'100\' versus 100</h2>

<p>Acesta este <strong>cel mai important lucru</strong> din această lecție, așa că citește cu atenție!</p>

<p>Imaginează-ți asta:</p>
<ul>
<li><code>100</code> (fără ghilimele) — acesta este un <strong>număr</strong>. Ca și cum ai avea 100 de mere pe masă. Poți să le aduni, scazi, împarți.</li>
<li><code>\'100\'</code> (cu ghilimele) — acesta este <strong>text</strong>. Ca și cum ai fi scris „100" pe hârtie. Este un desen al numărului, nu un număr adevărat!</li>
</ul>

<p>Uită-te ce se întâmplă când le adunăm:</p>

<div data-code-exercise="" startercode="# Sabiranje BROJEVA&#10;print(100 + 100)&#10;&#10;# Sabiranje TEKSTA&#10;print(\'100\' + \'100\')" instructions="Rulează și uită-te la diferență! Numerele se adună matematic. Textul se lipește unul de altul!"></div>

<p>Vezi? <code>100 + 100 = 200</code> (matematică), dar <code>\'100\' + \'100\' = \'100100\'</code> (lipirea textului)! La text, <code>+</code> nu adună — ci <strong>unește</strong> textul unul lângă altul.</p>

<h2>type() — întreabă Python care este tipul</h2>

<p>Dacă nu ești sigur/sigură care este tipul unei valori, întreabă Python! Comanda <code>type()</code> îți spune:</p>

<div data-code-exercise="" startercode="print(type(42))&#10;print(type(3.14))&#10;print(type(\'Zdravo\'))&#10;print(type(\'100\'))" instructions="Rulează și uită-te la răspunsuri. Observă că \'100\' este de tip str (text), nu int (număr)!"></div>

<p>Python răspunde: <code>&lt;class \'int\'&gt;</code>, <code>&lt;class \'float\'&gt;</code>, sau <code>&lt;class \'str\'&gt;</code>.</p>

<h2>Conversia tipurilor</h2>

<p>Uneori trebuie să convertești un tip în altul. Imaginează-ți asta ca turnarea dintr-o cutie în alta:</p>

<ul>
<li><code>int()</code> — convertește în număr întreg (dacă se poate)</li>
<li><code>float()</code> — convertește în număr zecimal</li>
<li><code>str()</code> — convertește în text</li>
</ul>

<div data-code-exercise="" startercode="# Tekst u broj&#10;tekst = \'50\'&#10;broj = int(tekst)&#10;print(broj + 10)&#10;&#10;# Broj u tekst&#10;godine = 12&#10;poruka = \'Imam \' + str(godine) + \' godina\'&#10;print(poruka)" instructions="Rulează programul. Vezi cum int() convertește textul în număr, iar str() convertește numărul în text?"></div>

<h2>Quiz — ghicește tipul!</h2>

<p>Încearcă să ghicești care este tipul fiecărei valori <strong>înainte</strong> de a rula programul:</p>

<div data-code-exercise="" startercode="# Pogodi tip svake vrednosti!&#10;print(type(42))       # int, float ili str?&#10;print(type(\'42\'))     # int, float ili str?&#10;print(type(3.0))      # int, float ili str?&#10;print(type(\'Zdravo\')) # int, float ili str?&#10;print(type(True))     # iznenadjenje!" instructions="Mai întâi ghicește răspunsurile în minte, apoi rulează pentru a verifica! Câte ai ghicit?"></div>

<h2>Încearcă singur! — Mini digitron</h2>

<p>Creează un program care adună două numere pe care le scrii în cod:</p>

<div data-code-exercise="" startercode="# Promeni ove brojeve kako zelis&#10;prvi_broj = 25&#10;drugi_broj = 17&#10;&#10;zbir = prvi_broj + drugi_broj&#10;razlika = prvi_broj - drugi_broj&#10;&#10;print(\'Prvi broj: \' + str(prvi_broj))&#10;print(\'Drugi broj: \' + str(drugi_broj))&#10;print(\'Zbir: \' + str(zbir))&#10;print(\'Razlika: \' + str(razlika))" instructions="Schimbă valorile variabilelor prvi_broj și drugi_broj. Încearcă numere diferite!"></div>

<h2>Ce am învățat? 📝</h2>

<ul>
<li><strong>int</strong> = numere întregi (5, 42, 100)</li>
<li><strong>float</strong> = numere zecimale (3.14, 36.6)</li>
<li><strong>str</strong> = text (\'Salut\', \'100\')</li>
<li><code>\'100\'</code> este TEXT, <code>100</code> este NUMĂR — aceasta este o diferență mare!</li>
<li><code>type()</code> verifică tipul datei</li>
<li><code>int()</code>, <code>float()</code>, <code>str()</code> convertesc între tipuri</li>
</ul>

<p>În lecția următoare vei învăța cum să conversezi cu calculatorul — cum poate utilizatorul să <strong>introducă</strong> date în timp ce programul rulează!</p><h2>Temă pentru acasă: Detectivul tipurilor</h2>
<p>Creează un program care are <strong>9 variabile</strong> — câte 3 de fiecare tip (int, float, str). Pentru fiecare variabilă afișează valoarea și tipul.</p>
<p>De exemplu:</p>
<ul>
<li>3 întregi (int): numărul de elevi, numărul de pagini al cărții, temperatura în grade întregi</li>
<li>3 zecimale (float): media notelor, prețul înghețatei, greutatea în kg</li>
<li>3 texte (str): numele orașului, numele școlii, citatul preferat</li>
</ul>
<p>Pentru fiecare afișează: valoarea, apoi tipul folosind <code>type()</code>.</p><div data-code-exercise="" startercode="# DOMACI ZADATAK: Detektiv tipova&#10;# Napravi po 3 promenljive svakog tipa&#10;&#10;# 3 cela broja (int):&#10;broj_ucenika = 0&#10;# dodaj jos 2...&#10;&#10;# 3 decimalna broja (float):&#10;prosecna_ocena = 0.0&#10;# dodaj jos 2...&#10;&#10;# 3 teksta (str):&#10;ime_grada = \'\'&#10;# dodaj jos 2...&#10;&#10;# Ispisi svaku sa tipom:&#10;print(f\'{broj_ucenika} — tip: {type(broj_ucenika)}\')&#10;# Dodaj za ostale...&#10;" instructions="Creează 9 variabile (3 int, 3 float, 3 str) și pentru fiecare afișează valoarea și tipul."></div>';

// --- LESSON 42: Discuție cu calculatorul — input() ---
$lessonContent[42] = '<h1>Discuție cu calculatorul — input()</h1>

<p>Până acum noi am scris toate datele dinainte. Dar ce faci dacă vrei ca <strong>utilizatorul</strong> să tasteze ceva în timp ce programul rulează? Pentru asta există comanda <code>input()</code>!</p>

<h2>Calculatorul întreabă, utilizatorul răspunde</h2>

<p>Comanda <code>input()</code> funcționează așa:</p>
<ol>
<li>Calculatorul afișează întrebarea pe ecran</li>
<li>Programul se <strong>oprește și așteaptă</strong> ca utilizatorul să tasteze ceva</li>
<li>Când utilizatorul apasă Enter, răspunsul se salvează într-o variabilă</li>
</ol>

<div data-code-exercise="" startercode="ime = input(\'Kako se zoves? \')&#10;print(\'Zdravo, \' + ime + \'!\')" instructions="Rulează programul. Calculatorul te va întreba de nume — tastează-l și apasă Enter!"></div>

<p>Vezi cât de ușor este? <code>input(\'întrebare\')</code> afișează întrebarea și așteaptă răspunsul.</p>

<h2>CAPCANĂ: input() returnează mereu TEXT!</h2>

<p>Acesta este un lucru <strong>foarte important</strong> de reținut: tot ce tastează utilizatorul, <code>input()</code> tratează ca <strong>text</strong>. Chiar dacă utilizatorul tastează un număr!</p>

<p>Uită-te ce se întâmplă:</p>

<div data-code-exercise="" startercode="godine = input(\'Koliko imas godina? \')&#10;print(type(godine))&#10;# godine je TEKST, ne broj!&#10;# print(godine + 1)  # OVO BI BILA GRESKA!" instructions="Rulează și tastează un număr. Uită-te la tip — va fi str (text), nu int (număr)!"></div>

<p>Chiar dacă tastezi <code>12</code>, Python vede ca text <code>\'12\'</code>, nu ca număr <code>12</code>. De aceea nu poți calcula imediat cu asta!</p>

<h2>Soluție: convertește în număr!</h2>

<p>Să ne amintim de lecția trecută — <code>int()</code> convertește textul în număr întreg, iar <code>float()</code> în zecimal. Combinăm asta cu <code>input()</code>:</p>

<div data-code-exercise="" startercode="# Za tekst — ne treba nista&#10;ime = input(\'Ime: \')&#10;&#10;# Za ceo broj — omotaj sa int()&#10;godine = int(input(\'Godine: \'))&#10;&#10;# Za decimalan broj — omotaj sa float()&#10;visina = float(input(\'Visina u metrima (npr. 1.55): \'))&#10;&#10;print(\'Zdravo, \' + ime + \'!\')&#10;print(\'Imas \' + str(godine) + \' godina.\')&#10;print(\'Visok/a si \' + str(visina) + \'m.\')" instructions="Rulează și răspunde la întrebări. Acum programul poate lucra cu numere!"></div>

<h2>Rețetă de reținut 📋</h2>

<p>Reține aceste trei modele:</p>

<ul>
<li>Pentru <strong>text</strong>: <code>variabila = input(\'întrebare\')</code></li>
<li>Pentru <strong>număr întreg</strong>: <code>variabila = int(input(\'întrebare\'))</code></li>
<li>Pentru <strong>număr zecimal</strong>: <code>variabila = float(input(\'întrebare\'))</code></li>
</ul>

<h2>Încearcă singur! — Poveste nebună (Mad Libs)</h2>

<p>Creează un program care cere utilizatorului cuvinte, apoi face o poveste amuzantă cu acele cuvinte!</p>

<div data-code-exercise="" startercode="# Pitaj za reci&#10;ime = input(\'Unesi neko ime: \')&#10;zivotinja = input(\'Unesi neku zivotinju: \')&#10;broj = input(\'Unesi neki broj: \')&#10;&#10;# Napravi smesnu pricu&#10;print()&#10;print(\'Jednog dana, \' + ime + \' je setao/la ulicom.\')&#10;print(\'Odjednom, ogromna \' + zivotinja + \' je iskocila!\')&#10;print(ime + \' je pobegao/la i trcao/la \' + broj + \' kilometara.\')&#10;print(\'Kraj!\')" instructions="Rulează și răspunde la întrebări. Cu cât introduci cuvinte mai nebunești, cu atât povestea e mai amuzantă! Adaugă mai multe întrebări și rânduri de poveste."></div>

<h2>Încearcă singur! — Digitron de vârstă</h2>

<p>Creează un program care cere numele și anul nașterii, apoi calculează câți ani ai:</p>

<div data-code-exercise="" startercode="ime = input(\'Kako se zoves? \')&#10;godina_rodjenja = int(input(\'Koje si godine rodjen/a? \'))&#10;&#10;godine = 2026 - godina_rodjenja&#10;&#10;print(\'Zdravo, \' + ime + \'!\')&#10;print(\'Ti imas \' + str(godine) + \' godina.\')" instructions="Rulează programul și introdu datele tale. A calculat corect vârsta?"></div>

<h2>Ce am învățat? 📝</h2>

<ul>
<li><code>input()</code> cere utilizatorului date și așteaptă răspunsul</li>
<li><code>input()</code> <strong>returnează mereu text</strong> (str)</li>
<li>Pentru numere folosim <code>int(input())</code> sau <code>float(input())</code></li>
<li>Putem crea programe interactive care conversează cu utilizatorul!</li>
</ul>

<p>În lecția următoare vei învăța toate operațiile matematice din Python — vei deveni un adevărat digitron!</p><h2>Temă pentru acasă: Interviu</h2>
<p>Creează un program care conduce un <strong>interviu</strong> cu utilizatorul. Programul trebuie să:</p>
<ol>
<li>Ceară numele (text)</li>
<li>Ceară anul nașterii (număr) și să calculeze câți ani are</li>
<li>Ceară mâncarea preferată (text)</li>
<li>Ceară câte ore pe zi petrece la calculator (număr zecimal)</li>
<li>Calculeze câte ore pe săptămână înseamnă (ore * 7)</li>
</ol>
<p>La final afișează toate răspunsurile într-un format frumos folosind f-string.</p><div data-code-exercise="" startercode="# DOMACI ZADATAK: Intervju&#10;print(\'=== INTERVJU ===\')&#10;print()&#10;&#10;ime = input(\'Kako se zoves? \')&#10;# Dodaj pitanje za godinu rodjenja (int)&#10;# Izracunaj godine: 2026 - godina_rodjenja&#10;# Dodaj pitanje za omiljenu hranu (str)&#10;# Dodaj pitanje za sate za kompjuterom (float)&#10;# Izracunaj sate nedeljno&#10;&#10;print()&#10;print(\'=== REZULTATI ===\')&#10;print(f\'Ime: {ime}\')&#10;# Ispisi ostale rezultate sa f-stringom&#10;" instructions="Completează interviul — adaugă toate întrebările cu tipurile corecte (int, float, str) și afișează rezultatele."></div>';

// --- LESSON 43: Python ca un digitron ---
$lessonContent[43] = '<h1>Python ca un digitron</h1>

<p>Python poate calcula în locul tău! Și nu e vorba doar de adunare și scădere — Python știe și câteva trucuri pe care digitronul tău de buzunar nu le poate face. Hai să explorăm!</p>

<h2>Operații de bază</h2>

<p>Pe acestea sigur le cunoști de la matematică:</p>

<div data-code-exercise="" startercode="print(10 + 3)   # Sabiranje&#10;print(10 - 3)   # Oduzimanje&#10;print(10 * 3)   # Mnozenje&#10;print(10 / 3)   # Deljenje" instructions="Rulează și uită-te la rezultate. Observă că împărțirea dă un număr zecimal!"></div>

<p>Observă că <code>10 / 3</code> dă <code>3.3333...</code> — Python dă mereu rezultatul exact al împărțirii, cu zecimale.</p>

<h2>Operații speciale</h2>

<p>Acum vin trei operatori pe care poate nu-i cunoști, dar sunt <strong>super utili</strong>:</p>

<h3>// — Împărțire întreagă (de câte ori încape complet?)</h3>

<p>Imaginează-ți că ai 10 bomboane și le împarți la 3 prieteni. Fiecare primește <strong>3 întregi</strong> bomboane (nimeni nu primește jumătate de bomboană!).</p>

<div data-code-exercise="" startercode="print(10 // 3)  # Koliko celih puta 3 stane u 10?&#10;print(7 // 2)   # Koliko celih puta 2 stane u 7?&#10;print(20 // 6)  # Koliko celih puta 6 stane u 20?" instructions="Rulează și verifică rezultatele. // aruncă zecimalele și dă doar partea întreagă."></div>

<h3>% — Restul la împărțire (ce rămâne?)</h3>

<p>După împărțirea a 10 bomboane la 3 prieteni, fiecare primește 3, dar <strong>rămâne 1</strong> bomboană. Acesta este restul!</p>

<div data-code-exercise="" startercode="print(10 % 3)  # 10 podeljeno na 3: ostatak je 1&#10;print(7 % 2)   # 7 podeljeno na 2: ostatak je 1&#10;print(20 % 6)  # 20 podeljeno na 6: ostatak je 2" instructions="Rulează. Operatorul % dă ceea ce rămâne după împărțire."></div>

<h3>** — Ridicare la putere (înmulțește cu el însuși)</h3>

<div data-code-exercise="" startercode="print(2 ** 3)   # 2 * 2 * 2 = 8&#10;print(5 ** 2)   # 5 * 5 = 25&#10;print(10 ** 3)  # 10 * 10 * 10 = 1000" instructions="Rulează. Operatorul ** înmulțește numărul cu el însuși de mai multe ori."></div>

<h2>Ordinea operațiilor</h2>

<p>Aceleași reguli ca în matematică! Mai întâi înmulțirea și împărțirea, apoi adunarea și scăderea:</p>

<div data-code-exercise="" startercode="# Bez zagrada: prvo mnozenje, pa sabiranje&#10;print(2 + 3 * 4)    # = 2 + 12 = 14&#10;&#10;# Sa zagradama: prvo ono u zagradi&#10;print((2 + 3) * 4)  # = 5 * 4 = 20" instructions="Rulează și uită-te la diferență. Parantezele schimbă ordinea, exact ca în matematică!"></div>

<h2>Încearcă singur! — Digitron</h2>

<p>Creează un digitron care cere două numere și arată toate operațiile:</p>

<div data-code-exercise="" startercode="a = int(input(\'Unesi prvi broj: \'))&#10;b = int(input(\'Unesi drugi broj: \'))&#10;&#10;print(\'--- Rezultati ---\')&#10;print(str(a) + \' + \' + str(b) + \' = \' + str(a + b))&#10;print(str(a) + \' - \' + str(b) + \' = \' + str(a - b))&#10;print(str(a) + \' * \' + str(b) + \' = \' + str(a * b))&#10;print(str(a) + \' / \' + str(b) + \' = \' + str(a / b))" instructions="Rulează și introdu două numere. Programul arată toate operațiile! Încearcă numere diferite."></div>

<h2>Încearcă singur! — Perimetrul și aria dreptunghiului</h2>

<div data-code-exercise="" startercode="a = int(input(\'Duzina stranice a: \'))&#10;b = int(input(\'Duzina stranice b: \'))&#10;&#10;obim = 2 * (a + b)&#10;povrsina = a * b&#10;&#10;print(\'Obim pravougaonika: \' + str(obim))&#10;print(\'Povrsina pravougaonika: \' + str(povrsina))" instructions="Introdu lungimile laturilor. Programul calculează perimetrul și aria!"></div>

<h2>Încearcă singur! — Digitron de buzunar(ac)</h2>

<p>Dacă primești bani de buzunar în fiecare săptămână, cât vei avea într-o lună? Într-un an?</p>

<div data-code-exercise="" startercode="nedeljni = int(input(\'Koliko dzeparca dobijas nedeljno (u dinarima)? \'))&#10;&#10;mesecno = nedeljni * 4&#10;godisnje = nedeljni * 52&#10;&#10;print(\'Nedeljno: \' + str(nedeljni) + \' din\')&#10;print(\'Mesecno (4 nedelje): \' + str(mesecno) + \' din\')&#10;print(\'Godisnje (52 nedelje): \' + str(godisnje) + \' din\')&#10;print()&#10;print(\'Za godinu dana ces imati \' + str(godisnje) + \' dinara!\')" instructions="Introdu cât primești bani de buzunar. Uită-te cât se adună într-un an!"></div>

<h2>Ce am învățat? 📝</h2>

<ul>
<li><code>+</code> <code>-</code> <code>*</code> <code>/</code> — operații de bază</li>
<li><code>//</code> — împărțire întreagă (fără zecimale)</li>
<li><code>%</code> — restul la împărțire</li>
<li><code>**</code> — ridicare la putere</li>
<li>Parantezele schimbă ordinea operațiilor, la fel ca în matematică</li>
</ul>

<p>În lecția următoare vei învăța trucuri interesante cu textul — cum să-l inversezi, STRIGI, șoptești și multe altele!</p><h2>Temă pentru acasă: Magazinul</h2>
<p>Creează un program pentru un <strong>mic magazin</strong>. Programul trebuie să:</p>
<ol>
<li>Ceară cât costă pâinea (float)</li>
<li>Ceară cât costă laptele (float)</li>
<li>Ceară cât costă ciocolata (float)</li>
<li>Calculeze prețul total</li>
<li>Ceară câți bani dă cumpărătorul (float)</li>
<li>Calculeze și afișeze restul (bani - preț_total)</li>
</ol>
<p>Dacă cumpărătorul nu are suficienți bani, afișează câți îi mai trebuie.</p><div data-code-exercise="" startercode="# DOMACI ZADATAK: Prodavnica&#10;print(\'=== PRODAVNICA ===\')&#10;print()&#10;&#10;hleb = float(input(\'Cena hleba: \'))&#10;# Dodaj pitanja za mleko i cokoladu&#10;&#10;# Izracunaj ukupnu cenu&#10;# ukupno = hleb + mleko + cokolada&#10;&#10;# Ispisi ukupno&#10;&#10;# Pitaj koliko novca kupac daje&#10;&#10;# Izracunaj kusur ili koliko fali&#10;" instructions="Completează programul pentru magazin. Calculează totalul, restul, și verifică dacă cumpărătorul are suficienți bani."></div>';

// --- LESSON 44: Jocuri cu textul ---
$lessonContent[44] = '<h1>Jocuri cu textul</h1>

<p>Textul în Python nu este doar pentru citit — te poți juca cu el în multe moduri interesante! Hai să învățăm trucuri care vor face programele tale mult mai interesante.</p>

<h2>Reamintire: f-strings</h2>

<p>Din lecțiile anterioare știi că poți folosi <code>f-string</code> pentru a pune variabile direct în text. Doar adaugi litera <code>f</code> în fața ghilimelelor și pui variabila în acolade:</p>

<div data-code-exercise="" startercode="ime = \'Marko\'&#10;godine = 12&#10;print(f\'Zdravo, ja sam {ime} i imam {godine} godina!\')" instructions="Rulează. f-string este cel mai ușor mod de a insera variabile în text!"></div>

<h2>STRIGARE și șoptire</h2>

<p>Poți transforma textul în TOATE MAJUSCULE sau toate minuscule:</p>

<div data-code-exercise="" startercode="poruka = \'Zdravo Svete\'&#10;&#10;print(poruka.upper())  # SVA VELIKA SLOVA — VIKANJE!&#10;print(poruka.lower())  # sva mala slova — saputanje..." instructions="Rulează. .upper() transformă în litere mari, .lower() în litere mici."></div>

<h2>Numărarea literelor cu len()</h2>

<p>Comanda <code>len()</code> numără câte caractere are textul (inclusiv spațiile!):</p>

<div data-code-exercise="" startercode="rec = \'Python\'&#10;print(f\'Rec \\\'{rec}\\\' ima {len(rec)} slova.\')&#10;&#10;recenica = \'Ja ucim Python\'&#10;print(f\'Recenica ima {len(recenica)} znakova (i razmaci se broje!).\')" instructions="Rulează și verifică. Spațiile și semnele de punctuație se numără și ele!"></div>

<h2>Accesarea literelor individuale</h2>

<p>Fiecare literă din text are propria sa <strong>poziție</strong> (index). DAR — Python începe să numere de la <strong>0</strong>, nu de la 1!</p>

<p>Imaginează-ți textul ca un șir de căsuțe, fiecare cu o literă:</p>

<div data-code-exercise="" startercode="rec = \'PYTHON\'&#10;# Pozicije: P=0, Y=1, T=2, H=3, O=4, N=5&#10;&#10;print(rec[0])   # Prvo slovo&#10;print(rec[1])   # Drugo slovo&#10;print(rec[-1])  # Poslednje slovo (negativan broj = od kraja!)" instructions="Rulează. [0] este prima literă, [-1] este ultima. Încearcă și alte poziții!"></div>

<h2>Tăierea textului (slicing)</h2>

<p>Poți lua o parte din text folosind <code>[de_la:până_la]</code>:</p>

<div data-code-exercise="" startercode="rec = \'PROGRAMIRANJE\'&#10;&#10;print(rec[0:3])   # Prva 3 slova: PRO&#10;print(rec[0:7])   # Prvih 7: PROGRAM&#10;print(rec[7:])    # Od 7. do kraja: IRANJE" instructions="Rulează. [0:3] înseamnă de la poziția 0 până la poziția 3 (dar 3 nu se numără)."></div>

<h2>Repetarea textului</h2>

<p>Asta deja o știi din lecția 2! Textul înmulțit cu un număr se repetă:</p>

<div data-code-exercise="" startercode="print(\'ha\' * 3)    # hahaha&#10;print(\'la\' * 5)    # lalalalala&#10;print(\'-\' * 30)    # linija od crtica" instructions="Rulează. Înmulțirea textului cu un număr îl repetă de mai multe ori!"></div>

<h2>Încearcă singur! — Generator de porecle</h2>

<p>Creează un program care ia numele și face diverse variante:</p>

<div data-code-exercise="" startercode="ime = input(\'Unesi svoje ime: \')&#10;&#10;print(f\'Tvoje ime: {ime}\')&#10;print(f\'VIKANJE: {ime.upper()}\')&#10;print(f\'saputanje: {ime.lower()}\')&#10;print(f\'Broj slova: {len(ime)}\')&#10;print(f\'Prvo slovo: {ime[0]}\')&#10;print(f\'Poslednje slovo: {ime[-1]}\')&#10;print(f\'Prva 3 slova: {ime[0:3]}\')&#10;print(f\'Ponovljeno: {ime * 3}\')" instructions="Introdu-ți numele și uită-te la toate variantele! Adaugă altele dacă îți vine vreo idee."></div>

<h2>Încearcă singur! — Cod secret</h2>

<p>Creează un program care afișează poziția fiecărei litere din nume:</p>

<div data-code-exercise="" startercode="ime = input(\'Unesi rec: \')&#10;&#10;print(f\'Tajni kod za rec \\\'{ime}\\\':\')&#10;print(f\'Slovo na poziciji 0: {ime[0]}\')&#10;print(f\'Slovo na poziciji 1: {ime[1]}\')&#10;print(f\'Slovo na poziciji 2: {ime[2]}\')&#10;print(f\'Ukupno slova: {len(ime)}\')" instructions="Introdu un cuvânt care are cel puțin 3 litere. Adaugă mai multe rânduri pentru celelalte poziții!"></div>

<h2>Ce am învățat? 📝</h2>

<ul>
<li><code>.upper()</code> — toate literele mari, <code>.lower()</code> — toate literele mici</li>
<li><code>len()</code> — numără caracterele din text</li>
<li><code>[0]</code>, <code>[1]</code>, <code>[-1]</code> — acces la litere individuale</li>
<li><code>[0:3]</code> — tăierea unei părți din text</li>
<li><code>\'text\' * 3</code> — repetarea textului</li>
</ul>

<p>În lecția următoare calculatorul va învăța să <strong>ia decizii</strong> — dacă ceva este adevărat, fă un lucru, altfel fă altceva!</p><h2>Temă pentru acasă: Mesaj cifrat</h2>
<p>Creează un program care ia numele utilizatorului și creează un <strong>cod secret</strong> din el:</p>
<ol>
<li>Cere numele</li>
<li>Afișează numele invers (hint: <code>ime[::-1]</code>)</li>
<li>Afișează doar fiecare a doua literă (hint: <code>ime[::2]</code>)</li>
<li>Afișează numele cu litere mari cu punct între fiecare literă (hint: <code>\'.\'.join(ime.upper())</code>)</li>
<li>Afișează câte litere are numele</li>
<li>Afișează prima și ultima literă</li>
</ol><div data-code-exercise="" startercode="# DOMACI ZADATAK: Sifrovana poruka&#10;&#10;ime = input(\'Unesi svoje ime: \')&#10;&#10;print(f\'Originalno: {ime}\')&#10;# Ispisi ime naopako&#10;# Ispisi svako drugo slovo&#10;# Ispisi velikim slovima sa tackama&#10;# Ispisi koliko slova ima&#10;# Ispisi prvo i poslednje slovo&#10;" instructions="Completează programul. Folosește [::-1], [::2], .upper(), len(), [0] și [-1]."></div>';

// --- LESSON 45: Da sau nu? — condiții ---
$lessonContent[45] = '<h1>Da sau nu? — condiții</h1>

<p>Până acum programele tale făceau același lucru de fiecare dată. Dar programele adevărate <strong>iau decizii</strong>! Ca un paznic la ușă care întreabă: „Ai bilet?" Dacă da — intri. Dacă nu — nu poți.</p>

<h2>Adevărat și Fals — True și False</h2>

<p>Python are două răspunsuri speciale: <code>True</code> (adevărat, da) și <code>False</code> (fals, nu). Le folosește când compară lucruri:</p>

<div data-code-exercise="" startercode="print(5 > 3)    # Da li je 5 vece od 3? True!&#10;print(2 > 10)   # Da li je 2 vece od 10? False!&#10;print(7 == 7)   # Da li je 7 jednako 7? True!&#10;print(5 == 3)   # Da li je 5 jednako 3? False!" instructions="Rulează. Python răspunde True (adevărat) sau False (fals) la fiecare întrebare."></div>

<h2>Operatori de comparație</h2>

<p>Iată toate modurile în care Python compară lucruri:</p>

<ul>
<li><code>==</code> — este egal (DOUĂ semne de egal! Unul singur = este pentru variabile)</li>
<li><code>!=</code> — este diferit</li>
<li><code>&gt;</code> — este mai mare</li>
<li><code>&lt;</code> — este mai mic</li>
<li><code>&gt;=</code> — este mai mare sau egal</li>
<li><code>&lt;=</code> — este mai mic sau egal</li>
</ul>

<div data-code-exercise="" startercode="a = 10&#10;b = 5&#10;&#10;print(f\'{a} == {b}: {a == b}\')&#10;print(f\'{a} != {b}: {a != b}\')&#10;print(f\'{a} > {b}: {a > b}\')&#10;print(f\'{a} < {b}: {a < b}\')" instructions="Rulează. Încearcă să schimbi valorile a și b și uită-te cum se schimbă răspunsurile."></div>

<h2>if — DACĂ este adevărat, fă asta</h2>

<p>Comanda <code>if</code> îi spune calculatorului: „Dacă această condiție este adevărată, atunci execută acest cod."</p>

<p><strong>Două reguli care sunt FOARTE importante:</strong></p>
<ol>
<li>După condiție <strong>mereu urmează două puncte</strong> <code>:</code></li>
<li>Codul care aparține lui if trebuie să fie <strong>indentat cu 4 spații</strong> (tab)</li>
</ol>

<div data-code-exercise="" startercode="uzrast = int(input(\'Koliko imas godina? \'))&#10;&#10;if uzrast >= 18:&#10;    print(\'Mozes da vozis auto!\')&#10;    print(\'Ti si punoletan/a.\')" instructions="Rulează și introdu un număr. Dacă este 18 sau mai mult, vei vedea mesajul. Dacă este mai puțin — nu se întâmplă nimic."></div>

<h2>if/else — DACĂ da fă asta, ALTFEL fă ailaltă</h2>

<p>Ce facem dacă vrem să se întâmple ceva și când condiția NU este adevărată? Folosim <code>else</code>:</p>

<div data-code-exercise="" startercode="lozinka = input(\'Unesi lozinku: \')&#10;&#10;if lozinka == \'python123\':&#10;    print(\'Tacna lozinka! Dobrodosao/la!\')&#10;else:&#10;    print(\'Pogresna lozinka! Pristup odbijen.\')" instructions="Rulează și încearcă parola corectă (python123) și una greșită. Uită-te la diferență!"></div>

<div data-code-exercise="" startercode="godine = int(input(\'Koliko imas godina? \'))&#10;&#10;if godine >= 18:&#10;    print(\'Mozes da glasas na izborima!\')&#10;else:&#10;    preostalo = 18 - godine&#10;    print(f\'Jos {preostalo} godina do glasanja.\')" instructions="Introdu ani diferiți și uită-te la răspunsuri."></div>

<h2>Încearcă singur! — Ghicește numărul</h2>

<p>Este numărul misterios mai mare sau mai mic decât 50?</p>

<div data-code-exercise="" startercode="tajanstveni_broj = 37&#10;&#10;odgovor = int(input(\'Pogodi broj (1-100): \'))&#10;&#10;if odgovor == tajanstveni_broj:&#10;    print(\'BRAVO! Pogodio/la si!\')&#10;else:&#10;    if odgovor > tajanstveni_broj:&#10;        print(\'Previse! Broj je manji.\')&#10;    else:&#10;        print(\'Premalo! Broj je veci.\')" instructions="Încearcă să ghicești numărul! Uită-te cum programul dă răspunsuri diferite."></div>

<h2>Încearcă singur! — Quiz cu puncte</h2>

<div data-code-exercise="" startercode="bodovi = 0&#10;&#10;odgovor1 = input(\'Glavnigrad Srbije? \')&#10;if odgovor1 == \'Beograd\':&#10;    print(\'Tacno!\')&#10;    bodovi = bodovi + 1&#10;else:&#10;    print(\'Netacno! Odgovor je Beograd.\')&#10;&#10;odgovor2 = input(\'Koliko dana ima nedelja? \')&#10;if odgovor2 == \'7\':&#10;    print(\'Tacno!\')&#10;    bodovi = bodovi + 1&#10;else:&#10;    print(\'Netacno! Odgovor je 7.\')&#10;&#10;odgovor3 = input(\'Koji je programski jezik najlaksi za pocetnike? \')&#10;if odgovor3 == \'Python\':&#10;    print(\'Tacno!\')&#10;    bodovi = bodovi + 1&#10;else:&#10;    print(\'Netacno! Odgovor je Python.\')&#10;&#10;print(f\'Tvoj rezultat: {bodovi}/3\')" instructions="Răspunde la întrebări și adună puncte! Adaugă mai multe întrebări dacă dorești."></div>

<h2>Ce am învățat? 📝</h2>

<ul>
<li><code>True</code> și <code>False</code> — modul lui Python de a spune da/nu</li>
<li>Operatori de comparație: <code>==</code>, <code>!=</code>, <code>&gt;</code>, <code>&lt;</code>, <code>&gt;=</code>, <code>&lt;=</code></li>
<li><code>if</code> — execută codul doar dacă condiția este adevărată</li>
<li><code>else</code> — execută codul dacă condiția NU este adevărată</li>
<li>După <code>if</code> și <code>else</code> mereu urmează <code>:</code> și rândul următor trebuie să fie indentat</li>
</ul>

<p>În lecția următoare vei învăța ce să faci când ai <strong>mai mult de două opțiuni</strong> — elif!</p><h2>Temă pentru acasă: Creează un quiz</h2>
<p>Creează un program care este un <strong>quiz cu 5 întrebări</strong>. Pentru fiecare întrebare:</p>
<ol>
<li>Afișează întrebarea</li>
<li>Citește răspunsul utilizatorului</li>
<li>Verifică dacă este corect cu if/else</li>
<li>Dacă este corect — adaugă un punct și afișează „Corect!"</li>
<li>Dacă nu — afișează „Incorect! Răspunsul corect este..."</li>
</ol>
<p>La final afișează câte puncte a obținut din 5.</p><div data-code-exercise="" startercode="# DOMACI ZADATAK: Kviz&#10;print(\'=== KVIZ ===\')&#10;print()&#10;poeni = 0&#10;&#10;# Pitanje 1&#10;odgovor = input(\'Koji je glavni grad Srbije? \')&#10;if odgovor == \'Beograd\':&#10;    print(\'Tacno!\')&#10;    poeni = poeni + 1&#10;else:&#10;    print(\'Netacno! Tacan odgovor je Beograd.\')&#10;&#10;# Dodaj jos 4 pitanja po istom principu&#10;&#10;&#10;print()&#10;print(f\'Osvojio si {poeni} od 5 poena!\')&#10;" instructions="Adaugă încă 4 întrebări. Inventează-ți propriile întrebări (istorie, geografie, sport... ce vrei!). Nu uita poeni = poeni + 1 pentru cele corecte."></div>';

// --- LESSON 46: Mai multe opțiuni — elif ---
$lessonContent[46] = '<h1>Mai multe opțiuni — elif</h1>

<p>Ce faci dacă nu ai doar două opțiuni (da/nu) ci <strong>mai multe</strong>? Semaforul are trei culori: roșu, galben, verde. Notele merg de la 1 la 10. Pentru asta folosim <code>elif</code>!</p>

<h2>elif = „altfel, dacă..."</h2>

<p><code>elif</code> este prescurtarea de la „else if" — înseamnă „altfel, dacă asta este adevărat...". Poți avea oricâte elif-uri dorești:</p>

<div data-code-exercise="" startercode="boja = input(\'Koja je boja na semaforu? (crvena/zuta/zelena) \')&#10;&#10;if boja == \'crvena\':&#10;    print(\'STOJ! Cekaj.\')&#10;elif boja == \'zuta\':&#10;    print(\'PRIPREMI SE!\')&#10;elif boja == \'zelena\':&#10;    print(\'KRENI! Mozes da predjes.\')&#10;else:&#10;    print(\'To nije boja semafora!\')" instructions="Rulează și încearcă culori diferite. Ce se întâmplă dacă tastezi ceva ce nu este o culoare?"></div>

<h2>Digitron de note</h2>

<p>Hai să facem un program care transformă punctele în note:</p>

<div data-code-exercise="" startercode="bodovi = int(input(\'Koliko bodova imas (0-100)? \'))&#10;&#10;if bodovi >= 90:&#10;    print(\'Ocena: 5 (odlican!)\')&#10;elif bodovi >= 75:&#10;    print(\'Ocena: 4 (vrlo dobar)\')&#10;elif bodovi >= 60:&#10;    print(\'Ocena: 3 (dobar)\')&#10;elif bodovi >= 45:&#10;    print(\'Ocena: 2 (dovoljan)\')&#10;else:&#10;    print(\'Ocena: 1 (nedovoljan)\')" instructions="Introdu diferite punctaje și verifică notele. Ești de acord cu limitele?"></div>

<h2>Încearcă singur! — Consilier vestimentar</h2>

<p>Program care pe baza temperaturii sugerează ce să îmbraci:</p>

<div data-code-exercise="" startercode="temp = int(input(\'Koliko je stepeni napolju? \'))&#10;&#10;if temp >= 30:&#10;    print(\'Vruce! Obuci kratke rukave i ponesi vodu.\')&#10;elif temp >= 20:&#10;    print(\'Prijatno. Majica i pantalone su OK.\')&#10;elif temp >= 10:&#10;    print(\'Sveže. Ponesi duks ili laku jaknu.\')&#10;elif temp >= 0:&#10;    print(\'Hladno! Obuci jaknu, sal i kapu.\')&#10;else:&#10;    print(\'Ispod nule! Obuci SVE sto imas!\')" instructions="Introdu temperaturi diferite. Adaugă mai multe sfaturi dacă dorești!"></div>

<h2>Încearcă singur! — Digitron cu meniu</h2>

<div data-code-exercise="" startercode="print(\'--- DIGITRON ---\')&#10;print(\'1. Sabiranje\')&#10;print(\'2. Oduzimanje\')&#10;print(\'3. Mnozenje\')&#10;print(\'4. Deljenje\')&#10;&#10;izbor = input(\'Izaberi operaciju (1-4): \')&#10;a = int(input(\'Prvi broj: \'))&#10;b = int(input(\'Drugi broj: \'))&#10;&#10;if izbor == \'1\':&#10;    print(f\'{a} + {b} = {a + b}\')&#10;elif izbor == \'2\':&#10;    print(f\'{a} - {b} = {a - b}\')&#10;elif izbor == \'3\':&#10;    print(f\'{a} * {b} = {a * b}\')&#10;elif izbor == \'4\':&#10;    print(f\'{a} / {b} = {a / b}\')&#10;else:&#10;    print(\'Nepoznata operacija!\')" instructions="Alege o operație, introdu numere și uită-te la rezultat!"></div>

<h2>Operatori logici: and, or, not</h2>

<p>Uneori trebuie să verifici <strong>mai multe condiții deodată</strong>:</p>

<ul>
<li><code>and</code> — AMBELE condiții trebuie să fie adevărate (ca „și")</li>
<li><code>or</code> — cel puțin O condiție trebuie să fie adevărată (ca „sau")</li>
<li><code>not</code> — schimbă adevărat în fals și invers (ca „nu")</li>
</ul>

<div data-code-exercise="" startercode="domaci = input(\'Da li si zavrsio/la domaci? (da/ne) \')&#10;soba = input(\'Da li si pospremio/la sobu? (da/ne) \')&#10;&#10;if domaci == \'da\' and soba == \'da\':&#10;    print(\'Mozes na zurku! Zabavi se!\')&#10;elif domaci == \'da\' or soba == \'da\':&#10;    print(\'Uradio/la si jedno, ali treba i drugo!\')&#10;else:&#10;    print(\'Prvo zavrsi obaveze!\')" instructions="Încearcă combinații diferite de răspunsuri (da/da, da/ne, ne/da, ne/ne)."></div>

<h2>Ce am învățat? 📝</h2>

<ul>
<li><code>elif</code> — adaugă mai multe opțiuni între <code>if</code> și <code>else</code></li>
<li>Poți avea oricâte <code>elif</code>-uri</li>
<li><code>and</code> — ambele condiții trebuie să fie adevărate</li>
<li><code>or</code> — cel puțin o condiție trebuie să fie adevărată</li>
<li><code>not</code> — schimbă adevărat în fals</li>
</ul>

<p>În lecția următoare învățăm <strong>bucle</strong> — cum să faci calculatorul să repete ceva de 100 de ori fără să scrii 100 de linii de cod!</p><h2>Temă pentru acasă: Meniul restaurantului</h2>
<p>Creează un program care simulează <strong>comanda la restaurant</strong>:</p>
<ol>
<li>Afișează meniul cu 5 feluri și prețuri (de ex. 1. Pizza - 500din, 2. Paste - 400din...)</li>
<li>Cere utilizatorului ce număr alege (1-5)</li>
<li>Folosind elif afișează ce fel de mâncare a ales și cât costă</li>
<li>Întreabă dacă dorește desert (da/nu)</li>
<li>Dacă dorește — adaugă 200 dinari</li>
<li>Întreabă dacă dorește băutură (da/nu)</li>
<li>Dacă dorește — adaugă 150 dinari</li>
<li>La final afișează nota totală de plată</li>
</ol><div data-code-exercise="" startercode="# DOMACI ZADATAK: Restoran&#10;print(\'=== MENI ===\')&#10;print(\'1. Pica — 500 din\')&#10;print(\'2. Pasta — 400 din\')&#10;print(\'3. Cevapi — 450 din\')&#10;print(\'4. Salata — 300 din\')&#10;print(\'5. Supa — 250 din\')&#10;print()&#10;&#10;izbor = input(\'Izaberi jelo (1-5): \')&#10;racun = 0&#10;&#10;# Koristi if/elif/else da postavis cenu&#10;# Na osnovu izbora&#10;&#10;# Pitaj za desert i pice&#10;&#10;# Ispisi ukupan racun&#10;" instructions="Completează programul. Folosește if/elif/else pentru mâncare, apoi if/else pentru desert și băutură. La final afișează nota."></div>';

// --- LESSON 47: Repetare — bucla for ---
$lessonContent[47] = '<h1>Repetare — bucla for</h1>

<p>Ce faci dacă vrei să afișezi „Salut!" de 100 de ori? Să scrii de 100 de ori <code>print(\'Salut!\')</code>? Bineînțeles că nu! Pentru asta există <strong>buclele</strong> — comenzi care repetă codul de câte ori este nevoie.</p>

<h2>bucla for — repetă exact de X ori</h2>

<p>Comanda <code>for</code> spune: „Repetă acest cod de un anumit număr de ori." Se folosește împreună cu <code>range()</code>:</p>

<div data-code-exercise="" startercode="for i in range(5):&#10;    print(\'Zdravo!\')" instructions="Rulează. \'Zdravo!\' se afișează de 5 ori! range(5) înseamnă repetă de 5 ori."></div>

<p>Ca și la <code>if</code>, după <code>for</code> vine <code>:</code> și codul trebuie să fie indentat.</p>

<h2>range() — explicație</h2>

<p><code>range()</code> creează un șir de numere. Se poate folosi în trei moduri:</p>

<div data-code-exercise="" startercode="# range(5) = brojevi 0, 1, 2, 3, 4&#10;print(\'range(5):\')&#10;for i in range(5):&#10;    print(i)&#10;&#10;print()&#10;&#10;# range(1, 6) = brojevi 1, 2, 3, 4, 5&#10;print(\'range(1, 6):\')&#10;for i in range(1, 6):&#10;    print(i)" instructions="Rulează. Observă: range(5) începe de la 0! range(1, 6) începe de la 1 și merge până la 5."></div>

<div data-code-exercise="" startercode="# range(0, 11, 2) = svaki drugi broj od 0 do 10&#10;print(\'Parni brojevi do 10:\')&#10;for i in range(0, 11, 2):&#10;    print(i)" instructions="Al treilea număr în range() este pasul. Aici pasul este 2, deci se sare peste fiecare al doilea număr."></div>

<h2>Folosim contorul</h2>

<p>Variabila <code>i</code> în buclă își schimbă valoarea de fiecare dată. O putem folosi:</p>

<div data-code-exercise="" startercode="# Tablica mnozenja za broj 7&#10;print(\'Tablica mnozenja za 7:\')&#10;for i in range(1, 11):&#10;    rezultat = 7 * i&#10;    print(f\'7 x {i} = {rezultat}\')" instructions="Rulează. Bucla parcurge numerele 1-10 și pentru fiecare calculează 7 înmulțit cu acel număr."></div>

<h2>Încearcă singur! — Tabla înmulțirii</h2>

<p>Creează tabla înmulțirii pentru orice număr introdus de utilizator:</p>

<div data-code-exercise="" startercode="broj = int(input(\'Za koji broj zelis tablicu mnozenja? \'))&#10;&#10;print(f\'Tablica mnozenja za {broj}:\')&#10;print(\'-\' * 20)&#10;for i in range(1, 11):&#10;    print(f\'{broj} x {i} = {broj * i}\')" instructions="Introdu un număr și vei primi tabla lui de înmulțire de la 1 la 10!"></div>

<h2>Încearcă singur! — Mașina de adunat</h2>

<p>Program care cere utilizatorului câteva numere și le adună:</p>

<div data-code-exercise="" startercode="koliko = int(input(\'Koliko brojeva zelis da saberes? \'))&#10;zbir = 0&#10;&#10;for i in range(1, koliko + 1):&#10;    broj = int(input(f\'Unesi broj {i}: \'))&#10;    zbir = zbir + broj&#10;&#10;print(f\'Zbir svih brojeva: {zbir}\')" instructions="Introdu câte numere dorești, apoi tastează-le pe rând. Programul le va aduna pe toate!"></div>

<h2>Încearcă singur! — Desenare model</h2>

<p>Creează scărițe din steluțe:</p>

<div data-code-exercise="" startercode="visina = int(input(\'Koliko redova zelis? \'))&#10;&#10;for i in range(1, visina + 1):&#10;    print(\'*\' * i)" instructions="Introdu numărul de rânduri. Fiecare rând are cu o steluță mai mult! Încearcă și cu alte caractere."></div>

<h2>Ce am învățat? 📝</h2>

<ul>
<li><code>for i in range(x):</code> — repetă codul de x ori</li>
<li><code>range(5)</code> = 0,1,2,3,4 — <code>range(1,6)</code> = 1,2,3,4,5</li>
<li><code>range(0,10,2)</code> = 0,2,4,6,8 — al treilea număr este pasul</li>
<li>Variabila <code>i</code> își schimbă valoarea la fiecare trecere prin buclă</li>
<li>Codul din interiorul buclei trebuie să fie indentat</li>
</ul>

<p>În ultima lecție vei învăța alt tip de buclă — <code>while</code> — pentru când nu știi dinainte de câte ori trebuie să se repete!</p><h2>Temă pentru acasă: Desenare cu steluțe</h2>
<p>Folosind bucla for, desenează următoarele forme cu steluțe (*):</p>
<p><strong>1. Pătrat 5x5:</strong></p>
<pre><code>*****
*****
*****
*****
*****</code></pre>
<p><strong>2. Triunghi:</strong></p>
<pre><code>*
**
***
****
*****</code></pre>
<p><strong>3. Triunghi inversat:</strong></p>
<pre><code>*****
****
***
**
*</code></pre>
<p>Indiciu: <code>print(\'*\' * numar)</code> afișează atâtea steluțe cât este numărul.</p><div data-code-exercise="" startercode="# DOMACI ZADATAK: Crtanje&#10;&#10;# 1. Kvadrat 5x5&#10;print(\'Kvadrat:\')&#10;for i in range(5):&#10;    print(\'*\' * 5)&#10;&#10;print()&#10;&#10;# 2. Trougao (1 zvezdica, pa 2, pa 3...)&#10;print(\'Trougao:\')&#10;# Tvoj kod ovde&#10;&#10;print()&#10;&#10;# 3. Obrnuti trougao (5 zvezdica, pa 4, pa 3...)&#10;print(\'Obrnuti trougao:\')&#10;# Tvoj kod ovde&#10;" instructions="Pătratul este făcut pentru tine. Desenează triunghiul și triunghiul inversat folosind for și range(). Indiciu: print(\"*\" * i)"></div>';

// --- LESSON 48: Repetă cât timp... — bucla while ---
$lessonContent[48] = '<h1>Repetă cât timp... — bucla while</h1>

<p>Bucla <code>for</code> este super când știi de câte ori trebuie să repeți. Dar ce faci dacă nu știi? De exemplu: „Ghicește până ghicești" — nu știi dacă utilizatorul va ghici din prima sau din a suta încercare!</p>

<h2>while = „repetă CÂT TIMP condiția este adevărată"</h2>

<p>Comanda <code>while</code> repetă codul <strong>cât timp condiția este adevărată</strong>. Imediat ce condiția devine falsă, bucla se oprește.</p>

<div data-code-exercise="" startercode="# Pogadjanje lozinke&#10;lozinka = \'\'&#10;&#10;while lozinka != \'python\':&#10;    lozinka = input(\'Unesi lozinku: \')&#10;&#10;print(\'Tacna lozinka! Dobrodosao/la!\')" instructions="Rulează și încearcă diferite parole. Programul va întreba din nou și din nou până tastezi \'python\'."></div>

<h2>Numărătoare inversă</h2>

<div data-code-exercise="" startercode="broj = 10&#10;&#10;while broj > 0:&#10;    print(broj)&#10;    broj = broj - 1&#10;&#10;print(\'START!!!\')" instructions="Rulează și urmărește numărătoarea inversă! Variabila broj se micșorează cu 1 de fiecare dată."></div>

<h2>PERICOL: Buclă infinită!</h2>

<p>Ce se întâmplă dacă condiția <strong>nu devine niciodată falsă</strong>? Bucla se învârte PENTRU TOTDEAUNA! Asta se numește <strong>buclă infinită</strong> și aceasta este cea mai frecventă greșeală cu bucla while.</p>

<p>De exemplu, asta s-ar învârti veșnic (NU rula asta!):</p>

<pre><code># OPASNO - ovo se nikad ne zaustavlja!
# x = 5
# while x > 0:
#     print(x)
#     # Zaboravili smo x = x - 1 !!!</code></pre>

<p>Regulă: <strong>în interiorul buclei while, ceva trebuie să schimbe condiția</strong> astfel încât ea mai devreme sau mai târziu să devină falsă!</p>

<h2>Încearcă singur! — Ghicește numărul</h2>

<p>Creează un joc unde calculatorul „se gândește" la un număr, iar tu ghicești cu ajutor:</p>

<div data-code-exercise="" startercode="tajanstveni = 42&#10;pokusaj = 0&#10;broj_pokusaja = 0&#10;&#10;print(\'Mislim broj izmedju 1 i 100. Pogodi!\')&#10;&#10;while pokusaj != tajanstveni:&#10;    pokusaj = int(input(\'Tvoj pokusaj: \'))&#10;    broj_pokusaja = broj_pokusaja + 1&#10;    &#10;    if pokusaj > tajanstveni:&#10;        print(\'Previse! Pokusaj manji broj.\')&#10;    elif pokusaj < tajanstveni:&#10;        print(\'Premalo! Pokusaj veci broj.\')&#10;    else:&#10;        print(f\'BRAVO! Pogodio/la si iz {broj_pokusaja}. pokusaja!\')" instructions="Ghicește numărul! Programul te ajută — îți spune dacă numărul tău este prea mare sau prea mic."></div>

<h2>Încearcă singur! — Bancomat</h2>

<p>Creează un bancomat simplu:</p>

<div data-code-exercise="" startercode="stanje = 1000&#10;print(f\'Dobrodosao/la! Stanje: {stanje} din\')&#10;&#10;while stanje > 0:&#10;    iznos = int(input(\'Koliko zelis da podignes? \'))&#10;    &#10;    if iznos > stanje:&#10;        print(\'Nemas dovoljno novca!\')&#10;    else:&#10;        stanje = stanje - iznos&#10;        print(f\'Podigao/la si {iznos} din.\')&#10;        print(f\'Preostalo stanje: {stanje} din\')&#10;&#10;print(\'Stanje je 0. Dovidjenja!\')" instructions="Retrage bani până cheltuiești tot! Încearcă să retragi mai mult decât ai."></div>

<h2>Tot ce am învățat în tot cursul! 🎓</h2>

<p>Oprește-te un moment și uită-te la câte lucruri știi acum:</p>

<ul>
<li><strong>print()</strong> — afișarea textului</li>
<li><strong>Variabile</strong> — cutii pentru stocarea datelor</li>
<li><strong>input()</strong> — conversație cu utilizatorul</li>
<li><strong>Tipuri de date</strong> — int, float, str</li>
<li><strong>Operatori</strong> — +, -, *, /, //, %, **</li>
<li><strong>Stringuri</strong> — .upper(), .lower(), len(), tăiere</li>
<li><strong>if / elif / else</strong> — luarea deciziilor</li>
<li><strong>and, or, not</strong> — combinarea condițiilor</li>
<li><strong>bucla for</strong> — repetare de un număr exact de ori</li>
<li><strong>bucla while</strong> — repetare cât timp condiția este adevărată</li>
</ul>

<p><strong>Acestea sunt aceleași blocuri de construcție pe care le folosesc programatorii profesioniști!</strong> Diferența este doar că ei combină aceste blocuri în moduri mai complexe — dar baza este aceeași.</p>

<p>Continuă să exersezi, fă-ți propriile programe mici, experimentează — și ține minte: fiecare greșeală te face un programator mai bun! 💪</p><h2>Temă pentru acasă: Creează-ți propriul joc!</h2>
<p>Creează un program care este un <strong>joc de ghicit numere</strong>. Regulile:</p>
<ol>
<li>Calculatorul „se gândește" la un număr (tu îl scrii în cod, de ex. 7)</li>
<li>Jucătorul are <strong>5 încercări</strong> să ghicească</li>
<li>După fiecare încercare, programul spune „Mai mare!" sau „Mai mic!"</li>
<li>Dacă ghicește — afișează „Bravo!" și câte încercări au fost necesare</li>
<li>Dacă nu ghicește după 5 încercări — afișează „Nu ai ghicit. Numărul era..."</li>
<li>La final întreabă „Vrei din nou?" (da/nu) — dacă da, jocul se reia!</li>
</ol>
<p>Aceasta este o combinație a TUTUROR lucrurilor pe care le-ai învățat: print, input, if/elif/else, while, for, variabile!</p><div data-code-exercise="" startercode="# DOMACI ZADATAK: Igrica pogadjanja!&#10;# Ovo je tvoj ZAVRSNI projekat!&#10;&#10;tajni_broj = 7&#10;&#10;igraj = \'da\'&#10;while igraj == \'da\':&#10;    print(\'Zamislio sam broj od 1 do 20!\')&#10;    pokusaji = 0&#10;    pogodio = False&#10;&#10;    # Napravi petlju za 5 pokusaja&#10;    # U svakom pokusaju:&#10;    # - Pitaj za broj&#10;    # - Povecaj pokusaje za 1&#10;    # - Proveri: veci, manji ili pogodak?&#10;    # - Ako pogodi: ispisi bravo i prekini petlju&#10;&#10;    # Ako nije pogodio posle 5 pokusaja:&#10;    # ispisi koji je broj bio&#10;&#10;    igraj = input(\'Zelis li ponovo? (da/ne) \')&#10;&#10;print(\'Hvala sto si igrao!\')&#10;" instructions="Creează jocul complet! Folosește while pentru încercări, if/elif/else pentru verificare, și break când ghicește. Acesta este proiectul tău final!"></div>';

// Now save all lesson content
foreach ($lessonContent as $id => $content) {
    $lesson = Lesson::find($id);
    if ($lesson) {
        $lesson->content = $content;
        $lesson->is_assignment = true;
        $lesson->save();
        echo "Translated lesson $id ({$lesson->title})\n";
    } else {
        echo "ERROR: Lesson $id not found!\n";
    }
}

echo "\nDone! All 11 lessons translated to Romanian.\n";
