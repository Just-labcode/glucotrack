@extends('layouts.app')

@section('title', 'Reading Detail - GlucoTrack')

@section('content')
<div class="max-w-lg mx-auto">

    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('readings.index') }}" class="text-sm text-slate-500 hover:text-slate-700">← All Readings</a>
        <div class="flex gap-2">
            <a href="{{ route('readings.edit', $reading) }}"
               class="text-sm bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-4 py-2 rounded-lg transition">
                ✏️ Edit
            </a>
            <form action="{{ route('readings.destroy', $reading) }}" method="POST"
                  onsubmit="return confirm('Delete this reading?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="text-sm bg-red-50 hover:bg-red-100 text-red-600 font-medium px-4 py-2 rounded-lg transition">
                    🗑️ Delete
                </button>
            </form>
        </div>
    </div>

    {{-- Main Result Card --}}
    @php
        $borderColors = [
            'low'      => 'border-blue-400',
            'normal'   => 'border-green-400',
            'elevated' => 'border-yellow-400',
            'high'     => 'border-red-400',
        ];
        $bgColors = [
            'low'      => 'bg-blue-50',
            'normal'   => 'bg-green-50',
            'elevated' => 'bg-yellow-50',
            'high'     => 'bg-red-50',
        ];
        $border = $borderColors[$reading->status] ?? 'border-slate-300';
        $bg = $bgColors[$reading->status] ?? 'bg-slate-50';
    @endphp

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-5">
        {{-- Header --}}
        <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-4">
            <span class="text-5xl">{{ $reading->status_icon }}</span>
            <div>
                <p class="text-4xl font-bold text-slate-800">
                    {{ $reading->level }}
                    <span class="text-xl text-slate-400 font-normal">mg/dL</span>
                </p>
                <p class="text-sm text-slate-500 mt-1">
                    {{ $reading->meal_context_label }} &middot;
                    {{ $reading->created_at->format('F d, Y \a\t h:i A') }}
                </p>
            </div>
        </div>

        {{-- Status Badge --}}
        <div class="px-6 py-4 {{ $bg }} border-l-4 {{ $border }}">
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs uppercase tracking-widest font-bold text-slate-500">Status</span>
            </div>
            <p class="text-xl font-bold capitalize
                @if($reading->status === 'low') text-blue-700
                @elseif($reading->status === 'normal') text-green-700
                @elseif($reading->status === 'elevated') text-yellow-700
                @else text-red-700
                @endif">
                {{ $reading->status }}
            </p>
        </div>
    </div>

    {{-- Suggestion Card --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-5">
        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-3">💡 Suggestion</p>
        <p class="text-slate-700 leading-relaxed">{{ $reading->suggestion }}</p>
    </div>

    {{-- Notes (if any) --}}
    @if($reading->notes)
    <div class="bg-slate-50 rounded-xl border border-slate-200 p-5 mb-5">
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">📝 Notes</p>
        <p class="text-slate-700 text-sm">{{ $reading->notes }}</p>
    </div>
    @endif

    {{-- Reference Ranges --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 text-sm">
        <p class="font-semibold text-slate-700 mb-3">📊 Reference Ranges</p>
        <div class="space-y-2 text-slate-600">
            <div class="flex justify-between items-center py-1 border-b border-slate-100">
                <span>🔵 Low (Hypoglycemia)</span><span class="font-medium text-blue-600">Below 70 mg/dL</span>
            </div>
            <div class="flex justify-between items-center py-1 border-b border-slate-100">
                <span>🟢 Normal</span><span class="font-medium text-green-600">70–99 (fasting)</span>
            </div>
            <div class="flex justify-between items-center py-1 border-b border-slate-100">
                <span>🟡 Elevated (Pre-diabetic)</span><span class="font-medium text-yellow-600">100–125 (fasting)</span>
            </div>
            <div class="flex justify-between items-center py-1">
                <span>🔴 High (Diabetic range)</span><span class="font-medium text-red-600">126+ (fasting)</span>
            </div>
        </div>
        <p class="text-xs text-slate-400 mt-4">* Ranges may vary by meal context. Always consult your doctor.</p>
    </div>

</div>
@endsection