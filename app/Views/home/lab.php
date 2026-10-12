<?php
try {
    $courses = (new \App\Models\LearningCourseModel())
        ->where('is_active', 1)->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->findAll();
} catch (\Throwable $e) {
    $courses = [];
}
?>
<section id="lab">

  <div class="wrap">

    <div class="section-head">
      <h2>Little Doctors Learning Lab</h2>
      <a href="<?= base_url('learn') ?>">View all topics →</a>
    </div>

    <div class="lab-grid">

      <?php foreach ($courses as $c): ?>
        <div class="lab-card">
          <div class="ic" style="background:<?= esc($c['bg_color'] ?: '#e7effb') ?>">
            <span style="font-size:28px;line-height:1;"><?= esc($c['icon'] ?: '🩺') ?></span>
          </div>
          <h4><?= esc($c['title']) ?></h4>
          <p><?= esc($c['short_description']) ?></p>
          <a class="go" style="color:<?= esc($c['accent_color'] ?: 'var(--navy)') ?>"
             href="<?= base_url('learn') . '#' . esc($c['slug']) ?>">Explore →</a>
        </div>
      <?php endforeach; ?>

    </div>

  </div>

</section>