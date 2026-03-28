<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Subchapter;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class PygameKursSeeder extends Seeder
{
    private int $courseId = 12; // Informatika 7

    private function code(string $starterCode, string $instructions = ''): string
    {
        $sc = htmlspecialchars($starterCode, ENT_QUOTES, 'UTF-8');
        $ins = htmlspecialchars($instructions, ENT_QUOTES, 'UTF-8');
        return '<div data-code-exercise startercode="' . $sc . '" instructions="' . $ins . '"></div>';
    }

    public function run(): void
    {
        // Clean existing
        $chapters = Chapter::where('course_id', $this->courseId)->get();
        foreach ($chapters as $ch) {
            foreach ($ch->subchapters as $sub) {
                $sub->lessons()->delete();
            }
            $ch->subchapters()->delete();
        }
        $chapters->each->delete();

        // ============================================================
        // CHAPTER 1: Uvod u Pygame
        // ============================================================
        $ch1 = Chapter::create(['course_id' => $this->courseId, 'title' => 'Uvod u Pygame', 'order' => 1]);
        $sub1 = Subchapter::create(['chapter_id' => $ch1->id, 'title' => 'Prve korake', 'order' => 1]);

        // 1.1 Sta je Pygame
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub1->id,
            'title' => 'Sta je Pygame?',
            'content' => '<h2>Sta je Pygame?</h2>'
                . '<p>Pygame je Python biblioteka za pravljenje igara i grafickih programa. Sa njom mozes da crtas oblike, pravis animacije, a kasnije i prave igre!</p>'
                . '<p>U nasem LMS-u Pygame radi direktno u browseru - ne moras nista da instaliras. Samo napises kod i kliknes <strong>Run</strong>.</p>'
                . '<h3>Kako radi Pygame program?</h3>'
                . '<p>Svaki Pygame program ima istu strukturu:</p>'
                . '<ol>'
                . '<li><strong>Uvoz biblioteke</strong> - <code>import pygame</code></li>'
                . '<li><strong>Pravljenje prozora</strong> - <code>pygame.display.set_mode((sirina, visina))</code></li>'
                . '<li><strong>Bojenje pozadine</strong> - <code>prozor.fill(boja)</code></li>'
                . '<li><strong>Crtanje oblika</strong> - razne draw funkcije</li>'
                . '<li><strong>Prikaz</strong> - <code>pygame.display.update()</code></li>'
                . '</ol>'
                . '<h3>Koordinatni sistem</h3>'
                . '<p>Pygame koristi koordinatni sistem koji je malo drugaciji od onog u matematici:</p>'
                . '<ul>'
                . '<li>Tacka <strong>(0, 0)</strong> je u <strong>gornjem levom uglu</strong> (ne u donjem levom!)</li>'
                . '<li><strong>X</strong> raste udesno (kao u matematici)</li>'
                . '<li><strong>Y</strong> raste nadole (suprotno od matematike!)</li>'
                . '</ul>'
                . '<p>Zamisli da je ekran list papira na zidu. Vrh papira je y=0, a dno je y=400.</p>'
                . '<h3>Boje u Pygame-u</h3>'
                . '<p>Boje se zadaju kao tri broja: <strong>(R, G, B)</strong> - crvena, zelena, plava. Svaki broj ide od 0 do 255.</p>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Boja</th><th>RGB vrednost</th><th>Kako zapamtiti</th></tr></thead>'
                . '<tbody>'
                . '<tr><td>Crna</td><td>(0, 0, 0)</td><td>Sve ugaseno</td></tr>'
                . '<tr><td>Bela</td><td>(255, 255, 255)</td><td>Sve upaljeno</td></tr>'
                . '<tr><td>Crvena</td><td>(255, 0, 0)</td><td>Samo R</td></tr>'
                . '<tr><td>Zelena</td><td>(0, 255, 0)</td><td>Samo G</td></tr>'
                . '<tr><td>Plava</td><td>(0, 0, 255)</td><td>Samo B</td></tr>'
                . '<tr><td>Zuta</td><td>(255, 255, 0)</td><td>R + G</td></tr>'
                . '<tr><td>Narandzasta</td><td>(255, 165, 0)</td><td>R + malo G</td></tr>'
                . '<tr><td>Ljubicasta</td><td>(128, 0, 128)</td><td>R + B</td></tr>'
                . '<tr><td>Siva</td><td>(128, 128, 128)</td><td>Sve na pola</td></tr>'
                . '<tr><td>Svetlo plava</td><td>(135, 206, 235)</td><td>Nebo</td></tr>'
                . '</tbody></table>'
                . '<h3>Tvoj prvi Pygame program</h3>'
                . '<p>Pokreni kod ispod - videces beli prozor sa plavom pozadinom:</p>'
                . $this->code(
                    "import pygame\n\n# Napravi prozor 400x300 piksela\nprozor = pygame.display.set_mode((400, 300))\n\n# Oboji pozadinu svetlo plavom bojom\nprozor.fill((135, 206, 235))\n\n# Prikazi sve na ekranu\npygame.display.update()",
                    'Pokreni program. Probaj da promenis boju pozadine - stavi (255, 200, 200) za roze ili (200, 255, 200) za svetlo zelenu.'
                )
                . '<h3>Pregled komandi</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Komanda</th><th>Sta radi</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>import pygame</code></td><td>Uvozi Pygame biblioteku</td><td>Uvek na pocetku</td></tr>'
                . '<tr><td><code>pygame.display.set_mode((w, h))</code></td><td>Pravi prozor sirine w i visine h</td><td><code>pygame.display.set_mode((400, 300))</code></td></tr>'
                . '<tr><td><code>prozor.fill((R, G, B))</code></td><td>Boji ceo prozor zadatom bojom</td><td><code>prozor.fill((255, 255, 255))</code></td></tr>'
                . '<tr><td><code>pygame.display.update()</code></td><td>Prikazuje sve sto smo nacrtali</td><td>Uvek na kraju</td></tr>'
                . '</tbody></table>',
            'order' => 1,
            'is_assignment' => false,
        ]);

        // 1.2 Crtanje linija
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub1->id,
            'title' => 'Crtanje linija',
            'content' => '<h2>Crtanje linija</h2>'
                . '<p>Linija je najjednostavniji oblik. Zadajemo joj pocetnu i krajnju tacku.</p>'
                . '<h3>pygame.draw.line()</h3>'
                . '<p><strong>Sta radi:</strong> Crta pravu liniju od jedne tacke do druge.</p>'
                . '<p><strong>Parametri:</strong></p>'
                . '<pre><code>pygame.draw.line(prozor, boja, (x1, y1), (x2, y2), debljina)</code></pre>'
                . '<ul>'
                . '<li><code>prozor</code> - gde crtamo</li>'
                . '<li><code>boja</code> - (R, G, B) trojka</li>'
                . '<li><code>(x1, y1)</code> - pocetna tacka</li>'
                . '<li><code>(x2, y2)</code> - krajnja tacka</li>'
                . '<li><code>debljina</code> - koliko je linija debela (u pikselima)</li>'
                . '</ul>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((400, 300))\nprozor.fill((255, 255, 255))  # bela pozadina\n\n# Crvena horizontalna linija\npygame.draw.line(prozor, (255, 0, 0), (50, 50), (350, 50), 3)\n\n# Zelena vertikalna linija\npygame.draw.line(prozor, (0, 128, 0), (200, 20), (200, 280), 3)\n\n# Plava dijagonalna linija\npygame.draw.line(prozor, (0, 0, 255), (50, 250), (350, 100), 5)\n\npygame.display.update()",
                    'Pokreni pa probaj da promenis koordinate i boje linija.'
                )
                . '<h3>Primer: Kuca od linija</h3>'
                . '<p>Hajde da nacrtamo jednostavnu kucu koristeci samo linije:</p>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((400, 300))\nprozor.fill((135, 206, 235))  # nebo\n\n# Zidovi kuce (braon pravougaonik od linija)\npygame.draw.line(prozor, (139, 69, 19), (100, 150), (300, 150), 3)  # gore\npygame.draw.line(prozor, (139, 69, 19), (100, 150), (100, 280), 3)  # levo\npygame.draw.line(prozor, (139, 69, 19), (300, 150), (300, 280), 3)  # desno\npygame.draw.line(prozor, (139, 69, 19), (100, 280), (300, 280), 3)  # dole\n\n# Krov (crveni trougao od linija)\npygame.draw.line(prozor, (178, 34, 34), (80, 150), (200, 50), 4)\npygame.draw.line(prozor, (178, 34, 34), (200, 50), (320, 150), 4)\n\n# Vrata\npygame.draw.line(prozor, (101, 67, 33), (170, 200), (230, 200), 2)\npygame.draw.line(prozor, (101, 67, 33), (170, 200), (170, 280), 2)\npygame.draw.line(prozor, (101, 67, 33), (230, 200), (230, 280), 2)\n\npygame.display.update()",
                    'Nacrtali smo kucu sa krovom. Probaj da dodas prozor na kucu (dva horizontalna i dva vertikalna para linija).'
                ),
            'order' => 2,
            'is_assignment' => false,
        ]);

        // 1.3 Pravougaonici i krugovi
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub1->id,
            'title' => 'Pravougaonici i krugovi',
            'content' => '<h2>Pravougaonici i krugovi</h2>'
                . '<p>Linije su korisne, ali za vecinu crteza koristimo oblike - pravougaonike i krugove.</p>'
                . '<h3>pygame.draw.rect() - pravougaonik</h3>'
                . '<p><strong>Parametri:</strong></p>'
                . '<pre><code>pygame.draw.rect(prozor, boja, (x, y, sirina, visina), debljina)</code></pre>'
                . '<ul>'
                . '<li><code>(x, y)</code> - gornji levi ugao pravougaonika</li>'
                . '<li><code>sirina, visina</code> - dimenzije</li>'
                . '<li><code>debljina</code> - 0 znaci popunjen, broj > 0 znaci samo okvir te debljine</li>'
                . '</ul>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((400, 300))\nprozor.fill((255, 255, 255))\n\n# Popunjen crveni pravougaonik\npygame.draw.rect(prozor, (255, 0, 0), (50, 50, 120, 80))\n\n# Samo okvir (plavi, debljina 3)\npygame.draw.rect(prozor, (0, 0, 255), (200, 50, 150, 80), 3)\n\n# Zeleni kvadrat (sirina = visina)\npygame.draw.rect(prozor, (0, 180, 0), (130, 170, 100, 100))\n\npygame.display.update()",
                    'Popunjeni oblik ima debljinu 0 (ili bez parametra). Okvir ima debljinu > 0. Probaj oba!'
                )
                . '<h3>pygame.draw.circle() - krug</h3>'
                . '<p><strong>Parametri:</strong></p>'
                . '<pre><code>pygame.draw.circle(prozor, boja, (cx, cy), poluprecnik, debljina)</code></pre>'
                . '<ul>'
                . '<li><code>(cx, cy)</code> - centar kruga</li>'
                . '<li><code>poluprecnik</code> - velicina kruga</li>'
                . '<li><code>debljina</code> - 0 = popunjen, > 0 = samo kruznica</li>'
                . '</ul>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((400, 300))\nprozor.fill((255, 255, 255))\n\n# Popunjen narandzasti krug\npygame.draw.circle(prozor, (255, 165, 0), (100, 150), 60)\n\n# Kruznica (samo okvir)\npygame.draw.circle(prozor, (0, 0, 200), (280, 150), 80, 3)\n\n# Mali crveni krug\npygame.draw.circle(prozor, (255, 0, 0), (200, 80), 20)\n\npygame.display.update()",
                    'Centar kruga je (cx, cy), a poluprecnik je koliko je krug velik. Probaj razne velicine!'
                )
                . '<h3>Primer: Semafor</h3>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((400, 400))\nprozor.fill((200, 200, 200))  # siva pozadina\n\n# Telo semafora (crni pravougaonik)\npygame.draw.rect(prozor, (40, 40, 40), (150, 30, 100, 320))\n\n# Crveno svetlo\npygame.draw.circle(prozor, (255, 0, 0), (200, 100), 35)\n\n# Zuto svetlo\npygame.draw.circle(prozor, (255, 255, 0), (200, 200), 35)\n\n# Zeleno svetlo\npygame.draw.circle(prozor, (0, 255, 0), (200, 300), 35)\n\n# Stubic\npygame.draw.rect(prozor, (80, 80, 80), (185, 350, 30, 50))\n\npygame.display.update()",
                    'Semafor sa tri svetla. Probaj da promenis velicinu semafora ili da dodas okvire oko svetala.'
                )
                . '<h3>Pregled komandi za crtanje</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Komanda</th><th>Sta crta</th><th>Kljucni parametri</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>pygame.draw.line()</code></td><td>Liniju</td><td>pocetna tacka, krajnja tacka, debljina</td></tr>'
                . '<tr><td><code>pygame.draw.rect()</code></td><td>Pravougaonik</td><td>(x, y, sirina, visina), debljina (0=popunjen)</td></tr>'
                . '<tr><td><code>pygame.draw.circle()</code></td><td>Krug</td><td>centar (cx,cy), poluprecnik, debljina (0=popunjen)</td></tr>'
                . '</tbody></table>',
            'order' => 3,
            'is_assignment' => false,
        ]);

        // 1.4 Domaci
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub1->id,
            'title' => 'Domaci: Moj prvi crtez',
            'content' => '<h2>Domaci: Moj prvi crtez</h2>'
                . '<p>Koristi sve sto si naucio - linije, pravougaonike i krugove - da nacrtas zadatke ispod.</p>'
                . '<h3>Zadatak 1: Zastava Srbije</h3>'
                . '<p>Nacrtaj zastavu Srbije: tri horizontalne trake (crvena, plava, bela) pomocu tri pravougaonika.</p>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((400, 300))\n\n# Crvena traka (gore)\npygame.draw.rect(prozor, (198, 54, 60), (0, 0, 400, 100))\n\n# Plava traka (sredina)\n\n# Bela traka (dole)\n\npygame.display.update()",
                    'Dopuni kod da nacrtas zastavu sa tri trake jednake visine.'
                )
                . '<h3>Zadatak 2: Lice</h3>'
                . '<p>Nacrtaj smajlija: veliki zuti krug za glavu, dva manja crna kruga za oci, i crvenu liniju za osmeh.</p>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((400, 400))\nprozor.fill((255, 255, 255))\n\n# Glava (veliki zuti krug)\n\n# Oci (dva mala crna kruga)\n\n# Osmeh (crvena linija ili luk)\n\npygame.display.update()",
                    'Nacrtaj smajlija koristeci krugove i linije.'
                )
                . '<h3>Zadatak 3: Robot</h3>'
                . '<p>Nacrtaj robota koristeci pravougaonike (telo, glava, ruke, noge) i krugove (oci, dugmad).</p>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((400, 400))\nprozor.fill((200, 220, 240))\n\n# Glava\n\n# Telo\n\n# Ruke\n\n# Noge\n\n# Oci i dugmad\n\npygame.display.update()",
                    'Napravi svog robota! Koristi razne boje i velicine.'
                ),
            'order' => 4,
            'is_assignment' => true,
        ]);

        // ============================================================
        // CHAPTER 2: Napredni oblici i tekst
        // ============================================================
        $ch2 = Chapter::create(['course_id' => $this->courseId, 'title' => 'Napredni oblici i tekst', 'order' => 2]);
        $sub2 = Subchapter::create(['chapter_id' => $ch2->id, 'title' => 'Elipse, poligoni, tekst', 'order' => 1]);

        // 2.1 Elipse i poligoni
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub2->id,
            'title' => 'Elipse i poligoni',
            'content' => '<h2>Elipse i poligoni</h2>'
                . '<h3>pygame.draw.ellipse() - elipsa</h3>'
                . '<p><strong>Sta radi:</strong> Crta elipsu (izduzeni krug) unutar zadatog pravougaonika.</p>'
                . '<pre><code>pygame.draw.ellipse(prozor, boja, (x, y, sirina, visina), debljina)</code></pre>'
                . '<p>Elipsa se upisuje u nevidljivi pravougaonik. Ako je sirina = visina, dobijamo krug!</p>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((400, 300))\nprozor.fill((255, 255, 255))\n\n# Siroka elipsa (lezi)\npygame.draw.ellipse(prozor, (255, 100, 0), (50, 50, 200, 80))\n\n# Visoka elipsa (stoji)\npygame.draw.ellipse(prozor, (0, 100, 200), (270, 30, 80, 200))\n\n# Elipsa samo okvir\npygame.draw.ellipse(prozor, (200, 0, 100), (80, 180, 180, 90), 3)\n\npygame.display.update()",
                    'Elipsa se upisuje u pravougaonik (x, y, sirina, visina). Siroka elipsa = sirina > visina.'
                )
                . '<h3>pygame.draw.polygon() - poligon</h3>'
                . '<p><strong>Sta radi:</strong> Crta oblik sa proizvoljnim brojem temena (uglova). Zadajemo listu tacaka.</p>'
                . '<pre><code>pygame.draw.polygon(prozor, boja, [(x1,y1), (x2,y2), (x3,y3), ...], debljina)</code></pre>'
                . '<p>Sa 3 tacke crtamo trougao, sa 5 petougao, sa 6 sestougao...</p>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((400, 300))\nprozor.fill((255, 255, 255))\n\n# Trougao (3 tacke)\npygame.draw.polygon(prozor, (255, 0, 0),\n    [(200, 30), (100, 200), (300, 200)])\n\n# Petougao (5 tacaka)\npygame.draw.polygon(prozor, (0, 128, 0),\n    [(60, 230), (20, 270), (40, 290), (80, 290), (100, 270)], 3)\n\n# Dijamant/romb (4 tacke)\npygame.draw.polygon(prozor, (0, 0, 200),\n    [(300, 220), (260, 260), (300, 290), (340, 260)])\n\npygame.display.update()",
                    'Poligon moze imati koliko god tacaka zelis. Probaj da napravis zvezdicu sa 10 tacaka!'
                )
                . '<h3>Primer: Jelka</h3>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((400, 400))\nprozor.fill((135, 206, 235))  # nebo\n\n# Stablo (braon pravougaonik)\npygame.draw.rect(prozor, (139, 69, 19), (175, 300, 50, 80))\n\n# Tri zelena trougla (kruna jelke)\npygame.draw.polygon(prozor, (0, 128, 0),\n    [(200, 50), (100, 180), (300, 180)])\npygame.draw.polygon(prozor, (0, 140, 0),\n    [(200, 120), (80, 250), (320, 250)])\npygame.draw.polygon(prozor, (0, 150, 0),\n    [(200, 190), (60, 320), (340, 320)])\n\n# Zvezdica na vrhu (zuti poligon)\npygame.draw.polygon(prozor, (255, 215, 0),\n    [(200, 30), (205, 50), (225, 50), (210, 60),\n     (215, 80), (200, 68), (185, 80), (190, 60),\n     (175, 50), (195, 50)])\n\n# Kuglice (krugovi)\npygame.draw.circle(prozor, (255, 0, 0), (160, 200), 8)\npygame.draw.circle(prozor, (255, 215, 0), (230, 170), 8)\npygame.draw.circle(prozor, (0, 0, 255), (180, 260), 8)\npygame.draw.circle(prozor, (255, 0, 100), (250, 240), 8)\n\npygame.display.update()",
                    'Jelka sa kuglicama! Dodaj jos kuglica ili napravi sneg (bele krugove).'
                ),
            'order' => 1,
            'is_assignment' => false,
        ]);

        // 2.2 Tekst
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub2->id,
            'title' => 'Pisanje teksta',
            'content' => '<h2>Pisanje teksta</h2>'
                . '<p>Osim oblika, mozemo pisati i tekst na ekranu. Za to koristimo Pygame fontove.</p>'
                . '<h3>Kako se pise tekst?</h3>'
                . '<p>Pisanje teksta u Pygame-u ima tri koraka:</p>'
                . '<ol>'
                . '<li><strong>Napravi font</strong> - <code>pygame.font.SysFont("Arial", velicina)</code></li>'
                . '<li><strong>Renderuj tekst</strong> - <code>font.render("tekst", True, boja)</code></li>'
                . '<li><strong>Nacrtaj na prozoru</strong> - <code>prozor.blit(tekst, (x, y))</code></li>'
                . '</ol>'
                . $this->code(
                    "import pygame\npygame.font.init()\n\nprozor = pygame.display.set_mode((400, 300))\nprozor.fill((255, 255, 255))\n\n# Napravi font (ime fonta, velicina)\nfont_veliki = pygame.font.SysFont('Arial', 48)\nfont_mali = pygame.font.SysFont('Arial', 24)\n\n# Renderuj tekst (tekst, antialiasing, boja)\nnaslov = font_veliki.render('Pygame!', True, (0, 0, 200))\npodnaslov = font_mali.render('Ucimo da crtamo', True, (100, 100, 100))\n\n# Nacrtaj na prozoru na poziciji (x, y)\nprozor.blit(naslov, (100, 80))\nprozor.blit(podnaslov, (110, 150))\n\npygame.display.update()",
                    'Font.render() pravi sliku od teksta, a blit() je crta na prozor. Probaj razne velicine i boje!'
                )
                . '<h3>Primer: Vizit karta</h3>'
                . $this->code(
                    "import pygame\npygame.font.init()\n\nprozor = pygame.display.set_mode((400, 250))\nprozor.fill((245, 245, 245))\n\n# Okvir\npygame.draw.rect(prozor, (0, 100, 180), (10, 10, 380, 230), 3)\n\n# Dekorativna linija\npygame.draw.line(prozor, (0, 100, 180), (30, 120), (370, 120), 2)\n\n# Fontovi\nfont_ime = pygame.font.SysFont('Arial', 36)\nfont_info = pygame.font.SysFont('Arial', 18)\n\n# Ime\ntekst_ime = font_ime.render('Petar Petrovic', True, (30, 30, 30))\nprozor.blit(tekst_ime, (30, 40))\n\n# Informacije\ntekst1 = font_info.render('Ucenik 7. razreda', True, (100, 100, 100))\ntekst2 = font_info.render('OS Zarko Zrenjanin', True, (100, 100, 100))\ntekst3 = font_info.render('Omiljeni predmet: Informatika', True, (0, 100, 180))\n\nprozor.blit(tekst1, (30, 140))\nprozor.blit(tekst2, (30, 168))\nprozor.blit(tekst3, (30, 196))\n\npygame.display.update()",
                    'Vizit karta! Promeni ime i informacije da bude tvoja karta.'
                )
                . '<h3>Pregled komandi za tekst</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Komanda</th><th>Sta radi</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>pygame.font.init()</code></td><td>Inicijalizuje font sistem (obavezno pre koriscenja)</td></tr>'
                . '<tr><td><code>pygame.font.SysFont(ime, vel)</code></td><td>Pravi font sa zadatim imenom i velicinom</td></tr>'
                . '<tr><td><code>font.render(tekst, True, boja)</code></td><td>Pretvara tekst u sliku (True = glatke ivice)</td></tr>'
                . '<tr><td><code>prozor.blit(slika, (x, y))</code></td><td>Crta sliku/tekst na poziciji (x, y)</td></tr>'
                . '</tbody></table>',
            'order' => 2,
            'is_assignment' => false,
        ]);

        // 2.3 Racunanje koordinata
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub2->id,
            'title' => 'Racunanje koordinata',
            'content' => '<h2>Racunanje koordinata</h2>'
                . '<p>Do sada smo koordinate pisali rucno. Ali sta ako hoces da crtez bude uvek centriran, ili da se prilagodi velicini prozora? Za to koristimo <strong>promenljive i racunanje</strong>.</p>'
                . '<h3>Centar prozora</h3>'
                . '<p>Ako je prozor 400x300, centar je na (200, 150). Ali bolje je da izracunamo:</p>'
                . '<pre><code>sirina = 400\nvisina = 300\ncx = sirina // 2  # 200\ncy = visina // 2  # 150</code></pre>'
                . $this->code(
                    "import pygame\n\nSIRINA = 400\nVISINA = 400\nprozor = pygame.display.set_mode((SIRINA, VISINA))\nprozor.fill((240, 240, 240))\n\n# Centar prozora\ncx = SIRINA // 2\ncy = VISINA // 2\n\n# Nisan (target)\npygame.draw.circle(prozor, (255, 0, 0), (cx, cy), 80)\npygame.draw.circle(prozor, (255, 255, 255), (cx, cy), 55)\npygame.draw.circle(prozor, (255, 0, 0), (cx, cy), 30)\npygame.draw.circle(prozor, (255, 255, 255), (cx, cy), 10)\n\n# Linije krsta\npygame.draw.line(prozor, (0, 0, 0), (cx - 90, cy), (cx + 90, cy), 1)\npygame.draw.line(prozor, (0, 0, 0), (cx, cy - 90), (cx, cy + 90), 1)\n\npygame.display.update()",
                    'Nisan je uvek centriran jer koristimo cx i cy. Probaj da promenis SIRINA i VISINA!'
                )
                . '<h3>Relativne koordinate</h3>'
                . '<p>Umesto fiksnih brojeva, mozemo racunati pozicije relativno - npr. "50% od sirine", "treci deo visine"...</p>'
                . $this->code(
                    "import pygame\n\nSIRINA = 400\nVISINA = 300\nprozor = pygame.display.set_mode((SIRINA, VISINA))\nprozor.fill((255, 255, 255))\n\n# Tri jednaka kruga, ravnomerno rasporedjeni\nza_krug = SIRINA // 4  # razmak\n\npygame.draw.circle(prozor, (255, 0, 0), (za_krug, VISINA//2), 40)\npygame.draw.circle(prozor, (0, 180, 0), (za_krug*2, VISINA//2), 40)\npygame.draw.circle(prozor, (0, 0, 255), (za_krug*3, VISINA//2), 40)\n\npygame.display.update()",
                    'Tri kruga su ravnomerno rasporedjeni jer koristimo SIRINA // 4. Dodaj cetvrti krug!'
                )
                . '<h3>Primer: Olimpijski krugovi</h3>'
                . $this->code(
                    "import pygame\n\nSIRINA = 500\nVISINA = 300\nprozor = pygame.display.set_mode((SIRINA, VISINA))\nprozor.fill((255, 255, 255))\n\nr = 50  # poluprecnik kruga\nd = 15  # razmak izmedju krugova\ncx = SIRINA // 2\ncy = VISINA // 2 - 20\n\n# Gornji red: plavi, crni, crveni\npygame.draw.circle(prozor, (0, 129, 188), (cx - 2*(r+d), cy), r, 4)\npygame.draw.circle(prozor, (0, 0, 0), (cx, cy), r, 4)\npygame.draw.circle(prozor, (255, 0, 0), (cx + 2*(r+d), cy), r, 4)\n\n# Donji red: zuti, zeleni\npygame.draw.circle(prozor, (252, 177, 49), (cx - (r+d), cy + r), r, 4)\npygame.draw.circle(prozor, (0, 157, 87), (cx + (r+d), cy + r), r, 4)\n\npygame.display.update()",
                    'Olimpijski krugovi! Sve pozicije su izracunate relativno od centra (cx, cy).'
                ),
            'order' => 3,
            'is_assignment' => false,
        ]);

        // 2.4 Domaci
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub2->id,
            'title' => 'Domaci: Kreativni crtez',
            'content' => '<h2>Domaci: Kreativni crtez</h2>'
                . '<h3>Zadatak 1: Sneskovic</h3>'
                . '<p>Nacrtaj sneska od tri kruga (veliki, srednji, mali), sa ocima, nosom (narandzasti trougao), dugmadima i sesiricem.</p>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((400, 450))\nprozor.fill((200, 220, 255))  # svetlo plavo nebo\n\n# Telo (tri bela kruga, od dole ka gore)\n\n# Oci, nos, dugmad, sesir...\n\npygame.display.update()",
                    'Nacrtaj sneska koristeci krugove, pravougaonike i poligone!'
                )
                . '<h3>Zadatak 2: Nocno nebo</h3>'
                . '<p>Nacrtaj tamno plavo nebo sa mescem (zuti krug) i zvezdama (mali zuti krugovi ili poligoni).</p>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((500, 350))\nprozor.fill((10, 10, 50))  # tamno plavo nebo\n\n# Mesec (veliki zuti krug u gornjem desnom uglu)\n\n# Zvezde (mali zuti krugovi na raznim mestima)\n\n# Planine ili drvo dole (opciono)\n\npygame.display.update()",
                    'Budi kreativan! Dodaj planine, drvece, oblake...'
                )
                . '<h3>Zadatak 3: Tvoj izbor</h3>'
                . '<p>Nacrtaj sta god zelis! Koristi sve naucene oblike: linije, pravougaonike, krugove, elipse, poligone i tekst. Ideje: grad, automobil, cvet, zivotinja, tvoja soba...</p>'
                . $this->code(
                    "import pygame\npygame.font.init()\n\nprozor = pygame.display.set_mode((500, 400))\nprozor.fill((255, 255, 255))\n\n# Tvoj crtez ovde!\n\npygame.display.update()",
                    'Slobodan izbor! Koristi sve sto si naucio.'
                ),
            'order' => 4,
            'is_assignment' => true,
        ]);

        // ============================================================
        // CHAPTER 3: Petlje i pravilni oblici
        // ============================================================
        $ch3 = Chapter::create(['course_id' => $this->courseId, 'title' => 'Crtanje pomocu petlji', 'order' => 3]);
        $sub3 = Subchapter::create(['chapter_id' => $ch3->id, 'title' => 'Ponavljanje oblika', 'order' => 1]);

        // 3.1 For petlja u crtanju
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub3->id,
            'title' => 'Ponavljanje oblika sa for petljom',
            'content' => '<h2>Ponavljanje oblika sa for petljom</h2>'
                . '<p>Sta ako treba da nacrtas 10 krugova u redu? Ili 20 linija? Rucno bi trajalo predugo. Sa <strong>for petljom</strong> mozemo to uraditi u par redova!</p>'
                . '<h3>Osnovni primer: Red krugova</h3>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((500, 200))\nprozor.fill((255, 255, 255))\n\n# 8 krugova u redu\nfor i in range(8):\n    x = 30 + i * 60  # svaki krug je 60 piksela desnije\n    pygame.draw.circle(prozor, (0, 100, 200), (x, 100), 25)\n\npygame.display.update()",
                    'range(8) daje brojeve 0,1,2,...,7. Koristimo i da racunamo x poziciju svakog kruga.'
                )
                . '<h3>Promena boje u petlji</h3>'
                . '<p>Mozemo menjati ne samo poziciju, vec i boju, velicinu i oblik u svakoj iteraciji:</p>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((500, 200))\nprozor.fill((255, 255, 255))\n\n# Krugovi koji postaju sve crveniji\nfor i in range(10):\n    x = 25 + i * 50\n    crvena = i * 25  # od 0 do 225\n    pygame.draw.circle(prozor, (crvena, 0, 255 - crvena), (x, 100), 20)\n\npygame.display.update()",
                    'Boja se menja jer koristimo i za racunanje crvene komponente!'
                )
                . '<h3>Mreza (grid)</h3>'
                . '<p>Sa <strong>dve ugnjezdene petlje</strong> mozemo crtati u redovima i kolonama:</p>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((400, 400))\nprozor.fill((255, 255, 255))\n\n# Mreza krugova 8x8\nfor red in range(8):\n    for kolona in range(8):\n        x = 25 + kolona * 50\n        y = 25 + red * 50\n        # Naizmenicne boje (kao sahovska tabla)\n        if (red + kolona) % 2 == 0:\n            boja = (70, 130, 180)  # plava\n        else:\n            boja = (255, 165, 0)   # narandzasta\n        pygame.draw.circle(prozor, boja, (x, y), 20)\n\npygame.display.update()",
                    'Dve petlje = mreza! red i kolona odredjuju poziciju svakog kruga.'
                )
                . '<h3>Primer: Sahovska tabla</h3>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((400, 400))\n\nvelicina = 50  # velicina jednog polja\n\nfor red in range(8):\n    for kolona in range(8):\n        x = kolona * velicina\n        y = red * velicina\n        if (red + kolona) % 2 == 0:\n            boja = (240, 217, 181)  # svetla\n        else:\n            boja = (181, 136, 99)   # tamna\n        pygame.draw.rect(prozor, boja, (x, y, velicina, velicina))\n\npygame.display.update()",
                    'Sahovska tabla sa 8x8 polja! (red + kolona) % 2 menja boju naizmenicno.'
                ),
            'order' => 1,
            'is_assignment' => false,
        ]);

        // 3.2 Slozeni oblici
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub3->id,
            'title' => 'Slozeni oblici i obrasci',
            'content' => '<h2>Slozeni oblici i obrasci</h2>'
                . '<p>Kombinovanjem petlji i matematike mozemo praviti fascinantne obrasce!</p>'
                . '<h3>Koncentricni krugovi</h3>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((400, 400))\nprozor.fill((0, 0, 0))  # crna pozadina\n\ncx, cy = 200, 200\n\n# Koncentricni krugovi (od velikog ka malom)\nfor i in range(10):\n    r = 180 - i * 18\n    boja = (i * 25, 50, 255 - i * 25)\n    pygame.draw.circle(prozor, boja, (cx, cy), r)\n\npygame.display.update()",
                    'Krugovi se crtaju od najviseg ka najmanjem. Svaki ima drugaciju boju!'
                )
                . '<h3>Spiralna tacka</h3>'
                . $this->code(
                    "import pygame\nimport math\n\nprozor = pygame.display.set_mode((400, 400))\nprozor.fill((0, 0, 30))\n\ncx, cy = 200, 200\n\n# Spirala od tacaka\nfor i in range(200):\n    ugao = i * 0.2\n    udaljenost = i * 0.8\n    x = int(cx + math.cos(ugao) * udaljenost)\n    y = int(cy + math.sin(ugao) * udaljenost)\n    boja = (i % 256, (i * 2) % 256, 255)\n    pygame.draw.circle(prozor, boja, (x, y), 3)\n\npygame.display.update()",
                    'Spirala! Koristimo math.cos i math.sin za kruzhno kretanje, a udaljenost raste.'
                )
                . '<h3>Primer: Duga</h3>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((500, 300))\nprozor.fill((135, 206, 235))  # nebo\n\n# Boje duge (od spoljne ka unutrasnjoj)\nboje = [\n    (255, 0, 0),      # crvena\n    (255, 127, 0),    # narandzasta\n    (255, 255, 0),    # zuta\n    (0, 255, 0),      # zelena\n    (0, 0, 255),      # plava\n    (75, 0, 130),     # indigo\n    (148, 0, 211),    # ljubicasta\n]\n\ncx = 250\ncy = 300\n\nfor i, boja in enumerate(boje):\n    r = 200 - i * 20\n    pygame.draw.circle(prozor, boja, (cx, cy), r)\n\n# Prekrij donji deo nebom\npygame.draw.rect(prozor, (135, 206, 235), (0, 260, 500, 40))\n\n# Oblak\npygame.draw.circle(prozor, (255, 255, 255), (100, 80), 30)\npygame.draw.circle(prozor, (255, 255, 255), (130, 70), 40)\npygame.draw.circle(prozor, (255, 255, 255), (160, 80), 30)\n\npygame.display.update()",
                    'Duga se crta kao niz sve manjih krugova, pa se donji deo prekrije pravougaonikom boje neba.'
                ),
            'order' => 2,
            'is_assignment' => false,
        ]);

        // 3.3 Grananje u crtanju
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub3->id,
            'title' => 'Grananje u crtanju (if/else)',
            'content' => '<h2>Grananje u crtanju (if/else)</h2>'
                . '<p>Sa <code>if</code> i <code>else</code> u petlji mozemo crtati razlicite oblike na razlicitim mestima.</p>'
                . '<h3>Naizmenicni oblici</h3>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((500, 200))\nprozor.fill((240, 240, 240))\n\n# Naizmenicno krugovi i kvadrati\nfor i in range(8):\n    x = 30 + i * 60\n    if i % 2 == 0:\n        pygame.draw.circle(prozor, (200, 50, 50), (x, 100), 22)\n    else:\n        pygame.draw.rect(prozor, (50, 50, 200), (x-20, 80, 40, 40))\n\npygame.display.update()",
                    'i % 2 == 0 proverava da li je i parno. Parni crtaju krug, neparni kvadrat.'
                )
                . '<h3>Primer: Grad</h3>'
                . $this->code(
                    "import pygame\nimport random\n\nprozor = pygame.display.set_mode((500, 350))\nprozor.fill((20, 20, 60))  # nocno nebo\n\n# Zvezde\nfor i in range(50):\n    x = random.randint(0, 500)\n    y = random.randint(0, 150)\n    pygame.draw.circle(prozor, (255, 255, 200), (x, y), 1)\n\n# Zgrade razlicitih visina\nrandom.seed(42)  # isti rezultat svaki put\nfor i in range(10):\n    x = i * 50\n    visina = random.randint(80, 220)\n    boja = (random.randint(60, 120), random.randint(60, 120), random.randint(80, 140))\n    pygame.draw.rect(prozor, boja, (x, 350 - visina, 45, visina))\n\n    # Prozori na zgradama\n    for red in range(visina // 30):\n        for kol in range(2):\n            py = 350 - visina + 10 + red * 30\n            px = x + 8 + kol * 20\n            if random.random() > 0.3:  # 70% prozora je upaljeno\n                pygame.draw.rect(prozor, (255, 255, 150), (px, py, 12, 15))\n            else:\n                pygame.draw.rect(prozor, (50, 50, 80), (px, py, 12, 15))\n\npygame.display.update()",
                    'Nocni grad! random.randint daje slucajne brojeve. Svaki put se generise isti grad jer koristimo seed(42).'
                ),
            'order' => 3,
            'is_assignment' => false,
        ]);

        // 3.4 Domaci
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub3->id,
            'title' => 'Domaci: Petlje u crtanju',
            'content' => '<h2>Domaci: Petlje u crtanju</h2>'
                . '<h3>Zadatak 1: Ograda</h3>'
                . '<p>Nacrtaj ogradu: 10 vertikalnih linija (stubovi) spojenih sa dve horizontalne linije (precke). Koristi for petlju.</p>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((500, 300))\nprozor.fill((135, 206, 235))\n\n# Trava\npygame.draw.rect(prozor, (34, 139, 34), (0, 220, 500, 80))\n\n# Ograda: 10 stubova i dve precke\n# Koristi for petlju!\n\npygame.display.update()",
                    'Nacrtaj ogradu sa 10 stubova pomocu for petlje.'
                )
                . '<h3>Zadatak 2: Piramida od blokova</h3>'
                . '<p>Nacrtaj piramidu: prvi red ima 7 blokova, drugi 5, treci 3, cetvrti 1. Koristi dve ugnjezdene petlje.</p>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((400, 300))\nprozor.fill((200, 200, 200))\n\n# Piramida od blokova (pravougaonika)\n# Red 0: 7 blokova, red 1: 5, red 2: 3, red 3: 1\n\npygame.display.update()",
                    'Koristeci petlje, nacrtaj piramidu od blokova.'
                )
                . '<h3>Zadatak 3: Tvoj obrazac</h3>'
                . '<p>Napravi sopstveni obrazac koristeci petlje! Ideje: koncentricni kvadrati, spirala pravougaonika, sahovska tabla u boji, mozaik...</p>'
                . $this->code(
                    "import pygame\n\nprozor = pygame.display.set_mode((500, 400))\nprozor.fill((255, 255, 255))\n\n# Tvoj obrazac ovde!\n\npygame.display.update()",
                    'Budi kreativan! Koristi petlje, razne boje i oblike.'
                ),
            'order' => 4,
            'is_assignment' => true,
        ]);

        // ============================================================
        // CHAPTER 4: Funkcije za crtanje
        // ============================================================
        $ch4 = Chapter::create(['course_id' => $this->courseId, 'title' => 'Funkcije za crtanje', 'order' => 4]);
        $sub4 = Subchapter::create(['chapter_id' => $ch4->id, 'title' => 'Organizovanje koda', 'order' => 1]);

        // 4.1 Funkcije
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub4->id,
            'title' => 'Pravljenje funkcija za crtanje',
            'content' => '<h2>Pravljenje funkcija za crtanje</h2>'
                . '<p>Kada crtas slozenije crteze, kod postaje dugacak i nepregledan. <strong>Funkcije</strong> nam pomazu da organizujemo kod - napisemo crtez jednom, pa ga pozovemo koliko god puta zelimo.</p>'
                . '<h3>Sta je funkcija?</h3>'
                . '<p>Funkcija je blok koda koji ima ime i moze da primi parametre. Definisemo je sa <code>def</code>:</p>'
                . '<pre><code>def nacrtaj_drvo(prozor, x, y):\n    # kod za crtanje drveta na poziciji (x, y)\n    pygame.draw.rect(prozor, (139, 69, 19), (x-5, y, 10, 30))\n    pygame.draw.circle(prozor, (0, 128, 0), (x, y-10), 20)</code></pre>'
                . '<p>Sada mozemo nacrtati drvo gde god zelimo pozivanjem <code>nacrtaj_drvo(prozor, 100, 200)</code>.</p>'
                . $this->code(
                    "import pygame\n\ndef nacrtaj_drvo(prozor, x, y, velicina=1):\n    # Stablo\n    sw = int(10 * velicina)\n    sh = int(40 * velicina)\n    pygame.draw.rect(prozor, (139, 69, 19), (x - sw//2, y, sw, sh))\n    # Krosnja\n    kr = int(25 * velicina)\n    pygame.draw.circle(prozor, (34, 139, 34), (x, y - kr//2), kr)\n\ndef nacrtaj_oblak(prozor, x, y):\n    pygame.draw.circle(prozor, (255, 255, 255), (x, y), 25)\n    pygame.draw.circle(prozor, (255, 255, 255), (x+25, y-10), 30)\n    pygame.draw.circle(prozor, (255, 255, 255), (x+55, y), 25)\n\nprozor = pygame.display.set_mode((500, 350))\nprozor.fill((135, 206, 235))  # nebo\n\n# Trava\npygame.draw.rect(prozor, (34, 139, 34), (0, 260, 500, 90))\n\n# Crtamo vise drveca pozivom iste funkcije!\nnacrtaj_drvo(prozor, 50, 220)\nnacrtaj_drvo(prozor, 150, 230, 1.3)\nnacrtaj_drvo(prozor, 280, 225, 0.8)\nnacrtaj_drvo(prozor, 400, 220, 1.1)\nnacrtaj_drvo(prozor, 460, 235, 0.6)\n\n# Oblaci\nnacrtaj_oblak(prozor, 80, 60)\nnacrtaj_oblak(prozor, 300, 40)\n\npygame.display.update()",
                    'Definisemo funkciju jednom, a koristimo je koliko zelimo! Parametar velicina menja velicinu drveta.'
                )
                . '<h3>Funkcija sa vise parametara</h3>'
                . $this->code(
                    "import pygame\npygame.font.init()\n\ndef nacrtaj_kucu(prozor, x, y, sirina, visina, boja_zida, boja_krova):\n    # Zidovi\n    pygame.draw.rect(prozor, boja_zida, (x, y, sirina, visina))\n    # Krov (trougao)\n    pygame.draw.polygon(prozor, boja_krova,\n        [(x - 10, y), (x + sirina//2, y - visina//2), (x + sirina + 10, y)])\n    # Vrata\n    vw = sirina // 4\n    vh = visina // 2\n    pygame.draw.rect(prozor, (101, 67, 33), (x + sirina//2 - vw//2, y + visina - vh, vw, vh))\n    # Prozor\n    pw = sirina // 4\n    pygame.draw.rect(prozor, (173, 216, 230), (x + 15, y + 20, pw, pw))\n    pygame.draw.line(prozor, (50,50,50), (x+15, y+20+pw//2), (x+15+pw, y+20+pw//2), 1)\n    pygame.draw.line(prozor, (50,50,50), (x+15+pw//2, y+20), (x+15+pw//2, y+20+pw), 1)\n\nprozor = pygame.display.set_mode((500, 350))\nprozor.fill((135, 206, 235))\npygame.draw.rect(prozor, (34, 139, 34), (0, 260, 500, 90))  # trava\n\nnacrtaj_kucu(prozor, 30, 180, 100, 80, (255, 228, 181), (178, 34, 34))\nnacrtaj_kucu(prozor, 180, 160, 130, 100, (210, 210, 210), (100, 100, 100))\nnacrtaj_kucu(prozor, 370, 190, 90, 70, (255, 200, 200), (139, 69, 19))\n\n# Naslov\nfont = pygame.font.SysFont('Arial', 24)\ntekst = font.render('Moje selo', True, (50, 50, 50))\nprozor.blit(tekst, (190, 10))\n\npygame.display.update()",
                    'Tri razlicite kuce jednom funkcijom! Svaka ima svoju boju i velicinu.'
                ),
            'order' => 1,
            'is_assignment' => false,
        ]);

        // 4.2 Slozeni crteZi
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub4->id,
            'title' => 'Slozeni crtezi sa funkcijama',
            'content' => '<h2>Slozeni crtezi sa funkcijama</h2>'
                . '<p>Sada kada znamo da pravimo funkcije, mozemo praviti veoma slozene crteze koji su i dalje pregledni.</p>'
                . '<h3>Primer: Akvariium</h3>'
                . $this->code(
                    "import pygame\nimport math\npygame.font.init()\n\ndef nacrtaj_ribu(prozor, x, y, velicina, boja):\n    # Telo (elipsa)\n    w = int(60 * velicina)\n    h = int(30 * velicina)\n    pygame.draw.ellipse(prozor, boja, (x, y - h//2, w, h))\n    # Rep (trougao)\n    rw = int(20 * velicina)\n    pygame.draw.polygon(prozor, boja,\n        [(x, y), (x - rw, y - h//2), (x - rw, y + h//2)])\n    # Oko\n    ow = int(5 * velicina)\n    pygame.draw.circle(prozor, (255, 255, 255), (x + w - int(15*velicina), y - int(3*velicina)), ow)\n    pygame.draw.circle(prozor, (0, 0, 0), (x + w - int(13*velicina), y - int(3*velicina)), ow//2)\n\ndef nacrtaj_mehur(prozor, x, y, r):\n    pygame.draw.circle(prozor, (200, 230, 255), (x, y), r, 1)\n\ndef nacrtaj_biljku(prozor, x, y_dno, visina):\n    for i in range(5):\n        offset = int(math.sin(i * 1.5) * 10)\n        pygame.draw.line(prozor, (0, 128, 0),\n            (x + offset, y_dno), (x + offset + 5, y_dno - visina + i*10), 2)\n\nSIRINA, VISINA = 500, 350\nprozor = pygame.display.set_mode((SIRINA, VISINA))\n\n# Pozadina vode\nprozor.fill((0, 80, 140))\n\n# Pesak na dnu\npygame.draw.rect(prozor, (194, 178, 128), (0, 300, SIRINA, 50))\n\n# Biljke\nnacrtaj_biljku(prozor, 50, 300, 80)\nnacrtaj_biljku(prozor, 420, 300, 100)\nnacrtaj_biljku(prozor, 230, 300, 60)\n\n# Ribe\nnacrtaj_ribu(prozor, 80, 120, 1.0, (255, 100, 0))\nnacrtaj_ribu(prozor, 250, 200, 0.7, (255, 50, 100))\nnacrtaj_ribu(prozor, 350, 100, 1.2, (255, 215, 0))\nnacrtaj_ribu(prozor, 150, 260, 0.5, (100, 200, 255))\n\n# Mehurici\nfor i in range(12):\n    import random\n    nacrtaj_mehur(prozor, random.randint(20, 480), random.randint(30, 290), random.randint(3, 8))\n\n# Naslov\nfont = pygame.font.SysFont('Arial', 20)\ntekst = font.render('Moj akvarijum', True, (200, 230, 255))\nprozor.blit(tekst, (180, 10))\n\npygame.display.update()",
                    'Akvarijum sa ribama, biljkama i mehurima! Svaka riba je nacrtana jednim pozivom funkcije.'
                ),
            'order' => 2,
            'is_assignment' => false,
        ]);

        // 4.3 Pregled svih komandi
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub4->id,
            'title' => 'Pregled svih Pygame komandi',
            'content' => '<h2>Pregled svih Pygame komandi</h2>'
                . '<p>Evo kompletnog pregleda svega sto smo naucili u Pygame kursu.</p>'
                . '<h3>Osnovno</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Komanda</th><th>Sta radi</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>import pygame</code></td><td>Uvozi biblioteku</td><td>Uvek na pocetku</td></tr>'
                . '<tr><td><code>pygame.display.set_mode((w,h))</code></td><td>Pravi prozor</td><td><code>pygame.display.set_mode((400,300))</code></td></tr>'
                . '<tr><td><code>prozor.fill((R,G,B))</code></td><td>Boji pozadinu</td><td><code>prozor.fill((255,255,255))</code></td></tr>'
                . '<tr><td><code>pygame.display.update()</code></td><td>Prikazuje crtez</td><td>Uvek na kraju</td></tr>'
                . '</tbody></table>'
                . '<h3>Crtanje oblika</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Komanda</th><th>Sta crta</th><th>Kljucni parametri</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>pygame.draw.line(p, boja, (x1,y1), (x2,y2), deb)</code></td><td>Liniju</td><td>Pocetna tacka, krajnja tacka</td></tr>'
                . '<tr><td><code>pygame.draw.rect(p, boja, (x,y,w,h), deb)</code></td><td>Pravougaonik</td><td>Pozicija, dimenzije (deb=0: popunjen)</td></tr>'
                . '<tr><td><code>pygame.draw.circle(p, boja, (cx,cy), r, deb)</code></td><td>Krug</td><td>Centar, poluprecnik (deb=0: popunjen)</td></tr>'
                . '<tr><td><code>pygame.draw.ellipse(p, boja, (x,y,w,h), deb)</code></td><td>Elipsu</td><td>Pravougaonik u koji se upisuje</td></tr>'
                . '<tr><td><code>pygame.draw.polygon(p, boja, [(x,y),...], deb)</code></td><td>Poligon</td><td>Lista tacaka (3=trougao, 5=petougao...)</td></tr>'
                . '</tbody></table>'
                . '<h3>Tekst</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Komanda</th><th>Sta radi</th></tr></thead>'
                . '<tbody>'
                . '<tr><td><code>pygame.font.init()</code></td><td>Inicijalizuje font sistem</td></tr>'
                . '<tr><td><code>pygame.font.SysFont(ime, vel)</code></td><td>Pravi font</td></tr>'
                . '<tr><td><code>font.render(tekst, True, boja)</code></td><td>Pretvara tekst u sliku</td></tr>'
                . '<tr><td><code>prozor.blit(slika, (x,y))</code></td><td>Crta sliku na prozor</td></tr>'
                . '</tbody></table>'
                . '<h3>Korisni trikovi</h3>'
                . '<table border="1" cellpadding="8" cellspacing="0">'
                . '<thead><tr><th>Trik</th><th>Objasnjenje</th><th>Primer</th></tr></thead>'
                . '<tbody>'
                . '<tr><td>Centar prozora</td><td>cx = sirina // 2</td><td><code>cx = 400 // 2  # 200</code></td></tr>'
                . '<tr><td>Debljina 0</td><td>Popunjen oblik</td><td><code>pygame.draw.circle(p, boja, (x,y), r)</code></td></tr>'
                . '<tr><td>Debljina > 0</td><td>Samo okvir</td><td><code>pygame.draw.circle(p, boja, (x,y), r, 3)</code></td></tr>'
                . '<tr><td>Boja = (R,G,B)</td><td>Svako 0-255</td><td><code>(255, 0, 0)</code> = crvena</td></tr>'
                . '<tr><td>Petlja za crtanje</td><td>Ponavlja oblike</td><td><code>for i in range(10):</code></td></tr>'
                . '<tr><td>Funkcija</td><td>Slozen oblik</td><td><code>def nacrtaj_drvo(p, x, y):</code></td></tr>'
                . '</tbody></table>',
            'order' => 3,
            'is_assignment' => false,
        ]);

        // 4.4 Zavrsni projekat
        Lesson::create([
            'course_id' => $this->courseId,
            'subchapter_id' => $sub4->id,
            'title' => 'Zavrsni projekat: Moja slika',
            'content' => '<h2>Zavrsni projekat: Moja slika</h2>'
                . '<p>Vreme je da napravis svoju veliku sliku! Koristi <strong>sve sto si naucio</strong>: oblike, boje, petlje, funkcije i tekst.</p>'
                . '<h3>Zahtevi</h3>'
                . '<ul>'
                . '<li>Minimum 5 razlicitih oblika (linija, pravougaonik, krug, elipsa, poligon)</li>'
                . '<li>Bar jedna for petlja</li>'
                . '<li>Bar jedna funkcija koju definises sam</li>'
                . '<li>Tekst (naslov ili potpis)</li>'
                . '<li>Minimum 5 razlicitih boja</li>'
                . '</ul>'
                . '<h3>Ideje za temu</h3>'
                . '<ol>'
                . '<li><strong>Pejzaz</strong> - planine, reka, drvo, sunce, oblaci</li>'
                . '<li><strong>Svemirska scena</strong> - planete, zvezde, svemirski brod</li>'
                . '<li><strong>Podvodni svet</strong> - ribe, korali, morsko dno</li>'
                . '<li><strong>Grad noci</strong> - zgrade, svetla, mesec</li>'
                . '<li><strong>Tvoja soba</strong> - sto, racunar, polica sa knjigama</li>'
                . '</ol>'
                . $this->code(
                    "import pygame\nimport math\npygame.font.init()\n\nprozor = pygame.display.set_mode((600, 450))\nprozor.fill((255, 255, 255))\n\n# Tvoj zavrsni projekat!\n# Definisi funkcije za ponavljajuce elemente:\n\n# def nacrtaj_nesto(prozor, x, y):\n#     ...\n\n# Nacrtaj pozadinu:\n\n# Koristi petlje za ponavljanje:\n# for i in range(...):\n#     ...\n\n# Dodaj tekst (naslov i potpis):\n\npygame.display.update()",
                    'Napravi svoju jedinstvenu sliku! Koristi sve sto si naucio: oblike, petlje, funkcije i tekst.'
                ),
            'order' => 4,
            'is_assignment' => true,
        ]);

        echo "Pygame kurs uspesno kreiran! 4 poglavlja, 12 lekcija (3 domaca + 1 zavrsni projekat).\n";
    }
}
