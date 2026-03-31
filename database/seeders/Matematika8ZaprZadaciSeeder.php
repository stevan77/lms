<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\School;
use App\Models\Subchapter;
use Illuminate\Database\Seeder;

class Matematika8ZaprZadaciSeeder extends Seeder
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
            'title' => 'Zapremina valjka - Zadaci zbirka',
            'order' => 3,
        ]);

        // ============================================================
        // ZADATAK 29, str. 133
        // ============================================================
        $content29 = '<h3>Zadatak 29</h3>'

        . '<p>Povrsina osnove valjka je \(50 \text{ cm}^2\), a visina \(10 \text{ cm}\). Izracunaj zapreminu valjka.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Povrsina osnove: \(B = 50 \text{ cm}^2\)</li>'
        . '<li>Visina: \(H = 10 \text{ cm}\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Zapremina valjka \(V = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Zapremina valjka se racuna kao povrsina osnove puta visina:</p>'
        . $this->m('V = B \cdot H')
        . '<p>Zamenjujemo poznate vrednosti:</p>'
        . $this->m('V = 50 \cdot 10')
        . $this->m('V = 500 \text{ cm}^3')

        . '<p><strong>Odgovor: Zapremina valjka je \(500 \text{ cm}^3\).</strong></p>';

        $this->createLesson($course, $sub, 1, 'Zadatak 29, str. 133', $content29);

        // ============================================================
        // ZADATAK 30, str. 133
        // ============================================================
        $content30 = '<h3>Zadatak 30</h3>'

        . '<p>Povrsina osnove valjka je \(48 \text{ cm}^2\), a zapremina \(960 \text{ cm}^3\). Kolika je visina valjka?</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Povrsina osnove: \(B = 48 \text{ cm}^2\)</li>'
        . '<li>Zapremina: \(V = 960 \text{ cm}^3\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Visina valjka \(H = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Znamo da je zapremina valjka:</p>'
        . $this->m('V = B \cdot H')
        . '<p>Odavde izrazavamo visinu:</p>'
        . $this->m('H = \frac{V}{B}')
        . '<p>Zamenjujemo:</p>'
        . $this->m('H = \frac{960}{48}')
        . $this->m('H = 20 \text{ cm}')

        . '<p><strong>Odgovor: Visina valjka je \(20 \text{ cm}\).</strong></p>';

        $this->createLesson($course, $sub, 2, 'Zadatak 30, str. 133', $content30);

        // ============================================================
        // ZADATAK 31, str. 133
        // ============================================================
        $content31 = '<h3>Zadatak 31</h3>'

        . '<p>Izracunaj zapreminu valjka ako je:</p>'
        . '<p>a) poluprecnik osnove \(r = 5 \text{ cm}\), visina \(H = 12 \text{ cm}\)</p>'
        . '<p>b) precnik osnove \(d = 22 \text{ cm}\), visina jednaka poluprecniku osnove</p>'

        . '<h4>Resenje - deo a)</h4>'
        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>\(r = 5 \text{ cm}\)</li>'
        . '<li>\(H = 12 \text{ cm}\)</li>'
        . '</ul>'
        . '<p>Koristimo formulu za zapreminu valjka:</p>'
        . $this->m('V = r^2 \pi \cdot H')
        . '<p>Zamenjujemo:</p>'
        . $this->m('V = 5^2 \cdot \pi \cdot 12')
        . $this->m('V = 25 \cdot 12 \cdot \pi')
        . $this->m('V = 300\pi \text{ cm}^3')

        . '<h4>Resenje - deo b)</h4>'
        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Precnik: \(d = 22 \text{ cm}\), pa je \(r = 11 \text{ cm}\)</li>'
        . '<li>Visina jednaka poluprecniku: \(H = r = 11 \text{ cm}\)</li>'
        . '</ul>'
        . '<p>Racunamo zapreminu:</p>'
        . $this->m('V = r^2 \pi \cdot H')
        . $this->m('V = 11^2 \cdot \pi \cdot 11')
        . $this->m('V = 121 \cdot 11 \cdot \pi')
        . $this->m('V = 1331\pi \text{ cm}^3')

        . '<p><strong>Odgovor: a) \(V = 300\pi \text{ cm}^3\); b) \(V = 1331\pi \text{ cm}^3\).</strong></p>';

        $this->createLesson($course, $sub, 3, 'Zadatak 31, str. 133', $content31);

        // ============================================================
        // ZADATAK 32, str. 133
        // ============================================================
        $content32 = '<h3>Zadatak 32</h3>'

        . '<p>Zapremina valjka je \(135\pi \text{ cm}^3\), visina \(H = 5 \text{ cm}\). Izracunaj:</p>'
        . '<p>a) poluprecnik osnove</p>'
        . '<p>b) povrsinu omotaca</p>'
        . '<p>v) povrsinu valjka</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>\(V = 135\pi \text{ cm}^3\)</li>'
        . '<li>\(H = 5 \text{ cm}\)</li>'
        . '</ul>'

        . '<h4>Resenje - deo a) poluprecnik</h4>'
        . '<p>Krecemo od formule za zapreminu:</p>'
        . $this->m('V = r^2 \pi \cdot H')
        . '<p>Zamenjujemo poznate vrednosti:</p>'
        . $this->m('135\pi = r^2 \cdot \pi \cdot 5')
        . '<p>Skratimo \(\pi\) sa obe strane:</p>'
        . $this->m('135 = 5r^2')
        . '<p>Podelimo sa 5:</p>'
        . $this->m('r^2 = 27')
        . '<p>Korenujemo (rastavimo 27 = 9 \cdot 3):</p>'
        . $this->m('r = \sqrt{27} = \sqrt{9 \cdot 3} = 3\sqrt{3} \text{ cm}')

        . '<h4>Resenje - deo b) povrsina omotaca</h4>'
        . '<p>Formula za povrsinu omotaca:</p>'
        . $this->m('M = 2r\pi \cdot H')
        . '<p>Zamenjujemo \(r = 3\sqrt{3}\) i \(H = 5\):</p>'
        . $this->m('M = 2 \cdot 3\sqrt{3} \cdot \pi \cdot 5')
        . $this->m('M = 30\sqrt{3}\pi \text{ cm}^2')

        . '<h4>Resenje - deo v) povrsina valjka</h4>'
        . '<p>Formula za ukupnu povrsinu:</p>'
        . $this->m('P = 2r\pi(r + H)')
        . '<p>Zamenjujemo:</p>'
        . $this->m('P = 2 \cdot 3\sqrt{3} \cdot \pi \cdot (3\sqrt{3} + 5)')
        . $this->m('P = 6\sqrt{3}\pi \cdot (3\sqrt{3} + 5)')
        . '<p>Pomnozimo zagradu:</p>'
        . $this->m('P = 6\sqrt{3} \cdot 3\sqrt{3} \cdot \pi + 6\sqrt{3} \cdot 5 \cdot \pi')
        . $this->m('P = 6 \cdot 3 \cdot 3 \cdot \pi + 30\sqrt{3}\pi')
        . $this->m('P = 54\pi + 30\sqrt{3}\pi')
        . $this->m('P = 6(9 + 5\sqrt{3})\pi \text{ cm}^2')

        . '<p><strong>Odgovor: a) \(r = 3\sqrt{3} \text{ cm}\); b) \(M = 30\sqrt{3}\pi \text{ cm}^2\); v) \(P = 6(9 + 5\sqrt{3})\pi \text{ cm}^2\).</strong></p>';

        $this->createLesson($course, $sub, 4, 'Zadatak 32, str. 133', $content32);

        // ============================================================
        // ZADATAK 33, str. 133
        // ============================================================
        $content33 = '<h3>Zadatak 33</h3>'

        . '<p>Zapremina valjka je \(200\sqrt{2}\pi \text{ cm}^3\), precnik osnove \(20 \text{ cm}\). Izracunaj visinu valjka.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>\(V = 200\sqrt{2}\pi \text{ cm}^3\)</li>'
        . '<li>\(d = 20 \text{ cm}\), pa je \(r = 10 \text{ cm}\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Visina valjka \(H = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Koristimo formulu za zapreminu:</p>'
        . $this->m('V = r^2 \pi \cdot H')
        . '<p>Zamenjujemo:</p>'
        . $this->m('200\sqrt{2}\pi = 10^2 \cdot \pi \cdot H')
        . $this->m('200\sqrt{2}\pi = 100\pi \cdot H')
        . '<p>Skratimo \(\pi\) i podelimo sa 100:</p>'
        . $this->m('H = \frac{200\sqrt{2}}{100}')
        . $this->m('H = 2\sqrt{2} \text{ cm}')

        . '<p><strong>Odgovor: Visina valjka je \(2\sqrt{2} \text{ cm}\).</strong></p>';

        $this->createLesson($course, $sub, 5, 'Zadatak 33, str. 133', $content33);

        // ============================================================
        // ZADATAK 34, str. 133
        // ============================================================
        $content34 = '<h3>Zadatak 34</h3>'

        . '<p>Poluprecnik osnove valjka je \(2 \text{ cm}\), a povrsina omotaca \(4\pi \text{ cm}^2\). Izracunaj zapreminu valjka.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>\(r = 2 \text{ cm}\)</li>'
        . '<li>\(M = 4\pi \text{ cm}^2\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Zapremina \(V = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Prvo nadimo visinu iz formule za omotac:</p>'
        . $this->m('M = 2r\pi \cdot H')
        . $this->m('4\pi = 2 \cdot 2 \cdot \pi \cdot H')
        . $this->m('4\pi = 4\pi \cdot H')
        . '<p>Podelimo obe strane sa \(4\pi\):</p>'
        . $this->m('H = 1 \text{ cm}')
        . '<p>Sada racunamo zapreminu:</p>'
        . $this->m('V = r^2 \pi \cdot H')
        . $this->m('V = 4\pi \cdot 1')
        . $this->m('V = 4\pi \text{ cm}^3')

        . '<p><strong>Odgovor: Zapremina valjka je \(4\pi \text{ cm}^3\).</strong></p>';

        $this->createLesson($course, $sub, 6, 'Zadatak 34, str. 133', $content34);

        // ============================================================
        // ZADATAK 35, str. 133
        // ============================================================
        $content35 = '<h3>Zadatak 35</h3>'

        . '<p>Povrsina valjka je \(490\pi \text{ cm}^2\). Izracunaj zapreminu ako je:</p>'
        . '<p>a) \(r = 14 \text{ cm}\)</p>'
        . '<p>b) povrsina osnove \(49\pi \text{ cm}^2\)</p>'

        . '<h4>Resenje - deo a)</h4>'
        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>\(P = 490\pi \text{ cm}^2\)</li>'
        . '<li>\(r = 14 \text{ cm}\)</li>'
        . '</ul>'
        . '<p>Koristimo formulu za povrsinu valjka da nadjemo visinu:</p>'
        . $this->m('P = 2r\pi(r + H)')
        . $this->m('490\pi = 2 \cdot 14 \cdot \pi \cdot (14 + H)')
        . $this->m('490\pi = 28\pi(14 + H)')
        . '<p>Podelimo obe strane sa \(28\pi\):</p>'
        . $this->m('14 + H = \frac{490}{28} = 17{,}5')
        . $this->m('H = 17{,}5 - 14 = 3{,}5 \text{ cm}')
        . '<p>Sada racunamo zapreminu:</p>'
        . $this->m('V = r^2\pi \cdot H = 14^2 \cdot \pi \cdot 3{,}5')
        . $this->m('V = 196 \cdot 3{,}5 \cdot \pi')
        . $this->m('V = 686\pi \text{ cm}^3')

        . '<h4>Resenje - deo b)</h4>'
        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>\(P = 490\pi \text{ cm}^2\)</li>'
        . '<li>\(B = 49\pi \text{ cm}^2\)</li>'
        . '</ul>'
        . '<p>Iz povrsine osnove nalazimo poluprecnik:</p>'
        . $this->m('B = r^2\pi = 49\pi \Rightarrow r^2 = 49 \Rightarrow r = 7 \text{ cm}')
        . '<p>Sada iz povrsine valjka nalazimo visinu:</p>'
        . $this->m('P = 2r\pi(r + H)')
        . $this->m('490\pi = 2 \cdot 7 \cdot \pi \cdot (7 + H)')
        . $this->m('490\pi = 14\pi(7 + H)')
        . '<p>Podelimo sa \(14\pi\):</p>'
        . $this->m('7 + H = 35')
        . $this->m('H = 28 \text{ cm}')
        . '<p>Racunamo zapreminu:</p>'
        . $this->m('V = 49\pi \cdot 28 = 1372\pi \text{ cm}^3')

        . '<p><strong>Odgovor: a) \(V = 686\pi \text{ cm}^3\); b) \(V = 1372\pi \text{ cm}^3\).</strong></p>';

        $this->createLesson($course, $sub, 7, 'Zadatak 35, str. 133', $content35);

        // ============================================================
        // ZADATAK 36, str. 133
        // ============================================================
        $content36 = '<h3>Zadatak 36</h3>'

        . '<p>Visina valjka je \(8 \text{ cm}\), a dijagonala osnog preseka \(10 \text{ cm}\). Izracunaj povrsinu i zapreminu valjka.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>\(H = 8 \text{ cm}\)</li>'
        . '<li>Dijagonala osnog preseka: \(d = 10 \text{ cm}\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Povrsina \(P = ?\) i zapremina \(V = ?\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Osni presek valjka je pravougaonik sa stranicama \(2r\) i \(H\). Dijagonala tog pravougaonika je \(d = 10\).</p>'
        . '<p>Koristimo Pitagorinu teoremu:</p>'
        . $this->m('(2r)^2 + H^2 = d^2')
        . $this->m('(2r)^2 + 8^2 = 10^2')
        . $this->m('4r^2 + 64 = 100')
        . $this->m('4r^2 = 36')
        . $this->m('r^2 = 9')
        . $this->m('r = 3 \text{ cm}')

        . '<p>Sada racunamo povrsinu:</p>'
        . $this->m('P = 2r\pi(r + H) = 2 \cdot 3 \cdot \pi \cdot (3 + 8)')
        . $this->m('P = 6\pi \cdot 11 = 66\pi \text{ cm}^2')

        . '<p>I zapreminu:</p>'
        . $this->m('V = r^2\pi \cdot H = 9\pi \cdot 8 = 72\pi \text{ cm}^3')

        . '<p><strong>Odgovor: \(P = 66\pi \text{ cm}^2\), \(V = 72\pi \text{ cm}^3\).</strong></p>';

        $this->createLesson($course, $sub, 8, 'Zadatak 36, str. 133', $content36);

        // ============================================================
        // ZADATAK 37, str. 133
        // ============================================================
        $content37 = '<h3>Zadatak 37</h3>'

        . '<p>Osni presek valjka je kvadrat stranice \(6 \text{ cm}\). Izracunaj povrsinu i zapreminu valjka.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Osni presek je kvadrat sa stranicom \(a = 6 \text{ cm}\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Osni presek valjka je pravougaonik sa stranicama \(2r\) i \(H\). Ako je to kvadrat, onda je:</p>'
        . $this->m('2r = H = 6 \text{ cm}')
        . '<p>Odavde:</p>'
        . $this->m('r = 3 \text{ cm}, \quad H = 6 \text{ cm}')

        . '<p>Racunamo povrsinu:</p>'
        . $this->m('P = 2r\pi(r + H) = 2 \cdot 3 \cdot \pi \cdot (3 + 6)')
        . $this->m('P = 6\pi \cdot 9 = 54\pi \text{ cm}^2')

        . '<p>Racunamo zapreminu:</p>'
        . $this->m('V = r^2\pi \cdot H = 9\pi \cdot 6 = 54\pi \text{ cm}^3')

        . '<p><strong>Odgovor: \(P = 54\pi \text{ cm}^2\), \(V = 54\pi \text{ cm}^3\).</strong></p>';

        $this->createLesson($course, $sub, 9, 'Zadatak 37, str. 133', $content37);

        // ============================================================
        // ZADATAK 38, str. 133
        // ============================================================
        $content38 = '<h3>Zadatak 38</h3>'

        . '<p>Povrsina osnog preseka valjka je \(16 \text{ cm}^2\), a poluprecnik je dva puta veci od visine. Izracunaj povrsinu i zapreminu valjka.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Povrsina osnog preseka: \(S = 16 \text{ cm}^2\)</li>'
        . '<li>\(r = 2H\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Osni presek je pravougaonik sa stranicama \(2r\) i \(H\), pa je njegova povrsina:</p>'
        . $this->m('S = 2r \cdot H')
        . '<p>Posto je \(r = 2H\), zamenjujemo:</p>'
        . $this->m('S = 2 \cdot 2H \cdot H = 4H^2')
        . $this->m('4H^2 = 16')
        . $this->m('H^2 = 4')
        . $this->m('H = 2 \text{ cm}')
        . '<p>Poluprecnik je:</p>'
        . $this->m('r = 2H = 2 \cdot 2 = 4 \text{ cm}')

        . '<p>Racunamo povrsinu valjka:</p>'
        . $this->m('P = 2r\pi(r + H) = 2 \cdot 4 \cdot \pi \cdot (4 + 2)')
        . $this->m('P = 8\pi \cdot 6 = 48\pi \text{ cm}^2')

        . '<p>Racunamo zapreminu:</p>'
        . $this->m('V = r^2\pi \cdot H = 16\pi \cdot 2 = 32\pi \text{ cm}^3')

        . '<p><strong>Odgovor: \(P = 48\pi \text{ cm}^2\), \(V = 32\pi \text{ cm}^3\).</strong></p>';

        $this->createLesson($course, $sub, 10, 'Zadatak 38, str. 133', $content38);

        // ============================================================
        // ZADATAK 39, str. 133
        // ============================================================
        $content39 = '<h3>Zadatak 39</h3>'

        . '<p>Omotac valjka (kada se razvije) je kvadrat cija je:</p>'
        . '<p>a) stranica \(8 \text{ cm}\)</p>'
        . '<p>b) dijagonala \(10 \text{ cm}\)</p>'
        . '<p>Izracunaj povrsinu i zapreminu valjka.</p>'

        . '<h4>Resenje - deo a)</h4>'
        . '<p>Razvijeni omotac je pravougaonik sa stranicama \(H\) i \(2r\pi\). Ako je to kvadrat stranice 8:</p>'
        . $this->m('H = 8 \text{ cm}, \quad 2r\pi = 8')
        . '<p>Iz drugog uslova nalazimo poluprecnik:</p>'
        . $this->m('r = \frac{8}{2\pi} = \frac{4}{\pi} \text{ cm}')

        . '<p>Racunamo povrsinu:</p>'
        . $this->m('B = r^2\pi = \frac{16}{\pi^2} \cdot \pi = \frac{16}{\pi}')
        . $this->m('M = 8 \cdot 8 = 64 \text{ cm}^2')
        . $this->m('P = 2B + M = \frac{32}{\pi} + 64 = \frac{32 + 64\pi}{\pi} \text{ cm}^2')

        . '<p>Racunamo zapreminu:</p>'
        . $this->m('V = B \cdot H = \frac{16}{\pi} \cdot 8 = \frac{128}{\pi} \text{ cm}^3')

        . '<h4>Resenje - deo b)</h4>'
        . '<p>Dijagonala kvadrata je 10 cm, pa je stranica:</p>'
        . $this->m('a = \frac{d}{\sqrt{2}} = \frac{10}{\sqrt{2}} = 5\sqrt{2} \text{ cm}')
        . '<p>Znaci \(H = 5\sqrt{2}\) i \(2r\pi = 5\sqrt{2}\):</p>'
        . $this->m('r = \frac{5\sqrt{2}}{2\pi} \text{ cm}')

        . '<p>Racunamo povrsinu:</p>'
        . $this->m('B = r^2\pi = \frac{50}{4\pi^2} \cdot \pi = \frac{50}{4\pi} = \frac{25}{2\pi}')
        . $this->m('M = (5\sqrt{2})^2 = 50 \text{ cm}^2')
        . $this->m('P = 2B + M = \frac{25}{\pi} + 50 = \frac{25 + 50\pi}{\pi} \text{ cm}^2')

        . '<p>Racunamo zapreminu:</p>'
        . $this->m('V = B \cdot H = \frac{25}{2\pi} \cdot 5\sqrt{2} = \frac{125\sqrt{2}}{2\pi} \text{ cm}^3')

        . '<p><strong>Odgovor: a) \(P = \frac{32 + 64\pi}{\pi} \text{ cm}^2\), \(V = \frac{128}{\pi} \text{ cm}^3\); b) \(P = \frac{25 + 50\pi}{\pi} \text{ cm}^2\), \(V = \frac{125\sqrt{2}}{2\pi} \text{ cm}^3\).</strong></p>';

        $this->createLesson($course, $sub, 11, 'Zadatak 39, str. 133', $content39);

        // ============================================================
        // ZADATAK 40, str. 134
        // ============================================================
        $content40 = '<h3>Zadatak 40</h3>'

        . '<p>Omotac valjka je pravougaonik stranica \(31{,}4 \text{ cm}\) i \(12{,}56 \text{ cm}\). Koji valjak ima vecu zapreminu - onaj cija je visina kraca ili duza stranica? Koliki je odnos zapremina? (\(\pi \approx 3{,}14\))</p>'

        . '<h4>Resenje</h4>'
        . '<p><strong>Slucaj 1:</strong> Kraca stranica je visina: \(H = 12{,}56 \text{ cm}\), a obim osnove \(O = 31{,}4 \text{ cm}\).</p>'
        . $this->m('2r\pi = 31{,}4 \Rightarrow r = \frac{31{,}4}{2 \cdot 3{,}14} = 5 \text{ cm}')
        . $this->m('V_k = r^2\pi \cdot H = 25 \cdot 3{,}14 \cdot 12{,}56')
        . $this->m('V_k \approx 985{,}96 \text{ cm}^3')

        . '<p><strong>Slucaj 2:</strong> Duza stranica je visina: \(H = 31{,}4 \text{ cm}\), a obim osnove \(O = 12{,}56 \text{ cm}\).</p>'
        . $this->m('2r\pi = 12{,}56 \Rightarrow r = \frac{12{,}56}{2 \cdot 3{,}14} = 2 \text{ cm}')
        . $this->m('V_d = r^2\pi \cdot H = 4 \cdot 3{,}14 \cdot 31{,}4')
        . $this->m('V_d \approx 394{,}38 \text{ cm}^3')

        . '<p>Uporedjujemo:</p>'
        . $this->m('V_k > V_d')
        . $this->m('\frac{V_k}{V_d} = \frac{985{,}96}{394{,}38} = \frac{5}{2}')

        . '<p><strong>Odgovor: Vecu zapreminu ima valjak cija je visina kraca stranica. Odnos zapremina je \(\frac{5}{2}\).</strong></p>';

        $this->createLesson($course, $sub, 12, 'Zadatak 40, str. 134', $content40);

        // ============================================================
        // ZADATAK 41, str. 134
        // ============================================================
        $content41 = '<h3>Zadatak 41</h3>'

        . '<p>Kvadrat cija je povrsina \(32 \text{ cm}^2\) rotira oko jedne stranice. Izracunaj povrsinu i zapreminu nastalog valjka.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Povrsina kvadrata: \(a^2 = 32 \text{ cm}^2\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Nalazimo stranicu kvadrata:</p>'
        . $this->m('a = \sqrt{32} = \sqrt{16 \cdot 2} = 4\sqrt{2} \text{ cm}')
        . '<p>Kada kvadrat rotira oko jedne stranice, nastaje valjak gde je:</p>'
        . '<ul>'
        . '<li>Poluprecnik: \(r = a = 4\sqrt{2} \text{ cm}\)</li>'
        . '<li>Visina: \(H = a = 4\sqrt{2} \text{ cm}\)</li>'
        . '</ul>'

        . '<p>Racunamo povrsinu:</p>'
        . $this->m('P = 2r\pi(r + H) = 2 \cdot 4\sqrt{2} \cdot \pi \cdot (4\sqrt{2} + 4\sqrt{2})')
        . $this->m('P = 8\sqrt{2}\pi \cdot 8\sqrt{2}')
        . $this->m('P = 8 \cdot 8 \cdot 2 \cdot \pi = 128\pi \text{ cm}^2')

        . '<p>Racunamo zapreminu:</p>'
        . $this->m('V = r^2\pi \cdot H = (4\sqrt{2})^2 \cdot \pi \cdot 4\sqrt{2}')
        . $this->m('V = 32\pi \cdot 4\sqrt{2}')
        . $this->m('V = 128\sqrt{2}\pi \text{ cm}^3')

        . '<p><strong>Odgovor: \(P = 128\pi \text{ cm}^2\), \(V = 128\sqrt{2}\pi \text{ cm}^3\).</strong></p>';

        $this->createLesson($course, $sub, 13, 'Zadatak 41, str. 134', $content41);

        // ============================================================
        // ZADATAK 42, str. 134
        // ============================================================
        $content42 = '<h3>Zadatak 42</h3>'

        . '<p>Pravougaonik jedne stranice \(6 \text{ cm}\) i dijagonale \(10 \text{ cm}\) rotira oko:</p>'
        . '<p>a) krace stranice</p>'
        . '<p>b) duze stranice</p>'
        . '<p>Izracunaj povrsinu i zapreminu nastalog valjka.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Jedna stranica: \(a = 6 \text{ cm}\)</li>'
        . '<li>Dijagonala: \(d = 10 \text{ cm}\)</li>'
        . '</ul>'

        . '<h4>Nalazenje druge stranice</h4>'
        . '<p>Koristimo Pitagorinu teoremu:</p>'
        . $this->m('b = \sqrt{d^2 - a^2} = \sqrt{100 - 36} = \sqrt{64} = 8 \text{ cm}')
        . '<p>Dakle stranice pravougaonika su 6 cm (kraca) i 8 cm (duza).</p>'

        . '<h4>Resenje - deo a) rotacija oko krace stranice</h4>'
        . '<p>Oko krace stranice (6 cm): \(r = 8 \text{ cm}\), \(H = 6 \text{ cm}\)</p>'
        . $this->m('P = 2r\pi(r + H) = 2 \cdot 8 \cdot \pi \cdot (8 + 6)')
        . $this->m('P = 16\pi \cdot 14 = 224\pi \text{ cm}^2')
        . $this->m('V = r^2\pi \cdot H = 64\pi \cdot 6 = 384\pi \text{ cm}^3')

        . '<h4>Resenje - deo b) rotacija oko duze stranice</h4>'
        . '<p>Oko duze stranice (8 cm): \(r = 6 \text{ cm}\), \(H = 8 \text{ cm}\)</p>'
        . $this->m('P = 2r\pi(r + H) = 2 \cdot 6 \cdot \pi \cdot (6 + 8)')
        . $this->m('P = 12\pi \cdot 14 = 168\pi \text{ cm}^2')
        . $this->m('V = r^2\pi \cdot H = 36\pi \cdot 8 = 288\pi \text{ cm}^3')

        . '<p><strong>Odgovor: a) \(P = 224\pi \text{ cm}^2\), \(V = 384\pi \text{ cm}^3\); b) \(P = 168\pi \text{ cm}^2\), \(V = 288\pi \text{ cm}^3\).</strong></p>';

        $this->createLesson($course, $sub, 14, 'Zadatak 42, str. 134', $content42);

        // ============================================================
        // ZADATAK 43, str. 134
        // ============================================================
        $content43 = '<h3>Zadatak 43</h3>'

        . '<p>Poluprecnik osnove valjka je \(4 \text{ cm}\). Izracunaj povrsinu i zapreminu ako je ugao izmedju dijagonale osnog preseka i osnove:</p>'
        . '<p>a) \(60°\); b) \(45°\); v) \(30°\)</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>\(r = 4 \text{ cm}\), pa je \(2r = 8 \text{ cm}\)</li>'
        . '</ul>'

        . '<h4>Objasnjenje</h4>'
        . '<p>Osni presek je pravougaonik sa stranicama \(2r = 8\) i \(H\). Dijagonala tog pravougaonika zaklapa ugao \(\alpha\) sa osnovom (stranicom \(2r\)). Vazi:</p>'
        . $this->m('\tan \alpha = \frac{H}{2r} = \frac{H}{8}')

        . '<h4>Resenje - deo a) \(\alpha = 60°\)</h4>'
        . $this->m('H = 8 \cdot \tan 60° = 8\sqrt{3} \text{ cm}')
        . $this->m('P = 2r\pi(r + H) = 8\pi(4 + 8\sqrt{3}) = 32\pi(1 + 2\sqrt{3}) \text{ cm}^2')
        . $this->m('V = r^2\pi \cdot H = 16\pi \cdot 8\sqrt{3} = 128\sqrt{3}\pi \text{ cm}^3')

        . '<h4>Resenje - deo b) \(\alpha = 45°\)</h4>'
        . $this->m('H = 8 \cdot \tan 45° = 8 \cdot 1 = 8 \text{ cm}')
        . $this->m('P = 2 \cdot 4 \cdot \pi \cdot (4 + 8) = 8\pi \cdot 12 = 96\pi \text{ cm}^2')
        . $this->m('V = 16\pi \cdot 8 = 128\pi \text{ cm}^3')

        . '<h4>Resenje - deo v) \(\alpha = 30°\)</h4>'
        . $this->m('H = 8 \cdot \tan 30° = 8 \cdot \frac{\sqrt{3}}{3} = \frac{8\sqrt{3}}{3} \text{ cm}')
        . $this->m('P = 8\pi\left(4 + \frac{8\sqrt{3}}{3}\right) = 8\pi \cdot \frac{12 + 8\sqrt{3}}{3} = \frac{32\pi(3 + 2\sqrt{3})}{3} \text{ cm}^2')
        . $this->m('V = 16\pi \cdot \frac{8\sqrt{3}}{3} = \frac{128\sqrt{3}\pi}{3} \text{ cm}^3')

        . '<p><strong>Odgovor: a) \(P = 32\pi(1 + 2\sqrt{3}) \text{ cm}^2\), \(V = 128\sqrt{3}\pi \text{ cm}^3\); b) \(P = 96\pi \text{ cm}^2\), \(V = 128\pi \text{ cm}^3\); v) \(P = \frac{32\pi(3 + 2\sqrt{3})}{3} \text{ cm}^2\), \(V = \frac{128\sqrt{3}\pi}{3} \text{ cm}^3\).</strong></p>';

        $this->createLesson($course, $sub, 15, 'Zadatak 43, str. 134', $content43);

        // ============================================================
        // ZADATAK 44, str. 134
        // ============================================================
        $content44 = '<h3>Zadatak 44</h3>'

        . '<p>Dijagonala osnog preseka valjka je \(12 \text{ cm}\). Izracunaj povrsinu i zapreminu ako je ugao izmedju dijagonale i osnove:</p>'
        . '<p>a) \(30°\); b) \(45°\); v) \(60°\)</p>'

        . '<h4>Objasnjenje</h4>'
        . '<p>Dijagonala osnog preseka je \(d = 12\). Ako ugao izmedju dijagonale i osnove oznacimo sa \(\alpha\), onda:</p>'
        . $this->m('2r = d \cdot \cos\alpha = 12\cos\alpha, \quad H = d \cdot \sin\alpha = 12\sin\alpha')

        . '<h4>Resenje - deo a) \(\alpha = 30°\)</h4>'
        . $this->m('2r = 12\cos 30° = 12 \cdot \frac{\sqrt{3}}{2} = 6\sqrt{3} \Rightarrow r = 3\sqrt{3} \text{ cm}')
        . $this->m('H = 12\sin 30° = 12 \cdot \frac{1}{2} = 6 \text{ cm}')
        . $this->m('P = 2r\pi(r + H) = 6\sqrt{3}\pi(3\sqrt{3} + 6) = 6\sqrt{3}\pi \cdot 3(\sqrt{3} + 2)')
        . $this->m('P = 18\sqrt{3}(\sqrt{3} + 2)\pi = 18(3 + 2\sqrt{3})\pi \text{ cm}^2')
        . $this->m('V = r^2\pi \cdot H = 27\pi \cdot 6 = 162\pi \text{ cm}^3')

        . '<h4>Resenje - deo b) \(\alpha = 45°\)</h4>'
        . $this->m('2r = 12\cos 45° = 12 \cdot \frac{\sqrt{2}}{2} = 6\sqrt{2} \Rightarrow r = 3\sqrt{2} \text{ cm}')
        . $this->m('H = 12\sin 45° = 6\sqrt{2} \text{ cm}')
        . $this->m('P = 6\sqrt{2}\pi(3\sqrt{2} + 6\sqrt{2}) = 6\sqrt{2}\pi \cdot 9\sqrt{2} \cdot \text{...}')
        . '<p>Pojednostavimo:</p>'
        . $this->m('P = 2 \cdot 3\sqrt{2} \cdot \pi \cdot (3\sqrt{2} + 6\sqrt{2}) = 6\sqrt{2}\pi \cdot 9\sqrt{2} = 108\pi \text{ cm}^2')
        . $this->m('V = (3\sqrt{2})^2 \cdot \pi \cdot 6\sqrt{2} = 18\pi \cdot 6\sqrt{2} = 108\sqrt{2}\pi \text{ cm}^3')

        . '<h4>Resenje - deo v) \(\alpha = 60°\)</h4>'
        . $this->m('2r = 12\cos 60° = 12 \cdot \frac{1}{2} = 6 \Rightarrow r = 3 \text{ cm}')
        . $this->m('H = 12\sin 60° = 12 \cdot \frac{\sqrt{3}}{2} = 6\sqrt{3} \text{ cm}')
        . $this->m('P = 2 \cdot 3 \cdot \pi \cdot (3 + 6\sqrt{3}) = 6\pi(3 + 6\sqrt{3}) = 18\pi(1 + 2\sqrt{3}) \text{ cm}^2')
        . $this->m('V = 9\pi \cdot 6\sqrt{3} = 54\sqrt{3}\pi \text{ cm}^3')

        . '<p><strong>Odgovor: a) \(P = 18(3 + 2\sqrt{3})\pi \text{ cm}^2\), \(V = 162\pi \text{ cm}^3\); b) \(P = 108\pi \text{ cm}^2\), \(V = 108\sqrt{2}\pi \text{ cm}^3\); v) \(P = 18(1 + 2\sqrt{3})\pi \text{ cm}^2\), \(V = 54\sqrt{3}\pi \text{ cm}^3\).</strong></p>';

        $this->createLesson($course, $sub, 16, 'Zadatak 44, str. 134', $content44);

        // ============================================================
        // ZADATAK 45, str. 134
        // ============================================================
        $content45 = '<h3>Zadatak 45</h3>'

        . '<p>Visina valjka je jednaka precniku osnove. Ako visinu povecamo za \(2 \text{ cm}\), povrsina valjka se poveca za \(28\pi \text{ cm}^2\). Izracunaj zapreminu valjka.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>\(H = 2r\) (visina jednaka precniku)</li>'
        . '<li>Povecanje visine za 2 cm daje povecanje povrsine za \(28\pi\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Povrsina starog valjka:</p>'
        . $this->m('P_{staro} = 2r\pi(r + H) = 2r\pi(r + 2r) = 6r^2\pi')
        . '<p>Povrsina novog valjka (visina \(H + 2 = 2r + 2\)):</p>'
        . $this->m('P_{novo} = 2r\pi(r + 2r + 2) = 2r\pi(3r + 2)')
        . '<p>Razlika povrsina:</p>'
        . $this->m('P_{novo} - P_{staro} = 2r\pi(3r + 2) - 6r^2\pi')
        . $this->m('= 6r^2\pi + 4r\pi - 6r^2\pi = 4r\pi')
        . '<p>Postavljamo jednacinu:</p>'
        . $this->m('4r\pi = 28\pi')
        . $this->m('r = 7 \text{ cm}')
        . '<p>Visina:</p>'
        . $this->m('H = 2r = 14 \text{ cm}')
        . '<p>Zapremina:</p>'
        . $this->m('V = r^2\pi \cdot H = 49\pi \cdot 14 = 686\pi \text{ cm}^3')

        . '<p><strong>Odgovor: Zapremina valjka je \(686\pi \text{ cm}^3\).</strong></p>';

        $this->createLesson($course, $sub, 17, 'Zadatak 45, str. 134', $content45);

        // ============================================================
        // ZADATAK 46, str. 134
        // ============================================================
        $content46 = '<h3>Zadatak 46</h3>'

        . '<p>Osnovna ivica pravilne prizme je \(6 \text{ cm}\), a visina \(8 \text{ cm}\). Izracunaj povrsinu i zapreminu upisanog i opisanog valjka ako je prizma:</p>'
        . '<p>a) pravilna cetvorostrana; b) pravilna trostrana; v) pravilna sestostrana</p>'

        . '<h4>Resenje - deo a) pravilna cetvorostrana prizma</h4>'
        . '<p>Osnova je kvadrat stranice \(a = 6\). Visina prizme/valjka: \(H = 8\).</p>'
        . '<p><strong>Upisani valjak</strong> (dodiruje stranice): poluprecnik je polustranica kvadrata:</p>'
        . $this->m('r = \frac{a}{2} = 3 \text{ cm}')
        . $this->m('P_u = 2 \cdot 3 \cdot \pi \cdot (3 + 8) = 6\pi \cdot 11 = 66\pi \text{ cm}^2')
        . $this->m('V_u = 9\pi \cdot 8 = 72\pi \text{ cm}^3')

        . '<p><strong>Opisani valjak</strong> (prolazi kroz temena): poluprecnik je poludijaganala kvadrata:</p>'
        . $this->m('R = \frac{a\sqrt{2}}{2} = 3\sqrt{2} \text{ cm}')
        . $this->m('P_o = 2 \cdot 3\sqrt{2} \cdot \pi \cdot (3\sqrt{2} + 8) = 6\sqrt{2}\pi(3\sqrt{2} + 8)')
        . $this->m('P_o = 6\sqrt{2}(3\sqrt{2} + 8)\pi = (36 + 48\sqrt{2})\pi = 12\pi(3 + 4\sqrt{2}) \text{ cm}^2')
        . $this->m('V_o = (3\sqrt{2})^2 \cdot \pi \cdot 8 = 18\pi \cdot 8 = 144\pi \text{ cm}^3')

        . '<h4>Resenje - deo b) pravilna trostrana prizma</h4>'
        . '<p>Osnova je jednakostranican trougao stranice \(a = 6\). Visina prizme: \(H = 8\).</p>'
        . '<p><strong>Upisani valjak:</strong></p>'
        . $this->m('r = \frac{a\sqrt{3}}{6} = \frac{6\sqrt{3}}{6} = \sqrt{3} \text{ cm}')
        . $this->m('P_u = 2\sqrt{3}\pi(\sqrt{3} + 8) = 2\sqrt{3}(\sqrt{3} + 8)\pi = 2(3 + 8\sqrt{3})\pi \text{ cm}^2')
        . $this->m('V_u = 3\pi \cdot 8 = 24\pi \text{ cm}^3')

        . '<p><strong>Opisani valjak:</strong></p>'
        . $this->m('R = \frac{a\sqrt{3}}{3} = \frac{6\sqrt{3}}{3} = 2\sqrt{3} \text{ cm}')
        . $this->m('P_o = 2 \cdot 2\sqrt{3} \cdot \pi \cdot (2\sqrt{3} + 8) = 4\sqrt{3}(2\sqrt{3} + 8)\pi')
        . $this->m('P_o = 4\sqrt{3} \cdot 2(\sqrt{3} + 4)\pi = 8\sqrt{3}(\sqrt{3} + 4)\pi = 8(3 + 4\sqrt{3})\pi \text{ cm}^2')
        . $this->m('V_o = (2\sqrt{3})^2 \cdot \pi \cdot 8 = 12\pi \cdot 8 = 96\pi \text{ cm}^3')

        . '<h4>Resenje - deo v) pravilna sestostrana prizma</h4>'
        . '<p>Osnova je pravilan sestougao stranice \(a = 6\). Visina prizme: \(H = 8\).</p>'
        . '<p><strong>Upisani valjak:</strong></p>'
        . $this->m('r = \frac{a\sqrt{3}}{2} = \frac{6\sqrt{3}}{2} = 3\sqrt{3} \text{ cm}')
        . $this->m('P_u = 2 \cdot 3\sqrt{3} \cdot \pi \cdot (3\sqrt{3} + 8) = 6\sqrt{3}(3\sqrt{3} + 8)\pi')
        . $this->m('P_u = 6\sqrt{3} \cdot 3\sqrt{3} \cdot \pi + 6\sqrt{3} \cdot 8 \cdot \pi = 54\pi + 48\sqrt{3}\pi = 6(9 + 8\sqrt{3})\pi \text{ cm}^2')
        . $this->m('V_u = (3\sqrt{3})^2 \cdot \pi \cdot 8 = 27\pi \cdot 8 = 216\pi \text{ cm}^3')

        . '<p><strong>Opisani valjak:</strong></p>'
        . $this->m('R = a = 6 \text{ cm}')
        . $this->m('P_o = 2 \cdot 6 \cdot \pi \cdot (6 + 8) = 12\pi \cdot 14 = 168\pi \text{ cm}^2')
        . $this->m('V_o = 36\pi \cdot 8 = 288\pi \text{ cm}^3')

        . '<p><strong>Odgovor:</strong></p>'
        . '<p><strong>a) Upisani: \(P_u = 66\pi\), \(V_u = 72\pi\); Opisani: \(P_o = 12(3+4\sqrt{2})\pi\), \(V_o = 144\pi\).</strong></p>'
        . '<p><strong>b) Upisani: \(P_u = 2(3+8\sqrt{3})\pi\), \(V_u = 24\pi\); Opisani: \(P_o = 8(3+4\sqrt{3})\pi\), \(V_o = 96\pi\).</strong></p>'
        . '<p><strong>v) Upisani: \(P_u = 6(9+8\sqrt{3})\pi\), \(V_u = 216\pi\); Opisani: \(P_o = 168\pi\), \(V_o = 288\pi\).</strong></p>';

        $this->createLesson($course, $sub, 18, 'Zadatak 46, str. 134', $content46);

        // ============================================================
        // ZADATAK 47, str. 134
        // ============================================================
        $content47 = '<h3>Zadatak 47</h3>'

        . '<p>Pravilna cetvorostrana prizma ima ivicu osnove \(8 \text{ cm}\) i povrsinu \(512 \text{ cm}^2\). Izracunaj odnos povrsina i zapremina upisanog i opisanog valjka.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Ivica osnove: \(a = 8 \text{ cm}\)</li>'
        . '<li>Povrsina prizme: \(P_{pr} = 512 \text{ cm}^2\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Najpre nalazimo visinu prizme. Povrsina pravilne cetvorostrane prizme:</p>'
        . $this->m('P_{pr} = 2a^2 + 4aH')
        . $this->m('512 = 2 \cdot 64 + 4 \cdot 8 \cdot H')
        . $this->m('512 = 128 + 32H')
        . $this->m('32H = 384')
        . $this->m('H = 12 \text{ cm}')

        . '<p><strong>Upisani valjak:</strong> \(r = \frac{a}{2} = 4 \text{ cm}\)</p>'
        . $this->m('P_u = 2 \cdot 4\pi(4 + 12) = 8\pi \cdot 16 = 128\pi \text{ cm}^2')
        . $this->m('V_u = 16\pi \cdot 12 = 192\pi \text{ cm}^3')

        . '<p><strong>Opisani valjak:</strong> \(R = \frac{a\sqrt{2}}{2} = 4\sqrt{2} \text{ cm}\)</p>'
        . $this->m('P_o = 2 \cdot 4\sqrt{2} \cdot \pi \cdot (4\sqrt{2} + 12) = 8\sqrt{2}\pi(4\sqrt{2} + 12)')
        . $this->m('P_o = 8\sqrt{2}(4\sqrt{2} + 12)\pi = (64 + 96\sqrt{2})\pi = 32(2 + 3\sqrt{2})\pi \text{ cm}^2')
        . $this->m('V_o = (4\sqrt{2})^2 \cdot \pi \cdot 12 = 32\pi \cdot 12 = 384\pi \text{ cm}^3')

        . '<p><strong>Odnos zapremina:</strong></p>'
        . $this->m('\frac{V_o}{V_u} = \frac{384\pi}{192\pi} = 2')

        . '<p><strong>Odnos povrsina:</strong></p>'
        . $this->m('\frac{P_o}{P_u} = \frac{32(2 + 3\sqrt{2})\pi}{128\pi} = \frac{2 + 3\sqrt{2}}{4}')

        . '<p><strong>Odgovor: \(\frac{V_o}{V_u} = 2\), \(\frac{P_o}{P_u} = \frac{2 + 3\sqrt{2}}{4}\).</strong></p>';

        $this->createLesson($course, $sub, 19, 'Zadatak 47, str. 134', $content47);

        // ============================================================
        // ZADATAK 48, str. 134
        // ============================================================
        $content48 = '<h3>Zadatak 48</h3>'

        . '<p>Oko valjka je opisana pravilna trostrana prizma. Poluprecnik valjka je \(5 \text{ cm}\), visina \(7 \text{ cm}\). Izracunaj povrsinu i zapreminu prizme.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>\(r = 5 \text{ cm}\), \(H = 7 \text{ cm}\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Kod opisane pravilne trostrane prizme, valjak je upisan u prizmu. Poluprecnik upisanog kruga jednakostranicnog trougla je:</p>'
        . $this->m('r = \frac{a\sqrt{3}}{6}')
        . '<p>Odavde nalazimo ivicu osnove prizme:</p>'
        . $this->m('5 = \frac{a\sqrt{3}}{6} \Rightarrow a = \frac{30}{\sqrt{3}} = \frac{30\sqrt{3}}{3} = 10\sqrt{3} \text{ cm}')

        . '<p>Povrsina osnove (jednakostranicnog trougla):</p>'
        . $this->m('B = \frac{a^2\sqrt{3}}{4} = \frac{(10\sqrt{3})^2 \cdot \sqrt{3}}{4} = \frac{300\sqrt{3}}{4} = 75\sqrt{3} \text{ cm}^2')

        . '<p>Povrsina omotaca prizme (3 pravougaonika):</p>'
        . $this->m('M_{pr} = 3 \cdot a \cdot H = 3 \cdot 10\sqrt{3} \cdot 7 = 210\sqrt{3} \text{ cm}^2')

        . '<p>Ukupna povrsina prizme:</p>'
        . $this->m('P_{pr} = 2B + M_{pr} = 150\sqrt{3} + 210\sqrt{3} = 360\sqrt{3} \text{ cm}^2')

        . '<p>Zapremina prizme:</p>'
        . $this->m('V_{pr} = B \cdot H = 75\sqrt{3} \cdot 7 = 525\sqrt{3} \text{ cm}^3')

        . '<p><strong>Odgovor: \(P_{pr} = 360\sqrt{3} \text{ cm}^2\), \(V_{pr} = 525\sqrt{3} \text{ cm}^3\).</strong></p>';

        $this->createLesson($course, $sub, 20, 'Zadatak 48, str. 134', $content48);

        // ============================================================
        // ZADATAK 49, str. 134
        // ============================================================
        $content49 = '<h3>Zadatak 49</h3>'

        . '<p>U valjak je upisana pravilna sestostrana prizma. Povrsina omotaca valjka je \(2\pi \text{ cm}^2\), a povrsina valjka je dva puta veca od omotaca. Izracunaj povrsinu i zapreminu prizme.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>\(M = 2\pi \text{ cm}^2\)</li>'
        . '<li>\(P = 2M\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Povrsina valjka je dva puta veca od omotaca:</p>'
        . $this->m('P = 2M')
        . $this->m('2B + M = 2M')
        . $this->m('2B = M')
        . '<p>Zamenjujemo formule:</p>'
        . $this->m('2r^2\pi = 2r\pi H')
        . '<p>Skratimo \(2r\pi\):</p>'
        . $this->m('r = H')
        . '<p>Iz omotaca nalazimo \(r\):</p>'
        . $this->m('M = 2r\pi H = 2r\pi \cdot r = 2\pi r^2 = 2\pi')
        . $this->m('r^2 = 1 \Rightarrow r = 1 \text{ cm}, \quad H = 1 \text{ cm}')

        . '<p>Kod upisane pravilne sestostrane prizme, ivica osnove je jednaka poluprecniku opisanog kruga sestougla, a to je poluprecnik valjka:</p>'
        . $this->m('a = r = 1 \text{ cm}')

        . '<p>Povrsina osnove (pravilnog sestougla):</p>'
        . $this->m('B_{pr} = \frac{3a^2\sqrt{3}}{2} = \frac{3\sqrt{3}}{2} \text{ cm}^2')

        . '<p>Povrsina prizme:</p>'
        . $this->m('P_{pr} = 2B_{pr} + 6aH = 3\sqrt{3} + 6 = 3(\sqrt{3} + 2) \text{ cm}^2')

        . '<p>Zapremina prizme:</p>'
        . $this->m('V_{pr} = B_{pr} \cdot H = \frac{3\sqrt{3}}{2} \cdot 1 = \frac{3\sqrt{3}}{2} \text{ cm}^3')

        . '<p><strong>Odgovor: \(P_{pr} = 3(\sqrt{3} + 2) \text{ cm}^2\), \(V_{pr} = \frac{3\sqrt{3}}{2} \text{ cm}^3\).</strong></p>';

        $this->createLesson($course, $sub, 21, 'Zadatak 49, str. 134', $content49);

        // ============================================================
        // ZADATAK 50, str. 134
        // ============================================================
        $content50 = '<h3>Zadatak 50</h3>'

        . '<p>Ravan paralelna osi valjka sece osnovu po tetivama duzine \(5 \text{ cm}\). Visina valjka je \(4 \text{ cm}\). Izracunaj povrsinu preseka.</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Tetiva: \(t = 5 \text{ cm}\)</li>'
        . '<li>\(H = 4 \text{ cm}\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Kada ravan paralelna osi valjka sece valjak, presek je pravougaonik. Jedna stranica pravougaonika je visina valjka (\(H\)), a druga je duzina tetive (\(t\)).</p>'
        . $this->m('S = t \cdot H = 5 \cdot 4 = 20 \text{ cm}^2')

        . '<p><strong>Odgovor: Povrsina preseka je \(20 \text{ cm}^2\).</strong></p>';

        $this->createLesson($course, $sub, 22, 'Zadatak 50, str. 134', $content50);

        // ============================================================
        // ZADATAK 51, str. 134
        // ============================================================
        $content51 = '<h3>Zadatak 51</h3>'

        . '<p>Putar za ravnanje zemljista ima precnik \(120 \text{ cm}\) i duzinu \(2{,}2 \text{ m}\). Koju povrsinu izravna posle \(50\) okretaja? (\(\pi \approx 3{,}14\))</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Precnik: \(d = 120 \text{ cm}\), pa \(r = 60 \text{ cm}\)</li>'
        . '<li>Duzina (sirina putara): \(L = 2{,}2 \text{ m} = 220 \text{ cm}\)</li>'
        . '<li>Broj okretaja: \(n = 50\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Za jedan okretaj putar izravna traku sirine \(L\) i duzine jednakog obimu kruga:</p>'
        . $this->m('O = 2r\pi = 2 \cdot 60 \cdot 3{,}14 = 376{,}8 \text{ cm}')
        . '<p>Povrsina za jedan okretaj (to je omotac):</p>'
        . $this->m('M = O \cdot L = 376{,}8 \cdot 220 = 82896 \text{ cm}^2')
        . '<p>Za 50 okretaja:</p>'
        . $this->m('S = 50 \cdot M = 50 \cdot 82896 = 4144800 \text{ cm}^2')
        . '<p>Pretvaramo u \(\text{m}^2\) (\(1 \text{ m}^2 = 10000 \text{ cm}^2\)):</p>'
        . $this->m('S = \frac{4144800}{10000} = 414{,}48 \text{ m}^2')

        . '<p><strong>Odgovor: Putar izravna \(414{,}48 \text{ m}^2\) posle 50 okretaja.</strong></p>';

        $this->createLesson($course, $sub, 23, 'Zadatak 51, str. 134', $content51);

        // ============================================================
        // ZADATAK 52, str. 134
        // ============================================================
        $content52 = '<h3>Zadatak 52</h3>'

        . '<p>Treba ofarbati cev duzine \(7 \text{ m}\) i precnika \(13 \text{ cm}\). Za \(1 \text{ dm}^2\) treba \(12 \text{ g}\) boje. Da li moze da se ofarba sa \(3 \text{ kg}\) boje? (\(\pi \approx 3{,}14\))</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>Duzina cevi: \(H = 7 \text{ m} = 700 \text{ cm}\)</li>'
        . '<li>Precnik: \(d = 13 \text{ cm}\), pa \(r = 6{,}5 \text{ cm}\)</li>'
        . '<li>Potrosnja: \(12 \text{ g/dm}^2\)</li>'
        . '<li>Raspolozivo: \(3 \text{ kg} = 3000 \text{ g}\)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Racunamo povrsinu omotaca cevi:</p>'
        . $this->m('M = 2r\pi H = 2 \cdot 6{,}5 \cdot 3{,}14 \cdot 700')
        . $this->m('M = 13 \cdot 3{,}14 \cdot 700')
        . $this->m('M = 40{,}82 \cdot 700 = 28574 \text{ cm}^2')
        . '<p>Pretvaramo u \(\text{dm}^2\) (\(1 \text{ dm}^2 = 100 \text{ cm}^2\)):</p>'
        . $this->m('M = \frac{28574}{100} = 285{,}74 \text{ dm}^2')
        . '<p>Potrebna kolicina boje:</p>'
        . $this->m('m = 285{,}74 \cdot 12 = 3428{,}88 \text{ g}')
        . '<p>Uporedimo sa raspolozivom kolicinom:</p>'
        . $this->m('3428{,}88 \text{ g} > 3000 \text{ g}')

        . '<p><strong>Odgovor: NE MOZE. Potrebno je \(3428{,}88 \text{ g}\) boje, a na raspolaganju je samo \(3000 \text{ g}\) (3 kg). Nedostaje priblizno \(429 \text{ g}\) boje.</strong></p>';

        $this->createLesson($course, $sub, 24, 'Zadatak 52, str. 134', $content52);

        // ============================================================
        // ZADATAK 53, str. 134
        // ============================================================
        $content53 = '<h3>Zadatak 53</h3>'

        . '<p>Vaza ima oblik valjka. Zapremina je \(770 \text{ cm}^3\), visina \(20 \text{ cm}\). Treba obojiti spolja (omotac i dno). Kolika je ta povrsina? (\(\pi \approx \frac{22}{7}\))</p>'

        . '<h4>Dato</h4>'
        . '<ul>'
        . '<li>\(V = 770 \text{ cm}^3\)</li>'
        . '<li>\(H = 20 \text{ cm}\)</li>'
        . '<li>\(\pi \approx \frac{22}{7}\)</li>'
        . '</ul>'

        . '<h4>Trazi se</h4>'
        . '<ul>'
        . '<li>Povrsina za bojenje: \(P = M + B\) (omotac + dno)</li>'
        . '</ul>'

        . '<h4>Resenje</h4>'
        . '<p>Iz zapremine nalazimo poluprecnik:</p>'
        . $this->m('V = r^2\pi H')
        . $this->m('770 = r^2 \cdot \frac{22}{7} \cdot 20')
        . $this->m('770 = r^2 \cdot \frac{440}{7}')
        . $this->m('r^2 = \frac{770 \cdot 7}{440} = \frac{5390}{440} = 12{,}25')
        . $this->m('r = 3{,}5 \text{ cm}')

        . '<p>Povrsina dna:</p>'
        . $this->m('B = r^2\pi = 12{,}25 \cdot \frac{22}{7} = \frac{269{,}5}{7} = 38{,}5 \text{ cm}^2')

        . '<p>Povrsina omotaca:</p>'
        . $this->m('M = 2r\pi H = 2 \cdot 3{,}5 \cdot \frac{22}{7} \cdot 20')
        . $this->m('M = 7 \cdot \frac{22}{7} \cdot 20 = 22 \cdot 20 = 440 \text{ cm}^2')

        . '<p>Ukupna povrsina za bojenje:</p>'
        . $this->m('P = B + M = 38{,}5 + 440 = 478{,}5 \text{ cm}^2')

        . '<p><strong>Odgovor: Povrsina za bojenje je \(478{,}5 \text{ cm}^2\).</strong></p>';

        $this->createLesson($course, $sub, 25, 'Zadatak 53, str. 134', $content53);
    }
}
