@props(['isHeader' => false])

<tr
@class([
    'bg-white' => !$isHeader, 
    'bg-project-gray-light text-project-gray-dark font-medium' => $isHeader
])
>
{{$slot}}
</tr>