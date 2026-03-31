<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\School;
use App\Models\Subchapter;
use Illuminate\Database\Seeder;

class Matematika8PovrsZadaciSeeder extends Seeder
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
        $school = School::where('name', 'like', '%Zarko%')->firstOrFail();

        $course = Course::where('school_id', $school->id)
            ->where('name', 'Matematika 8')
            ->firstOrFail();

        $chapter = Chapter::where('course_id', $course->id)
            ->where('title', 'Valjak')
            ->firstOrFail();

        $sub = Subchapter::create([
            'chapter_id' => $chapter->id,
            'title' => 'Povrsina valjka - Zadaci zbirka',
            'order' => 2,
        ]);

        // ============================================================
        // ZADATAK 11, str. 131
        // ============================================================
        $content11 = '<h3>Zadatak 11</h3>'

        . '<p>Povrsina osnove valjka je \(20\pi \text{ cm}^2\), a povrsina omotaca je \(60\pi \text{ cm}^2\). Izracunaj povrsinu valjka.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Povrsina osnove: \(B = 20\pi \text{ cm}^2\)</li>'
        . '<li>Povrsina omotaca: \(M = 60\pi \text{ cm}^2\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Povrsina valjka \(P = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Valjak ima dve osnove i omotac, pa koristimo formulu:</p>'
        . $this->m('P = 2B + M')
        . '<p>Zamenjujemo poznate vrednosti:</p>'
        . $this->m('P = 2 \cdot 20\pi + 60\pi')
        . $this->m('P = 40\pi + 60\pi')
        . $this->m('P = 100\pi \text{ cm}^2')

        . '<p><strong>Odgovor: Povrsina valjka je \(100\pi \text{ cm}^2\).</strong></p>';

        $this->createLesson($course, $sub, 1, 'Zadatak 11, str. 131', $content11);

        // ============================================================
        // ZADATAK 12, str. 131
        // ============================================================
        $content12 = '<h3>Zadatak 12</h3>'

        . '<p>Povrsina valjka je \(260\pi \text{ cm}^2\), a povrsina omotaca je \(140\pi \text{ cm}^2\). Izracunaj povrsinu osnove.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Povrsina valjka: \(P = 260\pi \text{ cm}^2\)</li>'
        . '<li>Povrsina omotaca: \(M = 140\pi \text{ cm}^2\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Povrsina osnove \(B = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Znamo da je povrsina valjka:</p>'
        . $this->m('P = 2B + M')
        . '<p>Zamenjujemo poznate vrednosti:</p>'
        . $this->m('260\pi = 2B + 140\pi')
        . '<p>Prebacimo \(140\pi\) na levu stranu:</p>'
        . $this->m('2B = 260\pi - 140\pi')
        . $this->m('2B = 120\pi')
        . '<p>Podelimo obe strane sa 2:</p>'
        . $this->m('B = 60\pi \text{ cm}^2')

        . '<p><strong>Odgovor: Povrsina osnove valjka je \(60\pi \text{ cm}^2\).</strong></p>';

        $this->createLesson($course, $sub, 2, 'Zadatak 12, str. 131', $content12);

        // ============================================================
        // ZADATAK 13, str. 132
        // ============================================================
        $content13 = '<h3>Zadatak 13</h3>'

        . '<p>Izracunaj povrsinu valjka ako je:</p>'
        . '<p>a) poluprecnik osnove \(r = 4 \text{ cm}\), visina \(H = 7 \text{ cm}\)</p>'
        . '<p>b) precnik osnove \(d = 5 \text{ cm}\), visina \(H = 2 \text{ cm}\)</p>'

        . '<h4>Resenje a)</h4>'
        . '<p><strong>Dato:</strong> \(r = 4 \text{ cm}\), \(H = 7 \text{ cm}\)</p>'
        . '<p>Koristimo formulu za povrsinu valjka:</p>'
        . $this->m('P = 2r\pi(r + H)')
        . '<p>Zamenjujemo:</p>'
        . $this->m('P = 2 \cdot 4 \cdot \pi \cdot (4 + 7)')
        . $this->m('P = 8\pi \cdot 11')
        . $this->m('P = 88\pi \text{ cm}^2')

        . '<h4>Resenje b)</h4>'
        . '<p><strong>Dato:</strong> \(d = 5 \text{ cm}\), \(H = 2 \text{ cm}\)</p>'
        . '<p>Prvo nalazimo poluprecnik:</p>'
        . $this->m('r = \frac{d}{2} = \frac{5}{2} = 2{,}5 \text{ cm}')
        . '<p>Sada racunamo povrsinu:</p>'
        . $this->m('P = 2r\pi(r + H)')
        . $this->m('P = 2 \cdot 2{,}5 \cdot \pi \cdot (2{,}5 + 2)')
        . $this->m('P = 5\pi \cdot 4{,}5')
        . $this->m('P = 22{,}5\pi \text{ cm}^2')

        . '<p><strong>Odgovor: a) \(P = 88\pi \text{ cm}^2\); b) \(P = 22{,}5\pi \text{ cm}^2\).</strong></p>';

        $this->createLesson($course, $sub, 3, 'Zadatak 13, str. 132', $content13);

        // ============================================================
        // ZADATAK 14, str. 132
        // ============================================================
        $content14 = '<h3>Zadatak 14</h3>'

        . '<p>Visina valjka je \(H = 6 \text{ cm}\). Izracunaj povrsinu valjka ako je poluprecnik osnove:</p>'
        . '<p>a) dva puta veci od visine</p>'
        . '<p>b) za 2 cm manji od visine</p>'

        . '<h4>Resenje a)</h4>'
        . '<p>Poluprecnik je dva puta veci od visine:</p>'
        . $this->m('r = 2 \cdot H = 2 \cdot 6 = 12 \text{ cm}')
        . '<p>Racunamo povrsinu:</p>'
        . $this->m('P = 2r\pi(r + H)')
        . $this->m('P = 2 \cdot 12 \cdot \pi \cdot (12 + 6)')
        . $this->m('P = 24\pi \cdot 18')
        . $this->m('P = 432\pi \text{ cm}^2')

        . '<h4>Resenje b)</h4>'
        . '<p>Poluprecnik je za 2 cm manji od visine:</p>'
        . $this->m('r = H - 2 = 6 - 2 = 4 \text{ cm}')
        . '<p>Racunamo povrsinu:</p>'
        . $this->m('P = 2r\pi(r + H)')
        . $this->m('P = 2 \cdot 4 \cdot \pi \cdot (4 + 6)')
        . $this->m('P = 8\pi \cdot 10')
        . $this->m('P = 80\pi \text{ cm}^2')

        . '<p><strong>Odgovor: a) \(P = 432\pi \text{ cm}^2\); b) \(P = 80\pi \text{ cm}^2\).</strong></p>';

        $this->createLesson($course, $sub, 4, 'Zadatak 14, str. 132', $content14);

        // ============================================================
        // ZADATAK 15, str. 132
        // ============================================================
        $content15 = '<h3>Zadatak 15</h3>'

        . '<p>Obim osnove valjka je \(12\pi \text{ cm}\). Izracunaj povrsinu valjka ako je visina \(H = 4 \text{ cm}\).</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Obim osnove: \(O = 2r\pi = 12\pi \text{ cm}\)</li>'
        . '<li>Visina: \(H = 4 \text{ cm}\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Povrsina valjka \(P = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Iz obima nalazimo poluprecnik:</p>'
        . $this->m('2r\pi = 12\pi')
        . $this->m('r = 6 \text{ cm}')
        . '<p>Sada racunamo povrsinu:</p>'
        . $this->m('P = 2r\pi(r + H)')
        . $this->m('P = 2 \cdot 6 \cdot \pi \cdot (6 + 4)')
        . $this->m('P = 12\pi \cdot 10')
        . $this->m('P = 120\pi \text{ cm}^2')

        . '<p><strong>Odgovor: Povrsina valjka je \(120\pi \text{ cm}^2\).</strong></p>';

        $this->createLesson($course, $sub, 5, 'Zadatak 15, str. 132', $content15);

        // ============================================================
        // ZADATAK 16, str. 132
        // ============================================================
        $content16 = '<h3>Zadatak 16</h3>'

        . '<p>Povrsina osnove valjka je \(9\pi \text{ cm}^2\). Izracunaj povrsinu valjka ako je visina \(H = 3 \text{ cm}\).</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Povrsina osnove: \(B = r^2\pi = 9\pi \text{ cm}^2\)</li>'
        . '<li>Visina: \(H = 3 \text{ cm}\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Povrsina valjka \(P = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Iz povrsine osnove nalazimo poluprecnik:</p>'
        . $this->m('r^2\pi = 9\pi')
        . $this->m('r^2 = 9')
        . $this->m('r = 3 \text{ cm}')
        . '<p>Sada racunamo povrsinu valjka:</p>'
        . $this->m('P = 2r\pi(r + H)')
        . $this->m('P = 2 \cdot 3 \cdot \pi \cdot (3 + 3)')
        . $this->m('P = 6\pi \cdot 6')
        . $this->m('P = 36\pi \text{ cm}^2')

        . '<p><strong>Odgovor: Povrsina valjka je \(36\pi \text{ cm}^2\).</strong></p>';

        $this->createLesson($course, $sub, 6, 'Zadatak 16, str. 132', $content16);

        // ============================================================
        // ZADATAK 17, str. 132
        // ============================================================
        $content17 = '<h3>Zadatak 17</h3>'

        . '<p>Izracunaj povrsinu valjka ako je visina \(H = 6 \text{ cm}\), a dijagonala osnog preseka \(d = 10 \text{ cm}\).</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Visina: \(H = 6 \text{ cm}\)</li>'
        . '<li>Dijagonala osnog preseka: \(d = 10 \text{ cm}\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Povrsina valjka \(P = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Osni presek valjka je pravougaonik sa stranicama \(2r\) i \(H\). Dijagonala tog pravougaonika je \(d = 10\). Koristimo Pitagorinu teoremu:</p>'
        . $this->m('(2r)^2 + H^2 = d^2')
        . $this->m('(2r)^2 + 6^2 = 10^2')
        . $this->m('4r^2 + 36 = 100')
        . $this->m('4r^2 = 64')
        . $this->m('r^2 = 16')
        . $this->m('r = 4 \text{ cm}')
        . '<p>Sada racunamo povrsinu:</p>'
        . $this->m('P = 2r\pi(r + H)')
        . $this->m('P = 2 \cdot 4 \cdot \pi \cdot (4 + 6)')
        . $this->m('P = 8\pi \cdot 10')
        . $this->m('P = 80\pi \text{ cm}^2')

        . '<p><strong>Odgovor: Povrsina valjka je \(80\pi \text{ cm}^2\).</strong></p>';

        $this->createLesson($course, $sub, 7, 'Zadatak 17, str. 132', $content17);

        // ============================================================
        // ZADATAK 18, str. 132
        // ============================================================
        $content18 = '<h3>Zadatak 18</h3>'

        . '<p>Izracunaj visinu valjka ako mu je poluprecnik osnove \(r = 4 \text{ cm}\), a povrsina omotaca \(M = 24\pi \text{ cm}^2\).</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Poluprecnik: \(r = 4 \text{ cm}\)</li>'
        . '<li>Povrsina omotaca: \(M = 24\pi \text{ cm}^2\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Visina \(H = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Koristimo formulu za povrsinu omotaca:</p>'
        . $this->m('M = 2r\pi H')
        . '<p>Zamenjujemo poznate vrednosti:</p>'
        . $this->m('24\pi = 2 \cdot 4 \cdot \pi \cdot H')
        . $this->m('24\pi = 8\pi H')
        . '<p>Podelimo obe strane sa \(8\pi\):</p>'
        . $this->m('H = \frac{24\pi}{8\pi} = 3 \text{ cm}')

        . '<p><strong>Odgovor: Visina valjka je \(H = 3 \text{ cm}\).</strong></p>';

        $this->createLesson($course, $sub, 8, 'Zadatak 18, str. 132', $content18);

        // ============================================================
        // ZADATAK 19, str. 132
        // ============================================================
        $content19 = '<h3>Zadatak 19</h3>'

        . '<p>Povrsina valjka je \(84\pi \text{ cm}^2\), a povrsina omotaca je \(48\pi \text{ cm}^2\). Izracunaj poluprecnik osnove.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Povrsina valjka: \(P = 84\pi \text{ cm}^2\)</li>'
        . '<li>Povrsina omotaca: \(M = 48\pi \text{ cm}^2\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Poluprecnik \(r = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Iz formule za povrsinu valjka nalazimo povrsinu dveju osnova:</p>'
        . $this->m('P = 2B + M')
        . $this->m('2B = P - M = 84\pi - 48\pi = 36\pi')
        . '<p>Povrsina jedne osnove:</p>'
        . $this->m('B = 18\pi \text{ cm}^2')
        . '<p>Posto je \(B = r^2\pi\):</p>'
        . $this->m('r^2\pi = 18\pi')
        . $this->m('r^2 = 18')
        . $this->m('r = \sqrt{18} = \sqrt{9 \cdot 2} = 3\sqrt{2} \text{ cm}')

        . '<p><strong>Odgovor: Poluprecnik osnove je \(r = 3\sqrt{2} \text{ cm}\).</strong></p>';

        $this->createLesson($course, $sub, 9, 'Zadatak 19, str. 132', $content19);

        // ============================================================
        // ZADATAK 20, str. 132
        // ============================================================
        $content20 = '<h3>Zadatak 20</h3>'

        . '<p>Marketinska agencija treba da osmisli nalepnicu za konzervu u obliku valjka visine \(H = 15 \text{ cm}\) i poluprecnika \(r = 6 \text{ cm}\). Nalepnica pokriva omotac. Koliko papira je minimalno potrebno? (\(\pi \approx 3{,}14\))</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Visina: \(H = 15 \text{ cm}\)</li>'
        . '<li>Poluprecnik: \(r = 6 \text{ cm}\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Povrsina omotaca \(M = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Nalepnica pokriva samo omotac valjka, pa racunamo povrsinu omotaca:</p>'
        . $this->m('M = 2r\pi H')
        . $this->m('M = 2 \cdot 6 \cdot \pi \cdot 15')
        . $this->m('M = 180\pi')
        . '<p>Zamenjujemo \(\pi \approx 3{,}14\):</p>'
        . $this->m('M \approx 180 \cdot 3{,}14 = 565{,}2 \text{ cm}^2')

        . '<p><strong>Odgovor: Minimalno je potrebno \(565{,}2 \text{ cm}^2\) papira.</strong></p>';

        $this->createLesson($course, $sub, 10, 'Zadatak 20, str. 132', $content20);

        // ============================================================
        // ZADATAK 21, str. 132
        // ============================================================
        $content21 = '<h3>Zadatak 21</h3>'

        . '<p>Povrsina osnove valjka je \(25\pi \text{ cm}^2\). Izracunaj visinu i obim osnove ako je povrsina omotaca tri puta veca od povrsine osnove.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Povrsina osnove: \(B = 25\pi \text{ cm}^2\)</li>'
        . '<li>Povrsina omotaca: \(M = 3B\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Visina \(H = ?\)</li>'
        . '<li>Obim osnove \(O = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Iz povrsine osnove nalazimo poluprecnik:</p>'
        . $this->m('r^2\pi = 25\pi')
        . $this->m('r^2 = 25')
        . $this->m('r = 5 \text{ cm}')
        . '<p>Povrsina omotaca je tri puta veca od povrsine osnove:</p>'
        . $this->m('M = 3B = 3 \cdot 25\pi = 75\pi \text{ cm}^2')
        . '<p>Iz formule za omotac nalazimo visinu:</p>'
        . $this->m('M = 2r\pi H')
        . $this->m('75\pi = 2 \cdot 5 \cdot \pi \cdot H')
        . $this->m('75\pi = 10\pi H')
        . $this->m('H = \frac{75}{10} = 7{,}5 \text{ cm}')
        . '<p>Obim osnove:</p>'
        . $this->m('O = 2r\pi = 2 \cdot 5 \cdot \pi = 10\pi \text{ cm}')

        . '<p><strong>Odgovor: Visina je \(H = 7{,}5 \text{ cm}\), obim osnove je \(O = 10\pi \text{ cm}\).</strong></p>';

        $this->createLesson($course, $sub, 11, 'Zadatak 21, str. 132', $content21);

        // ============================================================
        // ZADATAK 22, str. 132
        // ============================================================
        $content22 = '<h3>Zadatak 22</h3>'

        . '<p>Povrsina valjka je \(192\pi \text{ cm}^2\). Izracunaj:</p>'
        . '<p>a) visinu, ako je poluprecnik \(r = 6 \text{ cm}\)</p>'
        . '<p>b) visinu, ako je povrsina osnove \(72\pi \text{ cm}^2\)</p>'
        . '<p>v) poluprecnik i visinu, ako je povrsina osnove jednaka povrsini omotaca</p>'

        . '<h4>Resenje a)</h4>'
        . '<p><strong>Dato:</strong> \(P = 192\pi\), \(r = 6\)</p>'
        . '<p>Koristimo formulu:</p>'
        . $this->m('P = 2r\pi(r + H)')
        . $this->m('192\pi = 2 \cdot 6 \cdot \pi \cdot (6 + H)')
        . $this->m('192\pi = 12\pi(6 + H)')
        . '<p>Podelimo sa \(12\pi\):</p>'
        . $this->m('16 = 6 + H')
        . $this->m('H = 10 \text{ cm}')

        . '<h4>Resenje b)</h4>'
        . '<p><strong>Dato:</strong> \(P = 192\pi\), \(B = 72\pi\)</p>'
        . '<p>Iz povrsine osnove nalazimo poluprecnik:</p>'
        . $this->m('r^2\pi = 72\pi')
        . $this->m('r^2 = 72')
        . $this->m('r = \sqrt{72} = 6\sqrt{2} \text{ cm}')
        . '<p>Zamenjujemo u formulu za povrsinu:</p>'
        . $this->m('192\pi = 2 \cdot 6\sqrt{2} \cdot \pi \cdot (6\sqrt{2} + H)')
        . $this->m('192\pi = 12\sqrt{2}\pi(6\sqrt{2} + H)')
        . '<p>Podelimo sa \(12\sqrt{2}\pi\):</p>'
        . $this->m('\frac{192}{12\sqrt{2}} = 6\sqrt{2} + H')
        . $this->m('\frac{16}{\sqrt{2}} = 6\sqrt{2} + H')
        . $this->m('8\sqrt{2} = 6\sqrt{2} + H')
        . $this->m('H = 8\sqrt{2} - 6\sqrt{2} = 2\sqrt{2} \text{ cm}')

        . '<h4>Resenje v)</h4>'
        . '<p><strong>Dato:</strong> \(P = 192\pi\), \(B = M\)</p>'
        . '<p>Ako je povrsina osnove jednaka povrsini omotaca:</p>'
        . $this->m('B = M')
        . $this->m('r^2\pi = 2r\pi H')
        . '<p>Podelimo sa \(r\pi\):</p>'
        . $this->m('r = 2H \quad \Rightarrow \quad H = \frac{r}{2}')
        . '<p>Zamenjujemo u formulu za povrsinu. Posto je \(P = 2B + M\) a \(B = M\), to je \(P = 3B\):</p>'
        . $this->m('P = 2B + M = 2B + B = 3B')

        . '<p>Ali mozemo koristiti i drugi pristup. Posto je \(r = 2H\), zamenjujemo u \(P = 2r\pi(r + H)\):</p>'
        . $this->m('192\pi = 2 \cdot 2H \cdot \pi \cdot (2H + H)')
        . $this->m('192\pi = 4H\pi \cdot 3H')
        . $this->m('192\pi = 12\pi H^2')
        . '<p>Podelimo sa \(12\pi\):</p>'
        . $this->m('H^2 = 16')
        . $this->m('H = 4 \text{ cm}')
        . '<p>Poluprecnik:</p>'
        . $this->m('r = 2H = 2 \cdot 4 = 8 \text{ cm}')

        . '<p><strong>Odgovor: a) \(H = 10 \text{ cm}\); b) \(H = 2\sqrt{2} \text{ cm}\); v) \(r = 8 \text{ cm}\), \(H = 4 \text{ cm}\).</strong></p>';

        $this->createLesson($course, $sub, 12, 'Zadatak 22, str. 132', $content22);

        // ============================================================
        // ZADATAK 23, str. 132
        // ============================================================
        $content23 = '<h3>Zadatak 23</h3>'

        . '<p>Povrsina omotaca valjka je \(24\pi \text{ cm}^2\), a visina je \(H = 12 \text{ cm}\). Izracunaj povrsinu valjka.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Povrsina omotaca: \(M = 24\pi \text{ cm}^2\)</li>'
        . '<li>Visina: \(H = 12 \text{ cm}\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Povrsina valjka \(P = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Iz formule za omotac nalazimo poluprecnik:</p>'
        . $this->m('M = 2r\pi H')
        . $this->m('24\pi = 2r\pi \cdot 12')
        . $this->m('24\pi = 24r\pi')
        . $this->m('r = 1 \text{ cm}')
        . '<p>Sada racunamo povrsinu valjka:</p>'
        . $this->m('P = 2r\pi(r + H)')
        . $this->m('P = 2 \cdot 1 \cdot \pi \cdot (1 + 12)')
        . $this->m('P = 2\pi \cdot 13')
        . $this->m('P = 26\pi \text{ cm}^2')

        . '<p><strong>Odgovor: Povrsina valjka je \(26\pi \text{ cm}^2\).</strong></p>';

        $this->createLesson($course, $sub, 13, 'Zadatak 23, str. 132', $content23);

        // ============================================================
        // ZADATAK 24, str. 132
        // ============================================================
        $content24 = '<h3>Zadatak 24</h3>'

        . '<p>Povrsina omotaca valjka je \(48\pi \text{ cm}^2\). Izracunaj povrsinu valjka ako je \(H = \frac{3}{2}r\).</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Povrsina omotaca: \(M = 48\pi \text{ cm}^2\)</li>'
        . '<li>Veza: \(H = \frac{3}{2}r\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Povrsina valjka \(P = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Zamenjujemo \(H = \frac{3}{2}r\) u formulu za omotac:</p>'
        . $this->m('M = 2r\pi H = 2r\pi \cdot \frac{3}{2}r = 3r^2\pi')
        . '<p>Zamenjujemo vrednost omotaca:</p>'
        . $this->m('3r^2\pi = 48\pi')
        . $this->m('r^2 = 16')
        . $this->m('r = 4 \text{ cm}')
        . '<p>Visina:</p>'
        . $this->m('H = \frac{3}{2} \cdot 4 = 6 \text{ cm}')
        . '<p>Racunamo povrsinu:</p>'
        . $this->m('P = 2r\pi(r + H)')
        . $this->m('P = 2 \cdot 4 \cdot \pi \cdot (4 + 6)')
        . $this->m('P = 8\pi \cdot 10')
        . $this->m('P = 80\pi \text{ cm}^2')

        . '<p><strong>Odgovor: Povrsina valjka je \(80\pi \text{ cm}^2\).</strong></p>';

        $this->createLesson($course, $sub, 14, 'Zadatak 24, str. 132', $content24);

        // ============================================================
        // ZADATAK 25, str. 132
        // ============================================================
        $content25 = '<h3>Zadatak 25</h3>'

        . '<p>Povrsina valjka je \(200\pi \text{ cm}^2\). Izracunaj visinu i precnik valjka ako je visina tri puta veca od poluprecnika.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Povrsina valjka: \(P = 200\pi \text{ cm}^2\)</li>'
        . '<li>Veza: \(H = 3r\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Visina \(H = ?\)</li>'
        . '<li>Precnik \(d = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Zamenjujemo \(H = 3r\) u formulu:</p>'
        . $this->m('P = 2r\pi(r + H) = 2r\pi(r + 3r) = 2r\pi \cdot 4r = 8r^2\pi')
        . '<p>Zamenjujemo vrednost povrsine:</p>'
        . $this->m('8r^2\pi = 200\pi')
        . $this->m('r^2 = 25')
        . $this->m('r = 5 \text{ cm}')
        . '<p>Precnik:</p>'
        . $this->m('d = 2r = 2 \cdot 5 = 10 \text{ cm}')
        . '<p>Visina:</p>'
        . $this->m('H = 3r = 3 \cdot 5 = 15 \text{ cm}')

        . '<p><strong>Odgovor: Precnik je \(d = 10 \text{ cm}\), visina je \(H = 15 \text{ cm}\).</strong></p>';

        $this->createLesson($course, $sub, 15, 'Zadatak 25, str. 132', $content25);

        // ============================================================
        // ZADATAK 26, str. 132
        // ============================================================
        $content26 = '<h3>Zadatak 26</h3>'

        . '<p>Osni presek valjka je kvadrat ciji je obim 20 cm. Izracunaj povrsinu valjka.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Osni presek je kvadrat</li>'
        . '<li>Obim kvadrata: \(O = 20 \text{ cm}\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Povrsina valjka \(P = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Osni presek valjka je pravougaonik sa stranicama \(2r\) i \(H\). Ako je osni presek kvadrat, znaci da je:</p>'
        . $this->m('2r = H')
        . '<p>Stranica kvadrata:</p>'
        . $this->m('a = \frac{O}{4} = \frac{20}{4} = 5 \text{ cm}')
        . '<p>Znaci \(2r = 5\) i \(H = 5\), pa je:</p>'
        . $this->m('r = 2{,}5 \text{ cm}, \quad H = 5 \text{ cm}')
        . '<p>Racunamo povrsinu:</p>'
        . $this->m('P = 2r\pi(r + H)')
        . $this->m('P = 2 \cdot 2{,}5 \cdot \pi \cdot (2{,}5 + 5)')
        . $this->m('P = 5\pi \cdot 7{,}5')
        . $this->m('P = 37{,}5\pi \text{ cm}^2')

        . '<p><strong>Odgovor: Povrsina valjka je \(37{,}5\pi \text{ cm}^2\).</strong></p>';

        $this->createLesson($course, $sub, 16, 'Zadatak 26, str. 132', $content26);

        // ============================================================
        // ZADATAK 27, str. 132
        // ============================================================
        $content27 = '<h3>Zadatak 27</h3>'

        . '<p>Povrsina valjka je \(288\pi \text{ cm}^2\). Izracunaj dijagonalu osnog preseka ako se visina i poluprecnik odnose kao \(3 : 1\).</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Povrsina valjka: \(P = 288\pi \text{ cm}^2\)</li>'
        . '<li>Odnos: \(H : r = 3 : 1\), tj. \(H = 3r\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Dijagonala osnog preseka \(d = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Zamenjujemo \(H = 3r\) u formulu:</p>'
        . $this->m('P = 2r\pi(r + H) = 2r\pi(r + 3r) = 8r^2\pi')
        . '<p>Zamenjujemo vrednost povrsine:</p>'
        . $this->m('8r^2\pi = 288\pi')
        . $this->m('r^2 = 36')
        . $this->m('r = 6 \text{ cm}')
        . '<p>Visina:</p>'
        . $this->m('H = 3 \cdot 6 = 18 \text{ cm}')
        . '<p>Osni presek je pravougaonik sa stranicama \(2r = 12\) i \(H = 18\). Dijagonalu racunamo Pitagorinom teoremom:</p>'
        . $this->m('d = \sqrt{(2r)^2 + H^2}')
        . $this->m('d = \sqrt{12^2 + 18^2}')
        . $this->m('d = \sqrt{144 + 324}')
        . $this->m('d = \sqrt{468}')
        . '<p>Pojednostavimo koren:</p>'
        . $this->m('468 = 4 \cdot 117 = 4 \cdot 9 \cdot 13 = 36 \cdot 13')
        . $this->m('d = \sqrt{36 \cdot 13} = 6\sqrt{13} \text{ cm}')

        . '<p><strong>Odgovor: Dijagonala osnog preseka je \(d = 6\sqrt{13} \text{ cm}\).</strong></p>';

        $this->createLesson($course, $sub, 17, 'Zadatak 27, str. 132', $content27);

        // ============================================================
        // ZADATAK 28, str. 132
        // ============================================================
        $content28 = '<h3>Zadatak 28</h3>'

        . '<p>Valjak je upisan u kocku cija je ivica \(a = 4 \text{ cm}\). Izracunaj razliku povrsina kocke i valjka.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Ivica kocke: \(a = 4 \text{ cm}\)</li>'
        . '<li>Valjak je upisan u kocku</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Razlika povrsina: \(P_{kocke} - P_{valjka} = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Kada je valjak upisan u kocku, osnove valjka su upisane u kvadratne strane kocke. Precnik osnove jednak je ivici kocke, a visina valjka jednaka je ivici kocke:</p>'
        . $this->m('2r = a = 4 \quad \Rightarrow \quad r = 2 \text{ cm}')
        . $this->m('H = a = 4 \text{ cm}')

        . '<p>Povrsina kocke (6 kvadratnih strana):</p>'
        . $this->m('P_{kocke} = 6a^2 = 6 \cdot 4^2 = 6 \cdot 16 = 96 \text{ cm}^2')

        . '<p>Povrsina valjka:</p>'
        . $this->m('P_{valjka} = 2r\pi(r + H)')
        . $this->m('P_{valjka} = 2 \cdot 2 \cdot \pi \cdot (2 + 4)')
        . $this->m('P_{valjka} = 4\pi \cdot 6')
        . $this->m('P_{valjka} = 24\pi \text{ cm}^2')

        . '<p>Razlika povrsina:</p>'
        . $this->m('P_{kocke} - P_{valjka} = 96 - 24\pi')
        . '<p>Mozemo izdvojiti zajednicki cinilac:</p>'
        . $this->m('96 - 24\pi = 24(4 - \pi) \text{ cm}^2')

        . '<p><strong>Odgovor: Razlika povrsina je \(24(4 - \pi) \text{ cm}^2\).</strong></p>';

        $this->createLesson($course, $sub, 18, 'Zadatak 28, str. 132', $content28);
    }
}
