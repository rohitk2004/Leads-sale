<?php
require_once __DIR__ . '/header.php';

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
?>

<section class="page-header container">
  <h1>Contact</h1>
  <p>Have a project in mind or just want to say hi? Fill out the form below.</p>
</section>

<section class="contact-content container reveal">
  <div class="contact-grid">
    <div class="contact-info">
      <p><strong>Email:</strong> <?= htmlspecialchars($site_email) ?></p>
      <p><strong>Phone:</strong> <?= htmlspecialchars($site_phone) ?></p>
      <p><strong>Location:</strong> <?= htmlspecialchars($site_location) ?></p>
    </div>
    <form class="contact-form" method="post" novalidate>
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
