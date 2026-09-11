<?php
require_once __DIR__ . '/config.php';

$sent = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $message === '') {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        // Placeholder: wire this up to mail() or an API later.
        $sent = true;
    }
}

require_once __DIR__ . '/header.php';

$projects = [
    ['title' => 'Automated Lead Routing Platform', 'desc' => 'Custom web tool that filters, stores, and automatically routes incoming inquiries directly to spreadsheets and CRM destinations in real time.', 'tags' => ['PHP', 'API Integration']],
    ['title' => 'Web Automation & Scraping Tools', 'desc' => 'Python scripts using Selenium/Playwright for bulk data extraction and task automation, reducing manual labor by 80%.', 'tags' => ['Python', 'Selenium', 'Playwright']],
    ['title' => 'SEO Automation Tools', 'desc' => 'An auto backlinks creator and content publisher built to distribute posts across high DA/PA websites.', 'tags' => ['Python', 'SEO']],
    ['title' => '45+ Freelance Websites', 'desc' => 'Delivered 45+ WordPress and PHP websites for independent clients across varied industries, applying advanced technical SEO across competitive niches like Airlines and Tech Products.', 'tags' => ['WordPress', 'PHP', 'SEO']],
];

$seo_clients = [
    ['name' => 'Culture Circle', 'keywords' => [
        ['Best sneakers under 10000', 2], ['sneakers under 10000', 5], ['Buy cheap sneakers', 2], ['buy nike sneakers', 2], ['yzy sneakers', 2],
    ]],
    ['name' => 'Bakersoven.in', 'keywords' => [
        ['1st birthday cakes', 2], ['Lotus Biscoff Theme Cake', 2], ['Roasted Almond Cake', 1], ['Phone Cake', 2], ['Little Singham Cake', 3], ['Blackpink Cake', 2], ['brothers day 2026', 3],
    ]],
    ['name' => 'fns.co.in', 'keywords' => [
        ['Cutlery set with stand', 2], ['18 Piece Cutlery Set', 1], ['Cutlery Set 24 Piece', 2], ['Fruit Fork Set', 2], ['Serving Spoon', 2], ['Bar Tools Set Silver', 1], ['Water Pitcher', 2],
    ]],
    ['name' => 'Ele Jungle Elephant Safari', 'keywords' => [
        ['Elephant Ride In Amer', 1], ['Amer Fort Elephant Ride', 1], ['elephant ride in amer fort', 1], ['Amer fort elephant ride price', 1], ['amer fort elephant ride cost', 1], ['Rajasthan Heritage Tour Packages', 1],
    ]],
    ['name' => 'Gully Baba', 'keywords' => [
        ['IGNOU Solved Assignments', 1], ['Buy IGNOU BA Projects Online', 1], ['Buy IGNOU Solved Assignments Online', 1], ['Buy IGNOU Help Books Online', 1], ['Buy IGNOU Handwritten Assignments Online', 1],
    ]],
    ['name' => 'The WallStreet School', 'keywords' => [
        ['Frm Online Classes', 1], ['Acca Coaching Near Me', 2], ['Cpa Certification Classes', 2], ['Frm Coaching Classes', 1], ['Stock Market Wizard Course', 1], ['Cima Courses Near Me', 1], ['Accounting Cpa Classes', 1],
    ]],
    ['name' => 'Crystal India Holidays', 'keywords' => [
        ['Golden Triangle Tour India', 3], ['Best Golden Triangle Tour Operator', 3], ['Golden Triangle Tour 5 Nights 6 Days', 3], ['4 Days Golden Triangle Tour from Delhi', 3],
    ]],
    ['name' => 'KidsCity.com', 'keywords' => [
        ['Buy baby milk formula advanced', 2], ['baby milk formula infant formula', 2], ['Buy goat milk formula', 1], ['Buy enfamil milk formula', 1], ['Buy Aptamil Infant Formula Online', 1], ['buy Hipp Organic Baby Milk Online', 1],
    ]],
    ['name' => 'Garg Water Proofing', 'keywords' => [
        ['waterproofing consultant service in Delhi', 1], ['Waterproofing Agency India', 2], ['Waterproofing Services In India', 2], ['Waterproofing Services In Westend Colony', 1], ['Waterproofing Contractors', 2],
    ]],
    ['name' => '3D Paradise', 'keywords' => [
        ['3D printing service in Delhi', 1], ['3D Printing in Delhi', 1], ['3D Printing Service Delhi', 1], ['Best 3D printing in Delhi', 1], ['Best 3D printing service', 1],
    ]],
    ['name' => 'Kookee.in', 'keywords' => [
        ['Best Bathroom Accessories Set', 2], ['Buy Acrylic Bathroom Sets', 3], ['Buy Best Acrylic Bathroom Sets Online', 1], ['Buy Ceramic Bathroom Sets', 1], ['Buy Toilet Brush Holder For Bathroom', 1], ['Buy Glass Bathroom Sets Online', 1],
    ]],
    ['name' => 'INIFT.com', 'keywords' => [
        ['Fashion Designing Institute In Kolkata', 1], ['Fashion Designing Course In Kolkata', 1], ['Fashion Design Institute In Kolkata', 1], ['Interior Design Course In Kolkata', 2], ['Interior Design Institute In Kolkata', 2], ['Interior Designer Courses In Kolkata', 2],
    ]],
    ['name' => 'Charbhuja', 'keywords' => [
        ['Marble Dealers In Delhi', 3], ['Marble Suppliers In Delhi', 4], ['Imported Marble In Delhi', 4], ['Italian Marble Delhi', 4], ['Black Italian Marble in Delhi', 3],
    ]],
    ['name' => 'Anupam Sink', 'keywords' => [
        ['Buy Steel Sink For Kitchen', 2], ['Single Bowl Stainless Steel Sink', 2], ['Best Single Bowl Kitchen Sink', 2], ['Single Bowl Kitchen Sink', 2], ['Stainless Steel Double Sink', 2],
    ]],
];
?>

