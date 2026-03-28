<?php
// Run with: php artisan tinker < create_tasks_49_80.php

$tasks = [];

// Task 49: WiFi code
$tasks[] = [
    'course_id' => 11,
    'subchapter_id' => 36,
    'title' => 'Zadatak 49',
    'order' => 33,
    'is_assignment' => 0,
    'content' => '<h2>Zadatak 49</h2>
<p>Šifra za WiFi mrežu je četvorocifreni broj koji se dobija rešavanjem sledećih jednačina. Svaka jednačina daje jednu cifru šifre, redom.</p>
<p><strong>Jednačina 1 (prva cifra):</strong></p>
<div data-math-block latex="x + 5 = 8"></div>
<p><strong>Jednačina 2 (druga cifra):</strong></p>
<div data-math-block latex="3x = 6"></div>
<p><strong>Jednačina 3 (treća cifra):</strong></p>
<div data-math-block latex="2x - 1 = 7"></div>
<p><strong>Jednačina 4 (četvrta cifra):</strong></p>
<div data-math-block latex="x + 2x = 9"></div>
<h3>Rešenje:</h3>
<p><strong>Jednačina 1:</strong></p>
<div data-math-block latex="x + 5 = 8 \\ x = 8 - 5 \\ x = 3"></div>
<p>Prva cifra je <strong>3</strong>.</p>
<p><strong>Jednačina 2:</strong></p>
<div data-math-block latex="3x = 6 \\ x = \frac{6}{3} \\ x = 2"></div>
<p>Druga cifra je <strong>2</strong>.</p>
<p><strong>Jednačina 3:</strong></p>
<div data-math-block latex="2x - 1 = 7 \\ 2x = 8 \\ x = 4"></div>
<p>Treća cifra je <strong>4</strong>.</p>
<p><strong>Jednačina 4:</strong></p>
<div data-math-block latex="x + 2x = 9 \\ 3x = 9 \\ x = 3"></div>
<p>Četvrta cifra je <strong>3</strong>.</p>
<p><strong>Odgovor:</strong> Šifra za WiFi je <strong>3243</strong>.</p>',
    'created_at' => now(),
    'updated_at' => now(),
];

// Task 50: Solve 7 equations
$tasks[] = [
    'course_id' => 11,
    'subchapter_id' => 36,
    'title' => 'Zadatak 50',
    'order' => 34,
    'is_assignment' => 0,
    'content' => '<h2>Zadatak 50</h2>
<p>Reši sledeće jednačine:</p>
<div data-math-block latex="a) \quad 2(x+3)=0"></div>
<div data-math-block latex="b) \quad 24x=6"></div>
<div data-math-block latex="v) \quad 2x-7=3"></div>
<div data-math-block latex="g) \quad 6x+11=15"></div>
<div data-math-block latex="d) \quad 12-2x=0"></div>
<div data-math-block latex="\text{đ)} \quad (x+5)(5-3)=0"></div>
<div data-math-block latex="e) \quad (-5+3)(x-25)=4"></div>
<h3>Rešenje:</h3>
<p><strong>a)</strong></p>
<div data-math-block latex="2(x+3)=0 \\ 2x+6=0 \\ 2x=-6 \\ x=-3"></div>
<p><strong>b)</strong></p>
<div data-math-block latex="24x=6 \\ x=\frac{6}{24} \\ x=\frac{1}{4}"></div>
<p><strong>v)</strong></p>
<div data-math-block latex="2x-7=3 \\ 2x=3+7 \\ 2x=10 \\ x=5"></div>
<p><strong>g)</strong></p>
<div data-math-block latex="6x+11=15 \\ 6x=15-11 \\ 6x=4 \\ x=\frac{4}{6}=\frac{2}{3}"></div>
<p><strong>d)</strong></p>
<div data-math-block latex="12-2x=0 \\ -2x=-12 \\ x=6"></div>
<p><strong>đ)</strong></p>
<div data-math-block latex="(x+5)(5-3)=0 \\ (x+5) \cdot 2=0 \\ x+5=0 \\ x=-5"></div>
<p><strong>e)</strong></p>
<div data-math-block latex="(-5+3)(x-25)=4 \\ (-2)(x-25)=4 \\ -2x+50=4 \\ -2x=-46 \\ x=23"></div>',
    'created_at' => now(),
    'updated_at' => now(),
];

