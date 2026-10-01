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
  <div class="card" style="max-width:28rem;width:100%;">
    <h1 style="color:var(--navy);font-size:1.6rem;margin-bottom:6px;text-align:center;">Join Little Doctors</h1>
    <p style="color:var(--gray);font-size:.95rem;margin-bottom:22px;text-align:center;">
      Create your Little Doctors account
    </p>

    <?php if (!empty($error)): ?>
      <div style="background:#fde3e0;color:#a3311f;padding:.7rem 1rem;border-radius:8px;margin-bottom:1.2rem;font-size:.9rem;">
        <?= esc($error) ?>
      </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('register') ?>">
      <?= csrf_field() ?>

      <div style="margin-bottom:1.1rem;">
        <label for="name" style="display:block;font-weight:700;font-size:.85rem;color:var(--navy);margin-bottom:.35rem;">Name</label>
        <input
          type="text" id="name" name="name"
          placeholder="Enter your name" value="<?= esc($name ?? '') ?>" required
          style="width:100%;padding:.65rem .8rem;border:1px solid var(--line);border-radius:8px;font:inherit;background:var(--bg-blue);"
        >
      </div>

      <div style="margin-bottom:1.1rem;">
        <label for="email" style="display:block;font-weight:700;font-size:.85rem;color:var(--navy);margin-bottom:.35rem;">Email</label>
        <input
          type="email" id="email" name="email"
          placeholder="Enter your email" value="<?= esc($email ?? '') ?>" required
          style="width:100%;padding:.65rem .8rem;border:1px solid var(--line);border-radius:8px;font:inherit;background:var(--bg-blue);"
        >
      </div>

      <div style="margin-bottom:1.1rem;">
        <label for="password" style="display:block;font-weight:700;font-size:.85rem;color:var(--navy);margin-bottom:.35rem;">Password</label>
        <div style="position:relative;">
          <input
            type="password" id="password" name="password"
            placeholder="Create a password" required
            style="width:100%;padding:.65rem .8rem;border:1px solid var(--line);border-radius:8px;font:inherit;background:var(--bg-blue);"
          >
          <button
            type="button" onclick="togglePassword('password', this)"
            style="position:absolute;right:.6rem;top:50%;transform:translateY(-50%);background:none;border:0;color:var(--teal);font-weight:700;font-size:.8rem;cursor:pointer;"
          >Show</button>
        </div>
      </div>

      <div style="margin-bottom:1.1rem;">
        <label for="confirmPassword" style="display:block;font-weight:700;font-size:.85rem;color:var(--navy);margin-bottom:.35rem;">Confirm Password</label>
        <div style="position:relative;">
          <input
            type="password" id="confirmPassword" name="confirm_password"
            placeholder="Confirm your password" required
            style="width:100%;padding:.65rem .8rem;border:1px solid var(--line);border-radius:8px;font:inherit;background:var(--bg-blue);"
          >
          <button
            type="button" onclick="togglePassword('confirmPassword', this)"
            style="position:absolute;right:.6rem;top:50%;transform:translateY(-50%);background:none;border:0;color:var(--teal);font-weight:700;font-size:.8rem;cursor:pointer;"
          >Show</button>
        </div>
      </div>

      <div style="display:flex;align-items:flex-start;gap:.5rem;margin:1rem 0 1.2rem;font-size:.82rem;color:var(--gray);line-height:1.5;">
        <input type="checkbox" id="terms" name="terms" value="1" required style="margin-top:3px;">
        <label for="terms" style="font-weight:400;color:var(--gray);">
          I agree to the
          <a href="#" onclick="return false;" style="color:var(--teal);font-weight:700;">Terms &amp; Conditions</a>
          and
          <a href="#" onclick="return false;" style="color:var(--teal);font-weight:700;">Privacy Policy</a>
        </label>
      </div>

      <button type="submit" class="btn btn-solid" style="width:100%;justify-content:center;">Create Account</button>
    </form>

    <div style="text-align:center;font-size:.9rem;color:var(--gray);margin-top:1.2rem;">
      Already have an account? <a href="<?= base_url('login') ?>" style="color:var(--teal);font-weight:700;">Login</a>
    </div>
  </div>
</main>

<script>
function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    if (input.type === "password") {
        input.type = "text";
        button.textContent = "Hide";
    } else {
        input.type = "password";
        button.textContent = "Show";
    }
}
</script>

<?= $this->endSection() ?>