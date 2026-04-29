/* ============================================================
   IMPERIUL ROMAN — script.js
   Toate funcționalitățile JavaScript pentru site-ul multi-pagina
============================================================ */

'use strict';

/* ============================================================
   1. CURSOR PERSONALIZAT
============================================================ */
(function initCursor() {
    const dot  = document.querySelector('.cursor-dot');
    const ring = document.querySelector('.cursor-ring');
    if (!dot || !ring) return;

    let mouseX = 0, mouseY = 0;
    let ringX  = 0, ringY  = 0;

    document.addEventListener('mousemove', e => {
        mouseX = e.clientX;
        mouseY = e.clientY;
        dot.style.left  = mouseX + 'px';
        dot.style.top   = mouseY + 'px';
    });

    (function animateRing() {
        ringX += (mouseX - ringX) * 0.12;
        ringY += (mouseY - ringY) * 0.12;
        ring.style.left = ringX + 'px';
        ring.style.top  = ringY + 'px';
        requestAnimationFrame(animateRing);
    })();

    document.querySelectorAll('a, button, .flip-card, .stat-card, .emperor-dot, .timeline-event-card, .monument-item, .god-card, .heritage-item, .reason-item').forEach(el => {
        el.addEventListener('mouseenter', () => document.body.classList.add('cursor-hover'));
        el.addEventListener('mouseleave', () => document.body.classList.remove('cursor-hover'));
    });
})();


