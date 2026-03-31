<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Subchapter;
use Illuminate\Database\Seeder;

class Probni2025Seeder extends Seeder
{
    private function m($latex)
    {
        return '<div data-math-block latex="' . htmlspecialchars($latex, ENT_QUOTES) . '"></div>';
    }

    private function createLesson($course, $sub, $order, $title, $content)
    {
        Lesson::create([
            'course_id' => $course->id,
            'subchapter_id' => $sub->id,
            'title' => $title,
            'order' => $order,
            'is_assignment' => false,
            'content' => $content,
        ]);
    }

    public function run(): void
    {
        $course = Course::findOrFail(19);
        $chapter = Chapter::findOrFail(152);

        $sub = Subchapter::create([
            'chapter_id' => $chapter->id,
            'title' => 'Probni',
            'order' => 2,
        ]);

        $this->createLesson($course, $sub, 1, 'Zadatak 1', $this->task1());
        $this->createLesson($course, $sub, 2, 'Zadatak 2', $this->task2());
        $this->createLesson($course, $sub, 3, 'Zadatak 3', $this->task3());
        $this->createLesson($course, $sub, 4, 'Zadatak 4', $this->task4());
        $this->createLesson($course, $sub, 5, 'Zadatak 5', $this->task5());
        $this->createLesson($course, $sub, 6, 'Zadatak 6', $this->task6());
        $this->createLesson($course, $sub, 7, 'Zadatak 7', $this->task7());
        $this->createLesson($course, $sub, 8, 'Zadatak 8', $this->task8());
        $this->createLesson($course, $sub, 9, 'Zadatak 9', $this->task9());
        $this->createLesson($course, $sub, 10, 'Zadatak 10', $this->task10());
        $this->createLesson($course, $sub, 11, 'Zadatak 11', $this->task11());
        $this->createLesson($course, $sub, 12, 'Zadatak 12', $this->task12());
        $this->createLesson($course, $sub, 13, 'Zadatak 13', $this->task13());
        $this->createLesson($course, $sub, 14, 'Zadatak 14', $this->task14());
        $this->createLesson($course, $sub, 15, 'Zadatak 15', $this->task15());
        $this->createLesson($course, $sub, 16, 'Zadatak 16', $this->task16());
        $this->createLesson($course, $sub, 17, 'Zadatak 17', $this->task17());
        $this->createLesson($course, $sub, 18, 'Zadatak 18', $this->task18());
        $this->createLesson($course, $sub, 19, 'Zadatak 19', $this->task19());
        $this->createLesson($course, $sub, 20, 'Zadatak 20', $this->task20());
    }

    private function task1(): string
    {
        return '<h3>Zadatak 1</h3>'
            . '<p>Zastava Srbije ima duzinu \(A = 210\) cm. Kolika je visina grba na zastavi?</p>'
            . '<p>[slika - zastava Srbije sa oznacenom duzinom A i grbom]</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Zastava Srbije ima odnos stranica 2:1, sto znaci da je visina zastave jednaka polovini duzine:</p>'
            . $this->m('\\text{Visina zastave} = \\frac{A}{2} = \\frac{210}{2} = 105 \\text{ cm}')
            . '<p>Iz slike vidimo da visina grba zauzima polovinu visine zastave, sto je upravo:</p>'
            . $this->m('\\text{Visina grba} = \\frac{1}{2} \\cdot A = \\frac{1}{2} \\cdot 210 = 105 \\text{ cm}')
            . '<p><strong>Odgovor:</strong> Visina grba je \(105\) cm.</p>';
    }

    private function task2(): string
    {
        return '<h3>Zadatak 2</h3>'
            . '<p>Vaska je putovala od Nisa do Beograda i prosla kroz vise gradova. Rastojanja izmedju gradova su: 72 km, 41 km, 24 km, 54 km, 52 km i 75 km. Na povratku je isla direktno od Beograda do Nisa, sto je 242 km. Koliko je kilometara vise presla na putu od Nisa do Beograda?</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Najpre izracunajmo koliko je Vaska presla na putu Nis - Beograd (preko vise gradova):</p>'
            . $this->m('72 + 41 + 24 + 54 + 52 + 75 = 318 \\text{ km}')
            . '<p>Na povratku je isla direktno i presla 242 km.</p>'
            . '<p>Razlika je:</p>'
            . $this->m('318 - 242 = 76 \\text{ km}')
            . '<p><strong>Odgovor:</strong> Vaska je na putu od Nisa do Beograda presla \(76\) km vise.</p>';
    }

