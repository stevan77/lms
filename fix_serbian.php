<?php

/**
 * Fix Serbian characters (š, č, ć, ž, đ) in course_id=8 content.
 *
 * Run: php fix_serbian.php
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$courseId = 8;

// ── Replacement map ──────────────────────────────────────────────────
// Longer strings FIRST to avoid partial matches.
$replacements = [
    // ---- multi-syllable / longer words first ----
    'koristeci'   => 'koristeći',
    'mogucnosti'  => 'mogućnosti',
    'zamisljeni'  => 'zamišljeni',
    'Matematicki'  => 'Matematički',
    'matematicki'  => 'matematički',
    'Odlucivanje' => 'Odlučivanje',
    'odlucivanje' => 'odlučivanje',
    'pocetnike'   => 'početnike',
    'Pocetnike'   => 'Početnike',
    'pocetku'     => 'početku',
    'Pocetku'     => 'Početku',
    'pocinje'     => 'počinje',
    'Pocinje'     => 'Počinje',
    'Pocnite'     => 'Počnite',
    'pocnite'     => 'počnite',
    'pocne'       => 'počne',
    'poredjenje'  => 'poređenje',
    'Poredjenje'  => 'Poređenje',
    'poredjenjem' => 'poređenjem',
    'izmedju'     => 'između',
    'Izmedju'     => 'Između',
    'stavljas'    => 'stavljaš',
    'prosao'      => 'prošao',
    'Prosao'      => 'Prošao',
    'koristis'    => 'koristiš',
    'izracunas'   => 'izračunaš',
    'uradis'      => 'uradiš',
    'pricas'      => 'pričaš',
    'razlicite'   => 'različite',
    'razlicito'   => 'različito',
    'Razlicite'   => 'Različite',
    'odredjeni'   => 'određeni',
    'odredjen'    => 'određen',
    'odredjuje'   => 'određuje',
    'Odredjuje'   => 'Određuje',
    'pronadjes'   => 'pronađeš',
    'Pronadjes'   => 'Pronađeš',
    'racunanje'   => 'računanje',
    'Racunanje'   => 'Računanje',
    'racunamo'    => 'računamo',
    'racunas'     => 'računaš',
    'racuna'      => 'računa',
    'Racuna'      => 'Računa',
    'znacenje'    => 'značenje',
    'Znacenje'    => 'Značenje',
    'ispisemo'    => 'ispišemo',
    'napisemo'    => 'napišemo',
    'napises'     => 'napišeš',
    'Pogresna'    => 'Pogrešna',
    'pogresno'    => 'pogrešno',
    'Pogresno'    => 'Pogrešno',
    'pokusaja'    => 'pokušaja',
    'pokusaj'     => 'pokušaj',
    'Pokusaj'     => 'Pokušaj',
    'sacuvaj'     => 'sačuvaj',
    'Sacuvaj'     => 'Sačuvaj',
    'sacuva'      => 'sačuva',
    'sacekaj'     => 'sačekaj',
    'Sacekaj'     => 'Sačekaj',
    'saljemo'     => 'šaljemo',
    'Saljemo'     => 'Šaljemo',
    'saljes'      => 'šalješ',
    'salje'       => 'šalje',
    'Salje'       => 'Šalje',
    'naucili'     => 'naučili',
    'nauciti'     => 'naučiti',
    'naucis'      => 'naučiš',
    'naucimo'     => 'naučimo',
    'Nauciti'     => 'Naučiti',
    'Naucimo'     => 'Naučimo',
    'ucenike'     => 'učenike',
    'ucimo'       => 'učimo',
    'uciti'       => 'učiti',
    'Uciti'       => 'Učiti',
    'obuciti'     => 'obući',
    'ukljuci'     => 'uključi',
    'Ukljuci'     => 'Uključi',
    'sledece'     => 'sledeće',
    'Sledece'     => 'Sledeće',
    'cetvrti'     => 'četvrti',
    'Cetvrti'     => 'Četvrti',
    'cuvaju'      => 'čuvaju',
    'cuvamo'      => 'čuvamo',
    'cuva'        => 'čuva',
    'Cuva'        => 'Čuva',
    'frizider'    => 'frižider',
    'Frizider'    => 'Frižider',
    'greska'      => 'greška',
    'Greska'      => 'Greška',
    'greske'      => 'greške',
    'Greske'      => 'Greške',
    'gresci'      => 'grešci',
    'promenis'    => 'promeniš',
    'sabiras'     => 'sabiraš',
    'saberes'     => 'sabereš',
    'takodje'     => 'takođe',
    'Takodje'     => 'Takođe',
    'zelimo'      => 'želimo',
    'Zelimo'      => 'Želimo',
    'zelis'       => 'želiš',
    'Zelis'       => 'Želiš',
    'zeli'        => 'želi',
    'Zeli'        => 'Želi',
    'zenski'      => 'ženski',
    'Zenski'      => 'Ženski',
    'sirina'      => 'širina',
    'Sirina'      => 'Širina',
    'menjas'      => 'menjaš',
    'dodjes'      => 'dođeš',
    'Dodjes'      => 'Dođeš',
    'ukucas'      => 'ukucaš',
    'Ispisi'      => 'Ispiši',
    'ispisi'      => 'ispiši',
    'Napisi'      => 'Napiši',
    'napisi'      => 'napiši',
    'zoves'       => 'zoveš',
    'mozes'       => 'možeš',
    'Mozes'       => 'Možeš',
    'moze'        => 'može',
    'Moze'        => 'Može',
    'kazes'       => 'kažeš',
    'Kazes'       => 'Kažeš',
    'znaci'       => 'znači',
    'Znaci'       => 'Znači',
    'dodas'       => 'dodaš',
    'Dodas'       => 'Dodaš',
    'neces'       => 'nećeš',
    'Neces'       => 'Nećeš',
    'vise'        => 'više',
    'Vise'        => 'Više',
    'VISE'        => 'VIŠE',
    'pises'       => 'pišeš',
    'Pises'       => 'Pišeš',
    'pise'        => 'piše',
    'Pise'        => 'Piše',
    'vrsi'        => 'vrši',
    'Vrsi'        => 'Vrši',
    'vraca'       => 'vraća',
    'Vraca'       => 'Vraća',
    'nece'        => 'neće',
    'Nece'        => 'Neće',
    'reci'        => 'reći',
    'Reci'        => 'Reći',
    'naci'        => 'naći',
    'Naci'        => 'Naći',
    'licnu'       => 'ličnu',
    'licna'       => 'lična',
    'Licna'       => 'Lična',
    'tacno'       => 'tačno',
    'Tacno'       => 'Tačno',
    'tacna'       => 'tačna',
    'Tacna'       => 'Tačna',
    'vezbi'       => 'vežbi',
    'Vezbi'       => 'Vežbi',
    'imas'        => 'imaš',
    'Imas'        => 'Imaš',
    'znas'        => 'znaš',
    'Znas'        => 'Znaš',
    'resis'       => 'rešiš',
    'resenje'     => 'rešenje',
    'Resenje'     => 'Rešenje',
    'cas'         => 'čas',
    'Cas'         => 'Čas',
    'cita'        => 'čita',
    'Cita'        => 'Čita',
    'cestka'      => 'česta',
    'Zasto'       => 'Zašto',
    'zasto'       => 'zašto',
];

// "Sta " and "sto " need special handling (very short, could match parts of words)
// We'll handle them with word-boundary aware regex
$regexReplacements = [
    '/\bSta\b/'   => 'Šta',
    '/\bsta\b/'   => 'šta',
    '/\bsto\b/'   => 'što',
    '/\buci\b/'   => 'uči',
    '/\bces\b/'   => 'ćeš',
];

/**
 * Apply all replacements to a string.
 */