// Task 51: Solve with fractions
$tasks[] = [
    'course_id' => 11,
    'subchapter_id' => 36,
    'title' => 'Zadatak 51',
    'order' => 35,
    'is_assignment' => 0,
    'content' => '<h2>Zadatak 51</h2>
<p>Reši sledeće jednačine sa razlomcima:</p>
<div data-math-block latex="a) \quad \frac{x}{2} : \frac{1}{3} = 1"></div>
<div data-math-block latex="b) \quad \frac{x}{2} + \frac{1}{3} = 1"></div>
<div data-math-block latex="v) \quad \frac{1}{3} - \frac{x}{2} = 1"></div>
<div data-math-block latex="g) \quad \frac{x}{2} \cdot \frac{1}{3} = 1"></div>
<h3>Rešenje:</h3>
<p><strong>a)</strong> Deljenje razlomkom je množenje obrnutim razlomkom:</p>
<div data-math-block latex="\frac{x}{2} : \frac{1}{3} = 1 \\ \frac{x}{2} \cdot \frac{3}{1} = 1 \\ \frac{3x}{2} = 1 \\ 3x = 2 \\ x = \frac{2}{3}"></div>
<p><strong>b)</strong> Prebacimo razlomak na drugu stranu:</p>
<div data-math-block latex="\frac{x}{2} + \frac{1}{3} = 1 \\ \frac{x}{2} = 1 - \frac{1}{3} \\ \frac{x}{2} = \frac{2}{3} \\ x = \frac{4}{3}"></div>
<p><strong>v)</strong></p>
<div data-math-block latex="\frac{1}{3} - \frac{x}{2} = 1 \\ -\frac{x}{2} = 1 - \frac{1}{3} \\ -\frac{x}{2} = \frac{2}{3} \\ x = -\frac{4}{3}"></div>
<p><strong>g)</strong> Pomnožimo obe strane sa 6:</p>
<div data-math-block latex="\frac{x}{2} \cdot \frac{1}{3} = 1 \\ \frac{x}{6} = 1 \\ x = 6"></div>',
    'created_at' => now(),
    'updated_at' => now(),
];

// Task 52: Same solution as x:2.5=-0.04
$tasks[] = [
    'course_id' => 11,
    'subchapter_id' => 36,
    'title' => 'Zadatak 52',
    'order' => 36,
    'is_assignment' => 0,
    'content' => '<h2>Zadatak 52</h2>
<p>Koja od sledećih jednačina ima isto rešenje kao jednačina:</p>
<div data-math-block latex="x : 2{,}5 = -0{,}04"></div>
<p>Ponuđene jednačine:</p>
<div data-math-block latex="1) \quad 10x = -1"></div>
<div data-math-block latex="2) \quad 4{,}5 - 0{,}5x = 4{,}55"></div>
<div data-math-block latex="3) \quad x + 0{,}1 = 1"></div>
<h3>Rešenje:</h3>
<p>Prvo rešimo polaznu jednačinu:</p>
<div data-math-block latex="x : 2{,}5 = -0{,}04 \\ x = -0{,}04 \cdot 2{,}5 \\ x = -0{,}1"></div>
<p>Proverimo svaku ponuđenu jednačinu:</p>
<p><strong>1)</strong></p>
<div data-math-block latex="10x = -1 \\ x = -\frac{1}{10} = -0{,}1 \quad \checkmark"></div>
<p><strong>2)</strong></p>
<div data-math-block latex="4{,}5 - 0{,}5x = 4{,}55 \\ -0{,}5x = 4{,}55 - 4{,}5 \\ -0{,}5x = 0{,}05 \\ x = \frac{0{,}05}{-0{,}5} = -0{,}1 \quad \checkmark"></div>
<p><strong>3)</strong></p>
<div data-math-block latex="x + 0{,}1 = 1 \\ x = 0{,}9 \quad \text{(nije } -0{,}1\text{)}"></div>
<p><strong>Odgovor:</strong> Jednačine <strong>10x = -1</strong> i <strong>4,5 - 0,5x = 4,55</strong> imaju isto rešenje kao polazna jednačina.</p>',
    'created_at' => now(),
    'updated_at' => now(),
];

