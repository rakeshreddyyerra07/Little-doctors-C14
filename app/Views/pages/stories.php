<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('partials/site_header') ?>

<section class="page-hero">
  <div class="wrap">
    <h1>What our <span class="accent">Little Doctors</span> say</h1>
    <p>Stories from the kids who have joined us.</p>
  </div>
</section>

<section class="testimonials" id="stories">
  <div class="wrap">
    <div class="test-grid">

      <?php if (empty($testimonials)): ?>
        <p class="empty">Stories are coming soon.</p>
      <?php else: foreach ($testimonials as $t): ?>
        <div class="test-card">
          <div class="stars"><?= str_repeat('★', max(1, min(5, (int) $t['rating']))) ?></div>
          <p>"<?= esc($t['message']) ?>"</p>
          <div class="test-who">
            <?php if (! empty($t['photo'])): ?>
              <img class="t-photo" src="<?= base_url($t['photo']) ?>" alt="<?= esc($t['name']) ?>">
            <?php endif; ?>
            <?= esc($t['name']) ?><?= ! empty($t['designation']) ? ', ' . esc($t['designation']) : '' ?>
          </div>
        </div>
      <?php endforeach; endif; ?>

    </div>
  </div>
</section>

<?= $this->include('partials/site_footer') ?>

<?= $this->endSection() ?>