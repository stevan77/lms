<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\School;
use App\Models\Subchapter;
use Illuminate\Database\Seeder;

class ProbniZavrsni2026Seeder extends Seeder
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
        $school = School::where('name', 'TEMP')->firstOrFail();

        $course = Course::create([
            'school_id' => $school->id,
            'name' => 'Prethodni zavrsni ispiti matematike',
            'description' => 'Zbirka prethodnih zavrsnih ispita iz matematike sa detaljnim resenjima.',
        ]);

        $chapter = Chapter::create([
            'course_id' => $course->id,
            'title' => '2026',
            'order' => 1,
        ]);

        $sub = Subchapter::create([
            'chapter_id' => $chapter->id,
            'title' => 'Probni',
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
            . '<p>Marija je celu cokoladu podelila na pet jednakih delova, a zatim Novaku dala dva takva dela. Koji deo cokolade je dobio Novak?</p>'
            . '<p><strong>Ponudjeni odgovori:</strong> A) 0,2 &nbsp; B) 0,4 &nbsp; C) 0,25 &nbsp; D) 0,5</p>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p>Cokolada je podeljena na <strong>5 jednakih delova</strong>. Svaki deo predstavlja jednu petinu cele cokolade:</p>'
            . $this->m('\\text{Jedan deo} = \\frac{1}{5}')
            . '<p>Novak je dobio <strong>2 takva dela</strong>, sto znaci:</p>'
            . $this->m('\\text{Novakov deo} = \\frac{2}{5}')
            . '<p>Sada pretvaramo razlomak u decimalan broj. Delimo brojilac sa imeniocem:</p>'
            . $this->m('\\frac{2}{5} = 2 : 5 = 0{,}4')
            . '<p><strong>Tacan odgovor: B) 0,4</strong></p>';
    }

    private function task2(): string
    {
        return '<h3>Zadatak 2</h3>'
            . '<p>Jelena je na vratima prodavnice videla obavestenje o snizenjima cena za kupce koji imaju karticu za popust u toj prodavnici:</p>'
            . '<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; margin: 10px 0;">'
            . '<tr><th>Proizvod</th><th>Cena</th><th>Cena sa karticom za popust</th></tr>'
            . '<tr><td>Mleko (1 l)</td><td>120 dinara</td><td>95 dinara</td></tr>'
            . '<tr><td>Sir (1 kg)</td><td>800 dinara</td><td>630 dinara</td></tr>'
            . '<tr><td>Deterdzent za ves (3 kg)</td><td>1 500 dinara</td><td>1 240 dinara</td></tr>'
            . '<tr><td>Keks (300 g)</td><td>320 dinara</td><td>245 dinara</td></tr>'
            . '</table>'
            . '<p>Jelena je tog dana, po akcijskim cenama, kupila 2 l mleka, 1/2 kilograma sira, 3 kg deterdzenta za ves i 600 g keksa.</p>'
            . '<p>Koliko je novca Jelena ustedela ovom kupovinom?</p>'
            . '<p><strong>Ponudjeni odgovori:</strong> A) 530 dinara &nbsp; B) 545 dinara &nbsp; C) 755 dinara &nbsp; D) 1 090 dinara</p>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p>Prvo racunamo koliko je Jelena platila <strong>sa karticom</strong> (akcijske cene):</p>'
            . '<ul>'
            . '<li>2 l mleka: 2 &times; 95 = 190 dinara</li>'
            . '<li>1/2 kg sira: 630 : 2 = 315 dinara</li>'
            . '<li>3 kg deterdzenta: 1 240 dinara (pakovanje je vec 3 kg)</li>'
            . '<li>600 g keksa = 2 pakovanja po 300 g: 2 &times; 245 = 490 dinara</li>'
            . '</ul>'
            . $this->m('\\text{Ukupno sa karticom} = 190 + 315 + 1240 + 490 = 2235 \\text{ dinara}')
            . '<p>Sada racunamo koliko bi platila <strong>bez kartice</strong> (redovne cene):</p>'
            . '<ul>'
            . '<li>2 l mleka: 2 &times; 120 = 240 dinara</li>'
            . '<li>1/2 kg sira: 800 : 2 = 400 dinara</li>'
            . '<li>3 kg deterdzenta: 1 500 dinara</li>'
            . '<li>600 g keksa: 2 &times; 320 = 640 dinara</li>'
            . '</ul>'
            . $this->m('\\text{Ukupno bez kartice} = 240 + 400 + 1500 + 640 = 2780 \\text{ dinara}')
            . '<p>Usteda je razlika izmedju te dve cene:</p>'
            . $this->m('\\text{Usteda} = 2780 - 2235 = 545 \\text{ dinara}')
            . '<p><strong>Tacan odgovor: B) 545 dinara</strong></p>';
    }

    private function task3(): string
    {
        return '<h3>Zadatak 3</h3>'
            . '<p>Mirko otkljucava telefon prevlacenjem prsta preko ekrana telefona. Sablon za otkljucavanje telefona se dobije kada se povezu svi izrazi cija je vrednost -12.</p>'
            . '<p>U tabeli se nalaze sledeci izrazi:</p>'
            . '<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; margin: 10px 0;">'
            . '<tr><td>-3 &middot; 2&sup2;</td><td>3 &middot; 2&sup2;</td><td>-3 &middot; (-4)&sup1;</td></tr>'
            . '<tr><td>-3 &middot; (-2)&sup2;</td><td>-2&sup2; &middot; 3</td><td>12 &middot; (-1)&sup3;</td></tr>'
            . '<tr><td>-2&sup2; &middot; (-3)</td><td>3 &middot; (-2)&sup2;</td><td>-12 &middot; (-1)&#8308;</td></tr>'
            . '</table>'
            . '<p>[Slika]</p>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p>Moramo da izracunamo vrednost svakog izraza i pronadjemo one cija je vrednost <strong>-12</strong>.</p>'
            . '<p><strong>Pravilo:</strong> Prvo racunamo stepen, pa tek onda mnozenje. Minus ispred broja koji NIJE u zagradi se ne stepenuje!</p>'
            . '<p><strong>Red 1:</strong></p>'
            . '<ul>'
            . '<li>-3 &middot; 2&sup2; = -3 &middot; 4 = <strong>-12</strong> &#10004;</li>'
            . '<li>3 &middot; 2&sup2; = 3 &middot; 4 = 12</li>'
            . '<li>-3 &middot; (-4)&sup1; = -3 &middot; (-4) = 12</li>'
            . '</ul>'
            . '<p><strong>Red 2:</strong></p>'
            . '<ul>'
            . '<li>-3 &middot; (-2)&sup2; = -3 &middot; 4 = <strong>-12</strong> &#10004; (minus ispred trojke se NE stepenuje, a (-2)&sup2; = 4)</li>'
            . '<li>-2&sup2; &middot; 3 = -4 &middot; 3 = <strong>-12</strong> &#10004; (minus ispred dvojke se NE stepenuje, pa je -2&sup2; = -4)</li>'
            . '<li>12 &middot; (-1)&sup3; = 12 &middot; (-1) = <strong>-12</strong> &#10004; (neparan stepen negativnog broja daje negativan rezultat)</li>'
            . '</ul>'
            . '<p><strong>Red 3:</strong></p>'
            . '<ul>'
            . '<li>-2&sup2; &middot; (-3) = -4 &middot; (-3) = 12</li>'
            . '<li>3 &middot; (-2)&sup2; = 3 &middot; 4 = 12</li>'
            . '<li>-12 &middot; (-1)&#8308; = -12 &middot; 1 = <strong>-12</strong> &#10004;</li>'
            . '</ul>'
            . '<p>Izrazi cija je vrednost -12 nalaze se na pozicijama:</p>'
            . '<ul>'
            . '<li>Gornji levi ugao (1,1)</li>'
            . '<li>Srednji levi (2,1)</li>'
            . '<li>Sredina (2,2)</li>'
            . '<li>Srednji desni (2,3)</li>'
            . '<li>Donji desni ugao (3,3)</li>'
            . '</ul>'
            . '<p>Povezivanjem ovih polja dobija se sablon prikazan kao <strong>poslednja opcija</strong> (dole desno).</p>'
            . '<p><strong>Tacan odgovor: cetvrta opcija (poslednji sablon)</strong></p>';
    }

    private function task4(): string
    {
        return '<h3>Zadatak 4</h3>'
            . '<p>U internet prodavnici kapa kosta 500 dinara, a dostava se naplacuje 350 dinara bez obzira na broj porucenih kapa. Ukupan trosak porucbine (kapa i dostava) moze se izracunati po formuli:</p>'
            . $this->m('C = 350 + 500 \\cdot m')
            . '<p>gde je sa C oznacen ukupan iznos u dinarima, a sa m broj porucenih kapa.</p>'
            . '<p>Koliko najvise kapa Strahinja moze da poruci za 4 000 dinara?</p>'
            . '<p><strong>Ponudjeni odgovori:</strong> A) 4 &nbsp; B) 5 &nbsp; C) 6 &nbsp; D) 7 &nbsp; E) 8</p>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p>Znamo da Strahinja ima <strong>4 000 dinara</strong>. Ukupan trosak ne sme biti veci od tog iznosa:</p>'
            . $this->m('C \\leq 4000')
            . '<p>Zamenjujemo formulu:</p>'
            . $this->m('350 + 500 \\cdot m \\leq 4000')
            . '<p>Prebacujemo 350 na desnu stranu:</p>'
            . $this->m('500 \\cdot m \\leq 4000 - 350')
            . $this->m('500 \\cdot m \\leq 3650')
            . '<p>Delimo obe strane sa 500:</p>'
            . $this->m('m \\leq \\frac{3650}{500} = 7{,}3')
            . '<p>Posto m mora biti <strong>ceo broj</strong> (ne mozes poruciti 0,3 kape!), najveci broj kapa je <strong>7</strong>.</p>'
            . '<p>Provera: za 7 kapa platimo 350 + 500 &middot; 7 = 350 + 3500 = 3 850 dinara. To je manje od 4 000 dinara.</p>'
            . '<p>Za 8 kapa bi bilo: 350 + 500 &middot; 8 = 350 + 4000 = 4 350 dinara. To je previse!</p>'
            . '<p><strong>Tacan odgovor: D) 7</strong></p>';
    }

    private function task5(): string
    {
        return '<h3>Zadatak 5</h3>'
            . '<p>Na zgradi kompanije je nacrtan njen logo, koji se sastoji od dva kvadrata. Ako je duzina stranice veceg kvadrata 4 m, a manjeg 1 m, koliku povrsinu zauzima beli deo ovog logoa?</p>'
            . '<p>[Slika]</p>'
            . '<p><strong>Ponudjeni odgovori:</strong> A) 3 m&sup2; &nbsp; B) 9 m&sup2; &nbsp; C) 15 m&sup2; &nbsp; D) 16 m&sup2; &nbsp; E) 25 m&sup2;</p>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p>Logo se sastoji od dva kvadrata: veceg (stranica 4 m) i manjeg (stranica 1 m) koji se nalazi unutar veceg.</p>'
            . '<p><strong>Korak 1:</strong> Racunamo povrsinu veceg kvadrata:</p>'
            . $this->m('P_1 = a^2 = 4^2 = 16 \\text{ m}^2')
            . '<p><strong>Korak 2:</strong> Racunamo povrsinu manjeg kvadrata:</p>'
            . $this->m('P_2 = b^2 = 1^2 = 1 \\text{ m}^2')
            . '<p><strong>Korak 3:</strong> Beli deo je ono sto ostane kada od veceg kvadrata oduzmemo manji:</p>'
            . $this->m('P_{\\text{beli}} = P_1 - P_2 = 16 - 1 = 15 \\text{ m}^2')
            . '<p><strong>Tacan odgovor: C) 15 m&sup2;</strong></p>';
    }

    private function task6(): string
    {
        return '<h3>Zadatak 6</h3>'
            . '<p>Aleksa treba da napravi metalne drzace za police. Nacrtao je model drzaca i oznacio dimenzije. Da bi izracunao koliko je materijala potrebno za izradu drzaca, mora da izracuna nepoznatu duzinu x. Koliko iznosi duzina x?</p>'
            . '<p>[Slika: pravougli trougao sa katetama 4 cm i 3 cm, hipotenuza je x]</p>'
            . '<p><strong>Ponudjeni odgovori:</strong> A) 4 cm &nbsp; B) 4,5 cm &nbsp; C) 5 cm &nbsp; D) 5,5 cm &nbsp; E) 6 cm</p>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p>Na slici vidimo pravougli trougao. Poznate stranice su <strong>katete</strong> (stranice uz prav ugao):</p>'
            . $this->m('a = 4 \\text{ cm}, \\quad b = 3 \\text{ cm}')
            . '<p>Nepoznata stranica x je <strong>hipotenuza</strong> (najduza stranica, naspram pravog ugla).</p>'
            . '<p>Koristimo <strong>Pitagorinu teoremu</strong>: zbir kvadrata kateta jednak je kvadratu hipotenuze.</p>'
            . $this->m('x^2 = a^2 + b^2')
            . '<p>Zamenjujemo poznate vrednosti:</p>'
            . $this->m('x^2 = 4^2 + 3^2 = 16 + 9 = 25')
            . '<p>Korenujemo obe strane:</p>'
            . $this->m('x = \\sqrt{25} = 5 \\text{ cm}')
            . '<p><strong>Kako zapamtiti:</strong> Brojevi 3, 4 i 5 cine poznatu "Pitagorinu trojku" &mdash; uvek vazi 3&sup2; + 4&sup2; = 5&sup2;.</p>'
            . '<p><strong>Tacan odgovor: C) 5 cm</strong></p>';
    }

    private function task7(): string
    {
        return '<h3>Zadatak 7</h3>'
            . '<p>Planete Suncevog sistema se krecu po elipticnim orbitama i zbog toga se njihova udaljenost od Sunca stalno menja. U tabeli su prikazana neka rastojanja Zemlje od Sunca.</p>'
            . '<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; margin: 10px 0;">'
            . '<tr><th colspan="2">Rastojanje Zemlje od Sunca</th></tr>'
            . '<tr><td>Najvece</td><td>152 098 233 km</td></tr>'
            . '<tr><td>Srednje</td><td>149 597 871 km</td></tr>'
            . '<tr><td>Najmanje</td><td>147 098 291 km</td></tr>'
            . '</table>'
            . '<p>[Slika]</p>'
            . '<p>Koliko je najvece rastojanje Zemlje od Sunca zaokruzeno na milione kilometara?</p>'
            . '<p><strong>Ponudjeni odgovori:</strong> A) 152 000 000 &nbsp; B) 150 000 000 &nbsp; C) 149 000 000 &nbsp; D) 148 000 000</p>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p>Najvece rastojanje je <strong>152 098 233 km</strong>. Treba ga zaokruziti na milione.</p>'
            . '<p><strong>Kako se zaokruzuje na milione?</strong></p>'
            . '<p>Gledamo cifru na mestu stotina hiljada (to je prva cifra posle miliona). U nasem broju:</p>'
            . $this->m('152\\underbrace{\\,0\\,}_{\\text{stotine hiljada}}98\\,233')
            . '<p>Cifra na mestu stotina hiljada je <strong>0</strong>, sto je manje od 5, pa zaokruzujemo <strong>nadole</strong>.</p>'
            . '<p>Sve cifre posle miliona postaju nule:</p>'
            . $this->m('152\\,098\\,233 \\approx 152\\,000\\,000 \\text{ km}')
            . '<p><strong>Tacan odgovor: A) 152 000 000</strong></p>';
    }

    private function task8(): string
    {
        return '<h3>Zadatak 8</h3>'
            . '<p>Sifra za otvaranje trezora u banci se menja na dnevnom nivou. Direktor banke svakog dana dobija mejl u kome se nalaze 4 para simbola. Svaki par sadrzi jedno slovo i jednu cifru (npr. A1). Koristeci datu tabelu, direktor otkriva cetvorocifrenu sifru za trezor (npr. A1 B2 C3 D4 znaci da je sifra 2079).</p>'
            . '<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; margin: 10px 0;">'
            . '<tr><th></th><th>A</th><th>B</th><th>C</th><th>D</th></tr>'
            . '<tr><td><strong>1</strong></td><td>2</td><td>5</td><td>6</td><td>3</td></tr>'
            . '<tr><td><strong>2</strong></td><td>3</td><td>0</td><td>8</td><td>4</td></tr>'
            . '<tr><td><strong>3</strong></td><td>9</td><td>1</td><td>7</td><td>2</td></tr>'
            . '<tr><td><strong>4</strong></td><td>4</td><td>5</td><td>8</td><td>9</td></tr>'
            . '</table>'
            . '<p>Danas je direktor dobio mejl u kome pise <strong>C3 A4 B4 D1</strong>. Koja je danasnja sifra za otvaranje trezora?</p>'
            . '<p><strong>Ponudjeni odgovori:</strong> A) 7453 &nbsp; B) 8259 &nbsp; C) 7441 &nbsp; D) 4573</p>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p>Svaki par "Slovo + Broj" nam govori koja kolona (slovo) i koji red (broj) u tabeli treba da pogledamo.</p>'
            . '<ul>'
            . '<li><strong>C3</strong> &rarr; kolona C, red 3 &rarr; <strong>7</strong></li>'
            . '<li><strong>A4</strong> &rarr; kolona A, red 4 &rarr; <strong>4</strong></li>'
            . '<li><strong>B4</strong> &rarr; kolona B, red 4 &rarr; <strong>5</strong></li>'
            . '<li><strong>D1</strong> &rarr; kolona D, red 1 &rarr; <strong>3</strong></li>'
            . '</ul>'
            . '<p>Sifra je: <strong>7453</strong></p>'
            . '<p><strong>Tacan odgovor: A) 7453</strong></p>';
    }

    private function task9(): string
    {
        return '<h3>Zadatak 9</h3>'
            . '<p>U jednoj skoli ima 120 ucenika sedmog i 150 ucenika osmog razreda. Na pocetku skolske godine ucenici su anketirani i svaki se opredelio za jedan od ponudjenih izbornih predmeta. Rezultati ankete iskazani procentima broja ucenika koji su se opredelili za odredjeni predmet prikazani su u tabeli.</p>'
            . '<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; margin: 10px 0;">'
            . '<tr><th>Izborni predmet</th><th>VII</th><th>VIII</th></tr>'
            . '<tr><td>Svakodnevni zivot u proslosti</td><td>20 %</td><td>10 %</td></tr>'
            . '<tr><td>Medijska pismenost</td><td>10 %</td><td>30 %</td></tr>'
            . '<tr><td>Ja i eksperiment</td><td>15 %</td><td>20 %</td></tr>'
            . '<tr><td>Boravak u prirodi i planinarenje</td><td>30 %</td><td>10 %</td></tr>'
            . '<tr><td>Hor i orkestar</td><td>15 %</td><td>10 %</td></tr>'
            . '<tr><td>Crtanje, slikanje i vajanje</td><td>10 %</td><td>20 %</td></tr>'
            . '</table>'
            . '<p>Za koliko se vise ucenika sedmog razreda opredelilo za izborni predmet Boravak u prirodi i planinarenje od ucenika osmog razreda?</p>'
            . '<p><strong>Ponudjeni odgovori:</strong> A) 12 &nbsp; B) 15 &nbsp; C) 18 &nbsp; D) 21</p>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p><strong>Korak 1:</strong> Racunamo koliko sedmaka je izabralo "Boravak u prirodi i planinarenje".</p>'
            . '<p>U sedmom razredu ima <strong>120 ucenika</strong>, a 30% se opredelilo za ovaj predmet:</p>'
            . $this->m('\\frac{30}{100} \\cdot 120 = 0{,}3 \\cdot 120 = 36 \\text{ ucenika}')
            . '<p><strong>Korak 2:</strong> Racunamo koliko osmaka je izabralo isti predmet.</p>'
            . '<p>U osmom razredu ima <strong>150 ucenika</strong>, a 10% se opredelilo za ovaj predmet:</p>'
            . $this->m('\\frac{10}{100} \\cdot 150 = 0{,}1 \\cdot 150 = 15 \\text{ ucenika}')
            . '<p><strong>Korak 3:</strong> Razlika:</p>'
            . $this->m('36 - 15 = 21')
            . '<p>Za <strong>21 ucenika vise</strong> iz sedmog razreda se opredelilo za Boravak u prirodi.</p>'
            . '<p><strong>Tacan odgovor: D) 21</strong></p>';
    }

    private function task10(): string
    {
        return '<h3>Zadatak 10</h3>'
            . '<p>Ukoliko je tvrdenje tacno oboj kruzic u redu TACNO, a ukoliko tvrdenje nije tacno oboj kruzic u redu NETACNO.</p>'
            . '<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; margin: 10px 0;">'
            . '<tr><th>Tvrdenje</th><th>19% &lt; 1/5</th><th>2&radic;2 &lt; 7</th><th>2&pi; &lt; 6</th><th>-3,051 &lt; -3,05</th></tr>'
            . '<tr><td>TACNO</td><td>?</td><td>?</td><td>?</td><td>?</td></tr>'
            . '<tr><td>NETACNO</td><td>?</td><td>?</td><td>?</td><td>?</td></tr>'
            . '</table>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p>Proveravamo svako tvrdenje pojedinacno:</p>'

            . '<h4>Tvrdenje 1: 19% &lt; 1/5</h4>'
            . '<p>Pretvorimo obe vrednosti u isti oblik. Znamo da je:</p>'
            . $this->m('\\frac{1}{5} = \\frac{20}{100} = 20\\%')
            . '<p>Posto je 19% &lt; 20%, tvrdenje je <strong>TACNO</strong>.</p>'

            . '<h4>Tvrdenje 2: 2&radic;2 &lt; 7</h4>'
            . '<p>Znamo da je:</p>'
            . $this->m('\\sqrt{2} < \\sqrt{4} = 2')
            . '<p>Ako je &radic;2 manje od 2, onda je:</p>'
            . $this->m('2\\sqrt{2} < 2 \\cdot 2 = 4')
            . '<p>A 4 je sigurno manje od 7, pa je tvrdenje <strong>TACNO</strong>.</p>'

            . '<h4>Tvrdenje 3: 2&pi; &lt; 6</h4>'
            . '<p>Znamo da je &pi; &asymp; 3,14, pa je:</p>'
            . $this->m('2\\pi \\approx 2 \\cdot 3{,}14 = 6{,}28')
            . '<p>Posto je 6,28 &gt; 6, tvrdenje je <strong>NETACNO</strong>.</p>'

            . '<h4>Tvrdenje 4: -3,051 &lt; -3,05</h4>'
            . '<p>Kod negativnih brojeva, sto je broj "dalji" od nule, to je manji. Uporedimo:</p>'
            . $this->m('-3{,}051 \\text{ je levlje na brojevnoj pravi od } -3{,}05')
            . '<p>Zato je -3,051 &lt; -3,05 &mdash; tvrdenje je <strong>TACNO</strong>.</p>'

            . '<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; margin: 10px 0;">'
            . '<tr><th>Tvrdenje</th><th>19% &lt; 1/5</th><th>2&radic;2 &lt; 7</th><th>2&pi; &lt; 6</th><th>-3,051 &lt; -3,05</th></tr>'
            . '<tr><td><strong>TACNO</strong></td><td>&bull;</td><td>&bull;</td><td></td><td>&bull;</td></tr>'
            . '<tr><td><strong>NETACNO</strong></td><td></td><td></td><td>&bull;</td><td></td></tr>'
            . '</table>'
            . '<p><strong>Tacan odgovor: TACNO, TACNO, NETACNO, TACNO</strong></p>';
    }

    private function task11(): string
    {
        return '<h3>Zadatak 11</h3>'
            . '<p>Jelena ima plastenik sa 40 stabljika paradajza. Sa svake stabljike ocekuje prosecan prinos od 3 kg paradajza. Od ukupne kolicine, 20 kg ce ostaviti za porodicu, a ostatak prodaje na pijaci po ceni od 250 dinara za kilogram. Troskovi za seme, djubrivo i vodu iznose ukupno 15 000 dinara. Koliko ce, prema ovoj proceni, Jelena zaraditi od prodaje paradajza?</p>'
            . '<p><strong>Ponudjeni odgovori:</strong> A) 9 000 dinara &nbsp; B) 10 000 dinara &nbsp; C) 25 000 dinara &nbsp; D) 30 000 dinara</p>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p><strong>Korak 1:</strong> Racunamo ukupan prinos paradajza:</p>'
            . $this->m('40 \\text{ stabljika} \\times 3 \\text{ kg} = 120 \\text{ kg}')
            . '<p><strong>Korak 2:</strong> Od toga 20 kg ostavlja za porodicu, pa za prodaju ostaje:</p>'
            . $this->m('120 - 20 = 100 \\text{ kg za prodaju}')
            . '<p><strong>Korak 3:</strong> Prihod od prodaje (koliko ce novca dobiti):</p>'
            . $this->m('100 \\text{ kg} \\times 250 \\text{ din/kg} = 25\\,000 \\text{ dinara}')
            . '<p><strong>Korak 4:</strong> Zarada je prihod minus troskovi:</p>'
            . $this->m('\\text{Zarada} = 25\\,000 - 15\\,000 = 10\\,000 \\text{ dinara}')
            . '<p><strong>Tacan odgovor: B) 10 000 dinara</strong></p>';
    }

    private function task12(): string
    {
        return '<h3>Zadatak 12</h3>'
            . '<p>Data je jednacina:</p>'
            . $this->m('16{,}2 + 3{,}2x + \\frac{10 - 3x}{4} = 28{,}5')
            . '<p>Kom od ponudjenih intervala pripada resenje ove jednacine?</p>'
            . '<p><strong>Ponudjeni odgovori:</strong> A) (0, 1] &nbsp; B) (1, 2] &nbsp; C) (2, 3] &nbsp; D) (3, 4]</p>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p>U jednacini imamo razlomak sa imeniocem 4. Da bismo ga se oslobodili, <strong>pomnozimo celu jednacinu sa 4</strong>:</p>'
            . $this->m('4 \\cdot 16{,}2 + 4 \\cdot 3{,}2x + 4 \\cdot \\frac{10 - 3x}{4} = 4 \\cdot 28{,}5')
            . '<p>Racunamo svaki clan:</p>'
            . $this->m('64{,}8 + 12{,}8x + (10 - 3x) = 114')
            . '<p>Raspisujemo zagradu:</p>'
            . $this->m('64{,}8 + 12{,}8x + 10 - 3x = 114')
            . '<p>Na levoj strani saberemo brojeve i posebno clanove sa x:</p>'
            . $this->m('74{,}8 + 9{,}8x = 114')
            . '<p>Prebacujemo 74,8 na desnu stranu (menja znak):</p>'
            . $this->m('9{,}8x = 114 - 74{,}8 = 39{,}2')
            . '<p>Delimo obe strane sa 9,8. Da bismo lakse delili, pomnozimo i brojilac i imenilac sa 10:</p>'
            . $this->m('x = \\frac{39{,}2}{9{,}8} = \\frac{392}{98} = 4')
            . '<p>Resenje jednacine je x = 4. Proveravamo kom intervalu pripada:</p>'
            . '<ul>'
            . '<li>(0, 1] &mdash; od 0 do 1 &rarr; NE</li>'
            . '<li>(1, 2] &mdash; od 1 do 2 &rarr; NE</li>'
            . '<li>(2, 3] &mdash; od 2 do 3 &rarr; NE</li>'
            . '<li>(3, 4] &mdash; od 3 do 4, <strong>ukljucujuci 4</strong> &rarr; DA!</li>'
            . '</ul>'
            . '<p><strong>Napomena:</strong> Uglasta zagrada ] znaci da je ta granica <em>ukljucena</em>, a obla zagrada ( znaci da ta granica <em>nije ukljucena</em>.</p>'
            . '<p><strong>Tacan odgovor: D) (3, 4]</strong></p>';
    }

    private function task13(): string
    {
        return '<h3>Zadatak 13</h3>'
            . '<p>Dati su polinomi:</p>'
            . $this->m('P(x) = 3x^2 - 4x - 2 \\quad \\text{i} \\quad Q(x) = 3x^2 - 3x - 5')
            . '<p>Kom od ponudjenih polinoma je jednako (Q(x) - P(x))&sup2; za svaku vrednost promenljive x?</p>'
            . '<p><strong>Ponudjeni odgovori:</strong></p>'
            . '<ul>'
            . '<li>A) x&sup2; - 6x + 9</li>'
            . '<li>B) x&sup2; + 6x + 9</li>'
            . '<li>C) x&sup2; + 9</li>'
            . '<li>D) 49x&sup2; - 98x + 49</li>'
            . '<li>E) x&sup2; - 14x + 49</li>'
            . '</ul>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p><strong>Korak 1:</strong> Prvo izracunamo Q(x) - P(x).</p>'
            . $this->m('Q(x) - P(x) = (3x^2 - 3x - 5) - (3x^2 - 4x - 2)')
            . '<p>Pazljivo raspisujemo minus ispred zagrade (menja se znak svakom clanu u zagradi):</p>'
            . $this->m('= 3x^2 - 3x - 5 - 3x^2 + 4x + 2')
            . '<p>Sredimo (saberemo slicne clanove):</p>'
            . $this->m('= (3x^2 - 3x^2) + (-3x + 4x) + (-5 + 2)')
            . $this->m('= 0 + x + (-3)')
            . $this->m('= x - 3')
            . '<p><strong>Korak 2:</strong> Sada kvadriramo rezultat:</p>'
            . $this->m('(Q(x) - P(x))^2 = (x - 3)^2')
            . '<p>Koristimo formulu za kvadrat binoma: (a - b)&sup2; = a&sup2; - 2ab + b&sup2;</p>'
            . $this->m('(x - 3)^2 = x^2 - 2 \\cdot x \\cdot 3 + 3^2 = x^2 - 6x + 9')
            . '<p><strong>Tacan odgovor: A) x&sup2; - 6x + 9</strong></p>';
    }

    private function task14(): string
    {
        return '<h3>Zadatak 14</h3>'
            . '<p>Osnovna ivica pravilne cetvorostrane piramide je 6 cm. Visina bocne strane piramide je 5 cm, a visina piramide 4 cm. Kolika je povrsina piramide?</p>'
            . '<p>[Slika]</p>'
            . '<p><strong>Ponudjeni odgovori:</strong> A) 84 cm&sup2; &nbsp; B) 48 cm&sup2; &nbsp; C) 96 cm&sup2; &nbsp; D) 144 cm&sup2; &nbsp; E) 120 cm&sup2;</p>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p><strong>Podaci:</strong></p>'
            . '<ul>'
            . '<li>Osnovna ivica: a = 6 cm</li>'
            . '<li>Visina bocne strane (apotema): h = 5 cm</li>'
            . '<li>Visina piramide: H = 4 cm</li>'
            . '</ul>'
            . '<p>Povrsina piramide = Osnova + Omotac (sve bocne strane)</p>'
            . $this->m('P = B + M')
            . '<p><strong>Korak 1:</strong> Osnova je kvadrat sa stranicom a = 6 cm:</p>'
            . $this->m('B = a^2 = 6^2 = 36 \\text{ cm}^2')
            . '<p><strong>Korak 2:</strong> Pravilna cetvorostrana piramida ima 4 jednake bocne strane. Svaka bocna strana je trougao sa osnovicom a i visinom h. Omotac je zbir povrsina sva 4 trougla:</p>'
            . $this->m('M = 4 \\cdot \\frac{a \\cdot h}{2} = 2ah')
            . '<p>Zamenjujemo:</p>'
            . $this->m('M = 2 \\cdot 6 \\cdot 5 = 60 \\text{ cm}^2')
            . '<p><strong>Korak 3:</strong> Ukupna povrsina:</p>'
            . $this->m('P = B + M = 36 + 60 = 96 \\text{ cm}^2')
            . '<p><strong>Tacan odgovor: C) 96 cm&sup2;</strong></p>';
    }

    private function task15(): string
    {
        return '<h3>Zadatak 15</h3>'
            . '<p>Marija zivi u Vankuveru. Proslog leta je doputovala u Beograd da obidje rodjake iz Srbije. U Beogradu je kupila haljinu cija je cena bila 5 760 dinara. Ista ta haljina u Vankuveru je kostala 92 kanadska dolara. Za koliko je dinara jeftinija ta haljina u Beogradu nego u Vankuveru, ako je u trenutku kupovine 1 kanadski dolar vredio 72 dinara?</p>'
            . '<p><strong>Ponudjeni odgovori:</strong> A) 432 dinara &nbsp; B) 864 dinara &nbsp; C) 1 728 dinara &nbsp; D) 1 296 dinara</p>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p><strong>Korak 1:</strong> Pretvaramo cenu iz Vankuvera u dinare.</p>'
            . '<p>Jedan kanadski dolar vredi 72 dinara, a haljina kosta 92 dolara:</p>'
            . $this->m('92 \\cdot 72 = 6\\,624 \\text{ dinara}')
            . '<p><strong>Korak 2:</strong> Racunamo razliku u ceni:</p>'
            . $this->m('6\\,624 - 5\\,760 = 864 \\text{ dinara}')
            . '<p>Haljina je u Beogradu jeftinija za <strong>864 dinara</strong>.</p>'
            . '<p><strong>Tacan odgovor: B) 864 dinara</strong></p>';
    }

    private function task16(): string
    {
        return '<h3>Zadatak 16</h3>'
            . '<p>Djurdja zeli da kupi dres reprezentacije Srbije i da na dresu odstampa svoje ime. Pronasla je dve opcije za kupovinu.</p>'
            . '<ul>'
            . '<li><strong>Opcija A:</strong> Kupovina u prodavnici. Cena dresa je 6 400 dinara, a stampanje imena se ne naplacuje.</li>'
            . '<li><strong>Opcija B:</strong> Kupovina preko interneta. Cena dresa je 5 000 dinara, a stampanje imena se naplacuje 10% od cene dresa. Postarina je 400 dinara.</li>'
            . '</ul>'
            . '<p>Koja opcija je povoljnija za Djurdju?</p>'
            . '<p><strong>Ponudjeni odgovori:</strong></p>'
            . '<ul>'
            . '<li>A) Obe opcije su jednako povoljne</li>'
            . '<li>B) Povoljnija je opcija A za 1 400 dinara</li>'
            . '<li>C) Povoljnija je opcija A za 900 dinara</li>'
            . '<li>D) Povoljnija je opcija A za 500 dinara</li>'
            . '<li>E) Povoljnija je opcija B za 1 400 dinara</li>'
            . '<li>F) Povoljnija je opcija B za 900 dinara</li>'
            . '<li>G) Povoljnija je opcija B za 500 dinara</li>'
            . '</ul>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p><strong>Opcija A:</strong></p>'
            . '<p>Dres: 6 400 din + Stampanje: besplatno = <strong>6 400 dinara</strong></p>'
            . '<p><strong>Opcija B:</strong></p>'
            . '<p>Stampanje imena kosta 10% od cene dresa:</p>'
            . $this->m('10\\% \\cdot 5\\,000 = \\frac{10}{100} \\cdot 5\\,000 = 500 \\text{ dinara}')
            . '<p>Ukupno za opciju B:</p>'
            . $this->m('5\\,000 + 500 + 400 = 5\\,900 \\text{ dinara}')
            . '<p><strong>Poredjenje:</strong></p>'
            . $this->m('6\\,400 - 5\\,900 = 500 \\text{ dinara}')
            . '<p>Opcija B je jeftinija za 500 dinara.</p>'
            . '<p><strong>Tacan odgovor: G) Povoljnija je opcija B za 500 dinara</strong></p>';
    }

    private function task17(): string
    {
        return '<h3>Zadatak 17</h3>'
            . '<p>Sadrzaj i usluge jednog hotela dati su u tabeli.</p>'
            . '<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; margin: 10px 0;">'
            . '<tr><td>24h recepcija</td></tr>'
            . '<tr><td>Internet</td></tr>'
            . '<tr><td>Parking</td></tr>'
            . '<tr><td>Kafe bar</td></tr>'
            . '<tr><td>Smestaj: 80 soba</td></tr>'
            . '<tr><td>Restoran</td></tr>'
            . '<tr><td>Teretana</td></tr>'
            . '<tr><td>Konferencijska sala</td></tr>'
            . '</table>'
            . '<p>U hotelu je dvadeset trokrevetnih soba, polovinu broja preostalih soba cine dvokrevetne, 15% od ukupnog broja soba su jednokrevetne, a ostale sobe su cetvorokrevetne. Koliko je ukupno gostiju smesteno u taj hotel, ako su sve sobe popunjene?</p>'
            . '<p>Prikazi postupak.</p>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p><strong>Podaci:</strong> Ukupno <strong>80 soba</strong>.</p>'

            . '<p><strong>Korak 1:</strong> Trokrevetne sobe:</p>'
            . $this->m('\\text{Trokrevetne} = 20 \\text{ soba}')

            . '<p><strong>Korak 2:</strong> Preostale sobe posle trokrevetnih:</p>'
            . $this->m('80 - 20 = 60 \\text{ soba}')

            . '<p><strong>Korak 3:</strong> Dvokrevetne sobe (polovina preostalih):</p>'
            . $this->m('\\text{Dvokrevetne} = \\frac{60}{2} = 30 \\text{ soba}')

            . '<p><strong>Korak 4:</strong> Jednokrevetne sobe (15% od ukupnog broja soba, tj. od 80):</p>'
            . $this->m('\\text{Jednokrevetne} = 15\\% \\cdot 80 = \\frac{15}{100} \\cdot 80 = 12 \\text{ soba}')

            . '<p><strong>Korak 5:</strong> Cetvorokrevetne sobe (ostale):</p>'
            . $this->m('\\text{Cetvorokrevetne} = 80 - 20 - 30 - 12 = 18 \\text{ soba}')

            . '<p><strong>Korak 6:</strong> Racunamo broj gostiju (svaka soba je popunjena):</p>'
            . $this->m('\\text{Gostiju} = 20 \\cdot 3 + 30 \\cdot 2 + 12 \\cdot 1 + 18 \\cdot 4')
            . $this->m('= 60 + 60 + 12 + 72 = 204')

            . '<p><strong>Tacan odgovor: Ukupan broj gostiju u hotelu je 204.</strong></p>';
    }

    private function task18(): string
    {
        return '<h3>Zadatak 18</h3>'
            . '<p>Jedna internet prodavnica je 2022. godine prodala 3<sup>9</sup> proizvoda, 2023. godine tri puta vise nego prethodne godine, a 2024. godine dva puta vise u odnosu na ukupnu prodaju u prethodne dve godine. Kolika je prosecna godisnja prodaja internet prodavnice za ove tri godine?</p>'
            . '<p><strong>Ponudjeni odgovori:</strong></p>'
            . '<ul>'
            . '<li>A) 3<sup>10</sup></li>'
            . '<li>B) 4 &middot; 3<sup>9</sup></li>'
            . '<li>C) 2 &middot; 3<sup>10</sup></li>'
            . '<li>D) 3<sup>20</sup></li>'
            . '<li>E) 5 &middot; 3<sup>9</sup></li>'
            . '<li>F) 4 &middot; 3<sup>10</sup></li>'
            . '</ul>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p><strong>Korak 1:</strong> Zapisujemo prodaju za svaku godinu:</p>'
            . $this->m('\\text{2022:} \\quad 3^9')
            . '<p>2023. godine tri puta vise nego 2022:</p>'
            . $this->m('\\text{2023:} \\quad 3 \\cdot 3^9 = 3^{10}')
            . '<p>2024. godine dva puta vise od ukupne prodaje u prethodne dve godine:</p>'
            . $this->m('\\text{2024:} \\quad 2 \\cdot (3^9 + 3^{10})')
            . '<p>Sredimo izraz u zagradi (iznesemo zajednicki cinilac 3<sup>9</sup>):</p>'
            . $this->m('3^9 + 3^{10} = 3^9 + 3 \\cdot 3^9 = 3^9(1 + 3) = 4 \\cdot 3^9')
            . '<p>Dakle:</p>'
            . $this->m('\\text{2024:} \\quad 2 \\cdot 4 \\cdot 3^9 = 8 \\cdot 3^9')
            . '<p><strong>Korak 2:</strong> Racunamo ukupnu prodaju za sve tri godine:</p>'
            . $this->m('3^9 + 3^{10} + 8 \\cdot 3^9 = 3^9 + 3 \\cdot 3^9 + 8 \\cdot 3^9')
            . $this->m('= 3^9(1 + 3 + 8) = 12 \\cdot 3^9')
            . '<p><strong>Korak 3:</strong> Prosecna godisnja prodaja (delimo sa 3 godine):</p>'
            . $this->m('\\text{Prosek} = \\frac{12 \\cdot 3^9}{3} = 4 \\cdot 3^9')
            . '<p><strong>Tacan odgovor: B) 4 &middot; 3<sup>9</sup></strong></p>';
    }

    private function task19(): string
    {
        return '<h3>Zadatak 19</h3>'
            . '<p>Na slici je prikazan kvadrat ABCD. Poznato je i da je cetvorougao BFGE takodje kvadrat, kao i da tacka G pripada dijagonali BD. Koliko iznosi povrsina osencenog dela kvadrata ABCD?</p>'
            . '<p>[Slika: kvadrat ABCD sa upisanim kvadratom BFGE, dato je DG = 8&radic;2 cm i CG = 10 cm]</p>'
            . '<p>Prikazi postupak.</p>'
            . '<hr>'
            . '<h3>Resenje</h3>'
            . '<p>Oznacimo stranicu velikog kvadrata ABCD sa <strong>a</strong>, a stranicu malog kvadrata BFGE sa <strong>s</strong>.</p>'

            . '<p><strong>Korak 1: Nalazimo vezu izmedju a i s</strong></p>'
            . '<p>B i G su naspramna temena malog kvadrata BFGE, pa je BG dijagonala tog kvadrata:</p>'
            . $this->m('BG = s\\sqrt{2}')
            . '<p>Tacka G lezi na dijagonali BD velikog kvadrata, izmedju B i D. Zato je:</p>'
            . $this->m('DG + BG = BD')
            . '<p>Dijagonala velikog kvadrata je BD = a&radic;2, pa zamenjujemo:</p>'
            . $this->m('8\\sqrt{2} + s\\sqrt{2} = a\\sqrt{2}')
            . '<p>Podelimo celu jednacinu sa &radic;2:</p>'
            . $this->m('8 + s = a')

            . '<p><strong>Korak 2: Racunamo s iz trougla CGF</strong></p>'
            . '<p>Pogledajmo trougao CGF. Tacka F lezi na stranici BC, a GF je stranica malog kvadrata koja je horizontalna (upravna na BC). Zato je ugao kod F pravi ugao!</p>'
            . '<p>U tom pravouglom trouglu:</p>'
            . '<ul>'
            . '<li>CF = a - s = (s + 8) - s = <strong>8 cm</strong> (deo stranice BC iznad tacke F)</li>'
            . '<li>GF = s (stranica malog kvadrata)</li>'
            . '<li>CG = 10 cm (dato u zadatku)</li>'
            . '</ul>'
            . '<p>Pitagorina teorema:</p>'
            . $this->m('CF^2 + GF^2 = CG^2')
            . $this->m('8^2 + s^2 = 10^2')
            . $this->m('64 + s^2 = 100')
            . $this->m('s^2 = 36')
            . $this->m('s = 6 \\text{ cm}')

            . '<p><strong>Korak 3: Racunamo stranicu velikog kvadrata</strong></p>'
            . $this->m('a = s + 8 = 6 + 8 = 14 \\text{ cm}')

            . '<p><strong>Korak 4: Racunamo povrsinu osencenog dela</strong></p>'
            . '<p>Osenceni deo je trapez ABFG sa paralelnim stranicama AB i GF:</p>'
            . '<ul>'
            . '<li>AB = 14 cm (stranica velikog kvadrata)</li>'
            . '<li>GF = 6 cm (stranica malog kvadrata)</li>'
            . '<li>Visina trapeza = s = 6 cm (rastojanje izmedju AB i linije GF)</li>'
            . '</ul>'
            . $this->m('P = \\frac{(AB + GF) \\cdot h}{2} = \\frac{(14 + 6) \\cdot 6}{2} = \\frac{120}{2} = 60 \\text{ cm}^2')

            . '<p><strong>Tacan odgovor: P = 60 cm&sup2;</strong></p>';
    }

    private function task20(): string
    {
        return '<h3>Zadatak 20</h3>'
            . '<p>U krug je upisan pravilan sestougao ABCDEF. Kolika je povrsina osencenog dela kruga na crtezu, ako je data duz EG = 6 cm?</p>'
            . '<p>[Slika]</p>'
            . '<p>Prikazi postupak.</p>'
            . '<hr>'
            . '<h3>Resenje</h3>'

            . '<p><strong>Sta znamo o pravilnom sestouglu?</strong></p>'
            . '<p>Pravilni sestougao se sastoji od <strong>6 jednakostranicnih trouglova</strong> koji se spajaju u centru O. Svaki trougao ima stranicu jednaku stranici sestougla (oznacimo je sa <strong>a</strong>).</p>'
            . '<p>Takodje, kod pravilnog sestougla vazi: <strong>poluprecnik opisanog kruga = stranica sestougla</strong>, tj. R = a.</p>'

            . '<p><strong>Korak 1: Nalazimo stranicu sestougla iz EG = 6</strong></p>'
            . '<p>EG je visina jednog od tih 6 jednakostranicnih trouglova (trougao OEF). Visina jednakostranicnog trougla sa stranicom a iznosi:</p>'
            . $this->m('h = \\frac{a\\sqrt{3}}{2}')
            . '<p>Posto je EG = h = 6:</p>'
            . $this->m('\\frac{a\\sqrt{3}}{2} = 6')
            . '<p>Pomnozimo obe strane sa 2:</p>'
            . $this->m('a\\sqrt{3} = 12')
            . '<p>Podelimo sa &radic;3 (i racionalizujemo):</p>'
            . $this->m('a = \\frac{12}{\\sqrt{3}} = \\frac{12}{\\sqrt{3}} \\cdot \\frac{\\sqrt{3}}{\\sqrt{3}} = \\frac{12\\sqrt{3}}{3} = 4\\sqrt{3} \\text{ cm}')
            . '<p>Znaci poluprecnik opisanog kruga je takodje R = a = 4&radic;3 cm.</p>'

            . '<p><strong>Korak 2: Povrsina kruznog isecka (120°)</strong></p>'
            . '<p>Na slici je osencen deo kruga koji pokriva dva od sest trouglova sestougla. Dva trougla znaci ugao od 2 &times; 60° = <strong>120°</strong>.</p>'
            . '<p>Povrsina kruznog isecka sa uglom 120°:</p>'
            . $this->m('P_{\\text{isecak}} = \\frac{R^2 \\pi \\cdot 120°}{360°} = \\frac{R^2 \\pi}{3}')
            . '<p>Zamenjujemo R = 4&radic;3:</p>'
            . $this->m('R^2 = (4\\sqrt{3})^2 = 16 \\cdot 3 = 48')
            . $this->m('P_{\\text{isecak}} = \\frac{48\\pi}{3} = 16\\pi \\text{ cm}^2')

            . '<p><strong>Korak 3: Povrsina dva trougla sestougla</strong></p>'
            . '<p>Povrsina jednakostranicnog trougla sa stranicom a:</p>'
            . $this->m('P_{\\triangle} = \\frac{a^2\\sqrt{3}}{4} = \\frac{(4\\sqrt{3})^2 \\cdot \\sqrt{3}}{4} = \\frac{48\\sqrt{3}}{4} = 12\\sqrt{3} \\text{ cm}^2')
            . '<p>Dva trougla:</p>'
            . $this->m('P_{\\text{2 trougla}} = 2 \\cdot 12\\sqrt{3} = 24\\sqrt{3} \\text{ cm}^2')

            . '<p><strong>Korak 4: Povrsina osencenog dela</strong></p>'
            . '<p>Osenceni deo je ono sto ostane kada od kruznog isecka oduzmemo dva trougla sestougla:</p>'
            . $this->m('P_{\\text{osenceno}} = P_{\\text{isecak}} - P_{\\text{2 trougla}} = 16\\pi - 24\\sqrt{3} \\text{ cm}^2')

            . '<p><strong>Tacan odgovor: Povrsina osencenog dela kruga je (16&pi; - 24&radic;3) cm&sup2;</strong></p>';
    }
}
