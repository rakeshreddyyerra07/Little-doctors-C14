<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<header class="site">
  <div class="nav">
    <a class="brand" href="<?= base_url('/') ?>">
      <img
        src="<?= base_url('assets/images/logo.png') ?>"
        alt="Little Doctors logo"
        style="width:200px;height:auto;"
      >
    </a>

    <nav class="links">
      <a href="<?= base_url('/') ?>#lab">Learn <span class="icon-chevron">▾</span></a>
      <a href="<?= base_url('/') ?>#camps">Camps</a>
      <a href="<?= base_url('/') ?>#events">Events</a>
      <a href="<?= base_url('/') ?>#about">About <span class="icon-chevron">▾</span></a>
      <a href="<?= base_url('/') ?>#stories">Stories</a>
    </nav>

    <div class="nav-actions">
      <a class="btn btn-outline" href="<?= base_url('login') ?>">Login</a>
      <a class="btn btn-solid" href="<?= base_url('register') ?>">Join Little Doctors</a>
    </div>
  </div>
</header>

<main class="page-wrapper" style="display:flex;justify-content:center;padding:64px 24px;">
  <div class="card" style="max-width:26rem;width:100%;">
    <h1 style="color:var(--navy);font-size:1.6rem;margin-bottom:6px;">Forgot Password?</h1>
    <p style="color:var(--gray);font-size:.95rem;margin-bottom:22px;">
      Enter your registered email and name to set a new password.
    </p>

    <?php if (session()->getFlashdata('success')): ?>
      <div style="background:#e6f9f4;color:#0b7a63;padding:.7rem 1rem;border-radius:8px;margin-bottom:1.2rem;font-size:.9rem;">
        <?= esc(session()->getFlashdata('success')) ?>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
      <div style="background:#fde3e0;color:#a3311f;padding:.7rem 1rem;border-radius:8px;margin-bottom:1.2rem;font-size:.9rem;">
        <?= esc(session()->getFlashdata('error')) ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('forgot-password') ?>" method="post">
      <?= csrf_field() ?>

      <div style="margin-bottom:1.1rem;">
        <label for="email" style="display:block;font-weight:700;font-size:.85rem;color:var(--navy);margin-bottom:.35rem;">Email</label>
        <input
          type="email" id="email" name="email"
          value="<?= esc(old('email')) ?>"
          placeholder="Enter your email" required autocomplete="email"
          style="width:100%;padding:.65rem .8rem;border:1px solid var(--line);border-radius:8px;font:inherit;background:var(--bg-blue);"
        >
      </div>

      <div style="margin-bottom:1.1rem;">
        <label for="name" style="display:block;font-weight:700;font-size:.85rem;color:var(--navy);margin-bottom:.35rem;">Name</label>
        <input
          type="text" id="name" name="name"
          value="<?= esc(old('name')) ?>"
          placeholder="Name you registered with" required autocomplete="name"
          style="width:100%;padding:.65rem .8rem;border:1px solid var(--line);border-radius:8px;font:inherit;background:var(--bg-blue);"
        >
      </div>

      <button type="submit" class="btn btn-solid" style="width:100%;justify-content:center;">Continue</button>
    </form>

    <div style="text-align:center;font-size:.9rem;color:var(--gray);margin-top:1.2rem;">
      Remembered it? <a href="<?= base_url('login') ?>" style="color:var(--teal);font-weight:700;">Back to login</a>
    </div>
  </div>
</main>

<?= $this->endSection() ?>