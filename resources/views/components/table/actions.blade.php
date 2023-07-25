<form {{$attributes->class(["flex flex-row gap-5 p-4 bg-project-gray-light rounded-lg"])->merge(['class' => ''])}}>
    {{$slot}}
</form>