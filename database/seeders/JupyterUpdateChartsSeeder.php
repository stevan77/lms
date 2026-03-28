<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Seeder;

class JupyterUpdateChartsSeeder extends Seeder
{
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
        // ============================================================
        // UPDATE: Linijski dijagrami
        // ============================================================
        $lesson = Lesson::where('course_id', 4)->where('title', 'Linijski dijagrami')->first();
        if ($lesson) {
            $lesson->content = '<h2>Linijski dijagrami</h2>'
                . '<p>Sto bi rekli "slika vredi hiljadu reci". Umesto da gledamo dugacke liste brojeva, mozemo nacrtati <strong>dijagram</strong> i odmah videti trendove i obrasce.</p>'

                // --- matplotlib objasnjenje ---
                . '<h3>Biblioteka matplotlib</h3>'
                . '<p>Za crtanje dijagrama koristimo biblioteku <code>matplotlib</code> - najpoznatiju Python biblioteku za grafike. Uvozimo je ovako:</p>'
                . '<pre><code>import matplotlib.pyplot as plt</code></pre>'
                . '<p>Uvek je uvozimo kao <code>plt</code> (skracenica) da ne bismo pisali celo ime svaki put.</p>'

                // --- plt.figure() ---
                . '<h3>plt.figure() - priprema platna</h3>'
                . '<p><strong>Sta radi:</strong> Pravi novo prazno platno za crtanje. Kao kada uzmes prazan list papira pre nego sto pocnes da crtas.</p>'
                . '<p><strong>Parametar <code>figsize=(sirina, visina)</code></strong> - velicina platna u incima. Na primer, <code>figsize=(8, 4)</code> pravi siri dijagram.</p>'

                // --- plt.plot() ---
                . '<h3>plt.plot() - linijski dijagram</h3>'
                . '<p><strong>Sta radi:</strong> Crta liniju koja povezuje tacke. Dajemo mu dve liste - jednu za X osu (horizontalnu) i jednu za Y osu (vertikalnu).</p>'
                . '<p>Parametri koje mozemo dodati:</p>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Parametar</th><th>Sta radi</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>color</code></td><td>Boja linije</td><td><code>color=\'tomato\'</code> ili <code>color=\'#FF6347\'</code></td></tr>'
                . '<tr><td><code>marker</code></td><td>Oblik tacke na svakom podatku</td><td><code>marker=\'o\'</code> (krug), <code>\'s\'</code> (kvadrat), <code>\'*\'</code> (zvezdica)</td></tr>'
                . '<tr><td><code>linewidth</code></td><td>Debljina linije</td><td><code>linewidth=2</code></td></tr>'
                . '<tr><td><code>linestyle</code></td><td>Stil linije</td><td><code>linestyle=\'--\'</code> (crtica), <code>\':\'</code> (tacka), <code>\'-\'</code> (puna)</td></tr>'
                . '<tr><td><code>label</code></td><td>Ime za legendu</td><td><code>label=\'Beograd\'</code></td></tr>'
                . '</tbody></table>'

                // --- plt.title, xlabel, ylabel ---
                . '<h3>Naslovi i oznake</h3>'
                . '<p><strong><code>plt.title(\'tekst\')</code></strong> - naslov dijagrama (iznad grafika)</p>'
                . '<p><strong><code>plt.xlabel(\'tekst\')</code></strong> - oznaka X ose (ispod)</p>'
                . '<p><strong><code>plt.ylabel(\'tekst\')</code></strong> - oznaka Y ose (sa strane)</p>'
                . '<p><strong><code>plt.legend()</code></strong> - prikazuje legendu (objasnjenje boja/linija). Radi samo ako si stavio <code>label</code> u plot().</p>'
                . '<p><strong><code>plt.grid(True)</code></strong> - dodaje mrezu (linije u pozadini za lakse citanje)</p>'
                . '<p><strong><code>plt.show()</code></strong> - prikazuje dijagram. Uvek stavljamo na kraj!</p>'

                // --- Prvi dijagram ---
                . '<h3>Prvi dijagram</h3>'
                . $this->notebook([
                    $this->md("## Crtamo linijski dijagram\nNajjednostavniji dijagram - samo `plt.plot()` i `plt.show()`:"),
                    $this->code("import matplotlib.pyplot as plt\n\ndani = ['Pon', 'Uto', 'Sre', 'Cet', 'Pet', 'Sub', 'Ned']\ntemperature = [12, 14, 11, 15, 17, 16, 13]\n\nplt.plot(dani, temperature)        # nacrtaj liniju\nplt.title('Temperature u martu')   # naslov\nplt.ylabel('Temperatura (C)')      # oznaka Y ose\nplt.show()                         # prikazi"),
                    $this->md("## Lepsi dijagram\nDodajemo boju, markere, deblju liniju i mrezu:"),
                    $this->code("import matplotlib.pyplot as plt\n\ndani = ['Pon', 'Uto', 'Sre', 'Cet', 'Pet', 'Sub', 'Ned']\ntemperature = [12, 14, 11, 15, 17, 16, 13]\n\nplt.figure(figsize=(8, 4))              # vece platno\nplt.plot(dani, temperature,\n         color='tomato',                # crvena boja\n         marker='o',                    # krugovi na tackama\n         linewidth=2)                   # deblja linija\nplt.fill_between(range(len(dani)),\n                 temperature,\n                 alpha=0.2,             # providnost (0=nevidljivo, 1=puno)\n                 color='tomato')        # obojena povrsina ispod linije\nplt.title('Temperature tokom nedelje', fontsize=14)\nplt.ylabel('Temperatura (C)')\nplt.grid(True, alpha=0.3)               # mreza sa providnoscu 0.3\nplt.show()"),
                ])

                // --- Vise linija ---
                . '<h3>Vise linija na jednom dijagramu</h3>'
                . '<p>Mozemo uporediti vise nizova podataka na istom grafiku. Samo pozovemo <code>plt.plot()</code> vise puta pre <code>plt.show()</code>:</p>'
                . $this->notebook([
                    $this->md("## Poredjenje: Beograd vs Novi Sad\nKoristimo `label` i `plt.legend()` da oznacimo linije:"),
                    $this->code("import matplotlib.pyplot as plt\n\ndani = ['Pon', 'Uto', 'Sre', 'Cet', 'Pet', 'Sub', 'Ned']\nbeograd = [12, 14, 11, 15, 17, 16, 13]\nnovi_sad = [11, 13, 10, 14, 16, 15, 12]\n\nplt.figure(figsize=(8, 4))\nplt.plot(dani, beograd, marker='o', label='Beograd', color='crimson')\nplt.plot(dani, novi_sad, marker='s', label='Novi Sad', color='steelblue')\nplt.title('Poredjenje temperatura')\nplt.ylabel('Temperatura (C)')\nplt.legend()             # prikazi legendu (koristi label iz plot)\nplt.grid(True, alpha=0.3)\nplt.show()"),
                ])

                . '<h3>Kada koristimo linijski dijagram?</h3>'
                . '<ul>'
                . '<li>Podaci se menjaju tokom vremena (temperature, cene, ocene...)</li>'
                . '<li>Zelimo da vidimo trend - da li nesto raste ili opada</li>'
                . '<li>Poredimo dva ili vise nizova podataka</li>'
                . '</ul>'

                // --- TABELA ---
                . '<h3>Pregled matplotlib komandi - linijski dijagram</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Komanda</th><th>Sta radi</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>import matplotlib.pyplot as plt</code></td><td>Uvozi biblioteku za grafike</td><td>Uvek na pocetku</td></tr>'
                . '<tr><td><code>plt.figure(figsize=(w,h))</code></td><td>Pravi platno zadate velicine</td><td><code>plt.figure(figsize=(8,4))</code></td></tr>'
                . '<tr><td><code>plt.plot(x, y)</code></td><td>Crta linijski dijagram</td><td><code>plt.plot(dani, temp)</code></td></tr>'
                . '<tr><td><code>color=\'...\'</code></td><td>Boja linije/elementa</td><td><code>color=\'tomato\'</code></td></tr>'
                . '<tr><td><code>marker=\'...\'</code></td><td>Oblik tacke (o, s, *, ^, D)</td><td><code>marker=\'o\'</code></td></tr>'
                . '<tr><td><code>linewidth=n</code></td><td>Debljina linije</td><td><code>linewidth=2</code></td></tr>'
                . '<tr><td><code>linestyle=\'...\'</code></td><td>Stil linije (-, --, :, -.)</td><td><code>linestyle=\'--\'</code></td></tr>'
                . '<tr><td><code>label=\'...\'</code></td><td>Naziv za legendu</td><td><code>label=\'Beograd\'</code></td></tr>'
                . '<tr><td><code>alpha=n</code></td><td>Providnost (0-1)</td><td><code>alpha=0.3</code></td></tr>'
                . '<tr><td><code>plt.title(\'...\')</code></td><td>Naslov dijagrama</td><td><code>plt.title(\'Grafik\')</code></td></tr>'
                . '<tr><td><code>plt.xlabel(\'...\')</code></td><td>Oznaka X ose</td><td><code>plt.xlabel(\'Dani\')</code></td></tr>'
                . '<tr><td><code>plt.ylabel(\'...\')</code></td><td>Oznaka Y ose</td><td><code>plt.ylabel(\'Temp\')</code></td></tr>'
                . '<tr><td><code>plt.legend()</code></td><td>Prikazuje legendu</td><td>Koristi label iz plot()</td></tr>'
                . '<tr><td><code>plt.grid(True)</code></td><td>Prikazuje mrezu</td><td><code>plt.grid(True, alpha=0.3)</code></td></tr>'
                . '<tr><td><code>plt.fill_between(x, y)</code></td><td>Boji prostor ispod linije</td><td><code>plt.fill_between(x, y, alpha=0.2)</code></td></tr>'
                . '<tr><td><code>plt.show()</code></td><td>Prikazuje dijagram</td><td>Uvek na kraju</td></tr>'
                . '</tbody></table>';

            $lesson->save();
            echo "Updated: Linijski dijagrami\n";
        }

