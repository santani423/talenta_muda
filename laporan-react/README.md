# Laporan Ujian Siswa — React App

Modern React application mirroring the Laravel "Laporan Ujian Siswa" page, built with Vite, TanStack Query, Tailwind CSS, and Recharts.

## Project Structure

```
laporan-react/
├── .env                         Environment variables (not committed)
├── .env.example                 Environment variable template
├── index.html                   Vite entry HTML
├── package.json
├── vite.config.js               Vite config with proxy and build settings
├── tailwind.config.js
├── postcss.config.js
└── src/
    ├── main.jsx                 React entry point + QueryClientProvider
    ├── App.jsx                  Root component
    ├── index.css                Tailwind base + custom scrollbar utilities
    ├── assets/                  Static assets (images, icons)
    ├── components/
    │   ├── ui/
    │   │   ├── Spinner.jsx      Loading spinner (sm/md/lg/xl sizes)
    │   │   ├── Badge.jsx        Inline badge/pill component
    │   │   └── Modal.jsx        Full-screen overlay modal
    │   ├── charts/
    │   │   ├── RadarDomain.jsx  NEO-PI Big Five radar chart (Recharts)
    │   │   ├── BarDomain.jsx    Per-domain facet bar chart
    │   │   └── SekalaBar.jsx    Dark Triad / MMPI sekala bar chart
    │   ├── FilterBar.jsx        Search + batch + limit filters
    │   ├── SiswaTable.jsx       Main data table with per-row detail loading
    │   ├── Pagination.jsx       Page navigation with ellipsis
    │   ├── StatsCards.jsx       Summary stat cards (total, page info)
    │   └── HasilModal.jsx       Full results modal with tabbed sections
    ├── hooks/
    │   ├── useBatch.js          TanStack Query: GET /api/laporan/batch
    │   ├── useSiswa.js          TanStack Query: GET /api/laporan/siswa
    │   └── useSiswaDetail.js    TanStack Query: GET /api/laporan/siswa/:id/semua-nilai
    ├── layouts/
    │   └── MainLayout.jsx       Header + main content + footer shell
    ├── pages/
    │   └── LaporanPage.jsx      Main page (state management, layout)
    ├── services/
    │   └── laporanService.js    Axios API calls
    └── utils/
        ├── formatters.js        Date, gender, kualifikasi color helpers
        └── scoreHelpers.js      NEO-PI, sekala, facet data extractors
```

## Prerequisites

- **Node.js** 18+ (LTS recommended)
- **npm** 9+ or **yarn** 1.22+
- Laravel backend running at `http://localhost:8000` (or configured URL)

## Installation

```bash
# Navigate to the app folder
cd laporan-react

# Install dependencies
npm install
```

## Environment Configuration

Copy the example env file and configure:

```bash
cp .env.example .env
```

Edit `.env`:

```env
# Base URL of your Laravel backend
VITE_API_BASE_URL=http://localhost:8000
```

> During development, the Vite dev server will proxy all `/api/*` requests to `VITE_API_BASE_URL`, so CORS is not an issue.

## Development Server

```bash
npm run dev
```

The app will be available at: `http://localhost:5173/laporan-react/`

Hot Module Replacement (HMR) is enabled — changes reflect instantly.

## Building for Production

```bash
npm run build
```

The build output is placed in `../public/laporan-react` (relative to this folder), which is the Laravel `public/laporan-react/` directory.

After building, the app is accessible at: `http://your-laravel-domain/laporan-react/`

## Preview Production Build

```bash
npm run preview
```

## Deployment

### Option 1: Build directly (recommended)

Run `npm run build` from inside `laporan-react/`. The `vite.config.js` is already configured to output to `../public/laporan-react`, so no manual copying is needed.

### Option 2: CI/CD Pipeline

Add to your pipeline:

```bash
cd laporan-react
npm ci
npm run build
```

### Laravel Route (optional)

If you want to serve this app via a Laravel route, add to `routes/web.php`:

```php
Route::get('/laporan-react/{any?}', function () {
    return file_get_contents(public_path('laporan-react/index.html'));
})->where('any', '.*');
```

## CORS Configuration

During **development**: CORS is handled by Vite's proxy (`vite.config.js`). No Laravel CORS changes needed.

During **production**: The React build is served as static files from Laravel's `public/` folder — same origin, no CORS needed.

If serving from a different domain, add the React app's origin to Laravel's CORS config (`config/cors.php`):

```php
'allowed_origins' => ['https://your-domain.com'],
```

## API Endpoints Used

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/laporan/batch` | Get all batch/kelas options |
| GET | `/api/laporan/siswa` | Paginated siswa list with search/filter |
| GET | `/api/laporan/siswa/{id}/semua-nilai` | Complete test results for one siswa |

## Tech Stack

| Package | Version | Purpose |
|---------|---------|---------|
| React | 18.3.x | UI framework |
| Vite | 5.3.x | Build tool + dev server |
| TanStack Query | 5.40.x | Server state management, caching |
| Tailwind CSS | 3.4.x | Utility-first styling |
| Recharts | 2.12.x | Charts (Radar, Bar) |
| Axios | 1.7.x | HTTP client |

## Features

- **Filter & Search**: Real-time filter by name and batch/kelas
- **Pagination**: Server-side pagination with ellipsis navigation
- **Per-row detail loading**: Each table row loads its own IQ score via individual API calls (cached by TanStack Query)
- **Detail Modal** with 5 tabs:
  - Profil & Nilai (personal info + scores)
  - Jawaban (answer tables for Part 1–4)
  - NEO-PI (Big Five radar chart + interactive per-domain facet charts)
  - Dark Triad (sekala bar chart + kuesioner answers)
  - MMPI (sekala bar chart + kuesioner answers)
- **Loading states**: Skeleton rows, spinners
- **Error states**: User-friendly error messages with retry
- **Empty states**: Friendly empty-data UI
- **Responsive**: Works on mobile, tablet, and desktop

## Notes

- All API data is cached for 5 minutes by default (configurable in `main.jsx`)
- The `SiswaRow` component triggers individual detail API calls for each visible row to populate IQ/kualifikasi columns — this matches the original Laravel behavior
- Charts are only rendered when data is available; empty/missing data shows a graceful fallback
