<?php
helper('format');

$testimonials = [];
$err          = '';

try {
    $testimonials = active_rows('testimonials', 3);
} catch (\Throwable $e) {
    $err = $e->getMessage();
}
?>
<!-- stories: <?= count($testimonials) ?> rows<?= $err ? ' | ERROR: ' . str_replace('--', '- -', esc($err)) : '' ?> -->
<section class="testimonials" id="stories">

  <div class="wrap">

    <div class="pillars-head">
      <h2>What our Little Doctors say</h2>
    </div>

    <div class="test-grid">

      <?php foreach ($testimonials as $t): ?>
        <div class="test-card">
          <div class="stars"><?= str_repeat('★', max(1, min(5, (int) ($t['rating'] ?? 5)))) ?></div>
          <p>"<?= esc($t['message'] ?? '') ?>"</p>
          <div class="test-who">
            <?php if (! empty($t['photo'])): ?>
              <img class="t-photo" src="<?= base_url($t['photo']) ?>" alt="<?= esc($t['name'] ?? '') ?>">
            <?php endif; ?>
            <?= esc($t['name'] ?? '') ?><?= ! empty($t['designation']) ? ', ' . esc($t['designation']) : '' ?>
          </div>
        </div>
      <?php endforeach; ?>

    </div>

  </div>

</section>