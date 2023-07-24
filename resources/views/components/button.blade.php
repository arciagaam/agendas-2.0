@props(['label' => '', 'icon' => '', 'type' => 'primary', 'id' => ''])

<button id="{{$id}}"
{{$attributes->class([
    'rounded-lg py-2 px-4 transition-all duration-200 ease-in-out text-sm font-medium',
    'border border-2 border-project-gray-default hover:border-project-accent hover:text-project-accent hover:fill-project-accent' => $type == 'primary',
    'bg-project-gray-light' => $type == 'secondary',
    ])}}

>
    <div class="flex items-center justify-center gap-2">
        
        @if ($icon)
            {{$icon}}
        @endif

        <p>{{$label}}</p>
    </div>
</button>