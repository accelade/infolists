@props([
    'infolist',
])

@php
    use Accelade\Schemas\Component as SchemaComponent;

    $record = $infolist->getRecord();
    $columns = $infolist->getColumns();
    $columnClasses = match ($columns) {
        1 => 'grid-cols-1',
        2 => 'grid-cols-1 sm:grid-cols-2',
        3 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
        4 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
        default => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-' . $columns,
    };
@endphp

<div {{ $attributes->class([
    'accelade-infolist',
    'grid gap-6',
    $columnClasses,
]) }}>
    @foreach ($infolist->getEntries() as $entry)
        @php
            // Schema layout components (Grid, Section, etc.) span full by default
            $isSchemaComponent = $entry instanceof SchemaComponent;
            $columnSpan = $entry->getColumnSpan() ?? ($isSchemaComponent ? 'full' : null);
            $columnStart = $entry->getColumnStart();

            $spanClass = match ($columnSpan) {
                'full' => 'col-span-full',
                2 => 'sm:col-span-2',
                3 => 'lg:col-span-3',
                4 => 'lg:col-span-4',
                default => null,
            };

            $startClass = $columnStart ? "col-start-{$columnStart}" : null;
        @endphp

        @if (! $entry->isHidden())
            <div @class([
                'accelade-infolist-entry',
                $spanClass,
                $startClass,
            ])>
                {!! $entry->toHtml() !!}
            </div>
        @endif
    @endforeach
</div>
