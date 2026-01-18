@props([
    'entry',
])

@php
    $label = $entry->getLabel();
    $isLabelHidden = $entry->isLabelHidden();
    $hint = $entry->getHint();
    $hintIcon = $entry->getHintIcon();
    $hintColor = $entry->getHintColor();
    $helperText = $entry->getHelperText();
    $isInline = $entry->isInline();
    $extraAttributes = $entry->getExtraAttributes();
@endphp

<div
    @if ($extraAttributes)
        @foreach ($extraAttributes as $key => $value)
            {{ $key }}="{{ $value }}"
        @endforeach
    @endif
    {{ $attributes->class([
        'accelade-entry',
        'flex gap-x-3' => $isInline,
    ]) }}
>
    @if ($label && ! $isLabelHidden)
        <div @class([
            'accelade-entry-label',
            'flex items-center gap-x-2',
            'shrink-0 w-1/3' => $isInline,
            'mb-1' => ! $isInline,
        ])>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                {{ $label }}
            </span>

            @if ($hint || $hintIcon)
                <span @class([
                    'text-xs',
                    match ($hintColor) {
                        'primary' => 'text-primary-500',
                        'success' => 'text-success-500',
                        'warning' => 'text-warning-500',
                        'danger' => 'text-danger-500',
                        'info' => 'text-info-500',
                        default => 'text-gray-400 dark:text-gray-500',
                    },
                ])>
                    @if ($hintIcon)
                        <x-accelade::icon :name="$hintIcon" class="h-4 w-4" />
                    @endif
                    @if ($hint)
                        {{ $hint }}
                    @endif
                </span>
            @endif
        </div>
    @endif

    <div @class([
        'accelade-entry-content',
        'flex-1' => $isInline,
    ])>
        {{ $slot }}

        @if ($helperText)
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                {{ $helperText }}
            </p>
        @endif
    </div>
</div>
