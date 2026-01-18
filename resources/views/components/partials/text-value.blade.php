@php
    $url = $entry->getUrl();
    $shouldOpenUrlInNewTab = $entry->shouldOpenUrlInNewTab();
    $isMarkdown = $entry->isMarkdown();
    $isHtml = $entry->isHtml();
@endphp

@if ($url)
    <a
        href="{{ $url }}"
        @if ($shouldOpenUrlInNewTab) target="_blank" rel="noopener noreferrer" @endif
        class="hover:underline"
    >
@endif

@if ($isMarkdown)
    <span class="prose prose-sm dark:prose-invert">{!! Str::markdown((string) $value) !!}</span>
@elseif ($isHtml)
    {!! $value !!}
@else
    {{ $value }}
@endif

@if ($url)
    </a>
@endif
