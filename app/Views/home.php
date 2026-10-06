<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>

/* =========================================================
   HERO IMAGE POSITION
   Only affects the Home page hero.
   Existing functionality is unchanged.
========================================================= */

.hero > .wrap {
    display: grid !important;
    grid-template-columns: 0.95fr 1.05fr !important;
    align-items: center !important;
    gap: 0 !important;
}

.hero-art {
    position: relative !important;
    display: flex !important;
    align-items: center !important;
    justify-content: flex-start !important;
    width: 100% !important;
    min-height: 520px !important;

    /* Move image closer to the text */
    transform: translateX(-35px) !important;
}

.hero-photo {
    display: block !important;

    width: 480px !important;
    height: 500px !important;

    max-width: 500px !important;
    max-height: 500px !important;

    object-fit: contain !important;
    object-position: center !important;

    /* Circular image */
    border-radius: 50% !important;

    box-shadow: none !important;

    opacity: 1 !important;
    visibility: visible !important;

    position: relative !important;
    z-index: 2 !important;
}

.blob {
    position: absolute !important;
    z-index: 1 !important;
}

.badge {
    position: absolute !important;
    z-index: 3 !important;
}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 800px) {

    .hero > .wrap {
        grid-template-columns: 1fr !important;
        gap: 20px !important;
        text-align: center;
    }

    .hero-art {
        min-height: auto !important;
        transform: none !important;
        justify-content: center !important;
        margin-top: 10px;
    }

    .hero-photo {
        width: 380px !important;
        height: 380px !important;
        max-width: 100% !important;
        max-height: 380px !important;
    }

    .cta-row {
        justify-content: center;
    }

    .avatars {
        justify-content: center;
    }

}

@media (max-width: 500px) {

    .hero-photo {
        width: 330px !important;
        height: 330px !important;
        max-height: 330px !important;
    }

}


/* =========================================================
   CAMP PHOTOS
========================================================= */

.camp-photo {
    position: relative !important;
    overflow: hidden;
}

.camp-photo img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.camp-photo .camp-tag {
    position: absolute;
    z-index: 2;
}


/* =========================================================
   TESTIMONIAL PHOTOS (new)
========================================================= */

.test-who .t-photo {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    flex: none;
    background: #e2e8f0;
    border: 2px solid #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,.15);
}


/* =========================================================
   HERO ART - MATCH PROTOTYPE (new, appended)
   Light-blue circle behind the kids, kids shown uncropped
   (not clipped into a circle), 4 floating icon badges.
   Desktop only; mobile rules above are untouched.
========================================================= */

