<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Lesson;

// Lesson 49 - Zadatak 38
Lesson::find(49)->update(['content' => '<h1>Zadatak 38: Koliko godina imaju Maja i njen brat?</h1>

<h2>Tekst zadatka</h2>

<p><strong>Maja je 8 godina starija od svog brata. Za 5 godina Maja će biti 2 puta starija od brata. Koliko sada imaju godina Maja i njen brat?</strong></p>

<h2>Pre nego što počnemo — šta uopšte radimo?</h2>

<p>Imamo zadatak gde ne znamo koliko godina imaju Maja i njen brat. To su dva broja koja ne znamo. U matematici, kad ne znamo neki broj, označimo ga slovom — obično <strong>x</strong> i <strong>y</strong>.</p>

<p>Onda iz teksta zadatka napravimo jednačine (matematičke rečenice), i rešimo ih da saznamo koliki su ti brojevi.</p>

<h2>Korak 1: Označimo ono što ne znamo</h2>

<p>Šta ne znamo? Ne znamo koliko godina ima brat i koliko Maja. Dakle:</p>

<ul>
<li>Neka je <strong>x</strong> = koliko godina ima brat SADA</li>
<li>Neka je <strong>y</strong> = koliko godina ima Maja SADA</li>
</ul>

<p>To su naše nepoznate. Cilj nam je da otkrijemo koliko su x i y.</p>

<h2>Korak 2: Prevedemo tekst u matematiku</h2>

<p>Sad čitamo zadatak rečenicu po rečenicu i pretvaramo srpski u matematiku:</p>

<h3>Prva rečenica: „Maja je 8 godina starija od svog brata"</h3>

<p>Šta to znači? Ako brat ima x godina, Maja ima 8 više od njega. Dakle:</p>

<div data-math-block="" latex="y = x + 8" display="block"></div>

<p>Na primer: ako brat ima 10 godina, Maja ima 10 + 8 = 18 godina. Prosto!</p>

<h3>Druga rečenica: „Za 5 godina Maja će biti 2 puta starija od brata"</h3>

<p>Hajde da razmislimo — za 5 godina svi će biti stariji za 5:</p>
<ul>
<li>Brat će za 5 godina imati: <strong>x + 5</strong> godina</li>
<li>Maja će za 5 godina imati: <strong>y + 5</strong> godina</li>
</ul>

<p>I kaže se da će TADA Maja biti 2 puta starija. To znači da je Majin broj godina duplo veći od bratovog:</p>

<div data-math-block="" latex="y + 5 = 2 \cdot (x + 5)" display="block"></div>

<p>Na primer: ako za 5 godina brat bude imao 8 godina, Maja bi imala 2 × 8 = 16 godina.</p>

<h2>Korak 3: Napišemo sistem jednačina</h2>

<p>Sada imamo dve jednačine — to je naš „sistem":</p>

<div data-math-block="" latex="\begin{cases} y = x + 8 \\ y + 5 = 2(x + 5) \end{cases}" display="block"></div>

<p>Sistem jednačina je kao slagalica — dva uslova koja ISTOVREMENO moraju da važe.</p>

<h2>Korak 4: Rešavamo — metoda zamene</h2>

<p>Iz prve jednačine već znamo šta je y — to je <strong>x + 8</strong>. E sad, tu vrednost za y možemo da „ubacimo" u drugu jednačinu. Kao kad znaš da je jabuka 50 dinara, pa svuda gde piše „jabuka" napišeš 50.</p>

<p>Druga jednačina je: <strong>y + 5 = 2(x + 5)</strong></p>

<p>Zamenimo y sa (x + 8):</p>

<div data-math-block="" latex="(x + 8) + 5 = 2(x + 5)" display="block"></div>

<p>Sad imamo samo jedno slovo — x! Hajde da sredimo:</p>

<p>Leva strana: x + 8 + 5 = <strong>x + 13</strong></p>

<div data-math-block="" latex="x + 13 = 2(x + 5)" display="block"></div>

<p>Desna strana: 2 × x + 2 × 5 = <strong>2x + 10</strong></p>

<div data-math-block="" latex="x + 13 = 2x + 10" display="block"></div>

<p>Prebacimo sve x-ove na jednu stranu, sve brojeve na drugu (kad prebacimo, menjamo predznak!):</p>

<div data-math-block="" latex="13 - 10 = 2x - x" display="block"></div>

<div data-math-block="" latex="3 = x" display="block"></div>

<p><strong>Brat ima 3 godine!</strong></p>

<p>A Maja? Vratimo se na prvu jednačinu:</p>

<div data-math-block="" latex="y = x + 8 = 3 + 8 = 11" display="block"></div>

<p><strong>Maja ima 11 godina!</strong></p>

<h2>Korak 5: Provera — da li smo dobro uradili?</h2>

<p>UVEK proverimo da li naši odgovori zadovoljavaju ono što piše u zadatku:</p>

<p><strong>Provera 1:</strong> „Maja je 8 godina starija od brata"</p>
<p>Maja ima 11, brat ima 3. Razlika: 11 - 3 = 8. Tačno!</p>

<p><strong>Provera 2:</strong> „Za 5 godina Maja će biti 2 puta starija"</p>
<p>Za 5 godina: brat 3 + 5 = 8, Maja 11 + 5 = 16.</p>
<p>Da li je 16 jednako 2 × 8? DA! Tačno!</p>

<h2>Odgovor</h2>

<div data-math-block="" latex="\boxed{\text{Brat ima 3 godine, a Maja ima 11 godina.}}" display="block"></div>

<h2>Kako da zapamtiš postupak?</h2>

<ol>
<li><strong>Označi nepoznate</strong> — šta ne znaš, to nazovi x i y</li>
<li><strong>Prevedi tekst u jednačine</strong> — svaka rečenica sa podatkom daje jednu jednačinu</li>
<li><strong>Reši sistem</strong> — izrazi jedno iz jedne jednačine, pa zameni u drugu</li>
<li><strong>Proveri</strong> — vrati se na tekst i proveri da li tvoji odgovori imaju smisla</li>
</ol>']);

echo "Lesson 49 updated.\n";

// Lesson 50 - Zadatak 39
Lesson::find(50)->update(['content' => '<h1>Zadatak 39: Koliko ima olova i cinka u leguri?</h1>

<h2>Tekst zadatka</h2>

<p><strong>U jednoj leguri olovo i cink su zastupljeni u odnosu 4 : 7. Ako je masa legure 583 g, odredi koliko ima olova, a koliko cinka u toj leguri.</strong></p>

<h2>Šta je legura?</h2>

<p>Legura je mešavina dva ili više metala. Na primer, bronza je legura bakra i kalaja. U ovom zadatku, naša legura je napravljena od dva metala: <strong>olova</strong> i <strong>cinka</strong>. Cela legura teži 583 grama, a mi treba da otkrijemo koliko od toga je olovo, a koliko cink.</p>

<h2>Šta znači „odnos 4 : 7"?</h2>

<p>Ovo je ključna stvar! Odnos 4 : 7 znači: <strong>na svaka 4 dela olova, ima 7 delova cinka</strong>.</p>

<p>Zamisli da imaš 11 kockica (4 + 7 = 11). Od tih 11 kockica, 4 su od olova, a 7 od cinka. To je odnos 4 : 7.</p>

<p>Ali naša legura ne teži 11 grama, nego 583. Dakle, moramo da otkrijemo koliko tačno ima svakog metala.</p>

<h2>Korak 1: Označimo nepoznate</h2>

<ul>
<li><strong>x</strong> = masa olova u gramima</li>
<li><strong>y</strong> = masa cinka u gramima</li>
</ul>

<h2>Korak 2: Napravimo jednačine</h2>

<h3>Prva jednačina: „Olovo i cink su u odnosu 4 : 7"</h3>

<p>Odnos znači da kad podelimo masu olova sa masom cinka, dobijamo isti rezultat kao kad podelimo 4 sa 7:</p>

<div data-math-block="" latex="\frac{x}{y} = \frac{4}{7}" display="block"></div>

<p>Ovo možemo da zapišemo i ovako (pomnožimo „unakrsno" — x sa 7 i y sa 4):</p>

<div data-math-block="" latex="7x = 4y" display="block"></div>

<h3>Druga jednačina: „Masa legure je 583 g"</h3>

<p>Pošto se legura sastoji SAMO od olova i cinka, kad ih saberemo dobijamo ukupnu masu:</p>

<div data-math-block="" latex="x + y = 583" display="block"></div>

<h2>Korak 3: Sistem jednačina</h2>

<div data-math-block="" latex="\begin{cases} 7x = 4y \\ x + y = 583 \end{cases}" display="block"></div>

<h2>Korak 4: Rešavamo</h2>

<p>Iz prve jednačine izrazimo x (podelimo obe strane sa 7):</p>

<div data-math-block="" latex="x = \frac{4y}{7}" display="block"></div>

<p>Ovo znači: masa olova je jednaka četiri sedmine mase cinka.</p>

<p>Sada to ubacimo u drugu jednačinu umesto x:</p>

<div data-math-block="" latex="\frac{4y}{7} + y = 583" display="block"></div>

<p>Imamo razlomak — hajde da ga se rešimo. Pomnožimo celu jednačinu sa 7:</p>

<div data-math-block="" latex="4y + 7y = 583 \times 7" display="block"></div>

<div data-math-block="" latex="11y = 4081" display="block"></div>

<p>Podelimo obe strane sa 11:</p>

<div data-math-block="" latex="y = \frac{4081}{11} = 371" display="block"></div>

<p><strong>Cinka ima 371 gram!</strong></p>

<p>A olovo? Vratimo u drugu jednačinu:</p>

<div data-math-block="" latex="x = 583 - 371 = 212" display="block"></div>

<p><strong>Olova ima 212 grama!</strong></p>

<h2>Korak 5: Provera</h2>

<p><strong>Provera 1:</strong> Ukupna masa: 212 + 371 = 583 g. Tačno!</p>

<p><strong>Provera 2:</strong> Da li je odnos zaista 4 : 7?</p>
<p>Podelimo oba broja sa istim brojem da vidimo. Tražimo najmanji zajednički: 212 ÷ 53 = 4, 371 ÷ 53 = 7.</p>
<p>Odnos je 4 : 7. Tačno!</p>

<h2>Odgovor</h2>

<div data-math-block="" latex="\boxed{\text{Olova ima 212 g, a cinka 371 g.}}" display="block"></div>

<h2>Zaključak o zadacima sa odnosom</h2>

<p>Kad zadatak kaže „odnos je a : b", to uvek daješ dve informacije:</p>
<ol>
<li>Razlomak: x/y = a/b, što se unakrsno množi u <strong>bx = ay</strong></li>
<li>Neki zbir ili razliku koji daje drugu jednačinu</li>
</ol>']);

echo "Lesson 50 updated.\n";

// Lesson 51 - Zadatak 40
Lesson::find(51)->update(['content' => '<h1>Zadatak 40: Koliko godina imaju majka i sin?</h1>

<h2>Tekst zadatka</h2>

<p><strong>Pre 4 godine majka je bila 4 puta starija od sina. Koliko godina ima majka, a koliko sin ako je on sada 3 puta mlađi od majke?</strong></p>

<h2>Analizirajmo zadatak</h2>

<p>Ovaj zadatak priča o godinama majke i sina u DVA trenutka:</p>
<ul>
<li><strong>SADA</strong> — sadašnje godine</li>
<li><strong>PRE 4 GODINE</strong> — koliko su imali pre 4 godine</li>
</ul>

<p>Ključna stvar kod ovakvih zadataka: ako neko SADA ima x godina, onda je PRE 4 GODINE imao <strong>x - 4</strong> godina. Logično — jednostavno oduzmemo 4!</p>

<h2>Korak 1: Označimo nepoznate</h2>

<ul>
<li><strong>x</strong> = koliko godina ima sin SADA</li>
<li><strong>y</strong> = koliko godina ima majka SADA</li>
</ul>

<p>A koliko su imali pre 4 godine?</p>
<ul>
<li>Sin je pre 4 godine imao: <strong>x - 4</strong></li>
<li>Majka je pre 4 godine imala: <strong>y - 4</strong></li>
</ul>

<h2>Korak 2: Prevedemo tekst u jednačine</h2>

<h3>Prva rečenica: „Pre 4 godine majka je bila 4 puta starija od sina"</h3>

<p>To znači da je TADA majčin broj godina bio 4 puta veći od sinovog:</p>

<div data-math-block="" latex="y - 4 = 4 \cdot (x - 4)" display="block"></div>

<p>Hajde da proverimo sa nekim primerom: ako je sin pre 4 godine imao 5 godina, majka je tada imala 4 × 5 = 20 godina. Ima smisla!</p>

<h3>Druga rečenica: „On je sada 3 puta mlađi od majke"</h3>

<p>Pažljivo! „3 puta mlađi" znači isto što i „majka je 3 puta starija". Dakle:</p>

<div data-math-block="" latex="y = 3x" display="block"></div>

<p>Na primer: ako sin ima 10 godina, majka ima 3 × 10 = 30. Sin je 3 puta mlađi od majke.</p>

<h2>Korak 3: Sistem jednačina</h2>

<div data-math-block="" latex="\begin{cases} y - 4 = 4(x - 4) \\ y = 3x \end{cases}" display="block"></div>

<h2>Korak 4: Rešavamo</h2>

<p>Super! Druga jednačina nam kaže da je y = 3x. To je odlično jer možemo odmah da zamenimo y u prvoj jednačini:</p>

<div data-math-block="" latex="3x - 4 = 4(x - 4)" display="block"></div>

<p>Razvijemo desnu stranu — pomnožimo 4 sa svakim članom u zagradi:</p>

<div data-math-block="" latex="3x - 4 = 4x - 16" display="block"></div>

<p>Sada prebacujemo — x-ove na jednu stranu, brojeve na drugu:</p>

<div data-math-block="" latex="3x - 4x = -16 + 4" display="block"></div>

<p>Pazimo na predznake! Kad prebacimo 4x sa desne na levu stranu, menja se u -4x. Kad prebacimo -4 sa leve na desnu, menja se u +4.</p>

<div data-math-block="" latex="-x = -12" display="block"></div>

<p>Pomnožimo obe strane sa -1 (kad je nešto negativno sa obe strane, obrnemo predznak):</p>

<div data-math-block="" latex="x = 12" display="block"></div>

<p><strong>Sin ima 12 godina!</strong></p>

<p>A majka? Koristimo y = 3x:</p>

<div data-math-block="" latex="y = 3 \times 12 = 36" display="block"></div>

<p><strong>Majka ima 36 godina!</strong></p>

<h2>Korak 5: Provera</h2>

<p><strong>Provera 1:</strong> „On je sada 3 puta mlađi od majke"</p>
<p>Sin: 12, majka: 36. Da li je 36 = 3 × 12? DA! Tačno!</p>

<p><strong>Provera 2:</strong> „Pre 4 godine majka je bila 4 puta starija"</p>
<p>Pre 4 godine: sin je imao 12 - 4 = 8, majka 36 - 4 = 32.</p>
<p>Da li je 32 = 4 × 8? DA! Tačno!</p>

<h2>Odgovor</h2>

<div data-math-block="" latex="\boxed{\text{Sin ima 12 godina, a majka 36 godina.}}" display="block"></div>

<h2>Saveti za zadatke sa godinama</h2>

<p>Zadaci sa godinama se pojavljuju često. Evo šta treba da zapamtiš:</p>

<table>
<tr><th>Tekst u zadatku</th><th>Matematički zapis</th></tr>
<tr><td>Sada ima x godina</td><td>x</td></tr>
<tr><td>Pre 4 godine imao je</td><td>x - 4</td></tr>
<tr><td>Za 5 godina imaće</td><td>x + 5</td></tr>
<tr><td>A je 3 puta starija od B</td><td>A = 3B</td></tr>
<tr><td>B je 3 puta mlađi od A</td><td>A = 3B (isto!)</td></tr>
<tr><td>A je 8 godina starija od B</td><td>A = B + 8</td></tr>
</table>']);

echo "Lesson 51 updated.\n";
echo "Done!\n";
