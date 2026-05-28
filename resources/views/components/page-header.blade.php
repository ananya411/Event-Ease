@props(['title', 'subtitle' => null])

<div class="flex flex-wrap items-start justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $title }}</h1>
        @if($subtitle)
            <p class="mt-1 text-slate-600">{{ $subtitle }}</p>
        @endif
    </div>
    @if(isset($actions))
        <div class="flex flex-wrap items-center gap-2">
            {{ $actions }}
        </div>
    @endif
</div>
