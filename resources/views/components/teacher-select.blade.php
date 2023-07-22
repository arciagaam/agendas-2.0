@props(['fetchedTeacher' => '', 'fetchedTeacherId'])

<div {{$attributes->class([
    'teacher-select-dropdown',
    'relative flex flex-col'
])}}>
    <button class="teacher_select_dropdown_label flex gap-2">
        <p id="{{$fetchedTeacherId ?? ''}}" class="selectedOption">{{$fetchedTeacher == '' ? 'Select Teacher' : $fetchedTeacher ?? 'Select Teacher'}}</p>
        <box-icon name="chevron-down"></box-icon>
    </button>

    <div aria-expanded="false" class="teacher_select_dropdown_body absolute top-[100%] z-10 bg-white overflow-y-hidden max-h-0 aria-expanded:max-h-[100rem] transition-all">
        {{$slot}}
    </div>
</div>

@vite('resources/js/subject_teacher_dropdown.js')