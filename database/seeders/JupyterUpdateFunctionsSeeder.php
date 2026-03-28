<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Seeder;

class JupyterUpdateFunctionsSeeder extends Seeder
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
        // UPDATE: Racunanje u Jupyteru (lesson 713)
        // ============================================================
        $lesson = Lesson::where('course_id', 4)->where('title', 'Racunanje u Jupyteru')->first();
        if ($lesson) {
            $lesson->content = '<h2>Racunanje u Jupyteru</h2>'
                . '<p>Jupyter je savrseni digitron! Mozes da racunas sve - od prostih operacija do slozenih formula.</p>'

                // --- print() objasnjenje ---
                . '<h3>Funkcija print()</h3>'
                . '<p>Pre nego sto pocnemo da racunamo, upoznajmo nasu najvazniju funkciju: <code>print()</code>.</p>'
                . '<p><strong>Sta radi:</strong> Ispisuje tekst ili vrednost na ekran. Bez nje ne bismo videli rezultate!</p>'
                . '<p><strong>Kako se koristi:</strong> Napisemo <code>print()</code> i u zagradu stavimo ono sto zelimo da ispisemo. Tekst ide pod navodnike, brojevi bez navodnika.</p>'
                . $this->notebook([
                    $this->md("## Funkcija print()\n`print()` ispisuje ono sto stavimo u zagradu:"),
                    $this->code("# Ispisujemo tekst (pod navodnicima)\nprint('Zdravo svete!')\n\n# Ispisujemo broj (bez navodnika)\nprint(42)\n\n# Ispisujemo vise stvari odjednom (razdvojeno zarezom)\nprint('Rezultat je:', 5 + 3)\n\n# f-string - ubacujemo promenljive u tekst\nime = 'Marko'\nprint(f'Zdravo, {ime}!')"),
                ])

                // --- Osnovne operacije ---
                . '<h3>Osnovne operacije</h3>'
                . '<p>Python zna sve matematicke operacije. Evo ih:</p>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Operacija</th><th>Znak</th><th>Primer</th><th>Rezultat</th></tr></thead>'
                . '<tbody>'
                . '<tr><td>Sabiranje</td><td><code>+</code></td><td><code>5 + 3</code></td><td>8</td></tr>'
                . '<tr><td>Oduzimanje</td><td><code>-</code></td><td><code>100 - 37</code></td><td>63</td></tr>'
                . '<tr><td>Mnozenje</td><td><code>*</code></td><td><code>6 * 7</code></td><td>42</td></tr>'
                . '<tr><td>Deljenje</td><td><code>/</code></td><td><code>100 / 3</code></td><td>33.33...</td></tr>'
                . '<tr><td>Celobrojno deljenje</td><td><code>//</code></td><td><code>17 // 5</code></td><td>3</td></tr>'
                . '<tr><td>Ostatak pri deljenju</td><td><code>%</code></td><td><code>17 % 5</code></td><td>2</td></tr>'
                . '<tr><td>Stepenovanje</td><td><code>**</code></td><td><code>2 ** 10</code></td><td>1024</td></tr>'
                . '</tbody></table>'
                . '<p>Probaj sam u notebooku ispod:</p>'
                . $this->notebook([
                    $this->md("## Probaj sve operacije:"),
                    $this->code("# Sabiranje i oduzimanje\nprint('5 + 3 =', 5 + 3)\nprint('100 - 37 =', 100 - 37)"),
                    $this->code("# Mnozenje i deljenje\nprint('6 * 7 =', 6 * 7)\nprint('100 / 3 =', 100 / 3)     # obicno deljenje (sa decimalama)"),
                    $this->code("# Celobrojno deljenje i ostatak\n# // deli i odbacuje decimale, % daje ostatak\nprint('17 // 5 =', 17 // 5)  # 17 podeljeno sa 5 je 3 cela puta\nprint('17 % 5 =', 17 % 5)    # i ostaje 2 (jer 3*5=15, 17-15=2)"),
                    $this->code("# Stepenovanje - ** znaci \"na stepen\"\nprint('2 na 10 =', 2 ** 10)   # 2 * 2 * 2 ... (10 puta) = 1024\nprint('3 na 4 =', 3 ** 4)     # 3 * 3 * 3 * 3 = 81"),
                ])

                // --- round() i abs() ---
                . '<h3>Funkcije round() i abs()</h3>'
                . '<p><strong><code>round(broj, decimale)</code></strong> - zaokruzuje broj na zadati broj decimala. Ako ne napisemo broj decimala, zaokruzuje na ceo broj.</p>'
                . '<p>Zamisli da ti digitron pokaze 3.14159265... a tebi treba samo dve decimale. Onda koristis <code>round(3.14159, 2)</code> i dobijes 3.14.</p>'
                . '<p><strong><code>abs(broj)</code></strong> - daje apsolutnu vrednost (uklanja minus). Uvek vraca pozitivan broj.</p>'
                . '<p>Na primer, ako je temperatura -7 stepeni, <code>abs(-7)</code> vraca 7. Korisno kada nas zanima samo koliko je daleko od nule, ne u kom smeru.</p>'
                . $this->notebook([
                    $this->md("## round() i abs()"),
                    $this->code("# round() - zaokruzivanje\nprint('round(3.7) =', round(3.7))       # zaokruzi na ceo broj -> 4\nprint('round(3.2) =', round(3.2))       # zaokruzi na ceo broj -> 3\nprint('round(3.14159, 2) =', round(3.14159, 2))  # na 2 decimale -> 3.14\nprint('round(3.14159, 3) =', round(3.14159, 3))  # na 3 decimale -> 3.142"),
                    $this->code("# abs() - apsolutna vrednost (bez minusa)\nprint('abs(-7) =', abs(-7))     # 7\nprint('abs(7) =', abs(7))       # 7 (vec je pozitivan)\nprint('abs(-3.5) =', abs(-3.5)) # 3.5"),
                ])

                // --- import i math ---
                . '<h3>Biblioteka math</h3>'
                . '<p>Python ima ugradjen \"alat\" za osnovne stvari (<code>print</code>, <code>round</code>, <code>abs</code>...), ali za naprednije racunanje treba nam <strong>biblioteka</strong>.</p>'
                . '<p><strong>Sta je biblioteka?</strong> Zamisli biblioteku kao kutiju sa posebnim alatima. Da bi koristio alate, prvo moras da otvoris kutiju - to radimo sa <code>import</code>.</p>'
                . '<p><strong><code>import math</code></strong> - otvara kutiju sa matematickim alatima.</p>'

                . '<h4>math.sqrt() - kvadratni koren</h4>'
                . '<p><strong>Sta radi:</strong> Racuna kvadratni koren broja. Kvadratni koren od 144 je 12, jer 12 * 12 = 144.</p>'
                . '<p><strong>Primer iz zivota:</strong> Imas sobu povrsine 25 kvadratnih metara. Kolika je stranica ako je soba kvadratna? <code>math.sqrt(25) = 5</code> metara.</p>'

                . '<h4>math.pi - broj Pi</h4>'
                . '<p><strong>Sta je:</strong> Broj Pi (3.14159...) koristimo za racunanje sa krugovima. Nije funkcija vec konstanta (gotova vrednost).</p>'

                . '<h4>math.ceil() - zaokruzi navise</h4>'
                . '<p><strong>Sta radi:</strong> Zaokruzuje broj UVEK NAVISE na sledeci ceo broj. Cak i 3.01 postaje 4!</p>'
                . '<p><strong>Primer iz zivota:</strong> Imas 13 drugara i u svaki auto staje 4 osobe. Koliko auta ti treba? 13 / 4 = 3.25, ali ne mozes imati 3.25 auta - treba ti 4 auta! Zato koristis <code>math.ceil(3.25) = 4</code>.</p>'

                . '<h4>math.floor() - zaokruzi nanize</h4>'
                . '<p><strong>Sta radi:</strong> Suprotno od ceil - zaokruzuje UVEK NANIZE. Cak i 3.99 postaje 3.</p>'

                . $this->notebook([
                    $this->md("## Biblioteka math u akciji"),
                    $this->code("import math\n\n# math.sqrt() - kvadratni koren\nprint('Koren od 144 =', math.sqrt(144))  # 12, jer 12*12=144\nprint('Koren od 2 =', math.sqrt(2))      # 1.414..."),
                    $this->code("import math\n\n# math.pi - broj Pi\nprint('Pi =', math.pi)                            # 3.14159...\nprint('Pi zaokruzeno =', round(math.pi, 2))       # 3.14"),
                    $this->code("import math\n\n# math.ceil() - zaokruzi NAVISE\nprint('ceil(3.01) =', math.ceil(3.01))   # 4 (navise!)\nprint('ceil(3.99) =', math.ceil(3.99))   # 4\nprint('ceil(4.0) =', math.ceil(4.0))     # 4 (vec je ceo)\n\n# math.floor() - zaokruzi NANIZE\nprint('floor(3.99) =', math.floor(3.99)) # 3 (nanize!)\nprint('floor(3.01) =', math.floor(3.01)) # 3"),
                ])

                // --- Primer iz zivota ---
                . '<h3>Primer iz zivota: Planiranje rodjendana</h3>'
                . '<p>Hajde da iskoristimo sve naucene funkcije u jednom primeru:</p>'
                . $this->notebook([
                    $this->md("## Planiranje rodjendana\nKoristimo `math.ceil()` jer ne mozemo kupiti pola pizze!"),
                    $this->code("import math\n\n# Podaci\nbroj_gostiju = 12\ncena_pizze = 850     # jedna pizza za 4 osobe\ncena_soka = 180      # sok za 3 osobe\ncena_torte = 2500    # jedna torta\n\n# Koliko pizza treba? 12/4 = 3.0 -> math.ceil(3.0) = 3\nbroj_pizza = math.ceil(broj_gostiju / 4)\n\n# Koliko sokova? 12/3 = 4.0 -> math.ceil(4.0) = 4\nbroj_sokova = math.ceil(broj_gostiju / 3)\n\nukupno = broj_pizza * cena_pizze + broj_sokova * cena_soka + cena_torte\n\nprint(f'Za {broj_gostiju} gostiju treba:')\nprint(f'  Pizza: {broj_pizza} komada = {broj_pizza * cena_pizze} din')\nprint(f'  Sokovi: {broj_sokova} komada = {broj_sokova * cena_soka} din')\nprint(f'  Torta: {cena_torte} din')\nprint(f'  UKUPNO: {ukupno} din')"),
                ])

                // --- TABELA SA SVIM KOMANDAMA ---
                . '<h3>Pregled svih komandi</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Komanda</th><th>Sta radi</th><th>Primer</th><th>Rezultat</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>print()</code></td><td>Ispisuje na ekran</td><td><code>print(\'Zdravo\')</code></td><td>Zdravo</td></tr>'
                . '<tr><td><code>round(x, n)</code></td><td>Zaokruzuje broj x na n decimala</td><td><code>round(3.14159, 2)</code></td><td>3.14</td></tr>'
                . '<tr><td><code>abs(x)</code></td><td>Apsolutna vrednost (uklanja minus)</td><td><code>abs(-7)</code></td><td>7</td></tr>'
                . '<tr><td><code>import math</code></td><td>Uvozi matematicku biblioteku</td><td><code>import math</code></td><td>-</td></tr>'
                . '<tr><td><code>math.sqrt(x)</code></td><td>Kvadratni koren</td><td><code>math.sqrt(144)</code></td><td>12.0</td></tr>'
                . '<tr><td><code>math.pi</code></td><td>Broj Pi (3.14159...)</td><td><code>math.pi</code></td><td>3.14159...</td></tr>'
                . '<tr><td><code>math.ceil(x)</code></td><td>Zaokruzi navise</td><td><code>math.ceil(3.01)</code></td><td>4</td></tr>'
                . '<tr><td><code>math.floor(x)</code></td><td>Zaokruzi nanize</td><td><code>math.floor(3.99)</code></td><td>3</td></tr>'
                . '<tr><td><code>math.pow(x, y)</code></td><td>x na stepen y (isto kao x**y)</td><td><code>math.pow(2, 10)</code></td><td>1024.0</td></tr>'
                . '<tr><td><code>type(x)</code></td><td>Pokazuje tip podatka</td><td><code>type(42)</code></td><td>int</td></tr>'
                . '<tr><td><code>int(x)</code></td><td>Pretvara u ceo broj</td><td><code>int(3.7)</code></td><td>3</td></tr>'
                . '<tr><td><code>float(x)</code></td><td>Pretvara u decimalni broj</td><td><code>float(5)</code></td><td>5.0</td></tr>'
                . '<tr><td><code>str(x)</code></td><td>Pretvara u tekst</td><td><code>str(42)</code></td><td>\'42\'</td></tr>'
                . '</tbody></table>';

            $lesson->save();
            echo "Updated: Racunanje u Jupyteru\n";
        }

        // ============================================================
        // UPDATE: Nizovi (liste) podataka (lesson 715)
        // ============================================================
        $lesson = Lesson::where('course_id', 4)->where('title', 'Nizovi (liste) podataka')->first();
        if ($lesson) {
            $lesson->content = '<h2>Nizovi (liste) podataka</h2>'
                . '<p>U svakodnevnom zivotu stalno radimo sa nizovima podataka. Temperature tokom nedelje, ocene iz predmeta, broj golova po utakmici... U Pythonu koristimo <strong>liste</strong> da cuvamo ovakve podatke.</p>'

                . '<h3>Sta je lista?</h3>'
                . '<p>Lista je uredjen niz podataka u uglastim zagradama. Zamisli je kao policu za knjige - svaka knjiga ima svoje mesto (indeks), pocevsi od 0.</p>'
                . $this->notebook([
                    $this->md("## Liste u Pythonu\nLista je niz vrednosti u uglastim zagradama `[ ]`:"),
                    $this->code("# Lista ocena\nocene = [5, 4, 5, 3, 5, 4, 5]\nprint('Ocene:', ocene)\nprint('Broj ocena:', len(ocene))"),
                    $this->code("# Pristup elementima - indeks pocinje od 0!\nprint('Prva ocena:', ocene[0])      # prvi element\nprint('Poslednja ocena:', ocene[-1]) # poslednji element\nprint('Prva tri:', ocene[0:3])       # od 0 do 3 (ne ukljucujuci 3)"),
                    $this->code("# Lista moze da sadrzi razlicite tipove\nucenici = ['Ana', 'Marko', 'Jovana', 'Stefan']\nprint('Ucenici:', ucenici)\nprint('Drugi ucenik:', ucenici[1])   # indeks 1 = drugi element"),
                ])

                // --- len() ---
                . '<h3>Funkcija len()</h3>'
                . '<p><strong>Sta radi:</strong> Broji koliko elemenata ima u listi (ili koliko slova ima u tekstu). Ime dolazi od engleske reci "length" (duzina).</p>'
                . '<p><strong>Primer iz zivota:</strong> Imas korpu sa vocem. <code>len(korpa)</code> ti kaze koliko komada voca imas.</p>'
                . $this->notebook([
                    $this->md("## len() - broji elemente"),
                    $this->code("ocene = [5, 4, 5, 3, 5]\nprint('Broj ocena:', len(ocene))  # 5 ocena u listi\n\nime = 'Informatika'\nprint('Broj slova:', len(ime))    # 11 slova u reci\n\nprazna = []\nprint('Prazna lista:', len(prazna))  # 0 elemenata"),
                ])

                // --- sum(), min(), max() ---
                . '<h3>Funkcije sum(), min(), max()</h3>'
                . '<p><strong><code>sum(lista)</code></strong> - sabira sve elemente u listi. Kao kada sabiras ocene na papiru, ali mnogo brze!</p>'
                . '<p><strong><code>min(lista)</code></strong> - nalazi najmanji element. Kao kada trazis najnizu temperaturu u nedelji.</p>'
                . '<p><strong><code>max(lista)</code></strong> - nalazi najveci element. Kao kada trazis ko ima najvise bodova.</p>'
                . $this->notebook([
                    $this->md("## sum(), min(), max()"),
                    $this->code("ocene = [5, 4, 5, 3, 5, 4, 5]\n\n# sum() - sabira sve\nprint('Zbir svih ocena:', sum(ocene))   # 5+4+5+3+5+4+5 = 31\n\n# min() - najmanja vrednost\nprint('Najniza ocena:', min(ocene))     # 3\n\n# max() - najveca vrednost\nprint('Najvisa ocena:', max(ocene))     # 5\n\n# Prosek = zbir / broj\nprosek = sum(ocene) / len(ocene)\nprint(f'Prosek: {prosek:.2f}')          # 31/7 = 4.43"),
                ])

                // --- append() i remove() ---
                . '<h3>Metode append() i remove()</h3>'
                . '<p><strong><code>lista.append(element)</code></strong> - dodaje element na kraj liste. Kao kada stavis novu knjigu na kraj police.</p>'
                . '<p><strong><code>lista.remove(element)</code></strong> - uklanja prvo pojavljivanje elementa. Kao kada skines jednu knjigu sa police.</p>'
                . '<p><em>Napomena:</em> Ove funkcije se pisu sa tackom posle liste (<code>lista.append()</code>), jer pripadaju samoj listi. To se zove <strong>metoda</strong>.</p>'
                . $this->notebook([
                    $this->md("## append() i remove()"),
                    $this->code("ocene = [5, 4, 5, 3, 5]\nprint('Pre:', ocene)\n\n# append() - dodaj na kraj\nocene.append(4)\nprint('Posle append(4):', ocene)  # [5, 4, 5, 3, 5, 4]\n\n# remove() - ukloni prvo pojavljivanje\nocene.remove(3)\nprint('Posle remove(3):', ocene)  # [5, 4, 5, 5, 4] - obrisana je trojka"),
                    $this->code("# Paznja: remove brise samo PRVO pojavljivanje!\nbroj = [5, 3, 5, 3, 5]\nbroj.remove(5)\nprint(broj)   # [3, 5, 3, 5] - obrisana samo prva petica"),
                ])

                // --- sorted() ---
                . '<h3>Funkcija sorted()</h3>'
                . '<p><strong>Sta radi:</strong> Sortira (uredjuje) listu od najmanjeg do najveceg. Sa <code>reverse=True</code> sortira od najveceg do najmanjeg.</p>'
                . '<p><strong>Vazno:</strong> <code>sorted()</code> pravi NOVU listu i ne menja originalnu. Ako hoces da promenis originalnu, koristi <code>lista.sort()</code>.</p>'
                . $this->notebook([
                    $this->md("## sorted() - sortiranje"),
                    $this->code("brojevi = [42, 17, 8, 95, 33, 61]\n\n# sorted() pravi novu sortiranu listu\nprint('Originalno:', brojevi)\nprint('Sortirano:', sorted(brojevi))                   # [8, 17, 33, 42, 61, 95]\nprint('Obrnuto:', sorted(brojevi, reverse=True))        # [95, 61, 42, 33, 17, 8]\nprint('Original je nepromenjen:', brojevi)              # [42, 17, 8, 95, 33, 61]"),
                    $this->code("# Sortiranje teksta (po abecedi)\nimena = ['Stefan', 'Ana', 'Milica', 'Bojan']\nprint('Po abecedi:', sorted(imena))"),
                ])

                // --- zip() i index() ---
                . '<h3>Funkcije zip() i index()</h3>'
                . '<p><strong><code>zip(lista1, lista2)</code></strong> - spaja dve liste u parove. Kao kada sparujes cipele - leva sa desnom.</p>'
                . '<p><strong><code>lista.index(element)</code></strong> - nalazi na kojoj poziciji se element nalazi. Vraca indeks (broj mesta).</p>'
                . $this->notebook([
                    $this->md("## zip() i index()"),
                    $this->code("# zip() - spaja dve liste u parove\ndani = ['Pon', 'Uto', 'Sre', 'Cet', 'Pet']\ntemperature = [12, 14, 11, 15, 17]\n\n# Prolazimo kroz obe liste istovremeno\nfor dan, temp in zip(dani, temperature):\n    print(f'{dan}: {temp} C')"),
                    $this->code("# index() - gde se nalazi element?\nocene = [5, 4, 5, 3, 5, 4]\n\nprint('Gde je trojka?', ocene.index(3))    # na poziciji 3\nprint('Gde je prva 5?', ocene.index(5))    # na poziciji 0\n\n# Korisno: koji dan je bio najtopliji?\ndani = ['Pon', 'Uto', 'Sre', 'Cet', 'Pet']\ntemp = [12, 14, 11, 15, 17]\npozicija = temp.index(max(temp))           # pozicija max temperature\nprint(f'Najtopliji dan: {dani[pozicija]}') # Pet"),
                ])

                // --- Primer iz zivota ---
                . '<h3>Sve zajedno: Temperature u Zrenjaninu</h3>'
                . $this->notebook([
                    $this->md("## Kompletna analiza temperature"),
                    $this->code("temperature = [12, 14, 11, 15, 17, 16, 13]\ndani = ['Pon', 'Uto', 'Sre', 'Cet', 'Pet', 'Sub', 'Ned']\n\nprint('Temperature po danima:')\nfor dan, temp in zip(dani, temperature):\n    print(f'  {dan}: {temp} C')\n\nprint(f'\\nBroj merenja: {len(temperature)}')\nprint(f'Prosek: {sum(temperature)/len(temperature):.1f} C')\nprint(f'Minimum: {min(temperature)} C ({dani[temperature.index(min(temperature))]})')\nprint(f'Maksimum: {max(temperature)} C ({dani[temperature.index(max(temperature))]})')"),
                ])

                // --- TABELA SA SVIM KOMANDAMA ---
                . '<h3>Pregled svih komandi za liste</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Komanda</th><th>Sta radi</th><th>Primer</th><th>Rezultat</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>len(lista)</code></td><td>Broj elemenata</td><td><code>len([5,4,3])</code></td><td>3</td></tr>'
                . '<tr><td><code>sum(lista)</code></td><td>Zbir svih elemenata</td><td><code>sum([5,4,3])</code></td><td>12</td></tr>'
                . '<tr><td><code>min(lista)</code></td><td>Najmanji element</td><td><code>min([5,4,3])</code></td><td>3</td></tr>'
                . '<tr><td><code>max(lista)</code></td><td>Najveci element</td><td><code>max([5,4,3])</code></td><td>5</td></tr>'
                . '<tr><td><code>sorted(lista)</code></td><td>Nova sortirana lista</td><td><code>sorted([3,1,2])</code></td><td>[1, 2, 3]</td></tr>'
                . '<tr><td><code>lista.append(x)</code></td><td>Dodaj na kraj</td><td><code>[1,2].append(3)</code></td><td>[1, 2, 3]</td></tr>'
                . '<tr><td><code>lista.remove(x)</code></td><td>Ukloni prvo pojavljivanje</td><td><code>[1,2,3].remove(2)</code></td><td>[1, 3]</td></tr>'
                . '<tr><td><code>lista.index(x)</code></td><td>Pozicija elementa</td><td><code>[5,4,3].index(4)</code></td><td>1</td></tr>'
                . '<tr><td><code>lista.count(x)</code></td><td>Koliko puta se pojavljuje</td><td><code>[5,5,3].count(5)</code></td><td>2</td></tr>'
                . '<tr><td><code>lista.sort()</code></td><td>Sortira originalnu listu</td><td><code>[3,1,2].sort()</code></td><td>[1, 2, 3]</td></tr>'
                . '<tr><td><code>lista.reverse()</code></td><td>Obrce redosled</td><td><code>[1,2,3].reverse()</code></td><td>[3, 2, 1]</td></tr>'
                . '<tr><td><code>lista.insert(i, x)</code></td><td>Ubaci x na poziciju i</td><td><code>[1,3].insert(1, 2)</code></td><td>[1, 2, 3]</td></tr>'
                . '<tr><td><code>lista.pop()</code></td><td>Ukloni i vrati poslednji</td><td><code>[1,2,3].pop()</code></td><td>3</td></tr>'
                . '<tr><td><code>x in lista</code></td><td>Da li je x u listi?</td><td><code>5 in [5,4,3]</code></td><td>True</td></tr>'
                . '<tr><td><code>zip(a, b)</code></td><td>Spaja dve liste u parove</td><td><code>zip([1,2],[\'a\',\'b\'])</code></td><td>(1,a), (2,b)</td></tr>'
                . '</tbody></table>';

            $lesson->save();
            echo "Updated: Nizovi (liste) podataka\n";
        }

        // ============================================================
        // UPDATE: Prosek niza brojeva (lesson 719)
        // ============================================================
        $lesson = Lesson::where('course_id', 4)->where('title', 'Prosek niza brojeva')->first();
        if ($lesson) {
            $lesson->content = '<h2>Prosek niza brojeva</h2>'
                . '<p>Prosek (aritmeticka sredina) je jedan od najvaznijih pojmova u matematici i analizi podataka. Izracunava se tako sto saberemo sve brojeve i podelimo sa brojem elemenata.</p>'

                . '<h3>Racunanje proseka rucno</h3>'
                . '<p>Prosek izracunavamo formulom: <strong>prosek = zbir / broj_elemenata</strong>. U Pythonu vec znamo funkcije <code>sum()</code> i <code>len()</code>, pa je to lako:</p>'
                . $this->notebook([
                    $this->md("## Prosek - rucni nacin"),
                    $this->code("ocene = [5, 4, 5, 3, 4, 5]\n\n# sum() sabira sve, len() broji koliko ih ima\nprosek = sum(ocene) / len(ocene)\nprint(f'Zbir: {sum(ocene)}')\nprint(f'Broj ocena: {len(ocene)}')\nprint(f'Prosek: {prosek:.2f}')   # :.2f znaci 2 decimale"),
                ])

                . '<h3>Biblioteka statistics</h3>'
                . '<p>Python ima posebnu biblioteku <code>statistics</code> koja zna sve o statistici. Uvozimo je sa <code>import statistics</code>.</p>'

                . '<h4>statistics.mean() - prosek (aritmeticka sredina)</h4>'
                . '<p><strong>Sta radi:</strong> Isto sto i <code>sum()/len()</code>, ali je citljivije. "Mean" na engleskom znaci "srednja vrednost".</p>'

                . '<h4>statistics.median() - medijana (srednji element)</h4>'
                . '<p><strong>Sta radi:</strong> Nalazi srednju vrednost kada poredamo brojeve po velicini.</p>'
                . '<p><strong>Primer iz zivota:</strong> Ako 5 ucenika imaju ocene [2, 3, 4, 5, 5], medijana je 4 (srednji broj). Medijana je korisna jer je ne kvare ekstremne vrednosti - ako jedan ucenik ima 1, prosek pada mnogo, ali medijana ostaje slicna.</p>'

                . '<h4>statistics.mode() - mod (najcesci element)</h4>'
                . '<p><strong>Sta radi:</strong> Nalazi vrednost koja se najcesce pojavljuje.</p>'
                . '<p><strong>Primer iz zivota:</strong> Ako u odeljenju ocene iz informatike idu [5, 4, 5, 5, 4, 3, 5], mod je 5 jer se pojavljuje 4 puta - najcesce od svih.</p>'

                . $this->notebook([
                    $this->md("## Biblioteka statistics"),
                    $this->code("import statistics\n\nocene = [5, 4, 5, 3, 4, 5]\n\n# mean() - prosek\nprint(f'Prosek (mean): {statistics.mean(ocene):.2f}')   # 4.33\n\n# median() - srednji element kad se sortiraju\n# Sortirano: [3, 4, 4, 5, 5, 5] -> sredina izmedju 4 i 5 = 4.5\nprint(f'Medijana: {statistics.median(ocene)}')           # 4.5\n\n# mode() - najcesci element\n# Petica se pojavljuje 3 puta - najcesce\nprint(f'Mod (najcesci): {statistics.mode(ocene)}')       # 5"),
                    $this->md("### Zasto su razliciti?\n- **Prosek** = 4.33 (zbir/broj)\n- **Medijana** = 4.5 (srednja vrednost)\n- **Mod** = 5 (najcesci)\n\nSvaki daje drugaciju sliku podataka. Zajedno nam daju kompletnu pricu!"),
                ])

                . '<h3>Primer: Analiza temperature u Zrenjaninu</h3>'
                . $this->notebook([
                    $this->md("## Mesecne temperature u Zrenjaninu"),
                    $this->code("import matplotlib.pyplot as plt\nimport statistics\n\nmeseci = ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun',\n          'Jul', 'Avg', 'Sep', 'Okt', 'Nov', 'Dec']\ntemperature = [1, 3, 9, 14, 19, 23, 26, 25, 20, 14, 8, 2]\n\nprosek = statistics.mean(temperature)\nprint(f'Prosecna godisnja temperatura: {prosek:.1f} C')\nprint(f'Medijana: {statistics.median(temperature)} C')\nprint(f'Najhladniji: {meseci[temperature.index(min(temperature))]} ({min(temperature)} C)')\nprint(f'Najtopliji: {meseci[temperature.index(max(temperature))]} ({max(temperature)} C)')\n\n# Dijagram - hladni meseci plavo, topli crveno\nplt.figure(figsize=(10, 4))\nplt.bar(meseci, temperature,\n        color=['#4FC3F7' if t < prosek else '#FF7043' for t in temperature])\nplt.axhline(y=prosek, color='gray', linestyle='--',\n            label=f'Prosek ({prosek:.1f} C)')\nplt.title('Mesecne temperature u Zrenjaninu')\nplt.ylabel('Temperatura (C)')\nplt.legend()\nplt.grid(axis='y', alpha=0.3)\nplt.show()"),
                ])

                // --- TABELA ---
                . '<h3>Pregled komandi za statistiku</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Komanda</th><th>Sta radi</th><th>Primer</th><th>Rezultat</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>sum(lista)/len(lista)</code></td><td>Prosek (rucno)</td><td><code>sum([4,5,3])/len([4,5,3])</code></td><td>4.0</td></tr>'
                . '<tr><td><code>statistics.mean()</code></td><td>Prosek (aritmeticka sredina)</td><td><code>statistics.mean([4,5,3])</code></td><td>4.0</td></tr>'
                . '<tr><td><code>statistics.median()</code></td><td>Medijana (srednji element)</td><td><code>statistics.median([1,3,5])</code></td><td>3</td></tr>'
                . '<tr><td><code>statistics.mode()</code></td><td>Mod (najcesci element)</td><td><code>statistics.mode([5,5,3])</code></td><td>5</td></tr>'
                . '<tr><td><code>statistics.stdev()</code></td><td>Standardna devijacija (rasipanje)</td><td><code>statistics.stdev([2,4,6])</code></td><td>2.0</td></tr>'
                . '<tr><td><code>min(lista)</code></td><td>Najmanji element</td><td><code>min([4,5,3])</code></td><td>3</td></tr>'
                . '<tr><td><code>max(lista)</code></td><td>Najveci element</td><td><code>max([4,5,3])</code></td><td>5</td></tr>'
                . '</tbody></table>';

            $lesson->save();
            echo "Updated: Prosek niza brojeva\n";
        }

        // ============================================================
        // UPDATE: Frekvencijska analiza (lesson 721)
        // ============================================================
        $lesson = Lesson::where('course_id', 4)->where('title', 'Frekvencijska analiza')->first();
        if ($lesson) {
            $lesson->content = '<h2>Frekvencijska analiza</h2>'
                . '<p>Frekvencija znaci "koliko cesto se nesto pojavljuje". Ako bacis kockicu 100 puta, koliko cesto ce pasti svaki broj? To je frekvencijska analiza!</p>'

                // --- count() ---
                . '<h3>Metoda count()</h3>'
                . '<p><strong>Sta radi:</strong> Broji koliko puta se odredjeni element pojavljuje u listi.</p>'
                . '<p><strong>Primer iz zivota:</strong> Imas listu ocena i hoces da znas koliko petica imas. <code>ocene.count(5)</code> ti daje odgovor!</p>'
                . $this->notebook([
                    $this->md("## count() - broji pojavljivanja"),
                    $this->code("ocene = [5, 4, 5, 3, 4, 5, 5, 4, 3, 5,\n         4, 4, 5, 2, 4, 5, 3, 4, 5, 4,\n         5, 3, 4, 4, 5, 4, 3, 5, 4, 5]\n\n# count() broji koliko puta se pojavljuje svaki element\nfor ocena in [1, 2, 3, 4, 5]:\n    broj = ocene.count(ocena)       # koliko puta se pojavljuje\n    procenat = (broj / len(ocene)) * 100\n    zvezdice = '*' * broj            # vizuelni prikaz\n    print(f'Ocena {ocena}: {zvezdice} {broj} ({procenat:.0f}%)')"),
                ])

                // --- Counter ---
                . '<h3>Counter - automatsko brojanje</h3>'
                . '<p>Kada imamo mnogo razlicitih vrednosti, rucno brojanje sa <code>count()</code> je zamorno. Biblioteka <code>collections</code> ima alat <strong>Counter</strong> koji sve izbroji odjednom!</p>'
                . '<p><strong><code>Counter(lista)</code></strong> - pravi recnik gde su kljucevi elementi, a vrednosti koliko se puta pojavljuju.</p>'
                . '<p><strong><code>Counter.most_common(n)</code></strong> - vraca n najcescih elemenata, sortirano od najcesceg.</p>'
                . $this->notebook([
                    $this->md("## Counter iz collections"),
                    $this->code("from collections import Counter\n\nocene = [5, 4, 5, 3, 4, 5, 5, 4, 3, 5,\n         4, 4, 5, 2, 4, 5, 3, 4, 5, 4,\n         5, 3, 4, 4, 5, 4, 3, 5, 4, 5]\n\n# Counter automatski broji sve\nbrojac = Counter(ocene)\nprint('Frekvencije:', dict(brojac))\n# {5: 12, 4: 11, 3: 5, 2: 1}\n\n# most_common() - sortira od najcesceg\nprint('\\nOd najcesceg:')\nfor ocena, broj in brojac.most_common():\n    print(f'  Ocena {ocena}: {broj} puta')\n\n# Samo najcesci element\nprint(f'\\nNajcesca ocena: {brojac.most_common(1)[0][0]}')"),
                ])

                // --- Vizuelizacija ---
                . '<h3>Vizuelizacija frekvencija</h3>'
                . $this->notebook([
                    $this->md("## Frekvencijski dijagram"),
                    $this->code("import matplotlib.pyplot as plt\nfrom collections import Counter\n\nocene = [5, 4, 5, 3, 4, 5, 5, 4, 3, 5,\n         4, 4, 5, 2, 4, 5, 3, 4, 5, 4,\n         5, 3, 4, 4, 5, 4, 3, 5, 4, 5]\n\nbrojac = Counter(ocene)\nvrste = sorted(brojac.keys())               # [2, 3, 4, 5]\nfrekvencije = [brojac[v] for v in vrste]     # broj za svaku ocenu\n\nplt.figure(figsize=(8, 4))\nbars = plt.bar(vrste, frekvencije,\n               color=['#e74c3c', '#e67e22', '#f39c12', '#2ecc71', '#3498db'])\nplt.title('Raspodela ocena u odeljenju')\nplt.xlabel('Ocena')\nplt.ylabel('Broj ucenika')\n\n# Dodaj broj iznad svakog stubica\nfor bar, freq in zip(bars, frekvencije):\n    plt.text(bar.get_x() + bar.get_width()/2, bar.get_height() + 0.3,\n             str(freq), ha='center', fontsize=12, fontweight='bold')\n\nplt.grid(axis='y', alpha=0.3)\nplt.show()"),
                ])

                // --- Primer anketa ---
                . '<h3>Primer: Anketa o omiljenom sportu</h3>'
                . $this->notebook([
                    $this->md("## Mini anketa\nCounter radi i sa tekstom, ne samo sa brojevima:"),
                    $this->code("import matplotlib.pyplot as plt\nfrom collections import Counter\n\nodgovori = ['fudbal', 'kosarka', 'fudbal', 'tenis', 'fudbal',\n            'odbojka', 'kosarka', 'fudbal', 'plivanje', 'fudbal',\n            'kosarka', 'odbojka', 'fudbal', 'tenis', 'kosarka',\n            'fudbal', 'plivanje', 'kosarka', 'fudbal', 'odbojka']\n\nbrojac = Counter(odgovori)\n\nprint('Rezultati ankete:')\nfor sport, broj in brojac.most_common():\n    procenat = (broj / len(odgovori)) * 100\n    traka = '#' * broj\n    print(f'  {sport:10s} {traka} {broj} ({procenat:.0f}%)')\n\n# Sektorski dijagram\nplt.figure(figsize=(7, 7))\nplt.pie(brojac.values(), labels=brojac.keys(),\n        autopct='%1.0f%%', startangle=90,\n        colors=['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7'])\nplt.title('Omiljeni sport u odeljenju')\nplt.show()"),
                ])

                // --- TABELA ---
                . '<h3>Pregled komandi za frekvencijsku analizu</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Komanda</th><th>Sta radi</th><th>Primer</th><th>Rezultat</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>lista.count(x)</code></td><td>Broji koliko puta se x pojavljuje</td><td><code>[5,4,5].count(5)</code></td><td>2</td></tr>'
                . '<tr><td><code>Counter(lista)</code></td><td>Broji sve elemente odjednom</td><td><code>Counter([5,4,5])</code></td><td>{5: 2, 4: 1}</td></tr>'
                . '<tr><td><code>brojac.most_common(n)</code></td><td>Top n najcescih</td><td><code>Counter([5,4,5]).most_common(1)</code></td><td>[(5, 2)]</td></tr>'
                . '<tr><td><code>dict(brojac)</code></td><td>Pretvori Counter u recnik</td><td><code>dict(Counter([5,4,5]))</code></td><td>{5: 2, 4: 1}</td></tr>'
                . '<tr><td><code>brojac.keys()</code></td><td>Svi razliciti elementi</td><td><code>Counter([5,4,5]).keys()</code></td><td>[5, 4]</td></tr>'
                . '<tr><td><code>brojac.values()</code></td><td>Sve frekvencije</td><td><code>Counter([5,4,5]).values()</code></td><td>[2, 1]</td></tr>'
                . '</tbody></table>';

            $lesson->save();
            echo "Updated: Frekvencijska analiza\n";
        }

        echo "\nSve lekcije azurirane sa objasnjenjima funkcija i tabelama!\n";
    }
}
