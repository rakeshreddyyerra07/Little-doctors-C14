<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('partials/site_header') ?>

<section class="page-hero">
  <div class="wrap">
    <h1>Little Doctors <span class="accent">Learning Lab</span></h1>
    <p>Explore the human body, one amazing system at a time.</p>
  </div>
</section>

<section id="lab">
  <div class="wrap">
    <div class="lab-grid">

      <?php if (empty($courses)): ?>
        <p class="empty">New topics are coming soon.</p>
      <?php else: foreach ($courses as $c): ?>
        <div class="lab-card" id="<?= esc($c['slug']) ?>">
          <div class="ic" style="background:<?= esc($c['bg_color'] ?: '#e7effb') ?>">
            <span style="font-size:28px;line-height:1;"><?= esc($c['icon'] ?: '🩺') ?></span>
          </div>
          <h4><?= esc($c['title']) ?></h4>
          <p><?= esc($c['short_description']) ?></p>

          <?php if (! empty($c['content'])): ?>
            <details class="more">
              <summary class="go" style="color:<?= esc($c['accent_color'] ?: 'var(--navy)') ?>">Read more →</summary>
              <div class="more-body"><?= nl2br(esc($c['content'])) ?></div>
            </details>
          <?php endif; ?>
        </div>
      <?php endforeach; endif; ?>

    </div>
  </div>
</section>

<?= $this->include('partials/site_footer') ?>

<?= $this->endSection() ?>