@props(['label'])

<div class="flex flex-col w-full gap-1 relative col-span-2">
    <p class="whitespace-none w-full text-left text-sm">{{$label}}</p>
    <div {{$attributes->class([
        'relative flex bg-white ring-1 ring-project-gray-default rounded-lg',

    ])}}>

        <button class="section_dropdown_label flex flex-row items-center justify-start gap-2 w-full px-2 py-1">
            <p class="whitespace-none w-full text-left text-sm">{{$label}}</p>
            <box-icon name="chevron-down"></box-icon>
        </button>

        <div aria-expanded="false" class="flex flex-col w-full section_dropdown_body absolute top-[100%] left-0 overflow-y-hidden max-h-0 bg-white z-50 aria-expanded:max-h-[100rem] transition-all">
            {{$slot}}
        </div>
    </div>
</div>

@vite('resources/js/sections_dropdown.js')