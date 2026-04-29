<?php
$currentPage = 'cultura';
include 'includes/header.php';

// Date PHP pentru moștenire
$mostenire = [
    ['icon' => '⚖️', 'titlu' => 'Dreptul Roman',       'desc' => 'Baza sistemelor juridice din 150+ țări'],
    ['icon' => '🗣️', 'titlu' => 'Limbile Romanice',    'desc' => '900M vorbitori pe 5 continente'],
    ['icon' => '🏛️', 'titlu' => 'Arhitectura',         'desc' => 'Arcuri, cupole, beton — moștenire vie'],
    ['icon' => '📅', 'titlu' => 'Calendarul',           'desc' => 'Structura lunilor pe care o folosim azi'],
    ['icon' => '🏙️', 'titlu' => 'Orașe Europene',      'desc' => 'Londra, Paris, Viena — funduri romane'],
    ['icon' => '🔤', 'titlu' => 'Alfabetul Latin',      'desc' => 'Literele pe care le citești acum'],
    ['icon' => '🤝', 'titlu' => 'Republica',            'desc' => 'Conceptul de stat democratic reprezentativ'],
    ['icon' => '🛤️', 'titlu' => 'Infrastructura',      'desc' => '400.000 km de drumuri — model antic'],
];

// Limbi romanice
$limbi = ['🇷🇴 Română', '🇮🇹 Italiană', '🇪🇸 Spaniolă', '🇫🇷 Franceză', '🇵🇹 Portugheză', '🇦🇩 Catalană'];

// Zei romani
$zei = [
    ['icon' => '⚡', 'nume' => 'Jupiter', 'domeniu' => 'Cerul, Tunetul'],
    ['icon' => '🌊', 'nume' => 'Neptun',  'domeniu' => 'Marea'],
    ['icon' => '🔥', 'nume' => 'Vulcan',  'domeniu' => 'Focul, Fierăria'],
    ['icon' => '❤️', 'nume' => 'Venus',   'domeniu' => 'Dragostea'],
    ['icon' => '⚔️', 'nume' => 'Marte',  'domeniu' => 'Războiul'],
    ['icon' => '🌙', 'nume' => 'Diana',   'domeniu' => 'Luna, Vânătoarea'],
];

// Monumente
$monumente = [
    ['icon' => '🏟️', 'nume' => 'Colosseumul',         'detaliu' => '80 d.Hr., 80.000 locuri'],
    ['icon' => '⛩️', 'nume' => 'Pantheonul',           'detaliu' => '125 d.Hr., cupolă 43m'],
    ['icon' => '🏛️', 'nume' => 'Forul Roman',          'detaliu' => 'Centrul civic al Romei'],
    ['icon' => '🗿', 'nume' => 'Columna lui Traian',   'detaliu' => '113 d.Hr., 30m înălțime'],
];
?>

