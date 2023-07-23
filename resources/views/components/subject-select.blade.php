@props(['fetchedSubject' => '', 'fetchedSubjectId'])

<div {{$attributes->class([
    'subject-select-dropdown relative flex flex-col h-full w-full items-center'
])}}>
    {{-- @dd($fetchedSubject) --}}
    <button class="subject_select_dropdown_label flex gap-2">
        <p id="{{$fetchedSubjectId ?? ''}}" class="selectedOption">{{$fetchedSubject == '' ? 'Select Subject' : $fetchedSubject ?? 'Select Subject'}}</p>
        <box-icon name="chevron-down"></box-icon>
    </button>

    <div aria-expanded="false" class="subject_select_dropdown_body absolute top-[100%] z-10 bg-white overflow-y-hidden max-h-0 aria-expanded:max-h-[100rem] transition-all">
        {{$slot}}
    </div>
</div>

@vite('resources/js/subject_teacher_dropdown.js')