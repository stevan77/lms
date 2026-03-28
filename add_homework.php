<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Lesson;

$homework = [
    27 => [
        'title' => 'Domaći zadatak: Predstavi se!',
        'html' => '<h2>Domaći zadatak: Predstavi se!</h2>
<p>Napiši program koji ispisuje <strong>5 rečenica o tebi</strong>. Program treba da ispiše:</p>
<ol>
<li>Tvoje ime i prezime</li>
<li>Koliko imaš godina</li>
<li>U koji razred ideš</li>
<li>Šta ti je omiljeni predmet u školi</li>
<li>Šta voliš da radiš u slobodno vreme</li>
</ol>
<p>Svaka rečenica treba da bude u posebnom <code>print()</code>. Napravi lepo formatirano sa zaglavljem i linijama.</p>',
        'code' => "# DOMACI ZADATAK: Predstavi se!&#10;# Napravi program koji ispisuje 5 recenica o tebi&#10;# Koristi print() za svaku recenicu&#10;&#10;print('=============================')&#10;print('       O MENI')&#10;print('=============================')&#10;# Tvoj kod ide ovde:&#10;&#10;&#10;&#10;print('=============================')&#10;",
        'instructions' => 'Zameni komentare sa print() komandama koje ispisuju tvoje podatke. Neka izgleda lepo!',
    ],
    28 => [
        'title' => 'Domaći zadatak: Napravi poster',
        'html' => '<h2>Domaći zadatak: Napravi poster</h2>
<p>Napravi program koji ispisuje <strong>poster za tvoj omiljeni film, seriju ili igricu</strong>. Poster treba da sadrži:</p>
<ol>
<li>Naslov filma/serije/igrice (velikim slovima korišćenjem VELIKIH SLOVA u tekstu)</li>
<li>Kratki opis u 2-3 rečenice</li>
<li>Tvoja ocena od 1 do 5 zvezdica (napiši * za svaku zvezdicu)</li>
<li>Zašto preporučuješ drugima da pogledaju/igraju</li>
</ol>
<p>Koristi <code>print(\'*\' * 30)</code> za dekorativne linije i <code>print()</code> za prazne redove.</p>',
        'code' => "# DOMACI ZADATAK: Poster za omiljeni film/seriju/igricu&#10;# Koristi print() za svaki red&#10;# Koristi print('*' * 30) za dekorativne linije&#10;# Koristi print() za prazan red&#10;&#10;print('*' * 30)&#10;# Tvoj kod:&#10;&#10;&#10;&#10;print('*' * 30)",
        'instructions' => 'Napravi lep poster. Koristi * za linije, prazne redove za razmak, i # za komentare.',
    ],
    29 => [
        'title' => 'Domaći zadatak: Čuvaj podatke',
        'html' => '<h2>Domaći zadatak: Čuvaj podatke</h2>
<p>Napravi program koji koristi <strong>najmanje 6 promenljivih</strong> da opiše tvog kućnog ljubimca (ili zamišljenog ako ga nemaš). Koristi f-string za ispis.</p>
<p>Promenljive treba da budu:</p>
<ol>
<li><code>vrsta</code> — npr. "pas", "mačka", "hrčak"</li>
<li><code>ime_ljubimca</code> — ime tvog ljubimca</li>
<li><code>godine_ljubimca</code> — koliko ima godina (broj!)</li>
<li><code>boja</code> — koje je boje</li>
<li><code>tezina</code> — koliko je težak u kg (decimalni broj!)</li>
<li><code>voli_da</code> — šta voli da radi</li>
</ol>',
        'code' => "# DOMACI ZADATAK: Moj ljubimac&#10;# Napravi 6 promenljivih i ispisi ih sa f-stringom&#10;&#10;vrsta = ''&#10;ime_ljubimca = ''&#10;godine_ljubimca = 0&#10;boja = ''&#10;tezina = 0.0&#10;voli_da = ''&#10;&#10;# Ispisi sve koristeci f-string:&#10;print(f'=== Moj {vrsta} ===')&#10;# Dodaj ispis za svaku promenljivu&#10;",
        'instructions' => 'Popuni sve promenljive i dodaj f-string print za svaku. Koristi razlicite tipove: str, int, float!',
    ],
    30 => [
        'title' => 'Domaći zadatak: Detektiv tipova',
        'html' => '<h2>Domaći zadatak: Detektiv tipova</h2>
<p>Napravi program koji ima <strong>9 promenljivih</strong> — po 3 od svakog tipa (int, float, str). Za svaku promenljivu ispiši njenu vrednost i tip.</p>
<p>Na primer:</p>
<ul>
<li>3 celobrojna (int): broj učenika, broj stranica knjige, temperatura u celim stepenima</li>
<li>3 decimalna (float): prosečna ocena, cena sladoleda, težina u kg</li>
<li>3 teksta (str): ime grada, naziv škole, omiljeni citat</li>
</ul>
<p>Za svaku ispiši: vrednost, pa tip korišćenjem <code>type()</code>.</p>',
        'code' => "# DOMACI ZADATAK: Detektiv tipova&#10;# Napravi po 3 promenljive svakog tipa&#10;&#10;# 3 cela broja (int):&#10;broj_ucenika = 0&#10;# dodaj jos 2...&#10;&#10;# 3 decimalna broja (float):&#10;prosecna_ocena = 0.0&#10;# dodaj jos 2...&#10;&#10;# 3 teksta (str):&#10;ime_grada = ''&#10;# dodaj jos 2...&#10;&#10;# Ispisi svaku sa tipom:&#10;print(f'{broj_ucenika} — tip: {type(broj_ucenika)}')&#10;# Dodaj za ostale...&#10;",
        'instructions' => 'Napravi 9 promenljivih (3 int, 3 float, 3 str) i za svaku ispisi vrednost i tip.',
    ],
    31 => [
        'title' => 'Domaći zadatak: Intervju',
        'html' => '<h2>Domaći zadatak: Intervju</h2>
<p>Napravi program koji vodi <strong>intervju</strong> sa korisnikom. Program treba da:</p>
<ol>
<li>Pita za ime (tekst)</li>
<li>Pita za godinu rođenja (broj) i izračuna koliko ima godina</li>
<li>Pita za omiljenu hranu (tekst)</li>
<li>Pita koliko sati dnevno provodi za kompjuterom (decimalni broj)</li>
<li>Izračuna koliko sati nedeljno to bude (sati * 7)</li>
</ol>
<p>Na kraju ispiši sve odgovore u lepom formatu korišćenjem f-stringa.</p>',
        'code' => "# DOMACI ZADATAK: Intervju&#10;print('=== INTERVJU ===')&#10;print()&#10;&#10;ime = input('Kako se zoves? ')&#10;# Dodaj pitanje za godinu rodjenja (int)&#10;# Izracunaj godine: 2026 - godina_rodjenja&#10;# Dodaj pitanje za omiljenu hranu (str)&#10;# Dodaj pitanje za sate za kompjuterom (float)&#10;# Izracunaj sate nedeljno&#10;&#10;print()&#10;print('=== REZULTATI ===')&#10;print(f'Ime: {ime}')&#10;# Ispisi ostale rezultate sa f-stringom&#10;",
        'instructions' => 'Dovrsi intervju — dodaj sva pitanja sa ispravnim tipovima (int, float, str) i ispisi rezultate.',
    ],
    32 => [
        'title' => 'Domaći zadatak: Prodavnica',
        'html' => '<h2>Domaći zadatak: Prodavnica</h2>
<p>Napravi program za <strong>malu prodavnicu</strong>. Program treba da:</p>
<ol>
<li>Pita koliko košta hleb (float)</li>
<li>Pita koliko košta mleko (float)</li>
<li>Pita koliko košta čokolada (float)</li>
<li>Izračuna ukupnu cenu</li>
<li>Pita koliko novca kupac daje (float)</li>
<li>Izračuna i ispiše kusur (novac - ukupna_cena)</li>
</ol>
<p>Ako kupac nema dovoljno novca, ispiši koliko mu još treba.</p>',
        'code' => "# DOMACI ZADATAK: Prodavnica&#10;print('=== PRODAVNICA ===')&#10;print()&#10;&#10;hleb = float(input('Cena hleba: '))&#10;# Dodaj pitanja za mleko i cokoladu&#10;&#10;# Izracunaj ukupnu cenu&#10;# ukupno = hleb + mleko + cokolada&#10;&#10;# Ispisi ukupno&#10;&#10;# Pitaj koliko novca kupac daje&#10;&#10;# Izracunaj kusur ili koliko fali&#10;",
        'instructions' => 'Dovrsi program za prodavnicu. Izracunaj ukupno, kusur, i proveri da li kupac ima dovoljno novca.',
    ],
    33 => [
        'title' => 'Domaći zadatak: Šifrovana poruka',
        'html' => '<h2>Domaći zadatak: Šifrovana poruka</h2>
<p>Napravi program koji uzima ime korisnika i pravi <strong>tajni kod</strong> od njega:</p>
<ol>
<li>Pita za ime</li>
<li>Ispiše ime naopako (hint: <code>ime[::-1]</code>)</li>
<li>Ispiše samo svako drugo slovo (hint: <code>ime[::2]</code>)</li>
<li>Ispiše ime velikim slovima sa tačkom između svakog slova (hint: <code>\'.\'.join(ime.upper())</code>)</li>
<li>Ispiše koliko slova ima ime</li>
<li>Ispiše prvo i poslednje slovo</li>
</ol>',
        'code' => "# DOMACI ZADATAK: Sifrovana poruka&#10;&#10;ime = input('Unesi svoje ime: ')&#10;&#10;print(f'Originalno: {ime}')&#10;# Ispisi ime naopako&#10;# Ispisi svako drugo slovo&#10;# Ispisi velikim slovima sa tackama&#10;# Ispisi koliko slova ima&#10;# Ispisi prvo i poslednje slovo&#10;",
        'instructions' => 'Dovrsi program. Koristi [::-1], [::2], .upper(), len(), [0] i [-1].',
    ],
    34 => [
        'title' => 'Domaći zadatak: Kviz',
        'html' => '<h2>Domaći zadatak: Napravi kviz</h2>
<p>Napravi program koji je <strong>kviz sa 5 pitanja</strong>. Za svako pitanje:</p>
<ol>
<li>Ispiši pitanje</li>
<li>Pročitaj odgovor korisnika</li>
<li>Proveri da li je tačan sa if/else</li>
<li>Ako je tačan — dodaj bod i ispiši "Tačno!"</li>
<li>Ako nije — ispiši "Netačno! Tačan odgovor je..."</li>
</ol>
<p>Na kraju ispiši koliko je poena osvojio od 5.</p>',
        'code' => "# DOMACI ZADATAK: Kviz&#10;print('=== KVIZ ===')&#10;print()&#10;poeni = 0&#10;&#10;# Pitanje 1&#10;odgovor = input('Koji je glavni grad Srbije? ')&#10;if odgovor == 'Beograd':&#10;    print('Tacno!')&#10;    poeni = poeni + 1&#10;else:&#10;    print('Netacno! Tacan odgovor je Beograd.')&#10;&#10;# Dodaj jos 4 pitanja po istom principu&#10;&#10;&#10;print()&#10;print(f'Osvojio si {poeni} od 5 poena!')&#10;",
        'instructions' => 'Dodaj jos 4 pitanja. Smisli svoja pitanja (istorija, geografija, sport... sta hoces!). Ne zaboravi poeni = poeni + 1 za tacne.',
    ],
    35 => [
        'title' => 'Domaći zadatak: Restoran',
        'html' => '<h2>Domaći zadatak: Meni restorana</h2>
<p>Napravi program koji simulira <strong>naručivanje u restoranu</strong>:</p>
<ol>
<li>Ispiši meni sa 5 jela i cenama (npr. 1. Pica - 500din, 2. Pasta - 400din...)</li>
<li>Pita korisnika koji broj bira (1-5)</li>
<li>Korišćenjem elif ispiši koje jelo je izabrao i koliko košta</li>
<li>Pita da li želi desert (da/ne)</li>
<li>Ako želi — dodaj 200 dinara</li>
<li>Pita da li želi piće (da/ne)</li>
<li>Ako želi — dodaj 150 dinara</li>
<li>Na kraju ispiši ukupan račun</li>
</ol>',
        'code' => "# DOMACI ZADATAK: Restoran&#10;print('=== MENI ===')&#10;print('1. Pica — 500 din')&#10;print('2. Pasta — 400 din')&#10;print('3. Cevapi — 450 din')&#10;print('4. Salata — 300 din')&#10;print('5. Supa — 250 din')&#10;print()&#10;&#10;izbor = input('Izaberi jelo (1-5): ')&#10;racun = 0&#10;&#10;# Koristi if/elif/else da postavis cenu&#10;# Na osnovu izbora&#10;&#10;# Pitaj za desert i pice&#10;&#10;# Ispisi ukupan racun&#10;",
        'instructions' => 'Dovrsi program. Koristi if/elif/else za jelo, pa if/else za desert i pice. Na kraju ispisi racun.',
    ],
    36 => [
        'title' => 'Domaći zadatak: Crtanje',
        'html' => '<h2>Domaći zadatak: Crtanje sa zvezdicama</h2>
<p>Korišćenjem for petlje nacrtaj sledeće oblike sa zvezdicama (*):</p>
<p><strong>1. Kvadrat 5x5:</strong></p>
<pre><code>*****
*****
*****
*****
*****</code></pre>
<p><strong>2. Trougao:</strong></p>
<pre><code>*
**
***
****
*****</code></pre>
<p><strong>3. Obrnuti trougao:</strong></p>
<pre><code>*****
****
***
**
*</code></pre>
<p>Hint: <code>print(\'*\' * broj)</code> ispisuje onoliko zvezdica koliko je broj.</p>',
        'code' => "# DOMACI ZADATAK: Crtanje&#10;&#10;# 1. Kvadrat 5x5&#10;print('Kvadrat:')&#10;for i in range(5):&#10;    print('*' * 5)&#10;&#10;print()&#10;&#10;# 2. Trougao (1 zvezdica, pa 2, pa 3...)&#10;print('Trougao:')&#10;# Tvoj kod ovde&#10;&#10;print()&#10;&#10;# 3. Obrnuti trougao (5 zvezdica, pa 4, pa 3...)&#10;print('Obrnuti trougao:')&#10;# Tvoj kod ovde&#10;",
        'instructions' => 'Kvadrat je uraden za tebe. Nacrtaj trougao i obrnuti trougao koristeci for i range(). Hint: print(\"*\" * i)',
    ],
    37 => [
        'title' => 'Domaći zadatak: Igrica',
        'html' => '<h2>Domaći zadatak: Napravi svoju igricu!</h2>
<p>Napravi program koji je <strong>igrica pogađanja broja</strong>. Pravila:</p>
<ol>
<li>Kompjuter "zamisli" broj (ti ga napišeš u kodu, npr. 7)</li>
<li>Igrač ima <strong>5 pokušaja</strong> da pogodi</li>
<li>Posle svakog pokušaja, program kaže "Veći!" ili "Manji!"</li>
<li>Ako pogodi — ispiši "Bravo!" i koliko pokušaja je trebalo</li>
<li>Ako ne pogodi posle 5 pokušaja — ispiši "Nisi pogodio. Broj je bio..."</li>
<li>Na kraju pitaj "Želiš li ponovo?" (da/ne) — ako da, igra se ponovo!</li>
</ol>
<p>Ovo je kombinacija SVEGA što si naučio: print, input, if/elif/else, while, for, promenljive!</p>',
        'code' => "# DOMACI ZADATAK: Igrica pogadjanja!&#10;# Ovo je tvoj ZAVRSNI projekat!&#10;&#10;tajni_broj = 7&#10;&#10;igraj = 'da'&#10;while igraj == 'da':&#10;    print('Zamislio sam broj od 1 do 20!')&#10;    pokusaji = 0&#10;    pogodio = False&#10;&#10;    # Napravi petlju za 5 pokusaja&#10;    # U svakom pokusaju:&#10;    # - Pitaj za broj&#10;    # - Povecaj pokusaje za 1&#10;    # - Proveri: veci, manji ili pogodak?&#10;    # - Ako pogodi: ispisi bravo i prekini petlju&#10;&#10;    # Ako nije pogodio posle 5 pokusaja:&#10;    # ispisi koji je broj bio&#10;&#10;    igraj = input('Zelis li ponovo? (da/ne) ')&#10;&#10;print('Hvala sto si igrao!')&#10;",
        'instructions' => 'Napravi kompletnu igricu! Koristi while za pokusaje, if/elif/else za proveru, i break kad pogodi. Ovo je tvoj zavrsni projekat!',
    ],
];

foreach ($homework as $id => $hw) {
    $lesson = Lesson::find($id);
    if (!$lesson) { echo "Lesson $id not found!\n"; continue; }

    // Append homework to end of content
    $homeworkHtml = $hw['html']
        . '<div data-code-exercise="" startercode="' . $hw['code'] . '" instructions="' . $hw['instructions'] . '"></div>';

    // Check if homework already added
    if (strpos($lesson->content, 'Domaći zadatak') !== false) {
        echo "Lesson $id already has homework, skipping.\n";
        continue;
    }

    $lesson->content .= $homeworkHtml;
    $lesson->is_assignment = true;
    $lesson->save();
    echo "Added homework to lesson $id ({$lesson->title})\n";
}

echo "\nDone!\n";
