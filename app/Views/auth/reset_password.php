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
    <h1 style="color:var(--navy);font-size:1.6rem;margin-bottom:6px;">Set a New Password</h1>
    <p style="color:var(--gray);font-size:.95rem;margin-bottom:22px;">
      At least 8 characters, with an uppercase letter, a lowercase letter, a number and a special character.
    </p>

    <?php if (session()->getFlashdata('error')): ?>
      <div style="background:#fde3e0;color:#a3311f;padding:.7rem 1rem;border-radius:8px;margin-bottom:1.2rem;font-size:.9rem;">
        <?= esc(session()->getFlashdata('error')) ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('reset-password') ?>" method="post">
      <?= csrf_field() ?>
      <input type="hidden" name="token" value="<?= esc($token) ?>">

      <div style="margin-bottom:1.1rem;">
        <label for="password" style="display:block;font-weight:700;font-size:.85rem;color:var(--navy);margin-bottom:.35rem;">New password</label>
        <div style="position:relative;">
          <input
            type="password" id="password" name="password"
            placeholder="Enter new password" required autocomplete="new-password"
            style="width:100%;padding:.65rem .8rem;border:1px solid var(--line);border-radius:8px;font:inherit;background:var(--bg-blue);"
          >
          <button
            type="button" onclick="toggleField('password', this)"
            style="position:absolute;right:.6rem;top:50%;transform:translateY(-50%);background:none;border:0;color:var(--teal);font-weight:700;font-size:.8rem;cursor:pointer;"
          >Show</button>
        </div>
      </div>

      <div style="margin-bottom:1.1rem;">
        <label for="confirm_password" style="display:block;font-weight:700;font-size:.85rem;color:var(--navy);margin-bottom:.35rem;">Confirm password</label>
        <div style="position:relative;">
          <input
            type="password" id="confirm_password" name="confirm_password"
            placeholder="Confirm new password" required autocomplete="new-password"
            style="width:100%;padding:.65rem .8rem;border:1px solid var(--line);border-radius:8px;font:inherit;background:var(--bg-blue);"
          >
          <button
            type="button" onclick="toggleField('confirm_password', this)"
            style="position:absolute;right:.6rem;top:50%;transform:translateY(-50%);background:none;border:0;color:var(--teal);font-weight:700;font-size:.8rem;cursor:pointer;"
          >Show</button>
        </div>
      </div>

      <button type="submit" class="btn btn-solid" style="width:100%;justify-content:center;">Update Password</button>
    </form>
  </div>
</main>

<script>
function toggleField(id, btn) {
    const input = document.getElementById(id);
    if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = 'Hide';
    } else {
        input.type = 'password';
        btn.textContent = 'Show';
    }
}
</script>

<?= $this->endSection() ?>