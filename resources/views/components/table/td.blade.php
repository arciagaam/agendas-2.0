@props(['isHeader' => false, 'trPosition' => ''])
<td
@class([
    'p-2',

    'font-regular text-sm border-b first:border-l last:border-r' => !$isHeader,  

    'font-regular text-sm border-b first:rounded-bl-md first:border-l last:rounded-br-md last:border-r' => !$isHeader && $trPosition == 'last',  

    'font-medium text-regular border-t border-b 
    first:rounded-tl-md first:border-t first:border-l first:border-b
    last:rounded-tr-md last:border-t last:border-r last:border-b' => $isHeader,    
])
>
    {{$slot}}
</td>
