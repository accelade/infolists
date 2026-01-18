@props(['framework' => 'vanilla', 'prefix' => 'a', 'documentation' => null, 'hasDemo' => true])

<x-accelade::layouts.docs :framework="$framework" section="infolist-code-entry" :documentation="$documentation" :hasDemo="$hasDemo">
    @include('infolist::demo.partials._infolist-code-entry')
</x-accelade::layouts.docs>
