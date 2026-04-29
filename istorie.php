<?php
$currentPage = 'istorie';
include 'includes/header.php';

// Date timeline definite în PHP
$timelineEvents = [
    ['year' => '753 î.Hr.', 'title' => 'Fondarea Romei',          'short' => 'Romulus și Remus',       'icon' => '🐺',
     'detail' => 'Legenda spune că Roma a fost fondată de Romulus, care și-a ucis fratele Remus după o ceartă. Romulus a devenit primul rege al Romei.'],
    ['year' => '509 î.Hr.', 'title' => 'Republica Romană',         'short' => 'Sfârșitul monarhiei',    'icon' => '🏛️',
     'detail' => 'Ultimul rege roman, Tarquinius Superbus, a fost alungat. Roma a devenit o republică condusă de doi consuli aleși anual.'],
    ['year' => '264–146 î.Hr.', 'title' => 'Războaiele Punice',    'short' => 'Roma vs Cartagina',      'icon' => '🐘',
     'detail' => 'Trei războaie devastatoare împotriva Cartaginei. Hannibal a traversat Alpii cu elefanți, dar Roma a câștigat în final.'],
    ['year' => '44 î.Hr.',  'title' => 'Asasinarea lui Caesar',    'short' => 'Idele lui Marte',         'icon' => '🗡️',
     'detail' => 'Iulius Caesar a fost asasinat pe 15 martie 44 î.Hr. de un grup de senatori. Aceasta a declanșat un nou război civil.'],
    ['year' => '27 î.Hr.',  'title' => 'Imperiul Roman',           'short' => 'Augustus devine împărat', 'icon' => '👑',
     'detail' => 'Octavian primește titlul de Augustus. Începe Pax Romana — 200 de ani de relativă pace și prosperitate.'],
    ['year' => '70 d.Hr.',  'title' => 'Colosseumul',              'short' => 'Amfiteatrul Flavian',     'icon' => '🏟️',
     'detail' => 'Împăratul Vespasian a început construcția Colosseumului. Finalizat în 80 d.Hr., putea găzdui 80.000 de spectatori.'],
    ['year' => '98–117',    'title' => 'Apogeul sub Traian',       'short' => 'Dimensiunea maximă',      'icon' => '🗺️',
     'detail' => 'Sub Traian, imperiul a atins suprafața maximă de 5 milioane km². A cucerit Dacia (actuala România).'],
    ['year' => '313 d.Hr.', 'title' => 'Edictul de la Milano',     'short' => 'Libertatea religioasă',   'icon' => '✝️',
     'detail' => 'Constantin cel Mare a legalizat creștinismul. Aceasta a transformat fundamental societatea romană.'],
    ['year' => '395 d.Hr.', 'title' => 'Împărțirea Imperiului',   'short' => 'Apus și Răsărit',          'icon' => '⚡',
     'detail' => 'La moartea lui Teodosie I, imperiul a fost împărțit definitiv între fiii săi.'],
    ['year' => '476 d.Hr.', 'title' => 'Căderea Imperiului',       'short' => 'Sfârşitul Antichităţii',  'icon' => '💀',
     'detail' => 'Romulus Augustulus a fost detronat de Odoacru. Marchează sfârşitul Antichității și începutul Evului Mediu.'],
];

// Cauze cădere
$cauze = [
    ['icon' => '⚔️', 'titlu' => 'Invaziile Barbare',      'desc' => 'Vizigotii, Hunii, Vandalii au atacat constant. În 410 d.Hr. Roma a fost jefuită de Alaric I.'],
    ['icon' => '💰', 'titlu' => 'Criza Economică',         'desc' => 'Devalorizarea monedei, taxele excesive și declinul comerțului au dus la colapsul economic.'],
    ['icon' => '🏛️', 'titlu' => 'Instabilitatea Politică', 'desc' => 'Între 235-284 d.Hr. imperiul a avut peste 50 de împărați, mulți asasinați.'],
    ['icon' => '⚕️', 'titlu' => 'Epidemii',                'desc' => 'Ciuma Antonină și Ciuma lui Ciprian au ucis milioane, decimând armata.'],
];
?>

