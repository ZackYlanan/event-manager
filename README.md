# Vento — Event Management System

Vento is a role-based Event Management System built for university environments. It enables administrators to create and manage events while students can browse, register, receive ticket codes, and have their attendance tracked on the day of the event.

The system is built on **Laravel 13** with **Blade** templating, **Tailwind CSS** styling, **Alpine.js** interactivity, and **Chart.js** analytics — all bundled through **Vite**.

---

## Table of Contents

- [Details of the Members](#details-of-the-members)
- [Implemented Features](#implemented-features)
- [Tech Stack & Dependencies](#tech-stack--dependencies)
- [Authentication & Authorization](#authentication--authorization)
- [User Role Workflows](#user-role-workflows)
  - [Admin Workflow](#admin-workflow)
  - [Student Workflow](#student-workflow)
- [Event Registration & Attendance Tracking](#event-registration--attendance-tracking)
- [Project Setup](#project-setup)
- [Project Structure](#project-structure)
- [Future Enhancements](#future-enhancements)

---

## Details of the Members

| Name | Project Role | GitHub Profile |
| :--- | :--- | :--- |
| **Isaac Emmanuel F. Ylanan** | Project Lead & Backend Developer | [@ZackYlanan](https://github.com/ZackYlanan) |
| **John Cyrill L. Mindanao** | Backend Developer | [@johncyrillmindanao](https://github.com/johncyrillmindanao) |
| **Marvin Celzo Barrios** | UI/UX & Frontend Developer | [@vinbitz](https://github.com/vinbitz) |
| **Aizel Baraquil Ridor** | UI/UX & Frontend Developer | [@aiz-21](https://github.com/aiz-21) |

---

## Implemented Features

### Public (Guest) Access
- View the landing page with up to 3 upcoming published events.
- View individual event detail pages.
- Filter events by category on the landing page.

### Student Features
- Register with a PUP institutional email (`@iskolarngbayan.pup.edu.ph`), student ID, and course.
- Browse a full event directory with category filtering.
- Register for a published event and receive a unique 8-character ticket code.
- View a personal "My Tickets" page with all registrations sorted by status.
- Cancel a pending ticket (frees the slot for others).
- Tickets automatically show "Missed Event" once the event has ended without a check-in.

### Admin Features
- Analytics dashboard with:
  - Total events created, active (upcoming published) events count.
  - Total student count across the platform.
  - Total ticket count for the admin's own events.
  - Up to 4 upcoming events displayed at a glance.
- Full CRUD for events (Create, Read, Update, Delete) — scoped to the admin's own events.
- Event creation form with category selection, date/time scheduling, capacity limits, registration deadlines, status control (`Draft`, `Published`, `Cancelled`, `Completed`), and cover style (gradient theme) picker.
- Check-in management page:
  - Select an upcoming event (within 3 days) to view its registrant roster.
  - Check in students by ticket code.
  - Manually mark students as "Present" from the roster list.
  - Duplicate check-in prevention.
- Per-event analytics report:
  - Total registrations, capacity utilization %, actual attendance, no-shows, turnout rate %.
  - Student roster table with name, student ID, course, ticket code, attendance status, and check-in timestamp.
  - JSON API endpoint for dynamic frontend chart rendering.
  - CSV export of event analytics and student roster.

### Profile Management
- Edit name and email (students restricted to PUP domain emails).
- Delete account (with password confirmation).

### System Behaviors
- Automatic absence marking: pending registrations for past events are marked "Absent" when the admin dashboard is accessed.
- Real-time attendance status accessor: ticket status dynamically returns "Absent" for ended events without a database write.
- Display-friendly status labels: `Pending` → "Ready to Scan", `Present` → "Checked In", `Absent` → "Missed Event".
- Custom 404 error page.
- Catch-all route fallback for undefined URLs.
- Frontend sandbox route for isolated Blade view testing (`/sandbox/{view}`).

---

## Tech Stack & Dependencies

| Layer | Technology | Version |
|---|---|---|
| **Language** | PHP | ^8.3 |
| **Framework** | Laravel | ^13.8 |
| **Auth Scaffolding** | Laravel Breeze | ^2.4 |
| **Templating** | Blade | — |
| **CSS Framework** | Tailwind CSS | ^3.1 |
| **JS Reactivity** | Alpine.js | ^3.4 |
| **Charts** | Chart.js | ^4.5 |
| **Icons** | Bootstrap Icons | ^1.13 |
| **Build Tool** | Vite | ^8.0 |
| **Database** | SQLite (default) | — |
| **Testing** | PHPUnit | ^12.5 |

---

### Key Constraints

| Relationship | Cascade Rule |
|---|---|
| `events.admin_id` → `users.id` | `ON DELETE CASCADE` — deleting an admin removes all their events. |
| `events.category_id` → `event_categories.id` | `ON DELETE RESTRICT` — a category cannot be deleted while events reference it. |
| `registrations.event_id` → `events.id` | `ON DELETE CASCADE` — deleting an event removes all its registrations. |
| `registrations.user_id` → `users.id` | `ON DELETE CASCADE` — deleting a student releases all their ticket slots. |
| `registrations(event_id, user_id)` | `UNIQUE` composite — prevents duplicate registrations. |

---

## Authentication & Authorization

### Authentication
Vento uses **Laravel Breeze** (Blade stack) for authentication, providing:
- Login, Registration, Password Reset, Email Verification, and Password Confirmation flows.
- Session-based authentication via the `auth` middleware.

### Registration Restrictions
- Public registration creates **student** accounts only (hardcoded `role = 'student'`).
- Email must end with `@iskolarngbayan.pup.edu.ph`.
- Student ID and course are required and validated as unique.
- Admin accounts are created exclusively through the database seeder — there is no public admin registration.

### Authorization (Role-Based Access Control)
Authorization is implemented with a custom `RoleMiddleware` registered under the alias `role` in `bootstrap/app.php`:

| Middleware | Behavior |
|---|---|
| `auth` | Requires the user to be logged in. Unauthenticated users are redirected to login with a contextual message. |
| `role:admin` | Restricts access to admin-only routes. Non-admin users are redirected to `/dashboard` with an "Access Denied" error. |
| `role:student` | Restricts access to student-only routes. Non-student users are redirected to `/dashboard` with an "Access Denied" error. |

### Route Groups

| Prefix | Middleware | Description |
|---|---|---|
| `/` | None (public) | Landing page and event detail pages. |
| `/profile` | `auth` | Profile management (shared by all roles). |
| `/admin/*` | `auth`, `role:admin` | Event CRUD, dashboard, check-in, and reports. |
| `/student/*` | `auth`, `role:student` | Event directory, registration, and tickets. |

### Post-Login Redirect
After login, the `/dashboard` route inspects the user's `role` column and redirects:
- **Admin** → `admin.dashboard`
- **Student** → `student.home`

---

## User Role Workflows

### Admin Workflow

```
Login → Admin Dashboard
            │
            ├── View Analytics (total events, active events, students, tickets)
            ├── View Upcoming Events (max 4)
            │
            ├── Manage Events (/admin/events)
            │       ├── Create Event (title, description, category, venue, date/time, slots, deadline, status, cover style)
            │       ├── Edit Event
            │       └── Delete Event
            │
            ├── Check-In Students (/admin/checkin)
            │       ├── Select Event (within 3 days)
            │       ├── Enter Ticket Code → Mark Present
            │       └── Manual Check-In from Roster → Mark Present
            │
            └── Event Reports (/admin/events/{id}/report)
                    ├── View Analytics (registrations, utilization, attendance, turnout)
                    ├── View Student Roster
                    ├── Fetch Report Data as JSON (for Chart.js)
                    └── Export Roster as CSV
```

- Each admin can only see and manage **their own** events (scoped by `admin_id`).
- Event statuses: `Draft` → `Published` → `Completed` / `Cancelled`.
- Only `Published` events with future dates are visible to students.

### Student Workflow

```
Landing Page (/) → Browse up to 3 upcoming events
            │
            ├── View Event Details (/events/{id}/show)
            │       └── Register for Event (requires login)
            │
            ├── Event Directory (/student/events)
            │       ├── Browse all upcoming published events
            │       └── Filter by category
            │
            ├── My Tickets (/student/my-tickets)
            │       ├── View all registrations (sorted: Pending first)
            │       ├── See ticket code, status, event details
            │       └── Cancel pending tickets
            │
            └── Profile (/profile)
                    ├── Update name and email
                    └── Delete account
```

- Registration requires a PUP email, student ID, and course.
- Students cannot register for the same event twice (enforced at DB and controller level).
- Students cannot register for full events (slot count validated).
- Ticket cancellation is only allowed for `Pending` tickets.

---

## Event Registration & Attendance Tracking

### Registration Flow

1. A student views an event detail page or the event directory.
2. The student clicks "Register" (unauthenticated users are redirected to login first).
3. The system validates:
   - The user has the `student` role.
   - The student is not already registered (duplicate prevention).
   - The event has available slots (`current registrations < maximum_slots`).
4. A `Registration` record is created with a randomly generated, unique 8-character alphanumeric `registration_code` and an initial status of `Pending`.
5. The student is redirected to "My Tickets" with a success message.

### Attendance Tracking Flow

1. **Admin opens the Check-In page** and selects an event (events within the next 3 days are available).
2. The system displays the full registrant roster for the selected event.
3. **Check-in by Ticket Code**: The admin enters a student's ticket code.
   - If the code is invalid → error message.
   - If the student is already checked in → error message (duplicate prevention).
   - If valid → status updates to `Present`, `checked_in_at` is set to the current timestamp.
4. **Manual Check-In**: The admin clicks a button next to a student's name in the roster to directly mark them as `Present`.

### Automatic Absence Marking

- **On dashboard access**: `Registration::markAbsences()` is called, which queries all `Pending` registrations, checks if the associated event's `event_date + end_time` has passed, and updates the status to `Absent`.
- **On read (accessor)**: The `attendance_status` accessor on the `Registration` model dynamically returns `Absent` for pending tickets whose event has already ended, even before a database write occurs.

### Status Lifecycle

```
[Student Registers] → Pending ("Ready to Scan")
                           │
              ┌─────────────┼─────────────┐
              │             │             │
        Admin checks in   Event ends    Student cancels
              │             │             │
           Present      Absent         (Deleted)
        ("Checked In")  ("Missed Event")
```

---

## Project Setup

### Prerequisites

- **PHP** >= 8.3
- **Composer** >= 2.x
- **Node.js** >= 18.x and **npm**
- **SQLite** (default, no external database server required)

### Installation

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd event-manager
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies:**
   ```bash
   npm install
   ```

4. **Configure environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   The default configuration uses **SQLite**. The database file is located at `database/database.sqlite`.

5. **Run migrations:**
   ```bash
   php artisan migrate
   ```

6. **Seed the database** (creates admin accounts, student accounts, categories, events, and registrations):
   ```bash
   php artisan db:seed
   ```

7. **Start the development servers:**

   Using the built-in Composer script (starts Laravel server, queue worker, log viewer, and Vite concurrently):
   ```bash
   composer dev
   ```

   Or manually:
   ```bash
   # Terminal 1
   php artisan serve

   # Terminal 2
   npm run dev
   ```

8. Access the application at `http://localhost:8000`.

---

### Seeded Data
- **4 Event Categories**: Technical Workshop, Education Seminar, Hackathon Competition, Organization Meeting.
- **19 Events**: 10 events assigned to Admin 1, 9 events assigned to Admin 2 (all published, with future dates).
- **98 Registrations**: 49 students registered for the first 2 events.

---

## Project Structure

```
event-manager/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                        # Breeze auth controllers (login, register, password reset, etc.)
│   │   │   ├── AdminDashboardController.php # Admin analytics dashboard
│   │   │   ├── CategoryController.php       # JSON API for event categories
│   │   │   ├── EventController.php          # Event CRUD + public views
│   │   │   ├── EventReportController.php    # Event analytics, roster, CSV export
│   │   │   ├── ProfileController.php        # Profile edit/update/delete
│   │   │   └── RegistrationController.php   # Ticket registration, check-in, cancellation
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php           # Custom role-based access control
│   │   └── Requests/
│   │       └── ProfileUpdateRequest.php     # Profile validation (PUP email for students)
│   ├── Models/
│   │   ├── Event.php                        # Event model with cover gradient accessor
│   │   ├── EventCategory.php                # Category model
│   │   ├── Registration.php                 # Registration model with auto-absence logic
│   │   └── User.php                         # User model with role, student_id, course
│   └── View/                                # View components
├── database/
│   ├── migrations/                          # Schema for users, events, categories, registrations
│   ├── seeders/                             # Admin, student, category, event, and registration seeders
│   └── database.sqlite                      # SQLite database file
├── resources/views/
│   ├── admin/
│   │   ├── dashboard.blade.php              # Admin analytics dashboard
│   │   ├── checkin.blade.php                # Ticket check-in management
│   │   ├── report.blade.php                 # Per-event analytics report
│   │   └── events/                          # Event CRUD views (index, create, edit)
│   ├── student/
│   │   ├── home.blade.php                   # Public landing page
│   │   ├── directory.blade.php              # Full event directory
│   │   ├── show.blade.php                   # Single event detail page
│   │   └── tickets.blade.php                # My Tickets page
│   ├── auth/                                # Breeze auth views (login, register, etc.)
│   ├── profile/                             # Profile management views
│   ├── errors/                              # Custom error pages (404)
│   ├── layouts/                             # Blade layout templates
│   └── components/                          # Reusable Blade components
├── routes/
│   ├── web.php                              # All web routes (public, admin, student)
│   └── auth.php                             # Breeze authentication routes
├── bootstrap/
│   └── app.php                              # Middleware alias registration & exception handling
├── composer.json                            # PHP dependencies (Laravel 13, Breeze, Tinker)
├── package.json                             # JS dependencies (Vite, Tailwind, Alpine, Chart.js)
├── tailwind.config.js
├── vite.config.js
└── .env.example                             # Environment configuration template
```

---

## Future Enhancements

The following enhancements are natural extensions of the current architecture and codebase:

| Area | Enhancement | Rationale |
|---|---|---|
| **QR Code Tickets** | Generate QR codes from the existing `registration_code` for faster scanning at check-in. | The unique 8-character code already exists; a QR code is a visual wrapper around it. |
| **Email Notifications** | Send confirmation emails on registration, reminders before event day, and post-event summaries. | Laravel's mail system is already configured (`MAIL_MAILER=log`); switching to SMTP requires only `.env` changes. |
| **Event Image Uploads** | Allow admins to upload custom cover images instead of using gradient presets. | The `cover_style` column and `getAvailableCovers()` helper are designed to be extensible; file uploads via `Storage::disk('public')` fit naturally. |
| **Category CRUD for Admins** | Let admins create, edit, and delete event categories from the UI. | `CategoryController` already exists with an `index` method; CRUD routes and views can be added directly. |
| **Student Course Analytics** | Group registrations and attendance by `course` field in reports. | The `course` column is already collected during registration and displayed in CSV exports. |
| **Waitlist System** | Allow students to join a waitlist when an event is full, with automatic promotion on cancellation. | The slot-checking logic in `RegistrationController::store()` can be extended to create waitlist entries. |
| **Multi-Day / Recurring Events** | Support events spanning multiple days or on a recurring schedule. | The `events` table currently uses a single `event_date`; adding a `end_date` or a `recurrence` column would enable this. |
| **API Layer** | Expose RESTful API endpoints for mobile app integration. | `EventReportController::getReportData()` already returns JSON; extending this pattern to other resources is straightforward. |
| **Role Expansion** | Add an `organizer` or `moderator` role for delegated event management. | The `role` ENUM column on `users` and the `RoleMiddleware` are designed for easy role expansion. |