<section id="home" class="hero">
  <canvas id="hero-canvas"></canvas>
  <div class="container hero-inner">
    <div class="hero-text reveal">
      <p class="eyebrow">Hi, I'm</p>
      <h1><?= htmlspecialchars($site_name) ?></h1>
      <p class="tagline"><?= htmlspecialchars($site_tagline) ?></p>
      <p class="hero-desc">Result-driven Digital Marketing &amp; SEO Specialist with 3+ years scaling organic search visibility, running high-performing Meta/Google Ad campaigns, and staying ahead of the AI-search shift through AEO, GEO &amp; AI Overview Optimization. I also build custom automation tools that power SEO workflows and lead generation.</p>
      <div class="hero-actions">
        <a href="#projects" class="btn btn-primary">View Projects</a>
        <a href="assets/resume.pdf" class="btn btn-outline" download>Download Resume &rarr;</a>
      </div>
      <div class="mini-stats">
        <div><strong>3+</strong><span>Years Experience</span></div>
        <div><strong>45+</strong><span>Sites Delivered</span></div>
        <div><strong>#1</strong><span>Google Rankings</span></div>
      </div>
    </div>

    <div class="hero-visual reveal">
      <span class="floating-badge badge-a">⚡ AEO / GEO Ready</span>
      <span class="floating-badge badge-b">✓ Google Certified</span>
      <div class="browser-mock">
        <div class="browser-bar">
          <span></span><span></span><span></span>
        </div>
        <div class="browser-body">
          <p class="chart-label">Organic Traffic <span>&uarr; 50%+</span></p>
          <div class="chart-bars">
            <i style="--h:28%"></i>
            <i style="--h:38%"></i>
            <i style="--h:34%"></i>
            <i style="--h:52%"></i>
            <i style="--h:48%"></i>
            <i style="--h:66%"></i>
            <i style="--h:80%"></i>
            <i style="--h:100%"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="marquee-wrap reveal">
  <div class="marquee">
    <div class="marquee-track">
      <span>Razor Infotech</span><span>Traffic Tail</span><span>Ele Jungle Elephant Safari</span><span>Gully Baba</span><span>The Wall Street School</span>
      <span>Razor Infotech</span><span>Traffic Tail</span><span>Ele Jungle Elephant Safari</span><span>Gully Baba</span><span>The Wall Street School</span>
    </div>
  </div>
</div>

<section class="stats-bar container reveal">
  <div class="stat-tile"><strong>3+</strong><span>Years of Experience</span></div>
  <div class="stat-tile"><strong>45+</strong><span>Websites Delivered</span></div>
  <div class="stat-tile"><strong>50%+</strong><span>Organic Traffic Growth</span></div>
  <div class="stat-tile"><strong>80%</strong><span>Manual Work Automated</span></div>
</section>

