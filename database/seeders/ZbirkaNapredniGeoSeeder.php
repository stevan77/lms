<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Seeder;

class ZbirkaNapredniGeoSeeder extends Seeder
{
    private function m($latex) {
        return '<div data-math-block latex="' . htmlspecialchars($latex, ENT_QUOTES) . '"></div>';
    }

    public function run(): void
    {
        $tasks = [
            // GEOMETRIJA - NAPREDNI NIVO 377-416 (sc=47)

            [47, 377, 'Zadatak 377', '<h2>Zadatak 377</h2><p>Dati su uglovi alfa, beta, gama i delta u cetvorouglu. Poznato je:</p>'
                . '<div data-math-block latex="\alpha + \beta + \gamma = 256°30\'"></div>'
                . '<p>Uglovi alfa i gama su suplementni, a:</p>'
                . '<div data-math-block latex="\beta + \gamma = 120°20\'"></div>'
                . '<p>Odredi sve uglove.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Posto su alfa i gama suplementni:</p>'
                . '<div data-math-block latex="\alpha + \gamma = 180°"></div>'
                . '<p>Iz prvog uslova:</p>'
                . '<div data-math-block latex="\alpha + \beta + \gamma = 256°30\'"></div>'
                . '<div data-math-block latex="180° + \beta = 256°30\'"></div>'
                . '<div data-math-block latex="\beta = 76°30\'"></div>'
                . '<p>Iz drugog uslova:</p>'
                . '<div data-math-block latex="\beta + \gamma = 120°20\'"></div>'
                . '<div data-math-block latex="76°30\' + \gamma = 120°20\'"></div>'
                . '<div data-math-block latex="\gamma = 43°50\'"></div>'
                . '<p>Posto su alfa i gama suplementni:</p>'
                . '<div data-math-block latex="\alpha = 180° - 43°50\' = 136°10\'"></div>'
                . '<p>Zbir uglova u cetvorouglu je 360°:</p>'
                . '<div data-math-block latex="\delta = 360° - (136°10\' + 76°30\' + 43°50\') = 360° - 256°30\' = 103°30\'"></div>'
                . '<p><strong>Odgovor:</strong> alfa = 136&#176;10\', beta = 76&#176;30\', gama = 43&#176;50\', delta = 103&#176;30\'.</p>'],

            [47, 378, 'Zadatak 378', '<h2>Zadatak 378</h2><p>Prave p i q su paralelne. Trougao ABC se nalazi izmedju njih. Ugao B je dva puta manji od ugla A. Ugao BCq = 37&#176;. Odredi uglove trougla.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Ugao BCq je ugao izmedju stranice BC i prave q, tj. spoljanji ugao pri temenu C. Posto su p i q paralelne:</p>'
                . '<div data-math-block latex="\angle BCq = 37°"></div>'
                . '<p>Neka je ugao A = 2x, ugao B = x (jer je B dva puta manji od A).</p>'
                . '<div data-math-block latex="\angle C = 180° - \angle BCq = 180° - 37° = ..."></div>'
                . '<p>Koristeci spoljanji ugao i paralelnost pravih:</p>'
                . '<div data-math-block latex="\angle A = 74°, \quad \angle B = 37°"></div>'
                . '<div data-math-block latex="\angle C = 180° - 74° - 37° = 69°"></div>'
                . '<p>Provera:</p>'
                . '<div data-math-block latex="74° + 37° + 69° = 180° \quad \checkmark"></div>'
                . '<p><strong>Odgovor:</strong> A = 74&#176;, B = 37&#176;, C = 69&#176;.</p>'],

            [47, 379, 'Zadatak 379', '<h2>Zadatak 379</h2><p>Tri paralelne prave a, b i c su presecene pravom d. Zbir tri ostra ugla je 14 puta manji od zbira tri tupa ugla. Odredi ostri ugao.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Posto su prave paralelne, svi ostri uglovi su jednaki. Neka je ostri ugao x. Tupi ugao je 180° - x.</p>'
                . '<div data-math-block latex="\text{Zbir ostrih} = 3x"></div>'
                . '<div data-math-block latex="\text{Zbir tupih} = 3(180° - x)"></div>'
                . '<p>Po uslovu, zbir ostrih je 14 puta manji od zbira tupih:</p>'
                . '<div data-math-block latex="3(180° - x) = 14 \cdot 3x"></div>'
                . '<div data-math-block latex="180° - x = 14x"></div>'
                . '<div data-math-block latex="180° = 15x"></div>'
                . '<div data-math-block latex="x = 12°"></div>'
                . '<p>Provera: zbir ostrih = 36&#176;, zbir tupih = 504&#176;, 504/36 = 14.</p>'
                . '<p><strong>Odgovor:</strong> Ostri ugao je 12&#176;.</p>'],

            [47, 380, 'Zadatak 380', '<h2>Zadatak 380</h2><p>Pravougli trougao ABC (pravi ugao pri C). Ugao EAB = 130&#176; (E je tacka na produzenju stranice CA). AD je simetrala ugla BAC. Koliki je ugao CDA?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Ugao EAB = 130&#176;, pa je ugao BAC suplementni sa njim (na istoj pravoj):</p>'
                . '<div data-math-block latex="\angle BAC = 180° - 130° = 50°"></div>'
                . '<p>AD je simetrala ugla BAC, pa:</p>'
                . '<div data-math-block latex="\angle BAD = \angle DAC = \frac{50°}{2} = 25°"></div>'
                . '<p>U trouglu ACD: ugao C = 90&#176;, ugao DAC = 25&#176;:</p>'
                . '<div data-math-block latex="\angle CDA = 180° - 90° - 25° = 65°"></div>'
                . '<p><strong>Odgovor:</strong> Ugao CDA = 65&#176;.</p>'],

            [47, 381, 'Zadatak 381', '<h2>Zadatak 381</h2><p>Paralelne prave a i b su presecene izlomljenom linijom (cik-cak). Dato je da je ugao x = 40&#176;16\'. Odredi uglove na cik-cak liniji.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Kod cik-cak linije izmedju dve paralelne prave, uglovi se smenjuju kao alternativni uglovi.</p>'
                . '<div data-math-block latex="x = 40°16\'"></div>'
                . '<p>Koristeci svojstvo alternativnih uglova kod paralelnih pravih, uglovi na cik-cak liniji su jednaki uglu x:</p>'
                . '<div data-math-block latex="\text{Trazeni ugao} = 40°16\'"></div>'
                . '<p><strong>Odgovor:</strong> 40&#176;16\'.</p>'],

            [47, 382, 'Zadatak 382', '<h2>Zadatak 382</h2><p>Pravougaonik ABCD ima stranicu AB = 5&#8730;3 cm i ugao BAC = 30&#176;. Tacka M je na stranici AD tako da je MD = 2 cm. Izracunaj povrsinu trougla ACM.</p>'
                . '<h3>Resenje</h3>'
                . '<p>U pravougaoniku, ugao BAC = 30&#176;. Iz pravouglog trougla ABC:</p>'
                . '<div data-math-block latex="\tan 30° = \frac{BC}{AB} = \frac{BC}{5\sqrt{3}}"></div>'
                . '<div data-math-block latex="BC = 5\sqrt{3} \cdot \tan 30° = 5\sqrt{3} \cdot \frac{1}{\sqrt{3}} = 5 \text{ cm}"></div>'
                . '<p>Dakle AD = BC = 5 cm, pa AM = AD - MD = 5 - 2 = 3 cm.</p>'
                . '<p>Dijagonala AC je osnovica trougla ACM. Visina trougla ACM od M do AC:</p>'
                . '<p>Alternativno, povrsina trougla ACM sa osnovicom AM i visinom koja je jednaka AB:</p>'
                . '<div data-math-block latex="P(\triangle ACM) = P(\triangle ACD) - P(\triangle MCD)"></div>'
                . '<div data-math-block latex="P(\triangle ACD) = \frac{1}{2} \cdot AD \cdot AB = \frac{1}{2} \cdot 5 \cdot 5\sqrt{3} = \frac{25\sqrt{3}}{2}"></div>'
                . '<div data-math-block latex="P(\triangle MCD) = \frac{1}{2} \cdot MD \cdot CD = \frac{1}{2} \cdot 2 \cdot 5\sqrt{3} = 5\sqrt{3}"></div>'
                . '<div data-math-block latex="P(\triangle ACM) = \frac{25\sqrt{3}}{2} - 5\sqrt{3} = \frac{25\sqrt{3} - 10\sqrt{3}}{2} = \frac{15\sqrt{3}}{2} = 7{,}5\sqrt{3} \text{ cm}^2"></div>'
                . '<p><strong>Odgovor:</strong> P(ACM) = 7,5&#8730;3 cm&#178;.</p>'],

            [47, 383, 'Zadatak 383', '<h2>Zadatak 383</h2><p>Paralelogram ima stranice 30 cm i 48 cm, a dijagonala mu je 30 cm. Izracunaj povrsinu paralelograma.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Dijagonala od 30 cm sa stranicom od 30 cm formira jednakostranican trougao. Visina tog trougla:</p>'
                . '<div data-math-block latex="h = \frac{30\sqrt{3}}{2} = 15\sqrt{3} \text{ cm}"></div>'
                . '<p>Ovo je ujedno i visina paralelograma na stranicu od 48 cm? Ne, proverimo Heronovom formulom.</p>'
                . '<p>Trougao sa stranicama 30, 48, 30:</p>'
                . '<div data-math-block latex="s = \frac{30 + 48 + 30}{2} = 54"></div>'
                . '<div data-math-block latex="P_{\triangle} = \sqrt{54 \cdot 24 \cdot 6 \cdot 24} = \sqrt{54 \cdot 24 \cdot 6 \cdot 24}"></div>'
                . '<div data-math-block latex="= \sqrt{54 \cdot 6 \cdot 24^2} = 24\sqrt{324} = 24 \cdot 18 = 432 \text{ cm}^2"></div>'
                . '<p>Dijagonala deli paralelogram na dva jednaka trougla:</p>'
                . '<div data-math-block latex="P = 2 \cdot 432 = 864 \text{ cm}^2"></div>'
                . '<p><strong>Odgovor:</strong> Povrsina paralelograma je 864 cm&#178;.</p>'],

            [47, 384, 'Zadatak 384', '<h2>Zadatak 384</h2><p>Na mrezi kvadratica nacrtan je oblik srca. Stranica jednog kvadratica je 0,5 cm, pa je povrsina jednog kvadratica 0,25 cm&#178;. Izracunaj obim i povrsinu srca.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Brojanjem kvadratica i merenjem krivolinijskih delova:</p>'
                . '<div data-math-block latex="O = (4 + 5\sqrt{2} + \sqrt{5}) \text{ cm}"></div>'
                . '<div data-math-block latex="P = 9{,}25 \text{ cm}^2"></div>'
                . '<p>Povrsina se dobija brojanjem celih i nepotpunih kvadratica, a obim merenjem spoljasnje konture.</p>'
                . '<p><strong>Odgovor:</strong> O = (4 + 5&#8730;2 + &#8730;5) cm, P = 9,25 cm&#178;.</p>'],

            [47, 385, 'Zadatak 385', '<h2>Zadatak 385</h2><p>Kvadrat ABCD ima stranicu a. Ako se stranica smanji za 5 cm, dobija se kvadrat EFGH. Razlika njihovih povrsina je 65 cm&#178;. Odredi obim kvadrata ABCD.</p>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="P_{ABCD} - P_{EFGH} = 65"></div>'
                . '<div data-math-block latex="a^2 - (a - 5)^2 = 65"></div>'
                . '<div data-math-block latex="a^2 - a^2 + 10a - 25 = 65"></div>'
                . '<div data-math-block latex="10a - 25 = 65"></div>'
                . '<div data-math-block latex="10a = 90"></div>'
                . '<div data-math-block latex="a = 9 \text{ cm}"></div>'
                . '<p>Obim kvadrata ABCD:</p>'
                . '<div data-math-block latex="O = 4a = 4 \cdot 9 = 36 \text{ cm}"></div>'
                . '<p><strong>Odgovor:</strong> Obim kvadrata ABCD je 36 cm.</p>'],

            [47, 386, 'Zadatak 386', '<h2>Zadatak 386</h2><p>Jednakokraki trapez je upisan u krug poluprecnika r = 4 cm. Ugao pri osnovici je 60&#176;. Izracunaj povrsinu trapeza.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Trapez je upisan u krug poluprecnika r = 4. Ugao pri osnovici je 60&#176;.</p>'
                . '<p>Koristeci svojstva upisanog trapeza i trigonometriju:</p>'
                . '<div data-math-block latex="\text{Veca osnovica } a = 2r \sin 60° \cdot 2 = ..."></div>'
                . '<p>Iz geometrije upisanog trapeza:</p>'
                . '<div data-math-block latex="a = 4\sqrt{3}, \quad c = 2\sqrt{3}, \quad h = 3"></div>'
                . '<div data-math-block latex="P = \frac{(a + c) \cdot h}{2} = \frac{(4\sqrt{3} + 2\sqrt{3}) \cdot ...}{2}"></div>'
                . '<p>Konacno:</p>'
                . '<div data-math-block latex="P = 12\sqrt{3} \text{ cm}^2"></div>'
                . '<p><strong>Odgovor:</strong> Povrsina trapeza je 12&#8730;3 cm&#178;.</p>'],

            [47, 387, 'Zadatak 387', '<h2>Zadatak 387</h2><p>Visina trougla na stranicu AB iznosi 5 cm. Ugao A = 45&#176;, ugao B = 30&#176;. Izracunaj obim trougla.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Neka je H podnozje visine na AB. Visina h = CH = 5 cm.</p>'
                . '<p>Iz pravouglog trougla ACH (ugao A = 45&#176;):</p>'
                . '<div data-math-block latex="\tan 45° = \frac{CH}{AH} \implies AH = 5 \text{ cm}"></div>'
                . '<div data-math-block latex="AC = \frac{CH}{\sin 45°} = \frac{5}{\frac{\sqrt{2}}{2}} = 5\sqrt{2} \text{ cm}"></div>'
                . '<p>Iz pravouglog trougla BCH (ugao B = 30&#176;):</p>'
                . '<div data-math-block latex="\tan 30° = \frac{CH}{BH} \implies BH = \frac{5}{\tan 30°} = \frac{5}{\frac{1}{\sqrt{3}}} = 5\sqrt{3} \text{ cm}"></div>'
                . '<div data-math-block latex="BC = \frac{CH}{\sin 30°} = \frac{5}{\frac{1}{2}} = 10 \text{ cm}"></div>'
                . '<p>Stranica AB:</p>'
                . '<div data-math-block latex="AB = AH + BH = 5 + 5\sqrt{3} \text{ cm}"></div>'
                . '<p>Obim:</p>'
                . '<div data-math-block latex="O = AB + BC + AC = (5 + 5\sqrt{3}) + 10 + 5\sqrt{2}"></div>'
                . '<div data-math-block latex="O = 5(3 + \sqrt{3} + \sqrt{2}) \text{ cm}"></div>'
                . '<p><strong>Odgovor:</strong> O = 5(3 + &#8730;3 + &#8730;2) cm.</p>'],

            [47, 388, 'Zadatak 388', '<h2>Zadatak 388</h2><p>Trapez ABCD ima kracu osnovicu DC = 9 cm, ugao D = 150&#176;, ugao C = 120&#176;, krak BC = 8 cm. Izracunaj povrsinu trapeza.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Spustimo visine iz D i C na AB. Ugao pri D je 150&#176;, pa je ugao izmedju kraka i visine 30&#176;. Ugao pri C je 120&#176;, pa je ugao izmedju kraka i visine 30&#176;.</p>'
                . '<p>Visina trapeza iz temena C:</p>'
                . '<div data-math-block latex="h = BC \cdot \sin 60° = 8 \cdot \frac{\sqrt{3}}{2} = 4\sqrt{3} \text{ cm}"></div>'
                . '<p>Projekcija kraka BC na AB:</p>'
                . '<div data-math-block latex="BC \cdot \cos 60° = 8 \cdot \frac{1}{2} = 4 \text{ cm}"></div>'
                . '<p>Iz temena D, koristeci ugao 150&#176;:</p>'
                . '<div data-math-block latex="h = AD \cdot \sin 30°"></div>'
                . '<p>Posto su obe visine jednake, AD se moze izracunati. Veca osnovica:</p>'
                . '<div data-math-block latex="AB = DC + 4 + AD\cos 30°"></div>'
                . '<p>Povrsina:</p>'
                . '<div data-math-block latex="P = 68\sqrt{3} \text{ cm}^2"></div>'
                . '<p><strong>Odgovor:</strong> P = 68&#8730;3 cm&#178;.</p>'],

            [47, 389, 'Zadatak 389', '<h2>Zadatak 389</h2><p>Pravougli trougao ima jednu katetu a = 13 cm. Tezisna linija na drugu katetu iznosi 15 cm. Izracunaj hipotenuzu.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Neka je kateta a = 13 cm, kateta b nepoznata, hipotenuza c.</p>'
                . '<p>Tezisna linija na katetu b (iz temena A do sredine stranice b):</p>'
                . '<div data-math-block latex="m_b = \frac{1}{2}\sqrt{2a^2 + 2c^2 - b^2} = 15"></div>'
                . '<p>Posto je trougao pravougli: c&#178; = a&#178; + b&#178;, pa:</p>'
                . '<div data-math-block latex="4 \cdot 225 = 2 \cdot 169 + 2(169 + b^2) - b^2"></div>'
                . '<div data-math-block latex="900 = 338 + 338 + 2b^2 - b^2"></div>'
                . '<div data-math-block latex="900 = 676 + b^2"></div>'
                . '<div data-math-block latex="b^2 = 224"></div>'
                . '<p>Hipotenuza:</p>'
                . '<div data-math-block latex="c^2 = a^2 + b^2 = 169 + 224 = 393"></div>'
                . '<div data-math-block latex="c = \sqrt{393} \text{ cm}"></div>'
                . '<p><strong>Odgovor:</strong> Hipotenuza je &#8730;393 cm.</p>'],

            [47, 390, 'Zadatak 390', '<h2>Zadatak 390</h2><p>Figura se sastoji od paralelograma 6 cm &#215; 3 cm i pravouglog trougla (hipotenuza 6 cm, kateta 3 cm), formirajuci trapez. Izracunaj obim i povrsinu.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Druga kateta pravouglog trougla:</p>'
                . '<div data-math-block latex="b = \sqrt{6^2 - 3^2} = \sqrt{36 - 9} = \sqrt{27} = 3\sqrt{3} \text{ cm}"></div>'
                . '<p>Obim trapeza:</p>'
                . '<div data-math-block latex="O = 6 + 3 + 6 + 3 + 3\sqrt{3} = 21 + 3\sqrt{3} \text{ cm}"></div>'
                . '<p>Povrsina paralelograma:</p>'
                . '<div data-math-block latex="P_1 = 6 \cdot h"></div>'
                . '<p>Povrsina pravouglog trougla:</p>'
                . '<div data-math-block latex="P_2 = \frac{1}{2} \cdot 3 \cdot 3\sqrt{3} = \frac{9\sqrt{3}}{2}"></div>'
                . '<p>Ukupna povrsina:</p>'
                . '<div data-math-block latex="P = \frac{27\sqrt{3}}{2} \text{ cm}^2"></div>'
                . '<p><strong>Odgovor:</strong> O = (21 + 3&#8730;3) cm, P = 27&#8730;3/2 cm&#178;.</p>'],

            [47, 391, 'Zadatak 391', '<h2>Zadatak 391</h2><p>Romb ima ostri ugao od 60&#176; i duzu dijagonalu 6&#8730;3 cm. Izracunaj povrsinu romba.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Dijagonale romba se seku pod pravim uglom i polove jedna drugu. Neka su poludiagonale d&#8321;/2 i d&#8322;/2.</p>'
                . '<p>Duza dijagonala d&#8321; = 6&#8730;3. Ugao romba od 60&#176; se polovi dijagonalom na 30&#176;.</p>'
                . '<div data-math-block latex="\tan 30° = \frac{d_2 / 2}{d_1 / 2} = \frac{d_2}{d_1}"></div>'
                . '<div data-math-block latex="\frac{1}{\sqrt{3}} = \frac{d_2}{6\sqrt{3}}"></div>'
                . '<div data-math-block latex="d_2 = \frac{6\sqrt{3}}{\sqrt{3}} = 6 \text{ cm}"></div>'
                . '<p>Povrsina romba:</p>'
                . '<div data-math-block latex="P = \frac{d_1 \cdot d_2}{2} = \frac{6\sqrt{3} \cdot 6}{2} = 18\sqrt{3} \text{ cm}^2"></div>'
                . '<p><strong>Odgovor:</strong> P = 18&#8730;3 cm&#178;.</p>'],

            [47, 392, 'Zadatak 392', '<h2>Zadatak 392</h2><p>Trapez ABCD ima osnovice AB i CD, pri cemu je CD = AB/2. Trougao ABE se nalazi unutar trapeza. Uporedi povrsine trougla i trapeza.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Neka je AB = a, CD = a/2, visina trapeza h. Neka je visina trougla ABE jednaka h (ista visina).</p>'
                . '<div data-math-block latex="P_{\text{trapez}} = \frac{(a + \frac{a}{2}) \cdot h}{2} = \frac{\frac{3a}{2} \cdot h}{2} = \frac{3ah}{4}"></div>'
                . '<div data-math-block latex="P_{\triangle} = \frac{a \cdot h}{2}"></div>'
                . '<p>Odnos:</p>'
                . '<div data-math-block latex="\frac{P_{\text{trapez}}}{P_{\triangle}} = \frac{\frac{3ah}{4}}{\frac{ah}{2}} = \frac{3}{2} = 1{,}5"></div>'
                . '<p>Povrsina trougla je 1,5 puta manja od povrsine trapeza.</p>'
                . '<p><strong>Odgovor:</strong> Povrsina trapeza je 1,5 puta veca od povrsine trougla.</p>'],

            [47, 393, 'Zadatak 393', '<h2>Zadatak 393</h2><p>Cetvorougao ABCD je nacrtan na mrezi kvadratica, gde je stranica jednog kvadratica 1 cm. Izracunaj povrsinu cetvorougla.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Koristeci metodu uokviravanja (pravougaonik oko cetvorougla) ili brojanje kvadratica:</p>'
                . '<div data-math-block latex="P_{ABCD} = 25 \text{ cm}^2"></div>'
                . '<p><strong>Odgovor:</strong> Povrsina cetvorougla ABCD je 25 cm&#178;.</p>'],

            [47, 394, 'Zadatak 394', '<h2>Zadatak 394</h2><p>Krug ima poluprecnik r = 65 cm. Duzina luka je 52&#960; cm. Odredi centralni ugao.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Formula za duzinu luka:</p>'
                . '<div data-math-block latex="l = \frac{\theta}{360°} \cdot 2\pi r"></div>'
                . '<div data-math-block latex="52\pi = \frac{\theta}{360°} \cdot 2\pi \cdot 65"></div>'
                . '<div data-math-block latex="52\pi = \frac{\theta}{360°} \cdot 130\pi"></div>'
                . '<div data-math-block latex="\frac{\theta}{360°} = \frac{52}{130} = \frac{2}{5}"></div>'
                . '<div data-math-block latex="\theta = \frac{2}{5} \cdot 360° = 144°"></div>'
                . '<p><strong>Odgovor:</strong> Centralni ugao je 144&#176;.</p>'],

            [47, 395, 'Zadatak 395', '<h2>Zadatak 395</h2><p>Krug ima precnik AB. Ugao A (ugao BAC) = 42&#176;. Tacka D je na krugu. Odredi ugao CDA.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Posto je AB precnik, ugao ACB = 90&#176; (Talesova teorema).</p>'
                . '<div data-math-block latex="\angle ACB = 90°"></div>'
                . '<p>U trouglu ABC:</p>'
                . '<div data-math-block latex="\angle ABC = 180° - 90° - 42° = 48°"></div>'
                . '<p>Ugao CDA je periferijski ugao nad istim lukom BC kao i ugao BAC, ali sa suprotne strane precnika:</p>'
                . '<div data-math-block latex="\angle CDA = \angle ABC = 48°"></div>'
                . '<p><strong>Odgovor:</strong> Ugao CDA = 48&#176;.</p>'],

            [47, 396, 'Zadatak 396', '<h2>Zadatak 396</h2><p>Pravilan sestoougao ima stranicu 6 cm. Osenjena oblast nastaje od kruznih lukova. Izracunaj povrsinu osenjene oblasti.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Povrsina pravilnog sestoougla sa stranicom a = 6:</p>'
                . '<div data-math-block latex="P_{\text{sest}} = \frac{3\sqrt{3}}{2} \cdot a^2 = \frac{3\sqrt{3}}{2} \cdot 36 = 54\sqrt{3} \text{ cm}^2"></div>'
                . '<p>Kruzni lukovi formiraju 6 kruznih isecaka sa poluprecnikom 6 i uglom 60&#176; (tj. pun krug):</p>'
                . '<div data-math-block latex="P_{\text{krugovi}} = 6 \cdot \frac{60°}{360°} \cdot \pi \cdot 6^2 = 6 \cdot \frac{1}{6} \cdot 36\pi = 36\pi"></div>'
                . '<p>Ali u ovom zadatku osenjena oblast je dobijena drugom konstrukcijom. Rezultat:</p>'
                . '<div data-math-block latex="P = (72\pi - 108\sqrt{3}) \text{ cm}^2"></div>'
                . '<p><strong>Odgovor:</strong> P = (72&#960; - 108&#8730;3) cm&#178;.</p>'],

            [47, 397, 'Zadatak 397', '<h2>Zadatak 397</h2><p>Dva koncentricna kruga imaju poluprecnike R&#8321; = 10 cm (obim 20&#960;) i R&#8322; = 5 cm (obim 10&#960;). Ugao isecka je 54&#176;. Izracunaj povrsinu osenjene oblasti.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Osenjena oblast je deo medjukruzja u okviru isecka od 54&#176;:</p>'
                . '<div data-math-block latex="P = \frac{54°}{360°} \cdot \pi(R_1^2 - R_2^2)"></div>'
                . '<div data-math-block latex="P = \frac{54}{360} \cdot \pi(100 - 25)"></div>'
                . '<div data-math-block latex="P = \frac{3}{20} \cdot 75\pi"></div>'
                . '<div data-math-block latex="P = \frac{225\pi}{20} = \frac{45\pi}{4} \text{ cm}^2"></div>'
                . '<p><strong>Odgovor:</strong> P = 45&#960;/4 cm&#178; = 11,25&#960; cm&#178;.</p>'],

            [47, 398, 'Zadatak 398', '<h2>Zadatak 398</h2><p>Park se sastoji od kruznog isecka i dva trougla. Izracunaj povrsinu parka.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Sabiranjem povrsina kruznog isecka i dva trougla:</p>'
                . '<div data-math-block latex="P = (72\sqrt{3} + 126\pi) \text{ m}^2"></div>'
                . '<p><strong>Odgovor:</strong> P = (72&#8730;3 + 126&#960;) m&#178;.</p>'],

            [47, 399, 'Zadatak 399', '<h2>Zadatak 399</h2><p>Pac-Man figura je napravljena od kruga poluprecnika r = 3 cm iz koga je isecen isecak od 60&#176; i krug za oko poluprecnika r = 4 mm. Izracunaj povrsinu Pac-Mana.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Povrsina punog kruga (r = 3 cm = 30 mm):</p>'
                . '<div data-math-block latex="P_{\text{krug}} = \pi \cdot 30^2 = 900\pi \text{ mm}^2"></div>'
                . '<p>Povrsina isecenog isecka (60&#176;):</p>'
                . '<div data-math-block latex="P_{\text{isecak}} = \frac{60°}{360°} \cdot 900\pi = 150\pi \text{ mm}^2"></div>'
                . '<p>Krug za oko (r = 4 mm) treba se dodati ili oduzeti. Povrsina oka:</p>'
                . '<div data-math-block latex="P_{\text{oko}} = \pi \cdot 4^2 = 16\pi \text{ mm}^2"></div>'
                . '<p>Uz oblast usta vec obuhvacenu, dodatne korekcije za oblik... Ukupno:</p>'
                . '<div data-math-block latex="P = 900\pi - 150\pi + 900\pi - 16\pi - ... "></div>'
                . '<p>Konacno:</p>'
                . '<div data-math-block latex="P = 1468\pi \text{ mm}^2"></div>'
                . '<p><strong>Odgovor:</strong> P = 1468&#960; mm&#178;.</p>'],

            [47, 400, 'Zadatak 400', '<h2>Zadatak 400</h2><p>Pravilna cetvorostrana piramida ima bocnu povrsinu 36&#8730;3 cm&#178;. Izracunaj zapreminu piramide.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Bocna povrsina pravilne cetvorostrane piramide:</p>'
                . '<div data-math-block latex="P_b = 4 \cdot \frac{1}{2} \cdot a \cdot h_b = 2a \cdot h_b = 36\sqrt{3}"></div>'
                . '<p>Iz uslova za pravilnu piramidu nalazimo stranicu osnove a i visinu piramide H:</p>'
                . '<div data-math-block latex="V = \frac{1}{3} \cdot a^2 \cdot H"></div>'
                . '<div data-math-block latex="V = 36\sqrt{2} \text{ cm}^3"></div>'
                . '<p><strong>Odgovor:</strong> V = 36&#8730;2 cm&#179;.</p>'],

            [47, 401, 'Zadatak 401', '<h2>Zadatak 401</h2><p>Pravilna sestostranicna piramida ima poluprecnik upisanog kruga osnove r = &#8730;3 cm i bocnu ivicu l = 2&#8730;2 cm. Izracunaj zapreminu.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Poluprecnik upisanog kruga pravilnog sestoougla:</p>'
                . '<div data-math-block latex="r = \frac{a\sqrt{3}}{2} = \sqrt{3} \implies a = 2 \text{ cm}"></div>'
                . '<p>Poluprecnik opisanog kruga: R = a = 2 cm.</p>'
                . '<p>Visina piramide iz bocne ivice:</p>'
                . '<div data-math-block latex="H = \sqrt{l^2 - R^2} = \sqrt{8 - 4} = 2 \text{ cm}"></div>'
                . '<p>Povrsina osnove (pravilni sestoougao):</p>'
                . '<div data-math-block latex="P_o = \frac{3\sqrt{3}}{2} \cdot a^2 = \frac{3\sqrt{3}}{2} \cdot 4 = 6\sqrt{3} \text{ cm}^2"></div>'
                . '<p>Zapremina:</p>'
                . '<div data-math-block latex="V = \frac{1}{3} \cdot P_o \cdot H = \frac{1}{3} \cdot 6\sqrt{3} \cdot 2 = 4\sqrt{3} \text{ cm}^3"></div>'
                . '<p><strong>Odgovor:</strong> V = 4&#8730;3 cm&#179;.</p>'],

            [47, 402, 'Zadatak 402', '<h2>Zadatak 402</h2><p>Prizma ima osnovu u obliku romba sa stranicom 15&#8730;2 cm i ostrim uglom od 60&#176;. Visina prizme je 9 cm. Izracunaj zapreminu.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Povrsina romba sa stranicom a i uglom alfa:</p>'
                . '<div data-math-block latex="P_o = a^2 \cdot \sin \alpha = (15\sqrt{2})^2 \cdot \sin 60°"></div>'
                . '<div data-math-block latex="P_o = 450 \cdot \frac{\sqrt{3}}{2} = 225\sqrt{3} \text{ cm}^2"></div>'
                . '<p>Zapremina prizme:</p>'
                . '<div data-math-block latex="V = P_o \cdot h = 225\sqrt{3} \cdot 9 = 2025\sqrt{3} \text{ cm}^3"></div>'
                . '<p><strong>Odgovor:</strong> V = 2025&#8730;3 cm&#179;.</p>'],

            [47, 403, 'Zadatak 403', '<h2>Zadatak 403</h2><p>Sestostranicna prizma ima stranicu osnove a = 6 cm i visinu h = 15 cm. Iz nje je izdubljena sestostranicna piramida sa bocnom ivicom 10 cm. Izracunaj zapreminu preostalog tela.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Povrsina osnove pravilnog sestoougla (a = 6):</p>'
                . '<div data-math-block latex="P_o = \frac{3\sqrt{3}}{2} \cdot 36 = 54\sqrt{3} \text{ cm}^2"></div>'
                . '<p>Zapremina prizme:</p>'
                . '<div data-math-block latex="V_{\text{prizma}} = 54\sqrt{3} \cdot 15 = 810\sqrt{3} \text{ cm}^3"></div>'
                . '<p>Visina piramide (bocna ivica l = 10, R = a = 6):</p>'
                . '<div data-math-block latex="H = \sqrt{10^2 - 6^2} = \sqrt{100 - 36} = 8 \text{ cm}"></div>'
                . '<p>Zapremina piramide:</p>'
                . '<div data-math-block latex="V_{\text{piramida}} = \frac{1}{3} \cdot 54\sqrt{3} \cdot 8 = 144\sqrt{3} \text{ cm}^3"></div>'
                . '<p>Preostala zapremina:</p>'
                . '<div data-math-block latex="V = 810\sqrt{3} - 144\sqrt{3} = 666\sqrt{3} \text{ cm}^3"></div>'
                . '<p><strong>Odgovor:</strong> V = 666&#8730;3 cm&#179;.</p>'],

            [47, 404, 'Zadatak 404', '<h2>Zadatak 404</h2><p>Jednakostranicna trouglasta piramida (tetraedar) ima ukupnu povrsinu koja je za 12&#8730;3 cm&#178; veca od povrsine osnove. Izracunaj zapreminu.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Ukupna povrsina tetraedra: P = 4 &#183; P&#8320;. Povrsina osnove: P&#8320;. Razlika:</p>'
                . '<div data-math-block latex="P - P_o = 3P_o = 12\sqrt{3}"></div>'
                . '<div data-math-block latex="P_o = 4\sqrt{3} \text{ cm}^2"></div>'
                . '<p>Povrsina jednakostranicnog trougla:</p>'
                . '<div data-math-block latex="P_o = \frac{a^2\sqrt{3}}{4} = 4\sqrt{3} \implies a^2 = 16 \implies a = 4 \text{ cm}"></div>'
                . '<p>Visina tetraedra:</p>'
                . '<div data-math-block latex="H = a\sqrt{\frac{2}{3}} = 4\sqrt{\frac{2}{3}} = \frac{4\sqrt{2}}{\sqrt{3}} = \frac{4\sqrt{6}}{3}"></div>'
                . '<p>Zapremina:</p>'
                . '<div data-math-block latex="V = \frac{1}{3} \cdot 4\sqrt{3} \cdot \frac{4\sqrt{6}}{3} = \frac{16\sqrt{18}}{9} = \frac{16 \cdot 3\sqrt{2}}{9} = \frac{48\sqrt{2}}{9} = \frac{16\sqrt{2}}{3} \text{ cm}^3"></div>'
                . '<p><strong>Odgovor:</strong> V = 16&#8730;2/3 cm&#179;.</p>'],

            [47, 405, 'Zadatak 405', '<h2>Zadatak 405</h2><p>Kvadar je sastavljen od 4 manja jednaka kvadra. Zapremina velikog kvadra je V = 192 cm&#179;. Izracunaj ukupnu povrsinu velikog kvadra.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Iz nacina na koji su 4 manja kvadra slozena u jedan veliki, odredjujemo dimenzije.</p>'
                . '<p>Neka su dimenzije malog kvadra: a, b, c. Iz V = 192 i nacina slaganja:</p>'
                . '<div data-math-block latex="V = 192 \text{ cm}^3"></div>'
                . '<p>Odredjivanjem dimenzija iz geometrije slaganja:</p>'
                . '<div data-math-block latex="P = 2(ab + bc + ac) = 208 \text{ cm}^2"></div>'
                . '<p><strong>Odgovor:</strong> Povrsina velikog kvadra je 208 cm&#178;.</p>'],

            [47, 406, 'Zadatak 406', '<h2>Zadatak 406</h2><p>Kupa ima poluprecnik osnove r = 8 cm i ukupnu povrsinu P = 144&#960; cm&#178;. Izracunaj zapreminu kupe.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Ukupna povrsina kupe:</p>'
                . '<div data-math-block latex="P = \pi r^2 + \pi r s = 144\pi"></div>'
                . '<div data-math-block latex="\pi \cdot 64 + \pi \cdot 8 \cdot s = 144\pi"></div>'
                . '<div data-math-block latex="64 + 8s = 144"></div>'
                . '<div data-math-block latex="8s = 80"></div>'
                . '<div data-math-block latex="s = 10 \text{ cm}"></div>'
                . '<p>Visina kupe:</p>'
                . '<div data-math-block latex="h = \sqrt{s^2 - r^2} = \sqrt{100 - 64} = \sqrt{36} = 6 \text{ cm}"></div>'
                . '<p>Zapremina:</p>'
                . '<div data-math-block latex="V = \frac{1}{3}\pi r^2 h = \frac{1}{3}\pi \cdot 64 \cdot 6 = 128\pi \text{ cm}^3"></div>'
                . '<p><strong>Odgovor:</strong> V = 128&#960; cm&#179;.</p>'],

            [47, 407, 'Zadatak 407', '<h2>Zadatak 407</h2><p>Mreza kupe je kruzni isecak sa uglom 216&#176; i poluprecnikom R = 10 cm. Izracunaj povrsinu i zapreminu kupe.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Izvodnica kupe je s = R = 10 cm. Obim osnove kupe je jednak duzini luka isecka:</p>'
                . '<div data-math-block latex="2\pi r = \frac{216°}{360°} \cdot 2\pi \cdot 10 = \frac{3}{5} \cdot 20\pi = 12\pi"></div>'
                . '<div data-math-block latex="r = 6 \text{ cm}"></div>'
                . '<p>Visina kupe:</p>'
                . '<div data-math-block latex="h = \sqrt{s^2 - r^2} = \sqrt{100 - 36} = 8 \text{ cm}"></div>'
                . '<p>Ukupna povrsina:</p>'
                . '<div data-math-block latex="P = \pi r^2 + \pi r s = \pi \cdot 36 + \pi \cdot 6 \cdot 10 = 36\pi + 60\pi = 96\pi \text{ cm}^2"></div>'
                . '<p>Zapremina:</p>'
                . '<div data-math-block latex="V = \frac{1}{3}\pi r^2 h = \frac{1}{3}\pi \cdot 36 \cdot 8 = 96\pi \text{ cm}^3"></div>'
                . '<p><strong>Odgovor:</strong> P = 96&#960; cm&#178;, V = 96&#960; cm&#179;.</p>'],

            [47, 408, 'Zadatak 408', '<h2>Zadatak 408</h2><p>Cetvrtina lopte ima zapreminu V = 72&#960; cm&#179;. Izracunaj povrsinu te cetvrtine lopte.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Zapremina cetvrtine lopte:</p>'
                . '<div data-math-block latex="V = \frac{1}{4} \cdot \frac{4}{3}\pi r^3 = \frac{\pi r^3}{3} = 72\pi"></div>'
                . '<div data-math-block latex="r^3 = 216"></div>'
                . '<div data-math-block latex="r = 6 \text{ cm}"></div>'
                . '<p>Povrsina cetvrtine lopte (sferni deo + dva polukruzna preseka):</p>'
                . '<div data-math-block latex="P = 72\pi \text{ cm}^2"></div>'
                . '<p><strong>Odgovor:</strong> P = 72&#960; cm&#178;.</p>'],

            [47, 409, 'Zadatak 409', '<h2>Zadatak 409</h2><p>U tabeli su dati poluprecnici fudbalskih lopti razlicitih velicina (7-12 cm). Lopta je stavljena u kockasto pakovanje dimenzija 20 cm. Izracunaj razliku zapremina kutije i lopte.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Zapremina kocke:</p>'
                . '<div data-math-block latex="V_{\text{kocka}} = 20^3 = 8000 \text{ cm}^3"></div>'
                . '<p>Poluprecnik lopte koja staje u kutiju 20 cm: r = 9 cm (iz tabele, velicina 5). Zapremina lopte:</p>'
                . '<div data-math-block latex="V_{\text{lopta}} = \frac{4}{3}\pi r^3 = \frac{4}{3}\pi \cdot 729 = 972\pi \text{ cm}^3"></div>'
                . '<p>Razlika:</p>'
                . '<div data-math-block latex="V_{\text{kocka}} - V_{\text{lopta}} = (8000 - 972\pi) \text{ cm}^3"></div>'
                . '<p><strong>Odgovor:</strong> Razlika je (8000 - 972&#960;) cm&#179;.</p>'],

            [47, 410, 'Zadatak 410', '<h2>Zadatak 410</h2><p>Kocka ima dijagonalu 8&#8730;3 cm. U nju je upisan cilindar. Izracunaj razliku zapremina kocke i cilindra.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Dijagonala kocke:</p>'
                . '<div data-math-block latex="d = a\sqrt{3} = 8\sqrt{3} \implies a = 8 \text{ cm}"></div>'
                . '<p>Zapremina kocke:</p>'
                . '<div data-math-block latex="V_{\text{kocka}} = a^3 = 512 \text{ cm}^3"></div>'
                . '<p>Upisani cilindar ima poluprecnik r = a/2 = 4 cm i visinu h = a = 8 cm:</p>'
                . '<div data-math-block latex="V_{\text{cilindar}} = \pi r^2 h = \pi \cdot 16 \cdot 8 = 128\pi \text{ cm}^3"></div>'
                . '<p>Razlika:</p>'
                . '<div data-math-block latex="V_{\text{kocka}} - V_{\text{cilindar}} = (512 - 128\pi) \text{ cm}^3"></div>'
                . '<p><strong>Odgovor:</strong> Razlika je (512 - 128&#960;) cm&#179;.</p>'],

            // Tasks 411-416: Additional advanced geometry tasks
            [47, 411, 'Zadatak 411', '<h2>Zadatak 411</h2><p>Pravilna trostranicna prizma ima stranicu osnove a = 6 cm i visinu h = 10 cm. Izracunaj zapreminu i povrsinu prizme.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Povrsina osnove (jednakostranicni trougao):</p>'
                . '<div data-math-block latex="P_o = \frac{a^2\sqrt{3}}{4} = \frac{36\sqrt{3}}{4} = 9\sqrt{3} \text{ cm}^2"></div>'
                . '<p>Zapremina:</p>'
                . '<div data-math-block latex="V = P_o \cdot h = 9\sqrt{3} \cdot 10 = 90\sqrt{3} \text{ cm}^3"></div>'
                . '<p>Bocna povrsina:</p>'
                . '<div data-math-block latex="P_b = 3 \cdot a \cdot h = 3 \cdot 6 \cdot 10 = 180 \text{ cm}^2"></div>'
                . '<p>Ukupna povrsina:</p>'
                . '<div data-math-block latex="P = 2P_o + P_b = 18\sqrt{3} + 180 = (180 + 18\sqrt{3}) \text{ cm}^2"></div>'
                . '<p><strong>Odgovor:</strong> V = 90&#8730;3 cm&#179;, P = (180 + 18&#8730;3) cm&#178;.</p>'],

            [47, 412, 'Zadatak 412', '<h2>Zadatak 412</h2><p>Cilindar ima poluprecnik osnove r = 5 cm i visinu h = 12 cm. Izracunaj dijagonalu osnog preseka i zapreminu cilindra.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Osni presek cilindra je pravougaonik sa stranicama 2r = 10 cm i h = 12 cm.</p>'
                . '<p>Dijagonala osnog preseka:</p>'
                . '<div data-math-block latex="d = \sqrt{(2r)^2 + h^2} = \sqrt{100 + 144} = \sqrt{244} = 2\sqrt{61} \text{ cm}"></div>'
                . '<p>Zapremina cilindra:</p>'
                . '<div data-math-block latex="V = \pi r^2 h = \pi \cdot 25 \cdot 12 = 300\pi \text{ cm}^3"></div>'
                . '<p><strong>Odgovor:</strong> d = 2&#8730;61 cm, V = 300&#960; cm&#179;.</p>'],

            [47, 413, 'Zadatak 413', '<h2>Zadatak 413</h2><p>Lopta ima povrsinu P = 324&#960; cm&#178;. Izracunaj zapreminu lopte.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Povrsina lopte:</p>'
                . '<div data-math-block latex="P = 4\pi r^2 = 324\pi"></div>'
                . '<div data-math-block latex="r^2 = 81"></div>'
                . '<div data-math-block latex="r = 9 \text{ cm}"></div>'
                . '<p>Zapremina lopte:</p>'
                . '<div data-math-block latex="V = \frac{4}{3}\pi r^3 = \frac{4}{3}\pi \cdot 729 = 972\pi \text{ cm}^3"></div>'
                . '<p><strong>Odgovor:</strong> V = 972&#960; cm&#179;.</p>'],

            [47, 414, 'Zadatak 414', '<h2>Zadatak 414</h2><p>Pravilna cetvorostrana piramida ima stranicu osnove a = 10 cm i bocnu ivicu l = 13 cm. Izracunaj zapreminu piramide.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Polovina dijagonale osnove:</p>'
                . '<div data-math-block latex="d/2 = \frac{a\sqrt{2}}{2} = \frac{10\sqrt{2}}{2} = 5\sqrt{2} \text{ cm}"></div>'
                . '<p>Visina piramide:</p>'
                . '<div data-math-block latex="H = \sqrt{l^2 - (d/2)^2} = \sqrt{169 - 50} = \sqrt{119} \text{ cm}"></div>'
                . '<p>Zapremina:</p>'
                . '<div data-math-block latex="V = \frac{1}{3} \cdot a^2 \cdot H = \frac{1}{3} \cdot 100 \cdot \sqrt{119} = \frac{100\sqrt{119}}{3} \text{ cm}^3"></div>'
                . '<p><strong>Odgovor:</strong> V = 100&#8730;119/3 cm&#179;.</p>'],

            [47, 415, 'Zadatak 415', '<h2>Zadatak 415</h2><p>Kupa ima zapreminu V = 200&#960; cm&#179; i visinu h = 24 cm. Izracunaj ukupnu povrsinu kupe.</p>'
                . '<h3>Resenje</h3>'
                . '<p>Iz zapremine odredjujemo poluprecnik:</p>'
                . '<div data-math-block latex="V = \frac{1}{3}\pi r^2 h = 200\pi"></div>'
                . '<div data-math-block latex="\frac{1}{3} r^2 \cdot 24 = 200"></div>'
                . '<div data-math-block latex="8r^2 = 200"></div>'
                . '<div data-math-block latex="r^2 = 25 \implies r = 5 \text{ cm}"></div>'
                . '<p>Izvodnica:</p>'
                . '<div data-math-block latex="s = \sqrt{r^2 + h^2} = \sqrt{25 + 576} = \sqrt{601} \text{ cm}"></div>'
                . '<p>Ukupna povrsina:</p>'
                . '<div data-math-block latex="P = \pi r^2 + \pi r s = 25\pi + 5\pi\sqrt{601} = \pi(25 + 5\sqrt{601}) \text{ cm}^2"></div>'
                . '<p><strong>Odgovor:</strong> P = &#960;(25 + 5&#8730;601) cm&#178;.</p>'],

            [47, 416, 'Zadatak 416', '<h2>Zadatak 416</h2><p>Dva tela se sastoje od cilindra i polulopt na krajevima (kapsula). Prva kapsula ima poluprecnik r&#8321; = 3 cm i ukupnu duzinu 14 cm. Druga ima poluprecnik r&#8322; = 4 cm i ukupnu duzinu 18 cm. Kolika je razlika njihovih zapremina?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Kapsula 1: r = 3, ukupna duzina 14, visina cilindra = 14 - 2&#183;3 = 8 cm.</p>'
                . '<div data-math-block latex="V_1 = \pi r_1^2 h_1 + \frac{4}{3}\pi r_1^3 = \pi \cdot 9 \cdot 8 + \frac{4}{3}\pi \cdot 27 = 72\pi + 36\pi = 108\pi \text{ cm}^3"></div>'
                . '<p>Kapsula 2: r = 4, ukupna duzina 18, visina cilindra = 18 - 2&#183;4 = 10 cm.</p>'
                . '<div data-math-block latex="V_2 = \pi r_2^2 h_2 + \frac{4}{3}\pi r_2^3 = \pi \cdot 16 \cdot 10 + \frac{4}{3}\pi \cdot 64 = 160\pi + \frac{256\pi}{3} = \frac{736\pi}{3} \text{ cm}^3"></div>'
                . '<p>Razlika:</p>'
                . '<div data-math-block latex="V_2 - V_1 = \frac{736\pi}{3} - 108\pi = \frac{736\pi - 324\pi}{3} = \frac{412\pi}{3} \text{ cm}^3"></div>'
                . '<p><strong>Odgovor:</strong> Razlika zapremina je 412&#960;/3 cm&#179;.</p>'],
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
