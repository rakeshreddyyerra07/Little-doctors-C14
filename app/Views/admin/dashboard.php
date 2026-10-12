<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h1>Overview</h1>
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
                <td><span class="badge <?= esc($r['status']) ?>"><?= esc(ucfirst($r['status'])) ?></span></td>
                <td><?= esc($r['ipaddress']) ?></td>
                <td><?= esc($r['location'] ?: '-') ?></td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>