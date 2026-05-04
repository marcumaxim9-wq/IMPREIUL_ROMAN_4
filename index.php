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

    <!-- =============================================
         ORACOLUL ROMAN — Secțiune Ajax
    ============================================== -->
    <section class="oracle-section reveal-section" id="oracle-section">
        <h2 class="section-title">🔮 Oracolul Roman</h2>
        <p class="section-sub">Pune o întrebare despre Imperiul Roman și primești răspunsul din arhivele antice</p>

        <div class="oracle-container">

            <!-- Formular întrebare -->
            <div class="oracle-input-area">
                <div class="oracle-input-wrap">
                    <input
                        type="text"
                        id="oracle-input"
                        class="oracle-input"
                        placeholder="ex: Cine a fost Augustus? / Cum a căzut imperiul? / Ce era Colosseumul?"
                        maxlength="200"
                        autocomplete="off"
                    >
                    <button class="oracle-btn" id="oracle-btn" onclick="intreabaOracolul()">
                        <span class="oracle-btn-text">Consultă Oracolul</span>
                        <span class="oracle-btn-icon">🔮</span>
                    </button>
                </div>
                <div class="oracle-error" id="oracle-error"></div>

                <!-- Sugestii rapide -->
                <div class="oracle-suggestions">
                    <span class="suggestions-label">Sugestii:</span>
                    <button class="suggestion-chip" onclick="setSuggestion(this)">Cine a fost Caesar?</button>
                    <button class="suggestion-chip" onclick="setSuggestion(this)">Cum a căzut imperiul?</button>
                    <button class="suggestion-chip" onclick="setSuggestion(this)">Ce era Colosseumul?</button>
                    <button class="suggestion-chip" onclick="setSuggestion(this)">Traian și Dacia</button>
                    <button class="suggestion-chip" onclick="setSuggestion(this)">Armata romană</button>
                </div>
            </div>

            <!-- Zona de răspuns -->
            <div class="oracle-response-area" id="oracle-response-area">

                <!-- Loading -->
                <div class="oracle-loading hidden" id="oracle-loading">
                    <div class="oracle-loading-inner">
                        <div class="oracle-flame">🔥</div>
                        <div class="oracle-loading-text">Oracolul consultă arhivele antice...</div>
                        <div class="oracle-dots">
                            <span></span><span></span><span></span>
                        </div>
                    </div>
                </div>

                <!-- Răspuns -->
                <div class="oracle-answer hidden" id="oracle-answer">
                    <div class="oracle-answer-header">
                        <span class="oracle-answer-icon" id="oracle-answer-icon">🏛️</span>
                        <div>
                            <div class="oracle-answer-label">Răspuns Oracol pentru:</div>
                            <div class="oracle-answer-question" id="oracle-answer-question"></div>
                        </div>
                    </div>
                    <h3 class="oracle-answer-title" id="oracle-answer-title"></h3>
                    <p class="oracle-answer-text" id="oracle-answer-text"></p>
                    <div class="oracle-answer-quote" id="oracle-answer-quote"></div>
                    <button class="oracle-reset-btn" onclick="resetOracol()">🔄 Altă Întrebare</button>
                </div>

                <!-- Placeholder initial -->
                <div class="oracle-placeholder" id="oracle-placeholder">
                    <div class="oracle-placeholder-icon">🏛️</div>
                    <div class="oracle-placeholder-text">Oracolul așteaptă întrebarea ta...</div>
                    <div class="oracle-placeholder-sub">Consultă arhivele a 500 de ani de imperiu</div>
                </div>

            </div>
        </div>
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
