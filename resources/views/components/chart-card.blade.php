@props(['title', 'subtitle' => null])

<div class="chart-container bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col h-full">
  <div class="mb-4">
    <h3 class="font-bold text-gray-800 text-lg">{{ $title }}</h3>
    @if($subtitle)
      <p class="text-sm text-gray-500">{{ $subtitle }}</p>
    @endif
  </div>
  
  <div class="flex-grow relative min-h-[300px] w-full">
    {{ $slot }}
  </div>
</div>
