<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .set-card { background:#fff; border:1px solid var(--line); border-radius:14px; padding:20px; margin-bottom:18px; }
    .set-card h3 { margin:0 0 14px; text-transform:capitalize; }
    .row { display:grid; grid-template-columns:200px 1fr; gap:12px; align-items:start; margin-bottom:12px; }
    .row label { font-size:14px; color:var(--gray); padding-top:10px; text-transform:capitalize; }
    .row input, .row textarea { width:100%; padding:10px; border:1px solid var(--line); border-radius:8px; font:inherit; box-sizing:border-box; }
    .btn-save { background:var(--teal); color:#fff; border:0; padding:11px 26px; border-radius:8px; cursor:pointer; font-size:15px; }
    .msg-ok { background:#d1fae5; color:#065f46; padding:10px 14px; border-radius:10px; margin-bottom:14px; }
    .msg-err { background:#fee2e2; color:#991b1b; padding:10px 14px; border-radius:10px; margin-bottom:14px; }
    @media (max-width:640px) { .row { grid-template-columns:1fr; } .row label { padding-top:0; } }
</style>

<h1>Site Settings</h1>

<?php if (session()->getFlashdata('success')): ?>
    <div class="msg-ok"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('errors')): ?>
    <div class="msg-err"><?php foreach (session()->getFlashdata('errors') as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?></div>
<?php endif; ?>

<form method="post" action="<?= base_url('admin/settings') ?>">
    <?= csrf_field() ?>

    <?php foreach ($grouped as $group => $items): ?>
        <div class="set-card">
            <h3><?= esc($group) ?></h3>
            <?php foreach ($items as $s): ?>
                <?php $long = in_array($s['setting_key'], ['address', 'footer_text', 'map_embed_url', 'about_text'], true); ?>
                <div class="row">
                    <label for="s_<?= esc($s['setting_key']) ?>"><?= esc(str_replace('_', ' ', $s['setting_key'])) ?></label>
                    <?php if ($long): ?>
                        <textarea id="s_<?= esc($s['setting_key']) ?>" name="settings[<?= esc($s['setting_key']) ?>]" rows="3"><?= esc($s['setting_value']) ?></textarea>
                    <?php else: ?>
                        <input type="text" id="s_<?= esc($s['setting_key']) ?>" name="settings[<?= esc($s['setting_key']) ?>]" value="<?= esc($s['setting_value']) ?>">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>

    <button type="submit" class="btn-save">Save settings</button>
</form>

<?= $this->endSection() ?>