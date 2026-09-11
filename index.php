<?php require_once __DIR__ . '/header.php'; ?>

<section class="hero">
  <canvas id="hero-canvas"></canvas>
  <div class="container hero-inner">
    <div class="hero-text reveal">
      <p class="eyebrow">Hi, I'm</p>
      <h1><?= htmlspecialchars($site_name) ?></h1>
      <p class="tagline"><?= htmlspecialchars($site_tagline) ?></p>
      <p class="hero-desc">Result-driven Digital Marketing &amp; SEO Specialist with 3+ years scaling organic search visibility, running high-performing Meta/Google Ad campaigns, and staying ahead of the AI-search shift through AEO, GEO &amp; AI Overview Optimization. I also build custom automation tools that power SEO workflows and lead generation.</p>
      <div class="hero-actions">
        <a href="projects.php" class="btn btn-primary">View Projects</a>
        <a href="assets/resume.pdf" class="btn btn-outline" download>Download Resume &rarr;</a>
      </div>
    </div>
  </div>
</section>

<section class="skills container reveal">
  <h2>Skills</h2>
  <div class="skills-grid">
    <div class="skill-card">Technical &amp; On-Page SEO</div>
    <div class="skill-card">Meta &amp; Google Ads</div>
    <div class="skill-card">AEO / GEO / AIO</div>
    <div class="skill-card">Local SEO &amp; CRO</div>
    <div class="skill-card">PHP &amp; WordPress</div>
    <div class="skill-card">Python Automation</div>
    <div class="skill-card">GA4 &amp; Search Console</div>
    <div class="skill-card">Ahrefs &amp; SEMrush</div>
  </div>
</section>

<section class="featured container reveal">
  <div class="section-heading">
    <h2>Featured Projects</h2>
    <a href="projects.php" class="see-all">See all &rarr;</a>
  </div>
  <div class="project-grid">
    <div class="project-card">
      <div class="project-thumb">Lead Routing</div>
      <h3>Automated Lead Routing Platform</h3>
      <p>Custom web tool that filters, stores, and automatically routes incoming inquiries directly to spreadsheets and CRM destinations in real time.</p>
    </div>
    <div class="project-card">
      <div class="project-thumb">Automation</div>
      <h3>Web Automation &amp; Scraping Tools</h3>
      <p>Python scripts (Selenium/Playwright) for bulk data extraction and task automation, cutting manual labor by 80%.</p>
    </div>
    <div class="project-card">
      <div class="project-thumb">SEO Tools</div>
      <h3>SEO Automation Tools</h3>
      <p>An auto backlinks creator and content publisher built to distribute posts across high DA/PA websites.</p>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>
