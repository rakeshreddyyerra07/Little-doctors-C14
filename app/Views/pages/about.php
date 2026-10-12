<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('partials/site_header') ?>

<section class="page-hero">
  <div class="wrap">
    <h1><?= esc($settings['about_title'] ?? 'Why parents trust Little Doctors') ?></h1>
    <p><?= nl2br(esc($settings['about_text'] ?? 'Explore the human body, discover how to stay healthy, and learn how your knowledge can help others.')) ?></p>
  </div>
</section>

<section id="about">
  <div class="wrap">
    <?= $this->include('partials/trust_items') ?>
  </div>
</section>

<?= $this->include('partials/site_footer') ?>

<?= $this->endSection() ?>