@props(['gradeLevel' => ''])

<div class="flex flex-col">
    <button class="selection_dropdown_label flex gap-2">
        <p>Grade {{$gradeLevel}}</p>
        <box-icon name="chevron-down"></box-icon>
    </button>

    <div aria-expanded="false" class="selection_dropdown_body w-full bg-white overflow-hidden max-h-0 aria-expanded:max-h-[100rem] transition-all">
        {{$slot}}
    </div>
</div>