<?php
// =============================================
// ajax_oracol.php — endpoint Ajax
// Primește o întrebare și returnează un răspuns
// tematic despre Imperiul Roman
// =============================================

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'eroare' => 'Metodă nepermisă.']);
    exit;
}

$intrebare = trim(htmlspecialchars($_POST['intrebare'] ?? ''));

if (empty($intrebare)) {
    echo json_encode(['success' => false, 'eroare' => 'Întrebarea nu poate fi goală.']);
    exit;
}
if (strlen($intrebare) < 5) {
    echo json_encode(['success' => false, 'eroare' => 'Întrebarea este prea scurtă (minim 5 caractere).']);
    exit;
}

// =============================================
// Baza de cunoștințe — cuvinte cheie → răspuns
// =============================================
$raspunsuri = [
    [
        'cuvinte' => ['augustus', 'octavian', 'primul împărat', 'fondare', 'fondat', 'pax romana'],
        'icon' => '👑', 'titlu' => 'Augustus — Primul Împărat',
        'raspuns' => 'Gaius Octavius, cunoscut ca Augustus, a primit titlul de "Augustus" din partea Senatului în 27 î.Hr., devenind primul împărat roman. A transformat Roma dintr-un oraș de cărămidă într-unul de marmură și a instaurat Pax Romana — 200 de ani de relativă pace și prosperitate.',
        'citat' => '"Am găsit Roma din cărămidă și am lăsat-o din marmură." — Augustus'
    ],
    [
        'cuvinte' => ['caesar', 'cezar', 'iulius', 'asasinat', 'idele', 'brutus', 'rubicon'],
        'icon' => '🗡️', 'titlu' => 'Iulius Caesar',
        'raspuns' => 'Iulius Caesar a fost asasinat pe 15 martie 44 î.Hr. — Idele lui Marte — de un grup de senatori conduși de Brutus și Cassius. Deși nu a fost oficial împărat, el a deschis calea spre imperiu. A cucerit Galia, a traversat Rubiconul și a instaurat o dictatură care a schimbat Roma pentru totdeauna.',
        'citat' => '"Alea iacta est." (Zarurile au fost aruncate) — Caesar la traversarea Rubiconului'
    ],
    [
        'cuvinte' => ['traian', 'dacia', 'dacii', 'români', 'românia', 'columna', 'cucerire', 'decebal'],
        'icon' => '⚔️', 'titlu' => 'Traian și Dacia',
        'raspuns' => 'Împăratul Traian (98–117 d.Hr.) a cucerit Dacia în două campanii militare (101–102 și 105–106 d.Hr.). Dacia a devenit provincia romană Dacia Felix, bogată în aur și argint. Columna lui Traian din Roma, înaltă de 30m, istorisește aceste cuceriri în 155 de scene sculptate. Românii de azi sunt urmașii acestei fuziuni daco-romane.',
        'citat' => '"Optimus Princeps" — titlul dat lui Traian de Senat'
    ],
    [
        'cuvinte' => ['marcus aurelius', 'marcus', 'filosof', 'meditații', 'stoic', 'stoicism', 'filosofie'],
        'icon' => '📚', 'titlu' => 'Marcus Aurelius — Filosoful',
        'raspuns' => 'Marcus Aurelius (161–180 d.Hr.) este cunoscut ca "împăratul filosof". A scris Meditațiile — un jurnal personal de filosofie stoică — în timp ce conducea imperiul și purta războaie la frontieră. Este considerat unul dintre cei mai mari stoici din istorie și unul dintre cei mai buni împărați romani.',
        'citat' => '"Ai putere asupra minții tale, nu asupra evenimentelor exterioare." — Marcus Aurelius'
    ],
    [
        'cuvinte' => ['colosseum', 'coliseum', 'amfiteatru', 'gladiatori', 'gladiator', 'spectacol', 'lupte', 'arena'],
        'icon' => '🏟️', 'titlu' => 'Colosseumul',
        'raspuns' => 'Colosseumul (Amfiteatrul Flavian) a fost construit între 70–80 d.Hr. sub împărații Vespasian și Titus. Putea găzdui 50.000–80.000 de spectatori, avea 80 de intrări, un sistem de umbre (velarium) și chiar putea fi inundat pentru lupte navale. Gladiatorii, animalele exotice și execuțiile publice erau principalele atracții.',
        'citat' => '"Panem et Circenses" — Pâine și Circ — formula politică romană'
    ],
    [
        'cuvinte' => ['cădere', 'sfarsit', 'disparut', '476', 'barbari', 'invazii', 'de ce', 'cazut', 'odoacru', 'romulus augustulus'],
        'icon' => '💀', 'titlu' => 'Căderea Imperiului',
        'raspuns' => 'Imperiul Roman de Apus a căzut în 476 d.Hr. când Romulus Augustulus a fost detronat de Odoacru. Cauzele principale au fost: invaziile barbare necontenite (vizigoți, huni, vandali), criza economică severă, instabilitatea politică extremă (50+ împărați în 50 de ani) și epidemii devastatoare care au decimat armata.',
        'citat' => '"Imperiile nu sunt ucise — ele se sinucid." — Arnold Toynbee'
    ],
    [
        'cuvinte' => ['lege', 'drept', 'juridic', 'justitie', 'tribunal', 'senat', 'republic', 'republica'],
        'icon' => '⚖️', 'titlu' => 'Dreptul și Republica Romană',
        'raspuns' => 'Dreptul roman stă la baza sistemelor juridice din peste 150 de țări moderne, inclusiv România. Concepte ca "prezumția de nevinovăție" sau "habeas corpus" vin din Roma. Republica Romană (509–27 î.Hr.) a creat primul sistem de guvernare reprezentativă din lume, cu doi consuli aleși anual și un Senat.',
        'citat' => '"Legile sunt create pentru oameni, nu oamenii pentru legi." — Cicero'
    ],
    [
        'cuvinte' => ['drum', 'drumuri', 'via appia', 'infrastructura', 'apeduct', 'apeducte', 'inginerie'],
        'icon' => '🛤️', 'titlu' => 'Drumuri și Apeducte',
        'raspuns' => 'Romanii au construit peste 400.000 km de drumuri — de la Hadria până în Mesopotamia. Via Appia, construită în 312 î.Hr., este primul drum roman major. Expresia "Toate drumurile duc la Roma" vine de la piatra miliară aurie din Forul Roman. Roma primea 1 milion de litri de apă zilnic prin 11 apeducte.',
        'citat' => '"Toate drumurile duc la Roma." — proverb latin'
    ],
    [
        'cuvinte' => ['constantin', 'crestinism', 'crestin', 'religie', 'edict', 'milano', 'biseric', 'zei', 'jupiter', 'panteon'],
        'icon' => '✝️', 'titlu' => 'Religia în Imperiul Roman',
        'raspuns' => 'Romanii erau politeisti, adorând un panteon vast de zei (Jupiter, Marte, Venus, Neptun, etc.). În 313 d.Hr., Constantin cel Mare a emis Edictul de la Milano, legalizând creștinismul. Ulterior, în 380 d.Hr., Teodosie I a proclamat creștinismul religie oficială a imperiului.',
        'citat' => '"In hoc signo vinces." (Prin acest semn vei învinge) — viziunea lui Constantin'
    ],
    [
        'cuvinte' => ['hadrian', 'zid', 'britannia', 'anglia', 'pantheon', 'constructor'],
        'icon' => '🏛️', 'titlu' => 'Hadrian — Marele Constructor',
        'raspuns' => 'Hadrian (117–138 d.Hr.) a ridicat Zidul lui Hadrian în Britannia (117 km lungime) pentru a apăra imperiul de triburile nordice. A reconstruit Pantheonul din Roma — cupola sa de 43m rămânând un record de inginerie timp de 1.300 de ani.',
        'citat' => '"Animula vagula blandula..." — ultimele versuri scrise de Hadrian pe patul morții'
    ],
    [
        'cuvinte' => ['latina', 'limba', 'romana', 'italiana', 'franceza', 'spaniola', 'romanice', 'alfabet'],
        'icon' => '🗣️', 'titlu' => 'Moștenirea Limbii Latine',
        'raspuns' => 'Din latina vulgară s-au dezvoltat 6 limbi romanice majore: română, italiană, spaniolă, franceză, portugheză și catalană — vorbite azi de peste 900 de milioane de oameni. Alfabetul latin pe care îl folosim astăzi în toată lumea occidentală a fost creat de romani, adaptând alfabetul etrusc și grecesc.',
        'citat' => '"Latina nu e o limbă moartă — e mama a sute de milioane de cuvinte vii."'
    ],
    [
        'cuvinte' => ['nero', 'caligula', 'comodus', 'tiran', 'nebun'],
        'icon' => '🔥', 'titlu' => 'Împărații Tirani',
        'raspuns' => 'Printre cei mai infami împărați romani se numără Nero (54–68 d.Hr.), acuzat că a dat foc Romei; Caligula (37–41 d.Hr.), cunoscut pentru cruzime și demenție; și Commodus (180–192 d.Hr.), care credea că este reîncarnarea lui Hercule. Toți trei au fost asasinați de propria gardă sau conspiratori.',
        'citat' => '"Puterea absolută corupe absolut." — Lord Acton'
    ],
    [
        'cuvinte' => ['spartacus', 'spartak', 'sclav', 'sclavi', 'sclavie', 'rebeliune', 'revolta'],
        'icon' => '⛓️', 'titlu' => 'Spartacus și Revolta Sclavilor',
        'raspuns' => 'Spartacus a fost un sclav trac și gladiator care a condus cea mai mare rebeliune de sclavi din istoria Romei (73–71 î.Hr.). A adunat o armată de 120.000 de sclavi și a înfrânt mai multe legiuni romane. A fost înfrânt în final de Crassus; 6.000 de sclavi au fost crucificați de-a lungul Via Appia ca avertisment.',
        'citat' => '"Prefer să mor ca om liber decât să trăiesc ca sclav." — Spartacus'
    ],
    [
        'cuvinte' => ['pompei', 'vezuviu', 'vulcan', 'eruptie', 'herculaneum'],
        'icon' => '🌋', 'titlu' => 'Pompei și Vezuviul',
        'raspuns' => 'Pe 24 august 79 d.Hr., Muntele Vezuviu a erupt catastrofal, îngropând orașele Pompei și Herculaneum sub cenușă și lavă. Aproximativ 2.000 de oameni au murit. Paradoxal, această tragedie a conservat perfect viața romană a secolului I — Pompei rămânând cel mai bun "muzeu" al culturii romane.',
        'citat' => '"Cei morți de la Pompei ne-au lăsat cea mai vie imagine a lumii antice." — Plinius cel Tânăr'
    ],
    [
        'cuvinte' => ['legiune', 'legionar', 'armata', 'razboi', 'soldat', 'militar', 'centurion'],
        'icon' => '🛡️', 'titlu' => 'Armata Romană',
        'raspuns' => 'Armata romană era cea mai eficientă mașinărie de război din antichitate. O legiune număra ~5.000 de soldați, organizați în cohorte și centurii. Soldații se antrenau constant, construiau drumuri și castre. Serviciul militar dura 25 de ani, după care veteranii primeau pământ sau bani — o politică ce a asigurat loialitatea armatei.',
        'citat' => '"Si vis pacem, para bellum." (Dacă vrei pace, pregătește-te de război) — Vegetius'
    ],
];

