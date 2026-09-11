<?php require_once __DIR__ . '/header.php';

$projects = [
    ['title' => 'Project Title One',   'desc' => 'Placeholder description of what this project does, the tech used, and the outcome.', 'tags' => ['PHP', 'MySQL']],
    ['title' => 'Project Title Two',   'desc' => 'Placeholder description of what this project does, the tech used, and the outcome.', 'tags' => ['JavaScript', 'CSS']],
    ['title' => 'Project Title Three', 'desc' => 'Placeholder description of what this project does, the tech used, and the outcome.', 'tags' => ['HTML', 'PHP']],
    ['title' => 'Project Title Four',  'desc' => 'Placeholder description of what this project does, the tech used, and the outcome.', 'tags' => ['JavaScript']],
];
?>

<section class="page-header container">
  <h1>Projects</h1>
  <p>A placeholder list — replace with your real work, links, and screenshots.</p>
</section>

<section class="project-grid container reveal">
  <?php foreach ($projects as $p): ?>
  <div class="project-card tilt">
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

<?php require_once __DIR__ . '/footer.php'; ?>
