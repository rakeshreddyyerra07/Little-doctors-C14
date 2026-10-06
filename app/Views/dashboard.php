<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>

/* =========================================================
   DASHBOARD
   Only affects the dashboard page.
========================================================= */

.dash-page {
    --d-navy:   var(--navy, #12285c);
    --d-teal:   var(--teal, #17b39b);
    --d-coral:  var(--coral, #f45b36);
    --d-purple: var(--purple, #8b6cf0);
    --d-yellow: var(--yellow, #f7b731);
    --d-pink:   var(--pink, #ec4f78);
    --d-green:  var(--green, #34b36b);
    --d-text:   #5b6b86;

    position: relative;
    min-height: 100vh;
    overflow: hidden;
    padding-bottom: 70px;

    /* background: soft gradient + dotted pattern */
    background:
        radial-gradient(circle at 12% 8%,  rgba(23, 179, 155, .22) 0, transparent 38%),
        radial-gradient(circle at 92% 14%, rgba(139, 108, 240, .20) 0, transparent 40%),
        radial-gradient(circle at 80% 92%, rgba(244, 91, 54, .14) 0, transparent 38%),
        radial-gradient(circle at 6% 88%,  rgba(247, 183, 49, .16) 0, transparent 36%),
        linear-gradient(160deg, #eaf5ff 0%, #f6fbff 45%, #eef9f6 100%);
}

/* dotted pattern layer */
.dash-page::before {
    content: "";
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(18, 40, 92, .09) 1.4px, transparent 1.4px);
    background-size: 26px 26px;
    pointer-events: none;
}

/* floating decorative circles */
.dash-bubble {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    opacity: .55;
    animation: dashFloat 9s ease-in-out infinite;
}
.dash-bubble.b1 { width: 160px; height: 160px; top: 140px;  left: -50px;  background: rgba(23,179,155,.16); }
.dash-bubble.b2 { width: 110px; height: 110px; top: 420px;  right: -30px; background: rgba(139,108,240,.18); animation-delay: 1.5s; }
.dash-bubble.b3 { width: 80px;  height: 80px;  bottom: 120px; left: 8%;   background: rgba(247,183,49,.22); animation-delay: 3s; }

@keyframes dashFloat {
    0%, 100% { transform: translateY(0); }
    50%      { transform: translateY(-16px); }
}

.dash-inner {
    position: relative;
    z-index: 2;
    max-width: 1120px;
    margin: 0 auto;
    padding: 0 22px;
}


/* ---------- TOP BAR ---------- */

.dash-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 18px 0;
}

.dash-bar img {
    height: 54px;
    width: auto;
    display: block;
}

.dash-bar-right {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.dash-user {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255, 255, 255, .8);
    backdrop-filter: blur(6px);
    padding: 6px 16px 6px 6px;
    border-radius: 999px;
    box-shadow: 0 4px 14px rgba(18, 40, 92, .08);
    font-weight: 700;
    color: var(--d-navy);
}

.dash-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 800;
    background: linear-gradient(135deg, var(--d-teal), var(--d-purple));
}


/* ---------- HERO ---------- */

.dash-hero {
    position: relative;
    margin-top: 10px;
    padding: 38px 40px;
    border-radius: 28px;
    color: #fff;
    overflow: hidden;
    background: linear-gradient(120deg, var(--d-navy) 0%, #1c3f8f 55%, var(--d-teal) 130%);
    box-shadow: 0 18px 40px rgba(18, 40, 92, .25);
}

.dash-hero::after {
    content: "";
    position: absolute;
    right: -70px;
    top: -70px;
    width: 280px;
    height: 280px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .09);
}

.dash-hero::before {
    content: "";
    position: absolute;
    right: 90px;
    bottom: -90px;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .07);
}

.dash-hero h1 {
    margin: 0 0 8px;
    font-size: 36px;
    line-height: 1.15;
    color: #fff;
    position: relative;
    z-index: 1;
}

.dash-hero p {
    margin: 0 0 22px;
    max-width: 560px;
    font-size: 17px;
    color: rgba(255, 255, 255, .88);
    position: relative;
    z-index: 1;
}

.dash-hero .hero-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    position: relative;
    z-index: 1;
}

.dash-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 26px;
    border-radius: 999px;
    font-weight: 800;
    text-decoration: none;
    border: 2px solid transparent;
    cursor: pointer;
    transition: transform .15s ease, box-shadow .15s ease;
}
.dash-btn:hover { transform: translateY(-2px); }

.dash-btn.primary {
    background: var(--d-coral);
    color: #fff;
    box-shadow: 0 8px 18px rgba(244, 91, 54, .35);
}

.dash-btn.ghost {
    background: transparent;
    color: #fff;
    border-color: rgba(255, 255, 255, .7);
}

.dash-btn.dark {
    background: var(--d-navy);
    color: #fff;
}

.dash-btn.line {
    background: #fff;
    color: var(--d-navy);
    border-color: var(--d-navy);
}


/* ---------- STATS ---------- */

.dash-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-top: 26px;
}

.stat {
    background: rgba(255, 255, 255, .88);
    backdrop-filter: blur(6px);
    border-radius: 20px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 8px 22px rgba(18, 40, 92, .07);
}

.stat .ico {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    flex: none;
}

.stat b {
    display: block;
    font-size: 24px;
    color: var(--d-navy);
    line-height: 1.1;
}

.stat span {
    font-size: 13px;
    color: var(--d-text);
}


/* ---------- SECTION TITLES ---------- */

.dash-title {
    margin: 38px 0 16px;
    font-size: 24px;
    color: var(--d-navy);
}


/* ---------- ACTION CARDS ---------- */

.dash-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.dcard {
    background: rgba(255, 255, 255, .92);
    border-radius: 22px;
    padding: 26px;
    box-shadow: 0 10px 28px rgba(18, 40, 92, .08);
    transition: transform .2s ease, box-shadow .2s ease;
    border-top: 5px solid var(--d-teal);
}

.dcard:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 34px rgba(18, 40, 92, .13);
}

