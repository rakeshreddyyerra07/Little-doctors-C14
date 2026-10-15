<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .ac-panel { background:#fff; border:1px solid var(--line); border-radius:14px; padding:24px; max-width:760px; }
    .ac-row { margin-bottom:16px; }
    .ac-row label.ac-label { display:block; font-size:14px; font-weight:bold; margin-bottom:6px; }
    .ac-row input[type=text], .ac-row input[type=number], .ac-row input[type=date], .ac-row textarea {
        width:100%; padding:10px; border:1px solid var(--line); border-radius:8px; font:inherit; box-sizing:border-box;
    }
    .ac-row input[type=file] { margin-bottom:8px; }
    .ac-hint { font-size:12px; color:var(--gray); margin-top:4px; }
    .ac-check { display:flex; gap:8px; align-items:center; font-size:14px; }
    .ac-preview { width:140px; height:100px; object-fit:cover; border-radius:8px; display:block; margin-bottom:8px; background:#e5e7eb; }
    .ac-buttons { display:flex; gap:10px; margin-top:8px; }
    .ac-btn { background:var(--teal); color:#fff; text-decoration:none; padding:10px 22px; border-radius:8px; border:0; cursor:pointer; font-size:14px; display:inline-block; font-family:inherit; }
    .ac-btn.sec { background:#fff; color:var(--navy); border:1px solid var(--line); }
    .msg-err { background:#fee2e2; color:#991b1b; padding:10px 14px; border-radius:10px; margin-bottom:14px; max-width:760px; }
</style>

<h1><?= $id ? 'Edit' : 'Add' ?> <?= esc($cfg['single']) ?></h1>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="msg-err"><?php foreach (session()->getFlashdata('errors') as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?></div>
<?php endif; ?>

<form class="ac-panel" method="post" enctype="multipart/form-data"
      action="<?= base_url('admin/content/' . $res . '/save') ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $id ?>">

    <?php foreach ($fields as $f):
        $name = $f['name'];
        $col  = $f['col'];
        $val  = old($name, null, false);

        if ($val === null) {
            $val = $row[$col] ?? ($f['default'] ?? '');
        }
    ?>
        <div class="ac-row">

            <?php if ($f['type'] === 'checkbox'): ?>
                <input type="hidden" name="<?= esc($name) ?>" value="0">
                <label class="ac-check">
                    <input type="checkbox" name="<?= esc($name) ?>" value="1" <?= (string) $val === '1' ? 'checked' : '' ?>>
                    <?= esc($f['label']) ?>
                </label>

            <?php elseif ($f['type'] === 'image'): ?>
                <label class="ac-label"><?= esc($f['label']) ?></label>
                <?php if (! empty($row[$col])): ?>
                    <img class="ac-preview" src="<?= base_url($row[$col]) ?>" alt="">
                <?php endif; ?>
                <input type="file" name="<?= esc($name) ?>_file" accept="image/*">
                <input type="text" name="<?= esc($name) ?>" value="<?= esc($val) ?>"
                       placeholder="or type a path, e.g. assets/images/camp-1.jpg">
                <div class="ac-hint">Upload a picture (JPG, PNG, WEBP or GIF, max 2 MB), or type a path inside the public folder. Clear the path to remove the picture.</div>

            <?php elseif ($f['type'] === 'textarea'): ?>
                <label class="ac-label" for="f_<?= esc($name) ?>"><?= esc($f['label']) ?><?= ! empty($f['required']) ? ' *' : '' ?></label>
                <textarea id="f_<?= esc($name) ?>" name="<?= esc($name) ?>" rows="4"><?= esc($val) ?></textarea>

            <?php else: ?>
                <label class="ac-label" for="f_<?= esc($name) ?>"><?= esc($f['label']) ?><?= ! empty($f['required']) ? ' *' : '' ?></label>
                <input id="f_<?= esc($name) ?>" type="<?= $f['type'] === 'number' ? 'number' : ($f['type'] === 'date' ? 'date' : 'text') ?>"
                       name="<?= esc($name) ?>" value="<?= esc($val) ?>"
                       <?= $f['type'] === 'number' ? 'step="any"' : '' ?>
                       <?= isset($f['min']) ? 'min="' . (int) $f['min'] . '"' : '' ?>
                       <?= isset($f['max']) && $f['type'] === 'number' ? 'max="' . (int) $f['max'] . '"' : '' ?>>
            <?php endif; ?>

            <?php if (! empty($f['hint'])): ?><div class="ac-hint"><?= esc($f['hint']) ?></div><?php endif; ?>
        </div>
    <?php endforeach; ?>

    <div class="ac-buttons">
        <button type="submit" class="ac-btn">Save</button>
        <a class="ac-btn sec" href="<?= base_url('admin/content/' . $res) ?>">Cancel</a>
    </div>
</form>

<?= $this->endSection() ?>