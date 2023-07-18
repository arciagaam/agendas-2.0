@props(['label'])

<div {{$attributes->class([
    'relative flex w-1/2',

])}}>

    <button class="section_dropdown_label flex items-center justify-center gap-2 w-full">
        <p class="whitespace-none">{{$label}}</p>
        <box-icon name="chevron-down"></box-icon>
    </button>

    <div aria-expanded="false" class="section_dropdown_body absolute top-[100%] left-0 overflow-y-hidden max-h-0 bg-red-50 z-50 aria-expanded:max-h-[100rem] transition-all">
        {{$slot}}
    </div>
</div>

@vite('resources/js/sections_dropdown.js')