@extends('layouts.app')

@section('title', 'All Readings - GlucoTrack')

@section('content')

{{-- Stats Cards --}}
@if($stats['total'] > 0)
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl border border-slate-200 p-4 text-center shadow-sm">
        <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Total Logs</p>
        <p class="text-3xl font-bold text-slate-800">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-4 text-center shadow-sm">
        <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Average</p>
        <p class="text-3xl font-bold text-slate-800">{{ $stats['average'] ?? '—' }}</p>
        <p class="text-xs text-slate-400">mg/dL</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-4 text-center shadow-sm">
        <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Highest</p>
        <p class="text-3xl font-bold text-red-500">{{ $stats['highest'] ?? '—' }}</p>
        <p class="text-xs text-slate-400">mg/dL</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-4 text-center shadow-sm">
        <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Lowest</p>
        <p class="text-3xl font-bold text-blue-500">{{ $stats['lowest'] ?? '—' }}</p>
        <p class="text-xs text-slate-400">mg/dL</p>
    </div>
</div>

{{-- Status breakdown --}}
<div class="grid grid-cols-4 gap-3 mb-8">
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-center">
        <p class="text-xl font-bold text-blue-700">{{ $statusCounts['low'] }}</p>
        <p class="text-xs text-blue-600">🔵 Low</p>
    </div>
    <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-center">
        <p class="text-xl font-bold text-green-700">{{ $statusCounts['normal'] }}</p>
        <p class="text-xs text-green-600">🟢 Normal</p>
    </div>
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-center">
        <p class="text-xl font-bold text-yellow-700">{{ $statusCounts['elevated'] }}</p>
        <p class="text-xs text-yellow-600">🟡 Elevated</p>
    </div>
    <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-center">
        <p class="text-xl font-bold text-red-700">{{ $statusCounts['high'] }}</p>
        <p class="text-xs text-red-600">🔴 High</p>
    </div>
</div>
@endif

{{-- Readings List --}}
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-slate-800">Recent Readings</h2>
        <a href="{{ route('readings.create') }}" class="text-sm text-rose-600 hover:underline font-medium">+ New</a>
    </div>

    @if($readings->isEmpty())
        <div class="text-center py-16 text-slate-400">
            <p class="text-5xl mb-4">📋</p>
            <p class="text-lg font-medium">No readings yet</p>
            <p class="text-sm mt-1">Start by logging your first blood sugar reading.</p>
            <a href="{{ route('readings.create') }}"
               class="mt-4 inline-block bg-rose-600 text-white text-sm font-semibold px-5 py-2 rounded-lg hover:bg-rose-700 transition">
                Log First Reading
            </a>
        </div>
    @else
        <div class="divide-y divide-slate-100">
            @foreach($readings as $reading)
            <a href="{{ route('readings.show', $reading) }}"
               class="flex items-center justify-between px-6 py-4 hover:bg-slate-50 transition group">
                <div class="flex items-center gap-4">
                    <span class="text-2xl">{{ $reading->status_icon }}</span>
                    <div>
                        <p class="font-semibold text-slate-800 group-hover:text-rose-600 transition">
                            {{ $reading->level }} <span class="text-slate-400 font-normal text-sm">mg/dL</span>
                        </p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $reading->meal_context_label }} &middot; {{ $reading->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                <span class="text-xs font-semibold px-3 py-1 rounded-full border {{ $reading->status_color }} capitalize">
                    {{ $reading->status }}
                </span>
            </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($readings->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $readings->links() }}
        </div>
        @endif
    @endif
</div>

@endsection