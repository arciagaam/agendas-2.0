@props(['id' => '', 'types' => []])
<select class="absolute top-0 left-0 outline-none rounded-md appearance-none text-center h-full w-full bg-transparent cursor-pointer" name="celltypes[]" id={{$id}}>
    <option value="">Class</option>
    @foreach ($types as $type)
        <option value="{{$type->id}}">{{$type->subject_name}}</option>
    @endforeach
</select>

<div class="flex flex-col">
    <label for=""></label>
</div>