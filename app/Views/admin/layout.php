
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Little Doctors</title>

    <style>
        :root {
            --navy: #12305a;
            --teal: #1fb5a8;
            --gray: #6b7280;
            --line: #e5e7eb;
            --bg-blue: #f1f7fd;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--bg-blue);
            color: var(--navy);
        }

        /* Admin Header */
        .top {
            background: var(--navy);
            color: #fff;
            padding: 10px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .top .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            font-size: 17px;
            white-space: nowrap;
        }

        .admin-logo {
            width: 44px;
            height: 44px;
            object-fit: contain;
            background: #fff;
            border-radius: 8px;
            padding: 3px;
        }

        /* Shorter Navigation */
        .admin-nav {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
        }

        .admin-nav > a,
        .dropdown-toggle {
            color: #fff;
            font-family: inherit;
            font-size: 14px;
            text-decoration: none;
            background: transparent;
            border: 0;
            padding: 10px 0;
            cursor: pointer;
            white-space: nowrap;
        }

        .admin-nav > a:hover,
        .dropdown-toggle:hover {
            color: var(--teal);
        }

        /* Dropdown Menus */
        .nav-dropdown {
            position: relative;
        }

        .dropdown-toggle span {
            margin-left: 4px;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 190px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            padding: 6px;
            z-index: 1000;
        }

        .dropdown-menu a {
            display: block;
            color: var(--navy);
            text-decoration: none;
            padding: 10px 12px;
            border-radius: 6px;
            font-size: 14px;
            white-space: nowrap;
        }

        .dropdown-menu a:hover {
            background: var(--bg-blue);
            color: var(--navy);
        }

        .nav-dropdown:hover .dropdown-menu,
        .nav-dropdown:focus-within .dropdown-menu {
            display: block;
        }

        .dropdown-toggle:focus-visible,
        .admin-nav a:focus-visible,
        .dropdown-menu a:focus-visible {
            outline: 2px solid var(--teal);
            outline-offset: 3px;
        }

        /* Main Content */
        .wrap {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 16px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 18px;
        }

        .stat b {
            display: block;
            font-size: 30px;
            color: var(--teal);
        }

        .card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            overflow-x: auto;
            margin-bottom: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 11px 14px;
            text-align: left;
            border-bottom: 1px solid var(--line);
            font-size: 14px;
        }

        th {
            background: var(--navy);
            color: #fff;
        }

        .badge {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .success, .admin {
            background: #d1fae5;
            color: #065f46;
        }

        .failed {
            background: #fee2e2;
            color: #991b1b;
        }

        .user {
            background: #e0e7ff;
            color: #3730a3;
        }

        form.filters {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        form.filters input,
        form.filters select {
            padding: 9px;
            border: 1px solid var(--line);
            border-radius: 8px;
        }

        form.filters button {
            background: var(--teal);
            color: #fff;
            border: 0;
            padding: 9px 18px;
            border-radius: 8px;
            cursor: pointer;
        }

        /* Login Logs Pagination */
        .logs-pagination-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin: 20px 0;
        }

        .logs-pagination-info {
            color: var(--gray);
            font-size: 14px;
        }

        .logs-pagination ul {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .logs-pagination li a,
        .logs-pagination li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 36px;
            min-width: 36px;
            padding: 0 10px;
            border: 1px solid var(--line);
            border-radius: 7px;
            color: var(--navy);
            background: #fff;
            text-decoration: none;
            font-size: 14px;
        }

        .logs-pagination li a:hover {
            background: var(--bg-blue);
            border-color: var(--teal);
        }

        .logs-pagination li.active span {
            color: #fff;
            background: var(--navy);
            border-color: var(--navy);
        }

        .logs-pagination li.disabled span,
        .logs-pagination li.ellipsis span {
            color: var(--gray);
            background: #f9fafb;
        }

        /* Responsive Header and Pagination */
        @media (max-width: 700px) {
            .top {
                align-items: flex-start;
                flex-direction: column;
                padding: 12px 16px;
            }

            .admin-nav {
                gap: 12px;
            }

            .dropdown-menu {
                max-width: calc(100vw - 32px);
            }
        }

        @media (max-width: 600px) {
            .logs-pagination-wrapper {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

<div class="top">

    <a href="<?= base_url('admin') ?>" class="brand">
        <img
            src="<?= base_url('assets/images/logo.png') ?>"
            alt="Little Doctors Logo"
            class="admin-logo"
        >
        <span>Little Doctors Admin</span>
    </a>

    <nav class="admin-nav" aria-label="Admin navigation">

        <a href="<?= base_url('admin') ?>">Overview</a>

        <div class="nav-dropdown">
            <button type="button" class="dropdown-toggle">
                Content <span aria-hidden="true">▾</span>
            </button>

            <div class="dropdown-menu">
                <a href="<?= base_url('admin/slides') ?>">Home Slides</a>
                <a href="<?= base_url('admin/content/camps') ?>">Camps</a>
                <a href="<?= base_url('admin/content/courses') ?>">Courses</a>
                <a href="<?= base_url('admin/content/testimonials') ?>">
                    Testimonials
                </a>
            </div>
        </div>

        <div class="nav-dropdown">
            <button type="button" class="dropdown-toggle">
                Management <span aria-hidden="true">▾</span>
            </button>

            <div class="dropdown-menu">
                <a href="<?= base_url('admin/users') ?>">Users</a>
                <a href="<?= base_url('admin/logs') ?>">Login Logs</a>
                <a href="<?= base_url('admin/settings') ?>">Settings</a>
            </div>
        </div>

        <a href="<?= base_url('dashboard') ?>">My Dashboard</a>

    </nav>
</div>

<div class="wrap">
    <?= $this->renderSection('content') ?>
</div>

</body>
</html>