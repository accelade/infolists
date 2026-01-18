@props([
    'entry' => null,
    'orientation' => 'horizontal',
    'text' => null,
    'textPosition' => 'center',
    'color' => 'gray',
    'thickness' => 'thin',
    'style' => 'solid',
])

@php
    if ($entry) {
        // Object-based usage
        $orientation = $entry->getOrientation();
        $text = $entry->getText();
        $textPosition = $entry->getTextPosition();
        $colorClasses = $entry->getSeparatorColorClasses();
        $thicknessClasses = $entry->getThicknessClasses();
        $styleClasses = $entry->getStyleClasses();
        $isVertical = $entry->isVertical();
    } else {
        // Prop-based standalone usage
        $isVertical = $orientation === 'vertical';

        // Color classes
        $colorClasses = match ($color) {
            'primary' => 'border-primary-500 dark:border-primary-400',
            'success' => 'border-success-500 dark:border-success-400',
            'danger' => 'border-danger-500 dark:border-danger-400',
            'warning' => 'border-warning-500 dark:border-warning-400',
            'info' => 'border-info-500 dark:border-info-400',
            default => 'border-gray-200 dark:border-gray-700',
        };

        // Thickness classes
        $thicknessClasses = match ($thickness) {
            'medium' => $isVertical ? 'border-l-2' : 'border-t-2',
            'thick' => $isVertical ? 'border-l-4' : 'border-t-4',
            default => $isVertical ? 'border-l' : 'border-t',
        };

        // Style classes
        $styleClasses = match ($style) {
            'dashed' => 'border-dashed',
            'dotted' => 'border-dotted',
            default => 'border-solid',
        };
    }
@endphp

@if ($isVertical)
    {{-- Vertical separator --}}
    <div
        @class([
            'self-stretch',
            $colorClasses,
            $thicknessClasses,
            $styleClasses,
        ])
        role="separator"
        aria-orientation="vertical"
    ></div>
@else
    {{-- Horizontal separator --}}
    @if ($text)
        {{-- Separator with text --}}
        <div class="flex items-center w-full my-4" role="separator" aria-orientation="horizontal">
            @if ($textPosition === 'center' || $textPosition === 'right')
                <div
                    @class([
                        'flex-1',
                        $colorClasses,
                        $thicknessClasses,
                        $styleClasses,
                    ])
                ></div>
            @endif

            <span
                @class([
                    'px-3 text-sm text-gray-500 dark:text-gray-400',
                    'pl-0' => $textPosition === 'left',
                    'pr-0' => $textPosition === 'right',
                ])
            >
                {{ $text }}
            </span>

            @if ($textPosition === 'center' || $textPosition === 'left')
                <div
                    @class([
                        'flex-1',
                        $colorClasses,
                        $thicknessClasses,
                        $styleClasses,
                    ])
                ></div>
            @endif
        </div>
    @else
        {{-- Simple separator --}}
        <div
            @class([
                'w-full my-4',
                $colorClasses,
                $thicknessClasses,
                $styleClasses,
            ])
            role="separator"
            aria-orientation="horizontal"
        ></div>
    @endif
@endif
