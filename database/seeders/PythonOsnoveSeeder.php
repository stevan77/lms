<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Subchapter;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class PythonOsnoveSeeder extends Seeder
{
    private int $courseId = 14; // Informatika 6

    private function code(string $starterCode, string $instructions = ''): string
    {
        $sc = htmlspecialchars($starterCode, ENT_QUOTES, 'UTF-8');
        $ins = htmlspecialchars($instructions, ENT_QUOTES, 'UTF-8');
        return '<div data-code-exercise startercode="' . $sc . '" instructions="' . $ins . '"></div>';
    }

    public function run(): void
    {
        $chapters = Chapter::where('course_id', $this->courseId)->get();
        foreach ($chapters as $ch) {
            foreach ($ch->subchapters as $sub) { $sub->lessons()->delete(); }
            $ch->subchapters()->delete();
        }
        $chapters->each->delete();

        // ============================================================
        // CHAPTER 1: Upoznavanje sa Pythonom
        // ============================================================
        $ch = Chapter::create(['course_id' => $this->courseId, 'title' => 'Upoznavanje sa Pythonom', 'order' => 1]);
        $sub = Subchapter::create(['chapter_id' => $ch->id, 'title' => 'Prve naredbe', 'order' => 1]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 1, 'is_assignment' => false,
            'title' => 'Sta je Python i naredba print',
            'content' => '<h2>Sta je Python i naredba print</h2>'
                . '<p>Python je jedan od najpoznatijih programskih jezika na svetu. Koriste ga programeri u Google-u, NASA-i, YouTube-u i mnogim igrama!</p>'
                . '<p>Mi cemo ga koristiti da naucimo osnove programiranja. Naredbe se pisu u editoru, a kada kliknes <strong>Run</strong>, racunar ih izvrsi redom od gore ka dole.</p>'
                . '<h3>Naredba print()</h3>'
                . '<p><code>print()</code> je naredba koja ispisuje tekst ili brojeve na ekran. Tekst se stavlja pod navodnike, a brojevi bez navodnika.</p>'
                . $this->code(
                    "# Ovo je komentar - racunar ga ignorise\n# Sve posle znaka # je komentar\n\nprint('Zdravo svete!')\nprint('Ja ucim Python.')\nprint(2 + 3)",
                    'Pokreni program. Sta se ispisuje? Probaj da promenis tekst u navodnicima.'
                )
                . '<h3>Jednostruki i dvostruki navodnici</h3>'
                . '<p>Mozemo koristiti i jednostruke <code>\'...\'</code> i dvostruke <code>"..."</code> navodnike - oba rade isto.</p>'
                . $this->code(
                    "print('Zdravo!')      # jednostruki navodnici\nprint(\"Zdravo!\")      # dvostruki navodnici\nprint(\"Ja sam Python.\")  # i ovako radi",
                    'Oba nacina su ispravna. Koristi onaj koji ti se vise svidja!'
                )
                . '<h3>Vise print naredbi</h3>'
                . '<p>Svaki <code>print()</code> ispisuje u novi red. Mozemo ispisati i prazan red sa <code>print()</code> bez teksta.</p>'
                . $this->code(
                    "print('Ime: Ana')\nprint('Razred: 6')\nprint()              # prazan red\nprint('Skola: OS Zarko Zrenjanin')",
                    'Svaki print ispisuje u novi red. print() bez teksta pravi prazan red.'
                )
                . '<h3>Racunanje sa print</h3>'
                . '<p>Python moze i da racuna! Kada ne stavimo navodnike, Python izracuna rezultat:</p>'
                . $this->code(
                    "print(5 + 3)       # sabiranje = 8\nprint(10 - 4)      # oduzimanje = 6\nprint(6 * 7)       # mnozenje = 42\nprint(20 / 4)      # deljenje = 5.0\nprint(2 ** 3)      # stepenovanje = 8 (2 na 3)",
                    'Racunar racuna bez navodnika. Sa navodnicima bi ispisao tekst "5 + 3" umesto broja 8.'
                )
                . '<h3>Zapamti</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Kod</th><th>Sta ispisuje</th><th>Zasto</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>print(5 + 3)</code></td><td>8</td><td>Racuna, jer nema navodnika</td></tr>'
                . '<tr><td><code>print(\'5 + 3\')</code></td><td>5 + 3</td><td>Ispisuje tekst, jer ima navodnika</td></tr>'
                . '<tr><td><code>print(\'Zdravo\')</code></td><td>Zdravo</td><td>Tekst pod navodnicima</td></tr>'
                . '</tbody></table>',
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 2, 'is_assignment' => false,
            'title' => 'Promenljive',
            'content' => '<h2>Promenljive</h2>'
                . '<p>Promenljiva je kao kutija sa imenom u koju mozes da stavis neku vrednost. Kasnije mozes da koristis ime kutije umesto same vrednosti.</p>'
                . '<h3>Pravljenje promenljivih</h3>'
                . '<p>Promenljivu pravimo sa znakom <code>=</code>. Sa leve strane je ime, a sa desne vrednost.</p>'
                . $this->code(
                    "ime = 'Ana'\ngodine = 12\nrazred = 6\n\nprint(ime)\nprint(godine)\nprint(razred)",
                    'Promenljive cuvaju vrednosti. Ime se stavlja levo, vrednost desno od znaka =.'
                )
                . '<h3>Koriscenje promenljivih u racunanju</h3>'
                . $this->code(
                    "a = 10\nb = 3\n\nprint(a + b)    # 13\nprint(a - b)    # 7\nprint(a * b)    # 30\n\n# Mozemo sacuvati rezultat u novu promenljivu\nzbir = a + b\nprint(zbir)     # 13",
                    'Promenljive mozemo koristiti u racunanju. Rezultat mozemo sacuvati u novu promenljivu.'
                )
                . '<h3>f-string: Ubacivanje promenljivih u tekst</h3>'
                . '<p>Kada zelimo da ubacimo promenljivu u tekst, koristimo <strong>f-string</strong>. Stavimo <code>f</code> ispred navodnika, a promenljivu u viticaste zagrade <code>{}</code>:</p>'
                . $this->code(
                    "ime = 'Marko'\ngodine = 12\nrazred = 6\n\nprint(f'Zdravo, ja sam {ime}!')\nprint(f'Imam {godine} godina i idem u {razred}. razred.')\n\n# Moze i racunanje unutar {}\nprint(f'Sledece godine cu imati {godine + 1} godina.')",
                    'f-string pocinje sa f i koristi {} za ubacivanje promenljivih ili racunanja u tekst.'
                )
                . '<h3>Pravila za imena promenljivih</h3>'
                . '<ul>'
                . '<li>Ime moze sadrzati slova, brojeve i donju crtu <code>_</code></li>'
                . '<li>Ime <strong>ne sme</strong> pocinjati brojem (npr. <code>2ime</code> nije OK)</li>'
                . '<li>Python razlikuje velika i mala slova (<code>Ime</code> i <code>ime</code> su razlicite promenljive)</li>'
                . '<li>Koristi opisna imena: <code>broj_ucenika</code> je bolje od <code>x</code></li>'
                . '</ul>',
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 3, 'is_assignment' => false,
            'title' => 'Ucitavanje podataka - input()',
            'content' => '<h2>Ucitavanje podataka - input()</h2>'
                . '<p>Do sada smo sami pisali vrednosti u kodu. Ali sta ako zelimo da korisnik unese svoj podatak? Za to koristimo <code>input()</code>.</p>'
                . '<h3>Funkcija input()</h3>'
                . '<p><code>input()</code> pauzira program i ceka da korisnik nesto ukuca. Ono sto korisnik ukuca sacuva se kao tekst (string).</p>'
                . $this->code(
                    "ime = input('Kako se zoves? ')\nprint(f'Zdravo, {ime}!')",
                    'Kada pokrenes, pojavice se prozor gde mozes da ukucas svoje ime.'
                )
                . '<h3>input() i brojevi</h3>'
                . '<p><strong>Vazno:</strong> <code>input()</code> uvek vraca tekst (string), cak i ako korisnik ukuca broj! Da bismo racunali sa tim brojem, moramo ga pretvoriti u broj sa <code>int()</code> (ceo broj) ili <code>float()</code> (decimalni).</p>'
                . $this->code(
                    "tekst = input('Koliko imas godina? ')\ngodine = int(tekst)   # pretvaramo tekst u ceo broj\n\nprint(f'Ti imas {godine} godina.')\nprint(f'Za 5 godina ces imati {godine + 5} godina.')",
                    'int() pretvara tekst u ceo broj. Bez toga ne mozemo racunati!'
                )
                . '<h3>Krace pisanje: int(input(...))</h3>'
                . '<p>Mozemo spojiti input i int u jedan red:</p>'
                . $this->code(
                    "a = int(input('Unesi prvi broj: '))\nb = int(input('Unesi drugi broj: '))\n\nprint(f'{a} + {b} = {a + b}')\nprint(f'{a} - {b} = {a - b}')\nprint(f'{a} * {b} = {a * b}')",
                    'int(input(...)) je skracenica - ucitava tekst i odmah ga pretvara u broj.'
                )
                . '<h3>Zapamti</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Funkcija</th><th>Sta radi</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>input(\'poruka\')</code></td><td>Ucitava tekst od korisnika</td><td><code>ime = input(\'Ime? \')</code></td></tr>'
                . '<tr><td><code>int(x)</code></td><td>Pretvara u ceo broj</td><td><code>int(\'42\') → 42</code></td></tr>'
                . '<tr><td><code>float(x)</code></td><td>Pretvara u decimalni broj</td><td><code>float(\'3.14\') → 3.14</code></td></tr>'
                . '</tbody></table>',
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 4, 'is_assignment' => true,
            'title' => 'Domaci: Print, promenljive i input',
            'content' => '<h2>Domaci: Print, promenljive i input</h2>'
                . '<h3>Zadatak 1: Vizit karta</h3>'
                . '<p>Ucitaj ime, prezime i razred od korisnika, pa ispisi vizit kartu.</p>'
                . $this->code(
                    "ime = input('Ime: ')\nprezime = input('Prezime: ')\nrazred = input('Razred: ')\n\n# Ispisi vizit kartu\n# Primer ispisa:\n# ==================\n# Ana Petrovic\n# Razred: 6-1\n# OS Zarko Zrenjanin\n# ==================",
                    'Ucitaj podatke i ispisi ih u lepom formatu.'
                )
                . '<h3>Zadatak 2: Digitron</h3>'
                . '<p>Ucitaj dva broja i ispisi zbir, razliku, proizvod i kolicnik.</p>'
                . $this->code(
                    "a = int(input('Prvi broj: '))\nb = int(input('Drugi broj: '))\n\n# Ispisi sva 4 racuna sa rezultatima\n# Primer: 8 + 3 = 11",
                    'Ispisi rezultate svih operacija u formatu: a + b = rezultat.'
                )
                . '<h3>Zadatak 3: Godine</h3>'
                . '<p>Ucitaj ime i godinu rodjenja. Izracunaj koliko korisnik ima godina i ispisi recenicu.</p>'
                . $this->code(
                    "ime = input('Kako se zoves? ')\ngodina = int(input('Koje godine si rodjen/a? '))\n\n# Izracunaj godine (trenutna godina je 2026)\n# Ispisi: Ime, ti imas X godina.",
                    'Izracunaj godine tako sto od 2026 oduzmes godinu rodjenja.'
                ),
        ]);

        // ============================================================
        // CHAPTER 2: Grananje (if/else)
        // ============================================================
        $ch = Chapter::create(['course_id' => $this->courseId, 'title' => 'Grananje - if i else', 'order' => 2]);
        $sub = Subchapter::create(['chapter_id' => $ch->id, 'title' => 'Donosenje odluka', 'order' => 1]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 1, 'is_assignment' => false,
            'title' => 'Naredba if',
            'content' => '<h2>Naredba if</h2>'
                . '<p>U zivotu stalno donosimo odluke: "Ako pada kisa, uzmi kisobran." U Pythonu isto mozemo! Naredba <code>if</code> proverava uslov i izvrsava kod samo ako je uslov tacan.</p>'
                . '<h3>Kako radi if?</h3>'
                . '<pre><code>if uslov:\n    naredba koja se izvrsava ako je uslov tacan</code></pre>'
                . '<p><strong>Vazno:</strong> Kod unutar if-a mora biti uvucen (4 razmaka ili Tab). To je Python-ov nacin da zna koji kod pripada if-u.</p>'
                . $this->code(
                    "godine = int(input('Koliko imas godina? '))\n\nif godine >= 18:\n    print('Punoletan/na si!')\n    print('Mozes da vozis auto.')\n\nprint('Hvala sto si koristio program.')",
                    'Pokreni sa razlicitim brojevima. Poruka o voznji se prikazuje samo ako je godina >= 18.'
                )
                . '<h3>Operatori poredjenja</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Operator</th><th>Znacenje</th><th>Primer</th><th>Rezultat</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>==</code></td><td>Jednako</td><td><code>5 == 5</code></td><td>True</td></tr>'
                . '<tr><td><code>!=</code></td><td>Razlicito</td><td><code>5 != 3</code></td><td>True</td></tr>'
                . '<tr><td><code>&gt;</code></td><td>Vece od</td><td><code>7 &gt; 3</code></td><td>True</td></tr>'
                . '<tr><td><code>&lt;</code></td><td>Manje od</td><td><code>3 &lt; 7</code></td><td>True</td></tr>'
                . '<tr><td><code>&gt;=</code></td><td>Vece ili jednako</td><td><code>5 &gt;= 5</code></td><td>True</td></tr>'
                . '<tr><td><code>&lt;=</code></td><td>Manje ili jednako</td><td><code>3 &lt;= 7</code></td><td>True</td></tr>'
                . '</tbody></table>'
                . '<p><strong>Paznja:</strong> Za poredjenje koristimo <code>==</code> (dva jednako), a za dodelu vrednosti <code>=</code> (jedno jednako)!</p>',
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 2, 'is_assignment' => false,
            'title' => 'if-else i elif',
            'content' => '<h2>if-else i elif</h2>'
                . '<h3>if-else: Ako... inace...</h3>'
                . '<p><code>else</code> se izvrsava kada uslov u <code>if</code> nije tacan. Kao u zivotu: "Ako pada kisa, uzmi kisobran. Inace, idi bez kisobrana."</p>'
                . $this->code(
                    "temperatura = int(input('Koliko je stepeni napolju? '))\n\nif temperatura >= 25:\n    print('Toplo je! Obuci kratke rukave.')\nelse:\n    print('Hladno je! Obuci jaknu.')",
                    'Uvek se izvrsava JEDAN od dva bloka - ili if ili else, nikad oba.'
                )
                . '<h3>elif: Vise uslova</h3>'
                . '<p>Kada imamo vise od dva izbora, koristimo <code>elif</code> (skracenica od "else if"):</p>'
                . $this->code(
                    "ocena = int(input('Unesi ocenu (1-5): '))\n\nif ocena == 5:\n    print('Odlican!')\nelif ocena == 4:\n    print('Vrlo dobar!')\nelif ocena == 3:\n    print('Dobar.')\nelif ocena == 2:\n    print('Dovoljan.')\nelse:\n    print('Nedovoljan.')",
                    'Python proverava uslove redom odozgo. Cim nadje tacan, izvrsava taj blok i preskace ostale.'
                )
                . '<h3>Primer: Paran ili neparan</h3>'
                . $this->code(
                    "broj = int(input('Unesi broj: '))\n\nif broj % 2 == 0:\n    print(f'{broj} je paran.')\nelse:\n    print(f'{broj} je neparan.')\n\n# % je operator ostatka pri deljenju\n# Ako je ostatak 0, broj je deljiv sa 2 (paran)",
                    '% daje ostatak: 7 % 2 = 1 (neparan), 8 % 2 = 0 (paran).'
                )
                . '<h3>Zapamti</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Naredba</th><th>Kada se izvrsava</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>if uslov:</code></td><td>Kada je uslov tacan (True)</td></tr>'
                . '<tr><td><code>elif uslov:</code></td><td>Kada prethodni uslovi nisu tacni, a ovaj jeste</td></tr>'
                . '<tr><td><code>else:</code></td><td>Kada nijedan prethodni uslov nije tacan</td></tr>'
                . '</tbody></table>',
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 3, 'is_assignment' => false,
            'title' => 'Logicki operatori (and, or, not)',
            'content' => '<h2>Logicki operatori (and, or, not)</h2>'
                . '<p>Ponekad trebamo proveriti vise uslova istovremeno. Za to koristimo logicke operatore.</p>'
                . '<h3>and - oba uslova moraju biti tacna</h3>'
                . '<p>Kao u zivotu: "Ako imam pare AND imam vremena, idem u bioskop."</p>'
                . $this->code(
                    "godine = int(input('Koliko imas godina? '))\nocena = int(input('Koja ti je ocena iz matematike? '))\n\nif godine >= 12 and ocena >= 4:\n    print('Mozes na takmicenje!')\nelse:\n    print('Ne ispunjavas oba uslova.')",
                    'and: OBA uslova moraju biti tacna. Ako je jedan netacan, ceo izraz je netacan.'
                )
                . '<h3>or - bar jedan uslov mora biti tacan</h3>'
                . '<p>"Ako imam kartu OR sam na listi, ulazim na koncert."</p>'
                . $this->code(
                    "dan = input('Koji je dan? (pon/uto/sre/cet/pet/sub/ned) ')\n\nif dan == 'sub' or dan == 'ned':\n    print('Vikend je! Nema skole!')\nelse:\n    print('Radni dan. Idi u skolu!')",
                    'or: Dovoljno je da JEDAN uslov bude tacan.'
                )
                . '<h3>not - obrce uslov</h3>'
                . $this->code(
                    "kisa = input('Da li pada kisa? (da/ne) ')\n\nif not kisa == 'da':\n    print('Mozemo napolje!')\nelse:\n    print('Ostani unutra.')",
                    'not obrce True u False i obrnuto.'
                )
                . '<h3>Zapamti</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Operator</th><th>Znacenje</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>and</code></td><td>Oba moraju biti tacna</td><td><code>x &gt; 0 and x &lt; 10</code></td></tr>'
                . '<tr><td><code>or</code></td><td>Bar jedan mora biti tacan</td><td><code>x == 0 or x == 1</code></td></tr>'
                . '<tr><td><code>not</code></td><td>Obrce (True ↔ False)</td><td><code>not x == 5</code></td></tr>'
                . '</tbody></table>',
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 4, 'is_assignment' => true,
            'title' => 'Domaci: Grananje',
            'content' => '<h2>Domaci: Grananje</h2>'
                . '<h3>Zadatak 1: Deljivost</h3>'
                . '<p>Ucitaj broj i proveri da li je deljiv sa 3, sa 5, ili sa oba.</p>'
                . $this->code("broj = int(input('Unesi broj: '))\n\n# Proveri deljivost sa 3 i sa 5\n# Primer: 15 je deljiv i sa 3 i sa 5\n# Primer: 9 je deljiv samo sa 3\n# Primer: 10 je deljiv samo sa 5\n# Primer: 7 nije deljiv ni sa 3 ni sa 5",
                    'Koristi % (ostatak) i if/elif/else.')
                . '<h3>Zadatak 2: Kviz</h3>'
                . '<p>Napravi kviz sa 3 pitanja. Na kraju ispisi koliko tacnih odgovora je korisnik dao.</p>'
                . $this->code("tacnih = 0\n\nodgovor = input('Glavni grad Srbije? ')\nif odgovor == 'Beograd':\n    print('Tacno!')\n    tacnih = tacnih + 1\nelse:\n    print('Netacno! Odgovor je Beograd.')\n\n# Dodaj jos 2 pitanja\n\nprint(f'Imas {tacnih} od 3 tacnih odgovora.')",
                    'Dodaj jos dva pitanja o geografiji. Broji tacne odgovore.')
                . '<h3>Zadatak 3: Kalkulator</h3>'
                . '<p>Napravi jednostavan digitron: ucitaj dva broja i operaciju (+, -, *, /), pa ispisi rezultat.</p>'
                . $this->code("a = float(input('Prvi broj: '))\nb = float(input('Drugi broj: '))\noperacija = input('Operacija (+, -, *, /): ')\n\n# Koristi if/elif za svaku operaciju\n# Pazi na deljenje nulom!",
                    'Koristi if/elif da proveris koju operaciju je korisnik izabrao.'),
        ]);

        // ============================================================
        // CHAPTER 3: Petlje
        // ============================================================
        $ch = Chapter::create(['course_id' => $this->courseId, 'title' => 'Petlje - ponavljanje', 'order' => 3]);
        $sub = Subchapter::create(['chapter_id' => $ch->id, 'title' => 'for i while', 'order' => 1]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 1, 'is_assignment' => false,
            'title' => 'Petlja for i range()',
            'content' => '<h2>Petlja for i range()</h2>'
                . '<p>Sta ako treba da ispises "Zdravo" 100 puta? Da pises 100 print naredbi? Naravno da ne! Koristimo <strong>petlju</strong> (loop) - naredbu koja ponavlja kod odredjeni broj puta.</p>'
                . '<h3>for petlja</h3>'
                . '<pre><code>for i in range(broj_ponavljanja):\n    naredba koja se ponavlja</code></pre>'
                . '<p><code>range(5)</code> daje brojeve: 0, 1, 2, 3, 4 (5 brojeva, ali pocinje od 0!).</p>'
                . $this->code(
                    "# Ispisi Zdravo 5 puta\nfor i in range(5):\n    print(f'{i}: Zdravo!')\n\nprint('Kraj petlje.')",
                    'i menja vrednost u svakom krugu: 0, 1, 2, 3, 4. Isprobaj sa range(10)!'
                )
                . '<h3>range() sa razlicitim parametrima</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Poziv</th><th>Brojevi</th><th>Objasnjenje</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>range(5)</code></td><td>0, 1, 2, 3, 4</td><td>Od 0 do 4 (5 brojeva)</td></tr>'
                . '<tr><td><code>range(1, 6)</code></td><td>1, 2, 3, 4, 5</td><td>Od 1 do 5</td></tr>'
                . '<tr><td><code>range(0, 10, 2)</code></td><td>0, 2, 4, 6, 8</td><td>Od 0 do 8, korak 2</td></tr>'
                . '<tr><td><code>range(10, 0, -1)</code></td><td>10, 9, 8, ..., 1</td><td>Odbrojavanje</td></tr>'
                . '</tbody></table>'
                . $this->code(
                    "# Tablica mnozenja za broj 7\nbroj = 7\nfor i in range(1, 11):  # od 1 do 10\n    print(f'{broj} x {i} = {broj * i}')",
                    'range(1, 11) daje 1,2,...,10. Poslednji broj (11) se ne ukljucuje!'
                )
                . '<h3>Primer: Odbrojavanje</h3>'
                . $this->code(
                    "print('Odbrojavanje:')\nfor i in range(10, 0, -1):\n    print(i)\nprint('START!')",
                    'range(10, 0, -1) broji od 10 do 1, smanjuje za 1 u svakom koraku.'
                ),
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 2, 'is_assignment' => false,
            'title' => 'Petlja while',
            'content' => '<h2>Petlja while</h2>'
                . '<p><code>for</code> ponavlja kod tacno odredjeni broj puta. Ali sta ako ne znamo unapred koliko puta treba ponoviti? Na primer: "Pitaj korisnika dok ne pogodi broj." Za to koristimo <code>while</code>.</p>'
                . '<h3>Kako radi while?</h3>'
                . '<pre><code>while uslov:\n    naredba koja se ponavlja dok je uslov tacan</code></pre>'
                . '<p>While ponavlja kod SVE DOK je uslov tacan. Cim uslov postane netacan, petlja se zavrsava.</p>'
                . $this->code(
                    "# Odbrojavanje sa while\nbroj = 5\nwhile broj > 0:\n    print(broj)\n    broj = broj - 1    # smanjujemo broj\nprint('Kraj!')",
                    'Petlja se ponavlja dok je broj > 0. Svaki put smanjujemo broj za 1.'
                )
                . '<h3>Primer: Pogodi broj</h3>'
                . $this->code(
                    "tacan = 7\npokusaj = int(input('Pogodi broj (1-10): '))\n\nwhile pokusaj != tacan:\n    if pokusaj < tacan:\n        print('Previse malo!')\n    else:\n        print('Previse veliko!')\n    pokusaj = int(input('Pokusaj ponovo: '))\n\nprint('Bravo, pogodio/la si!')",
                    'While se ponavlja dok korisnik ne pogodi. Svaki put mu kazemo da li je broj veci ili manji.'
                )
                . '<h3>Sabiranje dok korisnik ne unese 0</h3>'
                . $this->code(
                    "zbir = 0\nbroj = int(input('Unesi broj (0 za kraj): '))\n\nwhile broj != 0:\n    zbir = zbir + broj\n    broj = int(input('Unesi broj (0 za kraj): '))\n\nprint(f'Zbir svih unetih brojeva: {zbir}')",
                    'Ucitavamo brojeve dok korisnik ne unese 0, pa ispisujemo zbir.'
                )
                . '<h3>for ili while?</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Petlja</th><th>Kada koristimo</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>for</code></td><td>Znamo unapred koliko puta</td><td>Ispisi 10 puta, tablica mnozenja</td></tr>'
                . '<tr><td><code>while</code></td><td>Ne znamo koliko puta, zavisi od uslova</td><td>Dok ne pogodi, dok ne unese 0</td></tr>'
                . '</tbody></table>',
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 3, 'is_assignment' => false,
            'title' => 'Ugnjezdene petlje',
            'content' => '<h2>Ugnjezdene petlje</h2>'
                . '<p>Petlju mozemo staviti unutar druge petlje. Za svaki krug spoljne petlje, unutrasnja petlja se izvrsi cela.</p>'
                . $this->code(
                    "# Tablica mnozenja 1-5\nfor i in range(1, 6):\n    for j in range(1, 6):\n        rezultat = i * j\n        print(f'{i} x {j} = {rezultat:2d}', end='   ')\n    print()  # novi red posle svakog reda tablice",
                    'Spoljna petlja (i) ide po redovima, unutrasnja (j) po kolonama. end="" sprečava novi red.'
                )
                . '<h3>Primer: Zvezdice</h3>'
                . $this->code(
                    "n = 5\n# Trougao od zvezdica\nfor i in range(1, n + 1):\n    print('* ' * i)",
                    '"* " * 3 daje "* * * ". Mnozenje teksta brojem ponavlja tekst!'
                )
                . '<h3>Primer: Pravougaonik od zvezdica</h3>'
                . $this->code(
                    "redovi = int(input('Koliko redova? '))\nkolone = int(input('Koliko kolona? '))\n\nfor i in range(redovi):\n    for j in range(kolone):\n        print('* ', end='')\n    print()  # novi red",
                    'Spoljna petlja = redovi, unutrasnja = kolone.'
                ),
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 4, 'is_assignment' => true,
            'title' => 'Domaci: Petlje',
            'content' => '<h2>Domaci: Petlje</h2>'
                . '<h3>Zadatak 1: Tablica mnozenja</h3>'
                . '<p>Ucitaj broj od korisnika i ispisi tablicu mnozenja za taj broj (od 1 do 10).</p>'
                . $this->code("broj = int(input('Za koji broj? '))\n\n# Ispisi: broj x 1 = ...\n#         broj x 2 = ...\n#         ...\n#         broj x 10 = ...",
                    'Koristi for i in range(1, 11).')
                . '<h3>Zadatak 2: Zbir prvih N brojeva</h3>'
                . '<p>Ucitaj N i izracunaj zbir brojeva od 1 do N.</p>'
                . $this->code("n = int(input('Unesi N: '))\nzbir = 0\n\n# Koristi for petlju da saberes 1+2+3+...+n\n\nprint(f'Zbir brojeva od 1 do {n} je: {zbir}')",
                    'Saberi sve brojeve od 1 do n koristeci for petlju.')
                . '<h3>Zadatak 3: Faktorijel</h3>'
                . '<p>Ucitaj N i izracunaj N! (faktorijel = 1 * 2 * 3 * ... * N). Primer: 5! = 120.</p>'
                . $this->code("n = int(input('Unesi N: '))\nfaktorijel = 1\n\n# Koristi for petlju da pomnozis 1*2*3*...*n\n\nprint(f'{n}! = {faktorijel}')",
                    'Slicno zbiru, ali umesto + koristi *.'),
        ]);

        // ============================================================
        // CHAPTER 4: Liste
        // ============================================================
        $ch = Chapter::create(['course_id' => $this->courseId, 'title' => 'Liste', 'order' => 4]);
        $sub = Subchapter::create(['chapter_id' => $ch->id, 'title' => 'Rad sa listama', 'order' => 1]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 1, 'is_assignment' => false,
            'title' => 'Sta su liste?',
            'content' => '<h2>Sta su liste?</h2>'
                . '<p>Lista je uredjen niz podataka. Zamisli je kao policu za knjige - svaka knjiga ima svoje mesto (indeks), pocevsi od 0.</p>'
                . $this->code(
                    "# Pravimo listu\nocene = [5, 4, 5, 3, 4]\nimena = ['Ana', 'Marko', 'Jovana', 'Stefan']\n\nprint(ocene)        # cela lista\nprint(ocene[0])     # prvi element (indeks 0)\nprint(ocene[-1])    # poslednji element\nprint(len(ocene))   # koliko ima elemenata",
                    'Indeks pocinje od 0! ocene[0] je prvi, ocene[1] drugi...'
                )
                . '<h3>Menjanje, dodavanje, brisanje</h3>'
                . $this->code(
                    "ocene = [5, 4, 3, 4, 5]\nprint('Pre:', ocene)\n\n# Menjanje elementa\nocene[2] = 5        # treci element (indeks 2) postaje 5\nprint('Posle menjanja:', ocene)\n\n# Dodavanje na kraj\nocene.append(4)\nprint('Posle dodavanja:', ocene)\n\n# Brisanje elementa\nocene.remove(4)     # brise prvo pojavljivanje broja 4\nprint('Posle brisanja:', ocene)",
                    'append() dodaje na kraj, remove() brise prvo pojavljivanje.'
                )
                . '<h3>Korisne funkcije za liste</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Funkcija</th><th>Sta radi</th><th>Primer</th><th>Rezultat</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>len(lista)</code></td><td>Broj elemenata</td><td><code>len([5,4,3])</code></td><td>3</td></tr>'
                . '<tr><td><code>sum(lista)</code></td><td>Zbir elemenata</td><td><code>sum([5,4,3])</code></td><td>12</td></tr>'
                . '<tr><td><code>min(lista)</code></td><td>Najmanji</td><td><code>min([5,4,3])</code></td><td>3</td></tr>'
                . '<tr><td><code>max(lista)</code></td><td>Najveci</td><td><code>max([5,4,3])</code></td><td>5</td></tr>'
                . '<tr><td><code>sorted(lista)</code></td><td>Sortirana kopija</td><td><code>sorted([3,1,2])</code></td><td>[1,2,3]</td></tr>'
                . '<tr><td><code>lista.append(x)</code></td><td>Dodaj na kraj</td><td><code>[1,2].append(3)</code></td><td>[1,2,3]</td></tr>'
                . '<tr><td><code>lista.remove(x)</code></td><td>Obrisi prvo x</td><td><code>[1,2,3].remove(2)</code></td><td>[1,3]</td></tr>'
                . '</tbody></table>',
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 2, 'is_assignment' => false,
            'title' => 'Prolazak kroz listu',
            'content' => '<h2>Prolazak kroz listu</h2>'
                . '<p>Najcesci posao sa listom je da prodjemo kroz sve elemente i uradimo nesto sa svakim. To radimo sa <code>for</code> petljom.</p>'
                . $this->code(
                    "imena = ['Ana', 'Marko', 'Jovana', 'Stefan']\n\n# Prolazimo kroz listu\nfor ime in imena:\n    print(f'Zdravo, {ime}!')",
                    'for ime in imena: uzima svaki element iz liste, jedan po jedan.'
                )
                . '<h3>Racunanje sa listom</h3>'
                . $this->code(
                    "ocene = [5, 4, 5, 3, 5, 4]\n\n# Rucno racunanje proseka\nzbir = 0\nfor ocena in ocene:\n    zbir = zbir + ocena\n\nprosek = zbir / len(ocene)\nprint(f'Ocene: {ocene}')\nprint(f'Zbir: {zbir}')\nprint(f'Broj ocena: {len(ocene)}')\nprint(f'Prosek: {prosek:.2f}')\n\n# Ili krace:\nprint(f'Prosek (krace): {sum(ocene) / len(ocene):.2f}')",
                    'Mozemo sabirati rucno sa petljom, ili koristiti sum() i len().'
                )
                . '<h3>Filtriranje liste</h3>'
                . $this->code(
                    "ocene = [5, 4, 5, 3, 5, 4, 2, 5, 3]\n\n# Izdvajamo samo petice\npetice = 0\nfor ocena in ocene:\n    if ocena == 5:\n        petice = petice + 1\n\nprint(f'Broj petica: {petice}')\nprint(f'Od ukupno {len(ocene)} ocena')",
                    'Kombinujemo for i if da filtriramo elemente.'
                ),
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 3, 'is_assignment' => false,
            'title' => 'Stringovi (niske)',
            'content' => '<h2>Stringovi (niske)</h2>'
                . '<p>String (niska) je niz karaktera - tekst. U Pythonu, string se ponasa slicno listi: ima duzinu, mozemo pristupiti svakom karakteru po indeksu, i prolaziti petljom.</p>'
                . $this->code(
                    "tekst = 'Informatika'\n\nprint(len(tekst))      # 11 karaktera\nprint(tekst[0])        # I (prvi karakter)\nprint(tekst[-1])       # a (poslednji)\nprint(tekst[0:6])      # Inform (od 0 do 5)\nprint(tekst.upper())   # INFORMATIKA\nprint(tekst.lower())   # informatika",
                    'String radi kao lista karaktera. Indeks pocinje od 0.'
                )
                . '<h3>Prolazak kroz string</h3>'
                . $this->code(
                    "rec = input('Unesi rec: ')\n\nsamoglasnici = 0\nfor slovo in rec:\n    if slovo in 'aeiouAEIOU':\n        samoglasnici = samoglasnici + 1\n\nprint(f'Rec \"{rec}\" ima {samoglasnici} samoglasnika.')",
                    'for slovo in rec: prolazi kroz svaki karakter teksta.'
                )
                . '<h3>Korisne metode za stringove</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Metoda</th><th>Sta radi</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>.upper()</code></td><td>Sva velika slova</td><td><code>\'abc\'.upper() → \'ABC\'</code></td></tr>'
                . '<tr><td><code>.lower()</code></td><td>Sva mala slova</td><td><code>\'ABC\'.lower() → \'abc\'</code></td></tr>'
                . '<tr><td><code>.count(x)</code></td><td>Broji pojavljivanja</td><td><code>\'banana\'.count(\'a\') → 3</code></td></tr>'
                . '<tr><td><code>.replace(a, b)</code></td><td>Zamenjuje a sa b</td><td><code>\'da\'.replace(\'d\', \'n\') → \'na\'</code></td></tr>'
                . '<tr><td><code>x in tekst</code></td><td>Proverava da li sadrzi</td><td><code>\'a\' in \'Ana\' → True</code></td></tr>'
                . '</tbody></table>',
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 4, 'is_assignment' => true,
            'title' => 'Domaci: Liste i stringovi',
            'content' => '<h2>Domaci: Liste i stringovi</h2>'
                . '<h3>Zadatak 1: Prosek ocena</h3>'
                . '<p>Ucitaj 5 ocena od korisnika, stavi ih u listu, pa ispisi prosek, najmanju i najvecu ocenu.</p>'
                . $this->code("ocene = []\nfor i in range(5):\n    o = int(input(f'Ocena {i+1}: '))\n    ocene.append(o)\n\n# Ispisi prosek, min, max",
                    'Koristi sum(), len(), min(), max().')
                . '<h3>Zadatak 2: Palindrom</h3>'
                . '<p>Ucitaj rec i proveri da li je palindrom (cita se isto s leva i s desna). Primeri: ana, radar, level.</p>'
                . $this->code("rec = input('Unesi rec: ').lower()\n\n# rec[::-1] obrce string\n# Proveri da li je rec jednaka obrnutoj",
                    'rec[::-1] obrce string. "ana"[::-1] daje "ana".')
                . '<h3>Zadatak 3: Najduza rec</h3>'
                . '<p>Ucitaj 5 reci i ispisi koja je najduza i koliko slova ima.</p>'
                . $this->code("reci = []\nfor i in range(5):\n    r = input(f'Rec {i+1}: ')\n    reci.append(r)\n\n# Nadji najduzu rec\n# Koristi len() za duzinu svake reci",
                    'Pronadji rec sa najvecim len().'),
        ]);

        // ============================================================
        // CHAPTER 5: Funkcije
        // ============================================================
        $ch = Chapter::create(['course_id' => $this->courseId, 'title' => 'Funkcije', 'order' => 5]);
        $sub = Subchapter::create(['chapter_id' => $ch->id, 'title' => 'Pravljenje funkcija', 'order' => 1]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 1, 'is_assignment' => false,
            'title' => 'Definisanje i pozivanje funkcija',
            'content' => '<h2>Definisanje i pozivanje funkcija</h2>'
                . '<p>Funkcija je blok koda sa imenom koji mozemo pozvati koliko god puta zelimo. Kao recept u kuhinji - napises ga jednom, a koristis uvek kad treba.</p>'
                . '<h3>Pravljenje funkcije - def</h3>'
                . $this->code(
                    "# Definisanje funkcije\ndef pozdravi(ime):\n    print(f'Zdravo, {ime}!')\n    print(f'Dobrodosao/la u Python!')\n\n# Pozivanje funkcije\npozdravi('Ana')\npozdravi('Marko')\npozdravi('Jovana')",
                    'def pravi funkciju. Jednom je napisemo, a mozemo je pozvati koliko god puta zelimo.'
                )
                . '<h3>Funkcije sa return</h3>'
                . '<p><code>return</code> vraca vrednost iz funkcije. Kao kada pitas nekoga "koliko je 5+3?" i on ti vrati odgovor "8".</p>'
                . $this->code(
                    "def zbir(a, b):\n    return a + b\n\ndef prosek(lista):\n    return sum(lista) / len(lista)\n\n# Koristimo return vrednost\nrezultat = zbir(5, 3)\nprint(f'5 + 3 = {rezultat}')\n\nocene = [5, 4, 5, 3, 4]\nprint(f'Prosek: {prosek(ocene):.2f}')",
                    'return vraca vrednost. Mozemo je sacuvati u promenljivu ili odmah koristiti u print.'
                )
                . '<h3>Primer: Funkcija za proveru parnosti</h3>'
                . $this->code(
                    "def je_paran(broj):\n    if broj % 2 == 0:\n        return True\n    else:\n        return False\n\n# Testiranje\nfor i in range(1, 11):\n    if je_paran(i):\n        print(f'{i} je paran')\n    else:\n        print(f'{i} je neparan')",
                    'Funkcija vraca True ili False. Koristimo je u if uslovu.'
                ),
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 2, 'is_assignment' => false,
            'title' => 'Funkcije - napredni primeri',
            'content' => '<h2>Funkcije - napredni primeri</h2>'
                . '<h3>Funkcija sa podrazumevanom vrednoscu</h3>'
                . $this->code(
                    "def pozdravi(ime, pozdrav='Zdravo'):\n    print(f'{pozdrav}, {ime}!')\n\npozdravi('Ana')              # Zdravo, Ana!\npozdravi('Marko', 'Cao')     # Cao, Marko!\npozdravi('Jovana', 'Hej')    # Hej, Jovana!",
                    'pozdrav ima podrazumevanu vrednost "Zdravo". Ako ne prosledimo drugi argument, koristi se podrazumevana.'
                )
                . '<h3>Primer: Mini dnevnik ocena</h3>'
                . $this->code(
                    "def dodaj_ocenu(ocene, nova_ocena):\n    if 1 <= nova_ocena <= 5:\n        ocene.append(nova_ocena)\n        print(f'Ocena {nova_ocena} dodata.')\n    else:\n        print('Ocena mora biti izmedju 1 i 5!')\n\ndef prikazi_statistiku(ocene):\n    if len(ocene) == 0:\n        print('Nema ocena.')\n        return\n    print(f'Ocene: {ocene}')\n    print(f'Broj ocena: {len(ocene)}')\n    print(f'Prosek: {sum(ocene)/len(ocene):.2f}')\n    print(f'Najbolja: {max(ocene)}')\n    print(f'Najgora: {min(ocene)}')\n\n# Koristimo funkcije\nmoje_ocene = []\ndodaj_ocenu(moje_ocene, 5)\ndodaj_ocenu(moje_ocene, 4)\ndodaj_ocenu(moje_ocene, 5)\ndodaj_ocenu(moje_ocene, 3)\ndodaj_ocenu(moje_ocene, 7)   # greska!\n\nprint()\nprikazi_statistiku(moje_ocene)",
                    'Funkcije pomazu da organizujemo kod. Svaka radi jednu stvar.'
                )
                . '<h3>Pregled</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Pojam</th><th>Objasnjenje</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>def ime():</code></td><td>Definise funkciju</td><td><code>def zbir(a, b):</code></td></tr>'
                . '<tr><td>Parametar</td><td>Vrednost koju funkcija prima</td><td><code>a, b</code> u <code>zbir(a, b)</code></td></tr>'
                . '<tr><td>Argument</td><td>Vrednost koju prosledjujemo</td><td><code>5, 3</code> u <code>zbir(5, 3)</code></td></tr>'
                . '<tr><td><code>return</code></td><td>Vraca vrednost iz funkcije</td><td><code>return a + b</code></td></tr>'
                . '<tr><td>Pozivanje</td><td>Pokrecemo funkciju</td><td><code>zbir(5, 3)</code></td></tr>'
                . '</tbody></table>',
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 3, 'is_assignment' => true,
            'title' => 'Zavrsni projekat: Mini program',
            'content' => '<h2>Zavrsni projekat: Mini program</h2>'
                . '<p>Napravi jedan od sledecih programa koristeci sve sto si naucio: print, input, promenljive, if/else, petlje, liste i funkcije.</p>'
                . '<h3>Opcija 1: Kviz igra</h3>'
                . '<p>Napravi kviz sa 5 pitanja. Broji poene, na kraju ispisi rezultat i ocenu (5 tacnih = 5, 4 tacnih = 4, itd).</p>'
                . $this->code("def postavi_pitanje(pitanje, tacan_odgovor):\n    odgovor = input(pitanje + ' ')\n    if odgovor.lower() == tacan_odgovor.lower():\n        print('Tacno!')\n        return 1\n    else:\n        print(f'Netacno. Tacan odgovor: {tacan_odgovor}')\n        return 0\n\npoeni = 0\n\n# Dodaj 5 pitanja\npoeni += postavi_pitanje('Glavni grad Srbije?', 'Beograd')\n\n# Dodaj jos 4 pitanja...\n\nprint(f'\\nRezultat: {poeni}/5')",
                    'Koristi funkciju postavi_pitanje za svako pitanje. Dodaj jos 4 pitanja!')
                . '<h3>Opcija 2: Lista zadataka (To-Do)</h3>'
                . '<p>Napravi program gde korisnik moze da dodaje, prikazuje i brise zadatke.</p>'
                . $this->code("zadaci = []\n\ndef prikazi_meni():\n    print('\\n=== MOJI ZADACI ===')\n    print('1. Prikazi zadatke')\n    print('2. Dodaj zadatak')\n    print('3. Obrisi zadatak')\n    print('4. Izlaz')\n\ndef prikazi_zadatke():\n    if len(zadaci) == 0:\n        print('Nema zadataka.')\n    else:\n        for i, z in enumerate(zadaci, 1):\n            print(f'  {i}. {z}')\n\n# Glavni program\nwhile True:\n    prikazi_meni()\n    izbor = input('Izbor: ')\n    if izbor == '4':\n        print('Cao!')\n        break\n    elif izbor == '1':\n        prikazi_zadatke()\n    elif izbor == '2':\n        zadatak = input('Novi zadatak: ')\n        zadaci.append(zadatak)\n        print('Dodato!')\n    # Dodaj opciju 3 - brisanje",
                    'Dopuni program: dodaj opciju za brisanje zadatka.')
                . '<h3>Opcija 3: Tvoj izbor</h3>'
                . '<p>Napravi bilo koji program! Mora da koristi: bar jednu funkciju, bar jednu petlju, bar jedan if/else, i bar jednu listu.</p>'
                . $this->code("# Tvoj mini program\n# Ideje: igra pogadjanja, statistika ocena,\n# generator sifara, konvertor valuta...\n",
                    'Budi kreativan! Koristi sve sto si naucio.'),
        ]);

        echo "Python osnove kurs kreiran! 5 poglavlja, 15 lekcija (4 domaca + 1 zavrsni projekat).\n";
    }
}
