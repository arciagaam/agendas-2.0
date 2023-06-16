<div class="nav_accordion flex flex-col overflow-hidden cursor-pointer whitespace-nowrap">
    <div class="flex gap-4 items-center">
        <box-icon name="{{$name}}" color="white"></box-icon>
        <p class="text-sm">
            {{$label}}
        </p>
        <box-icon type='solid' name='chevron-down' color="white"></box-icon>
    </div>

    <div class="accordion_content flex flex-col items-start max-h-[0rem] transition-all ease-in-out duration-500 delay-0s gap-3">
        {{$slot}}
    </div>
</div>

@vite('resources/js/navbar.js')
