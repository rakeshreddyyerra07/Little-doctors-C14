<link rel="stylesheet" href="<?= base_url('assets/css/pages.css') ?>">
<?php $active = $active ?? ''; ?>

<header class="site">
  <div class="nav">

    <a class="brand" href="<?= base_url('/') ?>">
      <img src="<?= base_url('assets/images/logo.png') ?>"
           alt="<?= esc($settings['site_name'] ?? 'Little Doctors') ?> logo"
           style="width:200px;height:auto;">
    </a>

    <nav class="links">
      <a class="<?= $active === 'learn' ? 'active' : '' ?>" href="<?= base_url('learn') ?>">Learn <span class="icon-chevron">▾</span></a>
      <a class="<?= $active === 'camps' ? 'active' : '' ?>" href="<?= base_url('camps') ?>">Camps</a>
      <a class="<?= $active === 'events' ? 'active' : '' ?>" href="<?= base_url('events') ?>">Events</a>
      <a class="<?= $active === 'about' ? 'active' : '' ?>" href="<?= base_url('about') ?>">About <span class="icon-chevron">▾</span></a>
      <a class="<?= $active === 'stories' ? 'active' : '' ?>" href="<?= base_url('stories') ?>">Stories</a>
      <a class="<?= $active === 'contact' ? 'active' : '' ?>" href="<?= base_url('contact') ?>">Contact</a>
    </nav>

    <div class="nav-actions">
      <?php if (session()->get('logged_in')): ?>
        <a class="btn btn-outline" href="<?= base_url('dashboard') ?>">Dashboard</a>
        <a class="btn btn-solid" href="<?= base_url('logout') ?>">Logout</a>
      <?php else: ?>
        <a class="btn btn-outline" href="<?= base_url('login') ?>">Login</a>
        <a class="btn btn-solid" href="<?= base_url('register') ?>">Join Little Doctors</a>
      <?php endif; ?>
    </div>

  </div>
</header>