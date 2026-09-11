<?php require_once __DIR__ . '/header.php';

$projects = [
    ['title' => 'Automated Lead Routing Platform', 'desc' => 'Custom web tool that filters, stores, and automatically routes incoming inquiries directly to spreadsheets and CRM destinations in real time.', 'tags' => ['PHP', 'API Integration']],
    ['title' => 'Web Automation & Scraping Tools', 'desc' => 'Python scripts using Selenium/Playwright for bulk data extraction and task automation, reducing manual labor by 80%.', 'tags' => ['Python', 'Selenium', 'Playwright']],
    ['title' => 'SEO Automation Tools', 'desc' => 'An auto backlinks creator and content publisher built to distribute posts across high DA/PA websites.', 'tags' => ['Python', 'SEO']],
    ['title' => '45+ Freelance Websites', 'desc' => 'Delivered 45+ WordPress and PHP websites for independent clients across varied industries, applying advanced technical SEO across competitive niches like Airlines and Tech Products.', 'tags' => ['WordPress', 'PHP', 'SEO']],
];

$results = [
    ['client' => 'Ele Jungle Elephant Safari', 'sector' => 'Travel / Tourism', 'keywords' => 'Elephant Ride In Amer (#1), Amer Fort Elephant Ride (#1), elephant ride in amer fort (#1), Amer fort elephant ride price (#1), amer fort elephant ride cost (#1), Rajasthan Heritage Tour Packages (#1)'],
    ['client' => 'Gully Baba', 'sector' => 'Education', 'keywords' => 'IGNOU Solved Assignments (#1), Buy IGNOU BA Projects Online (#1), Buy IGNOU Solved Assignments Online (#1), Buy IGNOU Help Books Online (#1), Buy IGNOU Handwritten Assignments Online (#1)'],
    ['client' => 'The Wall Street School', 'sector' => 'Finance Education', 'keywords' => 'Frm Online Classes (#1), Acca Coaching Near Me (#2), Cpa Certification Classes (#2), Frm Coaching Classes (#1), Stock Market Wizard Course (#1), Cima Courses Near Me (#1), Accounting Cpa Classes (#1)'],
];
?>

<section class="page-header container">
  <h1>Projects</h1>
  <p>Tools, platforms, and client results from 3+ years in SEO and web development.</p>
</section>

<section class="project-grid container reveal">
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
</section>

<section class="results container reveal">
  <h2>Client SEO Results</h2>
  <p class="section-sub">Google search ranking positions achieved for top-performing clients, tracked keyword by keyword.</p>
  <div class="results-list">
    <?php foreach ($results as $r): ?>
    <div class="result-card">
      <h3><?= htmlspecialchars($r['client']) ?> <span class="sector"><?= htmlspecialchars($r['sector']) ?></span></h3>
      <p><?= htmlspecialchars($r['keywords']) ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>
