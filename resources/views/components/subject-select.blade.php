@props(['fetchedSubject' => '', 'fetchedSubjectId'])

<div {{$attributes->class([
    'subject-select-dropdown w-full relative cursor-pointer hover:bg-gray-200 duration-100 rounded-lg'
])}}>
    {{-- @dd($fetchedSubject) --}}
    <button class="subject_select_dropdown_label flex gap-2 w-full justify-between p-2.5">
        <p id="{{$fetchedSubjectId ?? ''}}" class="selectedOption whitespace-nowrap">{{$fetchedSubject == '' ? 'Select Subject' : $fetchedSubject ?? 'Select Subject'}}</p>
        <box-icon name="chevron-down"></box-icon>
    </button>

    <div aria-expanded="false" class="subject_select_dropdown_body absolute left-0 top-[100%] z-10 bg-project-primary-600 overflow-y-hidden max-h-0 aria-expanded:max-h-[100rem] transition-all flex flex-col gap-2 w-full">
        <button class="clear_cell mx-2 mt-2 p-1 rounded-lg transition-all duration-200 ease-in-out text-sm font-medium text-amber-500 ring-1 ring-amber-500 fill-white hover:text-white hover:bg-amber-500">
            Clear Cell
        </button>
        {{$slot}}
    </div>
</div>

{{-- @vite('resources/js/subject_teacher_dropdown.js') --}}