<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Lesson;

// Lesson 38
Lesson::create([
    'course_id' => 10,
    'subchapter_id' => 32,
    'title' => 'Zadatak 38: Koliko godina imaju Maja i njen brat?',
    'order' => 1,
    'content' => '<h1>Zadatak 38</h1>

<p><strong>Tekst zadatka:</strong> Maja je 8 godina starija od svog brata. Za 5 godina Maja će biti 2 puta starija od brata. Koliko sada imaju godina Maja i njen brat?</p>

<h2>Korak 1: Uvođenje nepoznatih</h2>

<p>Prvo moramo da odlučimo šta su nam nepoznate. Označimo:</p>
<ul>
<li><strong>x</strong> = broj godina brata (sada)</li>
<li><strong>y</strong> = broj godina Maje (sada)</li>
</ul>

<h2>Korak 2: Sastavljanje jednačina</h2>

<p>Iz teksta zadatka izvlačimo dva podatka:</p>

<p><strong>Podatak 1:</strong> „Maja je 8 godina starija od svog brata"</p>
<p>To znači da je Majin broj godina jednak bratovom plus 8:</p>

<div data-math-block="" latex="y = x + 8" display="block"></div>

<p><strong>Podatak 2:</strong> „Za 5 godina Maja će biti 2 puta starija od brata"</p>
<p>Za 5 godina brat će imati <strong>x + 5</strong> godina, a Maja <strong>y + 5</strong> godina. Maja će tada biti 2 puta starija:</p>

<div data-math-block="" latex="y + 5 = 2 \cdot (x + 5)" display="block"></div>

<h2>Korak 3: Sistem jednačina</h2>

<p>Imamo sistem od dve jednačine sa dve nepoznate:</p>

<div data-math-block="" latex="\begin{cases} y = x + 8 \\ y + 5 = 2(x + 5) \end{cases}" display="block"></div>

<h2>Korak 4: Rešavanje</h2>

<p>Pošto iz prve jednačine već znamo da je <strong>y = x + 8</strong>, to možemo da zamenimo u drugu jednačinu:</p>

<div data-math-block="" latex="(x + 8) + 5 = 2(x + 5)" display="block"></div>

<p>Sređujemo levu stranu:</p>

<div data-math-block="" latex="x + 13 = 2x + 10" display="block"></div>

<p>Prebacujemo x na jednu stranu:</p>

<div data-math-block="" latex="13 - 10 = 2x - x" display="block"></div>

<div data-math-block="" latex="3 = x" display="block"></div>

<p>Dakle, <strong>brat ima 3 godine</strong>.</p>

<p>Vraćamo u prvu jednačinu da nađemo Majine godine:</p>

<div data-math-block="" latex="y = 3 + 8 = 11" display="block"></div>

<h2>Korak 5: Provera</h2>

<p>Uvek proverimo da li naše rešenje zadovoljava OBA uslova:</p>

<ul>
<li>Da li je Maja 8 godina starija? 11 - 3 = 8 ✓</li>
<li>Za 5 godina: brat će imati 8, Maja 16. Da li je 16 = 2 × 8? ✓</li>
</ul>

<h2>Odgovor</h2>

<div data-math-block="" latex="\boxed{\text{Brat ima 3 godine, a Maja 11 godina.}}" display="block"></div>',
]);

echo "Lesson 38 created.\n";