// Răspuns generic
$raspunsGeneric = [
    'icon' => '🏛️', 'titlu' => 'Oracolul Consultă Arhivele Romane...',
    'raspuns' => 'Întrebarea ta atinge un subiect vast din istoria Imperiului Roman. Imperiul a durat peste 500 de ani (27 î.Hr. – 476 d.Hr.), acoperind 5 milioane km² pe trei continente, cu o populație de 50–70 milioane de oameni. Moștenirea sa — dreptul, limba latină, arhitectura, calendarul — trăiește și astăzi în civilizația occidentală. Încearcă să întrebi despre un împărat, un monument sau un eveniment specific!',
    'citat' => '"Roma nu a fost construită într-o zi." — proverb latin'
];

// =============================================
// Caută cel mai bun răspuns bazat pe cuvinte cheie
// =============================================
$intrebareLower = mb_strtolower($intrebare, 'UTF-8');
$raspunsGasit   = null;
$maxCuvinte     = 0;

foreach ($raspunsuri as $r) {
    $count = 0;
    foreach ($r['cuvinte'] as $cuvant) {
        if (mb_strpos($intrebareLower, $cuvant, 0, 'UTF-8') !== false) {
            $count++;
        }
    }
    if ($count > $maxCuvinte) {
        $maxCuvinte   = $count;
        $raspunsGasit = $r;
    }
}

if (!$raspunsGasit || $maxCuvinte === 0) {
    $raspunsGasit = $raspunsGeneric;
}

// Salvare întrebare în log
$dir = __DIR__ . '/mesaje';
if (!is_dir($dir)) mkdir($dir, 0755, true);
$linie = '[' . date('d.m.Y H:i:s') . '] Oracol: ' . $intrebare . PHP_EOL;
file_put_contents($dir . '/oracol_log.txt', $linie, FILE_APPEND | LOCK_EX);

// Simulare timp de procesare (efect dramatic)
usleep(600000); // 0.6 secunde

echo json_encode([
    'success'   => true,
    'icon'      => $raspunsGasit['icon'],
    'titlu'     => $raspunsGasit['titlu'],
    'raspuns'   => $raspunsGasit['raspuns'],
    'citat'     => $raspunsGasit['citat'],
    'intrebare' => $intrebare,
], JSON_UNESCAPED_UNICODE);
exit;
