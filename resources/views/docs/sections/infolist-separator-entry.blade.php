@props(['framework' => 'vanilla', 'prefix' => 'a', 'documentation' => null, 'hasDemo' => true])

<x-accelade::layouts.docs :framework="$framework" section="infolist-separator-entry" :documentation="$documentation" :hasDemo="$hasDemo">
    @include('infolist::demo.partials._infolist-separator-entry')
</x-accelade::layouts.docs>