<section id="services" class="services container reveal">
  <h2>How I Bring Results</h2>
  <div class="services-list">
    <div class="service-item active">
      <div class="service-head">
        <span class="service-num">01</span>
        <h3>Technical &amp; On-Page SEO</h3>
        <span class="service-toggle">+</span>
      </div>
      <div class="service-body">
        <p>Full-site audits, speed &amp; crawlability fixes, schema markup, and on-page structure that gets pages ranking and staying there.</p>
      </div>
    </div>
    <div class="service-item">
      <div class="service-head">
        <span class="service-num">02</span>
        <h3>AI Search Optimization</h3>
        <span class="service-toggle">+</span>
      </div>
      <div class="service-body">
        <p>AEO, GEO &amp; AI Overview Optimization — structuring content and schema for visibility across ChatGPT, Perplexity, and Google AI Overviews.</p>
      </div>
    </div>
    <div class="service-item">
      <div class="service-head">
        <span class="service-num">03</span>
        <h3>Paid Media Management</h3>
        <span class="service-toggle">+</span>
      </div>
      <div class="service-body">
        <p>Meta &amp; Google Ads campaign strategy focused on Cost Per Lead efficiency and measurable ROI.</p>
      </div>
    </div>
    <div class="service-item">
      <div class="service-head">
        <span class="service-num">04</span>
        <h3>Web Development &amp; Automation</h3>
        <span class="service-toggle">+</span>
      </div>
      <div class="service-body">
        <p>Responsive PHP &amp; WordPress builds paired with Python automation for scraping, reporting, and workflow efficiency.</p>
      </div>
    </div>
    <div class="service-item">
      <div class="service-head">
        <span class="service-num">05</span>
        <h3>Lead Generation Systems</h3>
        <span class="service-toggle">+</span>
      </div>
      <div class="service-body">
        <p>Custom funnels and automated lead-routing platforms that capture and deliver high-intent leads in real time.</p>
      </div>
    </div>
  </div>
</section>

<section class="skills container reveal">
  <h2>Skills &amp; Tools</h2>
</section>
<div class="marquee-wrap marquee-wrap-alt reveal">
  <div class="marquee">
    <div class="marquee-track">
      <span class="skill-chip">Technical SEO</span><span class="skill-chip">Meta Ads</span><span class="skill-chip">Google Ads</span><span class="skill-chip">AEO / GEO / AIO</span><span class="skill-chip">Local SEO</span><span class="skill-chip">PHP</span><span class="skill-chip">WordPress</span><span class="skill-chip">Python</span><span class="skill-chip">GA4</span><span class="skill-chip">Search Console</span><span class="skill-chip">Ahrefs</span><span class="skill-chip">SEMrush</span>
      <span class="skill-chip">Technical SEO</span><span class="skill-chip">Meta Ads</span><span class="skill-chip">Google Ads</span><span class="skill-chip">AEO / GEO / AIO</span><span class="skill-chip">Local SEO</span><span class="skill-chip">PHP</span><span class="skill-chip">WordPress</span><span class="skill-chip">Python</span><span class="skill-chip">GA4</span><span class="skill-chip">Search Console</span><span class="skill-chip">Ahrefs</span><span class="skill-chip">SEMrush</span>
    </div>
  </div>
</div>

<section id="projects" class="featured container reveal">
  <div class="section-heading">
    <h2>Projects</h2>
  </div>
  <div class="project-grid">
    <?php foreach ($projects as $p): ?>
    <div class="project-card">
      <div class="project-thumb"><?= htmlspecialchars($p['title']) ?></div>
      <h3><?= htmlspecialchars($p['title']) ?></h3>
      <p><?= htmlspecialchars($p['desc']) ?></p>
      <div class="tags">
        <?php foreach ($p['tags'] as $tag): ?>
          <span class="tag"><?= htmlspecialchars($tag) ?></span>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="results container reveal">
  <h2>Client SEO Results</h2>
  <p class="section-sub">Real Google search ranking positions achieved for clients, tracked keyword by keyword.</p>
  <div class="seo-grid">
    <?php foreach ($seo_clients as $c): ?>
    <div class="seo-card">
      <h3>Client: <?= htmlspecialchars($c['name']) ?></h3>
      <table class="seo-table">
        <thead>
          <tr><th>Keyword Search</th><th>Ranking</th></tr>
        </thead>
        <tbody>
          <?php foreach ($c['keywords'] as $k): ?>
          <tr>
            <td><?= htmlspecialchars($k[0]) ?></td>
            <td class="rank<?= $k[1] === 1 ? ' rank-1' : '' ?>">#<?= (int) $k[1] ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="process container reveal">
  <h2>How I Work</h2>
  <div class="process-steps">
    <div class="process-step">
      <span class="process-num">01</span>
      <h3>Audit &amp; Research</h3>
      <p>Deep technical &amp; keyword audit to find what's holding rankings back.</p>
    </div>
    <div class="process-step">
      <span class="process-num">02</span>
      <h3>Strategy</h3>
      <p>A roadmap combining SEO, AI search visibility, and paid acquisition.</p>
    </div>
    <div class="process-step">
      <span class="process-num">03</span>
      <h3>Fix &amp; Build</h3>
      <p>Ship technical fixes, content, and automation tooling.</p>
    </div>
    <div class="process-step">
      <span class="process-num">04</span>
      <h3>Optimize for AI</h3>
      <p>Structure content for AEO/GEO so you show up in AI-driven search.</p>
    </div>
    <div class="process-step">
      <span class="process-num">05</span>
      <h3>Track &amp; Scale</h3>
      <p>Measure with GA4 &amp; Search Console, then double down on what works.</p>
    </div>
  </div>
