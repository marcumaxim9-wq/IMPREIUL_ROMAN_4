<?php
$currentPage = 'quiz';
include 'includes/header.php';
?>

<main>
    <section class="quiz-section">

        <div class="quiz-screen" id="quiz-start">
            <div class="quiz-card start-card">
                <div class="start-icon">🏛️</div>
                <h2>Provocarea Romană</h2>
                <p>10 întrebări despre Imperiul Roman. Câte știi?</p>
                <div class="difficulty-selector">
                    <span>Dificultate:</span>
                    <div class="diff-btns">
                        <button class="diff-btn active" onclick="setDifficulty('all', this)">Toate</button>
                        <button class="diff-btn" onclick="setDifficulty('easy', this)">Ușor</button>
                        <button class="diff-btn" onclick="setDifficulty('hard', this)">Dificil</button>
                    </div>
                </div>
                <button class="cta-button big" onclick="startQuiz()">⚔️ Începe Lupta!</button>
            </div>
        </div>

        <div class="quiz-screen hidden" id="quiz-game">
            <div class="quiz-card game-card">
                <div class="quiz-header">
                    <div class="quiz-progress-text">Întrebarea <span id="q-current">1</span> din <span id="q-total">10</span></div>
                    <div class="quiz-score-display">🏆 <span id="q-score">0</span> pct</div>
                </div>
                <div class="progress-bar-quiz"><div class="progress-fill-quiz" id="progress-fill"></div></div>
                <div class="timer-bar"><div class="timer-fill" id="timer-fill"></div></div>
                <div class="timer-text" id="timer-text">⏱ 15s</div>
                <div class="question-area">
                    <div class="question-category" id="q-category">📖 General</div>
                    <h3 class="question-text" id="q-text">...</h3>
                </div>
                <div class="answers-grid" id="answers-grid"></div>
                <div class="answer-feedback hidden" id="answer-feedback">
                    <div class="feedback-icon" id="feedback-icon"></div>
                    <div class="feedback-text" id="feedback-text"></div>
                    <div class="feedback-explanation" id="feedback-explanation"></div>
                    <button class="next-btn-quiz" onclick="nextQuestion()">Următoarea →</button>
                </div>
            </div>
        </div>

        <div class="quiz-screen hidden" id="quiz-results">
            <div class="quiz-card results-card">
                <div class="result-title-icon" id="result-icon">🏆</div>
                <h2 id="result-title">Felicitări!</h2>
                <div class="result-score-big"><span id="result-score">0</span>/<span id="result-total">10</span></div>
                <div class="result-points"><span id="result-points">0</span> puncte</div>
                <p id="result-msg" class="result-message"></p>
                <div class="result-rank" id="result-rank"></div>
                <div class="result-breakdown" id="result-breakdown"></div>
                <div class="result-btns">
                    <button class="cta-button" onclick="restartQuiz()">🔄 Din Nou</button>
                    <a href="index.php" class="cta-button secondary">🏛️ Acasă</a>
                </div>
            </div>
        </div>

    </section>
</main>

<?php include 'includes/footer.php'; ?>
