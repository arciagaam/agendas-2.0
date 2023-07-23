@props(['id' => '', 'name' => '', 'isChecked' => false])

<div class="relative min-w-[40px] mr-2 align-middle select-none">
    <input type="checkbox" id={{$id}} name={{$name}}
    {{ $attributes->class([
        "absolute top-0.5 block w-5 h-5 rounded-full bg-white appearance-none cursor-pointer transition-all duration-400",
        "ml-0.5" => $isChecked == false,
        "ml-[18px]" => $isChecked == true
    ])->merge(['class' => '']) 
    }}
    @checked($isChecked)>

    <label for={{$name}} 
    @class([
        "toggle-label block overflow-hidden h-6 rounded-full cursor-pointer transition-all duration-400",
        "bg-gray-300" => $isChecked == false,
        "bg-green-500" => $isChecked == true
    ])></label>
</div>