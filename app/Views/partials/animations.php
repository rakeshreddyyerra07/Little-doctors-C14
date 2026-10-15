<!-- animations loaded -->
<style>
/* ===== Little Doctors micro animations (additive) ===== */
body { animation: ldPageIn .45s ease both; }
@keyframes ldPageIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes ldFadeUp { from { opacity: 0; transform: translateY(26px); } to { opacity: 1; transform: none; } }
@keyframes ldSlideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: none; } }
@keyframes ldFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
@keyframes ldPulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.08); } }

/* scroll reveal (classes added by the script below) */
.ld-reveal { opacity: 0; }
.ld-reveal.ld-in { opacity: 1; animation: ldFadeUp .65s cubic-bezier(.2,.7,.2,1) backwards; animation-delay: var(--d, 0ms); }

/* hero entrance + floating image */
.hero > .wrap > div:first-child > * { animation: ldFadeUp .7s cubic-bezier(.2,.7,.2,1) backwards; }
.hero > .wrap > div:first-child > :nth-child(1) { animation-delay: .10s; }
.hero > .wrap > div:first-child > :nth-child(2) { animation-delay: .25s; }
.hero > .wrap > div:first-child > :nth-child(3) { animation-delay: .40s; }
.hero > .wrap > div:first-child > :nth-child(4) { animation-delay: .55s; }
.hero .hero-art .hero-photo { animation: ldFloat 6s ease-in-out infinite; }

/* buttons */
.btn { transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease, color .2s ease; }
.btn:active { transform: translateY(0) scale(.97) !important; }

/* nav underline + chevron */
header.site .links a {
  background-image: linear-gradient(#1fb5a8, #1fb5a8);
  background-repeat: no-repeat; background-position: 0 100%; background-size: 0 2px;
  transition: background-size .3s ease, color .2s ease; padding-bottom: 4px;
}
header.site .links a .icon-chevron { display: inline-block; transition: transform .25s ease; }

/* cards: transitions */
.pillar-row .card, .lab-card, .camp-card, .trust-item, .test-card, .jstep .circle, .event-row, .panel, .stat {
  transition: transform .28s cubic-bezier(.2,.7,.2,1), box-shadow .28s ease;
}
.ic { transition: transform .3s cubic-bezier(.3,1.6,.5,1); }
.camp-photo img { transition: transform .6s ease; }
.lab-card .go, .camp-body .btn { display: inline-block; transition: transform .25s ease; }
.stars { display: inline-block; transform-origin: left center; transition: transform .25s ease; }
.avatar-stack span { transition: transform .25s cubic-bezier(.3,1.6,.5,1); }
.jstep.trophy .circle { animation: ldPulse 2.6s ease-in-out infinite; }

/* hover (mouse devices) */
@media (hover: hover) {
  header.site .links a:hover { background-size: 100% 2px; }
  header.site .links a:hover .icon-chevron { transform: rotate(180deg); }
  .btn:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(18,48,90,.18); }

  .pillar-row .card:hover, .lab-card:hover, .camp-card:hover, .trust-item:hover,
  .test-card:hover, .event-row:hover, .stat:hover {
    transform: translateY(-8px); box-shadow: 0 16px 32px rgba(18,48,90,.14);
  }
  .pillar-row .card:hover .ic, .lab-card:hover .ic, .trust-item:hover .ic { transform: scale(1.14) rotate(-6deg); }
  .camp-card:hover .camp-photo img { transform: scale(1.08); }
  .lab-card:hover .go { transform: translateX(6px); }
  .test-card:hover .stars { transform: scale(1.12); }
  .jstep:hover .circle { transform: translateY(-8px) scale(1.07); }
  .avatar-stack span:hover { transform: translateY(-5px) scale(1.12); }

  /* any other card-like element (dashboard, enrollment, etc.), skipping tables and forms */
  [class*="card"]:not(.pillar-row .card):not(.lab-card):not(.camp-card):not(.test-card):not(:has(table)):not(:has(form)):not(:has(input)):not(:has(textarea)) {
    transition: transform .28s cubic-bezier(.2,.7,.2,1), box-shadow .28s ease;
  }
  [class*="card"]:not(.lab-card):not(.camp-card):not(.test-card):not(:has(table)):not(:has(form)):not(:has(input)):not(:has(textarea)):hover {
    transform: translateY(-6px); box-shadow: 0 14px 28px rgba(18,48,90,.13);
  }
}

/* inputs */
input:not([type="checkbox"]):not([type="radio"]):not([type="hidden"]), textarea, select {
  transition: border-color .2s ease, box-shadow .2s ease;
}
input:not([type="checkbox"]):not([type="radio"]):not([type="hidden"]):focus, textarea:focus, select:focus {
  outline: none; border-color: #1fb5a8; box-shadow: 0 0 0 3px rgba(31,181,168,.2);
}
.server-errors, .alert-err, .alert-ok, .msg-ok, .msg-err { animation: ldSlideDown .4s ease both; }

@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after { animation: none !important; transition: none !important; }
  .ld-reveal { opacity: 1 !important; }
}
</style>

<script>
(function () {
  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduce || !('IntersectionObserver' in window)) { return; }

  var sel = [
    '.page-hero .wrap > *', '.pillars-head', '.pillar-row .card', '.journey h2', '.jstep',
    '.section-head', '.lab-card', '.camp-card', '.camps-foot', '.trust-item', '.test-card',
    '.final-cta .wrap > *', '.event-row', '.panel', '.stat'
  ].join(',');

  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (en) {
      if (!en.isIntersecting) { return; }
      var el = en.target;
      el.classList.add('ld-in');
      el.addEventListener('animationend', function done() {
        el.classList.remove('ld-reveal', 'ld-in');
        el.style.removeProperty('--d');
        el.removeEventListener('animationend', done);
      });
      io.unobserve(el);
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

  document.querySelectorAll(sel).forEach(function (el) {
    var i = Array.prototype.indexOf.call(el.parentNode.children, el);
    el.style.setProperty('--d', Math.min(i, 6) * 90 + 'ms');
    el.classList.add('ld-reveal');
    io.observe(el);
  });

  // count-up for "10,000+"
  var c = document.querySelector('.avatars .count');
  if (c && c.firstChild && c.firstChild.nodeType === 3) {
    var node = c.firstChild, m = node.nodeValue.match(/[\d,]+/);
    if (m) {
      var target = parseInt(m[0].replace(/,/g, ''), 10);
      var pre = node.nodeValue.slice(0, m.index), post = node.nodeValue.slice(m.index + m[0].length);
      var started = false;
      var cio = new IntersectionObserver(function (e) {
        if (!e[0].isIntersecting || started) { return; }
        started = true;
        var t0 = null;
        (function tick(ts) {
          if (t0 === null) { t0 = ts; }
          var p = Math.min((ts - t0) / 1400, 1);
          node.nodeValue = pre + Math.round(target * (1 - Math.pow(1 - p, 3))).toLocaleString('en-US') + post;
          if (p < 1) { requestAnimationFrame(tick); }
        })(performance.now());
        cio.disconnect();
      }, { threshold: 0.4 });
      cio.observe(c);
    }
  }
})();
</script>