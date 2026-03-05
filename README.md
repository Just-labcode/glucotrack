# 🩸 GlucoTrack — Laravel Blood Sugar Tracker

A clean Laravel MVC app to log blood sugar readings, detect status (Low / Normal / Elevated / High), and give actionable suggestions.

---

## 🚀 Setup Options

Choose the method that works best for you:

| Method | Best for | Requirements |
|--------|----------|--------------|
| 🐳 Docker | Anyone who wants the easiest setup | Docker Desktop |
| ⚙️ Manual | Developers with PHP/Laravel installed | PHP 8.4, Composer |

---

## 🐳 Option 1 — Docker (Recommended)

The easiest way to run GlucoTrack. No PHP or Composer needed — just Docker.

### 1. Install Docker Desktop
👉 https://www.docker.com/products/docker-desktop

### 2. Clone the repository

```bash
git clone https://github.com/Just-labcode/glucotrack.git
cd glucotrack
```

### 3. Copy the environment file

```bash
cp .env.example .env
```

Then open `.env` and set:

```env
DB_CONNECTION=sqlite
APP_KEY=         # leave blank for now, next step fills this in
```

### 4. Build the Docker image

```bash
docker build -t glucotrack .
```

### 5. Generate your app key

```bash
docker run --rm glucotrack php artisan key:generate --show
```

Copy the output (starts with `base64:...`) and paste it as `APP_KEY` in your `.env` file.

### 6. Run the app

```bash
docker run -p 8080:8080 \
  -e APP_KEY=your_key_here \
  -e DB_CONNECTION=sqlite \
  -e APP_ENV=local \
  glucotrack
```

### 7. Visit the app

👉 **http://localhost:8080**

---

### 🔄 Keeping your data between restarts (Docker Volume)

By default, SQLite data is lost when the container stops. To keep your data, use a volume:

```bash
# Create a volume
docker volume create glucotrack-data

# Run with the volume attached
docker run -p 8080:8080 \
  -e APP_KEY=your_key_here \
  -e DB_CONNECTION=sqlite \
  -e APP_ENV=local \
  -v glucotrack-data:/app/database \
  glucotrack
```

---

## ⚙️ Option 2 — Manual Setup (Laravel + PHP)

### Requirements
- PHP 8.4+
- Composer
- Laravel Herd (Windows/Mac) or any local PHP server

### 1. Clone the repository

```bash
git clone https://github.com/Just-labcode/glucotrack.git
cd glucotrack
```

### 2. Install dependencies

```bash
composer install
```

### 3. Copy and configure the environment file

```bash
cp .env.example .env
```

Open `.env` and set:

```env
DB_CONNECTION=sqlite
```

Remove or comment out these lines:
```
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

### 4. Generate app key

```bash
php artisan key:generate
```

### 5. Create the SQLite database file

**Mac/Linux:**
```bash
touch database/database.sqlite
```

**Windows (PowerShell):**
```powershell
New-Item database\database.sqlite
```

### 6. Run migrations

```bash
php artisan migrate
```

### 7. Start the server

```bash
php artisan serve
```

Visit: **http://localhost:8000**

> If using Laravel Herd, visit **http://glucotrack.test** instead.

---

## 📁 File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── BloodSugarReadingController.php   ← CRUD logic + stats
│   └── Requests/
│       └── BloodSugarReadingRequest.php       ← Validation rules
└── Models/
    └── BloodSugarReading.php                  ← Status, suggestion, color logic

database/
└── migrations/
    └── ..._create_blood_sugar_readings_table.php

resources/views/
├── layouts/
│   └── app.blade.php          ← Navbar, flash messages, footer
└── readings/
    ├── index.blade.php        ← List + stats dashboard
    ├── create.blade.php       ← Log new reading form
    ├── show.blade.php         ← Detail view with status & suggestion
    └── edit.blade.php         ← Edit form

routes/
└── web.php                    ← Route::resource('readings', ...)

Dockerfile                     ← Docker configuration
```

---

## 🩺 Blood Sugar Status Logic

| Status | Fasting Range | After Meal Range |
|--------|--------------|-----------------|
| 🔵 Low | < 70 mg/dL | < 70 mg/dL |
| 🟢 Normal | 70–99 mg/dL | 70–139 mg/dL |
| 🟡 Elevated | 100–125 mg/dL | 140–199 mg/dL |
| 🔴 High | 126+ mg/dL | 200+ mg/dL |

> Ranges adjust based on `meal_context` (Fasting, Before Meal, After Meal, Bedtime, Random).

---

## ✅ Features

- Log readings with level (mg/dL), meal context, and optional notes
- Auto-detects: Low / Normal / Elevated / High status
- Personalized suggestions per status + meal context
- Dashboard with total, average, highest, lowest stats
- Status breakdown counts (Low / Normal / Elevated / High)
- Edit and delete readings
- Pagination
- Docker support for easy deployment

---

## 🛠️ Common Issues

| Problem | Solution |
|---------|----------|
| `php: command not found` in Docker | Make sure Docker Desktop is running |
| 500 Server Error | Check that `APP_KEY` is set in your environment |
| Data lost after restart | Use a Docker volume (see above) |
| `migrate` errors | Run `php artisan migrate:fresh` to reset |

---

> ⚠️ This app is for personal tracking only. Always consult your healthcare provider for medical decisions.
> Developed by Labcodebytes/Lionel-Dev