<?php
// =============================================
// footer.php — inclus în toate paginile
// =============================================
$currentYear = date('Y');
$lastUpdated = date('d.m.Y');
?>

<footer>
    <div class="footer-inner">
        <div class="footer-spqr">S·P·Q·R</div>
        <p>Lucrare de laborator &mdash; <?php echo $currentYear; ?></p>
        <p class="footer-sub">Alea iacta est. &nbsp;·&nbsp; Ultima actualizare: <?php echo $lastUpdated; ?></p>
    </div>
</footer>

<script src="script.js"></script>
</body>
</html>
