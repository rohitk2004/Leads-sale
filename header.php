<?php require_once __DIR__ . '/config.php';
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($site_name) ?> — <?= htmlspecialchars($site_tagline) ?></title>
<link rel="stylesheet" href="assets/css/style.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js" defer></script>
</head>
<body>
<header class="site-header">
  <div class="container nav-wrap">
    <a href="index.php" class="logo"><?= htmlspecialchars($site_name) ?></a>
    <nav class="nav">
      <a href="index.php" class="<?= $current === 'index.php' ? 'active' : '' ?>">Home</a>
      <a href="about.php" class="<?= $current === 'about.php' ? 'active' : '' ?>">About</a>
      <a href="projects.php" class="<?= $current === 'projects.php' ? 'active' : '' ?>">Projects</a>
      <a href="contact.php" class="<?= $current === 'contact.php' ? 'active' : '' ?>">Contact</a>
    </nav>
    <button class="nav-toggle" aria-label="Toggle menu">☰</button>
  </div>
</header>
<main>