.dcard.c2 { border-top-color: var(--d-coral); }
.dcard.c3 { border-top-color: var(--d-purple); }

.dcard .ico {
    width: 56px;
    height: 56px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin-bottom: 14px;
}

.dcard h3 {
    margin: 0 0 6px;
    color: var(--d-navy);
    font-size: 20px;
}

.dcard p {
    margin: 0 0 18px;
    color: var(--d-text);
    line-height: 1.5;
}


/* ---------- TWO COLUMN AREA ---------- */

.dash-two {
    display: grid;
    grid-template-columns: 1.4fr 1fr;
    gap: 20px;
}

.panel {
    background: rgba(255, 255, 255, .92);
    border-radius: 22px;
    padding: 26px;
    box-shadow: 0 10px 28px rgba(18, 40, 92, .08);
}

.panel h3 {
    margin: 0 0 16px;
    color: var(--d-navy);
    font-size: 20px;
}

.camp-row {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 0;
    border-bottom: 1px dashed #d9e3f1;
}
.camp-row:last-child { border-bottom: 0; }

.camp-date {
    width: 58px;
    flex: none;
    text-align: center;
    border-radius: 14px;
    padding: 8px 0;
    background: #eaf5ff;
    color: var(--d-navy);
    font-weight: 800;
    line-height: 1.1;
}
.camp-date small { display: block; font-size: 11px; color: var(--d-text); font-weight: 700; }

.camp-info b    { display: block; color: var(--d-navy); }
.camp-info span { font-size: 13px; color: var(--d-text); }

.profile-line {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px dashed #d9e3f1;
    font-size: 15px;
}
.profile-line:last-child { border-bottom: 0; }
.profile-line span { color: var(--d-text); }
.profile-line b    { color: var(--d-navy); word-break: break-all; text-align: right; }


/* ---------- TEMPORARY SESSION BOX ---------- */

.session-box {
    margin-top: 28px;
    background: rgba(255, 255, 255, .85);
    border: 2px dashed #b8c7e0;
    border-radius: 18px;
    padding: 16px 20px;
}

.session-box summary {
    cursor: pointer;
    font-weight: 800;
    color: var(--d-navy);
}

.session-box pre {
    margin: 14px 0 0;
    white-space: pre-wrap;
    word-break: break-all;
    font-size: 14px;
    color: #243556;
}


/* ---------- FLASH MESSAGE ---------- */

.dash-flash {
    margin-top: 6px;
    margin-bottom: 14px;
    padding: 14px 20px;
    border-radius: 16px;
    background: #e3faf3;
    border: 1px solid #a9e6d3;
    color: #0e7a63;
    font-weight: 700;
}


/* ---------- RESPONSIVE ---------- */

@media (max-width: 960px) {
    .dash-stats { grid-template-columns: repeat(2, 1fr); }
    .dash-cards { grid-template-columns: 1fr; }
    .dash-two   { grid-template-columns: 1fr; }
}

@media (max-width: 560px) {
    .dash-hero      { padding: 28px 22px; }
    .dash-hero h1   { font-size: 28px; }
    .dash-stats     { grid-template-columns: 1fr; }
    .dash-user span { display: none; }
    .dash-user      { padding: 6px; }
}

</style>


