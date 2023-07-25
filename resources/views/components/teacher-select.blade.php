@props(['fetchedTeacher' => '', 'fetchedTeacherId'])

<div {{$attributes->class([
    'teacher-select-dropdown',
    'relative text-center w-full cursor-pointer hover:bg-gray-200 duration-100 rounded-lg'
])}}>
    <button class="teacher_select_dropdown_label flex gap-2 w-full justify-between p-2.5">
        <p id="{{$fetchedTeacherId ?? ''}}" class="selectedOption whitespace-nowrap">{{$fetchedTeacher == '' ? 'Select Teacher' : $fetchedTeacher ?? 'Select Teacher'}}</p>
        <box-icon name="chevron-down"></box-icon>
    </button>

    <div aria-expanded="false" class="teacher_select_dropdown_body absolute top-[100%] z-10 bg-project-primary overflow-y-hidden max-h-0 aria-expanded:max-h-[100rem] transition-all flex flex-col gap-2 w-full">
        {{$slot}}
    </div>
</div>

@vite('resources/js/subject_teacher_dropdown.js')