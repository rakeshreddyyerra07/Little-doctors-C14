
<div class="social-links">
    <?php
    $socialLinks = [
        'facebook_url'  => 'Facebook',
        'instagram_url' => 'Instagram',
        'youtube_url'   => 'YouTube',
        'linkedin_url'  => 'LinkedIn',
        'tiktok_url'    => 'TikTok',
    ];
    ?>

    <?php foreach ($socialLinks as $key => $label): ?>
        <?php
        $url = trim((string) ($settings[$key] ?? ''));

        // Only display valid HTTP or HTTPS links.
        if (! preg_match('#^https?://#i', $url)) {
            continue;
        }
        ?>

        <a
            href="<?= esc($url, 'attr') ?>"
            target="_blank"
            rel="noopener noreferrer"
        ><?= esc($label) ?></a>
    <?php endforeach; ?>
</div>
