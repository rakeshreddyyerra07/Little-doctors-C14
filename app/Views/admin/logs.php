
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h1>Login Logs</h1>

<form class="filters" method="get" action="<?= base_url('admin/logs') ?>">
    <input
        type="text"
        name="email"
        placeholder="Search email"
        value="<?= esc($filter['email']) ?>"
    >

    <select name="status">
        <option value="">All statuses</option>
        <option value="success" <?= $filter['status'] === 'success' ? 'selected' : '' ?>>
            Success
        </option>
        <option value="failed" <?= $filter['status'] === 'failed' ? 'selected' : '' ?>>
            Failed
        </option>
    </select>

    <input type="date" name="from" value="<?= esc($filter['from']) ?>">
    <input type="date" name="to" value="<?= esc($filter['to']) ?>">

    <button type="submit">Filter</button>
</form>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Time</th>
                <th>Email</th>
                <th>Status</th>
                <th>IP</th>
                <th>Location</th>
                <th>Lat, Long</th>
            </tr>
        </thead>

        <tbody>
        <?php if (empty($logs)): ?>
            <tr>
                <td colspan="7">No logs found.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($logs as $l): ?>
                <tr>
                    <td><?= esc($l['id']) ?></td>

                    <td>
                        <?= esc(date(
                            'd M Y, h:i A',
                            strtotime($l['last_attempted_time'])
                        )) ?>
                    </td>

                    <td><?= esc($l['emailaddress']) ?></td>

                    <td>
                        <span class="badge <?= esc(strtolower($l['status'])) ?>">
                            <?= esc(ucfirst(strtolower($l['status']))) ?>
                        </span>
                    </td>

                    <td><?= esc($l['ipaddress']) ?></td>
                    <td><?= esc($l['location'] ?: '-') ?></td>
                    <td><?= esc($l['latlang'] ?: '-') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
$currentPage = (int) $pager->getCurrentPage();
$totalPages  = (int) $pager->getPageCount();
$total       = (int) $pager->getTotal();
$perPage     = (int) $pager->getPerPage();

$start = $total > 0 ? (($currentPage - 1) * $perPage) + 1 : 0;
$end   = min($currentPage * $perPage, $total);

// Create a compact page-number list.
$pages = [];

if ($totalPages > 0 && $totalPages <= 7) {
    $pages = range(1, $totalPages);
} elseif ($totalPages > 7) {
    $pages[] = 1;

    $windowStart = max(2, $currentPage - 1);
    $windowEnd   = min($totalPages - 1, $currentPage + 2);

    if ($windowStart > 2) {
        $pages[] = '...';
    }

    for ($i = $windowStart; $i <= $windowEnd; $i++) {
        $pages[] = $i;
    }

    if ($windowEnd < $totalPages - 1) {
        $pages[] = '...';
    }

    $pages[] = $totalPages;
}
?>

<div class="logs-pagination-wrapper">

    <div class="logs-pagination-info">
        Showing <?= $start ?>–<?= $end ?> of <?= $total ?> results
    </div>

    <?php if ($totalPages > 1): ?>
        <nav class="logs-pagination" aria-label="Login logs pagination">
            <ul>
                <?php if ($currentPage > 1): ?>
                    <li>
                        <a href="<?= esc(
                            $pager->only(['status', 'email', 'from', 'to'])
                                  ->getPageURI($currentPage - 1),
                            'attr'
                        ) ?>">&lt; Previous</a>
                    </li>
                <?php else: ?>
                    <li class="disabled">
                        <span>&lt; Previous</span>
                    </li>
                <?php endif; ?>

                <?php foreach ($pages as $page): ?>
                    <?php if ($page === '...'): ?>
                        <li class="ellipsis">
                            <span>...</span>
                        </li>
                    <?php else: ?>
                        <li class="<?= $page === $currentPage ? 'active' : '' ?>">
                            <?php if ($page === $currentPage): ?>
                                <span><?= $page ?></span>
                            <?php else: ?>
                                <a href="<?= esc(
                                    $pager->only(['status', 'email', 'from', 'to'])
                                          ->getPageURI($page),
                                    'attr'
                                ) ?>"><?= $page ?></a>
                            <?php endif; ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <li>
                        <a href="<?= esc(
                            $pager->only(['status', 'email', 'from', 'to'])
                                  ->getPageURI($currentPage + 1),
                            'attr'
                        ) ?>">Next &gt;</a>
                    </li>
                <?php else: ?>
                    <li class="disabled">
                        <span>Next &gt;</span>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>