function fixSerbian(string $text, array $replacements, array $regexReplacements): string
{
    // First pass: direct str_replace (longer keys first - already ordered above)
    $text = str_replace(array_keys($replacements), array_values($replacements), $text);

    // Second pass: regex-based for short words needing word boundaries
    foreach ($regexReplacements as $pattern => $replacement) {
        $text = preg_replace($pattern . 'u', $replacement, $text);
    }

    return $text;
}

// ── Counters ─────────────────────────────────────────────────────────
$stats = ['chapters' => 0, 'subchapters' => 0, 'lesson_titles' => 0, 'lesson_content' => 0];

echo "=== Fixing Serbian characters for course_id={$courseId} ===\n\n";

// ── 1. Course name ──────────────────────────────────────────────────
$course = DB::table('courses')->where('id', $courseId)->first();
if ($course) {
    $newName = fixSerbian($course->name ?? $course->title ?? '', $replacements, $regexReplacements);
    $field = property_exists($course, 'name') ? 'name' : 'title';
    $oldName = $course->$field;
    if ($newName !== $oldName) {
        DB::table('courses')->where('id', $courseId)->update([$field => $newName]);
        echo "[COURSE] \"{$oldName}\" → \"{$newName}\"\n";
    } else {
        echo "[COURSE] \"{$oldName}\" — no change needed\n";
    }
}