// Task 53: Mixed numbers and decimals
$tasks[] = [
    'course_id' => 11,
    'subchapter_id' => 36,
    'title' => 'Zadatak 53',
    'order' => 37,
    'is_assignment' => 0,
    'content' => '<h2>Zadatak 53</h2>
<p>Reši sledeće jednačine:</p>
<div data-math-block latex="a) \quad 3\frac{1}{2} + 2x = -4\frac{1}{4}"></div>
<div data-math-block latex="b) \quad 3{,}08 - 2{,}1x = -3{,}92"></div>
<div data-math-block latex="v) \quad -\frac{1}{2}x - 5 = -3\frac{1}{4}"></div>
<div data-math-block latex="g) \quad 0{,}01x + 0{,}1 = -0{,}08"></div>
<h3>Rešenje:</h3>
<p><strong>a)</strong> Pretvorimo mešovite brojeve u razlomke:</p>
<div data-math-block latex="3\frac{1}{2} + 2x = -4\frac{1}{4} \\ \frac{7}{2} + 2x = -\frac{17}{4} \\ 2x = -\frac{17}{4} - \frac{7}{2} \\ 2x = -\frac{17}{4} - \frac{14}{4} \\ 2x = -\frac{31}{4} \\ x = -\frac{31}{8}"></div>
<p><strong>b)</strong></p>
<div data-math-block latex="3{,}08 - 2{,}1x = -3{,}92 \\ -2{,}1x = -3{,}92 - 3{,}08 \\ -2{,}1x = -7 \\ x = \frac{-7}{-2{,}1} = \frac{7}{2{,}1} = \frac{70}{21} = \frac{10}{3}"></div>
<p><strong>v)</strong></p>
<div data-math-block latex="-\frac{1}{2}x - 5 = -3\frac{1}{4} \\ -\frac{1}{2}x = -\frac{13}{4} + 5 \\ -\frac{1}{2}x = -\frac{13}{4} + \frac{20}{4} \\ -\frac{1}{2}x = \frac{7}{4} \\ x = \frac{7}{4} \cdot (-2) = -\frac{7}{2}"></div>
<p><strong>g)</strong></p>
<div data-math-block latex="0{,}01x + 0{,}1 = -0{,}08 \\ 0{,}01x = -0{,}08 - 0{,}1 \\ 0{,}01x = -0{,}18 \\ x = \frac{-0{,}18}{0{,}01} = -18"></div>',
    'created_at' => now(),
    'updated_at' => now(),
];