    private function task3(): string
    {
        return '<h3>Zadatak 3</h3>'
            . '<p>U video igri, broj poena na nivou \(N\) racuna se po formuli \(3N^3 - 4N^2 + 7\). Koliko poena ima igrac na nivou \(N = 3\)?</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Zamenimo \(N = 3\) u formulu:</p>'
            . $this->m('3N^3 - 4N^2 + 7')
            . '<p>Prvo izracunamo stepene:</p>'
            . $this->m('3^3 = 27 \\quad \\text{i} \\quad 3^2 = 9')
            . '<p>Sada zamenimo:</p>'
            . $this->m('3 \\cdot 27 - 4 \\cdot 9 + 7')
            . '<p>Izracunamo svaki clan:</p>'
            . $this->m('81 - 36 + 7 = 52')
            . '<p><strong>Odgovor:</strong> Igrac na nivou 3 ima \(52\) poena.</p>';
    }

    private function task4(): string
    {
        return '<h3>Zadatak 4</h3>'
            . '<p>Koji su od sledecih izraza jednaki \(3x^2\) za svaku vrednost \(x\)?</p>'
            . '<ul>'
            . '<li>\(4x^4 - x^2\)</li>'
            . '<li>\(5x^2 - 2x^2\)</li>'
            . '<li>\(x^2 \cdot 3x^2\)</li>'
            . '<li>\(3x + x\)</li>'
            . '<li>\(3x \cdot x\)</li>'
            . '</ul>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Proverimo svaki izraz:</p>'
            . '<p><strong>1) \(4x^4 - x^2\)</strong></p>'
            . '<p>Ovo ne mozemo da uprostimo na \(3x^2\) jer imamo \(x^4\) i \(x^2\) - to su razliciti stepeni. NETACNO.</p>'
            . '<p><strong>2) \(5x^2 - 2x^2\)</strong></p>'
            . '<p>Oduzimamo koeficijente jer su isti stepeni:</p>'
            . $this->m('5x^2 - 2x^2 = (5 - 2) \\cdot x^2 = 3x^2 \\quad \\checkmark')
            . '<p>TACNO!</p>'
            . '<p><strong>3) \(x^2 \cdot 3x^2\)</strong></p>'
            . '<p>Kad mnozimo stepene, sabiramo eksponente:</p>'
            . $this->m('x^2 \\cdot 3x^2 = 3x^{2+2} = 3x^4')
            . '<p>Ovo je \(3x^4\), ne \(3x^2\). NETACNO.</p>'
            . '<p><strong>4) \(3x + x\)</strong></p>'
            . $this->m('3x + x = 4x')
            . '<p>Ovo je \(4x\), ne \(3x^2\). NETACNO.</p>'
            . '<p><strong>5) \(3x \cdot x\)</strong></p>'
            . '<p>Kad mnozimo \(x\) sa \(x\), dobijamo \(x^2\):</p>'
            . $this->m('3x \\cdot x = 3 \\cdot x \\cdot x = 3x^2 \\quad \\checkmark')
            . '<p>TACNO!</p>'
            . '<p><strong>Odgovor:</strong> Izrazi \(5x^2 - 2x^2\) i \(3x \cdot x\) su jednaki \(3x^2\).</p>';
    }

    private function task5(): string
    {
        return '<h3>Zadatak 5</h3>'
            . '<p>Kontejner ima oblik kvadra sa dimenzijama 4 dm, 2 dm i 1,5 dm. Koliko litara vode staje u kontejner?</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Zapremina kvadra se racuna po formuli:</p>'
            . $this->m('V = a \\cdot b \\cdot c')
            . '<p>Zamenimo dimenzije:</p>'
            . $this->m('V = 4 \\cdot 2 \\cdot 1{,}5 = 12 \\text{ dm}^3')
            . '<p>Zapamti: <strong>1 dm\(^3\) = 1 litar</strong>. To je vazna veza!</p>'
            . $this->m('V = 12 \\text{ dm}^3 = 12 \\text{ l}')
            . '<p><strong>Odgovor:</strong> U kontejner staje \(12\) litara vode.</p>';
    }