<main>

    <!-- TABS -->
    <section class="tabs-section reveal-section">
        <h2 class="section-title">Explorează Cultura</h2>
        <div class="tabs-nav">
            <button class="tab-btn active"  onclick="switchTab('arhitectura')">🏛️ Arhitectură</button>
            <button class="tab-btn"         onclick="switchTab('drumuri')">🛤️ Drumuri</button>
            <button class="tab-btn"         onclick="switchTab('limba')">📜 Limba</button>
            <button class="tab-btn"         onclick="switchTab('religie')">⚡ Religie</button>
            <button class="tab-btn"         onclick="switchTab('spectacole')">🎭 Spectacole</button>
        </div>

        <!-- TAB ARHITECTURA -->
        <div class="tab-content active" id="tab-arhitectura">
            <div class="tab-inner">
                <div class="tab-text">
                    <h3>Arhitectura Romană</h3>
                    <p>Romanii au construit monumente impresionante care au supraviețuit până astăzi.
                    Inovații majore: arcul, cupola și betonul roman (<em>opus caementicium</em>).</p>
                    <div class="monument-list">
                        <?php foreach ($monumente as $m): ?>
                        <div class="monument-item">
                            <span class="m-icon"><?php echo $m['icon']; ?></span>
                            <span class="m-name"><?php echo $m['nume']; ?></span>
                            <span class="m-detail">— <?php echo $m['detaliu']; ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="tab-visual">
                    <div class="arch-diagram">
                        <div class="arch-top">🏛️</div>
                        <div class="arch-name">Pantheon</div>
                        <div class="arch-year">125 d.Hr.</div>
                        <div class="arch-fact">Cupolă: 43.3m</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB DRUMURI -->
        <div class="tab-content" id="tab-drumuri">
            <div class="tab-inner">
                <div class="tab-text">
                    <h3>Drumuri și Apeducte</h3>
                    <p>Romanii au construit peste <strong>400.000 km de drumuri</strong>.
                    Expresia <em>„Toate drumurile duc la Roma"</em> vine tocmai de aici.</p>
                    <div class="road-animation">
                        <div class="road-line"></div>
                        <div class="road-traveler">🚶</div>
                        <div class="road-label">Via Appia — 312 î.Hr.</div>
                    </div>
                </div>
                <div class="tab-visual">
                    <div class="aqueduct-stats">
                        <div class="aq-stat"><span class="aq-num">11</span><span class="aq-desc">Apeducte în Roma</span></div>
                        <div class="aq-stat"><span class="aq-num">800km</span><span class="aq-desc">Total apeducte</span></div>
                        <div class="aq-stat"><span class="aq-num">400k</span><span class="aq-desc">km de drumuri</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB LIMBA -->
        <div class="tab-content" id="tab-limba">
            <div class="tab-inner">
                <div class="tab-text">
                    <h3>Limba Latină</h3>
                    <p>Din latină s-au dezvoltat <strong><?php echo count($limbi); ?> limbi romanice majore</strong>,
                    vorbite azi de peste 900 de milioane de oameni.</p>
                </div>
                <div class="tab-visual">
                    <div class="language-tree">
                        <div class="lt-root">LATINA</div>
                        <div class="lt-branch-line"></div>
                        <div class="lt-leaves">
                            <?php foreach ($limbi as $limba): ?>
                            <div class="lt-leaf"><?php echo $limba; ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB RELIGIE -->
        <div class="tab-content" id="tab-religie">
            <div class="tab-inner">
                <div class="tab-text">
                    <h3>Religia Romană</h3>
                    <p>Romanii adorau un panteon vast de <strong><?php echo count($zei); ?> zei principali</strong>,
                    moșteniți parțial din Grecia.</p>
                    <div class="gods-grid">
                        <?php foreach ($zei as $zeu): ?>
                        <div class="god-card">
                            <span class="god-icon"><?php echo $zeu['icon']; ?></span>
                            <div class="god-name"><?php echo $zeu['nume']; ?></div>
                            <div class="god-domain"><?php echo $zeu['domeniu']; ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB SPECTACOLE -->
        <div class="tab-content" id="tab-spectacole">
            <div class="tab-inner">
                <div class="tab-text">
                    <h3>Spectacole și Divertisment</h3>
                    <p>Politica romană se baza pe <em>„Panem et Circenses"</em> — Pâine și Circ.
                    Circus Maximus putea găzdui 250.000 de spectatori!</p>
                </div>
                <div class="tab-visual">
                    <div class="gladiator-card">
                        <div class="gladiator-emoji">⚔️</div>
                        <div class="gladiator-name">Gladiator</div>
                        <div class="gladiator-stats">
                            <div class="g-stat"><span>Forță</span><div class="g-bar"><div style="width:90%"></div></div></div>
                            <div class="g-stat"><span>Viteză</span><div class="g-bar"><div style="width:70%"></div></div></div>
                            <div class="g-stat"><span>Rezistență</span><div class="g-bar"><div style="width:80%"></div></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MOȘTENIREA — generat din array PHP -->
    <section class="heritage-section reveal-section">
        <h2 class="section-title">Moștenirea Romană</h2>
        <p class="section-sub">
            <?php echo count($mostenire); ?> influențe majore care durează până astăzi
        </p>
        <div class="heritage-grid">
            <?php foreach ($mostenire as $item): ?>
            <div class="heritage-item">
                <span class="heritage-icon"><?php echo $item['icon']; ?></span>
                <div class="heritage-title"><?php echo $item['titlu']; ?></div>
                <div class="heritage-desc"><?php echo $item['desc']; ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- CITAT ROTATIV -->
    <section class="quote-section reveal-section">
        <div class="big-quote" id="rotating-quote">
            <div class="quote-text">"Veni, vidi, vici."</div>
            <div class="quote-author">— Iulius Caesar</div>
        </div>
        <button class="quote-btn" onclick="nextQuote()">Altă Zicală →</button>
    </section>

</main>

<?php include 'includes/footer.php'; ?>