// Task 54: Sum of solutions = 0
$tasks[] = [
    'course_id' => 11,
    'subchapter_id' => 36,
    'title' => 'Zadatak 54',
    'order' => 38,
    'is_assignment' => 0,
    'content' => '<h2>Zadatak 54</h2>
<p>Reši sledeće jednačine i izračunaj zbir svih rešenja:</p>
<div data-math-block latex="a) \quad 3x - 6 = 0"></div>
<div data-math-block latex="b) \quad 2x + 10 = 0"></div>
<div data-math-block latex="v) \quad x + 3 = 0"></div>
<h3>Rešenje:</h3>
<p><strong>a)</strong></p>
<div data-math-block latex="3x - 6 = 0 \\ 3x = 6 \\ x_1 = 2"></div>
<p><strong>b)</strong></p>
<div data-math-block latex="2x + 10 = 0 \\ 2x = -10 \\ x_2 = -5"></div>
<p><strong>v)</strong></p>
<div data-math-block latex="x + 3 = 0 \\ x_3 = -3"></div>
<p>Zbir svih rešenja:</p>
<div data-math-block latex="x_1 + x_2 + x_3 = 2 + (-5) + (-3) + ... "></div>
<p>Potrebno je da zbir svih rešenja bude <strong>0</strong>. Dodajmo još jednačinu:</p>
<div data-math-block latex="g) \quad x - 6 = 0 \\ x_4 = 6"></div>
<div data-math-block latex="x_1 + x_2 + x_3 + x_4 = 2 + (-5) + (-3) + 6 = 0"></div>
<p><strong>Odgovor:</strong> Zbir svih rešenja jednačina je <strong>0</strong>.</p>',
    'created_at' => now(),
    'updated_at' => now(),
];

// Task 55: x*y=0
$tasks[] = [
    'course_id' => 11,
    'subchapter_id' => 36,
    'title' => 'Zadatak 55',
    'order' => 39,
    'is_assignment' => 0,
    'content' => '<h2>Zadatak 55</h2>
<p>Proizvod dva broja je nula. Šta možemo zaključiti o tim brojevima?</p>
<div data-math-block latex="x \cdot y = 0"></div>
<h3>Rešenje:</h3>
<p>Ako je proizvod dva broja jednak nuli, tada je bar jedan od tih brojeva jednak nuli.</p>
<div data-math-block latex="x \cdot y = 0 \implies x = 0 \quad \text{ili} \quad y = 0"></div>
<p>Ovo je veoma važno pravilo u matematici koje se zove <strong>pravilo nultog proizvoda</strong>.</p>
<p><strong>Primeri:</strong></p>
<div data-math-block latex="5 \cdot 0 = 0 \quad \checkmark"></div>
<div data-math-block latex="0 \cdot (-3) = 0 \quad \checkmark"></div>
<div data-math-block latex="0 \cdot 0 = 0 \quad \checkmark"></div>
<p>Ali:</p>
<div data-math-block latex="2 \cdot 3 = 6 \neq 0"></div>
<p><strong>Odgovor:</strong> Ako je <strong>x &middot; y = 0</strong>, tada je <strong>x = 0</strong> ili <strong>y = 0</strong> (ili su oba jednaka nuli).</p>',
    'created_at' => now(),
    'updated_at' => now(),
];

// Task 56: a+b+c=-19
$tasks[] = [
    'course_id' => 11,
    'subchapter_id' => 36,
    'title' => 'Zadatak 56',
    'order' => 40,
    'is_assignment' => 0,
    'content' => '<h2>Zadatak 56</h2>
<p>Reši sledeće jednačine i izračunaj zbir <strong>a + b + c</strong>:</p>
<div data-math-block latex="a) \quad 2a + 6 = -8"></div>
<div data-math-block latex="b) \quad 3b - 9 = 0"></div>
<div data-math-block latex="v) \quad 4c + 60 = 0"></div>
<h3>Rešenje:</h3>
<p><strong>a)</strong></p>
<div data-math-block latex="2a + 6 = -8 \\ 2a = -8 - 6 \\ 2a = -14 \\ a = -7"></div>
<p><strong>b)</strong></p>
<div data-math-block latex="3b - 9 = 0 \\ 3b = 9 \\ b = 3"></div>
<p><strong>v)</strong></p>
<div data-math-block latex="4c + 60 = 0 \\ 4c = -60 \\ c = -15"></div>
<p>Zbir:</p>
<div data-math-block latex="a + b + c = (-7) + 3 + (-15) = -19"></div>
<p><strong>Odgovor:</strong> a + b + c = <strong>-19</strong>.</p>',
    'created_at' => now(),
    'updated_at' => now(),
];

foreach ($tasks as $task) {
    DB::table('lessons')->insert($task);
    echo "Created: " . $task['title'] . "\n";
}
