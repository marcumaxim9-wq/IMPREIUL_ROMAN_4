<?php
// =============================================
// header.php — inclus în toate paginile
// Definește titlul paginii, header și nav
// =============================================

// Pagina curentă (setată înainte de include)
$currentPage = isset($currentPage) ? $currentPage : '';

// Titlul dinamic al paginii
$pageTitles = [
    'acasa'   => 'Imperiul Roman',
    'istorie' => 'Istorie — Imperiul Roman',
    'cultura' => 'Cultură — Imperiul Roman',
    'quiz'    => 'Quiz — Imperiul Roman',
    'contact' => 'Contact — Imperiul Roman',
];
$pageTitle = isset($pageTitles[$currentPage]) ? $pageTitles[$currentPage] : 'Imperiul Roman';

// Header emoji și subtitle dinamic
$pageHeaders = [
    'acasa'   => ['emoji' => '🦅', 'title' => 'IMPERIUL ROMAN',   'sub' => '27 î.Hr. — 476 d.Hr. &nbsp;·&nbsp; Senatus Populusque Romanus', 'bg' => 'SPQR'],
    'istorie' => ['emoji' => '⚔️', 'title' => 'ISTORIA',           'sub' => 'De la Fondare la Cădere',       'bg' => 'HISTORIA'],
    'cultura' => ['emoji' => '🏺', 'title' => 'CULTURA ROMANĂ',    'sub' => 'Artă, Arhitectură și Moștenire','bg' => 'CULTURA'],
    'quiz'    => ['emoji' => '🎯', 'title' => 'QUIZ ROMAN',        'sub' => 'Ești la fel de înțelept ca Cicero?', 'bg' => 'QUIZ'],
    'contact' => ['emoji' => '📜', 'title' => 'CONTACT',           'sub' => 'Trimite-ne un mesaj',           'bg' => 'CONTACT'],
];
$header = isset($pageHeaders[$currentPage]) ? $pageHeaders[$currentPage] : $pageHeaders['acasa'];
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400;600;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="cursor-dot"></div>
<div class="cursor-ring"></div>
<canvas id="particles-canvas"></canvas>

<?php if ($currentPage === 'acasa'): ?>
<div id="preloader">
    <div class="preloader-inner">
        <div class="spqr-text">S·P·Q·R</div>
        <div class="preloader-bar"><div class="preloader-fill"></div></div>
        <div class="preloader-sub">Se încarcă Imperiul...</div>
    </div>
</div>
<?php endif; ?>

<header id="main-header" <?php echo $currentPage !== 'acasa' ? 'class="page-header"' : ''; ?>>
    <div class="header-bg-text"><?php echo $header['bg']; ?></div>
    <div class="header-content">
        <div class="header-eagle"><?php echo $header['emoji']; ?></div>
        <h1 class="main-title" <?php echo $currentPage === 'acasa' ? 'data-text="IMPERIUL ROMAN"' : ''; ?>>
            <?php echo $header['title']; ?>
        </h1>
        <p class="header-sub"><?php echo $header['sub']; ?></p>
        <div class="header-line"></div>
    </div>
    <?php if ($currentPage === 'acasa'): ?>
    <div class="scroll-hint">
        <span>SCROLL</span>
        <div class="scroll-arrow"></div>
    </div>
    <?php endif; ?>
</header>

<nav id="main-nav">
    <div class="nav-inner">
        <?php
        $navLinks = [
            'acasa'   => ['file' => 'index.php',   'icon' => '🏛️', 'label' => 'Acasă'],
            'istorie' => ['file' => 'istorie.php',  'icon' => '⚔️', 'label' => 'Istorie'],
            'cultura' => ['file' => 'cultura.php',  'icon' => '🏺', 'label' => 'Cultură'],
            'quiz'    => ['file' => 'quiz.php',     'icon' => '🎯', 'label' => 'Quiz'],
            'contact' => ['file' => 'contact.php',  'icon' => '📜', 'label' => 'Contact'],
        ];
        $first = true;
        foreach ($navLinks as $key => $link):
            if (!$first) echo '<div class="nav-divider">✦</div>';
            $first = false;
            $activeClass = ($currentPage === $key) ? ' active' : '';
        ?>
        <a href="<?php echo $link['file']; ?>" class="nav-link<?php echo $activeClass; ?>">
            <span class="nav-icon"><?php echo $link['icon']; ?></span> <?php echo $link['label']; ?>
        </a>
        <?php endforeach; ?>
    </div>
</nav>
