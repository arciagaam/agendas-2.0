@props(['subjectType'])

<div {{$attributes->class([
    'flex flex-col'
])}}>

    <button class="subject_selection_dropdown_label flex gap-2">
        <p>{{$subjectType}}</p>
        <box-icon name="chevron-down"></box-icon>
    </button>

    <div aria-expanded="false" class="subject_selection_dropdown_body bg-white overflow-y-hidden max-h-0 aria-expanded:max-h-[100rem] transition-all">
        {{$slot}}
    </div>
</div>