// Lesson 39
Lesson::create([
    'course_id' => 10,
    'subchapter_id' => 32,
    'title' => 'Zadatak 39: Koliko ima olova i cinka u leguri?',
    'order' => 2,
    'content' => '<h1>Zadatak 39</h1>

<p><strong>Tekst zadatka:</strong> U jednoj leguri olovo i cink su zastupljeni u odnosu 4 : 7. Ako je masa legure 583 g, odredi koliko ima olova, a koliko cinka u toj leguri.</p>

<h2>Korak 1: Uvođenje nepoznatih</h2>

<ul>
<li><strong>x</strong> = masa olova (u gramima)</li>
<li><strong>y</strong> = masa cinka (u gramima)</li>
</ul>

<h2>Korak 2: Sastavljanje jednačina</h2>

<p><strong>Podatak 1:</strong> „Olovo i cink su u odnosu 4 : 7"</p>
<p>To znači:</p>

<div data-math-block="" latex="\frac{x}{y} = \frac{4}{7}" display="block"></div>

<p>Ili pomnoženo unakrsno:</p>

<div data-math-block="" latex="7x = 4y" display="block"></div>

<p><strong>Podatak 2:</strong> „Masa legure je 583 g"</p>
<p>Legura se sastoji samo od olova i cinka, pa:</p>

<div data-math-block="" latex="x + y = 583" display="block"></div>

<h2>Korak 3: Sistem jednačina</h2>

<div data-math-block="" latex="\begin{cases} 7x = 4y \\ x + y = 583 \end{cases}" display="block"></div>

<h2>Korak 4: Rešavanje</h2>

<p>Iz prve jednačine izrazimo x:</p>

<div data-math-block="" latex="x = \frac{4y}{7}" display="block"></div>

<p>Zamenimo u drugu jednačinu:</p>

<div data-math-block="" latex="\frac{4y}{7} + y = 583" display="block"></div>

<p>Pomnožimo celu jednačinu sa 7 da se rešimo razlomka:</p>

<div data-math-block="" latex="4y + 7y = 583 \cdot 7" display="block"></div>

<div data-math-block="" latex="11y = 4081" display="block"></div>

<div data-math-block="" latex="y = \frac{4081}{11} = 371" display="block"></div>

<p>Dakle, <strong>cinka ima 371 g</strong>.</p>

<p>Vraćamo da nađemo olovo:</p>

<div data-math-block="" latex="x = 583 - 371 = 212" display="block"></div>

<h2>Korak 5: Provera</h2>

<ul>
<li>Ukupna masa: 212 + 371 = 583 g ✓</li>
<li>Odnos: 212 : 371. Delimo oba sa najv. zajedničkim deliocem: 212 ÷ 53 = 4, 371 ÷ 53 = 7. Odnos je 4 : 7 ✓</li>
</ul>

<h2>Odgovor</h2>

<div data-math-block="" latex="\boxed{\text{Olova ima 212 g, a cinka 371 g.}}" display="block"></div>',
]);

echo "Lesson 39 created.\n";

// Lesson 40
Lesson::create([
    'course_id' => 10,
    'subchapter_id' => 32,
    'title' => 'Zadatak 40: Koliko godina imaju majka i sin?',
    'order' => 3,
    'content' => '<h1>Zadatak 40</h1>

<p><strong>Tekst zadatka:</strong> Pre 4 godine majka je bila 4 puta starija od sina. Koliko godina ima majka, a koliko sin ako je on sada 3 puta mlađi od majke?</p>

<h2>Korak 1: Uvođenje nepoznatih</h2>

<ul>
<li><strong>x</strong> = broj godina sina (sada)</li>
<li><strong>y</strong> = broj godina majke (sada)</li>
</ul>

<h2>Korak 2: Sastavljanje jednačina</h2>

<p><strong>Podatak 1:</strong> „Pre 4 godine majka je bila 4 puta starija od sina"</p>
<p>Pre 4 godine sin je imao <strong>x - 4</strong>, a majka <strong>y - 4</strong> godina:</p>

<div data-math-block="" latex="y - 4 = 4 \cdot (x - 4)" display="block"></div>

<p><strong>Podatak 2:</strong> „On je sada 3 puta mlađi od majke"</p>
<p>To znači da je majka 3 puta starija od sina:</p>

<div data-math-block="" latex="y = 3x" display="block"></div>

<h2>Korak 3: Sistem jednačina</h2>

<div data-math-block="" latex="\begin{cases} y - 4 = 4(x - 4) \\ y = 3x \end{cases}" display="block"></div>

<h2>Korak 4: Rešavanje</h2>

<p>Iz druge jednačine znamo da je <strong>y = 3x</strong>. Zamenimo u prvu:</p>

<div data-math-block="" latex="3x - 4 = 4(x - 4)" display="block"></div>

<p>Razvijemo desnu stranu:</p>

<div data-math-block="" latex="3x - 4 = 4x - 16" display="block"></div>

<p>Prebacimo x na jednu stranu, brojeve na drugu:</p>

<div data-math-block="" latex="3x - 4x = -16 + 4" display="block"></div>

<div data-math-block="" latex="-x = -12" display="block"></div>

<div data-math-block="" latex="x = 12" display="block"></div>

<p>Dakle, <strong>sin ima 12 godina</strong>.</p>

<p>Vraćamo u drugu jednačinu:</p>

<div data-math-block="" latex="y = 3 \cdot 12 = 36" display="block"></div>

<h2>Korak 5: Provera</h2>

<ul>
<li>Da li je majka 3 puta starija? 36 = 3 × 12 ✓</li>
<li>Pre 4 godine: sin 8, majka 32. Da li je 32 = 4 × 8? ✓</li>
</ul>

<h2>Odgovor</h2>

<div data-math-block="" latex="\boxed{\text{Sin ima 12 godina, a majka 36 godina.}}" display="block"></div>',
]);

echo "Lesson 40 created.\n";
echo "Done!\n";
