@extends('layouts.app')

@section('title', 'Log Reading - GlucoTrack')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="mb-6">
        <a href="{{ route('readings.index') }}" class="text-sm text-slate-500 hover:text-slate-700">← Back to Readings</a>
        <h1 class="text-2xl font-bold text-slate-800 mt-2">Log Blood Sugar Reading</h1>
        <p class="text-slate-500 text-sm mt-1">Enter your current blood sugar level in mg/dL.</p>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <form action="{{ route('readings.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Blood Sugar Level --}}
            <div>
                <label for="level" class="block text-sm font-semibold text-slate-700 mb-1">
                    Blood Sugar Level <span class="text-slate-400 font-normal">(mg/dL)</span>
                </label>
                <input
                    type="number"
                    id="level"
                    name="level"
                    step="0.01"
                    min="20"
                    max="600"
                    value="{{ old('level') }}"
                    placeholder="e.g. 110"
                    class="w-full border border-slate-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-rose-400 focus:border-transparent @error('level') border-red-400 @enderror"
                >
                @error('level')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Meal Context --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">When did you measure?</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                    @foreach([
                        'fasting'     => ['label' => 'Fasting',      'icon' => '🌙'],
                        'before_meal' => ['label' => 'Before Meal',  'icon' => '🍽️'],
                        'after_meal'  => ['label' => 'After Meal',   'icon' => '✅'],
                        'bedtime'     => ['label' => 'Bedtime',      'icon' => '😴'],
                        'random'      => ['label' => 'Random',       'icon' => '🎲'],
                    ] as $value => $item)
                    <label class="cursor-pointer">
                        <input type="radio" name="meal_context" value="{{ $value }}"
                               class="sr-only peer"
                               {{ old('meal_context') === $value ? 'checked' : '' }}>
                        <div class="border-2 border-slate-200 rounded-lg p-3 text-center text-sm font-medium
                                    peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-700
                                    hover:border-slate-300 transition select-none">
                            <span class="text-lg block">{{ $item['icon'] }}</span>
                            {{ $item['label'] }}
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('meal_context')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Notes --}}
            <div>
                <label for="notes" class="block text-sm font-semibold text-slate-700 mb-1">
                    Notes <span class="text-slate-400 font-normal">(optional)</span>
                </label>
                <textarea
                    id="notes"
                    name="notes"
                    rows="3"
                    placeholder="E.g. Had rice for lunch, feeling slightly tired..."
                    class="w-full border border-slate-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-rose-400 focus:border-transparent resize-none"
                >{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-rose-600 hover:bg-rose-700 text-white font-semibold py-3 rounded-lg transition text-base">
                Save Reading
            </button>
        </form>
    </div>

    {{-- Reference Card --}}
    <div class="mt-6 bg-slate-100 rounded-xl p-5 text-sm text-slate-600">
        <p class="font-semibold text-slate-700 mb-3">📊 Normal Blood Sugar Reference</p>
        <div class="space-y-2">
            <div class="flex justify-between"><span>Fasting / Before Meal</span><span class="font-medium text-green-700">70–99 mg/dL</span></div>
            <div class="flex justify-between"><span>After Meal (2 hrs)</span><span class="font-medium text-green-700">Below 140 mg/dL</span></div>
            <div class="flex justify-between"><span>Bedtime</span><span class="font-medium text-green-700">100–140 mg/dL</span></div>
        </div>
    </div>
</div>
@endsection