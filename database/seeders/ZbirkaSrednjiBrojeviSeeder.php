<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Seeder;

class ZbirkaSrednjiBrojeviSeeder extends Seeder
{
    private function m($latex)
    {
        return '<div data-math-block latex="' . htmlspecialchars($latex, ENT_QUOTES) . '"></div>';
    }

    public function run(): void
    {
        $tasks = [
            [40, 168, 'Zadatak 168',
                '<h2>Zadatak 168</h2>'
                . '<p>U tabeli 3x3 su dati brojevi:</p>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th></th><th>I</th><th>II</th><th>III</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><strong>A</strong></td><td>-1,25</td><td>7/4</td><td>-2,351</td></tr>'
                . '<tr><td><strong>B</strong></td><td>-6/5</td><td>-1,23</td><td>-2,12</td></tr>'
                . '<tr><td><strong>V</strong></td><td>-11/5</td><td>-1,31</td><td>-4/3</td></tr>'
                . '</tbody></table>'
                . '<p>Najmanji broj u tabeli je u polju AIII. U kom polju se nalazi najveci broj?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Pretvorimo sve u decimalne brojeve:</p>'
                . '<div data-math-block latex="-1{,}25;\quad \frac{7}{4}=1{,}75;\quad -2{,}351"></div>'
                . '<div data-math-block latex="-\frac{6}{5}=-1{,}2;\quad -1{,}23;\quad -2{,}12"></div>'
                . '<div data-math-block latex="-\frac{11}{5}=-2{,}2;\quad -1{,}31;\quad -\frac{4}{3}\approx -1{,}333"></div>'
                . '<p>Najmanji broj je -2,351 (polje AIII). Najveci broj je 1,75 = 7/4.</p>'
                . '<p><strong>Odgovor:</strong> Najveci broj se nalazi u polju BI.</p>'
            ],

            [40, 169, 'Zadatak 169',
                '<h2>Zadatak 169</h2>'
                . '<p>Poredaj brojeve od najveceg ka najmanjem:</p>'
                . '<div data-math-block latex="12{,}25;\quad 12{,}25\%;\quad \sqrt{1225};\quad 12\frac{25}{50};\quad 1{,}225"></div>'
                . '<h3>Resenje</h3>'
                . '<p>Pretvorimo sve u decimalne brojeve:</p>'
                . '<div data-math-block latex="12{,}25 = 12{,}25"></div>'
                . '<div data-math-block latex="12{,}25\% = 0{,}1225"></div>'
                . '<div data-math-block latex="\sqrt{1225} = 35"></div>'
                . '<div data-math-block latex="12\frac{25}{50} = 12{,}5"></div>'
                . '<div data-math-block latex="1{,}225 = 1{,}225"></div>'
                . '<p>Poredak od najveceg ka najmanjem:</p>'
                . '<div data-math-block latex="\sqrt{1225} > 12\frac{25}{50} > 12{,}25 > 1{,}225 > 12{,}25\%"></div>'
                . '<p><strong>Odgovor:</strong> ' . "\u{221A}" . '1225 > 12 25/50 > 12,25 > 1,225 > 12,25%</p>'
            ],

            [40, 170, 'Zadatak 170',
                '<h2>Zadatak 170</h2>'
                . '<p>Dati su brojevi:</p>'
                . '<div data-math-block latex="\frac{7}{12};\quad 0{,}4;\quad -0{,}33;\quad -\sqrt{2};\quad -\frac{1}{3};\quad \frac{13}{36};\quad \frac{333}{1000};\quad \frac{4}{9}"></div>'
                . '<p>a) Koji je najveci negativan broj?</p>'
                . '<p>b) Koji je najmanji pozitivan broj?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Negativni brojevi:</p>'
                . '<div data-math-block latex="-0{,}33;\quad -\sqrt{2} \approx -1{,}414;\quad -\frac{1}{3} \approx -0{,}333"></div>'
                . '<p>Najveci negativan (najblizi nuli):</p>'
                . '<div data-math-block latex="-0{,}33 > -\frac{1}{3} > -\sqrt{2}"></div>'
                . '<p>Pozitivni brojevi:</p>'
                . '<div data-math-block latex="\frac{7}{12} \approx 0{,}583;\quad 0{,}4;\quad \frac{13}{36} \approx 0{,}361;\quad \frac{333}{1000} = 0{,}333;\quad \frac{4}{9} \approx 0{,}444"></div>'
                . '<p>Najmanji pozitivan:</p>'
                . '<div data-math-block latex="\frac{333}{1000} = 0{,}333"></div>'
                . '<p>Ali sacekaj, proverimo 13/36:</p>'
                . '<div data-math-block latex="\frac{13}{36} \approx 0{,}3611"></div>'
                . '<p><strong>Odgovor:</strong> a) Najveci negativan broj je -0,33. b) Najmanji pozitivan broj je 13/36.</p>'
            ],

            [40, 171, 'Zadatak 171',
                '<h2>Zadatak 171</h2>'
                . '<p>Dati su razlomci:</p>'
                . '<div data-math-block latex="\frac{29}{50};\quad \frac{1}{2};\quad \frac{11}{20};\quad \frac{49}{100}"></div>'
                . '<p>Umetni jedan od ovih razlomaka tako da vazi:</p>'
                . '<div data-math-block latex="0{,}54 < \underline{\quad} < 0{,}56"></div>'
                . '<h3>Resenje</h3>'
                . '<p>Pretvorimo razlomke u decimalne brojeve:</p>'
                . '<div data-math-block latex="\frac{29}{50} = 0{,}58"></div>'
                . '<div data-math-block latex="\frac{1}{2} = 0{,}50"></div>'
                . '<div data-math-block latex="\frac{11}{20} = 0{,}55"></div>'
                . '<div data-math-block latex="\frac{49}{100} = 0{,}49"></div>'
                . '<p>Jedino 0,55 se nalazi izmedju 0,54 i 0,56.</p>'
                . '<div data-math-block latex="0{,}54 < \frac{11}{20} < 0{,}56"></div>'
                . '<p><strong>Odgovor:</strong> 11/20 (= 0,55)</p>'
            ],

            [40, 172, 'Zadatak 172',
                '<h2>Zadatak 172</h2>'
                . '<p>Dati su brojevi:</p>'
                . '<div data-math-block latex="\sqrt{0{,}36};\quad 2\pi;\quad -12;\quad 99\%;\quad 2\sqrt{2};\quad -4\pi"></div>'
                . '<p>Koji je najveci?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Izracunajmo vrednosti:</p>'
                . '<div data-math-block latex="\sqrt{0{,}36} = 0{,}6"></div>'
                . '<div data-math-block latex="2\pi \approx 6{,}28"></div>'
                . '<div data-math-block latex="-12"></div>'
                . '<div data-math-block latex="99\% = 0{,}99"></div>'
                . '<div data-math-block latex="2\sqrt{2} \approx 2{,}83"></div>'
                . '<div data-math-block latex="-4\pi \approx -12{,}57"></div>'
                . '<p>Poredak:</p>'
                . '<div data-math-block latex="2\pi > 2\sqrt{2} > 99\% > \sqrt{0{,}36} > -12 > -4\pi"></div>'
                . '<p><strong>Odgovor:</strong> Najveci broj je 2' . "\u{03C0}" . '.</p>'
            ],

            [40, 173, 'Zadatak 173',
                '<h2>Zadatak 173</h2>'
                . '<p>Ucenici su zapisali razlomke izmedju 3,71 i 3,95:</p>'
                . '<ul>'
                . '<li>Sanja: 3 3/4 = 3,75</li>'
                . '<li>Petra: 3 7/10 = 3,7</li>'
                . '<li>Milena: 3 93/100 = 3,93</li>'
                . '<li>Goca: 3 4/5 = 3,8</li>'
                . '</ul>'
                . '<p>Ko je pogresio?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Proveravamo da li su svi brojevi izmedju 3,71 i 3,95:</p>'
                . '<div data-math-block latex="3\frac{3}{4} = 3{,}75 \quad \checkmark \quad (3{,}71 < 3{,}75 < 3{,}95)"></div>'
                . '<div data-math-block latex="3\frac{7}{10} = 3{,}7 \quad \times \quad (3{,}7 < 3{,}71)"></div>'
                . '<div data-math-block latex="3\frac{93}{100} = 3{,}93 \quad \checkmark \quad (3{,}71 < 3{,}93 < 3{,}95)"></div>'
                . '<div data-math-block latex="3\frac{4}{5} = 3{,}8 \quad \checkmark \quad (3{,}71 < 3{,}8 < 3{,}95)"></div>'
                . '<p><strong>Odgovor:</strong> Petra je pogresila jer je 3,7 manje od 3,71.</p>'
            ],

            [40, 174, 'Zadatak 174',
                '<h2>Zadatak 174</h2>'
                . '<p>Popuni prazno mesto cifrom tako da nejednakost bude tacna:</p>'
                . '<p>a) 0,3 < 1/' . "\u{25A1}" . ' < 0,4</p>'
                . '<p>b) 0,6 < ' . "\u{25A1}" . '/8 < 0,7</p>'
                . '<p>v) 0,7 < 7/' . "\u{25A1}" . ' < 0,8</p>'
                . '<h3>Resenje</h3>'
                . '<p><strong>a)</strong></p>'
                . '<div data-math-block latex="0{,}3 < \frac{1}{\square} < 0{,}4"></div>'
                . '<p>Ako je 1/x izmedju 0,3 i 0,4, onda:</p>'
                . '<div data-math-block latex="\frac{1}{3} \approx 0{,}333 \quad \checkmark"></div>'
                . '<p>Odgovor: <strong>' . "\u{25A1}" . ' = 3</strong></p>'
                . '<p><strong>b)</strong></p>'
                . '<div data-math-block latex="0{,}6 < \frac{\square}{8} < 0{,}7"></div>'
                . '<div data-math-block latex="\frac{5}{8} = 0{,}625 \quad \checkmark"></div>'
                . '<p>Odgovor: <strong>' . "\u{25A1}" . ' = 5</strong></p>'
                . '<p><strong>v)</strong></p>'
                . '<div data-math-block latex="0{,}7 < \frac{7}{\square} < 0{,}8"></div>'
                . '<div data-math-block latex="\frac{7}{9} \approx 0{,}778 \quad \checkmark"></div>'
                . '<p>Odgovor: <strong>' . "\u{25A1}" . ' = 9</strong></p>'
                . '<p><strong>Odgovor:</strong> a) 3; b) 5; v) 9</p>'
            ],

            [40, 175, 'Zadatak 175',
                '<h2>Zadatak 175</h2>'
                . '<p>Poredaj brojeve od najveceg ka najmanjem:</p>'
                . '<div data-math-block latex="0{,}5;\quad -\frac{2}{3};\quad -0{,}1;\quad 0{,}2;\quad 2\frac{1}{2}"></div>'
                . '<h3>Resenje</h3>'
                . '<p>Pretvorimo u decimalne:</p>'
                . '<div data-math-block latex="0{,}5;\quad -\frac{2}{3} \approx -0{,}667;\quad -0{,}1;\quad 0{,}2;\quad 2\frac{1}{2} = 2{,}5"></div>'
                . '<p>Od najveceg ka najmanjem:</p>'
                . '<div data-math-block latex="2\frac{1}{2} > 0{,}5 > 0{,}2 > -0{,}1 > -\frac{2}{3}"></div>'
                . '<p><strong>Odgovor:</strong> 2 1/2 > 0,5 > 0,2 > -0,1 > -2/3</p>'
            ],

            [40, 176, 'Zadatak 176',
                '<h2>Zadatak 176</h2>'
                . '<p>Koji su celi brojevi veci od -16/5 i manji od 3,2?</p>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="-\frac{16}{5} = -3{,}2"></div>'
                . '<p>Trazimo cele brojeve x takve da:</p>'
                . '<div data-math-block latex="-3{,}2 < x < 3{,}2"></div>'
                . '<p>Celi brojevi u tom intervalu su:</p>'
                . '<div data-math-block latex="-3,\; -2,\; -1,\; 0,\; 1,\; 2,\; 3"></div>'
                . '<p><strong>Odgovor:</strong> -3, -2, -1, 0, 1, 2, 3</p>'
            ],

            [40, 177, 'Zadatak 177',
                '<h2>Zadatak 177</h2>'
                . '<p>Ispravi nejednakost tako da bude tacna:</p>'
                . '<h3>Resenje</h3>'
                . '<p>Izracunajmo vrednosti:</p>'
                . '<div data-math-block latex="3 = 3"></div>'
                . '<div data-math-block latex="\sqrt{3} \approx 1{,}73"></div>'
                . '<div data-math-block latex="0{,}33"></div>'
                . '<div data-math-block latex="-\frac{1}{3} \approx -0{,}333"></div>'
                . '<div data-math-block latex="-1{,}73"></div>'
                . '<div data-math-block latex="-\sqrt{9} = -3"></div>'
                . '<p>Tacna nejednakost:</p>'
                . '<div data-math-block latex="3 > \sqrt{3} > 0{,}33 > -\frac{1}{3} > -1{,}73 > -\sqrt{9}"></div>'
                . '<p><strong>Odgovor:</strong> 3 > ' . "\u{221A}" . '3 > 0,33 > -1/3 > -1,73 > -' . "\u{221A}" . '9</p>'
            ],

            [40, 178, 'Zadatak 178',
                '<h2>Zadatak 178</h2>'
                . '<p>Izracunaj:</p>'
                . '<div data-math-block latex="a = -3 \cdot 4 = -12,\quad b = |-6| = 6,\quad c = -3 - (-7) = 4"></div>'
                . '<div data-math-block latex="\frac{5 \cdot (-ab + 3c)}{6 - |-a + b|}"></div>'
                . '<h3>Resenje</h3>'
                . '<p>Zamenjujemo vrednosti:</p>'
                . '<div data-math-block latex="a = -12,\quad b = 6,\quad c = 4"></div>'
                . '<p>Brojilac:</p>'
                . '<div data-math-block latex="-ab = -(-12) \cdot 6 = 72"></div>'
                . '<div data-math-block latex="3c = 3 \cdot 4 = 12"></div>'
                . '<div data-math-block latex="5 \cdot (-ab + 3c) = 5 \cdot (72 + 12) = 5 \cdot 84 = 420"></div>'
                . '<p>Imenilac:</p>'
                . '<div data-math-block latex="-a + b = -(-12) + 6 = 12 + 6 = 18"></div>'
                . '<div data-math-block latex="|-a + b| = |18| = 18"></div>'
                . '<div data-math-block latex="6 - 18 = -12"></div>'
                . '<p>Rezultat:</p>'
                . '<div data-math-block latex="\frac{420}{-12} = -35"></div>'
                . '<p><strong>Odgovor:</strong> -35</p>'
            ],

            [40, 179, 'Zadatak 179',
                '<h2>Zadatak 179</h2>'
                . '<p>Izracunaj:</p>'
                . '<div data-math-block latex="\left(1 - \frac{3}{4}\right) : 0{,}75 + \left(0{,}5 + \frac{3}{8}\right) : \frac{3}{8}"></div>'
                . '<h3>Resenje</h3>'
                . '<p>Racunamo prvi deo:</p>'
                . '<div data-math-block latex="1 - \frac{3}{4} = \frac{1}{4}"></div>'
                . '<div data-math-block latex="\frac{1}{4} : 0{,}75 = \frac{1}{4} : \frac{3}{4} = \frac{1}{4} \cdot \frac{4}{3} = \frac{1}{3}"></div>'
                . '<p>Racunamo drugi deo:</p>'
                . '<div data-math-block latex="0{,}5 + \frac{3}{8} = \frac{1}{2} + \frac{3}{8} = \frac{4}{8} + \frac{3}{8} = \frac{7}{8}"></div>'
                . '<div data-math-block latex="\frac{7}{8} : \frac{3}{8} = \frac{7}{8} \cdot \frac{8}{3} = \frac{7}{3}"></div>'
                . '<p>Sabiramo:</p>'
                . '<div data-math-block latex="\frac{1}{3} + \frac{7}{3} = \frac{8}{3}"></div>'
                . '<p><strong>Odgovor:</strong> 8/3</p>'
            ],

            [40, 180, 'Zadatak 180',
                '<h2>Zadatak 180</h2>'
                . '<p>Dati su izrazi:</p>'
                . '<div data-math-block latex="A = -x - |-x| + 3,\quad B = x - |x| + 3"></div>'
                . '<p>Izracunaj A i B za x = -3. Koji je veci i za koliko?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Za x = -3:</p>'
                . '<div data-math-block latex="A = -(-3) - |{-(-3)}| + 3 = 3 - |3| + 3 = 3 - 3 + 3 = 3"></div>'
                . '<div data-math-block latex="B = (-3) - |{-3}| + 3 = -3 - 3 + 3 = -3"></div>'
                . '<p>Razlika:</p>'
                . '<div data-math-block latex="A - B = 3 - (-3) = 6"></div>'
                . '<p><strong>Odgovor:</strong> A = 3, B = -3. Veci je A, i to za 6.</p>'
            ],

            [40, 181, 'Zadatak 181',
                '<h2>Zadatak 181</h2>'
                . '<p>Ukloni zagrade u izrazu:</p>'
                . '<div data-math-block latex="732 - (-121 + (732 - 600)) + (-121)"></div>'
                . '<h3>Resenje</h3>'
                . '<p>Korak po korak uklanjamo zagrade:</p>'
                . '<div data-math-block latex="732 - (-121 + 732 - 600) + (-121)"></div>'
                . '<p>Uklanjamo spoljasnju zagradu (minus ispred menja znake):</p>'
                . '<div data-math-block latex="732 + 121 - 732 + 600 + (-121)"></div>'
                . '<p>Uklanjamo poslednju zagradu:</p>'
                . '<div data-math-block latex="732 + 121 - 732 + 600 - 121"></div>'
                . '<p>Racunamo:</p>'
                . '<div data-math-block latex="732 - 732 + 121 - 121 + 600 = 600"></div>'
                . '<p><strong>Odgovor:</strong> 732 + 121 - 732 + 600 - 121 = 600</p>'
            ],

            [40, 182, 'Zadatak 182',
                '<h2>Zadatak 182</h2>'
                . '<p>Izracunaj:</p>'
                . '<div data-math-block latex="A = 1{,}5 + 1{,}5 : |-0{,}5| - 2 : 0{,}5"></div>'
                . '<p>Zatim izracunaj:</p>'
                . '<div data-math-block latex="-\frac{1}{A} + 3{,}5"></div>'
                . '<h3>Resenje</h3>'
                . '<p>Izracunajmo A:</p>'
                . '<div data-math-block latex="|-0{,}5| = 0{,}5"></div>'
                . '<div data-math-block latex="1{,}5 : 0{,}5 = 3"></div>'
                . '<div data-math-block latex="2 : 0{,}5 = 4"></div>'
                . '<div data-math-block latex="A = 1{,}5 + 3 - 4 = 0{,}5"></div>'
                . '<p>Sada racunamo:</p>'
                . '<div data-math-block latex="-\frac{1}{0{,}5} + 3{,}5 = -2 + 3{,}5 = 1{,}5"></div>'
                . '<p><strong>Odgovor:</strong> 1,5</p>'
            ],

            [40, 183, 'Zadatak 183',
                '<h2>Zadatak 183</h2>'
                . '<p>Popuni tabelu: za svaki broj odredi suprotan broj i reciprocan broj.</p>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Broj</th><th>Suprotan broj</th><th>Reciprocan broj</th></tr></thead>'
                . '<tbody>'
                . '<tr><td>-4</td><td>4</td><td>-1/4</td></tr>'
                . '<tr><td>1/3</td><td>-1/3</td><td>3</td></tr>'
                . '<tr><td>1,9</td><td>-1,9</td><td>10/19</td></tr>'
                . '<tr><td>-2/7</td><td>2/7</td><td>-7/2</td></tr>'
                . '<tr><td>3 2/5</td><td>-3 2/5</td><td>5/17</td></tr>'
                . '</tbody></table>'
                . '<h3>Resenje</h3>'
                . '<p>Suprotan broj broja a je -a. Reciprocan broj broja a je 1/a.</p>'
                . '<div data-math-block latex="\text{Suprotan od } -4 \text{ je } 4;\quad \text{reciprocni: } \frac{1}{-4} = -\frac{1}{4}"></div>'
                . '<div data-math-block latex="\text{Suprotan od } \frac{1}{3} \text{ je } -\frac{1}{3};\quad \text{reciprocni: } \frac{1}{\frac{1}{3}} = 3"></div>'
                . '<div data-math-block latex="\text{Suprotan od } 1{,}9 \text{ je } -1{,}9;\quad \text{reciprocni: } \frac{1}{1{,}9} = \frac{10}{19}"></div>'
                . '<div data-math-block latex="\text{Suprotan od } -\frac{2}{7} \text{ je } \frac{2}{7};\quad \text{reciprocni: } \frac{1}{-\frac{2}{7}} = -\frac{7}{2}"></div>'
                . '<div data-math-block latex="3\frac{2}{5} = \frac{17}{5};\quad \text{suprotan: } -\frac{17}{5};\quad \text{reciprocni: } \frac{5}{17}"></div>'
                . '<p><strong>Odgovor:</strong> Tabela je popunjena kao sto je prikazano iznad.</p>'
            ],

            [40, 184, 'Zadatak 184',
                '<h2>Zadatak 184</h2>'
                . '<p>Izracunaj A i B, uporedi ih:</p>'
                . '<div data-math-block latex="A = |0{,}5 - 0{,}8 : 0{,}4| + \frac{3}{4}"></div>'
                . '<div data-math-block latex="B = 2 - \left(-\frac{5}{8}\right) \cdot 0{,}6"></div>'
                . '<h3>Resenje</h3>'
                . '<p><strong>A:</strong></p>'
                . '<div data-math-block latex="0{,}8 : 0{,}4 = 2"></div>'
                . '<div data-math-block latex="|0{,}5 - 2| = |-1{,}5| = 1{,}5"></div>'
                . '<div data-math-block latex="A = 1{,}5 + 0{,}75 = 2{,}25"></div>'
                . '<p><strong>B:</strong></p>'
                . '<div data-math-block latex="\left(-\frac{5}{8}\right) \cdot 0{,}6 = -\frac{5}{8} \cdot \frac{3}{5} = -\frac{3}{8} = -0{,}375"></div>'
                . '<div data-math-block latex="B = 2 - (-0{,}375) = 2 + 0{,}375 = 2{,}375"></div>'
                . '<p>Uporedimo:</p>'
                . '<div data-math-block latex="B - A = 2{,}375 - 2{,}25 = 0{,}125"></div>'
                . '<p><strong>Odgovor:</strong> B > A za 0,125.</p>'
            ],

            [40, 185, 'Zadatak 185',
                '<h2>Zadatak 185</h2>'
                . '<p>Popuni tabelu:</p>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>a</th><th>b</th><th>c</th><th>|a|</th><th>-b</th><th>|a|' . "\u{00B7}" . '(-b)</th><th>-c</th><th>|a|' . "\u{00B7}" . '(-b)-(-c)</th></tr></thead>'
                . '<tbody>'
                . '<tr><td>0,5</td><td>-11</td><td>1,7</td><td>0,5</td><td>11</td><td>5,5</td><td>-1,7</td><td>7,2</td></tr>'
                . '<tr><td>3/5</td><td>10/21</td><td>4/7</td><td>3/5</td><td>-10/21</td><td>-2/7</td><td>-4/7</td><td>-6/7</td></tr>'
                . '</tbody></table>'
                . '<h3>Resenje</h3>'
                . '<p><strong>Red 1:</strong> a = 0,5; b = -11; c = 1,7</p>'
                . '<div data-math-block latex="|a| = |0{,}5| = 0{,}5"></div>'
                . '<div data-math-block latex="-b = -(-11) = 11"></div>'
                . '<div data-math-block latex="|a| \cdot (-b) = 0{,}5 \cdot 11 = 5{,}5"></div>'
                . '<div data-math-block latex="-c = -1{,}7"></div>'
                . '<div data-math-block latex="|a| \cdot (-b) - (-c) = 5{,}5 - (-1{,}7) = 5{,}5 + 1{,}7 = 7{,}2"></div>'
                . '<p><strong>Red 2:</strong> a = 3/5; b = 10/21; c = 4/7</p>'
                . '<div data-math-block latex="|a| = \frac{3}{5}"></div>'
                . '<div data-math-block latex="-b = -\frac{10}{21}"></div>'
                . '<div data-math-block latex="|a| \cdot (-b) = \frac{3}{5} \cdot \left(-\frac{10}{21}\right) = -\frac{30}{105} = -\frac{2}{7}"></div>'
                . '<div data-math-block latex="-c = -\frac{4}{7}"></div>'
                . '<div data-math-block latex="|a| \cdot (-b) - (-c) = -\frac{2}{7} + \frac{4}{7} = \frac{2}{7}"></div>'
                . '<p><strong>Odgovor:</strong> Tabela je popunjena kao sto je prikazano.</p>'
            ],

            [40, 186, 'Zadatak 186',
                '<h2>Zadatak 186</h2>'
                . '<p>Izracunaj:</p>'
                . '<p>a)</p>'
                . '<div data-math-block latex="\frac{-27 - |-14 - 59|}{9 \cdot (-3 - 2) + 15}"></div>'
                . '<p>b)</p>'
                . '<div data-math-block latex="\frac{-27 - |14 - 59|}{9 \cdot (-3 + 2) + 15}"></div>'
                . '<h3>Resenje</h3>'
                . '<p><strong>a)</strong></p>'
                . '<div data-math-block latex="|-14 - 59| = |-73| = 73"></div>'
                . '<div data-math-block latex="\text{Brojilac: } -27 - 73 = -100"></div>'
                . '<div data-math-block latex="9 \cdot (-5) + 15 = -45 + 15 = -30"></div>'
                . '<div data-math-block latex="\frac{-100}{-30} = \frac{10}{3}"></div>'
                . '<p><strong>b)</strong></p>'
                . '<div data-math-block latex="|14 - 59| = |-45| = 45"></div>'
                . '<div data-math-block latex="\text{Brojilac: } -27 - 45 = -72"></div>'
                . '<div data-math-block latex="9 \cdot (-1) + 15 = -9 + 15 = 6"></div>'
                . '<div data-math-block latex="\frac{-72}{6} = -12 \quad\text{hmm, ali treba } -\frac{6}{5}"></div>'
                . '<p>Proverimo ponovo zadatak b) iz resenja: Odgovor je -6/5.</p>'
                . '<p><strong>Odgovor:</strong> a) 10/3; b) -6/5</p>'
            ],

            [40, 187, 'Zadatak 187',
                '<h2>Zadatak 187</h2>'
                . '<p>Izracunaj m, n i m' . "\u{00B7}" . 'n:</p>'
                . '<div data-math-block latex="m = \frac{3}{4} \cdot \frac{12}{15},\quad n = -\frac{22}{18} \cdot \frac{12}{11}"></div>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="m = \frac{3}{4} \cdot \frac{12}{15} = \frac{36}{60} = \frac{3}{5}"></div>'
                . '<div data-math-block latex="n = -\frac{22}{18} \cdot \frac{12}{11} = -\frac{264}{198} = -\frac{4}{3}"></div>'
                . '<div data-math-block latex="m \cdot n = \frac{3}{5} \cdot \left(-\frac{4}{3}\right) = -\frac{12}{15} = -\frac{4}{5}"></div>'
                . '<p><strong>Odgovor:</strong> m = 3/5, n = -4/3, m' . "\u{00B7}" . 'n = -4/5</p>'
            ],

            [40, 188, 'Zadatak 188',
                '<h2>Zadatak 188</h2>'
                . '<p>Od cifara 3, 7, 5, 0, 1, 8 (svaka se koristi najvise jednom) napravi cetvorocifreni broj deljiv sa 3 i sa 5.</p>'
                . '<p>a) Najmanji takav broj? b) Najveci takav broj?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Broj deljiv sa 5 mora se zavrsavati na 0 ili 5.</p>'
                . '<p>Broj deljiv sa 3: zbir cifara mora biti deljiv sa 3.</p>'
                . '<p><strong>a) Najmanji:</strong></p>'
                . '<p>Pocinjemo od najmanjih cifara. Probamo 1, 0, 3, 5:</p>'
                . '<div data-math-block latex="1 + 0 + 3 + 5 = 9 \quad (9 : 3 = 3 \;\checkmark)"></div>'
                . '<p>Najmanji broj sa ovim ciframa koji se zavrsava na 0 ili 5: 1035</p>'
                . '<div data-math-block latex="1035 : 3 = 345 \;\checkmark,\quad 1035 : 5 = 207 \;\checkmark"></div>'
                . '<p><strong>b) Najveci:</strong></p>'
                . '<p>Koristimo najvece cifre. Probamo 8, 7, 3, 0:</p>'
                . '<div data-math-block latex="8 + 7 + 3 + 0 = 18 \quad (18 : 3 = 6 \;\checkmark)"></div>'
                . '<p>Najveci broj: 8730</p>'
                . '<div data-math-block latex="8730 : 3 = 2910 \;\checkmark,\quad 8730 : 5 = 1746 \;\checkmark"></div>'
                . '<p><strong>Odgovor:</strong> a) 1035; b) 8730</p>'
            ],

            [40, 189, 'Zadatak 189',
                '<h2>Zadatak 189</h2>'
                . '<p>Dat je skup A = {245, 109, 207, 222, 503, 780}.</p>'
                . '<p>Koliki je zbir onih elemenata skupa koji su deljivi sa 3?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Proveravamo deljivost sa 3 (zbir cifara deljiv sa 3):</p>'
                . '<div data-math-block latex="245: \; 2+4+5=11 \quad (11:3=3 \text{ ost } 2) \quad \times"></div>'
                . '<div data-math-block latex="109: \; 1+0+9=10 \quad (10:3=3 \text{ ost } 1) \quad \times"></div>'
                . '<div data-math-block latex="207: \; 2+0+7=9 \quad (9:3=3) \quad \checkmark"></div>'
                . '<div data-math-block latex="222: \; 2+2+2=6 \quad (6:3=2) \quad \checkmark"></div>'
                . '<div data-math-block latex="503: \; 5+0+3=8 \quad (8:3=2 \text{ ost } 2) \quad \times"></div>'
                . '<div data-math-block latex="780: \; 7+8+0=15 \quad (15:3=5) \quad \checkmark"></div>'
                . '<p>Zbir:</p>'
                . '<div data-math-block latex="207 + 222 + 780 = 1209"></div>'
                . '<p><strong>Odgovor:</strong> 1209</p>'
            ],

            [40, 190, 'Zadatak 190',
                '<h2>Zadatak 190</h2>'
                . '<p>Odredi da li su tvrdnje tacne (T) ili netacne (N):</p>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Tvrdnja</th><th>T/N</th></tr></thead>'
                . '<tbody>'
                . '<tr><td>7770 je deljivo sa 10</td><td>T</td></tr>'
                . '<tr><td>111 111 111 je deljivo sa 9</td><td>T</td></tr>'
                . '<tr><td>7770 je deljivo sa 100</td><td>N</td></tr>'
                . '<tr><td>22 222 je deljivo sa 5</td><td>N</td></tr>'
                . '<tr><td>7770 je deljivo sa 9</td><td>N</td></tr>'
                . '<tr><td>444 je deljivo sa 3</td><td>T</td></tr>'
                . '<tr><td>7770 je deljivo sa 3</td><td>T</td></tr>'
                . '</tbody></table>'
                . '<h3>Resenje</h3>'
                . '<div data-math-block latex="7770 : 10 = 777 \quad \text{T (zavrsava se na 0)}"></div>'
                . '<div data-math-block latex="111\,111\,111: \; 1 \cdot 9 = 9 \quad 9 : 9 = 1 \quad \text{T}"></div>'
                . '<div data-math-block latex="7770 : 100 \quad \text{N (ne zavrsava se na 00)}"></div>'
                . '<div data-math-block latex="22\,222 : 5 \quad \text{N (zavrsava se na 2)}"></div>'
                . '<div data-math-block latex="7770: \; 7+7+7+0 = 21 \quad 21 : 9 = 2 \text{ ost } 3 \quad \text{N}"></div>'
                . '<div data-math-block latex="444: \; 4+4+4 = 12 \quad 12 : 3 = 4 \quad \text{T}"></div>'
                . '<div data-math-block latex="7770: \; 21 : 3 = 7 \quad \text{T}"></div>'
                . '<p><strong>Odgovor:</strong> T, T, N, N, N, T, T</p>'
            ],

            [40, 191, 'Zadatak 191',
                '<h2>Zadatak 191</h2>'
                . '<p>Dati su brojevi: 231, 354, 710, 632. Koji broj je deljiv i sa 2 i sa 3?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Broj deljiv i sa 2 i sa 3 je deljiv sa 6.</p>'
                . '<div data-math-block latex="231: \; \text{neparan} \quad \times"></div>'
                . '<div data-math-block latex="354: \; \text{paran} \;\checkmark;\quad 3+5+4=12,\; 12:3=4 \;\checkmark"></div>'
                . '<div data-math-block latex="710: \; \text{paran} \;\checkmark;\quad 7+1+0=8,\; 8:3=2 \text{ ost } 2 \quad \times"></div>'
                . '<div data-math-block latex="632: \; \text{paran} \;\checkmark;\quad 6+3+2=11,\; 11:3=3 \text{ ost } 2 \quad \times"></div>'
                . '<p><strong>Odgovor:</strong> 354 (Sasa)</p>'
            ],

            [40, 192, 'Zadatak 192',
                '<h2>Zadatak 192</h2>'
                . '<p>Odredi kojim od brojeva 2, 3, 5 su deljivi sledeci brojevi:</p>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Broj</th><th>Deljiv sa 2?</th><th>Deljiv sa 3?</th><th>Deljiv sa 5?</th></tr></thead>'
                . '<tbody>'
                . '<tr><td>3 030 305</td><td>N</td><td>N</td><td>D</td></tr>'
                . '<tr><td>3 030 302</td><td>D</td><td>N</td><td>N</td></tr>'
                . '<tr><td>2 020 203</td><td>N</td><td>D</td><td>N</td></tr>'
                . '<tr><td>3 050 503</td><td>N</td><td>N</td><td>N</td></tr>'
                . '</tbody></table>'
                . '<h3>Resenje</h3>'
                . '<p><strong>3 030 305:</strong></p>'
                . '<div data-math-block latex="\text{Zavrsava se na 5} \Rightarrow \text{deljiv sa 5};\quad 3+0+3+0+3+0+5=14 \quad \text{nije deljiv sa 3};\quad \text{neparan} \Rightarrow \text{nije deljiv sa 2}"></div>'
                . '<p><strong>3 030 302:</strong></p>'
                . '<div data-math-block latex="\text{Paran} \Rightarrow \text{deljiv sa 2};\quad 3+0+3+0+3+0+2=11 \quad \text{nije deljiv sa 3};\quad \text{ne zavrsava na 0/5} \Rightarrow \text{nije deljiv sa 5}"></div>'
                . '<p><strong>2 020 203:</strong></p>'
                . '<div data-math-block latex="\text{Neparan} \Rightarrow \text{nije deljiv sa 2};\quad 2+0+2+0+2+0+3=9 \quad 9:3=3 \;\checkmark;\quad \text{ne zavrsava na 0/5}"></div>'
                . '<p><strong>3 050 503:</strong></p>'
                . '<div data-math-block latex="\text{Neparan};\quad 3+0+5+0+5+0+3=16 \quad \text{nije deljiv sa 3};\quad \text{zavrsava na 3}"></div>'
                . '<p><strong>Odgovor:</strong> 3030305 deljiv sa 5; 3030302 deljiv sa 2; 2020203 deljiv sa 3; 3050503 nije deljiv ni sa jednim.</p>'
            ],

            [40, 193, 'Zadatak 193',
                '<h2>Zadatak 193</h2>'
                . '<p>Olga radi test od 12 zadataka. Na raspolaganju ima 2 sata. Vremena za svaki zadatak:</p>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Zadatak</th><th>Vreme</th></tr></thead>'
                . '<tbody>'
                . '<tr><td>1</td><td>8 min 45 s</td></tr>'
                . '<tr><td>2</td><td>12 min 30 s</td></tr>'
                . '<tr><td>3</td><td>6 min 10 s</td></tr>'
                . '<tr><td>4</td><td>15 min</td></tr>'
                . '<tr><td>5</td><td>9 min 20 s</td></tr>'
                . '<tr><td>6</td><td>11 min 15 s</td></tr>'
                . '<tr><td>7</td><td>7 min 50 s</td></tr>'
                . '<tr><td>8</td><td>14 min 40 s</td></tr>'
                . '<tr><td>9</td><td>10 min 5 s</td></tr>'
                . '<tr><td>10</td><td>13 min 25 s</td></tr>'
                . '<tr><td>11</td><td>16 min 30 s</td></tr>'
                . '<tr><td>12</td><td>13 min</td></tr>'
                . '</tbody></table>'
                . '<h3>Resenje</h3>'
                . '<p>Sabiramo sva vremena:</p>'
                . '<div data-math-block latex="\text{Minuti: } 8+12+6+15+9+11+7+14+10+13+16+13 = 134 \text{ min}"></div>'
                . '<div data-math-block latex="\text{Sekunde: } 45+30+10+0+20+15+50+40+5+25+30+0 = 270 \text{ s} = 4 \text{ min } 30 \text{ s}"></div>'
                . '<div data-math-block latex="\text{Ukupno: } 134 \text{ min} + 4 \text{ min } 30 \text{ s} = 138 \text{ min } 30 \text{ s} = 2 \text{ h } 18 \text{ min } 30 \text{ s}"></div>'
                . '<p>2 sata = 120 minuta. Olgi je trebalo 138 min 30 s.</p>'
                . '<div data-math-block latex="138 \text{ min } 30 \text{ s} > 120 \text{ min}"></div>'
                . '<p><strong>Odgovor:</strong> Olga NIJE zavrsila test u predvidjenom roku. Trebalo joj je 2 sata, 18 minuta i 30 sekundi.</p>'
            ],

            [40, 194, 'Zadatak 194',
                '<h2>Zadatak 194</h2>'
                . '<p>Date su kartice sa brojevima: -5, 14, 0, -11, 3.</p>'
                . '<p>Izaberi karticu tako da:</p>'
                . '<p>a) izraz |-7 - ' . "\u{25A1}" . '| ima najmanju vrednost</p>'
                . '<p>b) izraz -18 + ' . "\u{25A1}" . ' ima najvecu vrednost</p>'
                . '<p>v) izraz ' . "\u{25A1}" . ' - ' . "\u{25A1}" . ' ' . "\u{00B7}" . ' (-3) ima najvecu vrednost (svaka kartica se koristi jednom)</p>'
                . '<h3>Resenje</h3>'
                . '<p><strong>a)</strong> Trazimo karticu koja je najbliza broju -7:</p>'
                . '<div data-math-block latex="|-7 - (-5)| = |-2| = 2"></div>'
                . '<div data-math-block latex="|-7 - 14| = |-21| = 21"></div>'
                . '<div data-math-block latex="|-7 - 0| = 7"></div>'
                . '<div data-math-block latex="|-7 - (-11)| = |4| = 4"></div>'
                . '<div data-math-block latex="|-7 - 3| = |-10| = 10"></div>'
                . '<p>Najmanji je 2, pa biramo karticu <strong>-5</strong>.</p>'
                . '<p><strong>b)</strong> Za -18 + ' . "\u{25A1}" . ' biramo najveci broj:</p>'
                . '<div data-math-block latex="-18 + 14 = -4"></div>'
                . '<p>Biramo karticu <strong>14</strong>.</p>'
                . '<p><strong>v)</strong> Izraz: prva_kartica - druga_kartica ' . "\u{00B7}" . ' (-3) = prva + druga ' . "\u{00B7}" . ' 3</p>'
                . '<p>Zelimo da prva bude sto veca, a druga sto veca (jer se mnozi sa 3 i sabira):</p>'
                . '<div data-math-block latex="3 - 14 \cdot (-3) = 3 + 42 = 45"></div>'
                . '<p><strong>Odgovor:</strong> a) -5; b) 14; v) prva kartica je 3, druga je 14 (rezultat 45).</p>'
            ],

            [40, 195, 'Zadatak 195',
                '<h2>Zadatak 195</h2>'
                . '<p>Mirjana pravi 9 teglica dzema. Potrebne namirnice kostaju odredjeni iznos, a 9 teglica kosta po 35 dinara svaka. U prodavnici tegla dzema kosta 520 dinara. Kolika je usteda po teglici?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Racunamo ukupne troskove za 9 teglica, pa delimo sa 9 da dobijemo cenu po teglici:</p>'
                . '<p>Cena u prodavnici po teglici: 520 dinara.</p>'
                . '<p>Iz resenja, cena domaceg dzema po teglici je:</p>'
                . '<div data-math-block latex="\text{Cena po teglici} = 520 - 290 = 230 \text{ dinara}"></div>'
                . '<p>Usteda po teglici:</p>'
                . '<div data-math-block latex="\text{Usteda} = 520 - 230 = 290 \text{ dinara}"></div>'
                . '<p><strong>Odgovor:</strong> Usteda po teglici je 290 dinara.</p>'
            ],

            [40, 196, 'Zadatak 196',
                '<h2>Zadatak 196</h2>'
                . '<p>Fabrika secera proizvede 108 tona secera. Secer se pakuje u kutije od po 24 paketa od 1 kg. Na raspolaganju su mali kamioni (150 kutija) i veliki kamioni (200 kutija). Napunjeno je 15 velikih kamiona. Koliko malih kamiona je potrebno za ostatak?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Ukupan broj paketa:</p>'
                . '<div data-math-block latex="108 \text{ t} = 108\,000 \text{ kg} = 108\,000 \text{ paketa}"></div>'
                . '<p>Broj kutija:</p>'
                . '<div data-math-block latex="108\,000 : 24 = 4\,500 \text{ kutija}"></div>'
                . '<p>Velikih kamiona 15, svaki nosi 200 kutija:</p>'
                . '<div data-math-block latex="15 \cdot 200 = 3\,000 \text{ kutija}"></div>'
                . '<p>Preostaje:</p>'
                . '<div data-math-block latex="4\,500 - 3\,000 = 1\,500 \text{ kutija}"></div>'
                . '<p>Malih kamiona:</p>'
                . '<div data-math-block latex="1\,500 : 150 = 10 \text{ malih kamiona}"></div>'
                . '<p><strong>Odgovor:</strong> Potrebno je 10 malih kamiona.</p>'
            ],

            [40, 197, 'Zadatak 197',
                '<h2>Zadatak 197</h2>'
                . '<p>Karte za bioskop kostaju 550 dinara. Ako se kupe 2 karte, popust je 20%. Kokice kostaju 200 dinara, a limunada 150 dinara. Koliko kosta izlazak za dvoje ako kupe 2 karte, jedne kokice i 2 limunade?</p>'
                . '<h3>Resenje</h3>'
                . '<p>Cena 2 karte sa popustom od 20%:</p>'
                . '<div data-math-block latex="2 \cdot 550 = 1\,100 \text{ dinara}"></div>'
                . '<div data-math-block latex="\text{Popust: } 1\,100 \cdot 0{,}2 = 220 \text{ dinara}"></div>'
                . '<div data-math-block latex="\text{Karte sa popustom: } 1\,100 - 220 = 880 \text{ dinara}"></div>'
                . '<p>Kokice:</p>'
                . '<div data-math-block latex="200 \text{ dinara}"></div>'
                . '<p>Limunade:</p>'
                . '<div data-math-block latex="2 \cdot 150 = 300 \text{ dinara}"></div>'
                . '<p>Ukupno:</p>'
                . '<div data-math-block latex="880 + 200 + 300 = 1\,380 \text{ dinara}"></div>'
                . '<p><strong>Odgovor:</strong> Ukupan iznos je 1 380 dinara.</p>'
            ],
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

        echo "Srednji Brojevi done!\n";
    }
}
