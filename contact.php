<?php
$currentPage = 'contact';

// =============================================
// PROCESARE FORMULAR
// =============================================
$mesajTrimis  = false;
$erori        = [];
$valori       = ['nume' => '', 'email' => '', 'subiect' => '', 'mesaj' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Preluare și curățare date
    $valori['nume']    = trim(htmlspecialchars($_POST['nume']    ?? ''));
    $valori['email']   = trim(htmlspecialchars($_POST['email']   ?? ''));
    $valori['subiect'] = trim(htmlspecialchars($_POST['subiect'] ?? ''));
    $valori['mesaj']   = trim(htmlspecialchars($_POST['mesaj']   ?? ''));

    // Validare
    if (empty($valori['nume'])) {
        $erori['nume'] = 'Numele este obligatoriu.';
    } elseif (strlen($valori['nume']) < 2) {
        $erori['nume'] = 'Numele trebuie să aibă cel puțin 2 caractere.';
    }

    if (empty($valori['email'])) {
        $erori['email'] = 'Email-ul este obligatoriu.';
    } elseif (!filter_var($valori['email'], FILTER_VALIDATE_EMAIL)) {
        $erori['email'] = 'Adresa de email nu este validă.';
    }

    if (empty($valori['subiect'])) {
        $erori['subiect'] = 'Subiectul este obligatoriu.';
    }

    if (empty($valori['mesaj'])) {
        $erori['mesaj'] = 'Mesajul este obligatoriu.';
    } elseif (strlen($valori['mesaj']) < 10) {
        $erori['mesaj'] = 'Mesajul trebuie să aibă cel puțin 10 caractere.';
    }

    // Dacă nu sunt erori — salvăm în fișier
    if (empty($erori)) {
        $dataOra   = date('d.m.Y H:i:s');
        $linie     = "[$dataOra] Nume: {$valori['nume']} | Email: {$valori['email']} | Subiect: {$valori['subiect']} | Mesaj: {$valori['mesaj']}" . PHP_EOL;

        // Salvare în fișier mesaje.txt
        $dir = __DIR__ . '/mesaje';
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        file_put_contents($dir . '/mesaje.txt', $linie, FILE_APPEND | LOCK_EX);

        $mesajTrimis = true;
        $valori = ['nume' => '', 'email' => '', 'subiect' => '', 'mesaj' => ''];
    }
}

include 'includes/header.php';
?>

<main>
    <section class="contact-section reveal-section">
        <h2 class="section-title">Trimite un Mesaj</h2>
        <p class="section-sub">
            Data curentă: <?php echo date('d F Y'); ?> &nbsp;·&nbsp; Ora: <?php echo date('H:i'); ?>
        </p>

        <?php if ($mesajTrimis): ?>
        <!-- SUCCES -->
        <div class="form-success">
            <div class="success-icon">✅</div>
            <h3>Mesaj trimis cu succes!</h3>
            <p>Mulțumim, <strong><?php echo htmlspecialchars($_POST['nume'] ?? ''); ?></strong>! Îți vom răspunde în curând.</p>
            <a href="contact.php" class="cta-button" style="margin-top:15px">Trimite alt mesaj</a>
        </div>

        <?php else: ?>
        <!-- FORMULAR -->
        <div class="contact-grid">
            <form class="contact-form" method="POST" action="contact.php">

                <!-- NUME -->
                <div class="form-group <?php echo isset($erori['nume']) ? 'has-error' : ''; ?>">
                    <label for="nume">👤 Numele tău</label>
                    <input
                        type="text"
                        id="nume"
                        name="nume"
                        placeholder="ex: Marcus Aurelius"
                        value="<?php echo $valori['nume']; ?>"
                        maxlength="100"
                    >
                    <?php if (isset($erori['nume'])): ?>
                    <div class="form-error"><?php echo $erori['nume']; ?></div>
                    <?php endif; ?>
                </div>

                <!-- EMAIL -->
                <div class="form-group <?php echo isset($erori['email']) ? 'has-error' : ''; ?>">
                    <label for="email">📧 Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="ex: caesar@roma.it"
                        value="<?php echo $valori['email']; ?>"
                        maxlength="150"
                    >
                    <?php if (isset($erori['email'])): ?>
                    <div class="form-error"><?php echo $erori['email']; ?></div>
                    <?php endif; ?>
                </div>

                <!-- SUBIECT -->
                <div class="form-group <?php echo isset($erori['subiect']) ? 'has-error' : ''; ?>">
                    <label for="subiect">📜 Subiect</label>
                    <select id="subiect" name="subiect">
                        <option value="">— Alege subiectul —</option>
                        <?php
                        $subiecte = ['Întrebare despre istorie', 'Întrebare despre cultură', 'Feedback despre site', 'Altceva'];
                        foreach ($subiecte as $s):
                            $selected = ($valori['subiect'] === $s) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $s; ?>" <?php echo $selected; ?>><?php echo $s; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($erori['subiect'])): ?>
                    <div class="form-error"><?php echo $erori['subiect']; ?></div>
                    <?php endif; ?>
                </div>

                <!-- MESAJ -->
                <div class="form-group full-width <?php echo isset($erori['mesaj']) ? 'has-error' : ''; ?>">
                    <label for="mesaj">✍️ Mesajul tău</label>
                    <textarea
                        id="mesaj"
                        name="mesaj"
                        rows="5"
                        placeholder="Scrie mesajul tău aici..."
                        maxlength="1000"
                    ><?php echo $valori['mesaj']; ?></textarea>
                    <div class="char-counter"><span id="char-count">0</span>/1000 caractere</div>
                    <?php if (isset($erori['mesaj'])): ?>
                    <div class="form-error"><?php echo $erori['mesaj']; ?></div>
                    <?php endif; ?>
                </div>

                <!-- SUBMIT -->
                <div class="form-group full-width">
                    <button type="submit" class="cta-button big submit-btn">
                        📨 Trimite Mesajul
                    </button>
                </div>

            </form>

            <!-- INFO LATERALA -->
            <div class="contact-info">
                <div class="info-panel">
                    <div class="info-panel-title">📌 Informații</div>
                    <div class="contact-info-item">
                        <span class="ci-icon">🏛️</span>
                        <div>
                            <div class="ci-label">Proiect</div>
                            <div class="ci-val">Imperiul Roman — Lab Web</div>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <span class="ci-icon">📅</span>
                        <div>
                            <div class="ci-label">An academic</div>
                            <div class="ci-val"><?php echo date('Y'); ?></div>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <span class="ci-icon">🕐</span>
                        <div>
                            <div class="ci-label">Ora serverului</div>
                            <div class="ci-val"><?php echo date('H:i:s'); ?></div>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <span class="ci-icon">🖥️</span>
                        <div>
                            <div class="ci-label">PHP Version</div>
                            <div class="ci-val"><?php echo phpversion(); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </section>
</main>

<script>
// Contor caractere textarea
const textarea = document.getElementById('mesaj');
const counter  = document.getElementById('char-count');
if (textarea && counter) {
    textarea.addEventListener('input', () => {
        counter.textContent = textarea.value.length;
    });
}
</script>

<?php include 'includes/footer.php'; ?>