</section>

<section id="about" class="about-content container reveal">
  <div class="section-heading">
    <h2>About Me</h2>
  </div>
  <div class="about-grid">
    <div class="about-image">
      <img class="avatar-placeholder" src="assets/img/profile.jpg" alt="<?= htmlspecialchars($site_name) ?>">
    </div>
    <div class="about-text">
      <p>Result-driven Digital Marketing &amp; SEO Specialist with 3+ years of experience scaling organic search visibility, running high-performing Meta/Google Ad campaigns, and staying ahead of the AI-search shift through Answer Engine Optimization (AEO), Generative Engine Optimization (GEO), and AI Overview Optimization (AIO).</p>
      <p>Skilled in building custom automation tools to support SEO workflows and lead generation, with a consistent track record of driving clients to top Google rankings and measurable ROI.</p>

      <h2>Experience</h2>
      <ul class="timeline">
        <li>
          <strong>SEO Specialist &amp; AI Developer — Razor Infotech</strong>
          <span class="timeline-date">July 2024 — Present</span>
          <p>Designed and deployed responsive WordPress and PHP sites optimized for high speed and seamless user experience. Formulated local SEO strategies across target regions to capture high-intent leads. Tracked and analyzed user journeys using GA4 and Google Tag Manager to continuously optimize campaign landing pages.</p>
        </li>
        <li>
          <strong>Digital Marketing &amp; Web Development Specialist — Traffic Tail</strong>
          <span class="timeline-date">Feb 2023 — June 2024 · Delhi-SAKET</span>
          <p>Engineered custom lead generation funnels and web platforms, boosting lead capture rates by 35%. Managed high-budget Meta &amp; Google Ad campaigns while maintaining optimal Cost Per Lead (CPL). Developed automated Python scripts to streamline workflow efficiency, data collection, and reporting. Conducted comprehensive SEO audits, resulting in a 50%+ increase in organic traffic.</p>
        </li>
      </ul>

      <h2>Education</h2>
      <ul class="timeline">
        <li>
          <strong>Bachelor of Computer Applications — Jamia Hamdard University</strong>
          <span class="timeline-date">Sept 2024 — Pursuing</span>
        </li>
        <li>
          <strong>BA (Hons) — Delhi University</strong>
          <span class="timeline-date">Sept 2021 — 2023</span>
        </li>
      </ul>

      <h2>Certifications</h2>
      <ul class="timeline">
        <li><strong>Google Search Certification</strong></li>
        <li><strong>Meta Certified Digital Marketing Associate</strong></li>
      </ul>
    </div>
  </div>
</section>

<section class="testimonials container reveal">
  <h2>What Clients Say</h2>
  <p class="section-sub">Placeholder quotes — swap these for real client testimonials.</p>
  <div class="testimonial-track">
    <div class="testimonial-card">
      <p>&ldquo;Placeholder testimonial — replace with a real quote about the results delivered on this project.&rdquo;</p>
      <span class="testimonial-author">Client Name — Company</span>
    </div>
    <div class="testimonial-card">
      <p>&ldquo;Placeholder testimonial — replace with a real quote about turnaround time or communication.&rdquo;</p>
      <span class="testimonial-author">Client Name — Company</span>
    </div>
    <div class="testimonial-card">
      <p>&ldquo;Placeholder testimonial — replace with a real quote about measurable ranking or revenue impact.&rdquo;</p>
      <span class="testimonial-author">Client Name — Company</span>
    </div>
  </div>
  <div class="testimonial-nav">
    <button type="button" class="t-prev" aria-label="Previous">&larr;</button>
    <button type="button" class="t-next" aria-label="Next">&rarr;</button>
  </div>
</section>

<section id="contact" class="contact-content container reveal">
  <div class="section-heading">
    <h2>Contact</h2>
  </div>
  <div class="contact-grid">
    <div class="contact-info">
      <p><strong>Email:</strong> <?= htmlspecialchars($site_email) ?></p>
      <p><strong>Phone:</strong> <?= htmlspecialchars($site_phone) ?></p>
      <p><strong>Location:</strong> <?= htmlspecialchars($site_location) ?></p>
    </div>
    <form class="contact-form" method="post" action="#contact">
      <?php if ($sent): ?>
        <div class="alert alert-success">Thanks! Your message has been received (placeholder — not actually emailed yet).</div>
      <?php elseif ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <label for="name">Name</label>
      <input type="text" id="name" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

      <label for="message">Message</label>
      <textarea id="message" name="message" rows="6" required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>

      <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
  </div>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>
