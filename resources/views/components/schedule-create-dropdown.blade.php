@props(['label'])

<div 
data-type=""
data-id=""
{{$attributes->class([
    'schedule_dropdown_container relative flex w-1/2',
])}}>

    <button class="schedule_dropdown_label flex items-center justify-center gap-2 w-full">
        <p class="whitespace-none section_dropdown_label_display">{{$label}}</p>
        <box-icon name="chevron-down"></box-icon>
    </button>

    <div aria-expanded="false" class="schedule_dropdown_body absolute top-[100%] left-0 overflow-y-hidden max-h-0 bg-red-50 z-50 aria-expanded:max-h-[100rem] transition-all">
        {{$slot}}
    </div>
</div>

@vite('resources/js/schedule_dropdown.js')