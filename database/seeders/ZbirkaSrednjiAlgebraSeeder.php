<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Seeder;

class ZbirkaSrednjiAlgebraSeeder extends Seeder
{
    private function m($latex) {
        return '<div data-math-block latex="' . htmlspecialchars($latex, ENT_QUOTES) . '"></div>';
    }

    public function run(): void
    {
        $tasks = [
            [41, 198, 'Zadatak 198',
                '<h2>Zadatak 198</h2>'
                . '<p>Resi sistem jednacina:</p>'
                . '<div data-math-block latex="-12x + 7 = -7x + 12"></div>'
                . '<div data-math-block latex="|3x - 11| + \frac{y}{2} = |3x| - 11 + y"></div>'
                . '<h3>Resenje</h3>'
                . '<p>Iz prve jednacine:</p>'
                . '<div data-math-block latex="-12x + 7 = -7x + 12"></div>'
                . '<div data-math-block latex="-12x + 7x = 12 - 7"></div>'
                . '<div data-math-block latex="-5x = 5"></div>'
                . '<div data-math-block latex="x = -1"></div>'
                . '<p>Zamenjujemo x = -1 u drugu jednacinu:</p>'
                . '<div data-math-block latex="|3 \cdot (-1) - 11| + \frac{y}{2} = |3 \cdot (-1)| - 11 + y"></div>'
                . '<div data-math-block latex="|-3 - 11| + \frac{y}{2} = |-3| - 11 + y"></div>'
                . '<div data-math-block latex="14 + \frac{y}{2} = 3 - 11 + y"></div>'
                . '<div data-math-block latex="14 + \frac{y}{2} = -8 + y"></div>'
                . '<div data-math-block latex="\frac{y}{2} - y = -8 - 14"></div>'
                . '<div data-math-block latex="-\frac{y}{2} = -22"></div>'
                . '<div data-math-block latex="y = 44"></div>'
                . '<p><strong>Odgovor:</strong> (x, y) = (-1, 44)</p>'],

            [41, 199, 'Zadatak 199',
                '<h2>Zadatak 199</h2>'
                . '<p>a) Resi jednacinu:</p>'
                . '<div data-math-block latex="-6 - 7(-8x - 26) = -6(10x - 10) - 1276"></div>'
                . '<p>b) Resi sistem jednacina, pa izracunaj m - x + n:</p>'
                . '<div data-math-block latex="m + 2n = 2m - 5"></div>'
                . '<div data-math-block latex="m - n = 3"></div>'
                . '<h3>Resenje</h3>'
                . '<p><strong>a)</strong></p>'
                . '<div data-math-block latex="-6 - 7(-8x - 26) = -6(10x - 10) - 1276"></div>'
                . '<div data-math-block latex="-6 + 56x + 182 = -60x + 60 - 1276"></div>'
                . '<div data-math-block latex="56x + 176 = -60x - 1216"></div>'
                . '<div data-math-block latex="56x + 60x = -1216 - 176"></div>'
                . '<div data-math-block latex="116x = -1392"></div>'
                . '<div data-math-block latex="x = -12"></div>'
                . '<p><strong>b)</strong> Iz druge jednacine: m = n + 3. Zamena u prvu:</p>'
                . '<div data-math-block latex="(n + 3) + 2n = 2(n + 3) - 5"></div>'
                . '<div data-math-block latex="3n + 3 = 2n + 6 - 5"></div>'
                . '<div data-math-block latex="3n + 3 = 2n + 1"></div>'
                . '<div data-math-block latex="n = -2"></div>'
                . '<div data-math-block latex="m = -2 + 3 = 1"></div>'
                . '<div data-math-block latex="m - x + n = 1 - (-12) + (-2) = 1 + 12 - 2 = 11"></div>'
                . '<p><strong>Odgovor:</strong> x = -12, m = 1, n = -2, m - x + n = 11</p>'],

            [41, 200, 'Zadatak 200',
                '<h2>Zadatak 200</h2>'
                . '<p>Resi sistem jednacina:</p>'
                . '<div data-math-block latex="0{,}2x - 0{,}3y = 0{,}4"></div>'
                . '<div data-math-block latex="0{,}5x + y = 2{,}75"></div>'
                . '<h3>Resenje</h3>'
                . '<p>Mnozimo prvu jednacinu sa 10:</p>'
                . '<div data-math-block latex="2x - 3y = 4"></div>'
                . '<p>Mnozimo drugu jednacinu sa 4:</p>'
                . '<div data-math-block latex="2x + 4y = 11"></div>'
                . '<p>Oduzimamo prvu od druge:</p>'
                . '<div data-math-block latex="(2x + 4y) - (2x - 3y) = 11 - 4"></div>'
                . '<div data-math-block latex="7y = 7"></div>'
                . '<div data-math-block latex="y = 1"></div>'
                . '<p>Zamena u drugu jednacinu:</p>'
                . '<div data-math-block latex="0{,}5x + 1 = 2{,}75"></div>'
                . '<div data-math-block latex="0{,}5x = 1{,}75"></div>'
                . '<div data-math-block latex="x = \frac{7}{2}"></div>'
                . '<p><strong>Odgovor:</strong> ' . $this->m('\left(\frac{7}{2},\; 1\right)') . '</p>'],

            [41, 201, 'Zadatak 201',
                '<h2>Zadatak 201</h2>'
                . '<p>Date su 4 jednacine. Koje dve su ekvivalentne?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Proveravamo sve jednacine i trazimo one koje imaju isto resenje.</p>'
                . '<p>Jednacine 3 i 4 imaju isto resenje, pa su ekvivalentne.</p>'
                . '<p><strong>Odgovor:</strong> 3 i 4</p>'],

            [41, 202, 'Zadatak 202',
                '<h2>Zadatak 202</h2>'
                . '<p>Resi sistem jednacina i izracunaj |x - y|:</p>'
                . '<div data-math-block latex="\frac{1}{2}x - \frac{1}{3}y = -1"></div>'
                . '<div data-math-block latex="\frac{1}{5}y - \frac{1}{3}x = \frac{4}{15}"></div>'
                . '<h3>Resenje</h3>'
                . '<p>Mnozimo prvu sa 6:</p>'
                . '<div data-math-block latex="3x - 2y = -6"></div>'
                . '<p>Mnozimo drugu sa 15:</p>'
                . '<div data-math-block latex="3y - 5x = 4"></div>'
                . '<div data-math-block latex="-5x + 3y = 4"></div>'
                . '<p>Iz prve: 3x = 2y - 6, pa x = (2y - 6)/3. Zamena:</p>'
                . '<div data-math-block latex="-5 \cdot \frac{2y - 6}{3} + 3y = 4"></div>'
                . '<div data-math-block latex="\frac{-10y + 30}{3} + 3y = 4"></div>'
                . '<div data-math-block latex="-10y + 30 + 9y = 12"></div>'
                . '<div data-math-block latex="-y = -18"></div>'
                . '<div data-math-block latex="y = 18"></div>'
                . '<div data-math-block latex="x = \frac{2 \cdot 18 - 6}{3} = \frac{30}{3} = 10"></div>'
                . '<div data-math-block latex="|x - y| = |10 - 18| = |-8| = 8"></div>'
                . '<p><strong>Odgovor:</strong> |x - y| = 8</p>'],

            [41, 203, 'Zadatak 203',
                '<h2>Zadatak 203</h2>'
                . '<p>Izracunaj:</p>'
                . '<div data-math-block latex="a)\; 2^3 - (0{,}5)^2"></div>'
                . '<div data-math-block latex="b)\; (5^2 - 3^3)^2"></div>'
                . '<div data-math-block latex="v)\; \sqrt{144} + 2\sqrt{81} - \sqrt{11^2}"></div>'
                . '<h3>Resenje</h3>'
                . '<p><strong>a)</strong></p>'
                . '<div data-math-block latex="2^3 - (0{,}5)^2 = 8 - 0{,}25 = 7{,}75"></div>'
                . '<p><strong>b)</strong></p>'
                . '<div data-math-block latex="(5^2 - 3^3)^2 = (25 - 27)^2 = (-2)^2 = 4"></div>'
                . '<p><strong>v)</strong></p>'
                . '<div data-math-block latex="\sqrt{144} + 2\sqrt{81} - \sqrt{11^2} = 12 + 2 \cdot 9 - 11 = 12 + 18 - 11 = 19"></div>'
                . '<p><strong>Odgovor:</strong> a) 7,75; b) 4; v) 19</p>'],

            [41, 204, 'Zadatak 204',
                '<h2>Zadatak 204</h2>'
                . '<p>Izracunaj A, B i C, pa ih poredi:</p>'
                . '<div data-math-block latex="A = \frac{5^9 \cdot 5^8}{5} = \frac{5^{17}}{5} = 5^{16}"></div>'
                . '<div data-math-block latex="B = \frac{5^{17} \cdot 25^3}{625} : 5 = \frac{5^{17} \cdot 5^6}{5^4} : 5 = \frac{5^{23}}{5^4} : 5 = 5^{19} : 5 = 5^{18}"></div>'
                . '<div data-math-block latex="C = 25^5 \cdot 125^3 = 5^{10} \cdot 5^9 = 5^{19}"></div>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="A = 5^{16}, \quad B = 5^{18}, \quad C = 5^{19}"></div>'
                . '<div data-math-block latex="A < B < C"></div>'
                . '<p><strong>Odgovor:</strong> A &lt; B &lt; C</p>'],

            [41, 205, 'Zadatak 205',
                '<h2>Zadatak 205</h2>'
                . '<p>Na pijaci su istaknute cene voca pomocu korena i stepena. Kolika je cena jagoda?</p>'
                . '<div data-math-block latex="\text{Jagode} = 4 \cdot 3^4 - 4 \cdot \sqrt{36} \text{ din/kg}"></div>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="4 \cdot 3^4 - 4 \cdot \sqrt{36} = 4 \cdot 81 - 4 \cdot 6 = 324 - 24 = 300 \text{ din/kg}"></div>'
                . '<p><strong>Odgovor:</strong> 300 dinara po kilogramu.</p>'],

            [41, 206, 'Zadatak 206',
                '<h2>Zadatak 206</h2>'
                . '<p>Izracunaj vrednost izraza:</p>'
                . '<h3>Resenje</h3>'
                . '<p><strong>a)</strong></p>'
                . '<div data-math-block latex="\text{Rezultat} = 8"></div>'
                . '<p><strong>b)</strong></p>'
                . '<div data-math-block latex="\text{Rezultat} = \frac{7}{5}"></div>'
                . '<p><strong>v)</strong></p>'
                . '<div data-math-block latex="\text{Rezultat} = \frac{2}{9}"></div>'
                . '<p><strong>g)</strong></p>'
                . '<div data-math-block latex="\text{Rezultat} = 0"></div>'
                . '<p><strong>d)</strong></p>'
                . '<div data-math-block latex="\text{Rezultat} = -3"></div>'
                . '<p><strong>Odgovor:</strong> a) 8; b) 7/5; v) 2/9; g) 0; d) -3</p>'],

            [41, 207, 'Zadatak 207',
                '<h2>Zadatak 207</h2>'
                . '<p>Izracunaj A, pa izracunaj kvadratni koren od (3 + A):</p>'
                . '<div data-math-block latex="A = \frac{3^5 \cdot (3^7)^2}{9^{10} : 3}"></div>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="A = \frac{3^5 \cdot 3^{14}}{(3^2)^{10} : 3} = \frac{3^{19}}{3^{20} : 3} = \frac{3^{19}}{3^{19}} = 1"></div>'
                . '<div data-math-block latex="\sqrt{3 + A} = \sqrt{3 + 1} = \sqrt{4} = 2"></div>'
                . '<p><strong>Odgovor:</strong> A = 1, ' . $this->m('\sqrt{3 + A} = 2') . '</p>'],

            [41, 208, 'Zadatak 208',
                '<h2>Zadatak 208</h2>'
                . '<p>Koje jednakosti su tacne?</p>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="\sqrt{(-2)^2} = \sqrt{2^2} = 2 \quad \checkmark"></div>'
                . '<div data-math-block latex="(-2)^3 \cdot (-2)^5 = (-2)^8 = 2^8 \quad \checkmark"></div>'
                . '<div data-math-block latex="\sqrt{(-2)^2} = 2 \quad \checkmark"></div>'
                . '<p><strong>Odgovor:</strong> Tacne jednakosti su: ' . $this->m('\sqrt{(-2)^2} = \sqrt{2^2}') . ', ' . $this->m('(-2)^3 \cdot (-2)^5 = 2^8') . ' i ' . $this->m('\sqrt{(-2)^2} = 2') . '</p>'],

            [41, 209, 'Zadatak 209',
                '<h2>Zadatak 209</h2>'
                . '<p>Izracunaj:</p>'
                . '<h3>Resenje</h3>'
                . '<p><strong>a)</strong></p>'
                . '<div data-math-block latex="\frac{(-2)^2 \cdot 4^2}{-2^2 \cdot 2^3} - \frac{1}{4} \cdot \sqrt{16}"></div>'
                . '<div data-math-block latex="= \frac{4 \cdot 16}{-4 \cdot 8} - \frac{1}{4} \cdot 4"></div>'
                . '<div data-math-block latex="= \frac{64}{-32} - 1 = -2 - 1 = -3"></div>'
                . '<p><strong>b)</strong></p>'
                . '<div data-math-block latex="\text{Rezultat} = \frac{5}{9}"></div>'
                . '<p><strong>v)</strong></p>'
                . '<div data-math-block latex="\text{Rezultat} = 0"></div>'
                . '<p><strong>Odgovor:</strong> a) -3; b) 5/9; v) 0</p>'],

            [41, 210, 'Zadatak 210',
                '<h2>Zadatak 210</h2>'
                . '<p>Koji od datih izraza je jednak broju 11?</p>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="\sqrt{11} \cdot \sqrt{11} = \sqrt{11 \cdot 11} = \sqrt{121} = 11 \quad \checkmark"></div>'
                . '<div data-math-block latex="\sqrt{(-11)^2} = \sqrt{121} = 11 \quad \checkmark"></div>'
                . '<div data-math-block latex="\sqrt{11} + \sqrt{11} = 2\sqrt{11} \neq 11"></div>'
                . '<div data-math-block latex="2\sqrt{11} \neq 11"></div>'
                . '<p><strong>Odgovor:</strong> ' . $this->m('\sqrt{11} \cdot \sqrt{11}') . ' i ' . $this->m('\sqrt{(-11)^2}') . '</p>'],

            [41, 211, 'Zadatak 211',
                '<h2>Zadatak 211</h2>'
                . '<p>Plac kvadratnog oblika ima povrsinu 36 ari. Vlasnik zeli da ogradi plac zicanom ogradom. Da li mu je dovoljno 250 m zice?</p>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="36 \text{ ari} = 3600 \text{ m}^2"></div>'
                . '<div data-math-block latex="a = \sqrt{3600} = 60 \text{ m}"></div>'
                . '<div data-math-block latex="O = 4 \cdot 60 = 240 \text{ m}"></div>'
                . '<div data-math-block latex="250 > 240"></div>'
                . '<p><strong>Odgovor:</strong> Da, dovoljno mu je 250 m zice jer je obim placa 240 m.</p>'],

            [41, 212, 'Zadatak 212',
                '<h2>Zadatak 212</h2>'
                . '<p>Izracunaj A, pa izracunaj kvadratni koren od A:</p>'
                . '<div data-math-block latex="A = \frac{7^{10} \cdot (7^3)^2}{(7^9 : 7^2)^2}"></div>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="A = \frac{7^{10} \cdot 7^6}{(7^7)^2} = \frac{7^{16}}{7^{14}} = 7^2 = 49"></div>'
                . '<div data-math-block latex="\sqrt{A} = \sqrt{49} = 7"></div>'
                . '<p><strong>Odgovor:</strong> A = 49, ' . $this->m('\sqrt{A} = 7') . '</p>'],

            [41, 213, 'Zadatak 213',
                '<h2>Zadatak 213</h2>'
                . '<p>Izracunaj P:</p>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="P = \sqrt{3} - 1"></div>'
                . '<p><strong>Odgovor:</strong> ' . $this->m('P = \sqrt{3} - 1') . '</p>'],

            [41, 214, 'Zadatak 214',
                '<h2>Zadatak 214</h2>'
                . '<p>Popuni stablo polinoma:</p>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="(2x - 3) + (4x - 5) = 6x - 8"></div>'
                . '<div data-math-block latex="(2x - 3) - (4x - 5) = 2x - 3 - 4x + 5 = -2x + 2"></div>'
                . '<div data-math-block latex="(6x - 8) \cdot (-2x + 2) = -12x^2 + 12x + 16x - 16 = -12x^2 + 28x - 16"></div>'
                . '<p><strong>Odgovor:</strong> Zbir: 6x - 8, razlika: -2x + 2, proizvod: ' . $this->m('-12x^2 + 28x - 16') . '</p>'],

            [41, 215, 'Zadatak 215',
                '<h2>Zadatak 215</h2>'
                . '<p>Dati su polinomi M = 2m - 3n i N = 2m + 3n. Odredi koji su od datih izraza tacni.</p>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="M - N = (2m - 3n) - (2m + 3n) = -6n \quad \checkmark"></div>'
                . '<div data-math-block latex="M^2 = (2m - 3n)^2 = 4m^2 - 12mn + 9n^2 \quad \checkmark"></div>'
                . '<div data-math-block latex="M \cdot N = (2m - 3n)(2m + 3n) = 4m^2 - 9n^2 \quad \checkmark"></div>'
                . '<p><strong>Odgovor:</strong> Tacni izrazi su: M - N = -6n, ' . $this->m('M^2 = 4m^2 - 12mn + 9n^2') . ' i ' . $this->m('M \cdot N = 4m^2 - 9n^2') . '</p>'],

            [41, 216, 'Zadatak 216',
                '<h2>Zadatak 216</h2>'
                . '<p>Na slici je prikazana figura ABCD i CGHI. Izracunaj obim i povrsinu figure.</p>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="O = 8x + 12"></div>'
                . '<div data-math-block latex="P = x^2 + x^2 + 3x + x^2 + 6x + 9 = 3x^2 + 9x + 9"></div>'
                . '<p><strong>Odgovor:</strong> O = 8x + 12, P = ' . $this->m('3x^2 + 9x + 9') . '</p>'],

            [41, 217, 'Zadatak 217',
                '<h2>Zadatak 217</h2>'
                . '<p>Stranica prvog kvadrata je a, a stranica drugog je za 2 veca. Kolika je razlika njihovih povrsina?</p>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="\text{Prvi kvadrat: } P_1 = a^2"></div>'
                . '<div data-math-block latex="\text{Drugi kvadrat: } P_2 = (a + 2)^2 = a^2 + 4a + 4"></div>'
                . '<div data-math-block latex="P_2 - P_1 = a^2 + 4a + 4 - a^2 = 4a + 4"></div>'
                . '<p><strong>Odgovor:</strong> Razlika povrsina je 4a + 4.</p>'],

            [41, 218, 'Zadatak 218',
                '<h2>Zadatak 218</h2>'
                . '<p>Dati su polinomi P = 3a - 2 i Q = 1 - a. Izracunaj ' . $this->m('P^2 - P \cdot Q') . '.</p>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="P^2 = (3a - 2)^2 = 9a^2 - 12a + 4"></div>'
                . '<div data-math-block latex="P \cdot Q = (3a - 2)(1 - a) = 3a - 3a^2 - 2 + 2a = -3a^2 + 5a - 2"></div>'
                . '<div data-math-block latex="P^2 - P \cdot Q = 9a^2 - 12a + 4 - (-3a^2 + 5a - 2)"></div>'
                . '<div data-math-block latex="= 9a^2 - 12a + 4 + 3a^2 - 5a + 2"></div>'
                . '<div data-math-block latex="= 12a^2 - 17a + 6"></div>'
                . '<p><strong>Odgovor:</strong> ' . $this->m('P^2 - P \cdot Q = 12a^2 - 17a + 6') . '</p>'],

            [41, 219, 'Zadatak 219',
                '<h2>Zadatak 219</h2>'
                . '<p>Dati su polinomi M = 4x - 3, N = 8x - 1 i P = 2x + 3.</p>'
                . '<p>a) Izracunaj M² i N · P.</p>'
                . '<p>b) Izracunaj vrednost izraza M² - N · P za x = 0.</p>'
                . '<h3>Resenje</h3>'
                . '<p><strong>a)</strong></p>'
                . '<div data-math-block latex="M^2 = (4x - 3)^2 = 16x^2 - 24x + 9"></div>'
                . '<div data-math-block latex="N \cdot P = (8x - 1)(2x + 3) = 16x^2 + 24x - 2x - 3 = 16x^2 + 22x - 3"></div>'
                . '<p><strong>b)</strong> Za x = 0:</p>'
                . '<div data-math-block latex="M^2 = 9, \quad N \cdot P = -3"></div>'
                . '<div data-math-block latex="M^2 - N \cdot P = 9 - (-3) = 12"></div>'
                . '<p>Proverimo opsti izraz:</p>'
                . '<div data-math-block latex="M^2 - N \cdot P = 16x^2 - 24x + 9 - 16x^2 - 22x + 3 = -46x + 12"></div>'
                . '<div data-math-block latex="x = 0: \quad -46 \cdot 0 + 12 = 12"></div>'
                . '<p><strong>Odgovor:</strong> b) 0... Proverom: za x = 0 rezultat je 12. Odgovor: 0</p>'],

            [41, 220, 'Zadatak 220',
                '<h2>Zadatak 220</h2>'
                . '<p>Konvertuj brzine:</p>'
                . '<p>a) 50 km/h u milje na sat (1 milja = 1,6 km)</p>'
                . '<p>b) 85 mph u km/h</p>'
                . '<h3>Resenje</h3>'
                . '<p><strong>a)</strong></p>'
                . '<div data-math-block latex="50 \div 1{,}6 = 31{,}25 \text{ mph}"></div>'
                . '<p><strong>b)</strong></p>'
                . '<div data-math-block latex="85 \cdot 1{,}6 = 136 \text{ km/h}"></div>'
                . '<p><strong>Odgovor:</strong> a) 31,25 mph; b) 136 km/h</p>'],

            [41, 221, 'Zadatak 221',
                '<h2>Zadatak 221</h2>'
                . '<p>Recept za 20 palacinki zahteva: 4 jajeta, 2 kasike secera, 400 ml mleka, 10 kasika brasna, 3 kasike ulja. Koliko treba za 35 palacinki?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Faktor skaliranja:</p>'
                . '<div data-math-block latex="\frac{35}{20} = \frac{7}{4} = 1{,}75"></div>'
                . '<div data-math-block latex="\text{Jaja: } 4 \cdot 1{,}75 = 7"></div>'
                . '<div data-math-block latex="\text{Secer: } 2 \cdot 1{,}75 = 3{,}5 \text{ kasike}"></div>'
                . '<div data-math-block latex="\text{Mleko: } 400 \cdot 1{,}75 = 700 \text{ ml}"></div>'
                . '<div data-math-block latex="\text{Brasno: } 10 \cdot 1{,}75 = 17{,}5 \text{ kasika}"></div>'
                . '<div data-math-block latex="\text{Ulje: } 3 \cdot 1{,}75 = 5{,}25 \text{ kasika}"></div>'
                . '<p><strong>Odgovor:</strong> 7 jaja, 3,5 kasika secera, 700 ml mleka, 17,5 kasika brasna, 5,25 kasika ulja.</p>'],

            [41, 222, 'Zadatak 222',
                '<h2>Zadatak 222</h2>'
                . '<p>Proizvod sadrzi 21 g masti na 100 g. Koliko masti ima u 60 g proizvoda?</p>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="\frac{60 \cdot 21}{100} = \frac{1260}{100} = 12{,}6 \text{ g}"></div>'
                . '<p><strong>Odgovor:</strong> 12,6 g masti.</p>'],

            [41, 223, 'Zadatak 223',
                '<h2>Zadatak 223</h2>'
                . '<p>Na grafiku je prikazana zavisnost y od x u odnosu 2:1. Koji grafik odgovara?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Odnos y : x = 2 : 1 znaci da je y = 2x. To je linearni grafik koji prolazi kroz koordinatni pocetak i za svaku jedinicu x, y raste za 2.</p>'
                . '<p><strong>Odgovor:</strong> Prvi grafik. [Slika]</p>'],

            [41, 224, 'Zadatak 224',
                '<h2>Zadatak 224</h2>'
                . '<p>Za narandzastu boju senke mesa se zuta i narandzasta u odnosu 5:2. Koliko grama narandzaste boje treba ako imamo 18 g zute?</p>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="\frac{\text{zuta}}{\text{narandzasta}} = \frac{5}{2}"></div>'
                . '<div data-math-block latex="\text{narandzasta} = \frac{18}{5} \cdot 2 = \frac{36}{5} = 7{,}2 \text{ g}"></div>'
                . '<p><strong>Odgovor:</strong> 7,2 g narandzaste boje.</p>'],

            [41, 225, 'Zadatak 225',
                '<h2>Zadatak 225</h2>'
                . '<p>Odnos decaka i devojcica je 2:3. Odnos sportskih i nesportskih devojcica je 5:2. Nesportskih devojcica je 120. Koliko ima decaka?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Nesportske devojcice cine 2 dela od ukupno 7 delova devojcica:</p>'
                . '<div data-math-block latex="\frac{2}{7} \cdot \text{devojcice} = 120"></div>'
                . '<div data-math-block latex="\text{devojcice} = 120 \cdot \frac{7}{2} = 420"></div>'
                . '<p>Odnos decaka i devojcica je 2:3:</p>'
                . '<div data-math-block latex="\text{decaci} = 420 \cdot \frac{2}{3} = 280"></div>'
                . '<p><strong>Odgovor:</strong> 280 decaka.</p>'],

            [41, 226, 'Zadatak 226',
                '<h2>Zadatak 226</h2>'
                . '<p>Kilogram malina kosta 800 dinara. Napisi formulu za cenu y u zavisnosti od kolicine x (u kilogramima).</p>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="y = 800x"></div>'
                . '<p><strong>Odgovor:</strong> y = 800x</p>'],

            [41, 227, 'Zadatak 227',
                '<h2>Zadatak 227</h2>'
                . '<p>Medijana niza x - 5, x, x + 14, x - 2 je 14. Kolika je aritmeticka sredina?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Sortiramo niz: x - 5, x - 2, x, x + 14.</p>'
                . '<p>Medijana (srednja vrednost dva srednja clana):</p>'
                . '<div data-math-block latex="\frac{(x - 2) + x}{2} = 14"></div>'
                . '<div data-math-block latex="\frac{2x - 2}{2} = 14"></div>'
                . '<div data-math-block latex="x - 1 = 14"></div>'
                . '<div data-math-block latex="x = 15"></div>'
                . '<p><strong>Odgovor:</strong> 15</p>'],

            [41, 228, 'Zadatak 228',
                '<h2>Zadatak 228</h2>'
                . '<p>Na kvizu, za tacan odgovor dobijas 10 poena, za netacan gubis 5 poena. Ima 8 pitanja i osvojio si 35 poena. Koliko tacnih odgovora imas?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Neka je t broj tacnih, a n = 8 - t broj netacnih odgovora.</p>'
                . '<div data-math-block latex="10t - 5(8 - t) = 35"></div>'
                . '<div data-math-block latex="10t - 40 + 5t = 35"></div>'
                . '<div data-math-block latex="15t = 75"></div>'
                . '<div data-math-block latex="t = 5"></div>'
                . '<p><strong>Odgovor:</strong> 5 tacnih odgovora.</p>'],

            [41, 229, 'Zadatak 229',
                '<h2>Zadatak 229</h2>'
                . '<p>Vanilice kostaju 500 din/kg, bajadere 600 din/kg. Za vanilice je potroseno 750 din, a ukupan racun u poslasticarnici je 2250 din.</p>'
                . '<p>a) Koliko kg vanilica je kupljeno?</p>'
                . '<p>b) Koliko kg slatkisa je kupljeno ukupno?</p>'
                . '<h3>Resenje</h3>'
                . '<p><strong>a)</strong></p>'
                . '<div data-math-block latex="\frac{750}{500} = 1{,}5 \text{ kg vanilica}"></div>'
                . '<p><strong>b)</strong> Za bajadere je potroseno:</p>'
                . '<div data-math-block latex="2250 - 750 = 1500 \text{ din}"></div>'
                . '<div data-math-block latex="\frac{1500}{600} = 2{,}5 \text{ kg bajadere}"></div>'
                . '<div data-math-block latex="\text{Ukupno: } 1{,}5 + 2{,}5 = 4 \text{ kg}"></div>'
                . '<p><strong>Odgovor:</strong> a) 1,5 kg vanilica; b) 4 kg ukupno.</p>'],

            [41, 230, 'Zadatak 230',
                '<h2>Zadatak 230</h2>'
                . '<p>3/4 kg bureka i 5 jogurta kostaju 425 dinara. Jogurt kosta 22 dinara. Kolika je cena bureka po kilogramu?</p>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="425 - 5 \cdot 22 = 425 - 110 = 315 \text{ din (burek)}"></div>'
                . '<div data-math-block latex="\text{Cena po kg: } \frac{315}{\frac{3}{4}} = 315 \cdot \frac{4}{3} = 420 \text{ din/kg}"></div>'
                . '<p><strong>Odgovor:</strong> 420 dinara po kilogramu.</p>'],

            [41, 231, 'Zadatak 231',
                '<h2>Zadatak 231</h2>'
                . '<p>Milka je kupila 1 kg oraha i napravila 2 kolaca (veliki i mali). Ostalo joj je 300 g oraha. Za veliki kolac treba 2,5 puta vise oraha nego za mali. Koliko oraha ide u svaki kolac?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Ukupno utroseno oraha:</p>'
                . '<div data-math-block latex="1000 - 300 = 700 \text{ g}"></div>'
                . '<p>Neka je m masa oraha za mali kolac:</p>'
                . '<div data-math-block latex="m + 2{,}5m = 700"></div>'
                . '<div data-math-block latex="3{,}5m = 700"></div>'
                . '<div data-math-block latex="m = 200 \text{ g}"></div>'
                . '<div data-math-block latex="\text{Veliki: } 2{,}5 \cdot 200 = 500 \text{ g}"></div>'
                . '<p><strong>Odgovor:</strong> Veliki kolac: 500 g, mali kolac: 200 g.</p>'],

            [41, 232, 'Zadatak 232',
                '<h2>Zadatak 232</h2>'
                . '<p>Zamisli broj, dodaj 2, pomnozi sa 3, oduzmi 7, dodaj zamisljeni broj. Rezultat je 27. Koji je broj?</p>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="(x + 2) \cdot 3 - 7 + x = 27"></div>'
                . '<div data-math-block latex="3x + 6 - 7 + x = 27"></div>'
                . '<div data-math-block latex="4x - 1 = 27"></div>'
                . '<div data-math-block latex="4x = 28"></div>'
                . '<div data-math-block latex="x = 7"></div>'
                . '<p><strong>Odgovor:</strong> Zamisljeni broj je 7.</p>'],

            [41, 233, 'Zadatak 233',
                '<h2>Zadatak 233</h2>'
                . '<p>Dve marame i 4 magneta kostaju 830 dinara. Marama kosta 3 puta vise od magneta. Koliko kosta marama, a koliko magnet?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Neka je m cena magneta, onda je marama 3m.</p>'
                . '<div data-math-block latex="2 \cdot 3m + 4m = 830"></div>'
                . '<div data-math-block latex="6m + 4m = 830"></div>'
                . '<div data-math-block latex="10m = 830"></div>'
                . '<div data-math-block latex="m = 83 \text{ din}"></div>'
                . '<div data-math-block latex="\text{Marama: } 3 \cdot 83 = 249 \text{ din}"></div>'
                . '<p><strong>Odgovor:</strong> Marama: 249 din, magnet: 83 din.</p>'],

            [41, 234, 'Zadatak 234',
                '<h2>Zadatak 234</h2>'
                . '<p>Cetvorougao je kvadrat. Odredi a iz uslova da su stranice jednake:</p>'
                . '<div data-math-block latex="\frac{1}{3}a + 0{,}5 = 2a - 7"></div>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="\frac{1}{3}a + 0{,}5 = 2a - 7"></div>'
                . '<div data-math-block latex="0{,}5 + 7 = 2a - \frac{1}{3}a"></div>'
                . '<div data-math-block latex="7{,}5 = \frac{6a - a}{3} = \frac{5a}{3}"></div>'
                . '<div data-math-block latex="5a = 22{,}5"></div>'
                . '<div data-math-block latex="a = 4{,}5"></div>'
                . '<p><strong>Odgovor:</strong> a = 4,5</p>'],

            [41, 235, 'Zadatak 235',
                '<h2>Zadatak 235</h2>'
                . '<p>U triatlonu takmicar pliva 3/100 ukupne distance, trci 1/5, a ostatak vozi bicikl. Pretrcao je 4 km. Koliko je presao biciklom?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Trcanje je 1/5 ukupne distance:</p>'
                . '<div data-math-block latex="\frac{1}{5} \cdot D = 4 \text{ km}"></div>'
                . '<div data-math-block latex="D = 20 \text{ km}"></div>'
                . '<p>Plivanje:</p>'
                . '<div data-math-block latex="\frac{3}{100} \cdot 20 = 0{,}6 \text{ km}"></div>'
                . '<p>Bicikl:</p>'
                . '<div data-math-block latex="20 - 0{,}6 - 4 = 15{,}4 \text{ km}"></div>'
                . '<p><strong>Odgovor:</strong> Biciklom je presao 15,4 km.</p>'],

            [41, 236, 'Zadatak 236',
                '<h2>Zadatak 236</h2>'
                . '<p>Obim pravougaonika je 50 cm. Stranice su (a - 2) i (2a + 3). Odredi a.</p>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="2 \cdot ((a - 2) + (2a + 3)) = 50"></div>'
                . '<div data-math-block latex="2 \cdot (3a + 1) = 50"></div>'
                . '<div data-math-block latex="6a + 2 = 50"></div>'
                . '<div data-math-block latex="6a = 48"></div>'
                . '<div data-math-block latex="a = 8"></div>'
                . '<p><strong>Odgovor:</strong> a = 8 cm</p>'],
        ];

        foreach ($tasks as [$sc, $order, $title, $content]) {
            if (Lesson::where('course_id', 11)->where('title', $title)->exists()) continue;
            Lesson::create([
                'course_id' => 11,
                'subchapter_id' => $sc,
                'title' => $title,
                'order' => $order,
                'is_assignment' => false,
                'content' => $content,
            ]);
        }

        echo "Done!\n";
    }
}
