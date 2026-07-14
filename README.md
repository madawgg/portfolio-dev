# Personal Portfolio

Personal portfolio website built to showcase my work as a junior full-stack web developer. Public pages for visitors (home, about, projects, contact) and a private admin panel where all the content — profile, experience, education, projects with image galleries, and the downloadable CV — is managed without touching code.

Built as a classic server-rendered monolith on purpose: no SPA, no API, just Laravel doing what Laravel does best.

## Tech stack

- **PHP 8.2 · Laravel 12** — Blade views, session auth, Form Requests, Eloquent
- **MySQL 8** — relational data (projects ↔ gallery images)
- **Tailwind CSS 4 · Vite** — class-based dark/light mode, self-hosted fonts
- **GD** — server-side image processing (WebP conversion + resizing)
- **PHPUnit** — feature test suite (auth, contact anti-spam, CV download, account)

## Features

**Public**
- Four sections: home (hero + featured projects), about (experience timeline + education), projects (Netflix-style horizontal rows split by professional/personal), contact
- Per-project detail page with screenshot carousel
- Dark mode by default with a persisted light/dark toggle
- Downloadable CV (PDF served from private storage, rate-limited)
- OpenGraph/Twitter cards, custom 404, SVG favicon

**Admin panel** (session auth, single admin seeded from env)
- Full CRUD for profile, projects, experience, education
- Image uploads converted to WebP and resized on the server; every image (thumbnail, gallery, profile photo) can be replaced or deleted, files included
- Contact inbox with per-message view linked from the notification email
- Change login email and password (current password required)

**Security hardening**
- Contact form: honeypot + time-trap + one-time arithmetic captcha + rate limits by IP *and* by sender email + IP-consent checkbox (bots get a fake success)
- Login throttling (5 attempts/min per email+IP), session regeneration, generic error messages
- Upload defense in depth: extension + real MIME (finfo) + magic bytes + decompression-bomb guard (megapixel cap before decoding)
- Global security headers (X-Frame-Options, nosniff, Referrer-Policy)
- CSRF everywhere, no raw SQL, escaped output

## Requirements

- PHP ≥ 8.2 with the `gd` extension (WebP support)
- Composer, Node 18+, MySQL 8

## Install & run

```bash
composer install
npm install

cp .env.example .env        # fill DB_*, ADMIN_*, CONTACT_TO_ADDRESS
php artisan key:generate

# create the MySQL database first, then:
php artisan migrate --seed

npm run build               # or `npm run dev` while developing
php artisan serve           # http://127.0.0.1:8000
```

The seeder creates the admin user from `ADMIN_NAME` / `ADMIN_EMAIL` / `ADMIN_PASSWORD` (it aborts with a clear error if they are missing, and never overwrites an existing user). Log in at `/login` to manage content.

## Tests

```bash
php artisan test            # runs against SQLite in-memory, no MySQL needed
```

## Config notes

- `MAIL_MAILER=log` in local: contact notifications go to `storage/logs/laravel.log`. Point it to a real SMTP in production.
- Uploaded images live in `public/project-mini-img`, `public/project-img` and `public/img` (git-ignored); the CV lives outside the web root in `storage/app/private/cv` and is only served through a rate-limited controller.
- UI is in Spanish; validation messages come from `laravel-lang` (es).

## Routes overview

| Route | Access | Purpose |
|---|---|---|
| `/`, `/sobre-mi`, `/proyectos`, `/proyectos/{id}`, `/contacto` | public | portfolio pages |
| `POST /contacto` | public, throttled | contact form |
| `/cv` | public, throttled | CV download |
| `/login`, `POST /logout` | guest / auth | session auth |
| `/admin/**` | auth | dashboard + CRUD + inbox + account |