    private function task6(): string
    {
        return '<h3>Zadatak 6</h3>'
            . '<p>Na slici je tangram (slozena figura od 7 delova). Koji delovi su podudarni?</p>'
            . '<p>[slika - tangram sa numerisanim delovima od 1 do 7]</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p><strong>Podudarni</strong> znaci potpuno isti - istog oblika i iste velicine. Mozemo da ih preklopimo jedan preko drugog.</p>'
            . '<p>Pogledajmo tangram:</p>'
            . '<ul>'
            . '<li>Delovi <strong>1 i 3</strong> su dva velika trougla - imaju isti oblik i istu velicinu. Oni su <strong>podudarni</strong>.</li>'
            . '<li>Delovi <strong>2 i 5</strong> su dva mala trougla - takodje istog oblika i iste velicine. Oni su <strong>podudarni</strong>.</li>'
            . '</ul>'
            . '<p>Ostali delovi (4, 6 i 7) nemaju par - svaki je jedinstven po velicini.</p>'
            . '<p><strong>Odgovor:</strong> Podudarni su delovi 1 i 3, kao i delovi 2 i 5.</p>';
    }

    private function task7(): string
    {
        return '<h3>Zadatak 7</h3>'
            . '<p>Nina je presla 6000 koraka, sto je ukupno 3,6 km. Kolika je prosecna duzina jednog koraka?</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Najpre pretvorimo kilometre u metre:</p>'
            . $this->m('3{,}6 \\text{ km} = 3600 \\text{ m}')
            . '<p>Sada podelimo ukupno rastojanje sa brojem koraka da dobijemo duzinu jednog koraka:</p>'
            . $this->m('\\text{Duzina koraka} = \\frac{3600}{6000} = 0{,}6 \\text{ m}')
            . '<p>Pretvorimo u centimetre:</p>'
            . $this->m('0{,}6 \\text{ m} = 60 \\text{ cm}')
            . '<p><strong>Odgovor:</strong> Prosecna duzina jednog Nininog koraka je \(60\) cm.</p>';
    }

    private function task8(): string
    {
        return '<h3>Zadatak 8</h3>'
            . '<p>Bioskop ima 12 redova sa po 17 sedista. Ema, Una, Lav i Vuk zele da sednu u istom redu, jedno do drugog (4 uzastopna sedista). Siva polja na slici oznacavaju zauzeta mesta. U kom redu i na kojim mestima mogu da sednu?</p>'
            . '<p>[slika - raspored sedista u bioskopu sa sivim (zauzetim) i belim (slobodnim) poljima]</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Trazimo 4 slobodna mesta <strong>jedno do drugog</strong> u istom redu.</p>'
            . '<p>Gledamo red po red i trazimo 4 uzastopna bela (slobodna) polja. Iz slike vidimo da u <strong>IX redu</strong> postoje 4 slobodna uzastopna sedista.</p>'
            . '<p>To su mesta: <strong>10, 11, 12 i 13</strong> u IX redu.</p>'
            . '<p><strong>Odgovor:</strong> Mogu da sednu u IX redu, na mestima 10, 11, 12 i 13.</p>';
    }

