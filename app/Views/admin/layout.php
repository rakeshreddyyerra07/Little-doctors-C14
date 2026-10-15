<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Little Doctors</title>
    <style>
        :root { --navy:#12305a; --teal:#1fb5a8; --gray:#6b7280; --line:#e5e7eb; --bg-blue:#f1f7fd; }
        body { margin:0; font-family:Arial, sans-serif; background:var(--bg-blue); color:var(--navy); }
        .top { background:var(--navy); color:#fff; padding:14px 24px; display:flex; gap:20px; align-items:center; flex-wrap:wrap; }
        .top a { color:#fff; text-decoration:none; opacity:.85; }
        .top a:hover { opacity:1; }
        .top .brand { font-weight:bold; font-size:18px; margin-right:auto; }
        .wrap { max-width:1100px; margin:30px auto; padding:0 16px; }
        .stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:16px; margin-bottom:24px; }
        .stat { background:#fff; border:1px solid var(--line); border-radius:14px; padding:18px; }
        .stat b { display:block; font-size:30px; color:var(--teal); }
        .card { background:#fff; border:1px solid var(--line); border-radius:14px; overflow-x:auto; margin-bottom:16px; }
        table { width:100%; border-collapse:collapse; }
        th, td { padding:11px 14px; text-align:left; border-bottom:1px solid var(--line); font-size:14px; }
        th { background:var(--navy); color:#fff; }
        .badge { padding:3px 10px; border-radius:20px; font-size:12px; font-weight:bold; }
        .success, .admin { background:#d1fae5; color:#065f46; }
        .failed { background:#fee2e2; color:#991b1b; }
        .user { background:#e0e7ff; color:#3730a3; }
        form.filters { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:16px; }
        form.filters input, form.filters select { padding:9px; border:1px solid var(--line); border-radius:8px; }
        form.filters button { background:var(--teal); color:#fff; border:0; padding:9px 18px; border-radius:8px; cursor:pointer; }
    </style>
</head>
<body>
<div class="top">
    <span class="brand">Little Doctors Admin</span>
    <a href="<?= base_url('admin') ?>">Overview</a>
    <a href="<?= base_url('admin/slides') ?>">Slides</a>
    <a href="<?= base_url('admin/content/camps') ?>">Camps</a>
    <a href="<?= base_url('admin/content/courses') ?>">Courses</a>
    <a href="<?= base_url('admin/content/testimonials') ?>">Testimonials</a>
    <a href="<?= base_url('admin/users') ?>">Users</a>
    <a href="<?= base_url('admin/logs') ?>">Login Logs</a>
    <a href="<?= base_url('admin/settings') ?>">Settings</a>
    <a href="<?= base_url('dashboard') ?>">My Dashboard</a>
</div>
<div class="wrap">
    <?= $this->renderSection('content') ?>
</div>
</body>
</html>