<?php
helper('format');

$slides = [];

try {
    $slides = active_rows('hero_slides');
} catch (\Throwable $e) {
    $slides = [];
}

if (empty($slides)):
?>

<!-- fallback: your original hero, used when no slides are active -->
<section class="hero">

  <div class="wrap">

    <!-- HERO TEXT -->
    <div>

      <h1>
        Big knowledge<br>
        for <span class="accent">little doctors.</span>
      </h1>

      <p>
        Explore the human body, discover how to stay healthy, and learn how your knowledge can help others.
      </p>

      <div class="cta-row">
        <a class="btn btn-solid" href="#lab">Explore the Program →</a>
        <a class="btn btn-outline" href="#camps">Find a Camp Near You</a>
      </div>

      <div class="avatars">

        <div class="avatar-stack">
          <span style="background:var(--coral)">A</span>
          <span style="background:var(--teal)">N</span>
          <span style="background:var(--purple)">D</span>
          <span style="background:var(--yellow)">R</span>
        </div>

        <div class="count">
          10,000+
          <small>Little Doctors and growing!</small>
        </div>

      </div>

    </div>


    <!-- HERO IMAGE -->
    <div class="hero-art">

      <div class="blob"></div>

      <img
        src="<?= base_url('assets/images/hero-kids.png') ?>?v=2"
        alt="Four kids in lab coats with stethoscopes and a teddy bear"
        class="hero-photo"
      >

      <!-- BADGE 1 -->
      <div class="badge b1">
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--coral)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20.8 8.6c0 5-8.8 10.4-8.8 10.4S3.2 13.6 3.2 8.6a5 5 0 0 1 9-3 5 5 0 0 1 8.6 3z"/>
          <path d="M3 12h4l2 4 3-8 2 4h5"/>
        </svg>
      </div>

      <!-- BADGE 2 -->
      <div class="badge b2">
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--navy)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 4a3 3 0 0 0-3 3v1a3 3 0 0 0-2 5v4a3 3 0 0 0 3 3h1"/>
          <path d="M15 4a3 3 0 0 1 3 3v1a3 3 0 0 1 2 5v4a3 3 0 0 1-3 3h-1"/>
          <path d="M9 4a3 3 0 0 1 6 0v13a3 3 0 0 1-6 0z"/>
        </svg>
      </div>

      <!-- BADGE 3 -->
      <div class="badge b3">
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M8 3c-3 4-4 8-2 13 1 2.5 3.5 4 5 5-3-6 0-10 3-12"/>
          <path d="M16 3c3 4 4 8 2 13-1 2.5-3.5 4-5 5"/>
        </svg>
      </div>

      <!-- BADGE 4 -->
      <div class="badge b4">
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--yellow)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="9"/>
          <path d="M12 7v5l3 3"/>
        </svg>
      </div>

    </div>

  </div>

</section>

<?php
    return;
endif;

/** Title markup: | = line break, {{text}} = coloured text. Escaped first, so it is safe. */
$fmt = static function (string $t): string {
    $t = esc($t);
    $t = str_replace('|', '<br>', $t);

    return preg_replace('/\{\{(.+?)\}\}/', '<span class="accent">$1</span>', $t);
};

