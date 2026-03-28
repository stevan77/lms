<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Subchapter;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class ScratchKursSeeder extends Seeder
{
    private int $courseId = 16;

    private function scratch(string $projectId, string $caption = ''): string
    {
        $pid = htmlspecialchars($projectId, ENT_QUOTES, 'UTF-8');
        $cap = htmlspecialchars($caption, ENT_QUOTES, 'UTF-8');
        return '<div data-scratch-embed projectid="' . $pid . '" caption="' . $cap . '"></div>';
    }

    // Helper: creates a colored "Scratch block" look in HTML
    private function block(string $category, string $text): string
    {
        $colors = [
            'motion' => '#4C97FF',
            'looks' => '#9966FF',
            'sound' => '#CF63CF',
            'events' => '#FFBF00',
            'control' => '#FFAB19',
            'sensing' => '#5CB1D6',
            'operators' => '#59C059',
            'variables' => '#FF8C1A',
            'myblocks' => '#FF6680',
        ];
        $bg = $colors[$category] ?? '#888';
        return '<span style="display:inline-block;background:' . $bg . ';color:white;padding:4px 12px;border-radius:6px;font-size:14px;font-weight:600;margin:2px 0;font-family:sans-serif;">' . htmlspecialchars($text) . '</span>';
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
        // CHAPTER 1: Uvod u Scratch
        // ============================================================
        $ch = Chapter::create(['course_id' => $this->courseId, 'title' => 'Uvod u Scratch', 'order' => 1]);
        $sub = Subchapter::create(['chapter_id' => $ch->id, 'title' => 'Upoznavanje', 'order' => 1]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 1, 'is_assignment' => false,
            'title' => 'Scratch - softver za vizuelno programiranje',
            'content' => '<h2>Scratch - softver za vizuelno programiranje</h2>'
                . '<p>Scratch je programski jezik napravljen specijalno za decu i pocetnike. Umesto da kucate kod, u Scratchu <strong>prevlacite blokove</strong> koji se spajaju kao Lego kockice!</p>'
                . '<h3>Kako otvoriti Scratch?</h3>'
                . '<p>Scratch radi u browseru (pregledacu). Otvorite adresu <strong>scratch.mit.edu</strong> i kliknite na "Napravi" (Create). Pojavice se Scratch editor sa tri glavna dela:</p>'
                . '<ol>'
                . '<li><strong>Paleta blokova</strong> (levo) - ovde se nalaze svi blokovi grupisani po kategorijama (boji)</li>'
                . '<li><strong>Oblast za skripte</strong> (sredina) - ovde prevlacimo blokove i spajamo ih</li>'
                . '<li><strong>Scena</strong> (desno) - ovde vidimo rezultat - nasa macka (ili drugi lik) izvrsava naredbe</li>'
                . '</ol>'
                . '<h3>Kategorije blokova</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Boja</th><th>Kategorija</th><th>Sta radi</th></tr></thead>'
                . '<tbody>'
                . '<tr><td style="background:#4C97FF;color:white;text-align:center;font-weight:bold;">plava</td><td>Kretanje (Motion)</td><td>Pomera lik, okrece ga, postavlja na poziciju</td></tr>'
                . '<tr><td style="background:#9966FF;color:white;text-align:center;font-weight:bold;">ljubicasta</td><td>Izgled (Looks)</td><td>Menja izgled lika, govori, misli, menja pozadinu</td></tr>'
                . '<tr><td style="background:#CF63CF;color:white;text-align:center;font-weight:bold;">roza</td><td>Zvuk (Sound)</td><td>Pusta zvukove i muziku</td></tr>'
                . '<tr><td style="background:#FFBF00;color:white;text-align:center;font-weight:bold;">zuta</td><td>Dogadjaji (Events)</td><td>Reaguje na klik, taster, poruku</td></tr>'
                . '<tr><td style="background:#FFAB19;color:white;text-align:center;font-weight:bold;">narandzasta</td><td>Upravljanje (Control)</td><td>Petlje, uslovi, pauze</td></tr>'
                . '<tr><td style="background:#5CB1D6;color:white;text-align:center;font-weight:bold;">svetlo plava</td><td>Osecanje (Sensing)</td><td>Dodiruje li nesto, pitaj korisnika, pozicija misa</td></tr>'
                . '<tr><td style="background:#59C059;color:white;text-align:center;font-weight:bold;">zelena</td><td>Operatori (Operators)</td><td>Racunanje, poredjenje, logika</td></tr>'
                . '<tr><td style="background:#FF8C1A;color:white;text-align:center;font-weight:bold;">tamno narandzasta</td><td>Promenljive (Variables)</td><td>Cuva podatke (brojeve, tekst)</td></tr>'
                . '</tbody></table>'
                . '<h3>Tvoj prvi program</h3>'
                . '<p>Hajde da napravimo najjednostavniji program: macka kaze "Zdravo!"</p>'
                . '<ol>'
                . '<li>Iz kategorije ' . $this->block('events', 'kada se klikne na zastavicu') . ' prevuci blok na sredinu</li>'
                . '<li>Iz kategorije ' . $this->block('looks', 'reci Zdravo! 2 sekunde') . ' prevuci ispod</li>'
                . '<li>Klikni na <strong>zelenu zastavicu</strong> iznad scene!</li>'
                . '</ol>'
                . '<p>Pogledaj primer ispod - klikni zelenu zastavicu da ga pokrenes:</p>'
                . $this->scratch('12624412', 'Primer: Macka kaze Zdravo! Klikni zelenu zastavicu.'),
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 2, 'is_assignment' => false,
            'title' => 'Rad sa objektima',
            'content' => '<h2>Rad sa objektima</h2>'
                . '<p>U Scratchu, svaki lik na sceni se zove <strong>sprite</strong> (objekat). Na pocetku imate macku, ali mozete dodati koliko god likova zelite!</p>'
                . '<h3>Likovi (Sprites)</h3>'
                . '<p>Ispod scene postoje dugmad za dodavanje likova:</p>'
                . '<ul>'
                . '<li><strong>Izaberi lik</strong> - birate iz biblioteke gotovih likova (zivotinje, ljudi, predmeti...)</li>'
                . '<li><strong>Nacrtaj lik</strong> - crtate sopstveni lik u editoru za crtanje</li>'
                . '<li><strong>Slucajan lik</strong> - Scratch vam da nasumican lik</li>'
                . '</ul>'
                . '<h3>Osobine lika</h3>'
                . '<p>Svaki lik ima osobine koje mozemo menjati:</p>'
                . '<ul>'
                . '<li><strong>Pozicija (x, y)</strong> - gde se lik nalazi na sceni. Centar scene je (0, 0). X ide od -240 do 240, Y od -180 do 180.</li>'
                . '<li><strong>Pravac</strong> - u kom smeru lik gleda (0° = gore, 90° = desno, 180° = dole, -90° = levo)</li>'
                . '<li><strong>Velicina</strong> - koliko je lik velik (100% = normalno)</li>'
                . '<li><strong>Vidljivost</strong> - da li se lik vidi ili je sakriven</li>'
                . '</ul>'
                . '<h3>Kostimi</h3>'
                . '<p>Svaki lik moze imati vise <strong>kostima</strong> (slika). Menjanjem kostima pravimo animacije! Na primer, macka ima dva kostima - sa podignutom i spustenom sapom.</p>'
                . '<h3>Pozadina</h3>'
                . '<p>Scena takodje moze imati razlicite pozadine. Kliknite na ikonu scene (dole desno) da dodate ili promenite pozadinu.</p>'
                . '<p>Pogledaj primer sa vise likova:</p>'
                . $this->scratch('12367177', 'Primer: Dva lika koja komuniciraju na sceni.'),
        ]);

        // ============================================================
        // CHAPTER 2: Osnovne strukture
        // ============================================================
        $ch = Chapter::create(['course_id' => $this->courseId, 'title' => 'Osnovne strukture', 'order' => 2]);
        $sub = Subchapter::create(['chapter_id' => $ch->id, 'title' => 'Blokovi i linijski programi', 'order' => 1]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 1, 'is_assignment' => false,
            'title' => 'Blok naredbe',
            'content' => '<h2>Blok naredbe</h2>'
                . '<p>U Scratchu, svaka naredba je predstavljena kao <strong>blok</strong>. Blokovi se spajaju jedan ispod drugog i izvrsavaju se redom, od vrha ka dnu.</p>'
                . '<h3>Tipovi blokova</h3>'
                . '<p><strong>1. Blokovi sesira (Hat blocks)</strong> - pokrecu program. Imaju zaobljen vrh.</p>'
                . '<p>' . $this->block('events', 'kada se klikne na zastavicu') . '</p>'
                . '<p>' . $this->block('events', 'kada se pritisne taster razmak') . '</p>'
                . '<p><strong>2. Blokovi naredbi (Stack blocks)</strong> - izvrsavaju akciju. Imaju udubljenje gore i ispupcenje dole pa se spajaju.</p>'
                . '<p>' . $this->block('motion', 'idi 10 koraka') . '</p>'
                . '<p>' . $this->block('looks', 'reci Zdravo!') . '</p>'
                . '<p>' . $this->block('sound', 'sviraj zvuk Meow') . '</p>'
                . '<p><strong>3. Blokovi uslova (C-blocks)</strong> - obuhvataju druge blokove unutar sebe.</p>'
                . '<p>' . $this->block('control', 'ako ... onda') . '</p>'
                . '<p>' . $this->block('control', 'ponovi 10 puta') . '</p>'
                . '<p><strong>4. Blokovi vrednosti (Reporter blocks)</strong> - zaobljeni, daju neku vrednost.</p>'
                . '<p>' . $this->block('sensing', 'pozicija x') . ' ' . $this->block('operators', '1 + 1') . '</p>'
                . '<p><strong>5. Blokovi logike (Boolean blocks)</strong> - sestostruki, daju tacno/netacno.</p>'
                . '<p>' . $this->block('sensing', 'dodiruje li boju?') . ' ' . $this->block('operators', '5 > 3') . '</p>'
                . '<h3>Kako se blokovi spajaju?</h3>'
                . '<p>Prevucite blok iz palete na oblast za skripte. Kada ga priblizite drugom bloku, pojavice se sivi prostor koji pokazuje gde ce se zakaciti. Pustite mis i blokovi se spoje!</p>'
                . '<p>Da biste <strong>razdvojili</strong> blokove, uhvatite donji blok i odvucite ga.</p>',
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 2, 'is_assignment' => false,
            'title' => 'Linijska programska struktura',
            'content' => '<h2>Linijska programska struktura</h2>'
                . '<p>Linijska (sekvencijalna) struktura je najjednostavnija - naredbe se izvrsavaju <strong>jedna za drugom</strong>, redom od vrha ka dnu. Nema preskakanja, nema ponavljanja.</p>'
                . '<h3>Primer: Macka se predstavlja</h3>'
                . '<p>Napravimo program gde macka kaze kako se zove, koliko ima godina, i onda se pomeri:</p>'
                . '<ol>'
                . '<li>' . $this->block('events', 'kada se klikne na zastavicu') . '</li>'
                . '<li>' . $this->block('looks', 'reci Zdravo! Ja sam macka. 2 sekunde') . '</li>'
                . '<li>' . $this->block('looks', 'reci Imam 5 godina. 2 sekunde') . '</li>'
                . '<li>' . $this->block('motion', 'idi 100 koraka') . '</li>'
                . '<li>' . $this->block('looks', 'reci Stigla sam! 2 sekunde') . '</li>'
                . '</ol>'
                . '<p>Ovo je linijski program - svaka naredba se izvrsi tacno jednom, redom.</p>'
                . $this->scratch('741103723', 'Primer linijskog programa - naredbe se izvrsavaju redom, jedna za drugom.')
                . '<h3>Primer: Crtanje kvadrata korak po korak</h3>'
                . '<p>Mozemo nacrtati kvadrat linijskim programom (ali je dugacak!):</p>'
                . '<ol>'
                . '<li>' . $this->block('events', 'kada se klikne na zastavicu') . '</li>'
                . '<li>' . $this->block('motion', 'spusti olovku') . '</li>'
                . '<li>' . $this->block('motion', 'idi 100 koraka') . ' → ' . $this->block('motion', 'okreni se za 90 stepeni') . '</li>'
                . '<li>' . $this->block('motion', 'idi 100 koraka') . ' → ' . $this->block('motion', 'okreni se za 90 stepeni') . '</li>'
                . '<li>' . $this->block('motion', 'idi 100 koraka') . ' → ' . $this->block('motion', 'okreni se za 90 stepeni') . '</li>'
                . '<li>' . $this->block('motion', 'idi 100 koraka') . ' → ' . $this->block('motion', 'okreni se za 90 stepeni') . '</li>'
                . '</ol>'
                . '<p>Vidimo da se dve naredbe ponavljaju 4 puta. U sledecem poglavlju naucicemo kako da to skratimo sa <strong>petljom</strong>!</p>',
        ]);

        // ============================================================
        // CHAPTER 3: Petlje
        // ============================================================
        $ch = Chapter::create(['course_id' => $this->courseId, 'title' => 'Petlje (ciklicne strukture)', 'order' => 3]);
        $sub = Subchapter::create(['chapter_id' => $ch->id, 'title' => 'Ponavljanje naredbi', 'order' => 1]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 1, 'is_assignment' => false,
            'title' => 'Ciklicna programska struktura',
            'content' => '<h2>Ciklicna programska struktura</h2>'
                . '<p>Umesto da ponavljamo iste blokove mnogo puta, koristimo <strong>petlju</strong> (ciklus). Scratch ima tri vrste petlji:</p>'
                . '<h3>1. Ponovi ___ puta</h3>'
                . '<p>' . $this->block('control', 'ponovi 10 puta') . '</p>'
                . '<p>Izvrsava blokove unutar sebe tacno odredjeni broj puta. Savrseno kada znamo koliko puta treba ponoviti.</p>'
                . '<p><strong>Primer: Kvadrat</strong> - umesto 8 blokova, koristimo samo 2 unutar petlje:</p>'
                . '<ol>'
                . '<li>' . $this->block('events', 'kada se klikne na zastavicu') . '</li>'
                . '<li>' . $this->block('control', 'ponovi 4 puta') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('motion', 'idi 100 koraka') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('motion', 'okreni se za 90 stepeni') . '</li>'
                . '</ol>'
                . $this->scratch('195553830', 'Crtanje kvadrata sa petljom pomocu olovke - samo 4 bloka umesto 10!')
                . '<h3>2. Ponavljaj zauvek</h3>'
                . '<p>' . $this->block('control', 'ponavljaj zauvek') . '</p>'
                . '<p>Izvrsava blokove beskonacno - nikada se ne zaustavlja (osim ako kliknemo crveni znak stop). Koristi se za animacije i igre.</p>'
                . '<p><strong>Primer:</strong> Macka se neprestano krece po sceni:</p>'
                . '<ol>'
                . '<li>' . $this->block('events', 'kada se klikne na zastavicu') . '</li>'
                . '<li>' . $this->block('control', 'ponavljaj zauvek') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('motion', 'idi 10 koraka') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('motion', 'ako si na ivici, okreni se') . '</li>'
                . '</ol>'
                . '<h3>3. Ponavljaj dok nije ...</h3>'
                . '<p>' . $this->block('control', 'ponavljaj dok nije ...') . '</p>'
                . '<p>Ponavlja blokove dok uslov ne postane tacan. Na primer: "ponavljaj dok macka ne dodirne ivicu".</p>',
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 2, 'is_assignment' => false,
            'title' => 'Linijska i ciklicna programska struktura',
            'content' => '<h2>Linijska i ciklicna programska struktura</h2>'
                . '<p>U praksi, programi kombinuju linijske i ciklicne delove. Neki blokovi se izvrsavaju jednom (na pocetku), a neki se ponavljaju.</p>'
                . '<h3>Primer: Crtanje razlicitih oblika</h3>'
                . '<p>Sa petljom mozemo nacrtati bilo koji pravilan oblik! Tajni trik: ugao okretanja = 360 / broj stranica.</p>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Oblik</th><th>Broj stranica</th><th>Ugao</th></tr></thead>'
                . '<tbody>'
                . '<tr><td>Trougao</td><td>3</td><td>360 / 3 = 120</td></tr>'
                . '<tr><td>Kvadrat</td><td>4</td><td>360 / 4 = 90</td></tr>'
                . '<tr><td>Petougao</td><td>5</td><td>360 / 5 = 72</td></tr>'
                . '<tr><td>Sestougao</td><td>6</td><td>360 / 6 = 60</td></tr>'
                . '<tr><td>Krug (priblizno)</td><td>36</td><td>360 / 36 = 10</td></tr>'
                . '</tbody></table>'
                . $this->scratch('24226', 'Crtanje razlicitih oblika (trougao, kvadrat, petougao, krug) pomocu petlje.')
                . '<h3>Ugnjezdene petlje</h3>'
                . '<p>Mozemo staviti petlju unutar petlje! Na primer, da nacrtamo 6 kvadrata u krug:</p>'
                . '<ol>'
                . '<li>' . $this->block('events', 'kada se klikne na zastavicu') . '</li>'
                . '<li>' . $this->block('control', 'ponovi 6 puta') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('control', 'ponovi 4 puta') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('motion', 'idi 80 koraka') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('motion', 'okreni se za 90 stepeni') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('motion', 'okreni se za 60 stepeni') . '</li>'
                . '</ol>'
                . '<p>Spoljna petlja (6 puta) crta 6 kvadrata, a unutrasnja (4 puta) crta jedan kvadrat. Posle svakog kvadrata okrecemo se za 60 stepeni (360/6).</p>'
                . $this->scratch('96893466', 'Primer ugnjezdenih petlji - crtanje slozenijih obrazaca.'),
        ]);

        // ============================================================
        // CHAPTER 4: Grananje i promenljive
        // ============================================================
        $ch = Chapter::create(['course_id' => $this->courseId, 'title' => 'Grananje i promenljive', 'order' => 4]);
        $sub = Subchapter::create(['chapter_id' => $ch->id, 'title' => 'Odluke i podaci', 'order' => 1]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 1, 'is_assignment' => false,
            'title' => 'Razgranata programska struktura',
            'content' => '<h2>Razgranata programska struktura</h2>'
                . '<p>Ponekad zelimo da program radi razlicite stvari u zavisnosti od uslova. Na primer: "Ako macka dodirne ivicu, okreni se." Za to koristimo <strong>grananje</strong>.</p>'
                . '<h3>Blok: ako ... onda</h3>'
                . '<p>' . $this->block('control', 'ako ... onda') . '</p>'
                . '<p>Izvrsava blokove unutar sebe <strong>samo ako</strong> je uslov tacan. Ako nije, preskace ih.</p>'
                . '<h3>Blok: ako ... onda ... inace</h3>'
                . '<p>' . $this->block('control', 'ako ... onda ... inace') . '</p>'
                . '<p>Ako je uslov tacan, izvrsava prvi deo. Ako nije, izvrsava drugi deo (inace). Uvek se izvrsava tacno jedan od dva dela.</p>'
                . '<h3>Uslovi</h3>'
                . '<p>U "rombic" (sestougaono polje) stavljamo uslov. Najcesci su:</p>'
                . '<ul>'
                . '<li>' . $this->block('sensing', 'dodiruje li ivicu?') . '</li>'
                . '<li>' . $this->block('sensing', 'dodiruje li boju?') . '</li>'
                . '<li>' . $this->block('sensing', 'dodiruje li lik?') . '</li>'
                . '<li>' . $this->block('operators', '_ > _') . ' ' . $this->block('operators', '_ < _') . ' ' . $this->block('operators', '_ = _') . '</li>'
                . '<li>' . $this->block('sensing', 'pritisnut taster razmak?') . '</li>'
                . '</ul>'
                . $this->scratch('130483171', 'Primer grananja: ako je uslov tacan, izvrsava se jedan deo, inace drugi.'),
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 2, 'is_assignment' => false,
            'title' => 'Matematicke formule i promenljive u programu',
            'content' => '<h2>Matematicke formule i promenljive u programu</h2>'
                . '<p>Promenljive su kao kutije sa imenom u kojima cuvamo podatke (brojeve ili tekst). U Scratchu ih pravimo u kategoriji ' . $this->block('variables', 'Promenljive') . '.</p>'
                . '<h3>Pravljenje promenljive</h3>'
                . '<ol>'
                . '<li>Klikni na kategoriju <strong>Promenljive</strong> (tamno narandzasta)</li>'
                . '<li>Klikni na dugme <strong>"Napravi promenljivu"</strong></li>'
                . '<li>Upisi ime (npr. "poeni" ili "brzina")</li>'
                . '<li>Pojavljuju se novi blokovi za tu promenljivu</li>'
                . '</ol>'
                . '<h3>Blokovi za promenljive</h3>'
                . '<p>' . $this->block('variables', 'postavi poeni na 0') . ' - zadaje vrednost</p>'
                . '<p>' . $this->block('variables', 'promeni poeni za 1') . ' - povecava ili smanjuje</p>'
                . '<p>' . $this->block('variables', 'poeni') . ' - citamo trenutnu vrednost (zaobljeni blok)</p>'
                . '<h3>Matematicki operatori</h3>'
                . '<p>Scratch ima blokove za racunanje:</p>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Blok</th><th>Operacija</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td>' . $this->block('operators', '_ + _') . '</td><td>Sabiranje</td><td>5 + 3 = 8</td></tr>'
                . '<tr><td>' . $this->block('operators', '_ - _') . '</td><td>Oduzimanje</td><td>10 - 4 = 6</td></tr>'
                . '<tr><td>' . $this->block('operators', '_ * _') . '</td><td>Mnozenje</td><td>6 * 7 = 42</td></tr>'
                . '<tr><td>' . $this->block('operators', '_ / _') . '</td><td>Deljenje</td><td>20 / 4 = 5</td></tr>'
                . '<tr><td>' . $this->block('operators', 'ostatak _ / _') . '</td><td>Ostatak</td><td>17 mod 5 = 2</td></tr>'
                . '<tr><td>' . $this->block('operators', 'slucajan broj od _ do _') . '</td><td>Slucajan broj</td><td>1 do 10</td></tr>'
                . '</tbody></table>'
                . '<p>Primer: Pomeraj macku za slucajan broj koraka:</p>'
                . '<p>' . $this->block('motion', 'idi (slucajan broj od 10 do 50) koraka') . '</p>'
                . $this->scratch('27291226', 'Primer: Kviz sa promenljivom za poene.'),
        ]);

        // ============================================================
        // CHAPTER 5: Kombinovanje struktura
        // ============================================================
        $ch = Chapter::create(['course_id' => $this->courseId, 'title' => 'Kombinovanje struktura', 'order' => 5]);
        $sub = Subchapter::create(['chapter_id' => $ch->id, 'title' => 'Slozeniji programi', 'order' => 1]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 1, 'is_assignment' => false,
            'title' => 'Ciklicne i razgranate programske strukture',
            'content' => '<h2>Ciklicne i razgranate programske strukture</h2>'
                . '<p>Prava moc programiranja dolazi kada kombinujemo petlje i grananje! Na primer: "Ponavljaj zauvek: ako dodiruje misa, reci Uhvacen!"</p>'
                . '<h3>Primer: Igra hvatanja</h3>'
                . '<p>Macka se krece po sceni i proverava da li dodiruje mis:</p>'
                . '<ol>'
                . '<li>' . $this->block('events', 'kada se klikne na zastavicu') . '</li>'
                . '<li>' . $this->block('control', 'ponavljaj zauvek') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('motion', 'idi 5 koraka') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('motion', 'ako si na ivici, okreni se') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('control', 'ako dodiruje pokazivac misa? onda') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('looks', 'reci Uhvacen! 1 sekunde') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('variables', 'promeni poeni za 1') . '</li>'
                . '</ol>'
                . $this->scratch('24532954', 'Igra jurenja - kombinacija petlje, grananja i promenljivih za poene.')
                . '<h3>Primer: Reagovanje na tastere</h3>'
                . '<p>Kombinacijom petlje i vise grananja pravimo kontrolu pomocu tastera:</p>'
                . '<ol>'
                . '<li>' . $this->block('events', 'kada se klikne na zastavicu') . '</li>'
                . '<li>' . $this->block('control', 'ponavljaj zauvek') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('control', 'ako pritisnut taster strelica gore? onda') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('motion', 'promeni y za 10') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('control', 'ako pritisnut taster strelica dole? onda') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('motion', 'promeni y za -10') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('control', 'ako pritisnut taster strelica levo? onda') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('motion', 'promeni x za -10') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('control', 'ako pritisnut taster strelica desno? onda') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('motion', 'promeni x za 10') . '</li>'
                . '</ol>',
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 2, 'is_assignment' => false,
            'title' => 'Razgranata programska struktura, matematicke formule i promenljive u programu',
            'content' => '<h2>Grananje, formule i promenljive - vezba</h2>'
                . '<p>Hajde da kombinujemo sve nauceno u jednom slozenijeem programu!</p>'
                . '<h3>Primer: Kviz sa bodovanjem</h3>'
                . '<p>Napravicemo kviz gde macka postavlja pitanja, a korisnik odgovara. Za svaki tacan odgovor dobija poen.</p>'
                . '<ol>'
                . '<li>' . $this->block('events', 'kada se klikne na zastavicu') . '</li>'
                . '<li>' . $this->block('variables', 'postavi poeni na 0') . '</li>'
                . '<li>' . $this->block('sensing', 'pitaj Koliko je 5 + 3? i cekaj') . '</li>'
                . '<li>' . $this->block('control', 'ako (odgovor) = 8 onda') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('looks', 'reci Tacno! 2 sekunde') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('variables', 'promeni poeni za 1') . '<br>'
                . $this->block('control', 'inace') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('looks', 'reci Netacno! Odgovor je 8. 2 sekunde') . '</li>'
                . '<li><em>(ponovi za svako pitanje)</em></li>'
                . '<li>' . $this->block('looks', 'reci (spoji Imas poeni poena!)') . '</li>'
                . '</ol>'
                . '<h3>Korisni blokovi</h3>'
                . '<p>' . $this->block('sensing', 'pitaj ... i cekaj') . ' - pita korisnika i ceka odgovor</p>'
                . '<p>' . $this->block('sensing', 'odgovor') . ' - cuva ono sto je korisnik ukucao</p>'
                . '<p>' . $this->block('operators', 'spoji zdravo svet') . ' - spaja dva teksta u jedan</p>'
                . $this->scratch('27291611', 'Kviz sa pitanjima, bodovanjem i porukom na kraju.'),
        ]);

        // ============================================================
        // CHAPTER 6: Napredni koncepti
        // ============================================================
        $ch = Chapter::create(['course_id' => $this->courseId, 'title' => 'Napredni koncepti', 'order' => 6]);
        $sub = Subchapter::create(['chapter_id' => $ch->id, 'title' => 'Logika i algoritmi', 'order' => 1]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 1, 'is_assignment' => false,
            'title' => 'Matematicko-logicke operacije nad skupovima',
            'content' => '<h2>Matematicko-logicke operacije nad skupovima</h2>'
                . '<p>U Scratchu mozemo kombinovati vise uslova pomocu <strong>logickih operatora</strong>:</p>'
                . '<h3>Logicki operatori</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Operator</th><th>Scratch blok</th><th>Znacenje</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td>I (AND)</td><td>' . $this->block('operators', '_ i _') . '</td><td>Oba uslova moraju biti tacna</td><td>x &gt; 0 i x &lt; 10</td></tr>'
                . '<tr><td>ILI (OR)</td><td>' . $this->block('operators', '_ ili _') . '</td><td>Bar jedan mora biti tacan</td><td>taster a ili taster d</td></tr>'
                . '<tr><td>NE (NOT)</td><td>' . $this->block('operators', 'ne _') . '</td><td>Obrce uslov</td><td>ne (dodiruje ivicu)</td></tr>'
                . '</tbody></table>'
                . '<h3>Primer: Kretanje u okviru</h3>'
                . '<p>Macka se krece samo ako je unutar vidljivog dela scene:</p>'
                . '<p>' . $this->block('control', 'ako (x > -200) i (x < 200) onda') . '</p>'
                . '<p>&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('motion', 'idi 10 koraka') . '</p>'
                . '<h3>Skupovi u Scratchu</h3>'
                . '<p>Scratch ima <strong>liste</strong> koje su slicne skupovima. Lista moze cuvati vise podataka:</p>'
                . '<p>' . $this->block('variables', 'dodaj jabuka u voce') . '</p>'
                . '<p>' . $this->block('variables', 'element 1 od voce') . '</p>'
                . '<p>' . $this->block('variables', 'duzina liste voce') . '</p>'
                . '<p>Mozemo proveriti da li lista sadrzi element:</p>'
                . '<p>' . $this->block('variables', 'voce sadrzi jabuka?') . '</p>'
                . '<p>Kombinacijom listi i logickih operatora mozemo simulirati operacije nad skupovima (presek, unija).</p>'
                . $this->scratch('72747060', 'Primer koriscenja listi u Scratchu - dodavanje, brisanje i pretraga elemenata.'),
        ]);

        Lesson::create([
            'course_id' => $this->courseId, 'subchapter_id' => $sub->id, 'order' => 2, 'is_assignment' => false,
            'title' => 'Euklidov algoritam',
            'content' => '<h2>Euklidov algoritam</h2>'
                . '<p>Euklidov algoritam je jedan od najstarijih algoritama na svetu (star preko 2000 godina!). Sluzi za nalazenje <strong>najveceg zajednickog delioca (NZD)</strong> dva broja.</p>'
                . '<h3>Sta je NZD?</h3>'
                . '<p>Najveci zajednicki delilac je najveci broj kojim se oba broja mogu podeliti bez ostatka.</p>'
                . '<ul>'
                . '<li>NZD(12, 8) = 4 (jer je 4 najveci broj koji deli i 12 i 8)</li>'
                . '<li>NZD(15, 10) = 5</li>'
                . '<li>NZD(7, 3) = 1 (nemaju zajednickog delioca osim 1)</li>'
                . '</ul>'
                . '<h3>Kako radi algoritam?</h3>'
                . '<p>Koristimo ponavljanje sa ostatkom deljenja:</p>'
                . '<ol>'
                . '<li>Uzmi dva broja: <strong>a</strong> i <strong>b</strong></li>'
                . '<li>Izracunaj ostatak: <strong>r = a mod b</strong> (ostatak pri deljenju a sa b)</li>'
                . '<li>Zameni: <strong>a = b</strong>, <strong>b = r</strong></li>'
                . '<li>Ponavljaj dok b ne bude 0</li>'
                . '<li>Kada je b = 0, odgovor je <strong>a</strong></li>'
                . '</ol>'
                . '<h3>Primer: NZD(48, 18)</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Korak</th><th>a</th><th>b</th><th>a mod b</th></tr></thead>'
                . '<tbody>'
                . '<tr><td>1</td><td>48</td><td>18</td><td>48 mod 18 = 12</td></tr>'
                . '<tr><td>2</td><td>18</td><td>12</td><td>18 mod 12 = 6</td></tr>'
                . '<tr><td>3</td><td>12</td><td>6</td><td>12 mod 6 = 0</td></tr>'
                . '<tr><td>4</td><td>6</td><td>0</td><td>KRAJ! NZD = 6</td></tr>'
                . '</tbody></table>'
                . '<h3>U Scratchu</h3>'
                . '<p>Za implementaciju u Scratchu koristimo promenljive i petlju:</p>'
                . '<ol>'
                . '<li>' . $this->block('events', 'kada se klikne na zastavicu') . '</li>'
                . '<li>' . $this->block('sensing', 'pitaj Unesi prvi broj: i cekaj') . '</li>'
                . '<li>' . $this->block('variables', 'postavi a na (odgovor)') . '</li>'
                . '<li>' . $this->block('sensing', 'pitaj Unesi drugi broj: i cekaj') . '</li>'
                . '<li>' . $this->block('variables', 'postavi b na (odgovor)') . '</li>'
                . '<li>' . $this->block('control', 'ponavljaj dok nije (b = 0)') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('variables', 'postavi r na (ostatak a / b)') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('variables', 'postavi a na b') . '<br>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->block('variables', 'postavi b na r') . '</li>'
                . '<li>' . $this->block('looks', 'reci (spoji NZD je: a)') . '</li>'
                . '</ol>'
                . '<p>Ovaj program koristi <strong>sve sto smo naucili</strong>: promenljive, petlju (ponavljaj dok nije), grananje (uslov b = 0), i matematicki operator (ostatak).</p>'
                . $this->scratch('635196', 'Euklidov algoritam u Scratchu - racuna NZD i NZS dva broja.'),
        ]);

        echo "Scratch kurs kreiran! 6 poglavlja, 10 lekcija.\n";
    }
}
