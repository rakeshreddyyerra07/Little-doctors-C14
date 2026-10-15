<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .sl-panel { background:#fff; border:1px solid var(--line); border-radius:14px; padding:24px; max-width:760px; }
    .sl-row { margin-bottom:16px; }
    .sl-row label.sl-label { display:block; font-size:14px; font-weight:bold; margin-bottom:6px; }
    .sl-row input[type=text], .sl-row input[type=number], .sl-row textarea {
        width:100%; padding:10px; border:1px solid var(--line); border-radius:8px; font:inherit; box-sizing:border-box;
    }
    .sl-row input[type=file] { margin-bottom:8px; }
    .sl-hint { font-size:12px; color:var(--gray); margin-top:4px; }
    .sl-check { display:flex; gap:8px; align-items:center; font-size:14px; }
    .sl-preview { width:200px; max-height:140px; object-fit:contain; border-radius:8px; display:block; margin-bottom:8px; background:#e5e7eb; }
    .sl-two { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    @media (max-width:640px) { .sl-two { grid-template-columns:1fr; } }
    .sl-buttons { display:flex; gap:10px; margin-top:8px; }
    .sl-btn { background:var(--teal); color:#fff; text-decoration:none; padding:10px 22px; border-radius:8px; border:0; cursor:pointer; font-size:14px; display:inline-block; font-family:inherit; }
    .sl-btn.sec { background:#fff; color:var(--navy); border:1px solid var(--line); }
    .msg-err { background:#fee2e2; color:#991b1b; padding:10px 14px; border-radius:10px; margin-bottom:14px; max-width:760px; }
</style>

<?php
$v = static function (string $key, $default = '') use ($row) {
    $old = old($key, null, false);

    return $old !== null ? $old : ($row[$key] ?? $default);
};
?>

<h1><?= $id ? 'Edit' : 'Add' ?> Slide</h1>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="msg-err"><?php foreach (session()->getFlashdata('errors') as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?></div>
<?php endif; ?>

<form class="sl-panel" method="post" enctype="multipart/form-data" action="<?= base_url('admin/slides/save') ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $id ?>">

    <div class="sl-row">
        <label class="sl-label" for="title">Title *</label>
        <input type="text" id="title" name="title" value="<?= esc($v('title')) ?>">
        <div class="sl-hint">Use | for a new line and {{ }} around the coloured words. Example: Big knowledge | for {{little doctors.}}</div>
    </div>

    <div class="sl-row">
        <label class="sl-label" for="subtitle">Small heading above the title (optional)</label>
        <input type="text" id="subtitle" name="subtitle" value="<?= esc($v('subtitle')) ?>">
    </div>

    <div class="sl-row">
        <label class="sl-label" for="description">Description</label>
        <textarea id="description" name="description" rows="4"><?= esc($v('description')) ?></textarea>
    </div>

    <div class="sl-row">
        <label class="sl-label">Slide picture</label>
        <?php if (! empty($row['image'])): ?>
            <img class="sl-preview" src="<?= base_url($row['image']) ?>" alt="">
        <?php endif; ?>
        <input type="file" name="image_file" accept="image/*">
        <input type="text" name="image" value="<?= esc($v('image')) ?>" placeholder="or type a path, e.g. assets/images/hero-kids.png">
        <div class="sl-hint">Upload a picture (JPG, PNG, WEBP or GIF, max 2 MB), or type a path inside the public folder. Clear the path to remove the picture.</div>
    </div>

    <div class="sl-two">
        <div class="sl-row">
            <label class="sl-label" for="button_text">Button 1 text</label>
            <input type="text" id="button_text" name="button_text" value="<?= esc($v('button_text')) ?>">
        </div>
        <div class="sl-row">
            <label class="sl-label" for="button_link">Button 1 link</label>
            <input type="text" id="button_link" name="button_link" value="<?= esc($v('button_link')) ?>" placeholder="#lab or camps">
        </div>
        <div class="sl-row">
            <label class="sl-label" for="button2_text">Button 2 text</label>
            <input type="text" id="button2_text" name="button2_text" value="<?= esc($v('button2_text')) ?>">
        </div>
        <div class="sl-row">
            <label class="sl-label" for="button2_link">Button 2 link</label>
            <input type="text" id="button2_link" name="button2_link" value="<?= esc($v('button2_link')) ?>" placeholder="#camps or contact">
        </div>
    </div>

    <div class="sl-row">
        <label class="sl-label" for="sort_order">Sort order</label>
        <input type="number" id="sort_order" name="sort_order" value="<?= esc($v('sort_order', 0)) ?>">
        <div class="sl-hint">Lower numbers appear first.</div>
    </div>

    <div class="sl-row">
        <input type="hidden" name="is_active" value="0">
        <label class="sl-check">
            <input type="checkbox" name="is_active" value="1" <?= (string) $v('is_active', 1) === '1' ? 'checked' : '' ?>>
            Visible on the website
        </label>
    </div>

    <div class="sl-buttons">
        <button type="submit" class="sl-btn">Save</button>
        <a class="sl-btn sec" href="<?= base_url('admin/slides') ?>">Cancel</a>
    </div>
</form>

<?= $this->endSection() ?>