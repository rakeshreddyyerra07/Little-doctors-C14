<style>footer.site .brand { display: none !important; }</style>

<footer class="site">
  <div class="wrap">
    <a class="brand" href="<?= base_url('/') ?>">
      <img src="<?= base_url('assets/images/logo.png') ?>" alt="Little Doctors logo" style="height:100px">
    </a>
    <p><?= esc($settings['footer_text'] ?? '© 2026 Little Doctors. Caring today, healthy tomorrow.') ?></p>
    <?= $this->include('partials/social_links') ?>
  </div>
</footer>