    private function task9(): string
    {
        return '<h3>Zadatak 9</h3>'
            . '<p>Na grafiku su prikazani rezultati vaterpolo utakmice Srbija - Hrvatska po cetvrtinama. Rezultat na kraju svake cetvrtine je prikazan u tabeli. Koliko je \(x\)?</p>'
            . '<p>[slika - grafikon sa golovima po cetvrtinama i tabela sa kumulativnim rezultatima]</p>'
            . '<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; margin: 10px 0;">'
            . '<tr><th></th><th>I</th><th>II</th><th>III</th><th>IV</th></tr>'
            . '<tr><td>Srbija</td><td>5</td><td>8</td><td>11</td><td>\(x\)</td></tr>'
            . '<tr><td>Hrvatska</td><td>2</td><td>5</td><td>8</td><td>11</td></tr>'
            . '</table>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>U tabeli su prikazani <strong>kumulativni rezultati</strong> - ukupan broj golova do kraja svake cetvrtine.</p>'
            . '<p>Vidimo da je Srbija na kraju III cetvrtine imala 11 golova.</p>'
            . '<p>Iz grafika vidimo da je Srbija u IV cetvrtini postigla <strong>2 gola</strong>.</p>'
            . '<p>Zato je ukupan broj golova Srbije na kraju utakmice:</p>'
            . $this->m('x = 11 + 2 = 13')
            . '<p><strong>Odgovor:</strong> \(x = 13\).</p>';
    }

    private function task10(): string
    {
        return '<h3>Zadatak 10</h3>'
            . '<p>Odredi vrednosti \(A\) i \(B\) ako je: \(A\) najmanji ceo broj veci od \(-\\frac{7}{5}\), a \(B\) najveci ceo broj manji od \(|-2{,}5|\).</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p><strong>Trazimo A:</strong></p>'
            . '<p>Najpre izracunamo \(-\\frac{7}{5}\):</p>'
            . $this->m('-\\frac{7}{5} = -1{,}4')
            . '<p>Najmanji ceo broj <strong>veci</strong> od \(-1{,}4\) je \(-1\), jer:</p>'
            . '<ul>'
            . '<li>\(-2\) je manji od \(-1{,}4\) (ne odgovara)</li>'
            . '<li>\(-1\) je veci od \(-1{,}4\) (odgovara!)</li>'
            . '</ul>'
            . $this->m('A = -1')
            . '<p><strong>Trazimo B:</strong></p>'
            . '<p>Najpre izracunamo apsolutnu vrednost:</p>'
            . $this->m('|-2{,}5| = 2{,}5')
            . '<p>Najveci ceo broj <strong>manji</strong> od \(2{,}5\) je \(2\), jer:</p>'
            . '<ul>'
            . '<li>\(2\) je manji od \(2{,}5\) (odgovara!)</li>'
            . '<li>\(3\) je veci od \(2{,}5\) (ne odgovara)</li>'
            . '</ul>'
            . $this->m('B = 2')
            . '<p><strong>Odgovor:</strong> \(A = -1\) i \(B = 2\).</p>';
    }

    private function task11(): string
    {
        return '<h3>Zadatak 11</h3>'
            . '<p>Jelena svake nedelje putuje autobusom i treba joj povratna karta koja kosta 650 dinara. U godini ima 52 vikenda. Na stanici pise promocija: za svake 3 kupljene karte, 4. je besplatna. Koliko ce Jelena ustadeti za godinu dana koristeci ovu promociju?</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Jeleni treba <strong>52 karte</strong> godisnje (jedna za svaki vikend).</p>'
            . '<p>Sa promocijom: za svake 3 kupljene karte, 4. je besplatna. To znaci da na svake <strong>4 karte</strong> placa samo 3.</p>'
            . '<p>Koliko ciklusa od po 4 karte ima u 52 karte?</p>'
            . $this->m('52 : 4 = 13 \\text{ ciklusa}')
            . '<p>U svakom ciklusu placa 3 karte, pa ukupno placa:</p>'
            . $this->m('13 \\cdot 3 = 39 \\text{ karata}')
            . '<p>Bez promocije bi platila 52 karte. Sa promocijom placa samo 39. Ustedela je:</p>'
            . $this->m('52 - 39 = 13 \\text{ karata}')
            . '<p>U dinarima:</p>'
            . $this->m('13 \\cdot 650 = 8450 \\text{ dinara}')
            . '<p><strong>Odgovor:</strong> Jelena ce ustadeti \(8450\) dinara.</p>';
    }

