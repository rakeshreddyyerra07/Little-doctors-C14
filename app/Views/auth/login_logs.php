<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Activity | Little Doctors</title>
    <style>
        :root { --navy:#12305a; --teal:#1fb5a8; --gray:#6b7280; --line:#e5e7eb; --bg-blue:#f1f7fd; }
        body { margin:0; font-family:Arial, sans-serif; background:var(--bg-blue); color:var(--navy); }
        .wrap { max-width:960px; margin:40px auto; padding:0 16px; }
        h1 { margin:0 0 6px; }
        .sub { color:var(--gray); margin-bottom:20px; }
        .card { background:#fff; border:1px solid var(--line); border-radius:14px; overflow-x:auto; }
        table { width:100%; border-collapse:collapse; }
        th, td { padding:12px 14px; text-align:left; border-bottom:1px solid var(--line); font-size:14px; }
        th { background:var(--navy); color:#fff; }
        .badge { padding:3px 10px; border-radius:20px; font-size:12px; font-weight:bold; }
        .success { background:#d1fae5; color:#065f46; }
        .failed  { background:#fee2e2; color:#991b1b; }
        .pager { margin-top:16px; }
        .back { display:inline-block; margin-top:16px; color:var(--teal); text-decoration:none; font-weight:bold; }
    </style>
</head>
<body>
<div class="wrap">
    <h1>Login Activity</h1>
    <div class="sub">Recent sign-ins to your account</div>

    <div class="card">
        <table>
            <thead>
                <tr><th>#</th><th>Date &amp; Time</th><th>Status</th><th>IP Address</th><th>Location</th><th>Lat, Long</th></tr>
            </thead>
            <tbody>
            <?php if (empty($logs)): ?>
                <tr><td colspan="6">No login activity yet.</td></tr>
            <?php else: foreach ($logs as $i => $log): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= esc(date('d M Y, h:i A', strtotime($log['last_attempted_time']))) ?></td>
                    <td><span class="badge <?= esc($log['status']) ?>"><?= esc(ucfirst($log['status'])) ?></span></td>
                    <td><?= esc($log['ipaddress']) ?></td>
                    <td><?= esc($log['location'] ?: '-') ?></td>
                    <td><?= esc($log['latlang'] ?: '-') ?></td>
                </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>

    <div class="pager"><?= $pager->links() ?></div>
    <a class="back" href="<?= base_url('dashboard') ?>">← Back to dashboard</a>
</div>
</body>
</html>