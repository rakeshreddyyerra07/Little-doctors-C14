<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
.dash-wrap   { max-width: 1000px; margin: 0 auto; padding: 40px 20px 70px; }
.dash-top    { display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; margin-bottom: 30px; }
.dash-top h1 { margin: 0; font-size: 32px; color: var(--navy); }
.dash-top p  { margin: 6px 0 0; color: #5b6b86; }
.dash-grid   { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; }
.dash-card   { background: #fff; border-radius: 18px; padding: 26px; box-shadow: 0 8px 24px rgba(20, 50, 100, .08); }
.dash-card h3{ margin: 0 0 8px; color: var(--navy); }
.dash-card p { margin: 0 0 16px; color: #5b6b86; }
</style>

<div class="dash-wrap">

  <div class="dash-top">
    <div>
      <h1>Welcome, <?= esc($userName) ?>!</h1>
      <p>You are logged in as <?= esc($userEmail) ?></p>
    </div>

    <div>
      <a class="btn btn-outline" href="<?= base_url('/') ?>">Home</a>
      <a class="btn btn-solid" href="<?= base_url('logout') ?>">Logout</a>
    </div>
  </div>

  <div class="dash-grid">

    <div class="dash-card">
      <h3>My Profile</h3>
      <p>Name: <?= esc($userName) ?><br>Email: <?= esc($userEmail) ?></p>
    </div>

    <div class="dash-card">
      <h3>Camp Enrollment</h3>
      <p>Enroll your child in a Little Doctors camp or course.</p>
      <a class="btn btn-solid" href="#">Enroll Now</a>
    </div>

    <div class="dash-card">
      <h3>Explore Camps</h3>
      <p>See upcoming summer camps and workshops.</p>
      <a class="btn btn-outline" href="<?= base_url('/#camps') ?>">View Camps</a>
    </div>

  </div>

</div>

<?= $this->endSection() ?>