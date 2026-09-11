<?php require_once __DIR__ . '/header.php'; ?>

<section class="hero">
  <canvas id="hero-canvas"></canvas>
  <div class="container hero-inner">
    <div class="hero-text reveal">
      <p class="eyebrow">Hi, I'm</p>
      <h1><?= htmlspecialchars($site_name) ?></h1>
      <p class="tagline"><?= htmlspecialchars($site_tagline) ?></p>
      <p class="hero-desc">Placeholder intro paragraph — write a couple of sentences about what you do, who you help, and what makes your work stand out.</p>
      <div class="hero-actions">
        <a href="projects.php" class="btn btn-primary">View Projects</a>
        <a href="assets/resume.pdf" class="btn btn-outline" download>Download Resume</a>
      </div>
    </div>
    <div class="hero-image reveal">
      <div class="avatar-ring">
        <div class="avatar-placeholder">Photo</div>
      </div>
    </div>
  </div>
</section>

<section class="skills container reveal">
  <h2>Skills</h2>
  <div class="skills-grid">
    <div class="skill-card tilt">HTML / CSS</div>
    <div class="skill-card tilt">JavaScript</div>
    <div class="skill-card tilt">PHP</div>
    <div class="skill-card tilt">MySQL</div>
    <div class="skill-card tilt">Git</div>
    <div class="skill-card tilt">UI Design</div>
  </div>
</section>

<section class="featured container reveal">
  <div class="section-heading">
    <h2>Featured Projects</h2>
    <a href="projects.php" class="see-all">See all &rarr;</a>
  </div>
  <div class="project-grid">
    <div class="project-card tilt">
      <div class="project-thumb">Project 1</div>
      <h3>Project Title One</h3>
      <p>Short placeholder description of what this project does and the problem it solves.</p>
    </div>
    <div class="project-card tilt">
      <div class="project-thumb">Project 2</div>
      <h3>Project Title Two</h3>
      <p>Short placeholder description of what this project does and the problem it solves.</p>
    </div>
    <div class="project-card tilt">
      <div class="project-thumb">Project 3</div>
      <h3>Project Title Three</h3>
      <p>Short placeholder description of what this project does and the problem it solves.</p>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>
