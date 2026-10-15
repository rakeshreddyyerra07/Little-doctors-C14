<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .ac-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; gap:12px; flex-wrap:wrap; }
    .ac-head h1 { margin:0; }
    .ac-btn { background:var(--teal); color:#fff; text-decoration:none; padding:10px 18px; border-radius:8px; border:0; cursor:pointer; font-size:14px; display:inline-block; font-family:inherit; }
    .ac-btn.sec { background:#fff; color:var(--navy); border:1px solid var(--line); }
    .ac-btn.danger { background:#fee2e2; color:#991b1b; }
    .ac-btn.small { padding:6px 12px; font-size:13px; }
    .ac-thumb { width:56px; height:42px; object-fit:cover; border-radius:6px; background:#e5e7eb; display:block; }
    .ac-actions { display:flex; gap:8px; align-items:center; }
    .ac-actions form { margin:0; }
    .msg-ok { background:#d1fae5; color:#065f46; padding:10px 14px; border-radius:10px; margin-bottom:14px; }
    .msg-err { background:#fee2e2; color:#991b1b; padding:10px 14px; border-radius:10px; margin-bottom:14px; }
    .badge-btn { border:0; cursor:pointer; font-family:inherit; }
</style>

<div class="ac-head">
    <h1><?= esc($cfg['title']) ?></h1>
    <a class="ac-btn" href="<?= base_url('admin/content/' . $res . '/new') ?>">+ Add <?= esc($cfg['single']) ?></a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="msg-ok"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('errors')): ?>
    <div class="msg-err"><?php foreach (session()->getFlashdata('errors') as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?></div>
<?php endif; ?>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <?php if ($imageField): ?><th>Image</th><?php endif; ?>
                <?php foreach ($listCols as $label): ?><th><?= esc($label) ?></th><?php endforeach; ?>
                <?php if ($activeCol): ?><th>Status</th><?php endif; ?>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($rows)): ?>
            <tr><td colspan="<?= 3 + count($listCols) + ($imageField ? 1 : 0) ?>">Nothing here yet. Click "Add <?= esc($cfg['single']) ?>" to create the first one.</td></tr>
        <?php else: foreach ($rows as $r): ?>
            <tr>
                <td><?= (int) $r['id'] ?></td>

                <?php if ($imageField): ?>
                    <td><?php if (! empty($r[$imageField])): ?><img class="ac-thumb" src="<?= base_url($r[$imageField]) ?>" alt=""><?php endif; ?></td>
                <?php endif; ?>

                <?php foreach ($listCols as $k => $label): ?>
                    <td><?= esc($r[$k] ?? '') ?></td>
                <?php endforeach; ?>

                <?php if ($activeCol): ?>
                    <td>
                        <form method="post" action="<?= base_url('admin/content/' . $res . '/toggle/' . $r['id']) ?>">
                            <?= csrf_field() ?>
                            <?php $on = (int) $r[$activeCol] === 1; ?>
                            <button type="submit" class="badge badge-btn <?= $on ? 'success' : 'failed' ?>" title="Click to change"><?= $on ? 'Visible' : 'Hidden' ?></button>
                        </form>
                    </td>
                <?php endif; ?>

                <td>
                    <div class="ac-actions">
                        <a class="ac-btn sec small" href="<?= base_url('admin/content/' . $res . '/edit/' . $r['id']) ?>">Edit</a>
                        <form method="post" action="<?= base_url('admin/content/' . $res . '/delete/' . $r['id']) ?>"
                              onsubmit="return confirm('Delete this item? This cannot be undone.');">
                            <?= csrf_field() ?>
                            <button type="submit" class="ac-btn danger small">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>