/* ============================================================
   2. PARTICLES (canvas floating sparks)
============================================================ */
(function initParticles() {
    const canvas = document.getElementById('particles-canvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');

    let W, H, particles = [];

    function resize() {
        W = canvas.width  = window.innerWidth;
        H = canvas.height = window.innerHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    function Particle() {
        this.reset();
    }
    Particle.prototype.reset = function() {
        this.x     = Math.random() * W;
        this.y     = Math.random() * H + H;
        this.r     = Math.random() * 1.5 + 0.3;
        this.speed = Math.random() * 0.5 + 0.2;
        this.alpha = Math.random() * 0.5 + 0.1;
        this.drift = (Math.random() - 0.5) * 0.4;
    };
    Particle.prototype.update = function() {
        this.y -= this.speed;
        this.x += this.drift;
        this.alpha -= 0.0015;
        if (this.y < -10 || this.alpha <= 0) this.reset();
    };

    for (let i = 0; i < 60; i++) {
        const p = new Particle();
        p.y = Math.random() * H; // scatter on load
        particles.push(p);
    }

    function draw() {
        ctx.clearRect(0, 0, W, H);
        for (const p of particles) {
            p.update();
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(201,168,76,${p.alpha})`;
            ctx.fill();
        }
        requestAnimationFrame(draw);
    }
    draw();
})();


/* ============================================================
   3. PRELOADER (doar pe index.html)
============================================================ */
(function initPreloader() {
    const preloader = document.getElementById('preloader');
    if (!preloader) return;
    window.addEventListener('load', () => {
        setTimeout(() => preloader.classList.add('hidden'), 2000);
    });
})();


/* ============================================================
   4. NAV SCROLL EFFECT
============================================================ */
(function initNav() {
    const nav = document.getElementById('main-nav');
    if (!nav) return;
    window.addEventListener('scroll', () => {
        nav.style.boxShadow = window.scrollY > 50
            ? '0 4px 40px rgba(0,0,0,0.7)'
            : '0 4px 30px rgba(0,0,0,0.5)';
    });
})();


/* ============================================================
   5. REVEAL ON SCROLL
============================================================ */
(function initReveal() {
    const sections = document.querySelectorAll('.reveal-section');
    if (!sections.length) return;

    const observer = new IntersectionObserver(entries => {
        entries.forEach((e, i) => {
            if (e.isIntersecting) {
                setTimeout(() => {
                    e.target.classList.add('visible');
                    triggerSectionAnimations(e.target);
                }, i * 100);
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });

    sections.forEach(s => observer.observe(s));

    function triggerSectionAnimations(section) {
        // Animate progress bars
        section.querySelectorAll('.t-fill').forEach(bar => {
            const target = bar.dataset.width || 0;
            requestAnimationFrame(() => { bar.style.width = target + '%'; });
        });
        // Start counters if stats section
        if (section.querySelector('.stat-card')) {
            startCounters(section);
        }
    }
})();


/* ============================================================
   6. ANIMATED COUNTERS
============================================================ */
function startCounters(container) {
    const cards = (container || document).querySelectorAll('.stat-card[data-target]');
    cards.forEach(card => {
        const target = parseInt(card.dataset.target);
        const suffix = card.dataset.suffix || '';
        const numEl  = card.querySelector('.stat-number');
        if (!numEl) return;

        let current = 0;
        const duration = 2000;
        const steps = 60;
        const increment = target / steps;
        const interval = duration / steps;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            numEl.textContent = Math.floor(current) + suffix;
        }, interval);
    });
}


/* ============================================================
   7. EMPERORS CAROUSEL (index.html)
============================================================ */
const EMPERORS = [
    {
        emoji: '👑',
        name: 'Augustus',
        reign: '27 î.Hr. — 14 d.Hr.',
        desc: 'Primul împărat roman. A transformat Roma dintr-un oraș de cărămidă într-unul de marmură. A instaurat Pax Romana.',
        badge: 'Fondatorul Imperiului'
    },
    {
        emoji: '⚔️',
        name: 'Traian',
        reign: '98 — 117 d.Hr.',
        desc: 'Cel mai iubit împărat. Sub conducerea lui, imperiul a atins dimensiunea maximă. A cucerit Dacia și a ridicat Columna lui Traian.',
        badge: 'Optimus Princeps'
    },
    {
        emoji: '📚',
        name: 'Marcus Aurelius',
        reign: '161 — 180 d.Hr.',
        desc: 'Împăratul filosof. A scris Meditațiile — una dintre cele mai mari opere stoice. A guvernat cu înțelepciune și dreptate.',
        badge: 'Filosof-Împărat'
    },
    {
        emoji: '🔱',
        name: 'Iulius Caesar',
        reign: '49 — 44 î.Hr.',
        desc: 'Deși nu a fost oficial împărat, a deschis calea spre imperiu. General genial, a cucerit Galia și a revoluționat statul roman.',
        badge: 'Dictator Perpetuu'
    },
    {
        emoji: '✝️',
        name: 'Constantin cel Mare',
        reign: '306 — 337 d.Hr.',
        desc: 'A legalizat creștinismul prin Edictul de la Milano (313 d.Hr.) și a mutat capitala la Constantinopol.',
        badge: 'Fondatorul Bizanțului'
    },
    {
        emoji: '🛡️',
        name: 'Hadrian',
        reign: '117 — 138 d.Hr.',
        desc: 'Marele constructor. A ridicat Zidul lui Hadrian în Britannia și Panteonul de la Roma. A codificat dreptul roman.',
        badge: 'Arhitectul Imperiului'
    }
];

let currentEmperor = 0;

function renderEmperor(index, direction) {
    const display = document.getElementById('emperor-display');
    if (!display) return;

    const e = EMPERORS[index];
    display.style.opacity = '0';
    display.style.transform = direction > 0 ? 'translateX(30px)' : 'translateX(-30px)';

    setTimeout(() => {
        display.innerHTML = `
            <div class="emperor-emoji">${e.emoji}</div>
            <div class="emperor-info">
                <h3>${e.name}</h3>
                <div class="emperor-reign">${e.reign}</div>
                <p>${e.desc}</p>
                <div class="emperor-badge">${e.badge}</div>
            </div>
        `;
        display.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
        display.style.opacity = '1';
        display.style.transform = 'translateX(0)';
    }, 200);

    // Update dots
    const dotsEl = document.getElementById('emperor-dots');
    if (dotsEl) {
        dotsEl.querySelectorAll('.emperor-dot').forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
    }
}

function initEmperorsCarousel() {
    const display = document.getElementById('emperor-display');
    const dotsEl  = document.getElementById('emperor-dots');
    if (!display || !dotsEl) return;

    EMPERORS.forEach((_, i) => {
        const dot = document.createElement('div');
        dot.className = 'emperor-dot' + (i === 0 ? ' active' : '');
        dot.onclick = () => {
            const dir = i > currentEmperor ? 1 : -1;
            currentEmperor = i;
            renderEmperor(currentEmperor, dir);
        };
        dotsEl.appendChild(dot);
    });

    renderEmperor(0, 1);

    // Auto-advance every 5 seconds
    setInterval(() => changeEmperor(1), 5000);
}

window.changeEmperor = function(dir) {
    const prev = currentEmperor;
    currentEmperor = (currentEmperor + dir + EMPERORS.length) % EMPERORS.length;
    renderEmperor(currentEmperor, dir);
};


/* ============================================================
   8. FLIP CARDS (index.html)
============================================================ */
const FLIP_DATA = [
    { icon: '🏟️', hint: 'Arhitectură', title: 'Colosseumul', text: 'Putea găzdui 80.000 spectatori și era acoperit cu un velarium — o prelată uriașă!' },
    { icon: '💧', hint: 'Inginerie', title: 'Apeductele', text: 'Roma primea 1 milion de litri de apă zilnic prin 11 apeducte — mai mult decât multe orașe moderne!' },
    { icon: '⚖️', hint: 'Drept', title: 'Legea Romană', text: 'Sistemul juridic roman stă la baza legilor din peste 150 de țări moderne, inclusiv România!' },
    { icon: '📅', hint: 'Calendar', title: 'Calendarul', text: 'Iulius Caesar a creat calendarul iulian în 45 î.Hr. Lunile iulie și august poartă numele lui Caesar și Augustus!' },
    { icon: '🍕', hint: 'Mâncare', title: 'Gastronomia', text: 'Romanii aveau fast-food! Termopoliumuri (restaurante cu ghișee) serveau mâncare caldă pe străzile Pompeiei.' },
    { icon: '🌐', hint: 'Limbă', title: 'Latina Vie', text: 'Latina a dat naștere a 6 limbi majore vorbite de 900M oameni: română, italiană, spaniolă, franceză, portugheză, catalană.' },
];

function initFlipCards() {
    const grid = document.getElementById('flip-grid');
    if (!grid) return;

    FLIP_DATA.forEach(data => {
        const card = document.createElement('div');
        card.className = 'flip-card';
        card.innerHTML = `
            <div class="flip-card-inner">
                <div class="flip-front">
                    <div class="f-icon">${data.icon}</div>
                    <div class="f-hint">${data.hint}</div>
                </div>
                <div class="flip-back">
                    <div class="b-title">${data.title}</div>
                    <div class="b-text">${data.text}</div>
                </div>
            </div>
        `;
        card.addEventListener('click', () => card.classList.toggle('flipped'));
        grid.appendChild(card);
    });
}


/* ============================================================
   9. TIMELINE (istorie.html)
============================================================ */
const TIMELINE_DATA = [
    {
        year: '753 î.Hr.',
        title: 'Fondarea Romei',
        short: 'Romulus și Remus',
        detail: 'Legenda spune că Roma a fost fondată de Romulus, care și-a ucis fratele Remus după o ceartă. Romulus a devenit primul rege al Romei.',
        icon: '🐺'
    },
    {
        year: '509 î.Hr.',
        title: 'Republica Romană',
        short: 'Sfârșitul monarhiei',
        detail: 'Ultimul rege roman, Tarquinius Superbus, a fost alungat. Roma a devenit o republică condusă de doi consuli aleși anual.',
        icon: '🏛️'
    },
    {
        year: '264–146 î.Hr.',
        title: 'Războaiele Punice',
        short: 'Roma vs Cartagina',
        detail: 'Trei războaie devastatoare împotriva Cartaginei. Hannibal a traversat Alpii cu elefanți, dar Roma a câștigat în final. Cartagina a fost distrusă complet.',
        icon: '🐘'
    },
    {
        year: '44 î.Hr.',
        title: 'Asasinarea lui Caesar',
        short: 'Idele lui Marte',
        detail: 'Iulius Caesar a fost asasinat pe 15 martie 44 î.Hr. de un grup de senatori conduși de Brutus și Cassius. Aceasta a declanșat un nou război civil.',
        icon: '🗡️'
    },
    {
        year: '27 î.Hr.',
        title: 'Imperiul Roman',
        short: 'Augustus devine împărat',
        detail: 'Octavian primește titlul de Augustus din partea Senatului, devenind primul împărat roman. Începe Pax Romana — 200 de ani de relativă pace.',
        icon: '👑'
    },
    {
        year: '70 d.Hr.',
        title: 'Construcția Colosseumului',
        short: 'Amfiteatrul Flavian',
        detail: 'Împăratul Vespasian a început construcția Colosseumului. A fost finalizat în 80 d.Hr. sub Titus și putea găzdui 80.000 de spectatori.',
        icon: '🏟️'
    },
    {
        year: '98–117 d.Hr.',
        title: 'Apogeul sub Traian',
        short: 'Dimensiunea maximă',
        detail: 'Sub Traian, imperiul a atins suprafața maximă de 5 milioane km². A cucerit Dacia (actuala România) în două campanii militare remarcabile.',
        icon: '🗺️'
    },
    {
        year: '313 d.Hr.',
        title: 'Edictul de la Milano',
        short: 'Libertatea religioasă',
        detail: 'Constantin cel Mare a legalizat creștinismul. Aceasta a transformat fundamental societatea romană și a pus bazele Europei creștine medievale.',
        icon: '✝️'
    },
    {
        year: '395 d.Hr.',
        title: 'Împărțirea Imperiului',
        short: 'Apus și Răsărit',
        detail: 'La moartea lui Teodosie I, imperiul a fost împărțit definitiv între fiii săi: Honorius la Apus și Arcadius la Răsărit (Bizanț).',
        icon: '⚡'
    },
    {
        year: '476 d.Hr.',
        title: 'Căderea Imperiului de Apus',
        short: 'Sfârşitul Antichităţii',
        detail: 'Ultimul împărat roman de apus, Romulus Augustulus, a fost detronat de Odoacru. Aceasta marchează convențional sfârşitul Antichității şi începutul Evului Mediu.',
        icon: '💀'
    }
];

function initTimeline() {
    const container = document.getElementById('timeline-container');
    if (!container) return;

    TIMELINE_DATA.forEach((event, index) => {
        const div = document.createElement('div');
        div.className = 'timeline-event';
        div.innerHTML = `
            <div class="timeline-event-card">
                <div class="t-year">${event.icon} ${event.year}</div>
                <div class="t-title">${event.title}</div>
                <div class="t-short">${event.short}</div>
            </div>
            <div class="timeline-node"></div>
            <div style="flex:1"></div>
        `;
        div.addEventListener('click', () => showTimelineDetail(event, div));
        container.appendChild(div);
    });
}

function showTimelineDetail(event, clickedEl) {
    document.querySelectorAll('.timeline-event-card').forEach(c => c.classList.remove('active-event'));
    clickedEl.querySelector('.timeline-event-card').classList.add('active-event');

    const panel = document.getElementById('timeline-detail');
    const content = document.getElementById('detail-content');
    if (!panel || !content) return;

    content.innerHTML = `
        <div style="font-size:3rem;margin-bottom:12px">${event.icon}</div>
        <h3>${event.title}</h3>
        <div class="d-year">${event.year}</div>
        <p>${event.detail}</p>
    `;
    panel.classList.add('open');
}

window.closeDetail = function() {
    const panel = document.getElementById('timeline-detail');
    if (panel) panel.classList.remove('open');
    document.querySelectorAll('.timeline-event-card').forEach(c => c.classList.remove('active-event'));
};


/* ============================================================
   10. ACCORDION REASONS (istorie.html)
============================================================ */
window.toggleReason = function(item) {
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.reason-item').forEach(r => r.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
};


/* ============================================================
   11. TABS (cultura.html)
============================================================ */
window.switchTab = function(tabId) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));

    const target = document.getElementById('tab-' + tabId);
    if (target) target.classList.add('active');

    document.querySelectorAll('.tab-btn').forEach(b => {
        if (b.getAttribute('onclick').includes(tabId)) b.classList.add('active');
    });
};

function initMonuments() {
    const container = document.getElementById('monument-list');
    if (!container) return;

    const monuments = [
        { icon: '🏟️', name: 'Colosseumul',    detail: '80 d.Hr., 80.000 locuri' },
        { icon: '⛩️', name: 'Pantheonul',      detail: '125 d.Hr., cupolă 43m' },
        { icon: '🏛️', name: 'Forul Roman',     detail: 'Centrul civic al Romei' },
        { icon: '🗿', name: 'Columna lui Traian', detail: '113 d.Hr., 30m înălțime' },
    ];

    monuments.forEach(m => {
        const div = document.createElement('div');
        div.className = 'monument-item';
        div.innerHTML = `<span class="m-icon">${m.icon}</span><span class="m-name">${m.name}</span><span class="m-detail">— ${m.detail}</span>`;
        container.appendChild(div);
    });
}

function initLanguageTree() {
    const container = document.getElementById('language-tree');
    if (!container) return;

    const langs = ['🇷🇴 Română', '🇮🇹 Italiană', '🇪🇸 Spaniolă', '🇫🇷 Franceză', '🇵🇹 Portugheză', '🇦🇩 Catalană'];
    container.innerHTML = `
        <div class="lt-root">LATINA</div>
        <div class="lt-branch-line"></div>
        <div class="lt-leaves">
            ${langs.map(l => `<div class="lt-leaf">${l}</div>`).join('')}
        </div>
    `;
}

function initGodsGrid() {
    const container = document.getElementById('gods-grid');
    if (!container) return;

    const gods = [
        { icon: '⚡', name: 'Jupiter',  domain: 'Cerul, Tunetul' },
        { icon: '🌊', name: 'Neptun',   domain: 'Marea' },
        { icon: '🔥', name: 'Vulcan',   domain: 'Focul, Fierăria' },
        { icon: '❤️', name: 'Venus',    domain: 'Dragostea' },
        { icon: '⚔️', name: 'Marte',   domain: 'Războiul' },
        { icon: '🌙', name: 'Diana',    domain: 'Luna, Vânătoarea' },
    ];

    gods.forEach(g => {
        const div = document.createElement('div');
        div.className = 'god-card';
        div.innerHTML = `<span class="god-icon">${g.icon}</span><div class="god-name">${g.name}</div><div class="god-domain">${g.domain}</div>`;
        container.appendChild(div);
    });
}


/* ============================================================
   12. HERITAGE GRID (cultura.html)
============================================================ */
function initHeritage() {
    const container = document.getElementById('heritage-grid');
    if (!container) return;

    const items = [
        { icon: '⚖️', title: 'Dreptul Roman',      desc: 'Baza sistemelor juridice din 150+ țări' },
        { icon: '🗣️', title: 'Limbile Romanice',   desc: '900M vorbitori pe 5 continente' },
        { icon: '🏛️', title: 'Arhitectura',        desc: 'Arcuri, cupole, beton — moștenire vie' },
        { icon: '📅', title: 'Calendarul',          desc: 'Structura lunilor pe care o folosim azi' },
        { icon: '🏙️', title: 'Orașe Europene',     desc: 'Londra, Paris, Viena — fonduri romane' },
        { icon: '🔤', title: 'Alfabetul Latin',     desc: 'Literele pe care le citești acum' },
        { icon: '🤝', title: 'Republica',           desc: 'Conceptul de stat democratic reprezentativ' },
        { icon: '🛤️', title: 'Infrastructura',     desc: '400.000 km de drumuri — model antic' },
    ];

    items.forEach(item => {
        const div = document.createElement('div');
        div.className = 'heritage-item';
        div.innerHTML = `<span class="heritage-icon">${item.icon}</span><div class="heritage-title">${item.title}</div><div class="heritage-desc">${item.desc}</div>`;
        container.appendChild(div);
    });
}


/* ============================================================
   13. ROTATING QUOTES (cultura.html)
============================================================ */
const QUOTES = [
    { text: 'Veni, vidi, vici.',                        author: '— Iulius Caesar' },
    { text: 'Alea iacta est.',                           author: '— Iulius Caesar' },
    { text: 'Carpe diem.',                               author: '— Horațiu' },
    { text: 'Cogito, ergo sum.',                         author: '— tradiție filosofică romană' },
    { text: 'In vino veritas.',                          author: '— Plinius cel Bătrân' },
    { text: 'Dum spiro, spero.',                         author: '— Cicero' },
    { text: 'Per aspera ad astra.',                      author: '— proverb latin' },
    { text: 'Roma caput mundi.',                         author: '— lozinca Imperiului' },
    { text: 'Dulce et decorum est pro patria mori.',     author: '— Horațiu' },
    { text: 'Si vis pacem, para bellum.',                author: '— Vegetius' },
];

let quoteIndex = 0;

window.nextQuote = function() {
    quoteIndex = (quoteIndex + 1) % QUOTES.length;
    const q = QUOTES[quoteIndex];
    const container = document.getElementById('rotating-quote');
    if (!container) return;

    container.style.opacity = '0';
    container.style.transform = 'translateY(10px)';
    setTimeout(() => {
        container.querySelector('.quote-text').textContent = `"${q.text}"`;
        container.querySelector('.quote-author').textContent = q.author;
        container.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
        container.style.opacity = '1';
        container.style.transform = 'translateY(0)';
    }, 350);
};


/* ============================================================
   14. QUIZ
============================================================ */
const ALL_QUESTIONS = [
    // Easy
    { text: 'Când a fost fondat Imperiul Roman?', category: '📅 Cronologie', difficulty: 'easy',
      answers: ['27 î.Hr.', '44 î.Hr.', '100 d.Hr.', '476 d.Hr.'], correct: 0,
      explanation: 'Octavian a primit titlul de Augustus în 27 î.Hr., marcând fondarea imperiului.' },

    { text: 'Cine a fost primul împărat roman?', category: '👑 Împărați', difficulty: 'easy',
      answers: ['Iulius Caesar', 'Augustus', 'Nero', 'Traian'], correct: 1,
      explanation: 'Augustus (Octavian) a fost primul împărat, deși Caesar a deschis calea.' },

    { text: 'Câți spectatori putea găzdui Colosseumul?', category: '🏛️ Arhitectură', difficulty: 'easy',
      answers: ['10.000', '30.000', '80.000', '150.000'], correct: 2,
      explanation: 'Colosseumul (Amfiteatrul Flavian) putea găzdui între 50.000 și 80.000 spectatori.' },

    { text: 'Din ce limbă provin limbile romanice?', category: '🗣️ Limbă', difficulty: 'easy',
      answers: ['Greacă', 'Latină', 'Etruscă', 'Oscanică'], correct: 1,
      explanation: 'Limbile romanice (română, italiană, spaniolă etc.) descind din latina vulgară.' },

    { text: 'Când a căzut Imperiul Roman de Apus?', category: '📅 Cronologie', difficulty: 'easy',
      answers: ['395 d.Hr.', '410 d.Hr.', '455 d.Hr.', '476 d.Hr.'], correct: 3,
      explanation: 'Romulus Augustulus a fost detronat de Odoacru în 476 d.Hr.' },

    // Medium
    { text: 'Sub ce împărat a atins Imperiul Roman dimensiunea maximă?', category: '👑 Împărați', difficulty: 'easy',
      answers: ['Augustus', 'Hadrian', 'Traian', 'Marcus Aurelius'], correct: 2,
      explanation: 'Sub Traian (98-117 d.Hr.), imperiul a atins 5 milioane km² — inclusiv Dacia.' },

    { text: 'Ce a construit Hadrian în Britannia?', category: '🏛️ Arhitectură', difficulty: 'easy',
      answers: ['Un templu', 'Un zid de apărare', 'Un apeduct', 'Un for'], correct: 1,
      explanation: 'Zidul lui Hadrian (122 d.Hr.) traversa nordul Angliei — 117 km lungime.' },

    { text: 'Ce înseamnă SPQR?', category: '📜 Cultură', difficulty: 'easy',
      answers: ['Senatus Populusque Romanus', 'Sol Patriae Quaerit Roma', 'Sunt Pugna Quae Roma', 'Signum Populi Romani'], correct: 0,
      explanation: 'SPQR = Senatus Populusque Romanus = Senatul și Poporul Roman.' },

    // Hard
    { text: 'Ce eveniment marchează "Criza Secolului al III-lea"?', category: '⚔️ Crize', difficulty: 'hard',
      answers: ['50+ împărați în 50 ani', 'Invazia hunilor', 'Împărțirea imperiului', 'Căderea Romei'], correct: 0,
      explanation: 'Între 235-284 d.Hr., imperiul a avut peste 50 de împărați — mulți asasinați.' },

    { text: 'Ce lege a legalizat creștinismul în imperiu?', category: '✝️ Religie', difficulty: 'hard',
      answers: ['Legea celor XII Table', 'Edictul de la Milano', 'Edictul de la Tesalonic', 'Pax Dei'], correct: 1,
      explanation: 'Constantin cel Mare a emis Edictul de la Milano în 313 d.Hr., legalizând creștinismul.' },
];

let quizQuestions = [];
let currentQuestion = 0;
let score = 0;
let totalPoints = 0;
let timer = null;
let timeLeft = 15;
let selectedDifficulty = 'all';
let userAnswers = [];

window.setDifficulty = function(diff, btn) {
    selectedDifficulty = diff;
    document.querySelectorAll('.diff-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
};

window.startQuiz = function() {
    quizQuestions = selectedDifficulty === 'all'
        ? [...ALL_QUESTIONS].sort(() => Math.random() - 0.5).slice(0, 10)
        : ALL_QUESTIONS.filter(q => q.difficulty === selectedDifficulty).sort(() => Math.random() - 0.5).slice(0, 10);

    if (quizQuestions.length < 3) quizQuestions = [...ALL_QUESTIONS].sort(() => Math.random() - 0.5).slice(0, 10);

    currentQuestion = 0;
    score = 0;
    totalPoints = 0;
    userAnswers = [];

    showScreen('quiz-game');
    document.getElementById('q-total').textContent = quizQuestions.length;
    renderQuestion();
};

function renderQuestion() {
    const q = quizQuestions[currentQuestion];
    document.getElementById('q-current').textContent = currentQuestion + 1;
    document.getElementById('q-category').textContent = q.category;
    document.getElementById('q-text').textContent = q.text;

    const progress = ((currentQuestion) / quizQuestions.length) * 100;
    document.getElementById('progress-fill').style.width = progress + '%';

    const grid = document.getElementById('answers-grid');
    grid.innerHTML = '';
    q.answers.forEach((answer, i) => {
        const btn = document.createElement('button');
        btn.className = 'answer-btn';
        btn.textContent = answer;
        btn.onclick = () => selectAnswer(i);
        grid.appendChild(btn);
    });

    document.getElementById('answer-feedback').classList.add('hidden');
    startTimer();
}

function startTimer() {
    clearInterval(timer);
    timeLeft = 15;
    updateTimerUI();
    timer = setInterval(() => {
        timeLeft--;
        updateTimerUI();
        if (timeLeft <= 0) {
            clearInterval(timer);
            autoFail();
        }
    }, 1000);
}

function updateTimerUI() {
    const fill = document.getElementById('timer-fill');
    const text = document.getElementById('timer-text');
    if (fill) fill.style.width = (timeLeft / 15 * 100) + '%';
    if (text) text.textContent = `⏱ ${timeLeft}s`;
    if (fill && timeLeft <= 5) fill.style.background = 'linear-gradient(90deg, #cc0000, #ff4444)';
    else if (fill) fill.style.background = 'linear-gradient(90deg, var(--red-roman), #e63232)';
}

function autoFail() {
    const q = quizQuestions[currentQuestion];
    userAnswers.push({ q: q.text, correct: false, correctAnswer: q.answers[q.correct] });
    showFeedback(false, q, -1);
}

window.selectAnswer = function(index) {
    clearInterval(timer);
    const q = quizQuestions[currentQuestion];
    const correct = index === q.correct;

    if (correct) {
        score++;
        const timeBonus = Math.floor(timeLeft * 10);
        totalPoints += 100 + timeBonus;
    }
    userAnswers.push({ q: q.text, correct, correctAnswer: q.answers[q.correct] });

    document.getElementById('q-score').textContent = totalPoints;

    const btns = document.querySelectorAll('.answer-btn');
    btns.forEach((btn, i) => {
        btn.disabled = true;
        if (i === q.correct) btn.classList.add('correct');
        if (i === index && !correct) btn.classList.add('wrong');
    });

    showFeedback(correct, q, index);
};

function showFeedback(correct, q, selectedIndex) {
    const fb = document.getElementById('answer-feedback');
    document.getElementById('feedback-icon').textContent = correct ? '✅' : (selectedIndex === -1 ? '⏰' : '❌');
    document.getElementById('feedback-text').textContent = correct
        ? 'Corect! Bravo!'
        : (selectedIndex === -1 ? 'Timp expirat!' : `Greșit! Răspunsul corect: "${q.answers[q.correct]}"`);
    document.getElementById('feedback-explanation').textContent = q.explanation;
    fb.classList.remove('hidden');
}

window.nextQuestion = function() {
    currentQuestion++;
    if (currentQuestion >= quizQuestions.length) {
        showResults();
    } else {
        renderQuestion();
    }
};

function showResults() {
    clearInterval(timer);
    showScreen('quiz-results');

    const pct = score / quizQuestions.length;
    let icon, title, msg, rank;

    if (pct === 1)         { icon = '🏆'; title = 'Perfecțiune!';    msg = 'Ești un adevărat Caesar al cunoașterii romane!'; rank = '🦅 IMPERATOR MAXIMUS'; }
    else if (pct >= 0.8)   { icon = '⚔️'; title = 'Excelent!';       msg = 'Cunoștiințele tale ar impresiona chiar și pe Cicero.'; rank = '🛡️ LEGATUS LEGIONIS'; }
    else if (pct >= 0.6)   { icon = '🏛️'; title = 'Bine!';           msg = 'Un cetățean roman demn de Republică!'; rank = '⚔️ CENTURION'; }
    else if (pct >= 0.4)   { icon = '📜'; title = 'Poți mai mult!';  msg = 'Mai citește paginile de Istorie și Cultură.'; rank = '🗡️ MILES (Soldat)'; }
    else                   { icon = '🐺'; title = 'Recommence!';      msg = 'Chiar și Romulus a trebuit să înceapă de undeva.'; rank = '📖 TIRO (Recrut)'; }

    document.getElementById('result-icon').textContent = icon;
    document.getElementById('result-title').textContent = title;
    document.getElementById('result-score').textContent = score;
    document.getElementById('result-total').textContent = quizQuestions.length;
    document.getElementById('result-points').textContent = totalPoints;
    document.getElementById('result-msg').textContent = msg;
    document.getElementById('result-rank').textContent = rank;

    const breakdown = document.getElementById('result-breakdown');
    breakdown.innerHTML = '';
    userAnswers.forEach(a => {
        const div = document.createElement('div');
        div.className = 'breakdown-item ' + (a.correct ? 'correct' : 'wrong');
        div.innerHTML = `
            <span class="b-icon">${a.correct ? '✅' : '❌'}</span>
            <span class="b-q">${a.q}</span>
        `;
        breakdown.appendChild(div);
    });
}

window.restartQuiz = function() {
    showScreen('quiz-start');
};

function showScreen(id) {
    document.querySelectorAll('.quiz-screen').forEach(s => {
        s.classList.toggle('hidden', s.id !== id);
    });
}


/* ============================================================
   15. INIT — detectare pagina și rulare
============================================================ */
document.addEventListener('DOMContentLoaded', function() {
    const path = window.location.pathname;
    const page = path.split('/').pop() || 'index.html';

    // Toate paginile
    initTimeline();          // nu face rău dacă elementele nu există

    if (page === 'index.html' || page === '') {
        initEmperorsCarousel();
        initFlipCards();
    }

    if (page === 'cultura.html') {
        initMonuments();
        initLanguageTree();
        initGodsGrid();
        initHeritage();
    }

    // Adaugă hover cursor pe toate elementele interactive generate
    document.querySelectorAll('button, a').forEach(el => {
        el.addEventListener('mouseenter', () => document.body.classList.add('cursor-hover'));
        el.addEventListener('mouseleave', () => document.body.classList.remove('cursor-hover'));
    });
});
