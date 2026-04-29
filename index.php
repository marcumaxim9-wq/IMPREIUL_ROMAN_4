<?php
$currentPage = 'acasa';
include 'includes/header.php';

// Date dinamice afișate pe pagina principală
$imperiumData = [
    'capitala'   => 'Roma',
    'limba'      => 'Latina',
    'populatie'  => 'Peste 50 de milioane',
    'suprafata'  => '5 milioane km²',
    'religie'    => 'Politeism → Creștinism',
    'moneda'     => 'Denarius',
    'armata'     => 'Legiunile Romane',
    'mostenire'  => 'Drept, Limbă, Arhitectură',
];
?>

<main>

    <!-- STATS -->
    <section class="stats-section reveal-section">
        <h2 class="section-title">Imperiul în Cifre</h2>
        <div class="stats-grid">
            <div class="stat-card" data-target="500" data-suffix=" ani">
                <div class="stat-icon">⏳</div>
                <div class="stat-number">0</div>
                <div class="stat-label">Ani de Dominație</div>
            </div>
            <div class="stat-card" data-target="50" data-suffix="M+">
                <div class="stat-icon">👥</div>
                <div class="stat-number">0</div>
                <div class="stat-label">Locuitori</div>
            </div>
            <div class="stat-card" data-target="5" data-suffix="M km²">
                <div class="stat-icon">🗺️</div>
                <div class="stat-number">0</div>
                <div class="stat-label">Suprafață</div>
            </div>
            <div class="stat-card" data-target="400" data-suffix="k km">
                <div class="stat-icon">🛤️</div>
                <div class="stat-number">0</div>
                <div class="stat-label">Drumuri Construite</div>
            </div>
        </div>
    </section>

    <!-- INTRODUCERE -->
    <section class="intro-section reveal-section">
        <div class="intro-grid">
            <div class="intro-text">
                <h2 class="section-title">Introducere</h2>
                <p>
                    Imperiul Roman a fost una dintre cele mai mari civilizații din istoria omenirii.
                    A fost fondat în anul <strong>27 î.Hr.</strong> când Octavian a primit titlul de Augustus,
                    devenind primul împărat roman.
                </p>
                <p>
                    La apogeul său, imperiul se întindea de la <em>Britannia</em> în nord până în
                    <em>Egipt</em> în sud, și de la <em>Spania</em> în vest până la <em>Mesopotamia</em> în est.
                </p>
                <a href="istorie.php" class="cta-button">Explorează Istoria <span>→</span></a>
            </div>

            <!-- INFO DIN ARRAY PHP -->
            <div class="info-panel">
                <div class="info-panel-title">⚔ Fapte Rapide</div>
                <?php foreach ($imperiumData as $cheie => $valoare): ?>
                <div class="info-row">
                    <span class="info-key"><?php echo ucfirst($cheie); ?></span>
                    <span class="info-val"><?php echo $valoare; ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ÎMPĂRAȚI CAROUSEL -->
    <section class="emperors-section reveal-section">
        <h2 class="section-title">Împărații Legendari</h2>
        <div class="emperors-carousel">
            <button class="carousel-btn prev-btn" onclick="changeEmperor(-1)">‹</button>
            <div class="emperor-display" id="emperor-display"></div>
            <button class="carousel-btn next-btn" onclick="changeEmperor(1)">›</button>
        </div>
        <div class="emperor-dots" id="emperor-dots"></div>
    </section>

    <!-- FLIP CARDS -->
    <section class="flip-section reveal-section">
        <h2 class="section-title">Curiozități Romane</h2>
        <p class="section-sub">Apasă pe carduri pentru a descoperi!</p>
        <div class="flip-grid" id="flip-grid"></div>
    </section>

    <!-- CTA -->
    <section class="cta-section reveal-section">
        <div class="cta-banner">
            <h2>Testează-ți Cunoștințele!</h2>
            <p>Ai citit totul? Încearcă quiz-ul nostru despre Imperiul Roman!</p>
            <a href="quiz.php" class="cta-button big">🎯 Începe Quiz-ul</a>
        </div>
    </section>

</main>

<?php include 'includes/footer.php'; ?>
