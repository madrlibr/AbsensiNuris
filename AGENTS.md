# AGENTS.md — absensinuris

Laravel 13 attendance app (Sekolah): students, teachers, classes, schedules, daily/subject attendance, leave letters. Blade + Breeze auth, Tailwind v3 + Alpine, Vite. PHP `^8.3`.

## Commands

- `composer dev` — serve + queue:listen + vite concurrently (via `php artisan dev`). Use instead of separate `serve`/`vite` terminals.
- `composer test` — runs `config:clear` then `php artisan test`. Use for all test runs.
- `npm run build` / `npm run dev` — Vite only (entries: `resources/css/app.css`, `resources/js/app.js`).
- `./vendor/bin/pint` — formatter (no composer/npm script for it; run before committing PHP changes).
- Focused test: `php artisan test --filter=NameOfTest` (e.g. `--filter=ProfileTest`).

## Database

- Local dev uses **MySQL** (`DB_DATABASE=absensinuris` on `127.0.0.1:3306`, Laragon). `.env.example` says sqlite but the real `.env` is MySQL — don't "fix" this.
- Tests force sqlite `:memory:` via `phpunit.xml` — no DB setup needed for tests.
- `struktur.sql` is a MySQL dump fallback; migrations in `database/migrations/` are source of truth.
- `database/database.sqlite` exists but is unused while `.env` points to MySQL.

## Structure

- `routes/web.php` + `routes/auth.php` (Breeze) — no API routes file.
- `app/Http/Controllers/Admin/` (Jurusan, Kelas, TahunAjaran, PengaturanAbsensi, Pengguna, Siswa+Guru+Mapel+Jadwal), `DashboardController` (counts for active year + today), `app/Http/Controllers/BK/LaporanController` (rekap + perhatian + detail siswa, route `bk.*` dengan `role:bk`), `app/Http/Controllers/Guru/` (currently empty), `ProfileController` from Breeze.
- Views use two conventions (`<x-app-layout>` and `@extends('layouts.app')`) — both work: `layouts/app.blade.php` is a custom sidebar layout that renders `@yield('content')` or falls back to `$slot`. Do not "unify" them.
- Real nav is `components/sidebars/{admin,guru,orang-tua}.blade.php` (picked by role in the layout); `layouts/navigation.blade.php` is dead Breeze leftover — do not add links there. Sidebar theme is blue (`bg-blue-600` on the aside): active item = `bg-white/20` pill, no left-border tricks.
- `role` middleware alias (`role:admin`) is registered in `bootstrap/app.php`, implemented in `app/Http/Middleware/CheckRole.php` — not in a Kernel. Supports comma-separated roles (`role:admin,guru`).
- BK is not a `users.role` — it is a `users.penugasan` value on `role=guru` accounts. `role:bk` matches penugasan, so guru+penugasan bk passes both `role:guru` and `role:bk`; plain guru passes only `role:guru`. Helper: `User::bertugasSebagai('bk')`.
- Domain models in `app/Models/`: `AbsensiHarian`, `AbsensiMapel`, `JadwalPelajaran`, `AnggotaKelas`, `SuratIzin`, `Guru`, `Siswa`, plus `OrangTuaSiswa` (parent login link) and `NotifikasiKehadiran` (WA/send log).

## Gotchas

- `2026_10_12_041135_sampah.php` migration creates a junk `sampah` table and has an empty `down()` — remove it if touching migrations; don't copy it as a template.
- `CheckRole` usage is `role:admin` (singular `role`, comma-separated values) — don't use Spatie-style `role:` plural or `can:` syntax.
- Session/cache/queue drivers are `database` in `.env` (not file/array outside testing) — run `php artisan migrate` on fresh setups so sessions and queues work.
