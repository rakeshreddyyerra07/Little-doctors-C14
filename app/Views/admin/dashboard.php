<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .quick { display:grid; grid-template-columns:repeat(auto-fit,minmax(170px,1fr)); gap:14px; margin-bottom:24px; }
    .quick a.stat { text-decoration:none; color:var(--navy); font-weight:bold; }
    .quick a.stat span { display:block; font-weight:normal; font-size:13px; color:var(--gray); margin-top:4px; }
</style>

<h1>Overview</h1>

<div class="quick">
    <a class="stat" href="<?= base_url('admin/slides') ?>">Home Slides<span>Create, edit, delete</span></a>
    <a class="stat" href="<?= base_url('admin/content/camps') ?>">Camps<span>Create, edit, delete</span></a>
    <a class="stat" href="<?= base_url('admin/content/courses') ?>">Learning Lab<span>Courses</span></a>
    <a class="stat" href="<?= base_url('admin/content/testimonials') ?>">Testimonials<span>Stories</span></a>
    <a class="stat" href="<?= base_url('admin/settings') ?>">Settings<span>Contact and social links</span></a>
</div>

<div class="stats">
    <div class="stat"><b><?= $totalUsers ?></b>Total users</div>
    <div class="stat"><b><?= $successToday ?></b>Successful logins today</div>
    <div class="stat"><b><?= $failedToday ?></b>Failed attempts today</div>
</div>

<h2>Recent login activity</h2>
<div class="card">
    <table>
        <thead><tr><th>Time</th><th>Email</th><th>Status</th><th>IP</th><th>Location</th></tr></thead>
        <tbody>
        <?php if (! $recent): ?>
            <tr><td colspan="5">No activity yet.</td></tr>
        <?php else: foreach ($recent as $r): ?>
            <tr>
                <td><?= esc(date('d M Y, h:i A', strtotime($r['last_attempted_time']))) ?></td>
                <td><?= esc($r['emailaddress']) ?></td>
                <td><span class="badge <?= esc(strtolower($r['status'])) ?>"><?= esc(ucfirst(strtolower($r['status']))) ?></span></td>
                <td><?= esc($r['ipaddress']) ?></td>
                <td><?= esc($r['location'] ?: '-') ?></td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>