    private function task12(): string
    {
        return '<h3>Zadatak 12</h3>'
            . '<p>Izracunaj:</p>'
            . $this->m('(5x + 4y)^2 - (3x - 3y)^2')
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Koristimo formulu za kvadrat binoma:</p>'
            . $this->m('(a + b)^2 = a^2 + 2ab + b^2')
            . $this->m('(a - b)^2 = a^2 - 2ab + b^2')
            . '<p><strong>Prvi deo:</strong> \((5x + 4y)^2\)</p>'
            . $this->m('(5x + 4y)^2 = (5x)^2 + 2 \\cdot 5x \\cdot 4y + (4y)^2')
            . $this->m('= 25x^2 + 40xy + 16y^2')
            . '<p><strong>Drugi deo:</strong> \((3x - 3y)^2\)</p>'
            . $this->m('(3x - 3y)^2 = (3x)^2 - 2 \\cdot 3x \\cdot 3y + (3y)^2')
            . $this->m('= 9x^2 - 18xy + 9y^2')
            . '<p>Sada oduzimamo (pazimo na znak minus ispred zagrade!):</p>'
            . $this->m('(25x^2 + 40xy + 16y^2) - (9x^2 - 18xy + 9y^2)')
            . $this->m('= 25x^2 + 40xy + 16y^2 - 9x^2 + 18xy - 9y^2')
            . '<p>Grupemo slicne clanove:</p>'
            . $this->m('= (25 - 9)x^2 + (40 + 18)xy + (16 - 9)y^2')
            . $this->m('= 16x^2 + 58xy + 7y^2')
            . '<p><strong>Odgovor:</strong> \((5x + 4y)^2 - (3x - 3y)^2 = 16x^2 + 58xy + 7y^2\)</p>';
    }

    private function task13(): string
    {
        return '<h3>Zadatak 13</h3>'
            . '<p>U pravouglom trouglu jedan ugao je \(65°\). Odredi uglove \(\\alpha\), \(\\beta\) i \(\\gamma\).</p>'
            . '<p>[slika - pravougli trougao sa uglom od 65 stepeni]</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>U <strong>pravouglom</strong> trouglu jedan ugao je uvek \(90°\). To je ugao \(\\beta\):</p>'
            . $this->m('\\beta = 90°')
            . '<p>Znamo da je zbir svih uglova u trouglu \(180°\):</p>'
            . $this->m('\\alpha + \\beta + \\gamma = 180°')
            . '<p>Iz slike vidimo da je \(\\alpha = 65°\). Sada mozemo da izracunamo \(\\gamma\):</p>'
            . $this->m('65° + 90° + \\gamma = 180°')
            . $this->m('\\gamma = 180° - 65° - 90°')
            . $this->m('\\gamma = 25°')
            . '<p><strong>Odgovor:</strong> \(\\alpha = 65°\), \(\\beta = 90°\), \(\\gamma = 25°\).</p>';
    }

    private function task14(): string
    {
        return '<h3>Zadatak 14</h3>'
            . '<p>Izracunaj povrsinu jednakoivicne cetvorostrane piramide cija je bocna ivica 8 cm.</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p><strong>Jednakoivicna</strong> piramida znaci da su sve ivice jednake duzine. Sve ivice su \(a = 8\) cm.</p>'
            . '<p>Osnova je <strong>kvadrat</strong> sa stranicom \(a = 8\) cm:</p>'
            . $this->m('P_{\\text{osnove}} = a^2 = 8^2 = 64 \\text{ cm}^2')
            . '<p>Bocne strane su <strong>jednakostranicni trouglovi</strong> (jer su sve ivice jednake). Povrsina jednakostranicnog trougla sa stranicom \(a\) je:</p>'
            . $this->m('P_{\\triangle} = \\frac{a^2\\sqrt{3}}{4} = \\frac{64\\sqrt{3}}{4} = 16\\sqrt{3} \\text{ cm}^2')
            . '<p>Cetvorostrana piramida ima 4 bocne strane:</p>'
            . $this->m('P_{\\text{bocna}} = 4 \\cdot 16\\sqrt{3} = 64\\sqrt{3} \\text{ cm}^2')
            . '<p>Ukupna povrsina je zbir povrsine osnove i svih bocnih strana:</p>'
            . $this->m('P = P_{\\text{osnove}} + P_{\\text{bocna}} = 64 + 64\\sqrt{3} = (64 + 64\\sqrt{3}) \\text{ cm}^2')
            . '<p><strong>Odgovor:</strong> Povrsina piramide je \((64 + 64\\sqrt{3})\) cm\(^2\).</p>';
    }

