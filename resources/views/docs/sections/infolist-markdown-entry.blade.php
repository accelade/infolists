@props(['framework' => 'vanilla', 'prefix' => 'a', 'documentation' => null, 'hasDemo' => true])

<x-accelade::layouts.docs :framework="$framework" section="infolist-markdown-entry" :documentation="$documentation" :hasDemo="$hasDemo">
    @include('infolist::demo.partials._infolist-markdown-entry')
</x-accelade::layouts.docs>
