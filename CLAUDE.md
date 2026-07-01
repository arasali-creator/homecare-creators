# Homecare Creators — Project Guide for Claude

## What This Is
Custom PHP + MySQL marketing website for a Florida home care agency marketing firm.
No framework, no CMS, no npm. Pure PHP, vanilla JS, MySQL via PDO.

## Live Site
- URL: `https://homecarecreators.com`
- GitHub: `git@github.com:arasali-creator/homecare-creators.git` (SSH, push to `main`)
- Local path: `c:\Users\Web\Desktop\Homecare Creators`

## Key Files
| File | Purpose |
|---|---|
| `includes/header.php` | Global `<head>`, nav, tracking code injection |
| `includes/footer.php` | Footer + all shared JS |
| `admin/config.php` | DB credentials (DB_HOST, DB_NAME, DB_USER, DB_PASS, SITE_URL) |
| `admin/includes/db.php` | PDO helpers: `hc_q`, `hc_one`, `hc_all`, `hc_val` |
| `admin/includes/functions.php` | `hc_setting`, `hc_setting_save`, `hc_flash`, `h()` |
| `admin/includes/layout.php` | `hc_head()`, `hc_topbar()`, `hc_foot()` |
| `admin/includes/nav.php` | Admin sidebar navigation |
| `admin/assets/admin.css` | All admin UI styles |

## Database Tables
- `hc_settings` — key/value config (logo, SMTP, WhatsApp, etc.)
- `hc_form_submissions` — contact form leads
- `hc_blog_posts` — blog content (title, slug, content HTML, meta, status)
- `hc_tracking_codes` — GTM/GA4/pixel scripts (position: head or body, active: 0/1)
- `hc_seo_pages` — per-page SEO overrides
- `hc_redirects` — 301/302 redirects
- `hc_page_schema` — per-page LD+JSON schema
- `hc_org_schema` — organization schema fields

## New Admin Page Template
```php
<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();
hc_head('Page Title');
hc_topbar('Page Title', '<a href="/admin/">Admin</a> › Page Title');
?>
<div class="page-content">
  <?= hc_show_flash() ?>
</div>
<?php hc_foot(); ?>
```

## Admin Panel Pages (as of July 2026)
- `/admin/` — Dashboard
- `/admin/form-log.php` — Form submissions
- `/admin/blog/` — Blog manager
- `/admin/seo-pages.php` — Per-page SEO
- `/admin/technical/tracking.php` — Tracking codes (GTM, GA4, etc.)
- `/admin/technical/sitemap.php`, `robots.php`, `redirects.php`, `canonicals.php`
- `/admin/ai-geo/` — Entity, E-E-A-T, FAQ Bank, Citations, Knowledge Graph
- `/admin/content/` — Image alts, internal links, broken links
- `/admin/org-schema.php`, `/admin/schema/` — Schema management
- `/admin/settings.php` — SMTP, logo, WhatsApp, site identity

## Blog Posts Published (8 total)
1. `home-care-agency-marketing-mistakes`
2. `local-seo-home-care-agency-google-maps`
3. `home-care-website-design-must-haves`
4. `private-pay-home-care-clients-florida`
5. `why-home-care-agency-not-showing-up-google`
6. `google-reviews-home-care-agency` ← added July 2026
7. `google-business-profile-checklist-home-care` ← added July 2026
8. `home-care-agency-ai-search-chatgpt-optimization` ← added July 2026

## Important Rules
- **Never auto-seed DB data** the user might want to delete — use a one-time flag in `hc_settings` or a manual seeder script
- **CREATE TABLE IF NOT EXISTS** at the top of admin pages that own a table (no migration system)
- **Never push to GitHub** without user explicitly saying "push to GitHub"
- **Blog topics** must target home care agency owners — not families, not investors
- **Use hc_q/hc_one/hc_all/hc_val** for all DB access — never raw PDO in page files
