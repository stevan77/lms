<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\School;
use App\Models\Subchapter;
use Illuminate\Database\Seeder;

class Matematika8ValjakSeeder extends Seeder
{
    private function m($latex)
    {
        return '<div data-math-block latex="' . htmlspecialchars($latex, ENT_QUOTES) . '"></div>';
    }

    private function createLesson($course, $sub, $order, $title, $content, $isAssignment = false)
    {
        Lesson::create([
            'course_id' => $course->id,
            'subchapter_id' => $sub->id,
            'title' => $title,
            'order' => $order,
            'is_assignment' => $isAssignment,
            'content' => $content,
        ]);
    }

    public function run(): void
    {
        $school = School::where('name', 'like', '%Zarko%')->firstOrFail();

        $course = Course::create([
            'school_id' => $school->id,
            'name' => 'Matematika 8',
            'description' => 'Matematika za 8. razred - geometrijska tela, jednacine, funkcije i priprema za zavrsni ispit.',
        ]);

        $chapter = Chapter::create([
            'course_id' => $course->id,
            'title' => 'Valjak',
            'order' => 1,
        ]);

        $sub = Subchapter::create([
            'chapter_id' => $chapter->id,
            'title' => 'Definicije',
            'order' => 1,
        ]);

        // ============================================================
        // LEKCIJA 1: Sta je valjak?
        // ============================================================
        $content1 = '<h2>Sta je valjak?</h2>'

        . '<p>Pogledaj oko sebe - valjke vidis svuda! Konzerva tunjevine, rolna toalet papira, stub na zgradi, casa bez rucke, sveca... Sve su to predmeti u obliku valjka.</p>'

        . '<p>Ali kako nastaje valjak kao geometrijsko telo? Hajde da to istrazimo korak po korak.</p>'

        . '<h3>Kako nastaje valjak?</h3>'

        . '<p>Zamisli da imas <strong>pravougaonik</strong> nacrtan na papiru. Ako taj pravougaonik zarotiras oko jedne njegove stranice, dobices telo koje se zove <strong>valjak</strong>.</p>'

        . '<p>[slika - Pravougaonik ABCD sa oznacenim stranicama a i b. Strelica pokazuje rotaciju oko stranice b. Pored toga nacrtan rezultujuci valjak sa oznacenim r = a i H = b]</p>'

        . '<p>Zato kazemo da je valjak <strong>rotaciono telo</strong> - nastaje rotacijom (okretanjem) pravougaonika oko jedne stranice.</p>'

        . '<blockquote><p><strong>Zapamti:</strong> Stranica oko koje rotiramo pravougaonik postaje <strong>visina</strong> valjka, a druga stranica postaje <strong>poluprecnik osnove</strong>.</p></blockquote>'

        . '<h3>Cilindricna povrs</h3>'

        . '<p>Zamisli dva jednaka kruga koji se nalaze u paralelnim ravnima, jedan iznad drugog, tacno poravnati. Povrs koju obrazuju sve prave linije koje spajaju odgovarajuce tacke ova dva kruga naziva se <strong>cilindricna povrs</strong>.</p>'

        . '<p>[slika - Dva paralelna kruga (gornji i donji) povezani pravim linijama koje formiraju cilindricnu povrs. Oznacene ravni beta1 i beta2]</p>'

        . '<h3>Definicija valjka</h3>'

        . '<p>Geometrijsko telo ograniceno dvama krugovima (koji su osnove) i delom cilindricne povrsi izmedju njih naziva se <strong>prav valjak</strong>. Posto cemo se baviti iskljucivo pravim valjcima, reci "prav" cemo izostavljati.</p>'

        . '<p>Osnovni delovi valjka su:</p>'
        . '<ul>'
        . '<li><strong>Dve osnove (baze)</strong> - dva podudarna kruga</li>'
        . '<li><strong>Omotac</strong> - deo cilindricne povrsi izmedju osnova</li>'
        . '<li><strong>Visina (H)</strong> - rastojanje izmedju ravni osnova</li>'
        . '<li><strong>Poluprecnik osnove (r)</strong> - poluprecnik kruga koji je osnova</li>'
        . '</ul>'

        . '<p>[slika - Valjak sa jasno oznacenim delovima: gornja baza, donja baza, omotac, visina H (vertikalna linija), poluprecnik r (na osnovi). Sve lepo obojeno razlicitim bojama]</p>'

        . '<blockquote><p><strong>Zanimljivost:</strong> U mnogim jezicima za valjak se koristi rec izvedena od grcke reci koja izvorno znaci "oblicu". U nasem jeziku koristi se i rec <strong>cilindar</strong>. Cilindrom se nazivaju i razni predmeti u obliku valjka - na primer, komora u motorima automobila ili visoki muski sesir!</p></blockquote>'

        . '<h3>Valjak nije poliedar!</h3>'

        . '<p>Za razliku od prizmi i piramida, valjak <strong>nije poliedar</strong> jer njegove osnove nisu mnogouglovi vec krugovi. Valjak spada u takozvana <strong>obla tela</strong> - tela koja imaju zakrivljene povrsine.</p>'

        . '<h3>Da ponovimo</h3>'
        . '<table>'
        . '<thead><tr><th>Pojam</th><th>Objasnjenje</th></tr></thead>'
        . '<tbody>'
        . '<tr><td>Valjak</td><td>Oblo telo ograniceno dvema bazama (krugovima) i omotacem</td></tr>'
        . '<tr><td>Baze</td><td>Dva podudarna kruga u paralelnim ravnima</td></tr>'
        . '<tr><td>Omotac</td><td>Zakrivljena povrsina izmedju baza</td></tr>'
        . '<tr><td>Visina (H)</td><td>Rastojanje izmedju ravni baza</td></tr>'
        . '<tr><td>Poluprecnik (r)</td><td>Poluprecnik kruga koji je baza</td></tr>'
        . '<tr><td>Rotaciono telo</td><td>Nastaje rotacijom pravougaonika oko jedne stranice</td></tr>'
        . '</tbody>'
        . '</table>';

        $this->createLesson($course, $sub, 1, 'Sta je valjak?', $content1);

        // ============================================================
        // LEKCIJA 2: Elementi valjka
        // ============================================================
        $content2 = '<h2>Elementi valjka</h2>'

        . '<p>Sada kada znamo sta je valjak, hajde da detaljnije upoznamo njegove delove i naucimo sve vazne pojmove.</p>'

        . '<h3>Osa valjka</h3>'

        . '<p>Prava koja prolazi kroz centre obe osnove naziva se <strong>osa valjka</strong>. Kod pravog valjka, osa je <strong>upravna</strong> (normalna) na obe osnove.</p>'

        . '<p>[slika - Valjak sa ucrtanom osom (isprekidana linija od centra gornje baze do centra donje baze). Oznaceni centri O1 (gore) i O2 (dole). Osa oznacena slovom p]</p>'

        . '<h3>Osni presek</h3>'

        . '<p>Sta se desi kada valjak presecemo ravni koja sadrzi njegovu osu?</p>'

        . '<p>Dobijamo figuru koja se zove <strong>osni presek valjka</strong>. I ta figura je - <strong>pravougaonik</strong>!</p>'

        . '<p>[slika - Valjak presecen ravni kroz osu. Oznacen presek kao pravougaonik sa stranicama 2r (sirina) i H (visina). Sa strane posebno izcrtan pravougaonik sa oznakama]</p>'

        . '<p>Zasto pravougaonik? Zato sto:</p>'
        . '<ul>'
        . '<li>Jedna stranica pravougaonika jednaka je <strong>precniku osnove</strong>: \(2r\)</li>'
        . '<li>Druga stranica jednaka je <strong>visini valjka</strong>: \(H\)</li>'
        . '</ul>'

        . '<blockquote><p><strong>Vazno:</strong> Svi osni preseci jednog valjka su medjusobno <strong>podudarni</strong> (isti su), jer bez obzira kako okrenemo ravan kroz osu, uvek dobijamo isti pravougaonik.</p></blockquote>'

        . '<h4>Povrsina osnog preseka</h4>'

        . '<p>Posto je osni presek pravougaonik sa stranicama \(2r\) i \(H\), njegova povrsina je:</p>'

        . $this->m('P_{\\text{osni presek}} = 2r \\cdot H = 2rH')

        . '<h3>Primer 1</h3>'

        . '<p>Valjak je presecen ravni koja sadrzi centre njegovih osnova. Poluprecnik osnove je \(r = 1{,}5 \\text{ cm}\), a visina \(H = 4 \\text{ cm}\). Odredi povrsinu preseka.</p>'

        . '<p><strong>Resenje:</strong></p>'

        . '<p>Presek valjka i ravni je pravougaonik cija je jedna stranica jednaka precniku osnove \(2r = 2 \\cdot 1{,}5 = 3 \\text{ cm}\), a druga visini valjka \(H = 4 \\text{ cm}\):</p>'

        . $this->m('P = 2r \\cdot H = 3 \\cdot 4 = 12 \\text{ cm}^2')

        . '<h3>Poseban slucaj: osni presek je kvadrat</h3>'

        . '<p>Kada je precnik osnove jednak visini valjka, tj. kada je \(2r = H\), osni presek je <strong>kvadrat</strong>!</p>'

        . '<p>Na primer, ako je \(r = 3 \\text{ cm}\), onda je \(2r = 6 \\text{ cm}\). Da bi osni presek bio kvadrat, visina mora biti \(H = 6 \\text{ cm}\).</p>'

        . '<h3>Primer 2</h3>'

        . '<p>Osni presek valjka je kvadrat povrsine \(196 \\text{ cm}^2\). Odredi visinu i poluprecnik osnove valjka.</p>'

        . '<p><strong>Resenje:</strong></p>'

        . '<p>Posto je osni presek kvadrat, vazi \(2r = H\). Oznacimo stranicu kvadrata sa \(a\):</p>'

        . $this->m('a^2 = 196 \\text{ cm}^2')
        . $this->m('a = 14 \\text{ cm}')

        . '<p>Dakle:</p>'
        . '<ul>'
        . '<li>Visina: \(H = 14 \\text{ cm}\)</li>'
        . '<li>Precnik: \(2r = 14 \\text{ cm}\), pa je \(r = 7 \\text{ cm}\)</li>'
        . '</ul>'

        . '<h3>Primer 3</h3>'

        . '<p>Osni presek valjka visine \(H = 35 \\text{ cm}\) je pravougaonik cija je dijagonala \(d = 37 \\text{ cm}\). Odredi poluprecnik osnove valjka.</p>'

        . '<p><strong>Resenje:</strong></p>'

        . '<p>Osni presek je pravougaonik sa stranicama \(2r\) i \(H = 35 \\text{ cm}\), a dijagonala je \(d = 37 \\text{ cm}\). Po Pitagorinoj teoremi:</p>'

        . $this->m('(2r)^2 + H^2 = d^2')
        . $this->m('(2r)^2 + 35^2 = 37^2')
        . $this->m('(2r)^2 + 1225 = 1369')
        . $this->m('(2r)^2 = 144')
        . $this->m('2r = 12 \\text{ cm}')
        . $this->m('r = 6 \\text{ cm}')

        . '<h3>Da ponovimo</h3>'
        . '<table>'
        . '<thead><tr><th>Element</th><th>Opis</th></tr></thead>'
        . '<tbody>'
        . '<tr><td>Osa valjka</td><td>Prava kroz centre obe osnove</td></tr>'
        . '<tr><td>Osni presek</td><td>Pravougaonik sa stranicama \(2r\) i \(H\)</td></tr>'
        . '<tr><td>Povrsina osnog preseka</td><td>\(P = 2rH\)</td></tr>'
        . '<tr><td>Osni presek je kvadrat</td><td>Kada je \(2r = H\)</td></tr>'
        . '</tbody>'
        . '</table>';

        $this->createLesson($course, $sub, 2, 'Elementi valjka', $content2);

        // ============================================================
        // LEKCIJA 3: Mreza valjka
        // ============================================================
        $content3 = '<h2>Mreza valjka</h2>'

        . '<p>Da bismo razumeli povrsinu valjka, moramo prvo da vidimo kako izgleda njegova <strong>mreza</strong> - to jest, sta dobijemo kada valjak "rasecemo" i "razlijemo" na ravnu povrsinu.</p>'

        . '<h3>Kako razmotati valjak?</h3>'

        . '<p>Zamisli da imas limenku. Ako bi skinuo poklopac i dno (to su baze), ostao bi ti omotac. Ako taj omotac secnes po visini i razvijes ga na sto, dobices... <strong>pravougaonik</strong>!</p>'

        . '<p>[slika - Tri koraka: 1) Valjak sa oznacenom linijom secenja po omotacu, 2) Omotac koji se razvija/otvara, 3) Potpuno razvijen pravougaonik. Animacioni stil, korak po korak]</p>'

        . '<h3>Sta sadrzi mreza valjka?</h3>'

        . '<p>Mreza valjka se sastoji od <strong>tri dela</strong>:</p>'
        . '<ol>'
        . '<li><strong>Dva kruga</strong> - to su baze valjka (gornja i donja)</li>'
        . '<li><strong>Jedan pravougaonik</strong> - to je razvijeni omotac</li>'
        . '</ol>'

        . '<p>[slika - Kompletna mreza valjka: dva kruga poluprecnika r (gore i dole) i pravougaonik (u sredini) sa stranicama H i 2r*pi. Oznake na svim delovima. Baze oznacene kao "baza" sa r, pravougaonik oznacen sa "omotac" sa H i 2r*pi]</p>'

        . '<h3>Dimenzije pravougaonika (omotaca)</h3>'

        . '<p>Hajde da razmislimo koje su dimenzije tog pravougaonika:</p>'

        . '<p><strong>Visina pravougaonika</strong> = visina valjka = \(H\)</p>'

        . '<p><strong>Sirina pravougaonika</strong> = ? Ovo je kljucno pitanje!</p>'

        . '<p>Kada razvijemo omotac, njegova sirina mora biti jednaka <strong>obimu osnove</strong> (kruga). Zasto? Zato sto se omotac "obmotava" oko celog kruga, pa kad ga razvijemo, dobijemo duzinu tacno koliko iznosi obim tog kruga.</p>'

        . $this->m('\\text{Sirina omotaca} = O_{\\text{osnove}} = 2r\\pi')

        . '<blockquote><p><strong>Zapamti:</strong> Razvijeni omotac valjka je pravougaonik sa stranicama \(H\) i \(2r\\pi\).</p></blockquote>'

        . '<h3>Primer</h3>'

        . '<p>Nacrtaj mrezu valjka ciji je poluprecnik osnove \(r = 2 \\text{ cm}\) i visina \(H = 5 \\text{ cm}\).</p>'

        . '<p><strong>Resenje:</strong></p>'

        . '<p>Mreza se sastoji od:</p>'
        . '<ul>'
        . '<li>Dva kruga poluprecnika \(r = 2 \\text{ cm}\)</li>'
        . '<li>Pravougaonik sa stranicama:</li>'
        . '</ul>'

        . $this->m('H = 5 \\text{ cm}')
        . $this->m('2r\\pi = 2 \\cdot 2 \\cdot \\pi = 4\\pi \\approx 12{,}56 \\text{ cm}')

        . '<p>[slika - Nacrtana mreza: dva kruga precnika 4 cm i pravougaonik 5 cm x 12,56 cm sa oznacenim merama]</p>'

        . '<h3>Da ponovimo</h3>'
        . '<table>'
        . '<thead><tr><th>Deo mreze</th><th>Oblik</th><th>Dimenzije</th></tr></thead>'
        . '<tbody>'
        . '<tr><td>Baze (2 komada)</td><td>Krug</td><td>Poluprecnik \(r\)</td></tr>'
        . '<tr><td>Omotac</td><td>Pravougaonik</td><td>\(H \\times 2r\\pi\)</td></tr>'
        . '</tbody>'
        . '</table>';

        $this->createLesson($course, $sub, 3, 'Mreza valjka', $content3);

        // ============================================================
        // LEKCIJA 4: Povrsina valjka
        // ============================================================
        $content4 = '<h2>Povrsina valjka</h2>'

        . '<p>Sada kada znamo kako izgleda mreza valjka, mozemo lako da izracunamo njegovu povrsinu. Povrsina valjka je zbir povrsina svih delova mreze!</p>'

        . '<h3>Izvodjenje formule - korak po korak</h3>'

        . '<p>Povrsina valjka = povrsina dve baze + povrsina omotaca</p>'

        . '<h4>Korak 1: Povrsina jedne baze</h4>'

        . '<p>Baza je krug poluprecnika \(r\). Povrsina kruga je:</p>'

        . $this->m('B = r^2\\pi')

        . '<h4>Korak 2: Povrsina omotaca</h4>'

        . '<p>Omotac je pravougaonik sa stranicama \(H\) (visina) i \(2r\\pi\) (obim osnove). Povrsina pravougaonika je:</p>'

        . $this->m('M = H \\cdot 2r\\pi = 2r\\pi H')

        . '<h4>Korak 3: Ukupna povrsina</h4>'

        . '<p>Imamo <strong>dve baze</strong> i <strong>jedan omotac</strong>, pa sabiramo:</p>'

        . $this->m('P = 2B + M')
        . $this->m('P = 2r^2\\pi + 2r\\pi H')

        . '<p>Izvlacimo zajednicke faktore \(2r\\pi\) ispred zagrade:</p>'

        . $this->m('P = 2r\\pi(r + H)')

        . '<blockquote><p><strong>Formula za povrsinu valjka:</strong></p>'
        . $this->m('P = 2r\\pi(r + H)')
        . '<p>gde je \(r\) poluprecnik osnove, a \(H\) visina valjka.</p></blockquote>'

        . '<h3>Primer 1</h3>'

        . '<p>Izracunaj povrsinu valjka ako je poluprecnik osnove \(r = 3 \\text{ cm}\), a visina \(H = 5{,}5 \\text{ cm}\).</p>'

        . '<p><strong>Resenje:</strong></p>'

        . '<p>Primenjujemo formulu direktno:</p>'

        . $this->m('P = 2r\\pi(r + H)')
        . $this->m('P = 2 \\cdot 3 \\cdot \\pi \\cdot (3 + 5{,}5)')
        . $this->m('P = 6\\pi \\cdot 8{,}5')
        . $this->m('P = 51\\pi \\text{ cm}^2')

        . '<p>Ako uzmemo da je \(\\pi \\approx 3{,}14\), dobijamo pribliznu vrednost:</p>'

        . $this->m('P \\approx 51 \\cdot 3{,}14 \\approx 160{,}14 \\text{ cm}^2')

        . '<h3>Primer 2</h3>'

        . '<p>Odredi povrsinu valjka ako je <strong>precnik</strong> osnove \(2r = 3{,}4 \\text{ cm}\), a visina \(H = 15{,}2 \\text{ cm}\).</p>'

        . '<p><strong>Resenje:</strong></p>'

        . '<p>Pazljivo! Dat nam je <strong>precnik</strong>, a u formuli nam treba <strong>poluprecnik</strong>. Zato prvo delimo precnik sa 2:</p>'

        . $this->m('r = \\frac{2r}{2} = \\frac{3{,}4}{2} = 1{,}7 \\text{ cm}')

        . '<p>Sada primenjujemo formulu:</p>'

        . $this->m('P = 2 \\cdot 1{,}7 \\cdot \\pi \\cdot (1{,}7 + 15{,}2)')
        . $this->m('P = 3{,}4\\pi \\cdot 16{,}9')
        . $this->m('P = 57{,}46\\pi \\text{ cm}^2')
        . $this->m('P \\approx 57{,}46 \\cdot 3{,}14 \\approx 180{,}42 \\text{ cm}^2')

        . '<h3>Primer 3 - Nalazenje visine iz poznate povrsine</h3>'

        . '<p>Poluprecnik osnove valjka je \(r = 5 \\text{ cm}\), a povrsina je \(P = 100\\pi \\text{ cm}^2\). Odredi visinu valjka.</p>'

        . '<p><strong>Resenje:</strong></p>'

        . '<p>Krecemo od formule za povrsinu i u nju uvrstavamo poznate vrednosti:</p>'

        . $this->m('P = 2r\\pi(r + H)')
        . $this->m('100\\pi = 2 \\cdot 5 \\cdot \\pi \\cdot (5 + H)')
        . $this->m('100\\pi = 10\\pi(5 + H)')

        . '<p>Podelimo obe strane jednacine sa \(10\\pi\):</p>'

        . $this->m('\\frac{100\\pi}{10\\pi} = 5 + H')
        . $this->m('10 = 5 + H')
        . $this->m('H = 10 - 5 = 5 \\text{ cm}')

        . '<p>Visina valjka je \(H = 5 \\text{ cm}\). Primetimo da je u ovom slucaju \(2r = 10 \\text{ cm}\) i \(H = 5 \\text{ cm}\), pa osni presek <strong>nije</strong> kvadrat (jer \(2r \\neq H\)).</p>'

        . '<h3>Primer 4 - Valjak opisan oko pravilne cetvorostrane prizme</h3>'

        . '<p>Data je pravilna cetvorostrana prizma osnovne ivice \(a = 4 \\text{ cm}\) i visine \(H = 5\\sqrt{2} \\text{ cm}\). Odredi odnos povrsine valjka opisanog oko ove prizme i valjka upisanog u nju.</p>'

        . '<p>[slika - Kvadrat sa upisanim i opisanim krugom. Oznacen poluprecnik opisanog kruga R = a*sqrt(2)/2 i upisanog r = a/2]</p>'

        . '<p><strong>Resenje:</strong></p>'

        . '<p>Osnova prizme je kvadrat stranice \(a = 4 \\text{ cm}\).</p>'

        . '<p><strong>Opisani valjak</strong> ima poluprecnik jednak poluprecniku <strong>opisanog kruga kvadrata</strong> (to je poluijagonala kvadrata):</p>'

        . $this->m('R = \\frac{a\\sqrt{2}}{2} = \\frac{4\\sqrt{2}}{2} = 2\\sqrt{2} \\text{ cm}')

        . '<p>Njegova povrsina je:</p>'

        . $this->m('P_o = 2R\\pi(R + H) = 2 \\cdot 2\\sqrt{2} \\cdot \\pi \\cdot (2\\sqrt{2} + 5\\sqrt{2})')
        . $this->m('P_o = 4\\sqrt{2}\\pi \\cdot 7\\sqrt{2} = 4\\sqrt{2} \\cdot 7\\sqrt{2} \\cdot \\pi = 56\\pi \\text{ cm}^2')

        . '<p><strong>Upisani valjak</strong> ima poluprecnik jednak poluprecniku <strong>upisanog kruga kvadrata</strong> (to je polovina stranice kvadrata):</p>'

        . $this->m('r = \\frac{a}{2} = \\frac{4}{2} = 2 \\text{ cm}')

        . '<p>Njegova povrsina je:</p>'

        . $this->m('P_u = 2r\\pi(r + H) = 2 \\cdot 2 \\cdot \\pi \\cdot (2 + 5\\sqrt{2}) = 4\\pi(2 + 5\\sqrt{2}) \\text{ cm}^2')

        . '<p>Odnos povrsina:</p>'

        . $this->m('\\frac{P_o}{P_u} = \\frac{56\\pi}{4\\pi(2 + 5\\sqrt{2})} = \\frac{14}{2 + 5\\sqrt{2}} \\approx 1{,}5')

        . '<h3>Tabela formula</h3>'
        . '<table>'
        . '<thead><tr><th>Sta racunamo</th><th>Formula</th></tr></thead>'
        . '<tbody>'
        . '<tr><td>Povrsina jedne baze</td><td>\(B = r^2\\pi\)</td></tr>'
        . '<tr><td>Povrsina omotaca</td><td>\(M = 2r\\pi H\)</td></tr>'
        . '<tr><td>Ukupna povrsina valjka</td><td>\(P = 2r\\pi(r + H)\)</td></tr>'
        . '</tbody>'
        . '</table>';

        $this->createLesson($course, $sub, 4, 'Povrsina valjka', $content4);

        // ============================================================
        // LEKCIJA 5: Zapremina valjka
        // ============================================================
        $content5 = '<h2>Zapremina valjka</h2>'

        . '<p>Zapremina nam govori koliko prostora zauzima neko telo. Na primer, koliko vode moze da stane u casu, ili koliko goriva staje u rezervoar cisterne - to je zapremina!</p>'

        . '<h3>Veza valjka i prizme</h3>'

        . '<p>Secate se formule za zapreminu prizme?</p>'

        . $this->m('V_{\\text{prizme}} = B \\cdot H')

        . '<p>gde je \(B\) povrsina osnove, a \(H\) visina prizme.</p>'

        . '<p>Valjak i prizma su <strong>veoma srodna</strong> geometrijska tela! Setimo se da su pravilni mnogouglovi upisani u krug sve blizi tom krugu kako povecavamo broj stranica. Zamislite: trougao upisan u krug, pa kvadrat, pa sestougao, pa dvanaestougao... Sto vise stranica, to vise lici na krug!</p>'

        . '<p>[slika - Niz slika: trougaona prizma, cetvorostrana prizma, sestostrana prizma, dvanaestostrana prizma, i na kraju valjak. Strelice izmedju njih pokazuju "evoluciju" ka valjku]</p>'

        . '<p>Isto tako, pravilne prizme cije su osnove ti mnogouglovi sve su blize valjku. Zato <strong>ista formula</strong> vazi i za valjak!</p>'

        . '<h3>Formula za zapreminu valjka</h3>'

        . '<p>Povrsina osnove valjka (kruga) je \(B = r^2\\pi\). Zamenjujemo u opstu formulu \(V = B \\cdot H\):</p>'

        . $this->m('V = B \\cdot H = r^2\\pi \\cdot H')

        . '<blockquote><p><strong>Formula za zapreminu valjka:</strong></p>'
        . $this->m('V = r^2\\pi H')
        . '<p>gde je \(r\) poluprecnik osnove, a \(H\) visina valjka.</p></blockquote>'

        . '<h3>Primer 1</h3>'

        . '<p>Izracunaj zapreminu valjka ako je poluprecnik osnove \(r = 3 \\text{ cm}\), a visina \(H = 5{,}5 \\text{ cm}\).</p>'

        . '<p><strong>Resenje:</strong></p>'

        . '<p>Uvrstavamo u formulu:</p>'

        . $this->m('V = r^2\\pi H')
        . $this->m('V = 3^2 \\cdot \\pi \\cdot 5{,}5')
        . $this->m('V = 9 \\cdot 5{,}5 \\cdot \\pi')
        . $this->m('V = 49{,}5\\pi \\text{ cm}^3')

        . '<p>Priblizna vrednost (\(\\pi \\approx 3{,}14\)):</p>'

        . $this->m('V \\approx 49{,}5 \\cdot 3{,}14 \\approx 155{,}43 \\text{ cm}^3')

        . '<h3>Primer 2</h3>'

        . '<p>Izracunaj zapreminu valjka ako je <strong>precnik</strong> osnove \(2r = 3{,}4 \\text{ cm}\), a visina \(H = 5{,}2 \\text{ cm}\).</p>'

        . '<p><strong>Resenje:</strong></p>'

        . '<p>Prvo nalazimo poluprecnik:</p>'

        . $this->m('r = \\frac{3{,}4}{2} = 1{,}7 \\text{ cm}')

        . '<p>Zatim racunamo zapreminu:</p>'

        . $this->m('V = r^2\\pi H = 1{,}7^2 \\cdot \\pi \\cdot 5{,}2')
        . $this->m('V = 2{,}89 \\cdot 5{,}2 \\cdot \\pi')
        . $this->m('V = 15{,}028\\pi \\text{ cm}^3')
        . $this->m('V \\approx 15{,}028 \\cdot 3{,}14 \\approx 47{,}19 \\text{ cm}^3')

        . '<h3>Primer 3 - Koji valjak ima vecu zapreminu?</h3>'

        . '<p>Pravougaonik cije su stranice \(9{,}42 \\text{ cm}\) i \(12{,}56 \\text{ cm}\) savijen je u cilindricnu povrs na dva nacina. Prvi put je savijen duz duze stranice (dobijamo crveni valjak), a drugi put duz krace stranice (dobijamo zeleni valjak). Koji valjak ima vecu zapreminu?</p>'

        . '<p>[slika - Pravougaonik 9,42 x 12,56 cm sa dve strelice: crvena pokazuje savijanje duz duze stranice, zelena duz krace. Pored toga dva valjka razlicitih proporcija]</p>'

        . '<p><strong>Resenje:</strong></p>'

        . '<p><strong>Crveni valjak</strong> (savijen duz duze stranice \(12{,}56 \\text{ cm}\)):</p>'
        . '<p>Obim osnove je \(12{,}56 \\text{ cm}\), visina je \(H_c = 9{,}42 \\text{ cm}\). Nalazimo poluprecnik iz obima:</p>'

        . $this->m('2r_c\\pi = 12{,}56 \\implies r_c = \\frac{12{,}56}{2\\pi} \\approx 2 \\text{ cm}')

        . '<p>Zapremina crvenog valjka:</p>'

        . $this->m('V_c = r_c^2 \\pi H_c = 2^2 \\cdot \\pi \\cdot 9{,}42 = 4 \\cdot 9{,}42 \\cdot \\pi \\approx 37{,}68\\pi \\text{ cm}^3')

        . '<p><strong>Zeleni valjak</strong> (savijen duz krace stranice \(9{,}42 \\text{ cm}\)):</p>'
        . '<p>Obim osnove je \(9{,}42 \\text{ cm}\), visina je \(H_z = 12{,}56 \\text{ cm}\). Nalazimo poluprecnik:</p>'

        . $this->m('2r_z\\pi = 9{,}42 \\implies r_z = \\frac{9{,}42}{2\\pi} \\approx 1{,}5 \\text{ cm}')

        . '<p>Zapremina zelenog valjka:</p>'

        . $this->m('V_z = r_z^2 \\pi H_z = 1{,}5^2 \\cdot \\pi \\cdot 12{,}56 = 2{,}25 \\cdot 12{,}56 \\cdot \\pi \\approx 28{,}26\\pi \\text{ cm}^3')

        . '<p>Poredimo: \(37{,}68\\pi > 28{,}26\\pi\), dakle <strong>crveni valjak</strong> ima vecu zapreminu!</p>'

        . '<blockquote><p><strong>Zakljucak:</strong> Isti pravougaonik daje valjke razlicitih zapremina zavisno od toga kako ga savijemo. Veci poluprecnik daje vecu zapreminu jer poluprecnik ulazi u formulu na kvadrat (\(r^2\)) - zato vise "vredi" imati siri valjak nego visi.</p></blockquote>'

        . '<h3>Primer 4 - Odnos zapremina opisanog i upisanog valjka</h3>'

        . '<p>Data je pravilna cetvorostrana prizma osnovne ivice \(a = 6 \\text{ cm}\) i visine \(H = 9 \\text{ cm}\). Odredi odnos zapremina valjka opisanog oko ove prizme i valjka upisanog u nju.</p>'

        . '<p><strong>Resenje:</strong></p>'

        . '<p>Poluprecnik opisanog valjka (poluijagonala kvadrata):</p>'
        . $this->m('R = \\frac{a\\sqrt{2}}{2} = \\frac{6\\sqrt{2}}{2} = 3\\sqrt{2} \\text{ cm}')

        . '<p>Poluprecnik upisanog valjka (polovina stranice kvadrata):</p>'
        . $this->m('r = \\frac{a}{2} = \\frac{6}{2} = 3 \\text{ cm}')

        . '<p>Odnos zapremina (oba valjka imaju istu visinu \(H\), pa se \(\\pi H\) skrati):</p>'
        . $this->m('\\frac{V_o}{V_u} = \\frac{R^2 \\pi H}{r^2 \\pi H} = \\frac{R^2}{r^2} = \\frac{(3\\sqrt{2})^2}{3^2} = \\frac{9 \\cdot 2}{9} = \\frac{18}{9} = 2')

        . '<p>Valjak opisan oko prizme ima <strong>tacno duplo vecu</strong> zapreminu od valjka upisanog u istu prizmu!</p>'

        . '<h3>Tabela formula</h3>'
        . '<table>'
        . '<thead><tr><th>Velicina</th><th>Formula</th></tr></thead>'
        . '<tbody>'
        . '<tr><td>Zapremina valjka</td><td>\(V = r^2\\pi H\)</td></tr>'
        . '<tr><td>Zapremina preko povrsine osnove</td><td>\(V = B \\cdot H\)</td></tr>'
        . '</tbody>'
        . '</table>';

        $this->createLesson($course, $sub, 5, 'Zapremina valjka', $content5);

        // ============================================================
        // LEKCIJA 6: Zadaci za vezbanje (domaci)
        // ============================================================
        $content6 = '<h2>Zadaci za vezbanje - Valjak</h2>'

        . '<p>Resi sledece zadatke u svesci. Svaki zadatak resi korak po korak: zapisi sta je dato, sta se trazi, napravi crtez, primeni odgovarajucu formulu i izracunaj.</p>'

        . '<hr>'

        . '<h3>Zadatak 1</h3>'
        . '<p>Stranice pravougaonika su \(a = 5 \\text{ cm}\) i \(b = 7 \\text{ cm}\). Odredi povrsinu valjka koji nastaje rotacijom ovog pravougaonika:</p>'
        . '<p>a) oko stranice \(b\) (tada je \(r = a = 5 \\text{ cm}\), \(H = b = 7 \\text{ cm}\))</p>'
        . '<p>b) oko stranice \(a\) (tada je \(r = b = 7 \\text{ cm}\), \(H = a = 5 \\text{ cm}\))</p>'

        . '<p>[slika - Pravougaonik ABCD sa oznacenim stranicama a=5 i b=7. Dve strelice rotacije: jedna oko stranice b, druga oko stranice a]</p>'

        . '<hr>'

        . '<h3>Zadatak 2</h3>'
        . '<p>Kvadrat povrsine \(12 \\text{ cm}^2\) rotira oko jedne svoje stranice. Odredi povrsinu valjka koji se na ovaj nacin dobija.</p>'
        . '<p><em>Pomoc: Prvo odredi stranicu kvadrata iz \(a^2 = 12\), pa je \(a = 2\\sqrt{3} \\text{ cm}\). Zatim primeni formulu za povrsinu valjka gde je \(r = a\) i \(H = a\).</em></p>'

        . '<hr>'

        . '<h3>Zadatak 3</h3>'
        . '<p>Osni presek valjka visine \(H = 35 \\text{ cm}\) je pravougaonik cija je dijagonala \(d = 37 \\text{ cm}\). Odredi poluprecnik osnove valjka.</p>'
        . '<p><em>Pomoc: Primeni Pitagorinu teoremu: \((2r)^2 + H^2 = d^2\).</em></p>'

        . '<hr>'

        . '<h3>Zadatak 4</h3>'
        . '<p>Izracunaj zapreminu valjka ako je precnik osnove \(2r = 3{,}4 \\text{ cm}\), a visina \(H = 5{,}2 \\text{ cm}\). Rezultat izrazi u obliku \(\\ldots\\pi \\text{ cm}^3\) i priblizno (za \(\\pi \\approx 3{,}14\)).</p>'

        . '<hr>'

        . '<h3>Zadatak 5</h3>'
        . '<p>Stranice pravougaonika su \(a = 2 \\text{ cm}\) i \(b = 2{,}4 \\text{ cm}\). Odredi zapreminu valjka koji nastaje rotacijom ovog pravougaonika:</p>'
        . '<p>a) oko stranice \(b\)</p>'
        . '<p>b) oko stranice \(a\)</p>'
        . '<p>c) Koji od dva valjka ima vecu zapreminu i zasto?</p>'

        . '<hr>'

        . '<h3>Zadatak 6</h3>'
        . '<p>Odredi visinu valjka ako je poluprecnik osnove \(r = 5 \\text{ cm}\), a njegova povrsina \(P = 100\\pi \\text{ cm}^2\).</p>'

        . '<hr>'

        . '<h3>Zadatak 7</h3>'
        . '<p>Konzerve u obliku valjka precnika osnove \(7 \\text{ cm}\) i visine \(3 \\text{ cm}\) pakovane su po tri u red, jedna do druge. Odredi povrsinu folije koja obavija tri konzerve.</p>'
        . '<p>[slika - Tri konzerve (valjka) stoje jedna do druge u redu, obavijene folijom. Dimenzije: precnik 7 cm, visina 3 cm]</p>'
        . '<p><em>Pomoc: Posmatraj oblik folije odozgo - obavija tri kruga u nizu. Sirina folije je \(3 \\cdot 7 = 21 \\text{ cm}\), a za zaobljenost na krajevima dodaj obim jednog kruga.</em></p>'

        . '<hr>'

        . '<h3>Zadatak 8 (tezi)</h3>'
        . '<p>Data je pravilna trostrana prizma osnovne ivice \(a = 3 \\text{ cm}\) i visine \(H = 5 \\text{ cm}\). Odredi odnos povrsina valjka opisanog oko ove prizme i valjka upisanog u nju.</p>'
        . '<p><em>Pomoc: Za jednakostranicni trougao stranice \(a\): poluprecnik opisanog kruga je \(R = \\frac{a\\sqrt{3}}{3}\), a upisanog \(r = \\frac{a\\sqrt{3}}{6}\).</em></p>';

        $this->createLesson($course, $sub, 6, 'Zadaci za vezbanje', $content6, true);

        $this->command->info('Kurs "Matematika 8" kreiran sa glavom "Valjak" i 6 lekcija.');
    }
}
