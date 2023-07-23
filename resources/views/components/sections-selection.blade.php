@props(['gradeLevel' => ''])

<div class="flex flex-col border-x border-b border-project-gray-default box-content flex-1 hover:bg-project-gray-default">
    <button class="selection_dropdown_label flex gap-2 text-left px-2" data-value="{{$gradeLevel}}">
        <p class="w-full text-sm">Grade {{$gradeLevel}}</p>
        <box-icon name="chevron-down"></box-icon>
    </button>

    <div aria-expanded="false"class="selection_dropdown_body bg-white overflow-hidden max-h-0 aria-expanded:max-h-[100rem] transition-all">
        {{$slot}}
    </div>
</div>