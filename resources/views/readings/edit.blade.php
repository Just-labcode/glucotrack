@extends('layouts.app')

@section('title', 'Edit Reading - GlucoTrack')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="mb-6">
        <a href="{{ route('readings.show', $reading) }}" class="text-sm text-slate-500 hover:text-slate-700">← Back to Reading</a>
        <h1 class="text-2xl font-bold text-slate-800 mt-2">Edit Reading</h1>
        <p class="text-slate-500 text-sm mt-1">Logged on {{ $reading->created_at->format('M d, Y \a\t h:i A') }}</p>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <form action="{{ route('readings.update', $reading) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

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
                    value="{{ old('level', $reading->level) }}"
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
                               {{ old('meal_context', $reading->meal_context) === $value ? 'checked' : '' }}>
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
                    class="w-full border border-slate-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-rose-400 focus:border-transparent resize-none"
                >{{ old('notes', $reading->notes) }}</textarea>
                @error('notes')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="flex-1 bg-rose-600 hover:bg-rose-700 text-white font-semibold py-3 rounded-lg transition">
                    Update Reading
                </button>
                <a href="{{ route('readings.show', $reading) }}"
                   class="flex-1 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-3 rounded-lg transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection