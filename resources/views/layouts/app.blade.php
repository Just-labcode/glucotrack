<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blood Sugar Tracker')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .status-low      { @apply bg-blue-50 border-blue-400 text-blue-900; }
        .status-normal   { @apply bg-green-50 border-green-400 text-green-900; }
        .status-elevated { @apply bg-yellow-50 border-yellow-400 text-yellow-900; }
        .status-high     { @apply bg-red-50 border-red-400 text-red-900; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('readings.index') }}" class="flex items-center gap-2 text-xl font-bold text-rose-600">
                <span class="text-2xl">🩸</span>
                <span>GlucoTrack</span>
            </a>
            <a href="{{ route('readings.create') }}"
               class="bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                + Log Reading
            </a>
        </div>
    </nav>

    {{-- Flash Messages --}}
    <div class="max-w-4xl mx-auto px-4 mt-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg text-sm mb-4">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg text-sm mb-4">
                ❌ {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- Main Content --}}
    <main class="max-w-4xl mx-auto px-4 py-6">
        @yield('content')
    </main>

    <footer class="text-center text-slate-400 text-xs py-8 mt-4">
        GlucoTrack &mdash; Always consult your healthcare provider for medical advice.
    </footer>
</body>
</html>