<div class="dash-page">

  <span class="dash-bubble b1"></span>
  <span class="dash-bubble b2"></span>
  <span class="dash-bubble b3"></span>

  <div class="dash-inner">

    <!-- TOP BAR -->
    <div class="dash-bar">

      <a href="<?= base_url('/') ?>">
        <img src="<?= base_url('assets/images/logo.png') ?>" alt="Little Doctors logo">
      </a>

      <div class="dash-bar-right">

        <div class="dash-user">
          <div class="dash-avatar"><?= esc(strtoupper(substr((string) $userName, 0, 1))) ?></div>
          <span><?= esc($userName) ?></span>
        </div>

        <a class="dash-btn line" href="<?= base_url('/') ?>">Home</a>
        <a class="dash-btn dark" href="<?= base_url('logout') ?>">Logout</a>

      </div>

    </div>


    <!-- SUCCESS MESSAGE -->
    <?php if (session()->getFlashdata('success')): ?>
      <div class="dash-flash">✅ <?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>


    <!-- HERO -->
    <div class="dash-hero">

      <h1>Welcome back, <?= esc($userName) ?>! 👋</h1>
      <p>Ready for your next adventure? Explore camps, enroll your child and help them grow into a Little Doctor.</p>

      <div class="hero-actions">
        <a class="dash-btn primary" href="<?= base_url('enroll') ?>">Enroll Now →</a>
        <a class="dash-btn ghost" href="<?= base_url('/#camps') ?>">Explore Camps</a>
      </div>

    </div>


    <!-- STATS -->
    <div class="dash-stats">

      <div class="stat">
        <div class="ico" style="background:#e3faf3">🎓</div>
        <div><b><?= count($enrollments) ?></b><span>Enrollments</span></div>
      </div>

      <div class="stat">
        <div class="ico" style="background:#fff3de">⭐</div>
        <div><b>0</b><span>Badges earned</span></div>
      </div>

      <div class="stat">
        <div class="ico" style="background:#f2eefc">📅</div>
        <div><b>3</b><span>Upcoming camps</span></div>
      </div>

      <div class="stat">
        <div class="ico" style="background:#ffe7ec">🧸</div>
        <div><b>10,000+</b><span>Little Doctors</span></div>
      </div>

    </div>


    <!-- QUICK ACTIONS -->
    <h2 class="dash-title">Quick actions</h2>

    <div class="dash-cards">

      <div class="dcard">
        <div class="ico" style="background:#e3faf3">📝</div>
        <h3>Camp Enrollment</h3>
        <p>Enroll your child in a Little Doctors camp or course.</p>
        <a class="dash-btn dark" href="<?= base_url('enroll') ?>">Enroll Now</a>
      </div>

      <div class="dcard c2">
        <div class="ico" style="background:#ffe7e2">🏕️</div>
        <h3>Explore Camps</h3>
        <p>See upcoming summer camps and weekend workshops near you.</p>
        <a class="dash-btn line" href="<?= base_url('/#camps') ?>">View Camps</a>
      </div>

      <div class="dcard c3">
        <div class="ico" style="background:#f2eefc">🧠</div>
        <h3>Learning Lab</h3>
        <p>Brain, heart, lungs, bones and nutrition - learn through fun topics.</p>
        <a class="dash-btn line" href="<?= base_url('/#lab') ?>">Start Learning</a>
      </div>

    </div>


    <!-- CAMPS + PROFILE -->
    <h2 class="dash-title">Your overview</h2>

    <div class="dash-two">

      <div class="panel">
        <h3>Upcoming camps</h3>

        <div class="camp-row">
          <div class="camp-date"><small>JUN</small>15</div>
          <div class="camp-info">
            <b>Little Doctors Camp</b>
            <span>Boston, MA &bull; Ages 8 - 14</span>
          </div>
        </div>

        <div class="camp-row">
          <div class="camp-date"><small>JUL</small>12</div>
          <div class="camp-info">
            <b>Heart &amp; Health Workshop</b>
            <span>New York, NY &bull; Ages 7 - 12</span>
          </div>
        </div>

        <div class="camp-row">
          <div class="camp-date"><small>AUG</small>2</div>
          <div class="camp-info">
            <b>Human Body Explorer Camp</b>
            <span>Chicago, IL &bull; Ages 8 - 14</span>
          </div>
        </div>
      </div>

      <div class="panel">
        <h3>My profile</h3>

        <div class="profile-line"><span>Name</span><b><?= esc($userName) ?></b></div>
        <div class="profile-line"><span>Email</span><b><?= esc($userEmail) ?></b></div>
        <div class="profile-line"><span>Status</span><b style="color:var(--d-green)">Logged in</b></div>
      </div>

    </div>


    <!-- MY ENROLLMENTS -->
    <h2 class="dash-title">My enrollments</h2>

    <div class="panel">

      <?php if (empty($enrollments)): ?>
        <p style="margin:0;color:var(--d-text);">
          No enrollments yet.
          <a href="<?= base_url('enroll') ?>" style="color:var(--d-coral);font-weight:800;">Enroll your child &rarr;</a>
        </p>
      <?php else: ?>
        <?php foreach ($enrollments as $row): ?>
          <div class="camp-row">
            <div class="camp-date"><small>AGE</small><?= (int) $row->child_age ?></div>
            <div class="camp-info">
              <b><?= esc($row->child_name) ?></b>
              <span><?= esc($row->camp) ?></span>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

    </div>


    <!-- TEMPORARY: session data viewer. Remove this block later. -->
    <details class="session-box">
      <summary>Session data (temporary - remove later)</summary>
      <pre><?= esc(print_r($sessionData, true)) ?></pre>
    </details>

  </div>

</div>

<?= $this->endSection() ?>