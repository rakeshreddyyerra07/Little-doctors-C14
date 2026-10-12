<?php
helper('format');

try {
    $camps = (new \App\Models\CampModel())
        ->where('is_active', 1)->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->findAll(3);
} catch (\Throwable $e) {
    $camps = [];
}
?>
<section class="camps" id="camps">

  <div class="wrap">

    <div class="section-head">
      <h2>Find your next Little Doctors adventure</h2>
      <a href="<?= base_url('camps') ?>">View all camps →</a>
    </div>

    <div class="camp-grid">

      <?php foreach ($camps as $c): ?>
        <div class="camp-card">

          <div class="camp-photo">
            <?php if (! empty($c['image'])): ?>
              <img src="<?= base_url($c['image']) ?>" alt="<?= esc($c['title']) ?>">
            <?php endif; ?>
            <?php if (! empty($c['tag'])): ?><span class="camp-tag"><?= esc($c['tag']) ?></span><?php endif; ?>
          </div>

          <div class="camp-body">
            <h4><?= esc($c['title']) ?></h4>
            <div class="camp-meta">
              <?php if (! empty($c['start_date'])): ?><span>📅 <?= esc(format_date_range($c['start_date'], $c['end_date'])) ?></span><?php endif; ?>
              <?php if (! empty($c['location'])): ?><span>📍 <?= esc($c['location']) ?></span><?php endif; ?>
              <?php if (! empty($c['age_group'])): ?><span>👤 Ages <?= esc($c['age_group']) ?></span><?php endif; ?>
            </div>
            <a class="btn btn-solid" href="<?= base_url('camps') . '#' . esc($c['slug']) ?>"><?= esc($c['button_text'] ?: 'Explore Camp →') ?></a>
          </div>

        </div>
      <?php endforeach; ?>

    </div>

    <p class="camps-foot">
      Can't find a camp near you?
      <a href="<?= base_url('contact') ?>">Join the interest list →</a>
    </p>

  </div>

</section>