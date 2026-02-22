@props([
  'title',
  'value',
  'icon',
  'change' => null,
  'changeLabel' => '',
  'color' => 'blue' // blue, green, red, yellow
])

@php
  $colorClasses = [
    'blue' => 'bg-blue-100 text-blue-600',
    'green' => 'bg-green-100 text-green-600',
    'red' => 'bg-red-100 text-red-600',
    'yellow' => 'bg-yellow-100 text-yellow-600',
    'brand' => 'bg-brand-100 text-brand-600'
  ];
  
  $iconBg = $colorClasses[$color] ?? $colorClasses['blue'];
@endphp

<div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-md hover:-translate-y-1 relative overflow-hidden">
  {{-- Sublte brand border top --}}
  @if($color === 'brand')
    <div class="absolute top-0 left-0 w-full h-1 bg-brand-500"></div>
  @endif

  <div class="flex justify-between items-start">
    <div>
      <p class="text-sm font-medium text-gray-500 mb-1">{{ $title }}</p>
      <h3 class="text-2xl font-bold text-gray-800">{{ $value }}</h3>
    </div>
    
    <div class="p-3 rounded-full {{ $iconBg }} flex items-center justify-center">
      {!! $icon !!}
    </div>
  </div>

  @if($change !== null)
    <div class="mt-4 flex items-center text-sm">
      @if($change > 0)
        <span class="badge-up bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-medium flex items-center text-xs">
          <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
          {{ $change }}%
        </span>
      @elseif($change < 0)
        <span class="badge-down bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-medium flex items-center text-xs">
          <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
          {{ abs($change) }}%
        </span>
      @else
        <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full font-medium text-xs">0%</span>
      @endif
      <span class="text-gray-400 ml-2 text-xs truncate">{{ $changeLabel }}</span>
    </div>
  @else
    <div class="mt-4 text-xs text-gray-400 truncate">{{ $changeLabel }}</div>
  @endif
</div>
