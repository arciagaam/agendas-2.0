@props(['label' => '', 'icon' => '', 'type' => 'primary', 'size' => 'md', 'class' => '', 'url' => ''])

<a href="{{$url}}"
    {{$attributes->class([
        'rounded-lg transition-all duration-200 ease-in-out text-sm font-medium z-20',
        'bg-project-accent-500 text-white ring-1 ring-project-accent-500 fill-white hover:ring-project-accent-400 hover:fill-white hover:bg-project-accent-400' => $type == 'primary',
        'bg-white text-project-primary-600 ring-1 ring-project-gray-default fill-project-primary-600 hover:ring-project-accent-500 hover:text-project-accent-500 hover:fill-project-accent-400' => $type == 'secondary',
        'text-project-primary-600 fill-project-primary-600 hover:text-project-accent-500 hover:fill-project-accent-400' => $type == 'tertiary',
        'bg-project-gray-light text-project-primary-600 ring-1 ring-project-gray-default hover:bg-project-gray-default' => $type == 'inactive',
        'py-1 px-0' => $size == 'none',
        'px-2 py-1' => $size == 'sm',
        'px-4 py-2' => $size == 'md',
    ])->merge(['class' => ''])
    }}

>
    <div class="flex items-center justify-center gap-1">
        
        @if ($icon)
            {{$icon}}
        @endif

        <p {{$attributes->class([''])->merge(['class'=> ''])}}>{{$label}}</p>
    </div>
</a>