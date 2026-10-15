<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .sl-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; gap:12px; flex-wrap:wrap; }
    .sl-head h1 { margin:0; }
    .sl-btn { background:var(--teal); color:#fff; text-decoration:none; padding:10px 18px; border-radius:8px; border:0; cursor:pointer; font-size:14px; display:inline-block; font-family:inherit; }
    .sl-btn.sec { background:#fff; color:var(--navy); border:1px solid var(--line); }
    .sl-btn.danger { background:#fee2e2; color:#991b1b; }
    .sl-btn.small { padding:6px 12px; font-size:13px; }
    .sl-thumb { width:72px; height:48px; object-fit:cover; border-radius:6px; background:#e5e7eb; display:block; }
    .sl-actions { display:flex; gap:8px; align-items:center; }
    .sl-actions form { margin:0; }
    .msg-ok { background:#d1fae5; color:#065f46; padding:10px 14px; border-radius:10px; margin-bottom:14px; }
    .msg-err { background:#fee2e2; color:#991b1b; padding:10px 14px; border-radius:10px; margin-bottom:14px; }
    .badge-btn { border:0; cursor:pointer; font-family:inherit; }
</style>

<div class="sl-head">
    <h1>Home Slides</h1>
    <a class="sl-btn" href="<?= base_url('admin/slides/new') ?>">+ Add Slide</a>
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
            <tr><th>Order</th><th>Picture</th><th>Title</th><th>Button</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php if (empty($rows)): ?>
            <tr><td colspan="6">No slides yet. Until you add one, the home page shows its original hero. Click "Add Slide" to create the first slide.</td></tr>
        <?php else: foreach ($rows as $r): ?>
            <tr>
                <td><?= (int) $r['sort_order'] ?></td>
                <td><?php if (! empty($r['image'])): ?><img class="sl-thumb" src="<?= base_url($r['image']) ?>" alt=""><?php endif; ?></td>
                <td><?= esc(str_replace(['|', '{{', '}}'], [' ', '', ''], $r['title'])) ?></td>
                <td><?= esc($r['button_text'] ?? '') ?></td>
                <td>
                    <form method="post" action="<?= base_url('admin/slides/toggle/' . $r['id']) ?>">
                        <?= csrf_field() ?>
                        <?php $on = (int) $r['is_active'] === 1; ?>
                        <button type="submit" class="badge badge-btn <?= $on ? 'success' : 'failed' ?>" title="Click to change"><?= $on ? 'Visible' : 'Hidden' ?></button>
                    </form>
                </td>
                <td>
                    <div class="sl-actions">
                        <a class="sl-btn sec small" href="<?= base_url('admin/slides/edit/' . $r['id']) ?>">Edit</a>
                        <form method="post" action="<?= base_url('admin/slides/delete/' . $r['id']) ?>"
                              onsubmit="return confirm('Delete this slide? This cannot be undone.');">
                            <?= csrf_field() ?>
                            <button type="submit" class="sl-btn danger small">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>