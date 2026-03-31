<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Subchapter;
use Illuminate\Database\Seeder;

class Zavrsni2025Seeder extends Seeder
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

        $chapter = Chapter::create([
            'course_id' => $course->id,
            'title' => '2025',
            'order' => 2,
        ]);

        $sub = Subchapter::create([
            'chapter_id' => $chapter->id,
            'title' => 'Zavrsni',
            'order' => 1,
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
            . '<p>Koji brojevi su na brojevnoj pravoj oznaceni slovima A i B?</p>'
            . '<p>[slika - brojevna prava sa oznakama -1 i 1, podeljena na po 5 jednakih delova, tacka A levo od 0, tacka B desno od 0]</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Pogledajmo brojevnu pravu. Izmedju -1 i 0 ima <strong>5 jednakih delova</strong>. Isto tako izmedju 0 i 1 ima 5 jednakih delova.</p>'
            . '<p>Svaki deo je dugacak:</p>'
            . $this->m('\\frac{1}{5} = 0{,}2')
            . '<p>Sada brojimo gde se nalaze tacke:</p>'
            . '<p><strong>Tacka A:</strong> Nalazi se jednu podeoku levo od nule. To znaci:</p>'
            . $this->m('A = 0 - 0{,}2 = -0{,}2')
            . '<p><strong>Tacka B:</strong> Nalazi se tri podeoke desno od nule. To znaci:</p>'
            . $this->m('B = 0 + 3 \\cdot 0{,}2 = 0{,}6')
            . '<p><strong>Odgovor:</strong> Slovom A je oznacen broj \(-0{,}2\), a slovom B broj \(0{,}6\).</p>';
    }

    private function task2(): string
    {
        return '<h3>Zadatak 2</h3>'
            . '<p>Koji razlomak predstavlja osenceni deo figure?</p>'
            . '<p>[slika - pravougaonik podeljen na 12 jednakih delova (4 kolone i 3 reda), od kojih je 5 delova osenceno]</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Pravougaonik je podeljen na jednake delove. Prebrojimo ih:</p>'
            . '<ul>'
            . '<li>Ima 4 kolone i 3 reda</li>'
            . '<li>Ukupno delova: \(4 \cdot 3 = 12\)</li>'
            . '<li>Osenceno je <strong>5</strong> delova</li>'
            . '</ul>'
            . '<p>Razlomak koji predstavlja osenceni deo je:</p>'
            . $this->m('\\frac{\\text{osenceni delovi}}{\\text{svi delovi}} = \\frac{5}{12}')
            . '<p><strong>Odgovor:</strong> Osenceni deo figure predstavlja razlomak \(\dfrac{5}{12}\).</p>';
    }

    private function task3(): string
    {
        return '<h3>Zadatak 3</h3>'
            . '<p>Povezi svaki izraz sa njegovom vrednoscu.</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p><strong>Izraz 1:</strong> \(3^2 - 2\)</p>'
            . '<p>Prvo stepenujemo: \(3^2 = 9\)</p>'
            . '<p>Zatim oduzimamo:</p>'
            . $this->m('9 - 2 = 7')
            . '<p><strong>Izraz 2:</strong> \((-2)^3 - 3\)</p>'
            . '<p>Prvo stepenujemo: \((-2)^3 = (-2) \cdot (-2) \cdot (-2) = -8\)</p>'
            . '<p>Zatim oduzimamo:</p>'
            . $this->m('-8 - 3 = -11')
            . '<p><strong>Izraz 3:</strong> \(3^2 + 2\)</p>'
            . '<p>Prvo stepenujemo: \(3^2 = 9\)</p>'
            . '<p>Zatim sabiramo:</p>'
            . $this->m('9 + 2 = 11')
            . '<p><strong>Izraz 4:</strong> \((-2)^3 + 3\)</p>'
            . '<p>Prvo stepenujemo: \((-2)^3 = -8\)</p>'
            . '<p>Zatim sabiramo:</p>'
            . $this->m('-8 + 3 = -5')
            . '<p><strong>Odgovor:</strong></p>'
            . '<ul>'
            . '<li>\(3^2 - 2 = 7\)</li>'
            . '<li>\((-2)^3 - 3 = -11\)</li>'
            . '<li>\(3^2 + 2 = 11\)</li>'
            . '<li>\((-2)^3 + 3 = -5\)</li>'
            . '</ul>';
    }

    private function task4(): string
    {
        return '<h3>Zadatak 4</h3>'
            . '<p>Dato je: \(A = -7a^2b^2\) i \(B = 8a^2b^2\). Oboj kruzice ispred TACNIH jednakosti.</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Proverimo svaku jednakost:</p>'
            . '<p><strong>1) \(A + B = 15a^2b^2\)</strong></p>'
            . '<p>Racunamo: \(A + B = -7a^2b^2 + 8a^2b^2 = 1 \cdot a^2b^2 = a^2b^2\)</p>'
            . '<p>Ovo nije \(15a^2b^2\), pa je <strong>NETACNO</strong>.</p>'
            . '<p><strong>2) \(A + B = -a^2b^2\)</strong></p>'
            . '<p>Vec smo izracunali da je \(A + B = a^2b^2\), ne \(-a^2b^2\). <strong>NETACNO</strong>.</p>'
            . '<p><strong>3) \(A - B = -15a^2b^2\)</strong></p>'
            . '<p>Racunamo:</p>'
            . $this->m('A - B = -7a^2b^2 - 8a^2b^2 = (-7 - 8) \\cdot a^2b^2 = -15a^2b^2')
            . '<p>To je TACNO!</p>'
            . '<p><strong>4) \(A \cdot B = -56a^4b^4\)</strong></p>'
            . '<p>Racunamo:</p>'
            . $this->m('A \\cdot B = (-7a^2b^2) \\cdot (8a^2b^2) = (-7) \\cdot 8 \\cdot a^{2+2} \\cdot b^{2+2} = -56a^4b^4')
            . '<p>To je TACNO!</p>'
            . '<p><strong>5) \(A \cdot B = -56a^2b^2\)</strong></p>'
            . '<p>Vec smo izracunali da je \(A \cdot B = -56a^4b^4\), ne \(-56a^2b^2\). <strong>NETACNO</strong>.</p>'
            . '<p>Zapamti: kad mnozimo stepene sa istom osnovom, sabiramo eksponente! \(a^2 \cdot a^2 = a^{2+2} = a^4\)</p>'
            . '<p><strong>Odgovor:</strong> Tacne jednakosti su \(A - B = -15a^2b^2\) i \(A \cdot B = -56a^4b^4\).</p>';
    }

    private function task5(): string
    {
        return '<h3>Zadatak 5</h3>'
            . '<p>Fudbalski teren je pravougaonog oblika dimenzija 40 m i 50 m. Ko je tacno izracunao dijagonalu terena?</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Da bismo nasli dijagonalu pravougaonika, koristimo <strong>Pitagorinu teoremu</strong>. Dijagonala pravi pravi ugao sa stranicama, pa vazi:</p>'
            . $this->m('d^2 = a^2 + b^2')
            . '<p>Proverimo svaki odgovor:</p>'
            . '<p><strong>Bogdan:</strong> \(d = 90\) m - Samo je sabrao stranice (\(40 + 50 = 90\)). To nije dijagonala! NETACNO.</p>'
            . '<p><strong>Vuk:</strong> \(d^2 = 90\) - Takodje je samo sabrao stranice umesto njihove kvadrate. NETACNO.</p>'
            . '<p><strong>Natasa:</strong> \(d^2 = 50^2 - 40^2 = 900\), \(d = 30\) m - Oduzela je kvadrate umesto da ih sabere. NETACNO.</p>'
            . '<p><strong>Aleksandra:</strong></p>'
            . $this->m('d^2 = 40^2 + 50^2 = 1600 + 2500 = 4100')
            . $this->m('d = \\sqrt{4100}')
            . '<p>Aleksandra je ispravno primenila Pitagorinu teoremu - sabrala je kvadrate obe stranice!</p>'
            . '<p><strong>Odgovor:</strong> Aleksandra je tacno izracunala dijagonalu.</p>';
    }

    private function task6(): string
    {
        return '<h3>Zadatak 6</h3>'
            . '<p>Kolika je povrsina kruga ciji je poluprecnik duzine 18 dm?</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Formula za povrsinu kruga je:</p>'
            . $this->m('P = r^2 \\cdot \\pi')
            . '<p>Poluprecnik je \(r = 18\) dm. Zamenimo u formulu:</p>'
            . $this->m('P = 18^2 \\cdot \\pi')
            . $this->m('P = 324\\pi \\text{ dm}^2')
            . '<p>Zapamti: poluprecnik je rastojanje od centra do ivice kruga. Precnik je duplo veci od poluprecnika!</p>'
            . '<p><strong>Odgovor:</strong> Povrsina kruga je \(324\pi\) dm\(^2\).</p>';
    }

    private function task7(): string
    {
        return '<h3>Zadatak 7</h3>'
            . '<p>Magdalena kupuje laminat za stan. Koliko dinara ima za kupovinu ako poseduje sledece novcanice:</p>'
            . '<ul>'
            . '<li>90 novcanica od 1000 dinara</li>'
            . '<li>8 novcanica od 500 dinara</li>'
            . '<li>6 novcanica od 200 dinara</li>'
            . '<li>10 novcanica od 50 dinara</li>'
            . '<li>10 novcanica od 10 dinara</li>'
            . '</ul>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Izracunajmo koliko vredi svaka grupa novcanica:</p>'
            . $this->m('90 \\cdot 1000 = 90\\,000 \\text{ din}')
            . $this->m('8 \\cdot 500 = 4\\,000 \\text{ din}')
            . $this->m('6 \\cdot 200 = 1\\,200 \\text{ din}')
            . $this->m('10 \\cdot 50 = 500 \\text{ din}')
            . $this->m('10 \\cdot 10 = 100 \\text{ din}')
            . '<p>Sada saberemo sve:</p>'
            . $this->m('90\\,000 + 4\\,000 + 1\\,200 + 500 + 100 = 95\\,800 \\text{ din}')
            . '<p><strong>Odgovor:</strong> Magdalena ima 95.800 dinara za kupovinu laminata.</p>';
    }

    private function task8(): string
    {
        return '<h3>Zadatak 8</h3>'
            . '<p>Date su tacke: A(2,1), B(5,3), C(4,7), D(8,8), E(7,2), F(2,8). Andrija je nacrtao tacke u koordinatnom sistemu. Koje tacke je Andrija tacno nacrtao?</p>'
            . '<p>[slika - koordinatni sistem sa tackama koje je Andrija nacrtao, neke su na pogresnim pozicijama]</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>U koordinatnom sistemu, tacka se zapisuje kao \((x, y)\), gde je:</p>'
            . '<ul>'
            . '<li>\(x\) - koliko idemo udesno (horizontalno)</li>'
            . '<li>\(y\) - koliko idemo nagore (vertikalno)</li>'
            . '</ul>'
            . '<p>Proverimo svaku tacku koju je Andrija nacrtao:</p>'
            . '<ul>'
            . '<li><strong>A(2,1)</strong> - Na Andrijinoj slici A nije na pravom mestu. NETACNO.</li>'
            . '<li><strong>B(5,3)</strong> - Na slici B je na (5,3). TACNO!</li>'
            . '<li><strong>C(4,7)</strong> - Na slici C nije na pravom mestu. NETACNO.</li>'
            . '<li><strong>D(8,8)</strong> - Na slici D je na (8,8). TACNO!</li>'
            . '<li><strong>E(7,2)</strong> - Na slici E nije na pravom mestu. NETACNO.</li>'
            . '<li><strong>F(2,8)</strong> - Na slici F je na (2,8). TACNO!</li>'
            . '</ul>'
            . '<p>Cesta greska je da se zamene x i y koordinata. Na primer, umesto da nacrtamo (2,1), nacrtamo (1,2). Uvek zapamti: <strong>prvo idemo udesno (x), pa nagore (y)</strong>!</p>'
            . '<p><strong>Odgovor:</strong> Andrija je tacno nacrtao tacke B, D i F.</p>';
    }

    private function task9(): string
    {
        return '<h3>Zadatak 9</h3>'
            . '<p>U tabeli su prikazani podaci o temperaturi i vlaznosti vazduha. Koja je temperatura prijatna pri vlaznosti vazduha od 40%?</p>'
            . '<p>[slika - tabela sa temperaturama i procentima vlaznosti, smajliji oznacavaju prijatan osecaj]</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>U tabeli trazimo kolonu za vlaznost od <strong>40%</strong>.</p>'
            . '<p>Zatim u toj koloni trazimo polja oznacena smajlijem (prijatan osecaj).</p>'
            . '<p>Gledamo koja temperatura odgovara tim poljima:</p>'
            . '<ul>'
            . '<li>Na <strong>20&deg;C</strong> pri 40% vlaznosti - prijatno (smajli)</li>'
            . '<li>Na <strong>22&deg;C</strong> pri 40% vlaznosti - prijatno (smajli)</li>'
            . '</ul>'
            . '<p><strong>Odgovor:</strong> Pri vlaznosti vazduha od 40%, prijatna temperatura je 20&deg;C i 22&deg;C.</p>';
    }

    private function task10(): string
    {
        return '<h3>Zadatak 10</h3>'
            . '<p>Nenad, Bogdan, Vladimir i Damir su sutirali penale. Ko je imao najveci procenat uspesnosti?</p>'
            . '<ul>'
            . '<li>Nenad je dao 3 od 4 penala</li>'
            . '<li>Bogdan je dao 2 od 3 penala</li>'
            . '<li>Vladimir je dao 70% penala</li>'
            . '<li>Damir je dao svaki drugi penal</li>'
            . '</ul>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Da bismo uporedili, pretvorimo sve u procente:</p>'
            . '<p><strong>Nenad:</strong> Dao 3 od 4 penala</p>'
            . $this->m('\\frac{3}{4} = 0{,}75 = 75\\%')
            . '<p><strong>Bogdan:</strong> Dao 2 od 3 penala</p>'
            . $this->m('\\frac{2}{3} \\approx 0{,}667 = 66{,}7\\%')
            . '<p><strong>Vladimir:</strong> Dao 70% penala = <strong>70%</strong></p>'
            . '<p><strong>Damir:</strong> Dao svaki drugi penal, to znaci svaki drugi, odnosno 1 od 2</p>'
            . $this->m('\\frac{1}{2} = 0{,}5 = 50\\%')
            . '<p>Poredimo: 75% &gt; 70% &gt; 66,7% &gt; 50%</p>'
            . '<p><strong>Odgovor:</strong> Nenad je imao najveci procenat uspesnosti (75%).</p>';
    }

    private function task11(): string
    {
        return '<h3>Zadatak 11</h3>'
            . '<p>Resi sistem jednacina i izracunaj \(x \cdot y\):</p>'
            . $this->m('x + 2y + 3{,}7 = 2y - (x + 1{,}3)')
            . $this->m('2(x - y) - 0{,}45y = y - 5')
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p><strong>Prva jednacina:</strong></p>'
            . $this->m('x + 2y + 3{,}7 = 2y - (x + 1{,}3)')
            . '<p>Sklonimo zagradu na desnoj strani:</p>'
            . $this->m('x + 2y + 3{,}7 = 2y - x - 1{,}3')
            . '<p>Prebacimo \(2y\) sa obe strane - poniste se:</p>'
            . $this->m('x + 3{,}7 = -x - 1{,}3')
            . '<p>Prebacimo \(-x\) na levu stranu i \(3{,}7\) na desnu:</p>'
            . $this->m('x + x = -1{,}3 - 3{,}7')
            . $this->m('2x = -5')
            . $this->m('x = -2{,}5')
            . '<p><strong>Druga jednacina:</strong></p>'
            . $this->m('2(x - y) - 0{,}45y = y - 5')
            . '<p>Sklonimo zagradu:</p>'
            . $this->m('2x - 2y - 0{,}45y = y - 5')
            . '<p>Zamenimo \(x = -2{,}5\):</p>'
            . $this->m('2 \\cdot (-2{,}5) - 2y - 0{,}45y = y - 5')
            . $this->m('-5 - 2{,}45y = y - 5')
            . '<p>Prebacimo \(y\) na levu, a \(-5\) na desnu stranu:</p>'
            . $this->m('-2{,}45y - y = -5 + 5')
            . $this->m('-3{,}45y = 0')
            . '<p>Kad nulu podelimo bilo kojim brojem, dobijamo nulu:</p>'
            . $this->m('y = 0')
            . '<p>Sada izracunamo proizvod:</p>'
            . $this->m('x \\cdot y = (-2{,}5) \\cdot 0 = 0')
            . '<p>Zapamti: bilo koji broj pomnozen nulom daje nulu!</p>'
            . '<p><strong>Odgovor:</strong> \(x \cdot y = 0\)</p>';
    }

    private function task12(): string
    {
        return '<h3>Zadatak 12</h3>'
            . '<p>Povezi svaki izraz sa odgovarajucim rezultatom.</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p><strong>Izraz 1:</strong> \((12x^2 - 1) + (-3 + 12x - 3x^2)\)</p>'
            . '<p>Sklonimo zagrade i grupimo slicne clanove:</p>'
            . $this->m('12x^2 - 1 - 3 + 12x - 3x^2')
            . '<p>Saberimo clanove uz \(x^2\): \(12x^2 - 3x^2 = 9x^2\)</p>'
            . '<p>Clan uz \(x\): \(12x\)</p>'
            . '<p>Slobodni clanovi: \(-1 - 3 = -4\)</p>'
            . $this->m('= 9x^2 + 12x - 4')
            . '<p><strong>Izraz 2:</strong> \((3x - 1)(1 + 3x)\)</p>'
            . '<p>Preuredimo: \((3x - 1)(3x + 1)\) - ovo je razlika kvadrata!</p>'
            . $this->m('(3x - 1)(3x + 1) = (3x)^2 - 1^2 = 9x^2 - 1')
            . '<p><strong>Izraz 3:</strong> \((3x - 2)^2\)</p>'
            . '<p>Koristimo formulu za kvadrat binoma: \((a - b)^2 = a^2 - 2ab + b^2\)</p>'
            . $this->m('(3x - 2)^2 = (3x)^2 - 2 \\cdot 3x \\cdot 2 + 2^2 = 9x^2 - 12x + 4')
            . '<p><strong>Odgovor:</strong></p>'
            . '<ul>'
            . '<li>\((12x^2 - 1) + (-3 + 12x - 3x^2) = 9x^2 + 12x - 4\)</li>'
            . '<li>\((3x - 1)(1 + 3x) = 9x^2 - 1\)</li>'
            . '<li>\((3x - 2)^2 = 9x^2 - 12x + 4\)</li>'
            . '</ul>';
    }

    private function task13(): string
    {
        return '<h3>Zadatak 13</h3>'
            . '<p>Na slici su prikazani uglovi \(\alpha\), \(\beta\), \(\gamma\) i \(\delta\) koje obrazuju dve prave koje se seku. Poznato je da je \(\beta = 123°\). Izracunaj \(\alpha + \gamma\).</p>'
            . '<p>[slika - dve prave se seku i obrazuju cetiri ugla: alfa, beta, gama, delta]</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Kad se dve prave seku, nastaju 4 ugla. Zapamti dva vazna pravila:</p>'
            . '<ul>'
            . '<li><strong>Susedni uglovi</strong> (jedan do drugog) su <strong>suplementni</strong> - sabiraju se do 180&deg;</li>'
            . '<li><strong>Unakrsni uglovi</strong> (jedan naspram drugog) su <strong>jednaki</strong></li>'
            . '</ul>'
            . '<p>Uglovi \(\alpha\) i \(\beta\) su susedni (suplementni), pa vazi:</p>'
            . $this->m('\\alpha + \\beta = 180°')
            . $this->m('\\alpha + 123° = 180°')
            . $this->m('\\alpha = 180° - 123° = 57°')
            . '<p>Uglovi \(\alpha\) i \(\gamma\) su unakrsni uglovi, pa su jednaki:</p>'
            . $this->m('\\gamma = \\alpha = 57°')
            . '<p>Sada mozemo izracunati zbir:</p>'
            . $this->m('\\alpha + \\gamma = 57° + 57° = 114°')
            . '<p><strong>Odgovor:</strong> \(\alpha + \gamma = 114°\)</p>';
    }

    private function task14(): string
    {
        return '<h3>Zadatak 14</h3>'
            . '<p>Data je kocka ivice 6 cm. Iz svakog temena kocke isecena je manja kocka ivice 2 cm. Izracunaj zapreminu tela koje je nastalo.</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Kocka ima <strong>8 temena</strong> (zamislite kutiju - 4 temena gore i 4 dole).</p>'
            . '<p>Iz svakog temena isecemo malu kocku ivice 2 cm.</p>'
            . '<p><strong>Korak 1:</strong> Izracunamo zapreminu velike kocke:</p>'
            . $this->m('V_{\\text{velika}} = 6^3 = 6 \\cdot 6 \\cdot 6 = 216 \\text{ cm}^3')
            . '<p><strong>Korak 2:</strong> Izracunamo zapreminu jedne male kocke:</p>'
            . $this->m('V_{\\text{mala}} = 2^3 = 2 \\cdot 2 \\cdot 2 = 8 \\text{ cm}^3')
            . '<p><strong>Korak 3:</strong> Izracunamo ukupnu zapreminu svih 8 malih kocki:</p>'
            . $this->m('V_{8 \\text{ malih}} = 8 \\cdot 8 = 64 \\text{ cm}^3')
            . '<p><strong>Korak 4:</strong> Oduzmemo od velike kocke:</p>'
            . $this->m('V = V_{\\text{velika}} - V_{8 \\text{ malih}} = 216 - 64 = 152 \\text{ cm}^3')
            . '<p><strong>Odgovor:</strong> Zapremina nastalog tela je 152 cm\(^3\).</p>';
    }

    private function task15(): string
    {
        return '<h3>Zadatak 15</h3>'
            . '<p>Na semaforu se pojavio prikaz "82:_8". Druga cifra drugog broja se ne vidi jer je displej pokvaren. Ako je displej simetrican (osna simetrija oko dvotacke), koji broj se zapravo prikazuje?</p>'
            . '<p>[slika - LED displej semafora koji prikazuje 82:_8 sa pokvarenim segmentom]</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Osna simetrija oko dvotacke znaci da je desna strana <strong>ogledalo</strong> leve strane.</p>'
            . '<p>Leva strana prikazuje <strong>82</strong>.</p>'
            . '<p>Kad napravimo ogledalo broja 82, cifre se citaju obrnutim redosledom, i svaka cifra se ogleda:</p>'
            . '<ul>'
            . '<li>Cifra 2 u ogledalu postaje 5 (na LED displeju sa 7 segmenata)</li>'
            . '<li>Cifra 8 u ogledalu ostaje 8 (jer je simetricna)</li>'
            . '</ul>'
            . '<p>Dakle desna strana (ogledalo od 82) je <strong>58</strong>.</p>'
            . '<p><strong>Odgovor:</strong> Na semaforu se prikazuje broj 58 (ceo prikaz je 82:58).</p>';
    }

    private function task16(): string
    {
        return '<h3>Zadatak 16</h3>'
            . '<p>Kacina mama kupila je mindjuse za 82 evra i platila karticom. Banka joj je umanjila racun za 9.676 dinara. Zatim je platila rucak od 55 evra takodje karticom. Za koliko dinara ce banka umanjiti racun za rucak?</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p><strong>Korak 1:</strong> Izracunajmo kurs (koliko dinara vredi 1 evro).</p>'
            . '<p>Za 82 evra banka je skinula 9.676 dinara:</p>'
            . $this->m('1 \\text{ evro} = \\frac{9\\,676}{82} = 118 \\text{ dinara}')
            . '<p><strong>Korak 2:</strong> Izracunajmo koliko dinara ce banka skinuti za rucak od 55 evra:</p>'
            . $this->m('55 \\cdot 118 = 6\\,490 \\text{ dinara}')
            . '<p>Racunanje mozemo razbiti na laksi nacin:</p>'
            . $this->m('55 \\cdot 118 = 55 \\cdot 100 + 55 \\cdot 18 = 5\\,500 + 990 = 6\\,490')
            . '<p><strong>Odgovor:</strong> Banka ce umanjiti racun za 6.490 dinara.</p>';
    }

    private function task17(): string
    {
        return '<h3>Zadatak 17</h3>'
            . '<p>Izracunaj vrednost izraza:</p>'
            . $this->m('A = \\sqrt{3 - \\dfrac{-4 + \\dfrac{2}{1{,}5}}{2 + 0{,}5 \\cdot 1\\dfrac{1}{3}}}')
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Ovaj zadatak resavamo korak po korak, od unutra ka spolja.</p>'
            . '<p><strong>Korak 1:</strong> Izracunajmo \(\dfrac{2}{1{,}5}\)</p>'
            . '<p>Pretvorimo \(1{,}5\) u razlomak: \(1{,}5 = \dfrac{3}{2}\)</p>'
            . $this->m('\\frac{2}{1{,}5} = \\frac{2}{\\frac{3}{2}} = 2 \\cdot \\frac{2}{3} = \\frac{4}{3}')
            . '<p><strong>Korak 2:</strong> Izracunajmo brojilac razlomka</p>'
            . $this->m('-4 + \\frac{4}{3} = \\frac{-12}{3} + \\frac{4}{3} = \\frac{-12 + 4}{3} = \\frac{-8}{3}')
            . '<p><strong>Korak 3:</strong> Izracunajmo \(0{,}5 \cdot 1\dfrac{1}{3}\)</p>'
            . '<p>Pretvorimo: \(1\dfrac{1}{3} = \dfrac{4}{3}\) i \(0{,}5 = \dfrac{1}{2}\)</p>'
            . $this->m('0{,}5 \\cdot \\frac{4}{3} = \\frac{1}{2} \\cdot \\frac{4}{3} = \\frac{4}{6} = \\frac{2}{3}')
            . '<p><strong>Korak 4:</strong> Izracunajmo imenilac razlomka</p>'
            . $this->m('2 + \\frac{2}{3} = \\frac{6}{3} + \\frac{2}{3} = \\frac{8}{3}')
            . '<p><strong>Korak 5:</strong> Podelimo brojilac sa imeniocem</p>'
            . $this->m('\\frac{\\frac{-8}{3}}{\\frac{8}{3}} = \\frac{-8}{3} \\cdot \\frac{3}{8} = \\frac{-8 \\cdot 3}{3 \\cdot 8} = -1')
            . '<p><strong>Korak 6:</strong> Zavrsimo racun</p>'
            . $this->m('A = \\sqrt{3 - (-1)} = \\sqrt{3 + 1} = \\sqrt{4} = 2')
            . '<p>Zapamti: minus i minus daju plus! \(3 - (-1) = 3 + 1 = 4\)</p>'
            . '<p><strong>Odgovor:</strong> \(A = 2\)</p>';
    }

    private function task18(): string
    {
        return '<h3>Zadatak 18</h3>'
            . '<p>Basta kvadratnog oblika ima stranicu duzine \(a\) metara. Duzina baste je povecana za 3 m, a sirina je smanjena za 3 m. Da li se povrsina baste povecala ili smanjila i za koliko?</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p><strong>Korak 1:</strong> Izracunajmo prvobitnu povrsinu kvadratne baste:</p>'
            . $this->m('P_1 = a \\cdot a = a^2')
            . '<p><strong>Korak 2:</strong> Nove dimenzije baste su:</p>'
            . '<ul>'
            . '<li>Duzina: \(a + 3\) m</li>'
            . '<li>Sirina: \(a - 3\) m</li>'
            . '</ul>'
            . '<p><strong>Korak 3:</strong> Izracunajmo novu povrsinu:</p>'
            . $this->m('P_2 = (a + 3)(a - 3)')
            . '<p>Ovo je razlika kvadrata! Koristimo formulu \((a+b)(a-b) = a^2 - b^2\):</p>'
            . $this->m('P_2 = a^2 - 3^2 = a^2 - 9')
            . '<p><strong>Korak 4:</strong> Uporedimo povrsine:</p>'
            . $this->m('P_2 - P_1 = (a^2 - 9) - a^2 = -9 \\text{ m}^2')
            . '<p>Rezultat je negativan, sto znaci da se povrsina <strong>smanjila</strong>.</p>'
            . '<p><strong>Odgovor:</strong> Povrsina baste se smanjila za 9 m\(^2\).</p>';
    }

    private function task19(): string
    {
        return '<h3>Zadatak 19</h3>'
            . '<p>Izracunaj zapreminu pravilne sestostrane piramide cija je mreza prikazana na slici. Stranica osnove je \(a = 10\) cm, a bocna ivica trougla (kosa strana) je 13 cm.</p>'
            . '<p>[slika - mreza pravilne sestostrane piramide sa 6 jednakokrakih trouglova, osnova trougla 10 cm, kraci 13 cm]</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Ovo je tezi zadatak, ali idemo korak po korak!</p>'
            . '<p><strong>Korak 1:</strong> Nadji visinu bocnog trougla (apotemu piramide \(h_a\))</p>'
            . '<p>Svaki bocni trougao je jednakokraki sa osnovom 10 cm i kracima 13 cm. Visina deli osnovu na pola:</p>'
            . $this->m('h_a^2 = 13^2 - 5^2 = 169 - 25 = 144')
            . $this->m('h_a = \\sqrt{144} = 12 \\text{ cm}')
            . '<p><strong>Korak 2:</strong> Nadji apotemu osnove (rastojanje od centra sestoougla do sredine stranice)</p>'
            . '<p>Za pravilan sestoougao sa stranicom \(a = 10\) cm:</p>'
            . $this->m('a_o = \\frac{a\\sqrt{3}}{2} = \\frac{10\\sqrt{3}}{2} = 5\\sqrt{3} \\text{ cm}')
            . '<p><strong>Korak 3:</strong> Nadji visinu piramide \(H\)</p>'
            . '<p>Visina piramide, apotema osnove i apotema piramide cine pravi trougao:</p>'
            . $this->m('H^2 = h_a^2 - a_o^2 = 144 - (5\\sqrt{3})^2 = 144 - 75 = 69')
            . $this->m('H = \\sqrt{69} \\text{ cm}')
            . '<p><strong>Korak 4:</strong> Izracunaj povrsinu osnove</p>'
            . '<p>Pravilan sestoougao se sastoji od 6 jednakostranicnih trouglova sa stranicom \(a = 10\):</p>'
            . $this->m('B = 6 \\cdot \\frac{a^2\\sqrt{3}}{4} = 6 \\cdot \\frac{100\\sqrt{3}}{4} = 6 \\cdot 25\\sqrt{3} = 150\\sqrt{3} \\text{ cm}^2')
            . '<p><strong>Korak 5:</strong> Izracunaj zapreminu piramide</p>'
            . $this->m('V = \\frac{B \\cdot H}{3} = \\frac{150\\sqrt{3} \\cdot \\sqrt{69}}{3} = 50\\sqrt{3} \\cdot \\sqrt{69}')
            . '<p>Pojednostavimo: \(\sqrt{3} \cdot \sqrt{69} = \sqrt{3 \cdot 69} = \sqrt{207} = \sqrt{9 \cdot 23} = 3\sqrt{23}\)</p>'
            . $this->m('V = 50 \\cdot 3\\sqrt{23} = 150\\sqrt{23} \\text{ cm}^3')
            . '<p><strong>Odgovor:</strong> Zapremina piramide je \(150\sqrt{23}\) cm\(^3\).</p>';
    }

    private function task20(): string
    {
        return '<h3>Zadatak 20</h3>'
            . '<p>Cokolada je poskupela za 60% i sada kosta 200 dinara. Kolika je bila cena cokolade pre poskupljenja?</p>'
            . '<hr>'
            . '<h4>Resenje:</h4>'
            . '<p>Neka je stara cena cokolade \(x\) dinara.</p>'
            . '<p>Cokolada je poskupela za 60%, sto znaci da je nova cena <strong>160%</strong> od stare:</p>'
            . $this->m('x + 0{,}6 \\cdot x = 200')
            . '<p>Iznesemo \(x\) ispred zagrade:</p>'
            . $this->m('x \\cdot (1 + 0{,}6) = 200')
            . $this->m('1{,}6 \\cdot x = 200')
            . '<p>Podelimo obe strane sa \(1{,}6\):</p>'
            . $this->m('x = \\frac{200}{1{,}6} = 125')
            . '<p><strong>Provera:</strong> Stara cena je 125 din. 60% od 125 je \(0{,}6 \cdot 125 = 75\) din. Nova cena: \(125 + 75 = 200\) din. Tacno!</p>'
            . '<p><strong>Odgovor:</strong> Cokolada je pre poskupljenja kostala 125 dinara.</p>';
    }
}