        // ============================================================
        // UPDATE: Stubicasti dijagrami i histogrami
        // ============================================================
        $lesson = Lesson::where('course_id', 4)->where('title', 'Stubicasti dijagrami i histogrami')->first();
        if ($lesson) {
            $lesson->content = '<h2>Stubicasti dijagrami i histogrami</h2>'
                . '<p>Linijski dijagrami su odlicni za trendove, ali ponekad zelimo da <strong>uporedimo velicine</strong>. Za to koristimo stubicaste dijagrame!</p>'

                // --- plt.bar() ---
                . '<h3>plt.bar() - stubicasti dijagram</h3>'
                . '<p><strong>Sta radi:</strong> Crta vertikalne stubice. Svaki stubic predstavlja jednu kategoriju, a visina stubica pokazuje vrednost.</p>'
                . '<p><strong>Kada koristiti:</strong> Kada poredimo stvari - ocene po predmetima, broj glasova, bodove ucenika...</p>'
                . '<p>Parametri:</p>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Parametar</th><th>Sta radi</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>color</code></td><td>Boja stubica (jedna ili lista)</td><td><code>color=\'steelblue\'</code> ili <code>color=[\'red\',\'blue\']</code></td></tr>'
                . '<tr><td><code>edgecolor</code></td><td>Boja ivice stubica</td><td><code>edgecolor=\'white\'</code></td></tr>'
                . '<tr><td><code>width</code></td><td>Sirina stubica (podrazumevano 0.8)</td><td><code>width=0.6</code></td></tr>'
                . '</tbody></table>'

                . $this->notebook([
                    $this->md("## Stubicasti dijagram\nKoristi `plt.bar()` umesto `plt.plot()`:"),
                    $this->code("import matplotlib.pyplot as plt\n\npredmeti = ['Matem.', 'Srpski', 'Inform.', 'Fizika', 'Biolog.']\nocene = [4, 5, 5, 3, 4]\nboje = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7']\n\nplt.figure(figsize=(8, 4))\nplt.bar(predmeti, ocene, color=boje)  # stubicasti dijagram\nplt.title('Moje ocene po predmetima')\nplt.ylabel('Ocena')\nplt.ylim(0, 5.5)                      # opseg Y ose: 0 do 5.5\nplt.grid(axis='y', alpha=0.3)          # mreza samo horizontalno\nplt.show()"),
                ])

                // --- plt.barh() ---
                . '<h3>plt.barh() - horizontalni stubici</h3>'
                . '<p><strong>Sta radi:</strong> Isto kao <code>bar()</code> ali crta stubice horizontalno (u stranu). Preglednije je kada imas duga imena kategorija.</p>'
                . $this->notebook([
                    $this->md("## Horizontalni stubici\nKoristi `plt.barh()` - \"bar horizontal\":"),
                    $this->code("import matplotlib.pyplot as plt\n\nucenici = ['Ana', 'Marko', 'Jovana', 'Stefan', 'Milica', 'Lazar']\nbodovi = [92, 85, 97, 78, 88, 95]\n\nplt.figure(figsize=(8, 4))\nplt.barh(ucenici, bodovi, color='steelblue')  # horizontalni stubici\nplt.title('Bodovi na takmicenju')\nplt.xlabel('Bodovi')             # sada je X osa za vrednosti\nplt.xlim(0, 100)                 # opseg X ose\nplt.grid(axis='x', alpha=0.3)    # mreza samo vertikalno\nplt.show()"),
                ])

                // --- plt.ylim, plt.xlim, plt.xticks ---
                . '<h3>Podesavanje osa</h3>'
                . '<p><strong><code>plt.ylim(min, max)</code></strong> - postavlja opseg Y ose. Na primer, <code>plt.ylim(0, 5.5)</code> znaci da Y osa ide od 0 do 5.5.</p>'
                . '<p><strong><code>plt.xlim(min, max)</code></strong> - isto za X osu.</p>'
                . '<p><strong><code>plt.xticks(lista)</code></strong> - postavlja koje oznake se prikazuju na X osi.</p>'
                . '<p><strong><code>plt.axhline(y=vrednost)</code></strong> - crta horizontalnu liniju (korisno za prikaz proseka).</p>'

                // --- plt.hist() ---
                . '<h3>plt.hist() - histogram</h3>'
                . '<p><strong>Sta radi:</strong> Automatski grupishe podatke u intervale i prikazuje koliko ih ima u svakom intervalu.</p>'
                . '<p><strong>Razlika od bar():</strong> Kod <code>bar()</code> mi biramo kategorije (predmeti, ucenici...). Kod <code>hist()</code> Python sam grupishe brojeve u opsege.</p>'
                . '<p><strong>Kada koristiti:</strong> Kada zelimo da vidimo kako su rasporedjene vrednosti - koliko ucenika ima koju ocenu, raspodela visina, rezultati testa...</p>'
                . '<p>Parametri:</p>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Parametar</th><th>Sta radi</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>bins</code></td><td>Broj intervala ili granice intervala</td><td><code>bins=5</code> ili <code>bins=[1.5, 2.5, 3.5, 4.5, 5.5]</code></td></tr>'
                . '<tr><td><code>edgecolor</code></td><td>Boja ivice stubica</td><td><code>edgecolor=\'white\'</code></td></tr>'
                . '<tr><td><code>rwidth</code></td><td>Sirina stubica (0-1)</td><td><code>rwidth=0.8</code></td></tr>'
                . '</tbody></table>'

                . $this->notebook([
                    $this->md("## Histogram\nPrikazuje koliko ucenika ima svaku ocenu:"),
                    $this->code("import matplotlib.pyplot as plt\n\n# Ocene svih ucenika u odeljenju\nocene_odeljenja = [5, 4, 5, 3, 4, 5, 5, 4, 3, 5,\n                   4, 4, 5, 2, 4, 5, 3, 4, 5, 4,\n                   5, 3, 4, 4, 5, 4, 3, 5, 4, 5]\n\nplt.figure(figsize=(8, 4))\nplt.hist(ocene_odeljenja,\n         bins=[1.5, 2.5, 3.5, 4.5, 5.5],  # granice za svaku ocenu\n         color='mediumpurple',\n         edgecolor='white',                 # bela ivica\n         rwidth=0.8)                        # stubici zauzimaju 80% prostora\nplt.title('Raspodela ocena u odeljenju')\nplt.xlabel('Ocena')\nplt.ylabel('Broj ucenika')\nplt.xticks([2, 3, 4, 5])                   # prikazi samo 2, 3, 4, 5\nplt.grid(axis='y', alpha=0.3)\nplt.show()"),
                ])

                // --- Kada sta koristimo ---
                . '<h3>Kada sta koristimo?</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Dijagram</th><th>Funkcija</th><th>Kada koristimo</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td>Linijski</td><td><code>plt.plot()</code></td><td>Promena tokom vremena</td><td>Temperature po danima</td></tr>'
                . '<tr><td>Stubicasti</td><td><code>plt.bar()</code></td><td>Poredjenje kategorija</td><td>Ocene po predmetima</td></tr>'
                . '<tr><td>Horizontalni</td><td><code>plt.barh()</code></td><td>Poredjenje (duga imena)</td><td>Bodovi ucenika</td></tr>'
                . '<tr><td>Histogram</td><td><code>plt.hist()</code></td><td>Raspodela vrednosti</td><td>Koliko ucenika ima koju ocenu</td></tr>'
                . '</tbody></table>'

                // --- TABELA KOMANDI ---
                . '<h3>Pregled novih komandi</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Komanda</th><th>Sta radi</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>plt.bar(x, y)</code></td><td>Vertikalni stubicasti dijagram</td><td><code>plt.bar(predmeti, ocene)</code></td></tr>'
                . '<tr><td><code>plt.barh(x, y)</code></td><td>Horizontalni stubicasti dijagram</td><td><code>plt.barh(ucenici, bodovi)</code></td></tr>'
                . '<tr><td><code>plt.hist(podaci, bins=n)</code></td><td>Histogram (raspodela)</td><td><code>plt.hist(ocene, bins=5)</code></td></tr>'
                . '<tr><td><code>plt.ylim(min, max)</code></td><td>Opseg Y ose</td><td><code>plt.ylim(0, 5.5)</code></td></tr>'
                . '<tr><td><code>plt.xlim(min, max)</code></td><td>Opseg X ose</td><td><code>plt.xlim(0, 100)</code></td></tr>'
                . '<tr><td><code>plt.xticks(lista)</code></td><td>Oznake na X osi</td><td><code>plt.xticks([1,2,3,4,5])</code></td></tr>'
                . '<tr><td><code>plt.axhline(y=v)</code></td><td>Horizontalna linija</td><td><code>plt.axhline(y=4, linestyle=\'--\')</code></td></tr>'
                . '<tr><td><code>plt.text(x, y, tekst)</code></td><td>Dodaje tekst na grafik</td><td><code>plt.text(1, 5, \'Petica\')</code></td></tr>'
                . '<tr><td><code>edgecolor=\'...\'</code></td><td>Boja ivice stubica</td><td><code>edgecolor=\'white\'</code></td></tr>'
                . '<tr><td><code>rwidth=n</code></td><td>Sirina stubica histograma (0-1)</td><td><code>rwidth=0.8</code></td></tr>'
                . '</tbody></table>';

            $lesson->save();
            echo "Updated: Stubicasti dijagrami i histogrami\n";
        }

