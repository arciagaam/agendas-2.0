<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-path" content="{{ url('/') }}">
    <title>Agendas</title>
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
</head>
<body>
    <div class="relative flex h-screen font-inter text-project-primary">

        <x-navigation.navbar/>
        
        <div class="relative ml-[3.5rem] flex flex-col w-full">
            <x-header-bar/>
            
            <div class="flex flex-col px-10 py-5 gap-5">
                {{$slot}}
            </div>
        </div>
    </div>
</body>
</html>