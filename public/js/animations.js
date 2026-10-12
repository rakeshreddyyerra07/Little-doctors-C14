
(function () {
    'use strict';

    var reduce = window.matchMedia &&
        window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Respect reduced-motion preferences and support older browsers.
    if (reduce || !('IntersectionObserver' in window)) {
        return;
    }

    /* =========================================================
       SCROLL REVEAL
    ========================================================= */

    var selectors = [
        '.page-hero .wrap > *',
        '.pillars-head',
        '.pillar-row .card',
        '.journey h2',
        '.jstep',
        '.section-head',
        '.lab-card',
        '.camp-card',
        '.camps-foot',
        '.trust-item',
        '.test-card',
        '.final-cta .wrap > *',
        '.event-row',
        '.panel',
        '.stat',
        '.dcard'
    ].join(',');

    var items = document.querySelectorAll(selectors);

    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) {
                return;
            }

            var el = entry.target;

            // Start the entrance animation.
            el.classList.add('in');

            function finishReveal() {
                el.classList.remove('reveal', 'in');
                el.style.removeProperty('--d');
                el.removeEventListener('animationend', finishReveal);
            }

            el.addEventListener('animationend', finishReveal);

            // Fallback: prevent an element from staying invisible
            // if its animation event does not fire.
            window.setTimeout(function () {
                if (el.classList.contains('reveal')) {
                    finishReveal();
                }
            }, 1200);

            // Animate each element only once.
            io.unobserve(el);
        });
    }, {
        threshold: 0.12,
        rootMargin: '0px 0px -40px 0px'
    });

    items.forEach(function (el) {
        var index = Array.prototype.indexOf.call(
            el.parentNode.children,
            el
        );

        // Stagger neighboring cards slightly.
        el.style.setProperty(
            '--d',
            Math.min(index, 6) * 90 + 'ms'
        );

        el.classList.add('reveal');
        io.observe(el);
    });

    /* =========================================================
       COUNT-UP ANIMATION
       For numbers such as "10,000+"
    ========================================================= */

    var counter = document.querySelector('.avatars .count');

    if (counter && counter.firstChild &&
        counter.firstChild.nodeType === 3) {

        var node = counter.firstChild;
        var match = node.nodeValue.match(/[\d,]+/);

        if (match) {
            var target = parseInt(
                match[0].replace(/,/g, ''),
                10
            );

            var before = node.nodeValue.slice(0, match.index);

            var after = node.nodeValue.slice(
                match.index + match[0].length
            );

            var started = false;

            var cio = new IntersectionObserver(function (entries) {
                if (!entries[0].isIntersecting || started) {
                    return;
                }

                started = true;

                var duration = 1400;
                var t0 = null;

                function tick(ts) {
                    if (t0 === null) {
                        t0 = ts;
                    }

                    var p = Math.min(
                        (ts - t0) / duration,
                        1
                    );

                    // Ease out smoothly.
                    var eased = 1 - Math.pow(1 - p, 3);

                    node.nodeValue =
                        before +
                        Math.round(target * eased).toLocaleString('en-US') +
                        after;

                    if (p < 1) {
                        requestAnimationFrame(tick);
                    }
                }

                requestAnimationFrame(tick);
                cio.disconnect();
            }, {
                threshold: 0.4
            });

            cio.observe(counter);
        }
    }
})();
