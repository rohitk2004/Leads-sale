<?php
/**
 * Industry Page Builder — Premium Template
 * Usage: call render_industry_page($config) with the industry config array.
 */
function render_industry_page(array $c): void {
    $title   = $c['title'];
    $tagline = $c['tagline'];
    $emoji   = $c['emoji'];
    $color   = $c['color']  ?? '#ff5500';
    $glow    = $c['glow']   ?? 'rgba(255,85,0,0.35)';
    $badge   = $c['badge']  ?? 'INDUSTRY VERTICAL';
    $desc    = $c['desc'];
    $stats   = $c['stats']  ?? [];
    $steps   = $c['steps']  ?? [];
    $calls   = $c['calls']  ?? [];
    $modules = $c['modules'] ?? [];
    $keywords = $c['keywords'] ?? [];
    $meta_desc = $c['meta_desc'] ?? $desc;
    $meta_title = $c['meta_title'] ?? "Black Hat SEO for {$title} | BlackHat SEO";
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($meta_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_desc); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800;900&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <style>
        *,*::before,*::after{box-sizing:border-box;}
        :root{--accent:<?php echo $color; ?>;--glow:<?php echo $glow; ?>;--bg:#070810;}
        body{background:var(--bg);color:#fff;font-family:'Inter',sans-serif;margin:0;overflow-x:hidden;}

        /* ── HERO ── */
        .ind-hero{
            position:relative;min-height:72vh;display:flex;align-items:center;
            padding:140px 24px 80px;overflow:hidden;
            background:radial-gradient(ellipse at 60% 0%, rgba(0,0,0,0) 40%, var(--bg) 70%),
                        radial-gradient(ellipse at 50% -20%, var(--glow) 0%, transparent 60%);
        }
        .ind-hero .grid-bg{
            position:absolute;inset:0;z-index:0;
            background-image:linear-gradient(rgba(255,255,255,0.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.03) 1px,transparent 1px);
            background-size:55px 55px;
            animation:gridShift 18s linear infinite;
        }
        @keyframes gridShift{from{background-position:0 0;}to{background-position:55px 55px;}}

        .ind-hero-inner{position:relative;z-index:2;max-width:1100px;margin:0 auto;display:grid;grid-template-columns:1fr auto;gap:48px;align-items:center;}
        .ind-badge{display:inline-flex;align-items:center;gap:8px;background:color-mix(in srgb,var(--accent) 15%,transparent);border:1px solid color-mix(in srgb,var(--accent) 45%,transparent);padding:6px 18px;border-radius:100px;font-family:'JetBrains Mono',monospace;font-size:10px;font-weight:700;color:var(--accent);letter-spacing:2px;text-transform:uppercase;margin-bottom:20px;}
        .ind-badge-dot{width:6px;height:6px;border-radius:50%;background:var(--accent);box-shadow:0 0 8px var(--accent);animation:blink 1.4s infinite;}
        @keyframes blink{0%,100%{opacity:1;}50%{opacity:0.3;}}

        .ind-title{font-family:'Outfit',sans-serif;font-size:clamp(36px,5vw,72px);font-weight:900;letter-spacing:-2px;line-height:1.05;margin-bottom:18px;}
        .ind-title .accent{color:var(--accent);text-shadow:0 0 60px var(--glow);}
        .ind-tagline{font-size:18px;color:rgba(255,255,255,0.5);line-height:1.7;max-width:580px;margin-bottom:36px;}
        .ind-tagline strong{color:rgba(255,255,255,0.85);}

        .ind-cta-row{display:flex;gap:14px;flex-wrap:wrap;}
        .btn-accent{background:var(--accent);color:#fff;font-family:'Outfit',sans-serif;font-size:14px;font-weight:700;padding:14px 30px;border-radius:12px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .25s ease;box-shadow:0 0 30px color-mix(in srgb,var(--accent) 40%,transparent);position:relative;overflow:hidden;}
        .btn-accent::before{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.15),transparent);transition:left .4s ease;}
        .btn-accent:hover::before{left:100%;}
        .btn-accent:hover{transform:translateY(-2px) scale(1.03);color:#fff;}
        .btn-ghost{background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.12);color:rgba(255,255,255,0.72);font-family:'Outfit',sans-serif;font-size:14px;font-weight:600;padding:13px 26px;border-radius:12px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .25s ease;}
        .btn-ghost:hover{background:rgba(255,255,255,0.09);border-color:rgba(255,255,255,0.26);color:#fff;transform:translateY(-2px);}

        /* Big emoji orb */
        .ind-emoji-orb{
            width:220px;height:220px;border-radius:50%;
            display:flex;align-items:center;justify-content:center;
            font-size:90px;line-height:1;
            background:radial-gradient(circle,color-mix(in srgb,var(--accent) 20%,transparent) 0%,transparent 70%);
            border:1px solid color-mix(in srgb,var(--accent) 25%,transparent);
            box-shadow:0 0 80px var(--glow);
            animation:orbFloat 5s ease-in-out infinite;
            flex-shrink:0;
        }
        @keyframes orbFloat{0%,100%{transform:translateY(0) rotate(-3deg);}50%{transform:translateY(-18px) rotate(3deg);}}

        /* ── MARQUEE ── */
        .mq-strip{background:color-mix(in srgb,var(--accent) 6%,transparent);border-top:1px solid color-mix(in srgb,var(--accent) 20%,transparent);border-bottom:1px solid color-mix(in srgb,var(--accent) 20%,transparent);padding:14px 0;overflow:hidden;}
        .mq-track{display:flex;width:max-content;animation:mq 22s linear infinite;}
        .mq-track:hover{animation-play-state:paused;}
        .mq-item{display:inline-flex;align-items:center;gap:10px;padding:0 36px;white-space:nowrap;font-family:'JetBrains Mono',monospace;font-size:11px;font-weight:700;color:color-mix(in srgb,var(--accent) 80%,#fff);letter-spacing:1.2px;text-transform:uppercase;}
        .mq-sep{color:color-mix(in srgb,var(--accent) 50%,transparent);font-size:16px;}
        @keyframes mq{from{transform:translateX(0);}to{transform:translateX(-50%);}}

        /* ── STATS ROW ── */
        .stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;max-width:1100px;margin:0 auto;padding:60px 24px;}
        .stat-box{background:rgba(255,255,255,0.025);border:1px solid rgba(255,255,255,0.07);border-radius:18px;padding:26px 20px;text-align:center;transition:all .25s ease;}
        .stat-box:hover{border-color:color-mix(in srgb,var(--accent) 35%,transparent);background:color-mix(in srgb,var(--accent) 5%,transparent);transform:translateY(-4px);}
        .stat-num{font-family:'Outfit',sans-serif;font-size:36px;font-weight:900;color:var(--accent);letter-spacing:-1px;}
        .stat-lbl{font-size:12px;color:rgba(255,255,255,0.4);margin-top:6px;line-height:1.4;}

        /* ── SECTIONS ── */
        .sec{padding:80px 24px;max-width:1100px;margin:0 auto;}
        .sec-label{font-family:'JetBrains Mono',monospace;font-size:10px;font-weight:700;color:var(--accent);text-transform:uppercase;letter-spacing:2px;margin-bottom:10px;display:block;}
        .sec-h2{font-family:'Outfit',sans-serif;font-size:clamp(26px,3.5vw,44px);font-weight:800;letter-spacing:-1.2px;line-height:1.12;margin-bottom:14px;}
        .sec-p{font-size:15px;color:rgba(255,255,255,0.42);max-width:540px;line-height:1.7;margin-bottom:44px;}

        /* STEPS */
        .steps-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;}
        .step-card{background:rgba(255,255,255,0.025);border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:30px 24px;transition:all .3s ease;position:relative;overflow:hidden;}
        .step-card::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--accent),transparent);opacity:0;transition:opacity .3s;}
        .step-card:hover::before{opacity:1;}
        .step-card:hover{transform:translateY(-5px);border-color:color-mix(in srgb,var(--accent) 30%,transparent);box-shadow:0 16px 48px rgba(0,0,0,0.4);}
        .step-num{font-family:'JetBrains Mono',monospace;font-size:10px;font-weight:700;color:var(--accent);letter-spacing:1.5px;text-transform:uppercase;margin-bottom:12px;}
        .step-icon{font-size:28px;margin-bottom:14px;}
        .step-title{font-family:'Outfit',sans-serif;font-size:17px;font-weight:700;margin-bottom:10px;}
        .step-desc{font-size:13px;color:rgba(255,255,255,0.42);line-height:1.65;}

        /* CALL TYPES */
        .calls-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:14px;}
        .call-chip{display:flex;align-items:flex-start;gap:14px;background:rgba(255,255,255,0.025);border:1px solid rgba(255,255,255,0.07);border-radius:16px;padding:20px 20px;transition:all .25s ease;}
        .call-chip:hover{border-color:color-mix(in srgb,var(--accent) 35%,transparent);background:color-mix(in srgb,var(--accent) 4%,transparent);transform:translateX(4px);}
        .call-chip-icon{font-size:22px;flex-shrink:0;margin-top:2px;}
        .call-chip-title{font-family:'Outfit',sans-serif;font-size:15px;font-weight:700;margin-bottom:4px;}
        .call-chip-sub{font-size:12px;color:rgba(255,255,255,0.4);line-height:1.45;}

        /* MODULE CARDS */
        .modules-bg{background:rgba(255,255,255,0.012);padding:80px 24px;}
        .modules-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:16px;max-width:1100px;margin:0 auto;}
        .mod-card{background:rgba(255,255,255,0.025);border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:28px 26px;transition:all .3s ease;}
        .mod-card:hover{border-color:color-mix(in srgb,var(--accent) 30%,transparent);transform:translateY(-4px);box-shadow:0 12px 40px rgba(0,0,0,0.4);}
        .mod-badge{display:inline-flex;align-items:center;gap:6px;background:color-mix(in srgb,var(--accent) 12%,transparent);border:1px solid color-mix(in srgb,var(--accent) 28%,transparent);padding:4px 12px;border-radius:100px;font-family:'JetBrains Mono',monospace;font-size:9px;font-weight:700;color:var(--accent);letter-spacing:1px;text-transform:uppercase;margin-bottom:14px;}
        .mod-title{font-family:'Outfit',sans-serif;font-size:17px;font-weight:700;margin-bottom:10px;}
        .mod-desc{font-size:13px;color:rgba(255,255,255,0.42);line-height:1.65;}

        /* CTA SECTION */
        .cta-section{padding:90px 24px;text-align:center;position:relative;overflow:hidden;background:linear-gradient(180deg,var(--bg) 0%,#0d0616 50%,var(--bg) 100%);}
        .cta-section::before{content:'';position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:700px;height:350px;background:radial-gradient(ellipse,var(--glow) 0%,transparent 70%);filter:blur(60px);}
        .cta-h{font-family:'Outfit',sans-serif;font-size:clamp(30px,4vw,54px);font-weight:900;letter-spacing:-1.8px;line-height:1.1;margin-bottom:18px;position:relative;}
        .cta-sub{font-size:16px;color:rgba(255,255,255,0.42);max-width:480px;margin:0 auto 36px;line-height:1.65;position:relative;}
        .cta-row{display:flex;justify-content:center;gap:14px;flex-wrap:wrap;position:relative;}

        /* Breadcrumb */
        .breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(255,255,255,0.35);margin-bottom:20px;font-family:'Inter',sans-serif;}
        .breadcrumb a{color:rgba(255,255,255,0.35);text-decoration:none;transition:color .2s;}
        .breadcrumb a:hover{color:var(--accent);}
        .breadcrumb span{color:rgba(255,255,255,0.15);}

        /* Reveal */
        .reveal{opacity:0;transform:translateY(32px);transition:all .65s cubic-bezier(.23,1,.32,1);}
        .reveal.visible{opacity:1;transform:translateY(0);}
        .d1{transition-delay:.1s;}.d2{transition-delay:.2s;}.d3{transition-delay:.3s;}

        /* WhatsApp */
        .wa-float{position:fixed;bottom:28px;right:28px;z-index:9999;display:flex;align-items:center;gap:10px;text-decoration:none;}
        .wa-pill{background:#059669;color:#fff;font-family:'Outfit',sans-serif;font-weight:700;font-size:13px;padding:9px 18px;border-radius:100px;box-shadow:0 4px 20px rgba(5,150,105,.5);display:flex;align-items:center;gap:8px;transition:all .25s ease;}
        .wa-float:hover .wa-pill{transform:scale(1.04);}
        .wa-circle{width:50px;height:50px;border-radius:50%;background:#059669;color:#fff;display:flex;align-items:center;justify-content:center;box-shadow:0 0 0 8px rgba(5,150,105,.18),0 4px 20px rgba(5,150,105,.5);position:relative;animation:wap 2.5s infinite;}
        @keyframes wap{0%,100%{box-shadow:0 0 0 8px rgba(5,150,105,.18);}50%{box-shadow:0 0 0 16px rgba(5,150,105,.06);}}
        .wa-dot{position:absolute;top:4px;right:4px;width:10px;height:10px;border-radius:50%;background:#ef4444;border:2px solid #070810;}

        @media(max-width:900px){
            .ind-hero-inner{grid-template-columns:1fr;}
            .ind-emoji-orb{display:none;}
            .steps-grid{grid-template-columns:1fr;}
            .calls-grid{grid-template-columns:1fr;}
            .modules-grid{grid-template-columns:1fr;}
            .stats-row{grid-template-columns:repeat(2,1fr);}
        }
        @media(max-width:600px){
            .stats-row{grid-template-columns:repeat(2,1fr);}
            .cta-row{flex-direction:column;align-items:center;}
        }
    </style>
</head>
<body>
<?php include '../header.php'; ?>

<!-- ══ HERO ══ -->
<section class="ind-hero">
    <div class="grid-bg"></div>
    <div class="ind-hero-inner">
        <div>
            <div class="breadcrumb">
                <a href="../index.php">Home</a>
                <span>/</span>
                <a href="index.php">Industries</a>
                <span>/</span>
                <span style="color:rgba(255,255,255,0.6);"><?php echo $title; ?></span>
            </div>
            <div class="ind-badge"><div class="ind-badge-dot"></div><?php echo $badge; ?></div>
            <h1 class="ind-title">
                Black Hat SEO for<br>
                <span class="accent"><?php echo $title; ?></span>
            </h1>
            <p class="ind-tagline"><?php echo $tagline; ?></p>
            <div class="ind-cta-row">
                <a href="../register.php" class="btn-accent">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Enroll Now
                </a>
                <a href="https://wa.me/918920624649?text=Hi, I want to learn <?php echo urlencode($title); ?> call generation" target="_blank" class="btn-ghost">
                    💬 WhatsApp Us
                </a>
            </div>
        </div>
        <div class="ind-emoji-orb"><?php echo $emoji; ?></div>
    </div>
</section>

<!-- ══ MARQUEE ══ -->
<?php if (!empty($keywords)): ?>
<div class="mq-strip">
    <div class="mq-track">
        <?php
        $all = array_merge($keywords, $keywords);
        foreach ($all as $kw):
        ?><span class="mq-item"><span class="mq-sep">⚡</span><?php echo $kw; ?></span><?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ══ STATS ══ -->
<?php if (!empty($stats)): ?>
<div class="stats-row reveal">
    <?php foreach ($stats as $s): ?>
    <div class="stat-box reveal">
        <div class="stat-num"><?php echo $s[0]; ?></div>
        <div class="stat-lbl"><?php echo $s[1]; ?></div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- ══ HOW IT WORKS ══ -->
<?php if (!empty($steps)): ?>
<div class="sec">
    <div class="reveal">
        <span class="sec-label">The Strategy</span>
        <h2 class="sec-h2">How We Dominate <span style="color:var(--accent);"><?php echo $title; ?></span> SERPs</h2>
        <p class="sec-p">A battle-tested 3-step playbook for generating consistent, high-intent inbound calls in this vertical.</p>
    </div>
    <div class="steps-grid">
        <?php foreach ($steps as $i => $s): ?>
        <div class="step-card reveal d<?php echo min($i+1,3); ?>">
            <div class="step-num">STEP <?php printf('%02d', $i+1); ?></div>
            <div class="step-icon"><?php echo $s[0]; ?></div>
            <div class="step-title"><?php echo $s[1]; ?></div>
            <div class="step-desc"><?php echo $s[2]; ?></div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ══ CALL TYPES ══ -->
<?php if (!empty($calls)): ?>
<div class="sec" style="padding-top:0;">
    <div class="reveal">
        <span class="sec-label">Call Types</span>
        <h2 class="sec-h2">Types of Calls You'll <span style="color:var(--accent);">Generate Daily</span></h2>
        <p class="sec-p">Ultra-high-intent queries that convert callers into paying customers immediately.</p>
    </div>
    <div class="calls-grid">
        <?php foreach ($calls as $i => $call): ?>
        <div class="call-chip reveal d<?php echo ($i % 2 + 1); ?>">
            <div class="call-chip-icon"><?php echo $call[0]; ?></div>
            <div>
                <div class="call-chip-title"><?php echo $call[1]; ?></div>
                <div class="call-chip-sub"><?php echo $call[2]; ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ══ MODULES ══ -->
<?php if (!empty($modules)): ?>
<section class="modules-bg">
    <div style="max-width:1100px;margin:0 auto;">
        <div class="reveal" style="margin-bottom:44px;">
            <span class="sec-label" style="display:block;">Course Modules</span>
            <h2 class="sec-h2">Industry-Specific <span style="color:var(--accent);">Training Modules</span></h2>
            <p class="sec-p">Dedicated curriculum designed specifically for <?php echo $title; ?> call generation.</p>
        </div>
        <div class="modules-grid">
            <?php foreach ($modules as $i => $m): ?>
            <div class="mod-card reveal d<?php echo ($i % 2 + 1); ?>">
                <div class="mod-badge"><?php echo $m[0]; ?></div>
                <div class="mod-title"><?php echo $m[1]; ?></div>
                <div class="mod-desc"><?php echo $m[2]; ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ══ CTA ══ -->
<section class="cta-section reveal">
    <h2 class="cta-h">Start Generating <span style="color:var(--accent);"><?php echo $title; ?> Calls</span> Today</h2>
    <p class="cta-sub">Join 18,640+ students who have already taken control of their inbound call flow using BlackHat SEO techniques.</p>
    <div class="cta-row">
        <a href="../register.php" class="btn-accent" style="font-size:15px;padding:15px 36px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Enroll in <?php echo $title; ?> Course
        </a>
        <a href="../contact.php" class="btn-ghost" style="font-size:15px;padding:14px 28px;">Contact Suresh Das →</a>
    </div>
</section>

<!-- WhatsApp -->
<a href="https://wa.me/918920624649?text=Hi, I want to learn <?php echo urlencode($title); ?> Black Hat SEO" target="_blank" class="wa-float">
    <div class="wa-pill">
        <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
        WhatsApp
    </div>
    <div class="wa-circle">
        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
        <div class="wa-dot"></div>
    </div>
</a>

<?php include '../footer.php'; ?>

<script>
const obs = new IntersectionObserver(entries => {
    entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('visible'); obs.unobserve(e.target); }});
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
</script>
</body>
</html>
<?php
}