/** #anchor and https:// links are used as they are, anything else is a page on this site. */
$link = static function (?string $l): string {
    $l = trim((string) $l);

    if ($l === '') {
        return '#';
    }

    if ($l[0] === '#' || preg_match('#^https?://#i', $l)) {
        return esc($l, 'attr');
    }

    return esc(base_url(ltrim($l, '/')), 'attr');
};
?>
<style>
    .hero-slider .hero-slide:not(.is-active) { display: none !important; }
    .hero-slider .hero-slide.is-active { animation: heroSlideIn .6s ease both; }
    @keyframes heroSlideIn { from { opacity: 0; } to { opacity: 1; } }

    .hero-kicker { font-weight: 800; font-size: 13px; letter-spacing: .6px; text-transform: uppercase; color: var(--teal); margin-bottom: 8px; }

    .hero-dots { display: flex; justify-content: center; gap: 10px; padding: 6px 0 0; }
    .hero-dot { width: 10px; height: 10px; padding: 0; border: 0; border-radius: 50%; background: #c9d6e8; cursor: pointer; transition: transform .2s ease, background .2s ease; }
    .hero-dot.is-active { background: var(--teal); transform: scale(1.35); }
</style>

<section class="hero hero-slider">

  <?php foreach ($slides as $i => $s):
      $plainTitle = trim(str_replace(['|', '{{', '}}'], [' ', '', ''], (string) ($s['title'] ?? '')));
  ?>
    <div class="wrap hero-slide<?= $i === 0 ? ' is-active' : '' ?>">

      <!-- TEXT -->
      <div>

        <?php if (! empty($s['subtitle'])): ?>
          <div class="hero-kicker"><?= esc($s['subtitle']) ?></div>
        <?php endif; ?>

        <h1><?= $fmt((string) ($s['title'] ?? '')) ?></h1>

        <?php if (! empty($s['description'])): ?>
          <p><?= esc($s['description']) ?></p>
        <?php endif; ?>

        <?php if (! empty($s['button_text']) || ! empty($s['button2_text'])): ?>
          <div class="cta-row">
            <?php if (! empty($s['button_text'])): ?>
              <a class="btn btn-solid" href="<?= $link($s['button_link'] ?? '') ?>"><?= esc($s['button_text']) ?></a>
            <?php endif; ?>
            <?php if (! empty($s['button2_text'])): ?>
              <a class="btn btn-outline" href="<?= $link($s['button2_link'] ?? '') ?>"><?= esc($s['button2_text']) ?></a>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <div class="avatars">

          <div class="avatar-stack">
            <span style="background:var(--coral)">A</span>
            <span style="background:var(--teal)">N</span>
            <span style="background:var(--purple)">D</span>
            <span style="background:var(--yellow)">R</span>
          </div>

          <div class="count">
            10,000+
            <small>Little Doctors and growing!</small>
          </div>

        </div>

      </div>

      <!-- IMAGE -->
      <div class="hero-art">
        <?php if (! empty($s['image'])): ?>
          <img src="<?= esc(base_url($s['image']), 'attr') ?>" alt="<?= esc($plainTitle) ?>" class="hero-photo">
        <?php endif; ?>
      </div>

    </div>
  <?php endforeach; ?>

  <?php if (count($slides) > 1): ?>
    <div class="hero-dots">
      <?php foreach ($slides as $i => $s): ?>
        <button type="button" class="hero-dot<?= $i === 0 ? ' is-active' : '' ?>" aria-label="Show slide <?= $i + 1 ?>"></button>
      <?php endforeach; ?>
    </div>

    <script>
    (function () {
        var root = document.querySelector('.hero-slider');
        if (!root) { return; }

        var slides = root.querySelectorAll('.hero-slide');
        var dots   = root.querySelectorAll('.hero-dot');
        var cur    = 0;
        var timer  = null;

        function show(n) {
            slides[cur].classList.remove('is-active');
            dots[cur].classList.remove('is-active');
            cur = (n + slides.length) % slides.length;
            slides[cur].classList.add('is-active');
            dots[cur].classList.add('is-active');
        }

        function start() {
            if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) { return; }
            stop();
            timer = setInterval(function () { show(cur + 1); }, 6000);
        }

        function stop() { if (timer) { clearInterval(timer); timer = null; } }

        dots.forEach(function (d, i) {
            d.addEventListener('click', function () { stop(); show(i); start(); });
        });

        root.addEventListener('mouseenter', stop);
        root.addEventListener('mouseleave', start);

        start();
    })();
    </script>
  <?php endif; ?>

</section>