    private function task15(): string
    {
        return '<h3>Zadatak 15</h3>'
            . '<p>Mase jaja razlicitih ptica su: noj 1 kg 800 g, kokoska 0,058 kg, guska 215 g, prepelica 0,012 kg, kolibri 11 g. Koje jaje je trece po tezini (od najlakseg ka najtezem)?</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Da bismo uporedili, pretvorimo sve mase u grame:</p>'
            . '<ul>'
            . '<li><strong>Noj:</strong> 1 kg 800 g = 1800 g</li>'
            . '<li><strong>Kokoska:</strong> 0,058 kg = 58 g</li>'
            . '<li><strong>Guska:</strong> 215 g</li>'
            . '<li><strong>Prepelica:</strong> 0,012 kg = 12 g</li>'
            . '<li><strong>Kolibri:</strong> 11 g</li>'
            . '</ul>'
            . '<p>Poredimo od najlakseg ka najtezem:</p>'
            . $this->m('\\text{kolibri (11 g)} < \\text{prepelica (12 g)} < \\text{kokoska (58 g)} < \\text{guska (215 g)} < \\text{noj (1800 g)}')
            . '<p>Trece po redu (od najlakseg) je <strong>kokoska</strong> sa 58 g.</p>'
            . '<p><strong>Odgovor:</strong> Trece po tezini je jaje kokoske.</p>';
    }

    private function task16(): string
    {
        return '<h3>Zadatak 16</h3>'
            . '<p>Proslog meseca pekara je prodala 2400 vekni hleba. Ovog meseca prodaja je porasla za 12,5%. Koliko je vekni ukupno prodato u ta dva meseca?</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Proslog meseca: 2400 vekni.</p>'
            . '<p>Ovog meseca je porast od 12,5%. Izracunajmo koliko je to:</p>'
            . $this->m('\\text{Porast} = 2400 \\cdot \\frac{12{,}5}{100} = 2400 \\cdot 0{,}125 = 300 \\text{ vekni}')
            . '<p>Ovog meseca je prodato:</p>'
            . $this->m('2400 + 300 = 2700 \\text{ vekni}')
            . '<p>Ukupno za dva meseca:</p>'
            . $this->m('2400 + 2700 = 5100 \\text{ vekni}')
            . '<p><strong>Odgovor:</strong> Ukupno je prodato \(5100\) vekni hleba.</p>';
    }

