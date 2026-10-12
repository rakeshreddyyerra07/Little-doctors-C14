<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('partials/site_header') ?>

<section class="page-hero">
  <div class="wrap">
    <h1>Upcoming <span class="accent">Events</span></h1>
    <p>Camps and workshops, in date order.</p>
  </div>
</section>

<section>
  <div class="wrap">
    <div class="event-list">

      <?php if (empty($events)): ?>
        <p class="empty">No events scheduled yet.</p>
      <?php else: foreach ($events as $e):
          $endDate = $e['end_date'] ?: $e['start_date'];
          $done    = $endDate && $endDate < date('Y-m-d');
      ?>
        <div class="event-row">
          <div class="event-date">
            <?php if (! empty($e['start_date'])): ?>
              <b><?= esc(date('j', strtotime($e['start_date']))) ?></b>
              <small><?= esc(date('M Y', strtotime($e['start_date']))) ?></small>
            <?php else: ?>
              <small>TBA</small>
            <?php endif; ?>
          </div>

          <div class="event-info">
            <?php if (! empty($e['tag'])): ?><span class="event-tag"><?= esc($e['tag']) ?></span><?php endif; ?>
            <h4><?= esc($e['title']) ?></h4>
            <div class="camp-meta">
              <?php if (! empty($e['start_date'])): ?><span>📅 <?= esc(format_date_range($e['start_date'], $e['end_date'])) ?></span><?php endif; ?>
              <?php if (! empty($e['location'])): ?><span>📍 <?= esc($e['location']) ?></span><?php endif; ?>
              <?php if (! empty($e['age_group'])): ?><span>👤 Ages <?= esc($e['age_group']) ?></span><?php endif; ?>
            </div>
          </div>

          <span class="status <?= $done ? 'done' : 'upcoming' ?>"><?= $done ? 'Completed' : 'Upcoming' ?></span>
        </div>
      <?php endforeach; endif; ?>

    </div>
  </div>
</section>

<?= $this->include('partials/site_footer') ?>

<?= $this->endSection() ?>