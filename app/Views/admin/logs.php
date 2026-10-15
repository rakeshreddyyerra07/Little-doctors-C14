<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h1>Login Logs</h1>

<form class="filters" method="get" action="<?= base_url('admin/logs') ?>">
    <input type="text" name="email" placeholder="Search email" value="<?= esc($filter['email']) ?>">
    <select name="status">
        <option value="">All statuses</option>
        <option value="success" <?= $filter['status'] === 'success' ? 'selected' : '' ?>>Success</option>
        <option value="failed" <?= $filter['status'] === 'failed' ? 'selected' : '' ?>>Failed</option>
    </select>
    <input type="date" name="from" value="<?= esc($filter['from']) ?>">
    <input type="date" name="to" value="<?= esc($filter['to']) ?>">
    <button type="submit">Filter</button>
</form>

<div class="card">
    <table>
        <thead><tr><th>#</th><th>Time</th><th>Email</th><th>Status</th><th>IP</th><th>Location</th><th>Lat, Long</th></tr></thead>
        <tbody>
        <?php if (! $logs): ?>
            <tr><td colspan="7">No logs found.</td></tr>
        <?php else: foreach ($logs as $l): ?>
            <tr>
                <td><?= esc($l['id']) ?></td>
                <td><?= esc(date('d M Y, h:i A', strtotime($l['last_attempted_time']))) ?></td>
                <td><?= esc($l['emailaddress']) ?></td>
                <td><span class="badge <?= esc(strtolower($l['status'])) ?>"><?= esc(ucfirst(strtolower($l['status']))) ?></span></td>
                <td><?= esc($l['ipaddress']) ?></td>
                <td><?= esc($l['location'] ?: '-') ?></td>
                <td><?= esc($l['latlang'] ?: '-') ?></td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

<?= $pager->only(['status', 'email', 'from', 'to'])->links() ?>

<?= $this->endSection() ?>