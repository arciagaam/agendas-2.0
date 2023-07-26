<div class="nav_accordion flex flex-col overflow-hidden cursor-pointer whitespace-nowrap">
    <div class="flex gap-4 items-center text-white fill-white hover:fill-project-accent-500 hover:text-project-accent-500 duration-200 ease-in-out">
        <box-icon name="{{$name}}"></box-icon>
        <p class="text-sm">
            {{$label}}
        </p>
        <box-icon type='solid' name='chevron-down'></box-icon>
    </div>

    <div class="accordion_content flex flex-col items-start max-h-[0rem] transition-all ease-in-out duration-500 delay-0s gap-3">
        {{$slot}}
    </div>
</div>

@vite('resources/js/navbar.js')
