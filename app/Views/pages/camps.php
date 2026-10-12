<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('partials/site_header') ?>

<section class="page-hero">
  <div class="wrap">
    <h1>Find your next Little Doctors <span class="accent">adventure</span></h1>
    <p>Camps and workshops where learning about the body is hands-on and fun.</p>
  </div>
</section>

<section class="camps" id="camps">
  <div class="wrap">
    <div class="camp-grid">

      <?php if (empty($camps)): ?>
        <p class="empty">No camps are listed right now. Please check back soon.</p>
      <?php else: foreach ($camps as $c): ?>
        <div class="camp-card" id="<?= esc($c['slug']) ?>">

          <div class="camp-photo">
            <?php if (! empty($c['image'])): ?>
              <img src="<?= base_url($c['image']) ?>" alt="<?= esc($c['title']) ?>">
            <?php endif; ?>
            <?php if (! empty($c['tag'])): ?><span class="camp-tag"><?= esc($c['tag']) ?></span><?php endif; ?>
          </div>

          <div class="camp-body">
            <h4><?= esc($c['title']) ?></h4>
            <?php if (! empty($c['short_description'])): ?><p><?= esc($c['short_description']) ?></p><?php endif; ?>
            <div class="camp-meta">
              <?php if (! empty($c['start_date'])): ?><span>📅 <?= esc(format_date_range($c['start_date'], $c['end_date'])) ?></span><?php endif; ?>
              <?php if (! empty($c['location'])): ?><span>📍 <?= esc($c['location']) ?></span><?php endif; ?>
              <?php if (! empty($c['age_group'])): ?><span>👤 Ages <?= esc($c['age_group']) ?></span><?php endif; ?>
            </div>
            <a class="btn btn-solid" href="<?= base_url('enroll') ?>">Enroll →</a>
          </div>

        </div>
      <?php endforeach; endif; ?>

    </div>
  </div>
</section>

<?= $this->include('partials/site_footer') ?>

<?= $this->endSection() ?>