        // ============================================================
        // UPDATE: Procenti i sektorski dijagrami
        // ============================================================
        $lesson = Lesson::where('course_id', 4)->where('title', 'Procenti i sektorski dijagrami')->first();
        if ($lesson) {
            $lesson->content = '<h2>Procenti i sektorski dijagrami</h2>'
                . '<p>Procenat znaci "od sto" (per centum na latinskom). Ako imas 5 jabuka od ukupno 20 voca, jabuke cine 5/20 = 0.25 = 25% ukupnog voca.</p>'

                // --- Racunanje procenata ---
                . '<h3>Racunanje procenata</h3>'
                . '<p>Formula je jednostavna: <strong>procenat = (deo / celina) * 100</strong></p>'
                . $this->notebook([
                    $this->md("## Procenti u Pythonu"),
                    $this->code("# Koliko procenata cini deo od celine?\ndevojcice = 14\ndecki = 16\nukupno = devojcice + decki\n\nprocenat_devojcica = (devojcice / ukupno) * 100\nprocenat_decaka = (decki / ukupno) * 100\n\nprint(f'Devojcice: {devojcice} od {ukupno} = {procenat_devojcica:.1f}%')\nprint(f'Decki: {decki} od {ukupno} = {procenat_decaka:.1f}%')\nprint(f'Ukupno: {procenat_devojcica + procenat_decaka:.1f}%')"),
                ])

                // --- plt.pie() objasnjenje ---
                . '<h3>plt.pie() - sektorski dijagram</h3>'
                . '<p><strong>Sta radi:</strong> Crta "pitu" (krug) podeljenu na sektore (parcad). Svaki sektor pokazuje koliki deo celine zauzima neka kategorija.</p>'
                . '<p><strong>Kada koristiti:</strong> Kada zelimo da vidimo koliki procenat celine zauzima svaki deo - glasovi na anketi, raspodela budzeta, sastav odeljenja...</p>'
                . '<p><strong>Vazno:</strong> Python sam racuna procente! Ti samo das brojeve (npr. glasove), a <code>pie()</code> sam izracuna koliki deo kruga pripada svakom.</p>'

                . '<h4>Parametri plt.pie()</h4>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Parametar</th><th>Sta radi</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>labels</code></td><td>Imena za svaki sektor</td><td><code>labels=[\'Matem.\', \'Srpski\']</code></td></tr>'
                . '<tr><td><code>colors</code></td><td>Boje za svaki sektor</td><td><code>colors=[\'red\', \'blue\']</code></td></tr>'
                . '<tr><td><code>autopct</code></td><td>Format za prikaz procenata</td><td><code>autopct=\'%1.1f%%\'</code> prikazuje npr. "40.0%"</td></tr>'
                . '<tr><td><code>startangle</code></td><td>Pocetni ugao u stepenima</td><td><code>startangle=90</code> (pocinje odozgo)</td></tr>'
                . '<tr><td><code>explode</code></td><td>Izvlaci sektore iz centra</td><td><code>explode=[0.1, 0, 0]</code> (izvuci prvi)</td></tr>'
                . '<tr><td><code>shadow</code></td><td>Dodaje senku</td><td><code>shadow=True</code></td></tr>'
                . '<tr><td><code>textprops</code></td><td>Podesavanje teksta</td><td><code>textprops={\'fontsize\': 12}</code></td></tr>'
                . '</tbody></table>'

                . '<h4>Sta znaci autopct=\'%1.1f%%\'?</h4>'
                . '<p>Ovo izgleda cudno, ali je jednostavno:</p>'
                . '<ul>'
                . '<li><code>%1.1f</code> - prikazi broj sa jednom decimalom (npr. 40.0)</li>'
                . '<li><code>%%</code> - prikazi znak % (moramo dva puta jer je % specijalan karakter)</li>'
                . '<li>Dakle, rezultat je npr. "40.0%"</li>'
                . '</ul>'

                . '<h3>Primer: Omiljeni predmeti</h3>'
                . $this->notebook([
                    $this->md("## Sektorski dijagram - omiljeni predmeti\n`plt.pie()` sam racuna procente iz brojeva:"),
                    $this->code("import matplotlib.pyplot as plt\n\npredmeti = ['Informatika', 'Fizicko', 'Matematika', 'Likovno', 'Muzicko']\nglasovi = [12, 8, 5, 3, 2]\n# Ukupno glasova: 30\n# Python sam racuna: Informatika = 12/30 = 40%, itd.\n\nboje = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7']\n\nplt.figure(figsize=(8, 6))\nplt.pie(glasovi,\n        labels=predmeti,           # imena sektora\n        colors=boje,               # boje sektora\n        autopct='%1.1f%%',         # prikazi procente\n        startangle=90,             # pocni odozgo\n        textprops={'fontsize': 12})\nplt.title('Omiljeni predmeti u odeljenju', fontsize=14)\nplt.show()"),
                ])

                // --- explode i shadow ---
                . '<h3>Isticanje sektora sa explode</h3>'
                . '<p>Parametar <code>explode</code> izvlaci sektor iz kruga - kao da izvadis parce torte. Dajemo listu brojeva gde 0 znaci "ostavi na mestu", a 0.1 znaci "izvuci malo".</p>'
                . $this->notebook([
                    $this->md("## Izvlacenje sektora i senka\nIzvucemo Informatiku iz kruga i dodamo senku:"),
                    $this->code("import matplotlib.pyplot as plt\n\npredmeti = ['Informatika', 'Fizicko', 'Matematika', 'Likovno', 'Muzicko']\nglasovi = [12, 8, 5, 3, 2]\nboje = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7']\n\n# explode - izvuci Informatiku (0.1), ostale ostavi (0)\nizvuci = [0.1, 0, 0, 0, 0]\n\nplt.figure(figsize=(8, 6))\nplt.pie(glasovi,\n        labels=predmeti,\n        colors=boje,\n        autopct='%1.1f%%',\n        startangle=90,\n        explode=izvuci,            # izvuci prvi sektor\n        shadow=True,               # dodaj senku\n        textprops={'fontsize': 12})\nplt.title('Omiljeni predmeti u odeljenju', fontsize=14)\nplt.show()"),
                ])

                . '<h3>Primer: Budzet za skolski izlet</h3>'
                . $this->notebook([
                    $this->md("## Budzet za izlet\nGde ide novac za skolski izlet?"),
                    $this->code("import matplotlib.pyplot as plt\n\nstavke = ['Prevoz', 'Hrana', 'Ulaznice', 'Suveniri']\ntrosak = [3000, 2000, 1500, 500]\n\nplt.figure(figsize=(7, 7))\nplt.pie(trosak,\n        labels=stavke,\n        autopct='%1.0f%%',         # bez decimala: 43%\n        startangle=90,\n        colors=['#3498db', '#2ecc71', '#e74c3c', '#f39c12'],\n        explode=[0.05, 0.05, 0.05, 0.05],  # malo razdvoji sve\n        shadow=True)\nplt.title('Budzet za skolski izlet (ukupno 7000 din)')\nplt.show()"),
                ])

                // --- TABELA KOMANDI ---
                . '<h3>Pregled komandi za sektorski dijagram</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Komanda</th><th>Sta radi</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>plt.pie(vrednosti)</code></td><td>Crta sektorski dijagram</td><td><code>plt.pie([12, 8, 5])</code></td></tr>'
                . '<tr><td><code>labels=[...]</code></td><td>Imena sektora</td><td><code>labels=[\'A\', \'B\', \'C\']</code></td></tr>'
                . '<tr><td><code>colors=[...]</code></td><td>Boje sektora</td><td><code>colors=[\'red\', \'blue\']</code></td></tr>'
                . '<tr><td><code>autopct=\'%1.1f%%\'</code></td><td>Prikazuje procente (1 decimala)</td><td>Rezultat: "40.0%"</td></tr>'
                . '<tr><td><code>autopct=\'%1.0f%%\'</code></td><td>Prikazuje procente (bez decimala)</td><td>Rezultat: "40%"</td></tr>'
                . '<tr><td><code>startangle=90</code></td><td>Pocetni ugao (90 = odozgo)</td><td><code>startangle=90</code></td></tr>'
                . '<tr><td><code>explode=[...]</code></td><td>Izvlaci sektore (0=ne, 0.1=da)</td><td><code>explode=[0.1, 0, 0]</code></td></tr>'
                . '<tr><td><code>shadow=True</code></td><td>Dodaje senku ispod dijagrama</td><td><code>shadow=True</code></td></tr>'
                . '<tr><td><code>textprops={...}</code></td><td>Podesavanje teksta</td><td><code>textprops={\'fontsize\': 14}</code></td></tr>'
                . '</tbody></table>'

                // --- Uporedna tabela sva 3 dijagrama ---
                . '<h3>Koji dijagram kada?</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Pitanje</th><th>Dijagram</th><th>Funkcija</th></tr></thead>'
                . '<tbody>'
                . '<tr><td>Kako se nesto menja tokom vremena?</td><td>Linijski</td><td><code>plt.plot()</code></td></tr>'
                . '<tr><td>Koja kategorija je najveca/najmanja?</td><td>Stubicasti</td><td><code>plt.bar()</code></td></tr>'
                . '<tr><td>Koliki procenat celine zauzima svaki deo?</td><td>Sektorski</td><td><code>plt.pie()</code></td></tr>'
                . '<tr><td>Kako su rasporedjene vrednosti?</td><td>Histogram</td><td><code>plt.hist()</code></td></tr>'
                . '</tbody></table>';

            $lesson->save();
            echo "Updated: Procenti i sektorski dijagrami\n";
        }

        echo "\nSve lekcije o dijagramima azurirane!\n";
    }
}