@media (min-width: 801px) {

    .hero-art {
        justify-content: center !important;
        transform: translateX(-20px) !important;
        min-height: 540px !important;
    }

    /* light-blue circle behind the kids */
    .hero-art .blob {
        width: 400px !important;
        height: 400px !important;
        top: 50% !important;
        left: 50% !important;
        right: auto !important;
        bottom: auto !important;
        margin: -215px 0 0 -170px !important;
        border-radius: 50% !important;
        background: radial-gradient(circle at 40% 35%, #d6ebff 0%, #bde0ff 55%, #a9d6fb 100%) !important;
        opacity: 1 !important;
    }

    /* kids picture: no circular crop, natural shape, soft shadow */
    .hero-art .hero-photo {
        width: 100% !important;
        height: auto !important;
        max-width: 520px !important;
        max-height: none !important;
        border-radius: 0 !important;
        object-fit: contain !important;
        filter: drop-shadow(0 16px 22px rgba(20, 60, 120, .16));
    }

    /* floating icon badges */
    .hero-art .badge {
        width: 54px !important;
        height: 54px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        background: transparent !important;
        box-shadow: none !important;
        border-radius: 50% !important;
        animation: heroFloat 5s ease-in-out infinite;
    }

    .hero-art .badge svg {
        width: 34px !important;
        height: 34px !important;
    }

    .hero-art .badge.b1 { top: 9% !important;  left: 6% !important;  right: auto !important; bottom: auto !important; }
    .hero-art .badge.b2 { top: 6% !important;  left: 52% !important; right: auto !important; bottom: auto !important; animation-delay: .8s; }
    .hero-art .badge.b3 { top: 5% !important;  right: 4% !important; left: auto !important;  bottom: auto !important; animation-delay: 1.6s; }
    .hero-art .badge.b4 { top: 34% !important; right: 0 !important;  left: auto !important;  bottom: auto !important; animation-delay: 2.4s; }

    @keyframes heroFloat {
        0%, 100% { transform: translateY(0); }
        50%      { transform: translateY(-8px); }
    }

}

/* =========================================================
   HERO - SHOW IMAGE EXACTLY AS DESIGNED (new, appended)
   hero-kids.png already contains its own circle + icons,
   so show it as-is: no crop, no filter, no extra circle,
   no extra badges. Higher specificity than the rules above.
========================================================= */

.hero .hero-art .blob,
.hero .hero-art .badge {
    display: none !important;
}

.hero .hero-art .hero-photo {
    width: 100% !important;
    height: auto !important;
    max-width: min(680px, 100%) !important;
    max-height: none !important;
    aspect-ratio: auto !important;
    border-radius: 0 !important;
    object-fit: contain !important;
    filter: none !important;
    box-shadow: none !important;
    clip-path: none !important;
    mask-image: none !important;
    -webkit-mask-image: none !important;
    mix-blend-mode: normal !important;
}

@media (min-width: 801px) {
    .hero .hero-art {
        justify-content: center !important;
        transform: translateX(0) !important;
        min-height: 640px !important;
    }
}

/* =========================================================
   HERO - REMOVE TOP SPACE + BIGGER IMAGE AT TOP (new, appended)
   Desktop only. Image starts at the top of the hero (no empty
   band under the header) and gets more room to grow.
========================================================= */

@media (min-width: 801px) {

    .hero {
        padding-top: 10px !important;
        padding-bottom: 30px !important;
    }

    .hero > .wrap {
        grid-template-columns: 0.85fr 1.15fr !important;
        align-items: start !important;
        padding-top: 0 !important;
    }

    /* text sits a little lower so it balances with the bigger image */
    .hero > .wrap > div:first-child {
        padding-top: 70px !important;
    }

    .hero .hero-art {
        align-items: flex-start !important;
        justify-content: center !important;
        min-height: 0 !important;
        margin-top: 0 !important;
        transform: none !important;
    }

    .hero .hero-art .hero-photo {
        max-width: min(760px, 100%) !important;
        margin-top: 0 !important;
    }

}

/* =========================================================
   FOOTER LOGO BOX + CTA BUTTON (new, appended)
   - hides the grey logo box in the footer
   - makes the "Find a Camp" button text visible on the teal bar
========================================================= */

footer.site .brand {
    display: none !important;
}

.final-cta .btn-outline {
    background: transparent !important;
    color: #fff !important;
    border: 2px solid #fff !important;
}

.final-cta .btn-outline:hover {
    background: #fff !important;
    color: var(--navy) !important;
}

</style>


<!-- =========================================================
     HEADER
========================================================= -->

<header class="site">

  <div class="nav">

    <a class="brand" href="#">
      <img
        src="<?= base_url('assets/images/logo.png') ?>"
        alt="Little Doctors logo"
        style="width:200px;height:auto;"
      >
    </a>

    <nav class="links">
      <a href="#lab">Learn <span class="icon-chevron">▾</span></a>
      <a href="#camps">Camps</a>
      <a href="#events">Events</a>
      <a href="#about">About <span class="icon-chevron">▾</span></a>
      <a href="#stories">Stories</a>
    </nav>

    <div class="nav-actions">

      <!-- Login opens the Login page -->
      <a class="btn btn-outline" href="<?= base_url('login') ?>">
        Login
      </a>

      <!-- Join opens the Register page -->
      <a class="btn btn-solid" href="<?= base_url('register') ?>">
        Join Little Doctors
      </a>

    </div>

  </div>

</header>


<!-- =========================================================
     HERO
========================================================= -->

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


<!-- =========================================================
     PILLARS
========================================================= -->

<section class="pillars">

  <div class="wrap">

    <div class="pillars-head">
      <h2>
        What if learning about the human body was an
        <span class="accent">adventure?</span>
      </h2>
    </div>

    <div class="pillar-row">

      <div class="card">
        <div class="ic" style="background:#e3faf3">
          <svg viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 4a3 3 0 0 0-3 3v1a3 3 0 0 0-2 5v4a3 3 0 0 0 3 3h1"/>
            <path d="M15 4a3 3 0 0 1 3 3v1a3 3 0 0 1 2 5v4a3 3 0 0 1-3 3h-1"/>
            <path d="M9 4a3 3 0 0 1 6 0v13a3 3 0 0 1-6 0z"/>
          </svg>
        </div>
        <h3>Discover</h3>
        <p>Learn how the brain, heart, lungs and body systems work.</p>
      </div>

      <div class="card">
        <div class="ic" style="background:#fff3de">
          <svg viewBox="0 0 24 24" fill="none" stroke="var(--yellow)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 12V5a2 2 0 1 1 4 0v6"/>
            <path d="M13 11V4a2 2 0 1 1 4 0v8"/>
            <path d="M17 12V7a2 2 0 1 1 4 0v8a7 7 0 0 1-14 0V9a2 2 0 1 1 4 0v3"/>
          </svg>
        </div>
        <h3>Explore</h3>
        <p>Take part in hands-on activities, games and interactive lessons.</p>
      </div>

      <div class="card">
        <div class="ic" style="background:#ffe7ec">
          <svg viewBox="0 0 24 24" fill="none" stroke="var(--pink)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20.8 8.6c0 5-8.8 10.4-8.8 10.4S3.2 13.6 3.2 8.6a5 5 0 0 1 9-3 5 5 0 0 1 8.6 3z"/>
          </svg>
        </div>
        <h3>Inspire</h3>
        <p>Use your knowledge to help friends, family and your community.</p>
      </div>

    </div>

  </div>

</section>


<!-- =========================================================
     JOURNEY
========================================================= -->

<section class="journey">

  <div class="wrap">

    <h2>Your Little Doctor Journey</h2>

    <div class="journey-row">

      <div class="jstep">
        <div class="circle">
          <span class="num" style="background:var(--teal)">1</span>
          <span style="font-size:30px;line-height:1;">🔍</span>
        </div>
        <h4>Discover</h4>
        <p>Understand the amazing systems inside you.</p>
      </div>

      <div class="jstep">
        <div class="circle">
          <span class="num" style="background:var(--yellow)">2</span>
          <span style="font-size:30px;line-height:1;">🔬</span>
        </div>
        <h4>Explore</h4>
        <p>Learn about health and common medical conditions.</p>
      </div>

      <div class="jstep">
        <div class="circle">
          <span class="num" style="background:var(--purple)">3</span>
          <span style="font-size:30px;line-height:1;">📖</span>
        </div>
        <h4>Learn</h4>
        <p>Ask questions and explore through activities.</p>
      </div>

      <div class="jstep">
        <div class="circle">
          <span class="num" style="background:var(--pink)">4</span>
          <span style="font-size:30px;line-height:1;">🤝</span>
        </div>
        <h4>Share</h4>
        <p>Help others make healthier choices.</p>
      </div>

      <div class="jstep trophy">
        <div class="circle">
          <span style="font-size:36px;line-height:1;">🏆</span>
        </div>
        <h4>Become a<br>Little Doctor!</h4>
      </div>

    </div>

  </div>

</section>


<!-- =========================================================
     LEARNING LAB
========================================================= -->

<section id="lab">

  <div class="wrap">

    <div class="section-head">
      <h2>Little Doctors Learning Lab</h2>
      <a href="#">View all topics →</a>
    </div>

    <div class="lab-grid">

      <div class="lab-card">
        <div class="ic" style="background:#ffe7ec">
          <span style="font-size:28px;line-height:1;">🧠</span>
        </div>
        <h4>Brain</h4>
        <p>Uncover how your brain helps you think, feel and move.</p>
        <a class="go" style="color:var(--pink)" href="#">Explore →</a>
      </div>

      <div class="lab-card">
        <div class="ic" style="background:#ffe7e2">
          <span style="font-size:28px;line-height:1;">❤️</span>
        </div>
        <h4>Heart</h4>
        <p>Learn how your heart pumps blood to keep you strong.</p>
        <a class="go" style="color:var(--coral)" href="#">Explore →</a>
      </div>

      <div class="lab-card">
        <div class="ic" style="background:#e7effb">
          <span style="font-size:28px;line-height:1;">🫁</span>
        </div>
        <h4>Lungs</h4>
        <p>See how your lungs help you breathe fresh air.</p>
        <a class="go" style="color:var(--navy)" href="#">Explore →</a>
      </div>

      <div class="lab-card">
        <div class="ic" style="background:#f2eefc">
          <span style="font-size:28px;line-height:1;">🦴</span>
        </div>
        <h4>Bones</h4>
        <p>Find out how your skeleton supports you every day.</p>
        <a class="go" style="color:var(--purple)" href="#">Explore →</a>
      </div>

      <div class="lab-card">
        <div class="ic" style="background:#e6f8ec">
          <span style="font-size:28px;line-height:1;">🍎</span>
        </div>
        <h4>Nutrition</h4>
        <p>Good food helps your body grow and stay healthy.</p>
        <a class="go" style="color:var(--green)" href="#">Explore →</a>
      </div>

    </div>

  </div>

</section>


<!-- =========================================================
     CAMPS
========================================================= -->

<section class="camps" id="camps">

  <div class="wrap">

    <div class="section-head">
      <h2>Find your next Little Doctors adventure</h2>
      <a href="#">View all camps →</a>
    </div>

    <div class="camp-grid">

      <div class="camp-card">

        <div class="camp-photo">
          <img src="<?= base_url('assets/images/camp-1.jpg') ?>" alt="Little Doctors Camp">
          <span class="camp-tag">SUMMER CAMP</span>
        </div>

        <div class="camp-body">
          <h4>Little Doctors Camp</h4>
          <div class="camp-meta">
            <span>📅 Jun 15 – Jun 19, 2026</span>
            <span>📍 Boston, MA</span>
            <span>👤 Ages 8 – 14</span>
          </div>
          <a class="btn btn-solid" href="#">Explore Camp →</a>
        </div>

      </div>


      <div class="camp-card">

        <div class="camp-photo">
          <img src="<?= base_url('assets/images/camp-2.jpg') ?>" alt="Heart and Health Workshop">
          <span class="camp-tag">WEEKEND WORKSHOP</span>
        </div>

        <div class="camp-body">
          <h4>Heart &amp; Health Workshop</h4>
          <div class="camp-meta">
            <span>📅 Jul 12 – Jul 13, 2026</span>
            <span>📍 New York, NY</span>
            <span>👤 Ages 7 – 12</span>
          </div>
          <a class="btn btn-solid" href="#">Explore Workshop →</a>
        </div>

      </div>


      <div class="camp-card">

        <div class="camp-photo">
          <img src="<?= base_url('assets/images/camp-3.jpg') ?>" alt="Human Body Explorer Camp">
          <span class="camp-tag">SCIENCE CAMP</span>
        </div>

        <div class="camp-body">
          <h4>Human Body Explorer Camp</h4>
          <div class="camp-meta">
            <span>📅 Aug 2 – Aug 6, 2026</span>
            <span>📍 Chicago, IL</span>
            <span>👤 Ages 8 – 14</span>
          </div>
          <a class="btn btn-solid" href="#">Explore Camp →</a>
        </div>

      </div>

    </div>

    <p class="camps-foot">
      Can't find a camp near you?
      <a href="#">Join the interest list →</a>
    </p>

  </div>

</section>


<!-- =========================================================
     ABOUT
========================================================= -->

<section id="about">

  <div class="wrap">

    <div class="pillars-head">
      <h2>
        Why parents trust
        <span class="accent">Little Doctors</span>
      </h2>
    </div>

    <div class="trust-grid">

      <div class="trust-item">
        <div class="ic" style="background:#e3faf3">
          <svg viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 3 4 6v6c0 5 3.5 8.5 8 9 4.5-.5 8-4 8-9V6l-8-3Z"/>
          </svg>
        </div>
        <h4>Safe &amp; Supervised</h4>
        <p>All programs are designed with child safety as our top priority.</p>
      </div>

      <div class="trust-item">
        <div class="ic" style="background:#e7effb">
          <svg viewBox="0 0 24 24" fill="none" stroke="var(--navy)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 10 12 5 2 10l10 5 10-5Z"/>
            <path d="M6 12v5c2 1.5 10 1.5 12 0v-5"/>
          </svg>
        </div>
        <h4>Educational &amp; Fun</h4>
        <p>Age-appropriate content that makes learning exciting.</p>
      </div>

      <div class="trust-item">
        <div class="ic" style="background:#f2eefc">
          <svg viewBox="0 0 24 24" fill="none" stroke="var(--purple)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="8" r="3.2"/>
            <path d="M2.5 20c1-3.5 3.5-5.5 6.5-5.5s5.5 2 6.5 5.5"/>
            <circle cx="17.5" cy="9" r="2.6"/>
            <path d="M15 14.5c2.4.2 4 1.8 4.8 4.5"/>
          </svg>
        </div>
        <h4>Expert Guidance</h4>
        <p>Taught by trained educators and healthcare professionals.</p>
      </div>

      <div class="trust-item">
        <div class="ic" style="background:#fff3de">
          <svg viewBox="0 0 24 24" fill="none" stroke="var(--yellow)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m12 3 2.6 5.7 6.2.6-4.7 4.2 1.4 6.1L12 16.9l-5.5 2.7 1.4-6.1-4.7-4.2 6.2-.6L12 3Z"/>
          </svg>
        </div>
        <h4>Proven Impact</h4>
        <p>Thousands of children inspired to lead healthier lives.</p>
      </div>

    </div>

  </div>

</section>


<!-- =========================================================
     STORIES  (photos added here)
========================================================= -->

<section class="testimonials" id="stories">

  <div class="wrap">

    <div class="pillars-head">
      <h2>What our Little Doctors say</h2>
    </div>

    <div class="test-grid">

      <div class="test-card">
        <div class="stars">★★★★★</div>
        <p>"I love Little Doctors because I learn so many new things about the human body in a fun way!"</p>
        <div class="test-who">
          <img class="t-photo" src="<?= base_url('assets/images/t-1.png') ?>" alt="Neha">
          Neha, Age 10
        </div>
      </div>

      <div class="test-card">
        <div class="stars">★★★★★</div>
        <p>"The activities and games are awesome! I now know how my heart works."</p>
        <div class="test-who">
          <img class="t-photo" src="<?= base_url('assets/images/t-2.png') ?>" alt="Aarav">
          Aarav, Age 9
        </div>
      </div>

      <div class="test-card">
        <div class="stars">★★★★★</div>
        <p>"It's the best camp ever! I want to be a doctor when I grow up."</p>
        <div class="test-who">
          <img class="t-photo" src="<?= base_url('assets/images/t-3.png') ?>" alt="Diya">
          Diya, Age 11
        </div>
      </div>

    </div>

  </div>

</section>


<!-- =========================================================
     FINAL CTA
========================================================= -->

<section class="final-cta">

  <div class="wrap">

    <div>
      <h3>Ready to become a Little Doctor?</h3>
      <p>Join a program today and start your journey!</p>
    </div>

    <div class="actions">

      <a class="btn btn-outline small" href="#camps">Find a Camp</a>

      <!-- Join Now opens Register -->
      <a class="btn btn-solid" href="<?= base_url('register') ?>">Join Now</a>

    </div>

  </div>

</section>


<!-- =========================================================
     FOOTER
========================================================= -->

<footer class="site">

  <div class="wrap">

    <a class="brand" href="#">
      <img
        src="<?= base_url('assets/images/logo.png') ?>"
        alt="Little Doctors logo"
        style="height:100px"
      >
    </a>

    <p>© 2026 Little Doctors. Caring today, healthy tomorrow.</p>

  </div>

</footer>


<?= $this->endSection() ?>