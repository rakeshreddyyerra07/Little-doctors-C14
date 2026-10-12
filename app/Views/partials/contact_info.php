
<div class="contact-info">

    <?php if (! empty($settings['contact_email'])): ?>
        <p>
            <strong>Email:</strong>
            <a href="mailto:<?= esc($settings['contact_email'], 'attr') ?>">
                <?= esc($settings['contact_email']) ?>
            </a>
        </p>
    <?php endif; ?>

    <?php if (! empty($settings['contact_phone'])): ?>
        <p>
            <strong>Phone:</strong>
            <a href="tel:<?= esc($settings['contact_phone'], 'attr') ?>">
                <?= esc($settings['contact_phone']) ?>
            </a>
        </p>
    <?php endif; ?>

    <?php if (! empty($settings['contact_address'])): ?>
        <p>
            <strong>Address:</strong>
            <?= esc($settings['contact_address']) ?>
        </p>
    <?php endif; ?>

    <?php if (! empty($settings['contact_hours'])): ?>
        <p>
            <strong>Hours:</strong>
            <?= esc($settings['contact_hours']) ?>
        </p>
    <?php endif; ?>

</div>