    private function task17(): string
    {
        return '<h3>Zadatak 17</h3>'
            . '<p>Broj oblika \(\\overline{A4B}\) je najmanji trocifren broj deljiv sa 2 i sa 9. Broj oblika \(\\overline{6CD}\) je najveci trocifren broj deljiv sa 5 i sa 3. Izmedju kojih uzastopnih celih desetica se nalazi zbir ova dva broja?</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p><strong>Trazimo \(\\overline{A4B}\):</strong></p>'
            . '<p>Uslovi: deljiv sa 2 (poslednja cifra parna) i deljiv sa 9 (zbir cifara deljiv sa 9). Trazimo najmanji takav.</p>'
            . '<p>Najmanji trocifren znaci da je \(A\) sto manje, dakle \(A = 1\).</p>'
            . '<p>Zbir cifara: \(1 + 4 + B = 5 + B\). Treba da bude deljiv sa 9.</p>'
            . '<p>\(B\) mora biti paran broj (deljiv sa 2). Probamo: \(5 + B = 9\), pa \(B = 4\). Jeste li 4 parno? Da!</p>'
            . $this->m('\\overline{A4B} = 144')
            . '<p>Proverimo: \(144 : 2 = 72\) (deljiv sa 2), \(1 + 4 + 4 = 9\) (deljiv sa 9). Tacno!</p>'
            . '<p><strong>Trazimo \(\\overline{6CD}\):</strong></p>'
            . '<p>Uslovi: deljiv sa 5 (poslednja cifra 0 ili 5) i deljiv sa 3 (zbir cifara deljiv sa 3). Trazimo najveci takav.</p>'
            . '<p>Probamo \(D = 0\) (vece od \(D = 5\) za ukupan broj kad maksimizujemo \(C\)).</p>'
            . '<p>Za \(D = 0\): zbir cifara \(6 + C + 0 = 6 + C\) treba da bude deljiv sa 3. Najvece \(C\): probamo \(C = 9\), \(6 + 9 = 15\) - deljivo sa 3! Broj: 690.</p>'
            . '<p>Za \(D = 5\): zbir cifara \(6 + C + 5 = 11 + C\). Najvece \(C\): \(C = 7\), \(11 + 7 = 18\) - deljivo sa 3. Broj: 675.</p>'
            . '<p>Poredjenje: \(690 > 675\), pa je odgovor:</p>'
            . $this->m('\\overline{6CD} = 690')
            . '<p>Sada racunamo zbir:</p>'
            . $this->m('144 + 690 = 834')
            . '<p>Gledamo izmedju kojih uzastopnih celih desetica se nalazi 834:</p>'
            . $this->m('830 < 834 < 840')
            . '<p><strong>Odgovor:</strong> Zbir 834 se nalazi izmedju 831 i 860 (u ponudjenim odgovorima).</p>';
    }

    private function task18(): string
    {
        return '<h3>Zadatak 18</h3>'
            . '<p>Travnjak je kvadratnog oblika. Oko njega se nalazi staza sirine 2,5 m. Ukupna povrsina travnjaka i staze zajedno je 245 m\(^2\). Kolika je povrsina samog travnjaka?</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Neka je stranica travnjaka \(x\) metara.</p>'
            . '<p>Staza je sirine 2,5 m sa svih strana, pa spoljna stranica (travnjak + staza) iznosi:</p>'
            . $this->m('x + 2 \\cdot 2{,}5 = x + 5')
            . '<p>Povrsina same staze je 245 m\(^2\). Staza je razlika izmedju spoljasnjeg i unutrasnjeg kvadrata:</p>'
            . $this->m('(x + 5)^2 - x^2 = 245')
            . '<p>Raspisemo kvadrat binoma:</p>'
            . $this->m('x^2 + 10x + 25 - x^2 = 245')
            . $this->m('10x + 25 = 245')
            . $this->m('10x = 220')
            . $this->m('x = 22')
            . '<p>Povrsina travnjaka je:</p>'
            . $this->m('P = x^2 = 22^2 = 484 \\text{ m}^2')
            . '<p><strong>Odgovor:</strong> Povrsina travnjaka je \(484\) m\(^2\).</p>';
    }

    private function task19(): string
    {
        return '<h3>Zadatak 19</h3>'
            . '<p>Dat je kvadrat cija je dijagonala 8 cm. Temena kvadrata su centri dva mala i dva velika kruga. Veliki krugovi se dodiruju u preseku dijagonala. Tacke dodira krugova i stranica kvadrata pripadaju stranicama.</p>'
            . '<p>[slika - kvadrat sa cetiri kruga ciji su centri u temenima]</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Dijagonala kvadrata je \(d = 8\) cm. Izracunajmo stranicu:</p>'
            . $this->m('d = a\\sqrt{2} \\implies a\\sqrt{2} = 8 \\implies a = \\frac{8}{\\sqrt{2}} = 4\\sqrt{2} \\text{ cm}')
            . '<p><strong>Poluprecnik velikog kruga:</strong></p>'
            . '<p>Veliki krugovi se dodiruju u centru kvadrata (preseku dijagonala). Centar velikog kruga je u temenu, pa je poluprecnik jednak polovini dijagonale:</p>'
            . $this->m('R = \\frac{d}{2} = \\frac{8}{2} = 4 \\text{ cm}')
            . '<p><strong>Poluprecnik malog kruga:</strong></p>'
            . '<p>Mali krug dodiruje stranicu kvadrata. Centar malog kruga je u temenu, pa je poluprecnik jednak rastojanju od temena do tacke dodira na stranici, sto je jednako stranici kvadrata minus poluprecnik velikog kruga:</p>'
            . $this->m('r = a - R = 4\\sqrt{2} - 4 \\text{ cm}')
            . '<p><strong>Obim figure:</strong></p>'
            . '<p>Svaki krug daje cetvrtinu svog obima (jer je centar u temenu kvadrata, a ugao je 90 stepeni). Imamo 2 velika i 2 mala kruga:</p>'
            . $this->m('O = 2 \\cdot \\frac{1}{4} \\cdot 2R\\pi + 2 \\cdot \\frac{1}{4} \\cdot 2r\\pi')
            . $this->m('= R\\pi + r\\pi')
            . $this->m('= \\pi(R + r)')
            . $this->m('= \\pi(4 + 4\\sqrt{2} - 4)')
            . $this->m('= 4\\sqrt{2}\\pi \\text{ cm}')
            . '<p><strong>Odgovor:</strong> Obim figure je \(4\\sqrt{2}\\pi\) cm.</p>';
    }

