<?php require_once '../db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Industries | Black Hat SEO Call Generation | BlackHat SEO</title>
    <meta name="description" content="Explore all industry verticals covered in the Black Hat SEO Course — Tech Support, Airlines, Finance, Insurance, Healthcare, Legal, SaaS, Education, Home Services, Crypto, Automotive, and QuickBooks.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@700;800;900&family=Inter:wght@400;500&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <style>
        *{box-sizing:border-box;margin:0;padding:0;}
        body{background:#070810;color:#fff;font-family:'Inter',sans-serif;overflow-x:hidden;}
        .page-hero{padding:140px 24px 80px;text-align:center;position:relative;overflow:hidden;background:radial-gradient(ellipse at 50% -10%,rgba(255,85,0,0.22) 0%,transparent 60%);}
        .page-hero .grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,0.025) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.025) 1px,transparent 1px);background-size:55px 55px;animation:gs 18s linear infinite;}
        @keyframes gs{from{background-position:0 0;}to{background-position:55px 55px;}}
        .lbl{font-family:'JetBrains Mono',monospace;font-size:11px;font-weight:700;color:#ff6b35;text-transform:uppercase;letter-spacing:2px;display:block;margin-bottom:14px;}
        .hero-h1{font-family:'Outfit',sans-serif;font-size:clamp(36px,6vw,72px);font-weight:900;letter-spacing:-2px;line-height:1.05;margin-bottom:16px;position:relative;}
        .hero-sub{font-size:17px;color:rgba(255,255,255,0.45);max-width:560px;margin:0 auto;line-height:1.7;position:relative;}

        .grid-section{padding:60px 24px 100px;max-width:1200px;margin:0 auto;}
        .industry-big-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;}
        .ind-block{
            background:rgba(255,255,255,0.025);border:1px solid rgba(255,255,255,0.07);
            border-radius:22px;padding:32px 24px;text-decoration:none;color:#fff;
            display:flex;flex-direction:column;gap:12px;
            transition:all .3s cubic-bezier(.23,1,.32,1);
            position:relative;overflow:hidden;
        }
        .ind-block::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--c,#ff5500),transparent);opacity:0;transition:opacity .3s;}
        .ind-block:hover{transform:translateY(-8px);border-color:rgba(255,255,255,0.18);box-shadow:0 20px 60px rgba(0,0,0,0.5);color:#fff;}
        .ind-block:hover::before{opacity:1;}
        .ind-icon{font-size:36px;margin-bottom:4px;}
        .ind-name{font-family:'Outfit',sans-serif;font-size:18px;font-weight:800;letter-spacing:-.3px;}
        .ind-desc{font-size:13px;color:rgba(255,255,255,0.38);line-height:1.5;}
        .ind-earn{display:inline-flex;align-items:center;gap:6px;font-family:'JetBrains Mono',monospace;font-size:10px;font-weight:700;padding:4px 12px;border-radius:100px;margin-top:4px;}
        .ind-arrow{font-size:13px;color:rgba(255,255,255,0.25);margin-top:auto;transition:all .25s;transform:translateX(-4px);}
        .ind-block:hover .ind-arrow{color:var(--c,#ff5500);transform:translateX(0);}

        .reveal{opacity:0;transform:translateY(30px);transition:all .6s cubic-bezier(.23,1,.32,1);}
        .reveal.visible{opacity:1;transform:translateY(0);}

        @media(max-width:900px){.industry-big-grid{grid-template-columns:repeat(2,1fr);}}
        @media(max-width:500px){.industry-big-grid{grid-template-columns:1fr;}}
    </style>
</head>
<body>
<?php include '../header.php'; ?>

<section class="page-hero">
    <div class="grid"></div>
    <div style="position:relative;z-index:2;">
        <span class="lbl">All Industries</span>
        <h1 class="hero-h1">Choose Your <span style="color:#ff5500;">Industry Vertical</span></h1>
        <p class="hero-sub">Black Hat SEO blueprints tailored for every high-intent, high-value call generation vertical. Pick yours and dominate your niche.</p>
    </div>
</section>

<div class="grid-section">
    <?php
    $industries = [
        ['tech-support.php','🎧','Tech Support','Printer, antivirus, router & Windows support calls','$12-80/call','#ff5500','rgba(255,85,0,0.15)','rgba(255,85,0,0.3)'],
        ['airlines.php','✈️','Airlines & Travel','Flight booking, cancellation & rebooking calls','$30-120/call','#3b82f6','rgba(59,130,246,0.15)','rgba(59,130,246,0.3)'],
        ['finance.php','💰','Finance & Loans','Debt settlement, mortgage & personal loan calls','$80-400/call','#f59e0b','rgba(245,158,11,0.15)','rgba(245,158,11,0.3)'],
        ['insurance.php','🛡️','Insurance','Auto, health, life & Medicare insurance leads','$40-200/call','#10b981','rgba(16,185,129,0.15)','rgba(16,185,129,0.3)'],
        ['healthcare.php','🏥','Healthcare','Patient acquisition for clinics, dental & rehab','$50-300/call','#06b6d4','rgba(6,182,212,0.15)','rgba(6,182,212,0.3)'],
        ['legal.php','⚖️','Legal & Law Firms','Personal injury, DUI & attorney referral calls','$150-500/call','#8b5cf6','rgba(139,92,246,0.15)','rgba(139,92,246,0.3)'],
        ['saas.php','💻','SaaS & B2B','Enterprise demo requests & software renewal calls','$200-2000/deal','#00f2fe','rgba(0,242,254,0.12)','rgba(0,242,254,0.25)'],
        ['education.php','🎓','Education','Course enrollment, tutoring & admissions leads','$30-150/call','#f59e0b','rgba(245,158,11,0.15)','rgba(245,158,11,0.3)'],
        ['home-services.php','🔧','Home Services','HVAC, plumbing, roofing & electrical service calls','$50-200/call','#ef4444','rgba(239,68,68,0.15)','rgba(239,68,68,0.3)'],
        ['crypto.php','🪙','Cryptocurrency','Wallet recovery, exchange & crypto support calls','$100-500/call','#f59e0b','rgba(245,158,11,0.15)','rgba(245,158,11,0.3)'],
        ['automotive.php','🚗','Automotive','Car dealer, warranty & auto repair inbound calls','$30-200/call','#64748b','rgba(100,116,139,0.15)','rgba(100,116,139,0.3)'],
        ['accounting.php','📊','QuickBooks & Accounting','QuickBooks error, payroll & tax software calls','$50-250/call','#22c55e','rgba(34,197,94,0.15)','rgba(34,197,94,0.3)'],
    ];
    ?>
    <div class="industry-big-grid">
        <?php foreach ($industries as $i => $ind): ?>
        <a href="<?php echo $ind[0]; ?>" class="ind-block reveal" style="--c:<?php echo $ind[6]; ?>;transition-delay:<?php echo ($i % 4) * 0.08; ?>s;">
            <div class="ind-icon"><?php echo $ind[1]; ?></div>
            <div class="ind-name"><?php echo $ind[2]; ?></div>
            <div class="ind-desc"><?php echo $ind[3]; ?></div>
            <div class="ind-earn" style="background:<?php echo $ind[5]; ?>22;border:1px solid <?php echo $ind[5]; ?>44;color:<?php echo $ind[5]; ?>;">
                <span>💰</span><?php echo $ind[4]; ?>
            </div>
            <div class="ind-arrow">Learn the strategy →</div>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<section style="padding:80px 24px;text-align:center;background:rgba(255,255,255,.012);">
    <span class="lbl" style="display:block;margin-bottom:12px;">Not sure which to pick?</span>
    <div style="font-family:'Outfit',sans-serif;font-size:clamp(24px,4vw,40px);font-weight:900;letter-spacing:-1px;margin-bottom:16px;">Talk to Suresh Das<br><span style="color:#ff5500;">Directly</span></div>
    <p style="font-size:15px;color:rgba(255,255,255,.42);max-width:480px;margin:0 auto 32px;line-height:1.65;">Get a free 15-minute consultation to identify the most profitable call generation vertical for your call center.</p>
    <div style="display:flex;justify-content:center;gap:14px;flex-wrap:wrap;">
        <a href="https://wa.me/918920624649" target="_blank" style="background:#059669;color:#fff;font-family:'Outfit',sans-serif;font-weight:700;font-size:14px;padding:14px 30px;border-radius:12px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;box-shadow:0 4px 20px rgba(5,150,105,.4);transition:all .25s ease;">💬 WhatsApp Consultation</a>
        <a href="../contact.php" style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.8);font-family:'Outfit',sans-serif;font-weight:600;font-size:14px;padding:13px 26px;border-radius:12px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .25s ease;">Send a Message →</a>
    </div>
</section>

<?php include '../footer.php'; ?>
<script>
const o = new IntersectionObserver(e=>e.forEach(en=>{if(en.isIntersecting){en.target.classList.add('visible');o.unobserve(en.target);}}),{threshold:.08});
document.querySelectorAll('.reveal').forEach(el=>o.observe(el));
document.querySelectorAll('.ind-block').forEach(card=>{
    card.addEventListener('mousemove',e=>{
        const r=card.getBoundingClientRect(),x=e.clientX-r.left,y=e.clientY-r.top;
        card.style.transform=`perspective(600px) rotateX(${((y-r.height/2)/r.height)*-6}deg) rotateY(${((x-r.width/2)/r.width)*6}deg) translateY(-8px)`;
    });
    card.addEventListener('mouseleave',()=>{ card.style.transform=''; });
});
</script>
</body>
</html>
