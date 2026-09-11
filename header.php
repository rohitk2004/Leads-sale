<?php require_once __DIR__ . '/config.php'; ?>
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
<div class="scroll-progress"></div>
<header class="site-header">
  <div class="container nav-wrap">
    <a href="#home" class="logo"><?= htmlspecialchars($site_name) ?></a>
    <nav class="nav">
      <a href="#home">Home</a>
      <a href="#services">Services</a>
      <a href="#projects">Projects</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
    </nav>
    <button class="nav-toggle" aria-label="Toggle menu">☰</button>
  </div>
</header>
<main>
