# Lead Management Module (Laravel 12)

## Setup
1. `composer install`
2. Copy `.env.example` to `.env` and set your DB credentials
3. `php artisan key:generate`
4. `php artisan migrate --seed`
5. `npm install && npm run build`
6. `php artisan serve`

## Default login credentials (from seeder)
- Admin: `admin@example.com` / `password`
- Staff: `staff@example.com` / `password`

## Auth
Laravel Breeze (blade stack) was used for authentication — chosen because it's the officially
maintained Laravel starter kit and gives session-based login/logout, registration, and password
reset out of the box, which is a better use of the assignment's time budget than hand-rolling
Auth-facade controllers.

## Assumptions
- Added a `created_by` foreign key on `leads` (not listed in the original column spec) because
  requirement #9 (only the creator or an admin can delete a lead) can't be enforced without it.
- Added an `is_admin` boolean to `users` to represent "admin" for the same requirement, since no
  roles/permissions package was specified.
- Status and source are plain string/enum DB columns validated via `Rule::in()` in the Form
  Requests, rather than PHP backed enums, to keep the scope focused on the CRUD/validation/policy
  requirements being evaluated.

## Notes
- Search/filter state is preserved across pagination via `->withQueryString()`.
- CSV export re-runs the same query scopes as the index page, so it always reflects the current
  search/filter, and streams a real CSV via `fputcsv` (not an HTML table saved as `.csv`).
- Delete authorization is handled by `App\Policies\LeadPolicy` (auto-discovered), not inline role
  checks in the controller or views.