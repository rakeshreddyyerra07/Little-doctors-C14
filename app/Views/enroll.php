<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php $errors = session()->getFlashdata('errors') ?? []; ?>

<style>

/* =========================================================
   ENROLLMENT FORM
   Only affects the enrollment page.
========================================================= */

.enr-page {
    --e-navy:   var(--navy, #12285c);
    --e-teal:   var(--teal, #17b39b);
    --e-coral:  var(--coral, #f45b36);
    --e-purple: var(--purple, #8b6cf0);
    --e-text:   #5b6b86;

    position: relative;
    min-height: 100vh;
    overflow: hidden;
    padding-bottom: 70px;
    background:
        radial-gradient(circle at 12% 8%,  rgba(23, 179, 155, .22) 0, transparent 38%),
        radial-gradient(circle at 92% 14%, rgba(139, 108, 240, .20) 0, transparent 40%),
        radial-gradient(circle at 80% 92%, rgba(244, 91, 54, .14) 0, transparent 38%),
        linear-gradient(160deg, #eaf5ff 0%, #f6fbff 45%, #eef9f6 100%);
}

.enr-page::before {
    content: "";
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(18, 40, 92, .09) 1.4px, transparent 1.4px);
    background-size: 26px 26px;
    pointer-events: none;
}

.enr-inner {
    position: relative;
    z-index: 2;
    max-width: 760px;
    margin: 0 auto;
    padding: 0 22px;
}

.enr-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 0;
}

.enr-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 11px 22px;
    border-radius: 999px;
    border: 2px solid var(--e-navy);
    background: #fff;
    color: var(--e-navy);
    font-weight: 800;
    text-decoration: none;
}

.enr-card {
    margin-top: 10px;
    background: rgba(255, 255, 255, .94);
    border-radius: 26px;
    padding: 34px 36px 38px;
    box-shadow: 0 18px 40px rgba(18, 40, 92, .12);
    border-top: 6px solid var(--e-teal);
}

.enr-card h1 {
    margin: 0 0 6px;
    font-size: 32px;
    color: var(--e-navy);
}

.enr-card .sub {
    margin: 0 0 24px;
    color: var(--e-text);
}

.enr-alert {
    background: #ffe7e2;
    border: 1px solid #f5b8aa;
    color: #a3341a;
    padding: 14px 18px;
    border-radius: 14px;
    margin-bottom: 20px;
    font-weight: 600;
}

.enr-alert ul { margin: 0; padding-left: 18px; }

.enr-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}

.enr-field { display: flex; flex-direction: column; gap: 6px; }
.enr-field.full { grid-column: 1 / -1; }

.enr-field label {
    font-weight: 800;
    color: var(--e-navy);
    font-size: 14px;
}

.enr-field input,
.enr-field select,
.enr-field textarea {
    width: 100%;
    box-sizing: border-box;
    padding: 14px 16px;
    border: 2px solid #d6e2f2;
    border-radius: 14px;
    background: #fff;
    font: inherit;
    color: var(--e-navy);
    outline: none;
    transition: border-color .15s ease, box-shadow .15s ease;
}

.enr-field textarea { min-height: 110px; resize: vertical; }

.enr-field input:focus,
.enr-field select:focus,
.enr-field textarea:focus {
    border-color: var(--e-teal);
    box-shadow: 0 0 0 4px rgba(23, 179, 155, .15);
}

.enr-field .err { color: #c0391b; font-size: 13px; font-weight: 700; }

.enr-field small { color: var(--e-text); }

.enr-actions {
    margin-top: 26px;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.enr-submit {
    padding: 14px 32px;
    border: 0;
    border-radius: 999px;
    background: var(--e-coral);
    color: #fff;
    font: inherit;
    font-weight: 800;
    cursor: pointer;
    box-shadow: 0 8px 18px rgba(244, 91, 54, .35);
    transition: transform .15s ease;
}

.enr-submit:hover { transform: translateY(-2px); }

.enr-cancel {
    padding: 14px 28px;
    border-radius: 999px;
    border: 2px solid var(--e-navy);
    color: var(--e-navy);
    background: #fff;
    font-weight: 800;
    text-decoration: none;
}

@media (max-width: 600px) {
    .enr-card { padding: 26px 20px 30px; }
    .enr-grid { grid-template-columns: 1fr; }
    .enr-card h1 { font-size: 26px; }
}

</style>


<div class="enr-page">
  <div class="enr-inner">

    <div class="enr-bar">
      <a class="enr-back" href="<?= base_url('dashboard') ?>">&larr; Dashboard</a>
    </div>

    <div class="enr-card">

      <h1>Camp Enrollment 📝</h1>
      <p class="sub">Hi <?= esc($userName) ?>, tell us about your child and pick a camp.</p>

      <?php if (! empty($errors)): ?>
        <div class="enr-alert">
          Please fix the following:
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?= esc($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('enroll') ?>" method="post" novalidate>

        <?= csrf_field() ?>

        <div class="enr-grid">

          <div class="enr-field">
            <label for="child_name">Child's name *</label>
            <input type="text" id="child_name" name="child_name"
                   value="<?= esc(old('child_name')) ?>" placeholder="e.g. Aarav" maxlength="120">
          </div>

          <div class="enr-field">
            <label for="child_age">Child's age *</label>
            <input type="number" id="child_age" name="child_age"
                   value="<?= esc(old('child_age')) ?>" placeholder="5 - 18" min="5" max="18">
          </div>

          <div class="enr-field full">
            <label for="camp">Choose a camp *</label>
            <select id="camp" name="camp">
              <option value="">-- Select a camp --</option>
              <?php foreach ($camps as $key => $label): ?>
                <option value="<?= esc($key) ?>" <?= old('camp') === $key ? 'selected' : '' ?>>
                  <?= esc($label) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="enr-field full">
            <label for="parent_phone">Parent phone number *</label>
            <input type="tel" id="parent_phone" name="parent_phone"
                   value="<?= esc(old('parent_phone')) ?>" placeholder="e.g. +91 98765 43210" maxlength="20">
          </div>

          <div class="enr-field full">
            <label for="notes">Anything we should know? (optional)</label>
            <textarea id="notes" name="notes" maxlength="500"
                      placeholder="Questions or special requests"><?= esc(old('notes')) ?></textarea>
            <small>Maximum 500 characters.</small>
          </div>

        </div>

        <div class="enr-actions">
          <button type="submit" class="enr-submit">Submit Enrollment</button>
          <a class="enr-cancel" href="<?= base_url('dashboard') ?>">Cancel</a>
        </div>

      </form>

    </div>

  </div>
</div>

<?= $this->endSection() ?>