    private function task20(): string
    {
        return '<h3>Zadatak 20</h3>'
            . '<p>Pravilna cetvorostrana prizma ima zapreminu \(V = 64\\sqrt{6}\) cm\(^3\). Ugao izmedju dijagonale osnove i bocne ivice je 60°. Izracunaj povrsinu prizme.</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Pravilna cetvorostrana prizma ima <strong>kvadrat</strong> u osnovi sa stranicom \(a\) i visinu \(H\).</p>'
            . '<p><strong>Korak 1: Veza izmedju \(a\) i \(H\)</strong></p>'
            . '<p>Dijagonala osnove (kvadrata) je:</p>'
            . $this->m('D = a\\sqrt{2}')
            . '<p>Ugao izmedju dijagonale osnove i bocne ivice je 60°. Zamislimo pravougli trougao gde je:</p>'
            . '<ul>'
            . '<li>Jedna kateta = dijagonala osnove \(D = a\\sqrt{2}\)</li>'
            . '<li>Druga kateta = visina prizme \(H\)</li>'
            . '</ul>'
            . $this->m('\\tan(60°) = \\frac{H}{D} = \\frac{H}{a\\sqrt{2}}')
            . '<p>Znamo da je \(\\tan(60°) = \\sqrt{3}\), pa:</p>'
            . $this->m('\\sqrt{3} = \\frac{H}{a\\sqrt{2}}')
            . $this->m('H = a\\sqrt{2} \\cdot \\sqrt{3} = a\\sqrt{6}')
            . '<p><strong>Korak 2: Nalazimo \(a\)</strong></p>'
            . '<p>Zapremina prizme:</p>'
            . $this->m('V = a^2 \\cdot H = a^2 \\cdot a\\sqrt{6} = a^3\\sqrt{6}')
            . '<p>Zadato je \(V = 64\\sqrt{6}\):</p>'
            . $this->m('a^3\\sqrt{6} = 64\\sqrt{6}')
            . $this->m('a^3 = 64')
            . $this->m('a = 4 \\text{ cm}')
            . '<p>Odavde je visina:</p>'
            . $this->m('H = 4\\sqrt{6} \\text{ cm}')
            . '<p><strong>Korak 3: Racunamo povrsinu</strong></p>'
            . '<p>Povrsina prizme = 2 osnove + 4 bocne strane:</p>'
            . $this->m('P = 2a^2 + 4aH')
            . $this->m('P = 2 \\cdot 4^2 + 4 \\cdot 4 \\cdot 4\\sqrt{6}')
            . $this->m('P = 2 \\cdot 16 + 4 \\cdot 16\\sqrt{6}')
            . $this->m('P = 32 + 64\\sqrt{6}')
            . $this->m('P = (32 + 64\\sqrt{6}) \\text{ cm}^2')
            . '<p><strong>Odgovor:</strong> Povrsina prizme je \((32 + 64\\sqrt{6})\) cm\(^2\).</p>';
    }
}
