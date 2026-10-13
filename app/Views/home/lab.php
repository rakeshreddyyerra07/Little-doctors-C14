<?php
helper('format');

$courses = [];
$err     = '';

try {
    $courses = active_rows('learning_courses');
} catch (\Throwable $e) {
    $err = $e->getMessage();
}
?>
<!-- lab: <?= count($courses) ?> rows<?= $err ? ' | ERROR: ' . str_replace('--', '- -', esc($err)) : '' ?> -->
<style>
    .lab-card .lab-img { display:block; width:96px; height:96px; object-fit:contain; margin:0 auto 10px; }
</style>

<section id="lab">

  <div class="wrap">

    <div class="section-head">
      <h2>Little Doctors Learning Lab</h2>
      <a href="<?= base_url('learn') ?>">View all topics →</a>
    </div>

    <div class="lab-grid">

      <?php foreach ($courses as $c): ?>
        <div class="lab-card">

          <?php if (! empty($c['image'])): ?>
            <img class="lab-img" src="<?= base_url($c['image']) ?>" alt="<?= esc($c['title'] ?? '') ?>">
          <?php else: ?>
            <div class="ic" style="background:<?= esc(($c['bg_color'] ?? '') ?: '#e7effb') ?>">
              <span style="font-size:28px;line-height:1;"><?= esc(($c['icon'] ?? '') ?: '🩺') ?></span>
            </div>
          <?php endif; ?>

          <h4><?= esc($c['title'] ?? '') ?></h4>
          <p><?= esc($c['short_description'] ?? '') ?></p>
          <a class="go" style="color:<?= esc(($c['accent_color'] ?? '') ?: 'var(--navy)') ?>"
             href="<?= base_url('learn') . '#' . esc($c['slug'] ?? '') ?>">Explore →</a>
        </div>
      <?php endforeach; ?>

    </div>

  </div>

</section>