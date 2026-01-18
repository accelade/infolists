@props(['framework' => 'vanilla', 'prefix' => 'a', 'documentation' => null, 'hasDemo' => true])

<x-accelade::layouts.docs :framework="$framework" section="infolist-key-value-entry" :documentation="$documentation" :hasDemo="$hasDemo">
    @include('infolist::demo.partials._infolist-key-value-entry')
</x-accelade::layouts.docs>
