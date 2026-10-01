# Little Doctors — CodeIgniter 4

Landing page matched to the supplied design (hero, adventure features, journey steps,
learning-lab topic cards, camps, trust badges, testimonials, CTA), plus parent
registration/login and a post-login camp enrollment form.

## Logo

`public/assets/img/logo.png` is your real logo file, wired into the header in
`app/Views/layouts/main.php`. Note: the logo's own colors (red "LITTLE"/"DOCTORS",
blue figure) differ from the navy/teal palette used across the rest of the site,
which followed the homepage prototype image. Let me know if you'd like the whole
site recolored to match the logo's red/blue instead.

## What's real vs. placeholder

- **Design**: layout, colors, type, and copy follow the provided image closely.
- **Photos**: the two kids' hero photo, camp photos, and testimonial avatars are
  styled placeholder blocks/emoji — I don't have the original photography. Drop your
  real images into `public/assets/img/` and swap the corresponding `<div class="...">`
  blocks in `app/Views/home.php` for `<img>` tags.
- **Nav links** (Learn, Camps, Events, About, Stories) scroll to sections on the same
  page for now — wire them to real pages as content grows.
- **Enrollment form** assumes: child's name, age, camp choice, notes. Change the
  fields in `app/Controllers/EnrollController.php` and `app/Views/enroll/form.php`
  if you had something else in mind.

## Setup

```bash
composer create-project codeigniter4/appstarter little-doctors
cd little-doctors
# copy this folder's app/, public/ and env into place (merge/overwrite when asked)

cp env .env
php spark migrate      # creates users + enrollments tables
php spark serve
```

Open http://localhost:8080

## Flow

1. `/` — landing page. "Join Little Doctors" / "Login" in the header, and every
   camp card's "Explore" button, lead to registration.
2. `/auth/register` and `/auth/login` — parent account creation and login.
3. `/enroll` (requires login) — enrollment form plus a list of the parent's past
   enrollments.

## Files

| File | Purpose |
|---|---|
| `app/Views/home.php` + `public/assets/css/style.css` | The landing page |
| `app/Controllers/AuthController.php`, `app/Models/UserModel.php` | Register / login / logout |
| `app/Filters/AuthFilter.php` | Protects `/enroll` — redirects to login if not signed in |
| `app/Controllers/EnrollController.php`, `app/Models/EnrollmentModel.php` | Post-login enrollment form + list |
| `app/Database/Migrations/*CreateUsersTable.php`, `*CreateEnrollmentsTable.php` | Schema |