<main>

    <!-- TIMELINE -->
    <section class="timeline-section reveal-section">
        <h2 class="section-title">Linia Timpului</h2>
        <p class="section-sub">Apasă pe un eveniment pentru detalii</p>

        <div class="timeline-container" id="timeline-container">
            <?php foreach ($timelineEvents as $index => $ev): ?>
            <div class="timeline-event" onclick="showDetailStatic(
                '<?php echo addslashes($ev['icon']); ?>',
                '<?php echo addslashes($ev['title']); ?>',
                '<?php echo addslashes($ev['year']); ?>',
                '<?php echo addslashes($ev['detail']); ?>',
                this
            )">
                <div class="timeline-event-card">
                    <div class="t-year"><?php echo $ev['icon']; ?> <?php echo $ev['year']; ?></div>
                    <div class="t-title"><?php echo $ev['title']; ?></div>
                    <div class="t-short"><?php echo $ev['short']; ?></div>
                </div>
                <div class="timeline-node"></div>
                <div style="flex:1"></div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="timeline-detail-panel" id="timeline-detail">
            <div class="detail-close" onclick="closeDetail()">✕</div>
            <div id="detail-content"></div>
        </div>
    </section>

    <!-- FONDAREA -->
    <section class="content-section reveal-section">
        <div class="content-card left-accent">
            <h2 class="section-title">⚡ Fondarea</h2>
            <p>Imperiul Roman a fost fondat în anul <strong>27 î.Hr.</strong> când Octavian a primit
            titlul de <em>Augustus</em>. El a instaurat <em>Pax Romana</em> — o perioadă de pace
            relativă de aproape 200 de ani.</p>
        </div>
    </section>

    <!-- APOGEUL -->
    <section class="content-section reveal-section">
        <div class="content-card right-accent">
            <h2 class="section-title">🏆 Apogeul</h2>
            <p>Sub împăratul <strong>Traian</strong> (98–117 d.Hr.), imperiul a atins dimensiunea maximă,
            pe trei continente: Europa, Asia și Africa.</p>
            <div class="territory-chart">
                <h3 class="chart-title">Extinderea Teritorială</h3>
                <?php
                $teritorii = [
                    'Europa'          => 85,
                    'Africa de Nord'  => 70,
                    'Asia Mică'       => 55,
                    'Orientul Mijlociu' => 30,
                ];
                foreach ($teritorii as $regiune => $procent): ?>
                <div class="territory-bar-item">
                    <span><?php echo $regiune; ?></span>
                    <div class="t-bar"><div class="t-fill" data-width="<?php echo $procent; ?>"></div></div>
                    <span><?php echo $procent; ?>%</span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CĂDEREA -->
    <section class="content-section reveal-section">
        <div class="content-card danger-accent">
            <h2 class="section-title">💀 Căderea</h2>
            <p>În <strong>476 d.Hr.</strong> ultimul împărat roman de apus, <em>Romulus Augustulus</em>,
            a fost detronat de Odoacru.</p>

            <div class="collapse-reasons">
                <h3 class="chart-title">Cauzele Căderii</h3>
                <?php foreach ($cauze as $cauza): ?>
                <div class="reason-item" onclick="toggleReason(this)">
                    <div class="reason-header">
                        <span><?php echo $cauza['icon']; ?></span>
                        <?php echo $cauza['titlu']; ?>
                        <span class="reason-arrow">▼</span>
                    </div>
                    <div class="reason-body"><?php echo $cauza['desc']; ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

</main>

<script>
// Funcție pentru timeline generat din PHP
function showDetailStatic(icon, title, year, detail, el) {
    document.querySelectorAll('.timeline-event-card').forEach(c => c.classList.remove('active-event'));
    el.querySelector('.timeline-event-card').classList.add('active-event');
    const panel = document.getElementById('timeline-detail');
    const content = document.getElementById('detail-content');
    content.innerHTML = `<div style="font-size:3rem;margin-bottom:12px">${icon}</div><h3>${title}</h3><div class="d-year">${year}</div><p>${detail}</p>`;
    panel.classList.add('open');
}
</script>

<?php include 'includes/footer.php'; ?>
