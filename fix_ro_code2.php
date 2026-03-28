<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Lesson;

$lessons = Lesson::where('course_id', 9)->get();

$replacements = [
    // Lesson 38 - print examples
    "Ovo je sa jednostrukim navodnicima" => "Acesta este cu ghilimele simple",
    "Ovo je sa dvostrukim navodnicima" => "Acesta este cu ghilimele duble",
    "Ovo je moj prvi program sa vise linija" => "Acesta este primul meu program cu mai multe linii",
    "Ovo je" => "Acesta este",
    "navodnicima" => "ghilimele",
    "navodnici" => "ghilimele",
    "jednostrukim" => "simple",
    "dvostrukim" => "duble",
    "'Ja sam kompjuter.'" => "'Eu sunt un calculator.'",
    "'Ja sam'" => "'Eu sunt'",
    "Ja sam" => "Eu sunt",
    "kompjuter" => "calculator",
    "'moj prvi'" => "'primul meu'",
    "moj prvi" => "primul meu",
    "vise linija" => "mai multe linii",

    // Common verbs/phrases in code
    "'imam '" => "'am '",
    "' imam '" => "' am '",
    "imam " => "am ",
    "Imam " => "Am ",
    "'imas'" => "'ai'",
    " imas " => " ai ",
    "mozes" => "poti",
    "nece" => "nu va",
    "radi" => "functioneaza",

    // Lesson 38 - more
    "omiljeni" => "preferat",
    "predmet" => "materie",

    // Lesson 41 - operators in text
    "sabiranje" => "adunare",
    "oduzimanje" => "scadere",
    "mnozenje" => "inmultire",
    "deljenje" => "impartire",
    "ostatak" => "rest",
    "stepenovanje" => "ridicare la putere",
    "Celobrojno" => "Impartire intreaga",
    "celobrojno" => "impartire intreaga",

    // Lesson 42
    "greska" => "eroare",
    "visok" => "inalt",
    "tezak" => "greu",

    // Lesson 46 - weather/grades
    "'Ponesi jaknu!'" => "'Ia geaca!'",
    "'Ponesi kisobran!'" => "'Ia umbrela!'",
    "'Mozes samo u majici!'" => "'Poti doar in tricou!'",
    "Ponesi jaknu" => "Ia geaca",
    "Ponesi kisobran" => "Ia umbrela",
    "ponesi" => "ia",
    "jaknu" => "geaca",
    "kisobran" => "umbrela",
    "majici" => "tricou",
    "'Odlican!'" => "'Excelent!'",
    "Odlican" => "Excelent",
    "'Vrlo dobar'" => "'Foarte bine'",
    "Vrlo dobar" => "Foarte bine",
    "'Dobar'" => "'Bine'",
    "'Dovoljan'" => "'Suficient'",
    "Dovoljan" => "Suficient",
    "'Nedovoljan'" => "'Insuficient'",
    "Nedovoljan" => "Insuficient",
    "uci vise" => "invata mai mult",

    // Lesson 44
    "Volim da igram" => "Imi place sa joc",

    // Lesson 48
    "Nisi pogodio" => "Nu ai ghicit",
    "Broj je bio" => "Numarul a fost",

    // Variables in code
    "Ucim da programiram u Python-u" => "Invat sa programez in Python",
    "programiram" => "programez",
    "'Koliko si visok/visoka u metrima'" => "'Cat esti de inalt in metri'",
    "'Koliko kilograma'" => "'Cate kilograme'",
    "drugaric" => "prieten",
    "najvise" => "cel mai mult",
    "najmanje" => "cel mai putin",
    "treba da" => "trebuie sa",
    "sta hoces" => "ce vrei",
    "Sta je" => "Ce este",
    "Kako se" => "Cum se",
    "Koji je tvoj" => "Care este al tau",
];

// Sort by length descending
uksort($replacements, function($a, $b) {
    return strlen($b) - strlen($a);
});

foreach ($lessons as $lesson) {
    $content = $lesson->content;
    $changed = false;

    foreach ($replacements as $sr => $ro) {
        if (strpos($content, $sr) !== false) {
            $content = str_replace($sr, $ro, $content);
            $changed = true;
        }
    }

    if ($changed) {
        $lesson->content = $content;
        $lesson->save();
        echo "Fixed lesson {$lesson->id} - {$lesson->title}\n";
    }
}

echo "\nDone!\n";
