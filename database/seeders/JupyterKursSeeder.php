<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Subchapter;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class JupyterKursSeeder extends Seeder
{
    private int $courseId = 4; // Informatika 8

    private function notebook(array $cells): string
    {
        $json = json_encode($cells, JSON_UNESCAPED_UNICODE);
        $escaped = htmlspecialchars($json, ENT_QUOTES, 'UTF-8');
        return '<div data-notebook cells="' . $escaped . '"></div>';
    }

    private function md(string $content): array
    {
        return ['type' => 'markdown', 'content' => $content, 'editable' => false];
    }

    private function code(string $content, bool $editable = true): array
    {
        return ['type' => 'code', 'content' => $content, 'editable' => $editable];
    }

    public function run(): void
    {
        // Clean existing content for course 4
        $chapters = Chapter::where('course_id', $this->courseId)->get();
        foreach ($chapters as $ch) {
            foreach ($ch->subchapters as $sub) {
                $sub->lessons()->delete();
            }
            $ch->subchapters()->delete();
        }
        $chapters->each->delete();

        // ============================================================
        // CHAPTER 1: Uvod u Jupyter
        // ============================================================
        $ch1 = Chapter::create(['course_id' => $this->courseId, 'title' => 'Uvod u Jupyter', 'order' => 1]);

        $sub1_1 = Subchapter::create(['chapter_id' => $ch1->id, 'title' => 'Upoznavanje sa Jupyterom', 'order' => 1]);

        // Lesson 1.1.1 - Sta je Jupyter?
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub1_1->id,
            'title' => 'Sta je Jupyter?',
            'content' => '<h2>Sta je Jupyter?</h2>'
                . '<p>Zamisli da imas carobnu svesku u koju mozes da pises tekst, ali i da racunas i crtas grafike - sve na jednom mestu! To je <strong>Jupyter notebook</strong> (cita se "dzupajter").</p>'
                . '<p>Jupyter je alat koji koriste naucnici, programeri i ucenici sirom sveta da bi:</p>'
                . '<ul>'
                . '<li>Pisali i pokretali Python programe korak po korak</li>'
                . '<li>Videli rezultate odmah ispod koda</li>'
                . '<li>Pravili grafike i dijagrame</li>'
                . '<li>Pisali objasnjenja i beleske pored koda</li>'
                . '</ul>'
                . '<h3>Zasto se zove Jupyter?</h3>'
                . '<p>Ime dolazi od tri programska jezika: <strong>Ju</strong>lia, <strong>Pyt</strong>hon i <strong>R</strong>. Mi cemo koristiti Python, koji vec znamo!</p>'
                . '<h3>Kako Jupyter radi?</h3>'
                . '<p>Jupyter notebook se sastoji od <strong>celija</strong> (polja). Postoje dve vrste celija:</p>'
                . '<ol>'
                . '<li><strong>Celije sa kodom</strong> - u njih pisemo Python kod i pokrecemo ga</li>'
                . '<li><strong>Celije sa tekstom</strong> - u njih pisemo objasnjenja (koriste Markdown format)</li>'
                . '</ol>'
                . '<p>Pogledaj primer ispod. Imas notebook sa dve celije - jednom za opis i jednom za kod. Klikni na zeleno dugme <strong>Run All</strong> da pokrenes kod!</p>'
                . $this->notebook([
                    $this->md("# Moj prvi notebook\nOvo je celija sa tekstom. Ispod je celija sa kodom."),
                    $this->code("# Ovo je celija sa kodom - klikni Run All!\nprint('Zdravo, ja sam Jupyter!')\nprint('Danas ucimo nesto novo i zanimljivo!')"),
                ])
                . '<p>Kao sto vidis, rezultat se pojavljuje odmah ispod koda. To je velika prednost Jupytera - ne moras da pokreces ceo program, vec mozes da testiras delove koda jedan po jedan.</p>'
                . '<h3>Gde se Jupyter koristi?</h3>'
                . '<p>Jupyter se koristi svuda:</p>'
                . '<ul>'
                . '<li><strong>U skolama</strong> - za ucenje programiranja i matematike</li>'
                . '<li><strong>U nauci</strong> - naucnici analiziraju podatke i prave grafike</li>'
                . '<li><strong>U firmama</strong> - analiticari proucavaju prodaju, korisnike, trendove</li>'
                . '<li><strong>U novinarstvu</strong> - novinari analiziraju podatke za price</li>'
                . '</ul>',
            'order' => 1,
            'is_assignment' => false,
        ]);

        // Lesson 1.1.2 - Jupyter celije
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub1_1->id,
            'title' => 'Jupyter celije',
            'content' => '<h2>Jupyter celije</h2>'
                . '<p>Osnovna gradivna jedinica u Jupyteru je <strong>celija</strong>. Svaka celija je kao jedna kockica u Lego slagalici - mozes ih slagati jednu na drugu i svaka radi svoj posao.</p>'
                . '<h3>Celija sa kodom</h3>'
                . '<p>U celiju sa kodom pises Python kod. Kada pokrenes celiju, Python izvrsi kod i prikaze rezultat ispod.</p>'
                . '<p><strong>Vazno:</strong> Poslednji izraz u celiji se automatski prikazuje kao rezultat, cak i bez <code>print()</code>!</p>'
                . $this->notebook([
                    $this->md("## Automatski prikaz rezultata\nU Jupyteru ne moras uvek da koristis `print()`. Poslednji izraz u celiji se automatski prikazuje:"),
                    $this->code("# Sa print - prikazuje sve\nprint('Prvi red')\nprint('Drugi red')"),
                    $this->code("# Bez print - samo poslednji izraz\n2 + 3\n10 * 5"),
                    $this->md("Vidis razliku? Sa `print()` se prikazuje sve, a bez njega samo poslednja vrednost (50)."),
                ])
                . '<h3>Celija sa tekstom (Markdown)</h3>'
                . '<p>Markdown celije sluze za objasnjenja. U njima mozes pisati naslove, liste, podebljani tekst i slicno.</p>'
                . '<h3>Redosled pokretanja je bitan!</h3>'
                . '<p>Svaka celija sa kodom ima svoj redni broj pokretanja. Ako u jednoj celiji napravis promenljivu, mozete je koristiti u sledecoj celiji. Ali paznja - celije se moraju pokretati redom!</p>'
                . $this->notebook([
                    $this->md("## Promenljive izmedju celija\nPromenljiva napravljena u jednoj celiji moze se koristiti u drugoj:"),
                    $this->code("ime = 'Marko'\ngodine = 14"),
                    $this->code("# Koristimo promenljive iz prethodne celije\nprint(f'{ime} ima {godine} godina.')"),
                    $this->code("# Mozemo i menjati promenljive\ngodine = godine + 1\nprint(f'Sledece godine {ime} ce imati {godine} godina.')"),
                ])
                . '<h3>Probaj sam!</h3>'
                . '<p>U notebooku ispod, dopisi kod u prazne celije:</p>'
                . $this->notebook([
                    $this->md("## Vezba: Moje promenljive\nPopuni celije ispod:"),
                    $this->code("# 1. Napravi promenljivu 'predmet' sa vrednoscu 'Informatika'\npredmet = "),
                    $this->code("# 2. Napravi promenljivu 'ocena' sa tvojom ocenom iz informatike\nocena = "),
                    $this->code("# 3. Ispisi recenicu koristeci obe promenljive\nprint(f'Iz predmeta {predmet} imam ocenu {ocena}.')"),
                ]),
            'order' => 2,
            'is_assignment' => false,
        ]);

        // Lesson 1.1.3 - Racunanje u Jupyteru
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub1_1->id,
            'title' => 'Racunanje u Jupyteru',
            'content' => '<h2>Racunanje u Jupyteru</h2>'
                . '<p>Jupyter je savrseni digitron! Mozes da racunas sve - od prostih operacija do slozenih formula.</p>'
                . '<h3>Osnovne operacije</h3>'
                . $this->notebook([
                    $this->md("## Jupyter kao digitron\nProbaj sve operacije:"),
                    $this->code("# Sabiranje i oduzimanje\nprint('5 + 3 =', 5 + 3)\nprint('100 - 37 =', 100 - 37)"),
                    $this->code("# Mnozenje i deljenje\nprint('6 * 7 =', 6 * 7)\nprint('100 / 3 =', 100 / 3)"),
                    $this->code("# Celobrojno deljenje i ostatak\nprint('17 // 5 =', 17 // 5)  # koliko celih puta\nprint('17 % 5 =', 17 % 5)    # ostatak"),
                    $this->code("# Stepenovanje\nprint('2 na 10 =', 2 ** 10)\nprint('3 na 4 =', 3 ** 4)"),
                ])
                . '<h3>Biblioteka math</h3>'
                . '<p>Za naprednije racunanje koristimo biblioteku <code>math</code>. Biblioteka je kao kutija sa alatima - uvozimo je sa <code>import</code>.</p>'
                . $this->notebook([
                    $this->md("## Biblioteka math\nSa `import math` dobijamo pristup mnogim korisnim funkcijama:"),
                    $this->code("import math\n\n# Kvadratni koren\nprint('Koren od 144 =', math.sqrt(144))\nprint('Koren od 2 =', math.sqrt(2))"),
                    $this->code("# Pi i zaokruzivanje\nprint('Pi =', math.pi)\nprint('Pi zaokruzeno na 2 decimale =', round(math.pi, 2))"),
                    $this->code("# Apsolutna vrednost i zaokruzivanje\nprint('|-7| =', abs(-7))\nprint('Zaokruzi 3.7 =', round(3.7))\nprint('Zaokruzi 3.2 =', round(3.2))"),
                ])
                . '<h3>Primer iz zivota</h3>'
                . '<p>Zamisli da planiras zurku za rodjendan. Treba ti digitron da izracunas koliko cega treba da kupis!</p>'
                . $this->notebook([
                    $this->md("## Planiranje rodjendana\nIzracunaj koliko sve kosta:"),
                    $this->code("# Podaci\nbroj_gostiju = 12\ncena_pizze = 850     # jedna pizza za 4 osobe\ncena_soka = 180      # sok za 3 osobe\ncena_torte = 2500    # jedna torta\n\n# Racunanje\nimport math\nbroj_pizza = math.ceil(broj_gostiju / 4)  # zaokruzi navise!\nbroj_sokova = math.ceil(broj_gostiju / 3)\n\nukupno = broj_pizza * cena_pizze + broj_sokova * cena_soka + cena_torte\n\nprint(f'Za {broj_gostiju} gostiju treba:')\nprint(f'  Pizza: {broj_pizza} komada = {broj_pizza * cena_pizze} din')\nprint(f'  Sokovi: {broj_sokova} komada = {broj_sokova * cena_soka} din')\nprint(f'  Torta: {cena_torte} din')\nprint(f'  UKUPNO: {ukupno} din')"),
                ]),
            'order' => 3,
            'is_assignment' => false,
        ]);

        // Lesson 1.1.4 - Domaci: Moj prvi notebook
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub1_1->id,
            'title' => 'Domaci: Moj prvi notebook',
            'content' => '<h2>Domaci: Moj prvi notebook</h2>'
                . '<p>Vreme je da sam napravis nesto u Jupyteru! Resi zadatke ispod.</p>'
                . $this->notebook([
                    $this->md("# Domaci zadatak: Moj prvi notebook\n\n## Zadatak 1: Predstavi se\nU celiji ispod napravi promenljive sa tvojim podacima i ispisi ih."),
                    $this->code("# Napravi promenljive i ispisi ih\nime = ''\nprezime = ''\nrazred = 8\nomiljeni_predmet = ''\n\n# Ispisi lepu recenicu sa svim podacima\n"),
                    $this->md("## Zadatak 2: Digitron\nIzracunaj koliko sekundi ima u jednom danu, jednoj nedelji i jednoj godini."),
                    $this->code("# Koliko sekundi ima u...\nsekundi_u_minutu = 60\nminuta_u_satu = 60\nsati_u_danu = 24\n\n# Izracunaj i ispisi:\n# - sekundi u jednom danu\n# - sekundi u jednoj nedelji\n# - sekundi u jednoj godini (365 dana)\n"),
                    $this->md("## Zadatak 3: Prosek ocena\nIzracunaj prosek svojih ocena iz informatike koristeci Python."),
                    $this->code("# Upisi svoje ocene iz informatike\nocene = [5, 4, 5, 5, 4]  # zameni svojim ocenama\n\n# Izracunaj prosek\nprosek = sum(ocene) / len(ocene)\nprint(f'Moje ocene: {ocene}')\nprint(f'Prosek: {prosek}')\nprint(f'Zaokruzeno: {round(prosek, 2)}')"),
                    $this->md("## Zadatak 4: Povrsina i obim\nKoristeci `math.pi`, izracunaj obim i povrsinu kruga sa poluprecnikom 7 cm."),
                    $this->code("import math\n\nr = 7  # poluprecnik u cm\n\n# Izracunaj obim (O = 2 * pi * r) i povrsinu (P = pi * r^2)\n"),
                ]),
            'order' => 4,
            'is_assignment' => true,
        ]);

        // ============================================================
        // CHAPTER 2: Nizovi podataka i dijagrami
        // ============================================================
        $ch2 = Chapter::create(['course_id' => $this->courseId, 'title' => 'Nizovi podataka i dijagrami', 'order' => 2]);

        $sub2_1 = Subchapter::create(['chapter_id' => $ch2->id, 'title' => 'Liste i vizuelizacija', 'order' => 1]);

        // Lesson 2.1.1 - Nizovi (liste) podataka
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub2_1->id,
            'title' => 'Nizovi (liste) podataka',
            'content' => '<h2>Nizovi (liste) podataka</h2>'
                . '<p>U svakodnevnom zivotu stalno radimo sa nizovima podataka. Temperature tokom nedelje, ocene iz predmeta, broj golova po utakmici... U Pythonu koristimo <strong>liste</strong> da cuvamo ovakve podatke.</p>'
                . '<h3>Sta je lista?</h3>'
                . '<p>Lista je uredjen niz podataka u uglastim zagradama. Zamisli je kao policu za knjige - svaka knjiga ima svoje mesto (indeks), pocevsi od 0.</p>'
                . $this->notebook([
                    $this->md("## Liste u Pythonu\nLista je niz vrednosti u uglastim zagradama:"),
                    $this->code("# Lista ocena\nocene = [5, 4, 5, 3, 5, 4, 5]\nprint('Ocene:', ocene)\nprint('Broj ocena:', len(ocene))"),
                    $this->code("# Pristup elementima - indeks pocinje od 0!\nprint('Prva ocena:', ocene[0])\nprint('Poslednja ocena:', ocene[-1])\nprint('Prva tri:', ocene[0:3])"),
                    $this->code("# Lista moze da sadrzi razlicite tipove\nucenici = ['Ana', 'Marko', 'Jovana', 'Stefan']\nprint('Ucenici:', ucenici)\nprint('Drugi ucenik:', ucenici[1])"),
                ])
                . '<h3>Operacije sa listama</h3>'
                . $this->notebook([
                    $this->md("## Korisne operacije sa listama"),
                    $this->code("ocene = [5, 4, 5, 3, 5, 4, 5]\n\nprint('Zbir:', sum(ocene))\nprint('Najmanji:', min(ocene))\nprint('Najveci:', max(ocene))\nprint('Prosek:', sum(ocene) / len(ocene))"),
                    $this->code("# Dodavanje i brisanje\nocene.append(5)      # dodaj na kraj\nprint('Posle dodavanja:', ocene)\n\nocene.remove(3)      # ukloni prvo pojavljivanje broja 3\nprint('Posle brisanja:', ocene)"),
                    $this->code("# Sortiranje\nbrojevi = [42, 17, 8, 95, 33, 61]\nprint('Originalno:', brojevi)\nprint('Sortirano:', sorted(brojevi))\nprint('Obrnuto:', sorted(brojevi, reverse=True))"),
                ])
                . '<h3>Liste brojeva pomazu u analizi</h3>'
                . '<p>Kada imamo listu brojeva, mozemo lako izracunati razne statistike. To je upravo ono sto naucnici i analiticari rade svaki dan!</p>'
                . $this->notebook([
                    $this->md("## Primer: Temperature u Beogradu (jedna nedelja u martu)"),
                    $this->code("temperature = [12, 14, 11, 15, 17, 16, 13]\ndani = ['Pon', 'Uto', 'Sre', 'Cet', 'Pet', 'Sub', 'Ned']\n\nprint('Temperature po danima:')\nfor dan, temp in zip(dani, temperature):\n    print(f'  {dan}: {temp} C')\n\nprint(f'\\nProsecna temperatura: {sum(temperature)/len(temperature):.1f} C')\nprint(f'Najhladniji dan: {dani[temperature.index(min(temperature))]} ({min(temperature)} C)')\nprint(f'Najtopliji dan: {dani[temperature.index(max(temperature))]} ({max(temperature)} C)')"),
                ]),
            'order' => 1,
            'is_assignment' => false,
        ]);

        // Lesson 2.1.2 - Linijski dijagrami
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub2_1->id,
            'title' => 'Linijski dijagrami',
            'content' => '<h2>Linijski dijagrami</h2>'
                . '<p>Sto bi rekli "slika vredi hiljadu reci". Umesto da gledamo dugacke liste brojeva, mozemo nacrtati <strong>dijagram</strong> i odmah videti trendove i obrasce.</p>'
                . '<p>Za crtanje dijagrama koristimo biblioteku <code>matplotlib</code> - najpoznatiju Python biblioteku za grafike.</p>'
                . '<h3>Prvi dijagram</h3>'
                . $this->notebook([
                    $this->md("## Crtamo linijski dijagram\nBiblioteka `matplotlib.pyplot` se obicno uvozi kao `plt`:"),
                    $this->code("import matplotlib.pyplot as plt\n\n# Temperature tokom nedelje\ndani = ['Pon', 'Uto', 'Sre', 'Cet', 'Pet', 'Sub', 'Ned']\ntemperature = [12, 14, 11, 15, 17, 16, 13]\n\nplt.plot(dani, temperature)\nplt.title('Temperature u martu')\nplt.ylabel('Temperatura (C)')\nplt.show()"),
                    $this->md("## Lepsi dijagram\nMozemo dodati boje, markere i mrezu:"),
                    $this->code("import matplotlib.pyplot as plt\n\ndani = ['Pon', 'Uto', 'Sre', 'Cet', 'Pet', 'Sub', 'Ned']\ntemperature = [12, 14, 11, 15, 17, 16, 13]\n\nplt.figure(figsize=(8, 4))\nplt.plot(dani, temperature, color='tomato', marker='o', linewidth=2)\nplt.fill_between(range(len(dani)), temperature, alpha=0.2, color='tomato')\nplt.title('Temperature tokom nedelje', fontsize=14)\nplt.ylabel('Temperatura (C)')\nplt.grid(True, alpha=0.3)\nplt.show()"),
                ])
                . '<h3>Vise linija na jednom dijagramu</h3>'
                . '<p>Mozemo uporediti vise nizova podataka na istom grafiku:</p>'
                . $this->notebook([
                    $this->md("## Poredjenje: Beograd vs Novi Sad"),
                    $this->code("import matplotlib.pyplot as plt\n\ndani = ['Pon', 'Uto', 'Sre', 'Cet', 'Pet', 'Sub', 'Ned']\nbeograd = [12, 14, 11, 15, 17, 16, 13]\nnovi_sad = [11, 13, 10, 14, 16, 15, 12]\n\nplt.figure(figsize=(8, 4))\nplt.plot(dani, beograd, marker='o', label='Beograd', color='crimson')\nplt.plot(dani, novi_sad, marker='s', label='Novi Sad', color='steelblue')\nplt.title('Poredjenje temperatura')\nplt.ylabel('Temperatura (C)')\nplt.legend()\nplt.grid(True, alpha=0.3)\nplt.show()"),
                ])
                . '<h3>Kada koristimo linijski dijagram?</h3>'
                . '<p>Linijski dijagrami su najbolji kada:</p>'
                . '<ul>'
                . '<li>Podaci se menjaju tokom vremena (temperature, cene, ocene...)</li>'
                . '<li>Zelimo da vidimo trend - da li nesto raste ili opada</li>'
                . '<li>Poredimo dva ili vise nizova podataka</li>'
                . '</ul>',
            'order' => 2,
            'is_assignment' => false,
        ]);

        // Lesson 2.1.3 - Stubicasti dijagrami i histogrami
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub2_1->id,
            'title' => 'Stubicasti dijagrami i histogrami',
            'content' => '<h2>Stubicasti dijagrami i histogrami</h2>'
                . '<p>Linijski dijagrami su odlicni za trendove, ali ponekad zelimo da <strong>uporedimo velicine</strong>. Za to koristimo stubicaste dijagrame!</p>'
                . '<h3>Stubicasti dijagram (bar chart)</h3>'
                . $this->notebook([
                    $this->md("## Stubicasti dijagram\nKoristi `plt.bar()` umesto `plt.plot()`:"),
                    $this->code("import matplotlib.pyplot as plt\n\npredmeti = ['Matem.', 'Srpski', 'Inform.', 'Fizika', 'Biolog.']\nocene = [4, 5, 5, 3, 4]\nboje = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7']\n\nplt.figure(figsize=(8, 4))\nplt.bar(predmeti, ocene, color=boje)\nplt.title('Moje ocene po predmetima')\nplt.ylabel('Ocena')\nplt.ylim(0, 5.5)\nplt.grid(axis='y', alpha=0.3)\nplt.show()"),
                    $this->md("## Horizontalni stubici\nPonekad je preglednije nacrtati stubice horizontalno:"),
                    $this->code("import matplotlib.pyplot as plt\n\nucenici = ['Ana', 'Marko', 'Jovana', 'Stefan', 'Milica', 'Lazar']\nbodovi = [92, 85, 97, 78, 88, 95]\n\nplt.figure(figsize=(8, 4))\nplt.barh(ucenici, bodovi, color='steelblue')\nplt.title('Bodovi na takmicenju')\nplt.xlabel('Bodovi')\nplt.xlim(0, 100)\nplt.grid(axis='x', alpha=0.3)\nplt.show()"),
                ])
                . '<h3>Histogram</h3>'
                . '<p>Histogram pokazuje koliko cesto se pojavljuju vrednosti u odredjenom opsegu. Na primer, koliko ucenika ima ocene 1, 2, 3, 4 ili 5.</p>'
                . $this->notebook([
                    $this->md("## Histogram\nHistogram automatski grupishe podatke u intervale:"),
                    $this->code("import matplotlib.pyplot as plt\n\n# Ocene svih ucenika u odeljenju\nocene_odeljenja = [5, 4, 5, 3, 4, 5, 5, 4, 3, 5,\n                   4, 4, 5, 2, 4, 5, 3, 4, 5, 4,\n                   5, 3, 4, 4, 5, 4, 3, 5, 4, 5]\n\nplt.figure(figsize=(8, 4))\nplt.hist(ocene_odeljenja, bins=[1.5, 2.5, 3.5, 4.5, 5.5],\n         color='mediumpurple', edgecolor='white', rwidth=0.8)\nplt.title('Raspodela ocena u odeljenju')\nplt.xlabel('Ocena')\nplt.ylabel('Broj ucenika')\nplt.xticks([2, 3, 4, 5])\nplt.grid(axis='y', alpha=0.3)\nplt.show()"),
                ])
                . '<h3>Kada sta koristimo?</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Dijagram</th><th>Kada koristimo</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td>Linijski</td><td>Promena tokom vremena</td><td>Temperature po danima</td></tr>'
                . '<tr><td>Stubicasti</td><td>Poredjenje kategorija</td><td>Ocene po predmetima</td></tr>'
                . '<tr><td>Histogram</td><td>Raspodela vrednosti</td><td>Koliko ucenika ima koju ocenu</td></tr>'
                . '</tbody></table>',
            'order' => 3,
            'is_assignment' => false,
        ]);

        // Lesson 2.1.4 - Domaci: Vizuelizacija podataka
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub2_1->id,
            'title' => 'Domaci: Vizuelizacija podataka',
            'content' => '<h2>Domaci: Vizuelizacija podataka</h2>'
                . '<p>Nacrtaj dijagrame na osnovu podataka ispod.</p>'
                . $this->notebook([
                    $this->md("# Domaci: Vizuelizacija podataka\n\n## Zadatak 1: Moje ocene\nNapravi stubicasti dijagram svojih ocena iz svih predmeta. Koristi razlicite boje za svaki stubic."),
                    $this->code("import matplotlib.pyplot as plt\n\n# Zameni svojim predmetima i ocenama\npredmeti = ['Matem.', 'Srpski', 'Inform.']\nocene = [4, 5, 5]\n\n# Nacrtaj stubicasti dijagram\n"),
                    $this->md("## Zadatak 2: Temperature\nEvo temperatura u Zrenjaninu tokom dve nedelje. Nacrtaj linijski dijagram sa obe nedelje na istom grafiku."),
                    $this->code("import matplotlib.pyplot as plt\n\ndani = ['Pon', 'Uto', 'Sre', 'Cet', 'Pet', 'Sub', 'Ned']\nnedelja1 = [8, 10, 12, 11, 14, 15, 13]\nnedelja2 = [15, 17, 16, 18, 20, 19, 17]\n\n# Nacrtaj obe linije na istom grafiku\n# Dodaj naslov, oznake osa, legendu i mrezu\n"),
                    $this->md("## Zadatak 3: Anketa u odeljenju\nPitao si drugare koji im je omiljeni sport. Rezultati:"),
                    $this->code("import matplotlib.pyplot as plt\n\nsportovi = ['Fudbal', 'Kosarka', 'Odbojka', 'Tenis', 'Plivanje']\nglasovi = [12, 8, 5, 3, 2]\n\n# Nacrtaj horizontalni stubicasti dijagram\n# Sortiraj od najveceg do najmanjeg broja glasova\n"),
                ]),
            'order' => 4,
            'is_assignment' => true,
        ]);

        // ============================================================
        // CHAPTER 3: Prosek, procenti i analiza
        // ============================================================
        $ch3 = Chapter::create(['course_id' => $this->courseId, 'title' => 'Prosek, procenti i analiza', 'order' => 3]);

        $sub3_1 = Subchapter::create(['chapter_id' => $ch3->id, 'title' => 'Analiza podataka', 'order' => 1]);

        // Lesson 3.1.1 - Prosek niza brojeva
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub3_1->id,
            'title' => 'Prosek niza brojeva',
            'content' => '<h2>Prosek niza brojeva</h2>'
                . '<p>Prosek (aritmeticka sredina) je jedan od najvaznijih pojmova u matematici i analizi podataka. Izracunava se tako sto saberemo sve brojeve i podelimo sa brojem elemenata.</p>'
                . '<h3>Racunanje proseka</h3>'
                . $this->notebook([
                    $this->md("## Prosek - tri nacina\nU Pythonu mozemo izracunati prosek na vise nacina:"),
                    $this->code("# Nacin 1: rucno\nocene = [5, 4, 5, 3, 4, 5]\nprosek = sum(ocene) / len(ocene)\nprint(f'Prosek (rucno): {prosek:.2f}')"),
                    $this->code("# Nacin 2: sa statistics bibliotekom\nimport statistics\nocene = [5, 4, 5, 3, 4, 5]\nprint(f'Prosek: {statistics.mean(ocene):.2f}')\nprint(f'Medijana: {statistics.median(ocene)}')\nprint(f'Najcesci (mod): {statistics.mode(ocene)}')"),
                    $this->md("### Sta je medijana?\nMedijana je srednja vrednost kada poredamo brojeve po velicini. Ako imamo [3, 4, 4, 5, 5, 5], medijana je (4+5)/2 = 4.5\n\n### Sta je mod?\nMod je vrednost koja se najcesce pojavljuje. U nasem primeru, 5 se pojavljuje 3 puta."),
                ])
                . '<h3>Primer: Analiza temperature</h3>'
                . $this->notebook([
                    $this->md("## Mesecne temperature u Zrenjaninu (2024)"),
                    $this->code("import matplotlib.pyplot as plt\nimport statistics\n\nmeseci = ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun',\n          'Jul', 'Avg', 'Sep', 'Okt', 'Nov', 'Dec']\ntemperature = [1, 3, 9, 14, 19, 23, 26, 25, 20, 14, 8, 2]\n\nprosek = statistics.mean(temperature)\nprint(f'Prosecna godisnja temperatura: {prosek:.1f} C')\nprint(f'Najhladniji mesec: {meseci[temperature.index(min(temperature))]} ({min(temperature)} C)')\nprint(f'Najtopliji mesec: {meseci[temperature.index(max(temperature))]} ({max(temperature)} C)')\n\n# Dijagram sa linijom proseka\nplt.figure(figsize=(10, 4))\nplt.bar(meseci, temperature, color=['#4FC3F7' if t < prosek else '#FF7043' for t in temperature])\nplt.axhline(y=prosek, color='gray', linestyle='--', label=f'Prosek ({prosek:.1f} C)')\nplt.title('Mesecne temperature u Zrenjaninu')\nplt.ylabel('Temperatura (C)')\nplt.legend()\nplt.grid(axis='y', alpha=0.3)\nplt.show()"),
                ]),
            'order' => 1,
            'is_assignment' => false,
        ]);

        // Lesson 3.1.2 - Procenti i sektorski dijagrami
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub3_1->id,
            'title' => 'Procenti i sektorski dijagrami',
            'content' => '<h2>Procenti i sektorski dijagrami</h2>'
                . '<p>Procenat znaci "od sto" (per centum na latinskom). Ako imas 5 jabuka od ukupno 20 voca, jabuke cine 5/20 = 0.25 = 25% ukupnog voca.</p>'
                . '<h3>Racunanje procenata</h3>'
                . $this->notebook([
                    $this->md("## Procenti u Pythonu"),
                    $this->code("# Koliko procenata cini deo od celine?\ndevojcice = 14\ndecki = 16\nukupno = devojcice + decki\n\nprocenat_devojcica = (devojcice / ukupno) * 100\nprocenat_decaka = (decki / ukupno) * 100\n\nprint(f'Devojcice: {devojcice} od {ukupno} = {procenat_devojcica:.1f}%')\nprint(f'Decki: {decki} od {ukupno} = {procenat_decaka:.1f}%')\nprint(f'Ukupno: {procenat_devojcica + procenat_decaka:.1f}%')"),
                ])
                . '<h3>Sektorski dijagram (pie chart)</h3>'
                . '<p>Sektorski dijagram prikazuje delove celine. Svaki "parce" pokazuje koliki procenat zauzima.</p>'
                . $this->notebook([
                    $this->md("## Sektorski dijagram - omiljeni predmeti"),
                    $this->code("import matplotlib.pyplot as plt\n\npredmeti = ['Informatika', 'Fizicko', 'Matematika', 'Likovno', 'Muzicko']\nglasovi = [12, 8, 5, 3, 2]\nboje = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7']\n\nplt.figure(figsize=(8, 6))\nplt.pie(glasovi, labels=predmeti, colors=boje,\n        autopct='%1.1f%%', startangle=90,\n        textprops={'fontsize': 12})\nplt.title('Omiljeni predmeti u odeljenju', fontsize=14)\nplt.show()"),
                    $this->md("## Jos lepsi dijagram\nMozemo \"izvuci\" najveci deo i dodati senku:"),
                    $this->code("import matplotlib.pyplot as plt\n\npredmeti = ['Informatika', 'Fizicko', 'Matematika', 'Likovno', 'Muzicko']\nglasovi = [12, 8, 5, 3, 2]\nboje = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7']\nizvuci = [0.1, 0, 0, 0, 0]  # izvuci Informatiku\n\nplt.figure(figsize=(8, 6))\nplt.pie(glasovi, labels=predmeti, colors=boje,\n        autopct='%1.1f%%', startangle=90,\n        explode=izvuci, shadow=True,\n        textprops={'fontsize': 12})\nplt.title('Omiljeni predmeti u odeljenju', fontsize=14)\nplt.show()"),
                ]),
            'order' => 2,
            'is_assignment' => false,
        ]);

        // Lesson 3.1.3 - Frekvencijska analiza
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub3_1->id,
            'title' => 'Frekvencijska analiza',
            'content' => '<h2>Frekvencijska analiza</h2>'
                . '<p>Frekvencija znaci "koliko cesto se nesto pojavljuje". Ako bacis kockicu 100 puta, koliko cesto ce pasti svaki broj? To je frekvencijska analiza!</p>'
                . '<h3>Brojanje pojavljivanja</h3>'
                . $this->notebook([
                    $this->md("## Koliko se cesto pojavljuje svaki element?"),
                    $this->code("# Ocene u odeljenju\nocene = [5, 4, 5, 3, 4, 5, 5, 4, 3, 5,\n         4, 4, 5, 2, 4, 5, 3, 4, 5, 4,\n         5, 3, 4, 4, 5, 4, 3, 5, 4, 5]\n\n# Nacin 1: rucno brojanje\nfor ocena in [1, 2, 3, 4, 5]:\n    broj = ocene.count(ocena)\n    procenat = (broj / len(ocene)) * 100\n    print(f'Ocena {ocena}: {broj} ucenika ({procenat:.0f}%)')"),
                    $this->code("# Nacin 2: sa collections.Counter\nfrom collections import Counter\n\nocene = [5, 4, 5, 3, 4, 5, 5, 4, 3, 5,\n         4, 4, 5, 2, 4, 5, 3, 4, 5, 4,\n         5, 3, 4, 4, 5, 4, 3, 5, 4, 5]\n\nbrojac = Counter(ocene)\nprint('Frekvencije:', dict(brojac))\nprint('Najcesca ocena:', brojac.most_common(1)[0])"),
                ])
                . '<h3>Vizuelizacija frekvencija</h3>'
                . $this->notebook([
                    $this->md("## Frekvencijski dijagram"),
                    $this->code("import matplotlib.pyplot as plt\nfrom collections import Counter\n\nocene = [5, 4, 5, 3, 4, 5, 5, 4, 3, 5,\n         4, 4, 5, 2, 4, 5, 3, 4, 5, 4,\n         5, 3, 4, 4, 5, 4, 3, 5, 4, 5]\n\nbrojac = Counter(ocene)\nvrste = sorted(brojac.keys())\nfrekvencije = [brojac[v] for v in vrste]\n\nplt.figure(figsize=(8, 4))\nbars = plt.bar(vrste, frekvencije, color=['#e74c3c', '#e67e22', '#f39c12', '#2ecc71', '#3498db'])\nplt.title('Raspodela ocena u odeljenju')\nplt.xlabel('Ocena')\nplt.ylabel('Broj ucenika')\n\n# Dodaj broj iznad svakog stubica\nfor bar, freq in zip(bars, frekvencije):\n    plt.text(bar.get_x() + bar.get_width()/2, bar.get_height() + 0.3,\n             str(freq), ha='center', fontsize=12, fontweight='bold')\n\nplt.grid(axis='y', alpha=0.3)\nplt.show()"),
                ])
                . '<h3>Primer iz zivota: Anketa</h3>'
                . $this->notebook([
                    $this->md("## Mini anketa: Omiljeni sport\nAnaliziramo odgovore iz ankete:"),
                    $this->code("import matplotlib.pyplot as plt\nfrom collections import Counter\n\nodgovori = ['fudbal', 'kosarka', 'fudbal', 'tenis', 'fudbal',\n            'odbojka', 'kosarka', 'fudbal', 'plivanje', 'fudbal',\n            'kosarka', 'odbojka', 'fudbal', 'tenis', 'kosarka',\n            'fudbal', 'plivanje', 'kosarka', 'fudbal', 'odbojka']\n\nbrojac = Counter(odgovori)\nprint('Rezultati ankete:')\nfor sport, broj in brojac.most_common():\n    procenat = (broj / len(odgovori)) * 100\n    traka = '#' * broj\n    print(f'  {sport:10s} {traka} {broj} ({procenat:.0f}%)')\n\n# Sektorski dijagram\nplt.figure(figsize=(7, 7))\nplt.pie(brojac.values(), labels=brojac.keys(),\n        autopct='%1.0f%%', startangle=90,\n        colors=['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7'])\nplt.title('Omiljeni sport u odeljenju')\nplt.show()"),
                ]),
            'order' => 3,
            'is_assignment' => false,
        ]);

        // Lesson 3.1.4 - Domaci: Analiza podataka
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub3_1->id,
            'title' => 'Domaci: Analiza podataka',
            'content' => '<h2>Domaci: Analiza podataka</h2>'
                . $this->notebook([
                    $this->md("# Domaci: Analiza podataka\n\n## Zadatak 1: Prosek i statistika\nIzracunaj prosek, medijanu i mod za ocene tvog odeljenja iz matematike. Nacrtaj histogram."),
                    $this->code("import matplotlib.pyplot as plt\nimport statistics\n\n# Ocene tvog odeljenja iz matematike (zameni pravim ocenama)\nocene = [5, 4, 3, 5, 4, 4, 3, 5, 2, 4, 5, 3, 4, 5, 4]\n\n# Izracunaj prosek, medijanu i mod\n\n# Nacrtaj histogram\n"),
                    $this->md("## Zadatak 2: Procenat\nU odeljenju od 30 ucenika, 18 je polozilo test. Koliki procenat je polozio, a koliki nije? Nacrtaj sektorski dijagram."),
                    $this->code("import matplotlib.pyplot as plt\n\npolozili = 18\nukupno = 30\n\n# Izracunaj procente\n\n# Nacrtaj sektorski dijagram\n"),
                    $this->md("## Zadatak 3: Frekvencijska analiza\nAnketiraj odeljenje o omiljenom godishnjem dobu (prolece, leto, jesen, zima). Unesi odgovore u listu i napravi frekvencijski dijagram i sektorski dijagram."),
                    $this->code("import matplotlib.pyplot as plt\nfrom collections import Counter\n\n# Unesi odgovore ankete\nodgovori = ['leto', 'prolece', 'leto', 'zima']  # dopuni\n\n# Frekvencijska analiza\n\n# Nacrtaj oba dijagrama\n"),
                ]),
            'order' => 4,
            'is_assignment' => true,
        ]);

        // ============================================================
        // CHAPTER 4: Tabele (pandas)
        // ============================================================
        $ch4 = Chapter::create(['course_id' => $this->courseId, 'title' => 'Tabele i pandas', 'order' => 4]);

        $sub4_1 = Subchapter::create(['chapter_id' => $ch4->id, 'title' => 'Rad sa tabelama', 'order' => 1]);

        // Lesson 4.1.1 - Tabelarno predstavljanje podataka
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub4_1->id,
            'title' => 'Tabelarno predstavljanje podataka',
            'content' => '<h2>Tabelarno predstavljanje podataka</h2>'
                . '<p>Tabele su svuda oko nas - dnevnik, raspored casova, cenovnik u prodavnici, fudbalska tabela... U Pythonu koristimo biblioteku <strong>pandas</strong> za rad sa tabelama.</p>'
                . '<h3>Sta je pandas?</h3>'
                . '<p>Pandas je Python biblioteka koja nam omogucava da radimo sa tabelama kao u Excel-u, ali sa mnogo vise mogucnosti. Osnovna struktura je <strong>DataFrame</strong> - tabela sa vrstama i kolonama.</p>'
                . $this->notebook([
                    $this->md("## Pravimo prvu tabelu\nTabelu pravimo od recnika (dictionary):"),
                    $this->code("import pandas as pd\n\n# Podaci o ucenicima\npodaci = {\n    'Ime': ['Ana', 'Marko', 'Jovana', 'Stefan', 'Milica'],\n    'Razred': ['8-1', '8-1', '8-2', '8-2', '8-1'],\n    'Matematika': [5, 4, 5, 3, 4],\n    'Informatika': [5, 5, 4, 4, 5],\n    'Srpski': [4, 3, 5, 4, 5]\n}\n\ntabela = pd.DataFrame(podaci)\nprint(tabela)"),
                    $this->code("# Informacije o tabeli\nprint('Oblik tabele:', tabela.shape)  # (redovi, kolone)\nprint('Kolone:', list(tabela.columns))\nprint('Tipovi podataka:')\nprint(tabela.dtypes)"),
                ])
                . '<h3>Pristup podacima</h3>'
                . $this->notebook([
                    $this->md("## Citamo podatke iz tabele"),
                    $this->code("import pandas as pd\n\npodaci = {\n    'Ime': ['Ana', 'Marko', 'Jovana', 'Stefan', 'Milica'],\n    'Matematika': [5, 4, 5, 3, 4],\n    'Informatika': [5, 5, 4, 4, 5],\n    'Srpski': [4, 3, 5, 4, 5]\n}\ntabela = pd.DataFrame(podaci)\n\n# Jedna kolona\nprint('Ocene iz matematike:')\nprint(tabela['Matematika'])\nprint()\n\n# Vise kolona\nprint('Ime i informatika:')\nprint(tabela[['Ime', 'Informatika']])"),
                    $this->code("# Jedan red (po indeksu)\nprint('Treci ucenik:')\nprint(tabela.iloc[2])\nprint()\n\n# Jedna celija\nprint('Ocena Ane iz srpskog:', tabela.iloc[0]['Srpski'])"),
                ])
                . '<h3>Statistika tabele</h3>'
                . $this->notebook([
                    $this->md("## Brza statistika sa `describe()`"),
                    $this->code("import pandas as pd\n\npodaci = {\n    'Ime': ['Ana', 'Marko', 'Jovana', 'Stefan', 'Milica'],\n    'Matematika': [5, 4, 5, 3, 4],\n    'Informatika': [5, 5, 4, 4, 5],\n    'Srpski': [4, 3, 5, 4, 5]\n}\ntabela = pd.DataFrame(podaci)\n\n# describe() daje prosek, min, max, itd.\nprint(tabela.describe())"),
                    $this->code("# Prosek po kolonama\nprint('Prosecne ocene po predmetima:')\nprint(tabela[['Matematika', 'Informatika', 'Srpski']].mean())\nprint()\nprint('Prosek svakog ucenika:')\ntabela['Prosek'] = tabela[['Matematika', 'Informatika', 'Srpski']].mean(axis=1)\nprint(tabela[['Ime', 'Prosek']])"),
                ]),
            'order' => 1,
            'is_assignment' => false,
        ]);

        // Lesson 4.1.2 - Filtriranje i sortiranje tabela
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub4_1->id,
            'title' => 'Filtriranje i sortiranje tabela',
            'content' => '<h2>Filtriranje i sortiranje tabela</h2>'
                . '<p>Zamisli da imas tabelu sa 1000 ucenika i treba da nadjes samo one sa prosekom vecim od 4.5. Rucno bi to trajalo satima, ali sa pandas-om traje jedan red koda!</p>'
                . '<h3>Sortiranje</h3>'
                . $this->notebook([
                    $this->md("## Sortiranje tabele"),
                    $this->code("import pandas as pd\n\npodaci = {\n    'Ime': ['Ana', 'Marko', 'Jovana', 'Stefan', 'Milica', 'Lazar'],\n    'Bodovi': [92, 78, 97, 85, 88, 95],\n    'Grad': ['Zrenjanin', 'Beograd', 'Zrenjanin', 'Novi Sad', 'Beograd', 'Zrenjanin']\n}\ntabela = pd.DataFrame(podaci)\n\n# Sortiraj po bodovima (rastuce)\nprint('Od najmanje do najvise:')\nprint(tabela.sort_values('Bodovi'))\nprint()\n\n# Sortiraj po bodovima (opadajuce)\nprint('Od najvise do najmanje:')\nprint(tabela.sort_values('Bodovi', ascending=False))"),
                ])
                . '<h3>Filtriranje</h3>'
                . $this->notebook([
                    $this->md("## Filtriranje - biramo samo redove koji ispunjavaju uslov"),
                    $this->code("import pandas as pd\n\npodaci = {\n    'Ime': ['Ana', 'Marko', 'Jovana', 'Stefan', 'Milica', 'Lazar'],\n    'Bodovi': [92, 78, 97, 85, 88, 95],\n    'Grad': ['Zrenjanin', 'Beograd', 'Zrenjanin', 'Novi Sad', 'Beograd', 'Zrenjanin']\n}\ntabela = pd.DataFrame(podaci)\n\n# Ucenici sa vise od 90 bodova\nprint('Bodovi > 90:')\nprint(tabela[tabela['Bodovi'] > 90])\nprint()\n\n# Ucenici iz Zrenjanina\nprint('Iz Zrenjanina:')\nprint(tabela[tabela['Grad'] == 'Zrenjanin'])"),
                    $this->code("# Kombinovanje uslova\n# & znaci I (AND), | znaci ILI (OR)\n\n# Ucenici iz Zrenjanina SA vise od 90 bodova\nprint('Zrenjanin i > 90 bodova:')\nfilter = (tabela['Grad'] == 'Zrenjanin') & (tabela['Bodovi'] > 90)\nprint(tabela[filter])"),
                ])
                . '<h3>Grupiranje podataka</h3>'
                . $this->notebook([
                    $this->md("## Grupiranje sa `groupby()`\nGrupisemo podatke po kategorijama i racunamo statistike:"),
                    $this->code("import pandas as pd\n\npodaci = {\n    'Ime': ['Ana', 'Marko', 'Jovana', 'Stefan', 'Milica', 'Lazar'],\n    'Bodovi': [92, 78, 97, 85, 88, 95],\n    'Grad': ['Zrenjanin', 'Beograd', 'Zrenjanin', 'Novi Sad', 'Beograd', 'Zrenjanin']\n}\ntabela = pd.DataFrame(podaci)\n\n# Prosecni bodovi po gradu\nprint('Prosek po gradu:')\nprint(tabela.groupby('Grad')['Bodovi'].mean())\nprint()\n\n# Broj ucenika po gradu\nprint('Broj ucenika po gradu:')\nprint(tabela.groupby('Grad')['Ime'].count())"),
                ]),
            'order' => 2,
            'is_assignment' => false,
        ]);

        // Lesson 4.1.3 - Vizuelizacija tabela
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub4_1->id,
            'title' => 'Vizuelizacija tabela',
            'content' => '<h2>Vizuelizacija tabela</h2>'
                . '<p>Pandas ima ugradjen sistem za crtanje dijagrama direktno iz tabele! Koristi matplotlib u pozadini, ali je mnogo jednostavniji za koriscenje.</p>'
                . $this->notebook([
                    $this->md("## Crtanje direktno iz tabele"),
                    $this->code("import pandas as pd\nimport matplotlib.pyplot as plt\n\nprodaja = pd.DataFrame({\n    'Mesec': ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun'],\n    'Sladoledi': [120, 150, 300, 450, 680, 900],\n    'Cokolade': [500, 480, 400, 350, 300, 250]\n})\n\nprodaja.plot(x='Mesec', y=['Sladoledi', 'Cokolade'],\n             kind='line', marker='o', figsize=(8, 4))\nplt.title('Prodaja slatkisa po mesecima')\nplt.ylabel('Komada')\nplt.grid(True, alpha=0.3)\nplt.show()"),
                    $this->md("Primeti kako se sladoledi prodaju vise leti, a cokolade zimi!"),
                    $this->code("# Stubicasti dijagram\nimport pandas as pd\nimport matplotlib.pyplot as plt\n\nocene = pd.DataFrame({\n    'Predmet': ['Matem.', 'Srpski', 'Inform.', 'Fizika', 'Engl.'],\n    'Prosek': [3.8, 4.2, 4.7, 3.5, 4.1]\n})\n\nocene.plot(x='Predmet', y='Prosek', kind='bar',\n           color='steelblue', figsize=(8, 4), legend=False)\nplt.title('Prosecne ocene po predmetima')\nplt.ylabel('Prosek')\nplt.ylim(0, 5)\nplt.xticks(rotation=0)\nplt.grid(axis='y', alpha=0.3)\nplt.show()"),
                ]),
            'order' => 3,
            'is_assignment' => false,
        ]);

        // Lesson 4.1.4 - Domaci: Rad sa tabelama
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub4_1->id,
            'title' => 'Domaci: Rad sa tabelama',
            'content' => '<h2>Domaci: Rad sa tabelama</h2>'
                . $this->notebook([
                    $this->md("# Domaci: Rad sa tabelama\n\n## Zadatak 1: Tabela ucenika\nNapravi tabelu sa imenima, ocenama iz 3 predmeta za 6 ucenika. Izracunaj prosek svakog ucenika i sortiraj po proseku."),
                    $this->code("import pandas as pd\n\n# Napravi tabelu\npodaci = {\n    'Ime': [],\n    'Matematika': [],\n    'Informatika': [],\n    'Srpski': []\n}\ntabela = pd.DataFrame(podaci)\n\n# Dodaj kolonu 'Prosek'\n\n# Sortiraj po proseku (od najboljeg)\n\nprint(tabela)"),
                    $this->md("## Zadatak 2: Filtriranje\nKoristeci tabelu iz Zadatka 1, nadji:\n- Ucenike sa prosekom vecim od 4\n- Ucenike sa 5 iz informatike"),
                    $this->code("# Filtriranje\n"),
                    $this->md("## Zadatak 3: Fudbalska tabela\nNapravi tabelu Superlige Srbije sa 6 timova (kolone: Tim, Pobede, Nereseno, Porazi, Golovi_dati, Golovi_primljeni). Izracunaj bodove (pobeda=3, nereseno=1) i gol razliku. Sortiraj po bodovima."),
                    $this->code("import pandas as pd\n\n# Napravi fudbalsku tabelu\nfudbal = pd.DataFrame({\n    'Tim': [],\n    'Pobede': [],\n    'Nereseno': [],\n    'Porazi': [],\n    'Golovi_dati': [],\n    'Golovi_primljeni': []\n})\n\n# Izracunaj bodove i gol razliku\n\n# Sortiraj i prikazi\n"),
                ]),
            'order' => 4,
            'is_assignment' => true,
        ]);

        // ============================================================
        // CHAPTER 5: Ucitavanje podataka i zavrsni projekat
        // ============================================================
        $ch5 = Chapter::create(['course_id' => $this->courseId, 'title' => 'Ucitavanje podataka i projekat', 'order' => 5]);

        $sub5_1 = Subchapter::create(['chapter_id' => $ch5->id, 'title' => 'Spoljni podaci', 'order' => 1]);

        // Lesson 5.1.1 - Ucitavanje iz CSV fajlova
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub5_1->id,
            'title' => 'Ucitavanje iz CSV fajlova',
            'content' => '<h2>Ucitavanje iz CSV fajlova</h2>'
                . '<p>Do sada smo podatke unosili rucno. Ali u stvarnom svetu podaci vec postoje u fajlovima! Najcesci format je <strong>CSV</strong> (Comma-Separated Values) - obican tekst gde su vrednosti razdvojene zarezima.</p>'
                . '<h3>Sta je CSV?</h3>'
                . '<p>CSV fajl izgleda ovako:</p>'
                . '<pre><code>Ime,Prezime,Ocena,Grad'
                . "\n" . 'Ana,Petrovic,5,Zrenjanin'
                . "\n" . 'Marko,Jovanovic,4,Beograd'
                . "\n" . 'Jovana,Nikolic,5,Zrenjanin</code></pre>'
                . '<p>Svaki red je jedan podatak, a vrednosti su razdvojene zarezom. Mozes ga otvoriti i u Excel-u!</p>'
                . '<h3>Citanje CSV fajla</h3>'
                . $this->notebook([
                    $this->md("## Pravimo CSV i ucitavamo ga\nPrvo cemo napraviti CSV fajl, pa ga ucitati:"),
                    $this->code("import pandas as pd\n\n# Pravimo podatke i cuvamo u CSV\npodaci = pd.DataFrame({\n    'Grad': ['Zrenjanin', 'Beograd', 'Novi Sad', 'Nis', 'Kragujevac', 'Subotica'],\n    'Stanovnici': [75000, 1400000, 380000, 260000, 180000, 100000],\n    'Povrsina_km2': [1327, 360, 699, 597, 835, 1008]\n})\npodaci.to_csv('gradovi.csv', index=False)\nprint('CSV fajl sacuvan!')\nprint()\n\n# Citamo CSV fajl\ntabela = pd.read_csv('gradovi.csv')\nprint(tabela)"),
                    $this->code("# Gustina naseljenosti\ntabela['Gustina'] = (tabela['Stanovnici'] / tabela['Povrsina_km2']).round(0)\ntabela = tabela.sort_values('Gustina', ascending=False)\nprint('Gustina naseljenosti (stanovnika/km2):')\nprint(tabela[['Grad', 'Gustina']])"),
                ])
                . '<h3>Zapisivanje u CSV</h3>'
                . $this->notebook([
                    $this->md("## Cuvamo rezultate u novi CSV fajl"),
                    $this->code("import pandas as pd\n\n# Napravi tabelu\nocene = pd.DataFrame({\n    'Ucenik': ['Ana', 'Marko', 'Jovana', 'Stefan'],\n    'Test_1': [45, 38, 50, 42],\n    'Test_2': [48, 41, 47, 45]\n})\n\n# Dodaj prosek\nocene['Prosek'] = ocene[['Test_1', 'Test_2']].mean(axis=1)\n\n# Sacuvaj u CSV\nocene.to_csv('rezultati_testova.csv', index=False)\nprint('Sacuvano u rezultati_testova.csv!')\nprint(ocene)"),
                ]),
            'order' => 1,
            'is_assignment' => false,
        ]);

        // Lesson 5.1.2 - Modifikacija tabele
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub5_1->id,
            'title' => 'Modifikacija tabele',
            'content' => '<h2>Modifikacija tabele</h2>'
                . '<p>Kada ucitamo podatke, cesto ih treba prilagoditi - dodati nove kolone, obrisati nepotrebne, promeniti vrednosti...</p>'
                . $this->notebook([
                    $this->md("## Dodavanje i brisanje kolona"),
                    $this->code("import pandas as pd\n\ntabela = pd.DataFrame({\n    'Ime': ['Ana', 'Marko', 'Jovana', 'Stefan'],\n    'Matematika': [5, 3, 5, 4],\n    'Informatika': [5, 5, 4, 4],\n    'Fizicko': [5, 5, 5, 5]\n})\nprint('Originalna tabela:')\nprint(tabela)\nprint()\n\n# Dodaj novu kolonu\ntabela['Prosek'] = tabela[['Matematika', 'Informatika']].mean(axis=1)\nprint('Sa prosekom:')\nprint(tabela)\nprint()\n\n# Obrisi kolonu\ntabela = tabela.drop(columns=['Fizicko'])\nprint('Bez fizickog:')\nprint(tabela)"),
                    $this->md("## Menjanje vrednosti"),
                    $this->code("import pandas as pd\n\ntabela = pd.DataFrame({\n    'Ime': ['Ana', 'Marko', 'Jovana'],\n    'Bodovi': [85, 72, 91]\n})\n\n# Dodaj kolonu sa ocenom na osnovu bodova\ndef odredi_ocenu(bodovi):\n    if bodovi >= 90: return 5\n    elif bodovi >= 80: return 4\n    elif bodovi >= 70: return 3\n    elif bodovi >= 60: return 2\n    else: return 1\n\ntabela['Ocena'] = tabela['Bodovi'].apply(odredi_ocenu)\nprint(tabela)"),
                ]),
            'order' => 2,
            'is_assignment' => false,
        ]);

        // Lesson 5.1.3 - Jupyter i Excel
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub5_1->id,
            'title' => 'Jupyter i Excel',
            'content' => '<h2>Jupyter i Excel</h2>'
                . '<p>Mnogo ljudi koristi Excel za rad sa tabelama. Jupyter moze da cita i pise Excel fajlove, sto ga cini savrsenim alatom za analizu podataka!</p>'
                . '<h3>Excel vs Jupyter</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Osobina</th><th>Excel</th><th>Jupyter</th></tr></thead>'
                . '<tbody>'
                . '<tr><td>Vizuelni prikaz</td><td>Odlican</td><td>Dobar</td></tr>'
                . '<tr><td>Automatizacija</td><td>Ogranicena</td><td>Odlicna</td></tr>'
                . '<tr><td>Velike tabele</td><td>Spor</td><td>Brz</td></tr>'
                . '<tr><td>Ponovljivost</td><td>Teska</td><td>Laka</td></tr>'
                . '<tr><td>Ucenje</td><td>Lakse</td><td>Teze</td></tr>'
                . '</tbody></table>'
                . '<h3>Zasto koristiti Jupyter umesto Excel-a?</h3>'
                . '<p>Zamisli da svake nedelje dobijas tabelu sa ocenama i treba da izracunas prosek, napravis grafike i posaljes izvestaj. U Excel-u to radis rucno svaki put. U Jupyteru napises kod jednom i samo menjas podatke!</p>'
                . $this->notebook([
                    $this->md("## Primer: Automatski izvestaj\nZamisli da svake nedelje dobijas nove ocene:"),
                    $this->code("import pandas as pd\nimport matplotlib.pyplot as plt\n\n# Simuliramo \"nedeljni izvestaj\"\npodaci = pd.DataFrame({\n    'Ucenik': ['Ana', 'Marko', 'Jovana', 'Stefan', 'Milica', 'Lazar'],\n    'Ponasanje': [5, 4, 5, 3, 5, 4],\n    'Aktivnost': [5, 3, 5, 4, 4, 5],\n    'Domaci': [5, 2, 5, 4, 5, 3]\n})\n\n# Automatski izvestaj\npodaci['Prosek'] = podaci[['Ponasanje', 'Aktivnost', 'Domaci']].mean(axis=1).round(2)\n\nprint('=== NEDELJNI IZVESTAJ ===')\nprint(f'Broj ucenika: {len(podaci)}')\nprint(f'Prosek odeljenja: {podaci[\"Prosek\"].mean():.2f}')\nprint(f'Najbolji ucenik: {podaci.loc[podaci[\"Prosek\"].idxmax(), \"Ucenik\"]}')\nprint()\nprint(podaci.sort_values('Prosek', ascending=False).to_string(index=False))"),
                    $this->code("# Automatski grafik\nimport pandas as pd\nimport matplotlib.pyplot as plt\n\npodaci = pd.DataFrame({\n    'Ucenik': ['Ana', 'Marko', 'Jovana', 'Stefan', 'Milica', 'Lazar'],\n    'Ponasanje': [5, 4, 5, 3, 5, 4],\n    'Aktivnost': [5, 3, 5, 4, 4, 5],\n    'Domaci': [5, 2, 5, 4, 5, 3]\n})\n\nfig, axes = plt.subplots(1, 2, figsize=(12, 4))\n\n# Grafik 1: Prosek po uceniku\nproseci = podaci[['Ponasanje', 'Aktivnost', 'Domaci']].mean(axis=1)\naxes[0].barh(podaci['Ucenik'], proseci, color='steelblue')\naxes[0].set_title('Prosek po uceniku')\naxes[0].set_xlim(0, 5)\naxes[0].grid(axis='x', alpha=0.3)\n\n# Grafik 2: Prosek po kategoriji\nkategorije = ['Ponasanje', 'Aktivnost', 'Domaci']\nproseci_kat = [podaci[k].mean() for k in kategorije]\naxes[1].bar(kategorije, proseci_kat, color=['#FF6B6B', '#4ECDC4', '#45B7D1'])\naxes[1].set_title('Prosek po kategoriji')\naxes[1].set_ylim(0, 5)\naxes[1].grid(axis='y', alpha=0.3)\n\nplt.tight_layout()\nplt.show()"),
                ]),
            'order' => 3,
            'is_assignment' => false,
        ]);

        // Lesson 5.1.4 - Zavrsni projekat
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub5_1->id,
            'title' => 'Zavrsni projekat: Analiza podataka',
            'content' => '<h2>Zavrsni projekat: Analiza podataka</h2>'
                . '<p>Dosli smo do kraja kursa o Jupyteru! Vreme je da sve nauceno primenis u jednom velikom projektu.</p>'
                . '<h3>Zadatak</h3>'
                . '<p>Izaberi <strong>jednu</strong> od sledecih tema i napravi kompletnu analizu u notebooku ispod:</p>'
                . '<ol>'
                . '<li><strong>Analiza odeljenja</strong> - Napravi tabelu sa ocenama svih ucenika iz svih predmeta. Izracunaj proseke, nadji najbolje i najlosije predmete, nacrtaj grafike.</li>'
                . '<li><strong>Sportska analiza</strong> - Napravi tabelu fudbalske (ili kosarkaske) lige. Izracunaj bodove, gol razliku, formu timova. Nacrtaj grafike.</li>'
                . '<li><strong>Vremenska prognoza</strong> - Unesi temperature za Zrenjanin za ceo mesec (ili izmisli realne podatke). Analiziraj trendove, proseke, nacrtaj grafike.</li>'
                . '</ol>'
                . '<h3>Projekat mora da sadrzi:</h3>'
                . '<ul>'
                . '<li>Tabelu sa podacima (minimum 10 redova)</li>'
                . '<li>Izracunavanje proseka, min, max</li>'
                . '<li>Filtriranje podataka (bar 2 razlicita filtera)</li>'
                . '<li>Sortiranje</li>'
                . '<li>Bar 2 razlicita tipa dijagrama</li>'
                . '<li>Kratak zakljucak (sta si saznao iz analize)</li>'
                . '</ul>'
                . $this->notebook([
                    $this->md("# Zavrsni projekat\n## Tema: (upisi svoju temu)\n\n### Uvod\n(Opisi sta ces analizirati i zasto)"),
                    $this->code("import pandas as pd\nimport matplotlib.pyplot as plt\n\n# 1. Napravi tabelu sa podacima\n"),
                    $this->md("### Osnovna statistika"),
                    $this->code("# 2. Izracunaj prosek, min, max\n"),
                    $this->md("### Filtriranje"),
                    $this->code("# 3. Primeni filtere\n"),
                    $this->md("### Sortiranje"),
                    $this->code("# 4. Sortiraj podatke\n"),
                    $this->md("### Dijagrami"),
                    $this->code("# 5. Nacrtaj prvi dijagram\n"),
                    $this->code("# 6. Nacrtaj drugi dijagram\n"),
                    $this->md("### Zakljucak\n(Sta si saznao iz analize? Koji podatak te je iznenadio?)"),
                ]),
            'order' => 4,
            'is_assignment' => true,
        ]);

        echo "Jupyter kurs uspesno kreiran! 5 poglavlja, 5 potpoglavlja, 16 lekcija (4 domaca zadatka).\n";
    }
}