// ── 2. Chapters ─────────────────────────────────────────────────────
echo "\n--- Chapters ---\n";
$chapters = DB::table('chapters')->where('course_id', $courseId)->orderBy('order')->get();
foreach ($chapters as $ch) {
    $newTitle = fixSerbian($ch->title, $replacements, $regexReplacements);
    if ($newTitle !== $ch->title) {
        DB::table('chapters')->where('id', $ch->id)->update(['title' => $newTitle]);
        echo "[CH {$ch->id}] \"{$ch->title}\" → \"{$newTitle}\"\n";
        $stats['chapters']++;
    } else {
        echo "[CH {$ch->id}] \"{$ch->title}\" — no change\n";
    }
}

// ── 3. Subchapters ──────────────────────────────────────────────────
echo "\n--- Subchapters ---\n";
$chapterIds = $chapters->pluck('id')->toArray();
if ($chapterIds) {
    $subchapters = DB::table('subchapters')->whereIn('chapter_id', $chapterIds)->orderBy('chapter_id')->orderBy('order')->get();
    foreach ($subchapters as $sc) {
        $newTitle = fixSerbian($sc->title, $replacements, $regexReplacements);
        if ($newTitle !== $sc->title) {
            DB::table('subchapters')->where('id', $sc->id)->update(['title' => $newTitle]);
            echo "[SC {$sc->id}] \"{$sc->title}\" → \"{$newTitle}\"\n";
            $stats['subchapters']++;
        } else {
            echo "[SC {$sc->id}] \"{$sc->title}\" — no change\n";
        }
    }
}

// ── 4. Lessons (title + content) ────────────────────────────────────
echo "\n--- Lessons ---\n";
$lessons = DB::table('lessons')->where('course_id', $courseId)->orderBy('order')->get();
foreach ($lessons as $lesson) {
    $newTitle = fixSerbian($lesson->title, $replacements, $regexReplacements);
    $newContent = $lesson->content ? fixSerbian($lesson->content, $replacements, $regexReplacements) : $lesson->content;

    $updates = [];
    if ($newTitle !== $lesson->title) {
        $updates['title'] = $newTitle;
        echo "[LESSON {$lesson->id} TITLE] \"{$lesson->title}\" → \"{$newTitle}\"\n";
        $stats['lesson_titles']++;
    }
    if ($newContent !== $lesson->content) {
        $updates['content'] = $newContent;
        // Show a short preview of content changes
        $oldSnippet = mb_substr(strip_tags($lesson->content), 0, 80);
        $newSnippet = mb_substr(strip_tags($newContent), 0, 80);
        echo "[LESSON {$lesson->id} CONTENT] changed (preview: \"{$oldSnippet}...\" → \"{$newSnippet}...\")\n";
        $stats['lesson_content']++;
    }
    if (empty($updates)) {
        echo "[LESSON {$lesson->id}] \"{$lesson->title}\" — no change\n";
    } else {
        DB::table('lessons')->where('id', $lesson->id)->update($updates);
    }
}

// ── Summary ──────────────────────────────────────────────────────────
echo "\n=== Done ===\n";
echo "Chapters updated:       {$stats['chapters']}\n";
echo "Subchapters updated:    {$stats['subchapters']}\n";
echo "Lesson titles updated:  {$stats['lesson_titles']}\n";
echo "Lesson content updated: {$stats['lesson_content']}\n";
