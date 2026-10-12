
<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('partials/site_header') ?>

<section class="page-hero">
    <div class="wrap">
        <h1>Contact <span class="accent">Us</span></h1>
        <p>Questions about camps, enrollment or the Learning Lab? Send us a message.</p>
    </div>
</section>

<section>
    <div class="wrap">
        <div class="contact-grid">

            <!-- Contact form -->
            <div class="panel">
                <h3>Send us a message</h3>

                <?php if ($success = session()->getFlashdata('success')): ?>
                    <div class="alert-ok">
                        <?= esc($success) ?>
                    </div>
                <?php endif; ?>

                <?php if ($errors = session()->getFlashdata('errors')): ?>
                    <div class="alert-err">
                        <?php foreach ($errors as $err): ?>
                            <div><?= esc($err) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form
                    id="contactForm"
                    method="post"
                    action="<?= base_url('contact/send') ?>"
                >
                    <?= csrf_field() ?>

                    <!-- Honeypot anti-spam field -->
                    <input
                        type="text"
                        name="website"
                        class="hp"
                        tabindex="-1"
                        autocomplete="off"
                        aria-hidden="true"
                    >

                    <div class="field">
                        <label for="name">Your name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="<?= esc(old('name') ?? '') ?>"
                        >
                    </div>

                    <div class="field">
                        <label for="email">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?= esc(old('email') ?? '') ?>"
                        >
                    </div>

                    <div class="field">
                        <label for="phone">Phone (optional)</label>
                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="<?= esc(old('phone') ?? '') ?>"
                        >
                    </div>

                    <div class="field">
                        <label for="subject">Subject (optional)</label>
                        <input
                            type="text"
                            id="subject"
                            name="subject"
                            value="<?= esc(old('subject') ?? '') ?>"
                        >
                    </div>

                    <div class="field">
                        <label for="message">Message</label>
                        <textarea
                            id="message"
                            name="message"
                            rows="5"
                        ><?= esc(old('message') ?? '') ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-solid">
                        Send Message →
                    </button>
                </form>
            </div>

            <!-- Contact details and social media -->
            <div class="panel">
                <h3>Get in touch</h3>

                <?= $this->include('partials/contact_info') ?>

                <?= $this->include('partials/social_links') ?>

                <?php if (! empty($settings['map_embed_url'])): ?>
                    <iframe
                        class="map-frame"
                        src="<?= esc($settings['map_embed_url'], 'attr') ?>"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Little Doctors location map"
                    ></iframe>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<?= $this->include('partials/site_footer') ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<script>
$(function () {
    $('#contactForm').validate({
        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 120
            },
            email: {
                required: true,
                email: true,
                maxlength: 255
            },
            phone: {
                maxlength: 30
            },
            subject: {
                maxlength: 200
            },
            message: {
                required: true,
                minlength: 10,
                maxlength: 3000
            }
        },
        messages: {
            name: {
                required: 'Please enter your name.',
                minlength: 'Name must be at least 2 characters.'
            },
            email: {
                required: 'Please enter your email.',
                email: 'Enter a valid email address.'
            },
            message: {
                required: 'Please write a message.',
                minlength: 'Message must be at least 10 characters.'
            }
        }
    });
});
</script>

<?= $this->endSection() ?>
