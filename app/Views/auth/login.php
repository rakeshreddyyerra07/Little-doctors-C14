
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
    <h1 style="color:var(--navy);font-size:1.6rem;margin-bottom:6px;">Welcome Back!</h1>

    <p style="color:var(--gray);font-size:.95rem;margin-bottom:22px;">
      Sign in to continue your Little Doctors journey.
    </p>

    <?php if (session()->getFlashdata('success')): ?>
      <div style="background:#e6f9f4;color:#0b7a63;padding:.7rem 1rem;border-radius:8px;margin-bottom:1.2rem;font-size:.9rem;">
        <?= esc(session()->getFlashdata('success')) ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
      <div style="background:#fde3e0;color:#a3311f;padding:.7rem 1rem;border-radius:8px;margin-bottom:1.2rem;font-size:.9rem;">
        <?= esc($error) ?>
      </div>
    <?php endif; ?>

    <?php if (isset($validation)): ?>
      <div style="background:#fde3e0;color:#a3311f;padding:.7rem 1rem;border-radius:8px;margin-bottom:1.2rem;font-size:.9rem;">
        <?= $validation->listErrors() ?>
      </div>
    <?php endif; ?>

    <form id="loginForm" action="<?= base_url('login') ?>" method="post">
      <?= csrf_field() ?>

      <div style="margin-bottom:1.1rem;">
        <label for="email" style="display:block;font-weight:700;font-size:.85rem;color:var(--navy);margin-bottom:.35rem;">
          Email
        </label>

        <input
          type="email"
          id="email"
          name="email"
          value="<?= esc(old('email') ?? '') ?>"
          placeholder="Enter your email"
          required
          autocomplete="email"
          style="width:100%;padding:.65rem .8rem;border:1px solid var(--line);border-radius:8px;font:inherit;background:var(--bg-blue);"
        >
      </div>

      <div style="margin-bottom:.6rem;">
        <label for="password" style="display:block;font-weight:700;font-size:.85rem;color:var(--navy);margin-bottom:.35rem;">
          Password
        </label>

        <div style="position:relative;">
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Enter your password"
            required
            autocomplete="current-password"
            style="width:100%;padding:.65rem 4rem .65rem .8rem;border:1px solid var(--line);border-radius:8px;font:inherit;background:var(--bg-blue);"
          >

          <button
            type="button"
            id="passwordToggle"
            onclick="togglePassword()"
            style="position:absolute;right:.6rem;top:50%;transform:translateY(-50%);background:none;border:0;color:var(--teal);font-weight:700;font-size:.8rem;cursor:pointer;"
          >Show</button>
        </div>
      </div>

      <div style="text-align:right;margin-bottom:1.1rem;">
        <a href="<?= base_url('forgot-password') ?>" style="color:var(--teal);font-weight:700;font-size:.85rem;text-decoration:none;">
          Forgot password?
        </a>
      </div>

      <button type="submit" class="btn btn-solid" style="width:100%;justify-content:center;">
        Login
      </button>
    </form>

    <div style="text-align:center;font-size:.9rem;color:var(--gray);margin-top:1.2rem;">
      Don't have an account?
      <a href="<?= base_url('register') ?>" style="color:var(--teal);font-weight:700;">
        Register
      </a>
    </div>
  </div>
</main>

<style>
  #loginForm .validation-error {
    display: block;
    color: #dc2626;
    font-size: 13px;
    margin-top: 5px;
  }

  #loginForm input.error {
    border-color: #dc2626 !important;
  }
</style>

<script>
function togglePassword() {
    const password = document.getElementById('password');
    const button = document.getElementById('passwordToggle');

    if (password.type === 'password') {
        password.type = 'text';
        button.textContent = 'Hide';
    } else {
        password.type = 'password';
        button.textContent = 'Show';
    }
}
</script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    $('#loginForm').validate({
        rules: {
            email: {
                required: true,
                email: true,
                maxlength: 254
            },
            password: {
                required: true
            }
        },

        messages: {
            email: {
                required: 'Please enter your email address.',
                email: 'Please enter a valid email address.',
                maxlength: 'Email cannot exceed 254 characters.'
            },
            password: {
                required: 'Please enter your password.'
            }
        },

        errorElement: 'div',
        errorClass: 'validation-error',

        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },

        highlight: function (element) {
            $(element).addClass('error');
        },

        unhighlight: function (element) {
            $(element).removeClass('error');
        }
    });
});
</script>

<?= $this->endSection() ?>
