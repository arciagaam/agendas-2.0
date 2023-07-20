@props(['fetchedSubject' => '',])

<div {{$attributes->class([
    'subject-select-dropdown',
    'relative flex flex-col'
])}}>

    <button class="subject_select_dropdown_label flex gap-2">
        <p class="selectedOption">{{$fetchedSubject ?? ''}}</p>
        <box-icon name="chevron-down"></box-icon>
    </button>

    <div aria-expanded="false" class="subject_select_dropdown_body absolute mt-2 z-10 bg-white overflow-y-hidden max-h-0 aria-expanded:max-h-[100rem] transition-all">
        {{$slot}}
    </div>
</div>

@vite('resources/js/subject_teacher_dropdown.js')