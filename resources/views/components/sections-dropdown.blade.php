<div class="relative flex w-1/2">

    <button id="section_dropdown_label" class="flex gap-2 w-1/2">
        <p>Choose Section/s</p>
        <box-icon name="chevron-down"></box-icon>
    </button>

    <div aria-expanded="false" id="section_dropdown_body" class="absolute overflow-hidden top-[100%] w-full max-h-0 bg-white aria-expanded:max-h-[100rem] transition-all">
        {{$slot}}
    </div>
</div>

@vite('resources/js/sections_dropdown.js')